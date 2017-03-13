<?php

App::uses('AppController', 'Controller');
/**
 * Dispatches Controller.
 *
 * @property Dispatch $Dispatch
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class DispatchesController extends AppController
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
        $this->pageTitle = 'Manage Dispatches';
        $this->set('pageTitle', $this->pageTitle);

        $fields = [];

        $criteria = [];
        $containCriteria = [];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['Dispatch'] as $key => $value) {
                if (!empty($value)) {
                    $criteria[$key] = $value;
                    $this->request->params['named'][$key] = $value;
                }
            }
        }

        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] as $key => $value) {
                if (!in_array($key, ['page', 'sort', 'direction'])) {
                    if (!empty($value)) {
                        $criteria[$key] = $value;
                        $this->request->data['Dispatch'][$key] = $value;
                    }
                }
            }
        }

        if (empty($criteria)) {
            $criteria = '1=1';
        }

        $this->Paginator->settings = array(
            'page' => 1,
            'limit' => LIMIT,
            'fields' => $fields,
            'order' => array('Dispatch.id' => 'desc'),
            'contain' => array('ClientCase'),
        );

        if (!empty($containCriteria)) {
            $this->Paginator->settings['contain'] = array('ClientCase' => array('conditions' => array($containCriteria)));
        }
        $this->set('paginateLimit', LIMIT);
        $records = $this->Paginator->paginate('Dispatch', $criteria);
        /*foreach ($records as $key => $value) {
            if (!empty($value['Dispatch']['attachment'])) {
                $records[$key]['Dispatch']['attachment'] = $this->Aws->getObjectUrl($value['Dispatch']['attachment']);
            } else {
                $records[$key]['Dispatch']['attachment'] = '';
            }
        }*/
        $this->set('Dispatches', $records);
    }

    /**
     * It will add a new dispatch for the given case of the user or as misc.
     *
     * @param $computer_file_no It will be given if one comes directly from a case to add dispatch
     */
    public function add($computer_file_no = '')
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add New Dispatch';
        $this->set('pageTitle', $this->pageTitle);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['Dispatch']['computer_file_no'])) {
                // Get case ID for the given Computer File No
                $caseData = $this->Dispatch->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['Dispatch']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                if (!empty($caseData)) {
                    $this->request->data['Dispatch']['client_case_id'] = $caseData['ClientCase']['id'];
                } else {
                    $this->Dispatch->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                }
            }

            if (empty($this->Dispatch->validationErrors)) {
                $this->request->data['Dispatch']['user_id'] = $this->Session->read('UserInfo.uid');

                if (empty($this->request->data['Dispatch']['attachment']['name'])) {
                    unset($this->request->data['Dispatch']['attachment']);
                }

                $this->Dispatch->create();
                $this->Dispatch->set($this->request->data['Dispatch']);
                if ($this->Dispatch->validates()) {
                    // If attachment has been given upload it to aws S3
                    if (!empty($this->request->data['Dispatch']['attachment']['name'])) {
                        $sourceFile = $this->request->data['Dispatch']['attachment']['tmp_name'];
                        $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['Dispatch']['attachment']['name'];
                        // Upload file to S3
                        $this->Aws->upload($sourceFile, $fileKey);
                        $this->request->data['Dispatch']['attachment'] = $fileKey;
                    }
                    if ($this->Dispatch->save($this->request->data)) {
                        $this->Flash->success(__('The dispatch misc has been saved.'));

                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Flash->error(__('The dispatch could not be saved. Please, try again.'));
                    }
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
        $this->pageTitle = 'Edit Dispatch';
        $this->set('pageTitle', $this->pageTitle);
        $computer_file_no = '';

        $dispatchData = $this->Dispatch->find('first', array('contain' => array('ClientCase'), 'conditions' => array('Dispatch.user_id' => $this->Session->read('UserInfo.uid'), 'Dispatch.id' => $id)));

        if (!empty($dispatchData)) {
            if (!empty($dispatchData['ClientCase']['computer_file_no'])) {
                $computer_file_no = $dispatchData['ClientCase']['computer_file_no'];
            }
            // Get S3 url for the attachment if it was uploaded
            if (!empty($dispatchData['Dispatch']['attachment'])) {
                $this->set('attachment', $this->Aws->getObjectUrl($dispatchData['Dispatch']['attachment']));
            } else {
                $this->set('attachment', '');
            }

            if ($this->request->is(array('post', 'put'))) {
                if (empty($this->request->data['Dispatch']['computer_file_no'])) {
                    $this->request->data['Dispatch']['client_case_id'] = null;
                }

                // If computer file_no has been updated then find the associated case_id and update in CM/CRM
                if ($dispatchData['ClientCase']['computer_file_no'] != $this->request->data['Dispatch']['computer_file_no'] && !empty($this->request->data['Dispatch']['computer_file_no'])) {
                    $caseData = $this->Dispatch->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['Dispatch']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                    if (!empty($caseData)) {
                        $this->request->data['Dispatch']['client_case_id'] = $caseData['ClientCase']['id'];
                    } else {
                        $this->Dispatch->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                    }
                }

                if (empty($this->request->data['Dispatch']['attachment']['name'])) {
                    unset($this->request->data['Dispatch']['attachment']);
                }

                if (empty($this->Dispatch->validationErrors)) {
                    $this->Dispatch->set($this->request->data['Dispatch']);
                    if ($this->Dispatch->validates()) {
                        // If attachment has been given upload it to aws S3
                        if (!empty($this->request->data['Dispatch']['attachment']['name'])) {
                            $sourceFile = $this->request->data['Dispatch']['attachment']['tmp_name'];
                            $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['Dispatch']['attachment']['name'];
                            // Upload file to S3
                            $this->Aws->upload($sourceFile, $fileKey);
                            // Delete previous attached file
                            $this->Aws->delete($dispatchData['Dispatch']['attachment']);
                            $this->request->data['Dispatch']['attachment'] = $fileKey;
                        }

                        $this->Dispatch->id = $id;
                        if ($this->Dispatch->save($this->request->data)) {
                            $this->Flash->success(__('The dispatch has been saved.'));

                            return $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('The dispatch could not be saved. Please, try again.'));
                        }
                    } else {
                        pr($this->Dispatch->validationErrors);die;
                    }
                }
            } else {
                $this->request->data = $dispatchData;
            }
            $this->set(compact('id', 'computer_file_no'));
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
        $dispatchData = $this->Dispatch->find('first', array('conditions' => array('Dispatch.user_id' => $this->Session->read('UserInfo.uid'), 'Dispatch.id' => $id)));
        if (!empty($dispatchData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->Dispatch->id = $id;
                if ($this->Dispatch->delete()) {
                    if (!empty($dispatchData['Dispatch']['attachment'])) {
                        $this->Aws->delete($dispatchData['Dispatch']['attachment']);
                    }
                    $this->Flash->success(__('The dispatch has been deleted successfully.'));
                } else {
                    $this->Flash->error(__('The dispatch could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The selected http method is not allowed.'));
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
        }

        return $this->redirect(array('action' => 'index'));
    }

    /**
     * view the details of the given application ID.
     *
     * @param string $id
     */
    public function view($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Dispatch Details';
        $this->set('pageTitle', $this->pageTitle);
        $dispatchData = $this->Dispatch->find('first', array('contain' => array('ClientCase'), 'conditions' => array('Dispatch.user_id' => $this->Session->read('UserInfo.uid'), 'Dispatch.id' => $id)));
        if (!empty($dispatchData)) {
            // Get S3 url for the attachment if it was uploaded
            if (!empty($dispatchData['Dispatch']['attachment'])) {
                $dispatchData['Dispatch']['attachment'] = $this->Aws->getObjectUrl($dispatchData['Dispatch']['attachment']);
            }
            $this->set('Dispatch', $dispatchData);
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));

            return $this->redirect(array('action' => 'index'));
        }
    }
}
