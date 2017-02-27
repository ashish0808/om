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

        $date = date('Y-m-d');
        $criteria = ['date_of_hearing' => $date];
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['CaseProceeding']['id'])) {
                $date = $this->request->data['CaseProceeding']['search_date'];
                $cpData = $this->CaseProceeding->find('first', array('conditions' => array('id' => $this->request->data['CaseProceeding']['id'])));
                foreach ($this->request->data['ClientCase'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == 'status') {
                            $this->request->data['CaseProceeding']['case_status'] = $value;
                        } else {
                            $this->request->data['CaseProceeding'][$key] = $value;
                        }
                    }
                }
                if (!empty($this->request->data['CaseProceeding']['next_date_of_hearing'])) {
                    $this->request->data['CaseProceeding']['proceeding_status'] = 'completed';
                }
                $this->CaseProceeding->saveAssociated($this->request->data);
                if (!empty($this->request->data['CaseProceeding']['next_date_of_hearing'])) {
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

        $CaseProceedings = $this->CaseProceeding->find('all', array('contain' => array('ClientCase' => array('Court', 'conditions' => array('user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => $criteria));

        // Find todos for the given date
        $this->loadModel('Todo');
        $Todos = $this->Todo->find('all', array('contain' => array('ClientCase'),'conditions' => array('Todo.user_id' => $this->Session->read('UserInfo.uid'), 'completion_date' => $date)));

        $this->set(compact('CaseProceedings', 'date', 'Todos'));
    }

    /**
     * It will add a new application for the givn case of the user.
     *
     * @param $computer_file_no It will be given if one comes directly from a case to add CM/CRM
     */
    public function add($computer_file_no = '')
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add CM/CRM';
        $this->set('pageTitle', $this->pageTitle);
        if ($this->request->is('post')) {
            if (empty($this->request->data['CaseProceeding']['computer_file_no'])) {
                $this->CaseProceeding->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
            } else {
                // Get case ID for the given Computer File No
                $caseData = $this->CaseProceeding->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['CaseProceeding']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                if (!empty($caseData)) {
                    $this->request->data['CaseProceeding']['user_id'] = $this->Session->read('UserInfo.uid');
                    $this->request->data['CaseProceeding']['client_case_id'] = $caseData['ClientCase']['id'];

                    if (empty($this->request->data['CaseProceeding']['attachment']['name'])) {
                        unset($this->request->data['CaseProceeding']['attachment']);
                    }

                    $this->CaseProceeding->create();
                    $this->CaseProceeding->set($this->request->data['CaseProceeding']);
                    if ($this->CaseProceeding->validates()) {
                        // If attachment has been given upload it to aws S3
                        if (!empty($this->request->data['CaseProceeding']['attachment']['name'])) {
                            $sourceFile = $this->request->data['CaseProceeding']['attachment']['tmp_name'];
                            $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['CaseProceeding']['attachment']['name'];
                            // Upload file to S3
                            $this->Aws->upload($sourceFile, $fileKey);
                            $this->request->data['CaseProceeding']['attachment'] = $fileKey;
                        }

                        if ($this->CaseProceeding->save($this->request->data)) {
                            $this->Flash->success(__('CM/CRM has been saved successfully.'));
                            return $this->redirect(array('action' => 'index/'.$this->request->data['CaseProceeding']['status']));
                        } else {
                            $this->Flash->error(__('The CM/CRM could not be saved. Please, try again.'));
                        }
                    } else {
                        pr($this->CaseProceeding->validationErrors);
                    }
                } else {
                    $this->CaseProceeding->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                }
            }
        }
        $this->set(compact('computer_file_no'));
    }

    /**
     * edit method.
     *
     * @param string $id
     */
    public function edit($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Edit CM/CRM';
        $this->set('pageTitle', $this->pageTitle);

        $computer_file_no = '';

        $cmData = $this->CaseProceeding->find('first', array('contain' => array('ClientCase'), 'conditions' => array('CaseProceeding.user_id' => $this->Session->read('UserInfo.uid'), 'CaseProceeding.id' => $id)));

        if (!empty($cmData)) {
            if (!empty($cmData['ClientCase']['computer_file_no'])) {
                $computer_file_no = $cmData['ClientCase']['computer_file_no'];
            }
            // Get S3 url for the attachment if it was uploaded
            if (!empty($cmData['CaseProceeding']['attachment'])) {
                $this->set('attachment', $this->Aws->getObjectUrl($cmData['CaseProceeding']['attachment']));
            } else {
                $this->set('attachment', '');
            }

            if ($this->request->is(array('post', 'put'))) {
                // If computer file_no has been updated then find the associated case_id and update in CM/CRM
                if ($cmData['ClientCase']['computer_file_no'] != $this->request->data['CaseProceeding']['computer_file_no']) {
                    $caseData = $this->CaseProceeding->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['CaseProceeding']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                    if (!empty($caseData)) {
                        $this->request->data['CaseProceeding']['client_case_id'] = $caseData['ClientCase']['id'];
                    } else {
                        $this->CaseProceeding->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                    }
                }

                if (empty($this->request->data['CaseProceeding']['attachment']['name'])) {
                    unset($this->request->data['CaseProceeding']['attachment']);
                }

                if (empty($this->CaseProceeding->validationErrors)) {
                    $this->CaseProceeding->id = $id;
                    $this->CaseProceeding->set($this->request->data['CaseProceeding']);
                    if ($this->CaseProceeding->validates()) {
                        // If attachment has been given upload it to aws S3
                        if (!empty($this->request->data['CaseProceeding']['attachment']['name'])) {
                            $sourceFile = $this->request->data['CaseProceeding']['attachment']['tmp_name'];
                            $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['CaseProceeding']['attachment']['name'];
                            // Upload file to S3
                            $this->Aws->upload($sourceFile, $fileKey);
                            // Delete previous attached file
                            $this->Aws->delete($cmData['CaseProceeding']['attachment']);
                            $this->request->data['CaseProceeding']['attachment'] = $fileKey;
                        } else {
                            unset($this->request->data['CaseProceeding']['attachment']);
                        }

                        if ($this->CaseProceeding->save($this->request->data)) {
                            $this->Flash->success(__('CM/CRM has been saved successfully.'));
                            return $this->redirect(array('action' => 'index/'.$this->request->data['CaseProceeding']['status']));
                        } else {
                            $this->Flash->error(__('The CM/CRM could not be saved. Please, try again.'));
                        }
                    }
                }
                $this->request->data = $cmData;
            } else {
                $this->request->data = $cmData;
            }
            $this->set(compact('id', 'computer_file_no'));
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
            return $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * view the details of the given application ID
     *
     * @param string $id
     */
    public function view($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'CM/CRM Details';
        $this->set('pageTitle', $this->pageTitle);
        $cmData = $this->CaseProceeding->find('first', array('contain' => array('ClientCase'),'conditions' => array('CaseProceeding.user_id' => $this->Session->read('UserInfo.uid'), 'CaseProceeding.id' => $id)));
        if (!empty($cmData)) {
            // Get S3 url for the attachment if it was uploaded
            if (!empty($cmData['CaseProceeding']['attachment'])) {
                $cmData['CaseProceeding']['attachment'] = $this->Aws->getObjectUrl($cmData['CaseProceeding']['attachment']);
            }
            $this->set('CaseProceeding',$cmData);
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
            return $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * delete the given ID from DB and its associated attachment from AWS.
     *
     * @param string $id
     */
    public function delete($id = null)
    {
        $cmData = $this->CaseProceeding->find('first', array('conditions' => array('CaseProceeding.user_id' => $this->Session->read('UserInfo.uid'), 'CaseProceeding.id' => $id)));
        if (!empty($cmData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->CaseProceeding->id = $id;
                if ($this->CaseProceeding->delete()) {
                    if (!empty($cmData['CaseProceeding']['attachment'])) {
                        $this->Aws->delete($cmData['CaseProceeding']['attachment']);
                    }
                    $this->Flash->success(__('The CM/CRM has been deleted successfully.'));
                } else {
                    $this->Flash->error(__('The CM/CRM could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__("The selected http method is not allowed."));
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
        }

        return $this->redirect(array('action' => 'index/'.$cmData['CaseProceeding']['status']));
    }
}
