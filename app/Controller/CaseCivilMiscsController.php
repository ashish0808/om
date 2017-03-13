<?php

App::uses('AppController', 'Controller');
/**
 * CaseCivilMiscs Controller.
 *
 * @property CaseCivilMisc $CaseCivilMisc
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CaseCivilMiscsController extends AppController
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
    public function index($status = 'pending')
    {
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'basic';
        }
        $this->pageTitle = 'Manage '.ucfirst($status).' CM/CRM';
        $this->set('pageTitle', $this->pageTitle);

        $fields = [];

        $criteria = ['status' => $status];
        $containCriteria = [];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['CaseCivilMisc'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'cm_no') {
                        $criteria[$key.' LIKE'] = '%'.$value.'%';
                    } else {
                        $criteria[$key] = $value;
                    }
                    $this->request->params['named'][$key] = $value;
                }
            }
        }

        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] as $key => $value) {
                if (!in_array($key, ['page', 'sort', 'direction'])) {
                    if (!empty($value)) {
                        if ($key == 'cm_no') {
                            $criteria[$key.' LIKE'] = '%'.$value.'%';
                        } else {
                            $criteria[$key] = $value;
                        }
                        $this->request->data['CaseCivilMisc'][$key] = $value;
                    }
                }
            }
        }

        $this->Paginator->settings = array(
            'page' => 1,
            'limit' => LIMIT,
            'fields' => $fields,
            'order' => array('CaseCivilMisc.id' => 'desc'),
            'contain' => array('ClientCase'),
        );

        if (!empty($containCriteria)) {
            $this->Paginator->settings['contain'] = array('ClientCase' => array('conditions' => array($containCriteria)));
        }
        $this->set('paginateLimit', LIMIT);
        $records = $this->Paginator->paginate('CaseCivilMisc', $criteria);
        /*foreach ($records as $key => $value) {
            if (!empty($value['CaseCivilMisc']['attachment'])) {
                $records[$key]['CaseCivilMisc']['attachment'] = $this->Aws->getObjectUrl($value['CaseCivilMisc']['attachment']);
            } else {
                $records[$key]['CaseCivilMisc']['attachment'] = '';
            }
        }*/
        $this->set('caseCivilMiscs', $records);
        $this->set('status', $status);
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
            if (empty($this->request->data['CaseCivilMisc']['computer_file_no'])) {
                $this->CaseCivilMisc->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
            } else {
                // Get case ID for the given Computer File No
                $caseData = $this->CaseCivilMisc->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['CaseCivilMisc']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                if (!empty($caseData)) {
                    $this->request->data['CaseCivilMisc']['user_id'] = $this->Session->read('UserInfo.uid');
                    $this->request->data['CaseCivilMisc']['client_case_id'] = $caseData['ClientCase']['id'];

                    if (empty($this->request->data['CaseCivilMisc']['attachment']['name'])) {
                        unset($this->request->data['CaseCivilMisc']['attachment']);
                    }

                    $this->CaseCivilMisc->create();
                    $this->CaseCivilMisc->set($this->request->data['CaseCivilMisc']);
                    if ($this->CaseCivilMisc->validates()) {
                        // If attachment has been given upload it to aws S3
                        if (!empty($this->request->data['CaseCivilMisc']['attachment']['name'])) {
                            $sourceFile = $this->request->data['CaseCivilMisc']['attachment']['tmp_name'];
                            $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['CaseCivilMisc']['attachment']['name'];
                            // Upload file to S3
                            $this->Aws->upload($sourceFile, $fileKey);
                            $this->request->data['CaseCivilMisc']['attachment'] = $fileKey;
                        }

                        if ($this->CaseCivilMisc->save($this->request->data)) {
                            $this->Flash->success(__('CM/CRM has been saved successfully.'));
                            return $this->redirect(array('action' => 'index/'.$this->request->data['CaseCivilMisc']['status']));
                        } else {
                            $this->Flash->error(__('The CM/CRM could not be saved. Please, try again.'));
                        }
                    } else {
                        pr($this->CaseCivilMisc->validationErrors);
                    }
                } else {
                    $this->CaseCivilMisc->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
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

        $cmData = $this->CaseCivilMisc->find('first', array('contain' => array('ClientCase'), 'conditions' => array('CaseCivilMisc.user_id' => $this->Session->read('UserInfo.uid'), 'CaseCivilMisc.id' => $id)));

        if (!empty($cmData)) {
            if (!empty($cmData['ClientCase']['computer_file_no'])) {
                $computer_file_no = $cmData['ClientCase']['computer_file_no'];
            }
            // Get S3 url for the attachment if it was uploaded
            if (!empty($cmData['CaseCivilMisc']['attachment'])) {
                $this->set('attachment', $this->Aws->getObjectUrl($cmData['CaseCivilMisc']['attachment']));
            } else {
                $this->set('attachment', '');
            }

            if ($this->request->is(array('post', 'put'))) {
                // If computer file_no has been updated then find the associated case_id and update in CM/CRM
                if ($cmData['ClientCase']['computer_file_no'] != $this->request->data['CaseCivilMisc']['computer_file_no']) {
                    $caseData = $this->CaseCivilMisc->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['CaseCivilMisc']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                    if (!empty($caseData)) {
                        $this->request->data['CaseCivilMisc']['client_case_id'] = $caseData['ClientCase']['id'];
                    } else {
                        $this->CaseCivilMisc->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                    }
                }

                if (empty($this->request->data['CaseCivilMisc']['attachment']['name'])) {
                    unset($this->request->data['CaseCivilMisc']['attachment']);
                }

                if (empty($this->CaseCivilMisc->validationErrors)) {
                    $this->CaseCivilMisc->id = $id;
                    $this->CaseCivilMisc->set($this->request->data['CaseCivilMisc']);
                    if ($this->CaseCivilMisc->validates()) {
                        // If attachment has been given upload it to aws S3
                        if (!empty($this->request->data['CaseCivilMisc']['attachment']['name'])) {
                            $sourceFile = $this->request->data['CaseCivilMisc']['attachment']['tmp_name'];
                            $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['CaseCivilMisc']['attachment']['name'];
                            // Upload file to S3
                            $this->Aws->upload($sourceFile, $fileKey);
                            // Delete previous attached file
                            $this->Aws->delete($cmData['CaseCivilMisc']['attachment']);
                            $this->request->data['CaseCivilMisc']['attachment'] = $fileKey;
                        } else {
                            unset($this->request->data['CaseCivilMisc']['attachment']);
                        }

                        if ($this->CaseCivilMisc->save($this->request->data)) {
                            $this->Flash->success(__('CM/CRM has been saved successfully.'));
                            return $this->redirect(array('action' => 'index/'.$this->request->data['CaseCivilMisc']['status']));
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
        $cmData = $this->CaseCivilMisc->find('first', array('contain' => array('ClientCase'),'conditions' => array('CaseCivilMisc.user_id' => $this->Session->read('UserInfo.uid'), 'CaseCivilMisc.id' => $id)));
        if (!empty($cmData)) {
            // Get S3 url for the attachment if it was uploaded
            if (!empty($cmData['CaseCivilMisc']['attachment'])) {
                $cmData['CaseCivilMisc']['attachment'] = $this->Aws->getObjectUrl($cmData['CaseCivilMisc']['attachment']);
            }
            $this->set('CaseCivilMisc',$cmData);
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
        $cmData = $this->CaseCivilMisc->find('first', array('conditions' => array('CaseCivilMisc.user_id' => $this->Session->read('UserInfo.uid'), 'CaseCivilMisc.id' => $id)));
        if (!empty($cmData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->CaseCivilMisc->id = $id;
                if ($this->CaseCivilMisc->delete()) {
                    if (!empty($cmData['CaseCivilMisc']['attachment'])) {
                        $this->Aws->delete($cmData['CaseCivilMisc']['attachment']);
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

        return $this->redirect(array('action' => 'index/'.$cmData['CaseCivilMisc']['status']));
    }
}
