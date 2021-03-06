<?php

App::uses('AppController', 'Controller');
/**
 * CaseFiles Controller.
 *
 * @property CaseFile $CaseFile
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CaseFilesController extends AppController
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
    public function manage($caseId)
    {
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'basic';
        }
        $this->pageTitle = 'Manage Case Files';
        $this->set('pageTitle', $this->pageTitle);

	    $this->loadModel('ClientCase');
	    $caseDetails = $this->ClientCase->read(null, $caseId);
	    $this->checkCaseDetails($caseDetails);

        $fields = [];

        $criteria = array(
	        'client_case_id' => $caseId
        );
        $containCriteria = [];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['CaseFile'] as $key => $value) {
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
                        $this->request->data['CaseFile'][$key] = $value;
                    }
                }
            }
        }

        $this->Paginator->settings = array(
            'page' => 1,
            'limit' => LIMIT,
            'fields' => $fields,
            'order' => array('CaseFile.id' => 'desc'),
            'contain' => array('ClientCase'),
        );

        if (!empty($containCriteria)) {
            $this->Paginator->settings['contain'] = array('ClientCase' => array('conditions' => array($containCriteria)));
        }
        $this->set('paginateLimit', LIMIT);
        $records = $this->Paginator->paginate('CaseFile', $criteria);
        foreach ($records as $key => $value) {
            if (!empty($value['CaseFile']['path'])) {
                $records[$key]['CaseFile']['path'] = $this->Aws->getObjectUrl($value['CaseFile']['path']);
            } else {
                $records[$key]['CaseFile']['path'] = '';
            }
        }
        $this->set('CaseFiles', $records);
	    $this->set('caseDetails', $caseDetails);
	    $this->set('caseId', $caseId);

	    $mainCaseFile = '';
	    if (!empty($caseDetails['ClientCase']['main_file'])) {
		    $mainCaseFile = $this->Aws->getObjectUrl($caseDetails['ClientCase']['main_file']);
	    }
	    $this->set("mainCaseFile", $mainCaseFile);
    }

	private function checkCaseDetails($caseDetails)
	{
		if(empty($caseDetails['ClientCase']['case_number']) ||
			(isset($caseDetails['ClientCase']['user_id']) && $caseDetails['ClientCase']['user_id']!=$this->Session->read('UserInfo.lawyer_id')) || (!empty($caseDetails['ClientCase']['is_deleted']))) {

			$this->Flash->error(__("The selected case doesn't exist or deleted. Please, try with valid record."));

			return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
		}
	}

    /**
     * It will add a new CaseFile for the given case of the user or as misc.
     *
     * @param $computer_file_no It will be given if one comes directly from a case to add CaseFile
     */
    public function add($caseId)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Case File';
        $this->set('pageTitle', $this->pageTitle);

	    $this->loadModel('ClientCase');
	    $caseDetails = $this->ClientCase->read(null, $caseId);
	    $this->checkCaseDetails($caseDetails);

        if ($this->request->is('post')) {

            if (!empty($this->request->data['CaseFile']['files'])) {

	            $caseFiles = $this->request->data['CaseFile']['files'];

	            $fileSaved = false;
	            $errorFiles = array();
	            foreach($caseFiles as $caseFileArr) {

		            $this->CaseFile->create();

		            $saveData = array(
			            'client_case_id' => $caseId
		            );

		            // If attachment has been given upload it to aws S3
		            if (!empty($caseFileArr['name'])) {
			            $sourceFile = $caseFileArr['tmp_name'];
			            $fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$caseFileArr['name'];
			            // Upload file to S3
			            $this->Aws->upload($sourceFile, $fileKey);
			            $saveData['path'] = $fileKey;
			            $saveData['name'] = $caseFileArr['name'];

			            $fileSaved = true;

			            if (!$this->CaseFile->save($saveData)) {

				            $errorFiles[] = $caseFileArr['name'];
			            }
		            } else {

			            $errorFiles[] = $caseFileArr['name'];
		            }
	            }

	            if(empty($errorFiles)) {

		            $this->Flash->success(__('Case files updated successfully.'));
	            } elseif($fileSaved==true) {

		            $this->Flash->success(__('Few case files are updated. Please try remaining files again'));
	            }else {

		            $this->Flash->error(__('Nothing to upload.'));
	            }
            } else {

	            $this->Flash->error(__('Nothing to upload.'));
            }
        }

	    $this->set('caseDetails', $caseDetails);
	    $this->set('caseId', $caseId);
    }

    /**
     * delete the given ID from DB and its associated attachment from AWS.
     *
     * @param string $id
     */
    public function delete($id, $caseId)
    {
        $fileData = $this->CaseFile->find('first', array('conditions' => array('CaseFile.client_case_id' => $caseId, 'CaseFile.id' => $id)));
        if (!empty($fileData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->CaseFile->id = $id;
                if ($this->CaseFile->delete()) {
                    if (!empty($fileData['CaseFile']['path'])) {
                        $this->Aws->delete($fileData['CaseFile']['path']);
                    }
                    $this->Flash->success(__('The case file has been deleted successfully.'));
                } else {
                    $this->Flash->error(__('The case file could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The selected http method is not allowed.'));
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
        }

        return $this->redirect(array('controller' => 'CaseFiles', 'action' => 'manage', $caseId));
    }

	public function addMainCaseFile($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Add Main Case File';
		$this->set('pageTitle', $this->pageTitle);

		$this->loadModel('ClientCase');
		$caseDetails = $this->ClientCase->read(null, $caseId);

		$this->checkCaseDetails($caseDetails);

		if ($this->request->data) {

			if (isset($_FILES['file']) && $_FILES['file']['error'] > 0) {

				$this->Flash->error(__('Unable to upload.'));
			} else {

				if(!empty($_FILES['file']['tmp_name'])) {

					$sourceFile = $_FILES['file']['tmp_name'];
					$fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$_FILES['file']['name'];
					// Upload file to S3
					$this->Aws->upload($sourceFile, $fileKey);
					if(!empty($caseDetails['ClientCase']['main_file'])) {

						// Delete previous attached file
						$this->Aws->delete($caseDetails['ClientCase']['main_file']);
					}

					$updateCaseDetails = array();
					$updateCaseDetails['main_file'] = "'$fileKey'";
					$this->ClientCase->updateAll($updateCaseDetails, array('ClientCase.id'=> $caseId));

					$this->Flash->success(__('Case file updated successfully.'));

					return $this->redirect(array('controller' => 'CaseFiles', 'action' => 'manage', $caseId));
				}else {

					$this->Flash->error(__('Nothing to upload.'));
				}
			}
		}

		$this->set('caseDetails', $caseDetails);
		$this->set('caseId', $caseId);
	}
}
