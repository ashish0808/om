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
    public function index()
    {
    	if ($this->request->isAjax()) {
		    $this->layout = 'ajax';
	    } else {
		    $this->layout = 'basic';
	    }
        $this->pageTitle = 'Manage CM/CRM';
        $this->set('pageTitle', $this->pageTitle);

        $fields = [];

        $criteria = [];
        if (!empty($this->request->data)) {
        	foreach ($this->request->data['CaseCivilMisc'] as $key => $value) {
        		if (!empty($value)) {
        			$criteria[$key] = $value;
        			$this->request->params['named'][$key] = $value;
        		}
        	}
        }

        if (!empty($this->request->params['named'])) {
		    foreach ($this->request->params['named'] as $key => $value) {
		    	if ($key != 'page') {
				    if (!empty($value)) {
		        			$criteria[$key] = $value;
		        			$this->request->data['CaseCivilMisc'][$key] = $value;
				    }
				}
		    }
	    }

        if (empty($criteria)) {
        	$criteria = "1=1";
        }

        // pr($criteria);die;

        $this->Paginator->settings = array(
		    'page' => 1,
		    'limit' => LIMIT,
		    'fields' => $fields,
		    'order' => array('CaseCivilMisc.id' => 'desc'),
		    //'contain' => array('Customer' => array('Country', 'State', 'City'))
	    );
	    $this->set('paginateLimit', LIMIT);
        // $this->CaseCivilMisc->recursive = 0;
        $this->set('caseCivilMiscs', $this->Paginator->paginate('CaseCivilMisc', $criteria));
    }

    /**
     * view method.
     *
     * @throws NotFoundException
     *
     * @param string $id
     */
    public function view($id = null)
    {
        if (!$this->CaseCivilMisc->exists($id)) {
            throw new NotFoundException(__('Invalid case civil misc'));
        }
        $options = array('conditions' => array('CaseCivilMisc.'.$this->CaseCivilMisc->primaryKey => $id));
        $this->set('caseCivilMisc', $this->CaseCivilMisc->find('first', $options));
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

                    // If attachment has been given upload it to aws S3
                    if (!empty($this->request->data['CaseCivilMisc']['attachment']['name'])) {
                        $sourceFile = $this->request->data['CaseCivilMisc']['attachment']['tmp_name'];
                        $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$this->request->data['CaseCivilMisc']['attachment']['name'];
                        // Upload file to S3
                        $this->Aws->upload($sourceFile, $fileKey);
                        $this->request->data['CaseCivilMisc']['attachment'] = $fileKey;
                    } else {
                        unset($this->request->data['CaseCivilMisc']['attachment']);
                    }

                    $this->CaseCivilMisc->create();
                    $this->CaseCivilMisc->set($this->request->data['CaseCivilMisc']);
                    if ($this->CaseCivilMisc->validates()) {
                        if ($this->CaseCivilMisc->save($this->request->data)) {
                            $this->Flash->success(__('The case civil misc has been saved.'));
                            // return $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('The case civil misc could not be saved. Please, try again.'));
                        }
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

        $cmData = $this->CaseCivilMisc->find('first', array('contain' => array('ClientCase'),'conditions' => array('CaseCivilMisc.user_id' => $this->Session->read('UserInfo.uid'), 'CaseCivilMisc.id' => $id)));

        if (!empty($cmData)) {
        	// Get S3 url for the attachment if it was uploaded
        	if (!empty($cmData['CaseCivilMisc']['attachment'])) {
        		$this->set('attachment', $this->Aws->getObjectUrl($cmData['CaseCivilMisc']['attachment']));
        	} else {
        		$this->set('attachment', '');
        	}

            if ($this->request->is(array('post', 'put'))) {
            	// If computer file_no has been updated then find the associated case_id and update in CM/CRM
                if ($cmData['ClientCase']['computer_file_no'] != $this->request->data['ClientCase']['computer_file_no']) {
                    $caseData = $this->CaseCivilMisc->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['ClientCase']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                    if (!empty($caseData)) {
                        $this->request->data['CaseCivilMisc']['client_case_id'] = $caseData['ClientCase']['id'];
                    } else {
                        $this->CaseCivilMisc->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                    }
                }

                if (empty($this->CaseCivilMisc->validationErrors)) {
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

	                $this->CaseCivilMisc->id = $id;
	                if ($this->CaseCivilMisc->save($this->request->data)) {
	                    $this->Flash->success(__('The case civil misc has been saved.'));
	                    return $this->redirect(array('action' => 'index'));
	                } else {
	                    $this->Flash->error(__('The case civil misc could not be saved. Please, try again.'));
	                }
                }
            } else {
                $this->request->data = $cmData;
            }
            $this->set(compact('id'));
        } else {
        	$this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
        	return $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * delete method.
     *
     * @throws NotFoundException
     *
     * @param string $id
     */
    public function delete($id = null)
    {
        $this->CaseCivilMisc->id = $id;
        if (!$this->CaseCivilMisc->exists()) {
            throw new NotFoundException(__('Invalid case civil misc'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->CaseCivilMisc->delete()) {
            $this->Flash->success(__('The case civil misc has been deleted.'));
        } else {
            $this->Flash->error(__('The case civil misc could not be deleted. Please, try again.'));
        }

        return $this->redirect(array('action' => 'index'));
    }
}
