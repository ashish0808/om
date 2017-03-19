<?php

App::uses('AppController', 'Controller');
/**
 * CaseProceedings Controller.
 *
 * @property CaseProceeding $CaseProceeding
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CaseProceedingsController extends AppController
{
    /**
     * Components.
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash', 'Session');

    /**
     * index method.
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'basic';
        }
        $this->pageTitle = 'Daily Diary';
        $this->set('pageTitle', $this->pageTitle);

        $pageType = 'daily_diary';
        $date = date('Y-m-d');
        $criteria = ['date_of_hearing' => $date];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['CaseProceeding'] as $key => $value) {
                if (in_array($key, array('date_of_hearing'))) {
                    if (!empty($value)) {
                        $criteria[$key] = $value;
                        $this->request->params['named'][$key] = $value;
                        $date = $this->request->data['CaseProceeding']['date_of_hearing'];
                    }
                }
            }
        }

        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] as $key => $value) {
                if (in_array($key, array('date_of_hearing'))) {
                    if (!empty($value)) {
                        $criteria[$key] = $value;
                        $this->request->data['CaseProceeding'][$key] = $value;
                        $date = $this->request->params['named']['date_of_hearing'];
                    }
                }
            }
        }

        $this->CaseProceeding->bindModel(array('belongsTo' => array('ClientCase' => array('type' => 'INNER'))));
        $CaseProceedings = $this->CaseProceeding->find('all', array('contain' => array('ClientCase' => array('Court', 'conditions' => array('is_main_case' => true, 'user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => $criteria));

        // Find todos for the given date
        $this->loadModel('Todo');
        $Todos = $this->Todo->find('all', array('contain' => array('ClientCase'), 'conditions' => array('Todo.user_id' => $this->Session->read('UserInfo.uid'), 'completion_date' => $date)));

        $this->set(compact('CaseProceedings', 'date', 'Todos', 'pageType'));
    }

    public function editCaseProceeding($caseProceedingId, $date, $pageType)
    {
        $this->layout = 'ajax';
        $this->loadModel('ClientCase');

        if (!empty($this->request->data)) {
            if (!empty($this->request->data['CaseProceeding']['id'])) {
                // This is the search date to be shown on search field
                if (!empty($this->request->data['CaseProceeding']['search_date'])) {
                    $date = $this->request->data['CaseProceeding']['search_date'];
                }

                // Find the beind updated case proceeding data
                $cpData = $this->CaseProceeding->find('first', array('conditions' => array('id' => $this->request->data['CaseProceeding']['id'])));

                if (!empty($this->request->data['ClientCase'])) {
                    foreach ($this->request->data['ClientCase'] as $key => $value) {
                        if (!empty($value)) {
                            $this->request->data['CaseProceeding'][$key] = $value;
                        }
                    }
                }
                
                if (!empty($this->request->data['CaseProceeding']['next_date_of_hearing']) || !empty($cpData['CaseProceeding']['next_date_of_hearing'])) {
                    $this->request->data['CaseProceeding']['proceeding_status'] = 'completed';
                } else {
                    $this->request->data['CaseProceeding']['proceeding_status'] = 'pending';
                }

                $this->request->data['ClientCase']['id'] = $cpData['CaseProceeding']['client_case_id'];
                $this->CaseProceeding->id = $this->request->data['CaseProceeding']['id'];
                $this->CaseProceeding->saveAssociated($this->request->data);

                $this->loadModel('ClientCase');
                // Connected case data
                $ccData = $this->ClientCase->find('all', array('contain' => array('CaseProceeding' => array('conditions' => array('date_of_hearing' => $this->request->data['CaseProceeding']['date_of_hearing']))), 'conditions' => array('parent_case_id' => $this->request->data['CaseProceeding']['client_case_id'])));
                if (!empty($ccData)) {
                    // Update all the connected case proceeding as well
                    foreach ($ccData as $key => $proceedings) {
                        $updateCCData = $this->request->data;
                        $updateCCData['CaseProceeding']['client_case_id'] = $proceedings['ClientCase']['id'];
                        $updateCCData['ClientCase']['id'] = $proceedings['ClientCase']['id'];
                        foreach ($proceedings['CaseProceeding'] as $proceedingKey => $proceeding) {
                            $updateCCData['CaseProceeding']['id'] = $proceeding['id'];
                            $this->CaseProceeding->saveAssociated($updateCCData);
                        }
                    }
                }

                // If next hearing date has been entered add new row in proceeding for that date
                if (!empty($this->request->data['CaseProceeding']['next_date_of_hearing']) && empty($cpData['CaseProceeding']['next_date_of_hearing'])) {
                    foreach ($this->request->data['CaseProceeding'] as $key => $value) {
                        if (!in_array($key, array('date_of_hearing', 'referred_to_lok_adalat', 'case_status', 'brief_status', 'next_date_of_hearing'))) {
                            unset($this->request->data['CaseProceeding'][$key]);
                        }
                        if ($key == 'date_of_hearing') {
                            $this->request->data['CaseProceeding']['date_of_hearing'] = $this->request->data['CaseProceeding']['next_date_of_hearing'];
                            unset($this->request->data['CaseProceeding']['next_date_of_hearing']);
                        }
                    }
                    $this->request->data['CaseProceeding']['client_case_id'] = $cpData['CaseProceeding']['client_case_id'];
                    unset($this->request->data['CaseProceeding']['id']);
                    unset($this->request->data['ClientCase']);
                    $this->CaseProceeding->create();
                    $this->CaseProceeding->save($this->request->data);

                    // Add new proceeding for all the connected case as well
                    if (!empty($ccData)) {
                        foreach ($ccData as $key => $proceedings) {
                            $updateCCData = $this->request->data;
                            $updateCCData['CaseProceeding']['client_case_id'] = $proceedings['ClientCase']['id'];
                            unset($updateCCData['CaseProceeding']['id']);
                            unset($updateCCData['ClientCase']);
                            $this->CaseProceeding->create();
                            $this->CaseProceeding->save($updateCCData);
                        }
                    }
                }
            } else {
                foreach ($this->request->data['CaseProceeding'] as $key => $value) {
                    if (in_array($key, array('date_of_hearing'))) {
                        if (!empty($value)) {
                            $criteria[$key] = $value;
                            $this->request->params['named'][$key] = $value;
                            $date = $this->request->data['CaseProceeding']['date_of_hearing'];
                        }
                    }
                }
            }
            // echo "{date: $date, pageType: $pageType}";
            echo json_encode(array('date' => $date, 'pageType' => $pageType));
            exit;
        }

        $caseProceeding = $this->CaseProceeding->find('first', array('contain' => array('ClientCase' => array('Court', 'conditions' => array('user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => array('CaseProceeding.id' => $caseProceedingId)));
        $this->request->data = $caseProceeding;
        $this->set('caseProceeding', $caseProceeding);
        $this->set('caseProceedingId', $caseProceedingId);
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        $this->set('pageType', $pageType);
        $this->set('date', $date);
    }

    /**
     * Get all the proceedings of a case
     * @param  integer $caseId Case ID for which history has to be fetched
     * @return [html]  View of case history page
     */
    public function caseHistory($caseId)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Case History';
        $this->set('pageTitle', $this->pageTitle);

        $pageType = 'case_history';
        $date = date('Y-m-d');
        $caseDetails = $this->_getCaseDetails($caseId);

        $this->CaseProceeding->bindModel(array('belongsTo' => array('ClientCase' => array('type' => 'INNER'))));
        $CaseProceedings = $this->CaseProceeding->find('all', array('contain' => array('ClientCase' => array('Court', 'conditions' => array('ClientCase.id' => $caseId, 'user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => array('client_case_id' => $caseId)));

        $this->set(compact('caseDetails', 'caseId', 'CaseProceedings', 'date', 'pageType'));
    }

    private function _getCaseDetails($caseId)
    {
        $this->ClientCases = $this->Components->load('ClientCases');

        return $this->ClientCases->findByCaseId($caseId, $this->Session->read('UserInfo.lawyer_id'));
    }
}
