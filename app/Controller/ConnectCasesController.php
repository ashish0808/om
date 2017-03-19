<?php

App::uses('AppController', 'Controller');
/**
 * ConnectCases Controller.
 *
 * @property CaseFile $CaseFile
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class ConnectCasesController extends AppController
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
	    $this->layout = 'basic';
	    $this->pageTitle = 'Connected Child Cases';

	    $this->loadModel('ClientCase');
	    $caseDetails = $this->getCaseDetails($caseId);

	    if(!empty($caseDetails['ClientCase']['case_number'])) {

		    if ($this->request->data) {

			    $childIds = $this->request->data['box'];
			    if(!empty($childIds)) {

				    $this->detachCasesInBulk($childIds, $caseId);

				    $this->Flash->success(__('Selected cases detached successfully.'));
			    } else {

				    $this->Flash->error(__('Please select cases to detach'));
			    }

			    return $this->redirect(array('controller' => 'ConnectCases', 'action' => 'manage', $caseId));
		    }

		    $parentId = $caseDetails['ClientCase']['parent_case_id'];
		    if(!empty($parentId)) {

			    $this->pageTitle = 'Connected To Parent Case';

			    $parentCase = $this->getCaseDetails($parentId);
			    $this->set('parentCase', $parentCase);
		    } else {

			    $this->ClientCase->contain('CaseType');
			    $childCases = $this->ClientCase->find('all', array(
				    'conditions' => array(
					    'ClientCase.parent_case_id' => $caseId,
					    'ClientCase.user_id' => $this->Session->read('UserInfo.lawyer_id')
				    ),
				    'order' => 'ClientCase.created ASC'
			    ));
			    $this->set('childCases', $childCases);
		    }
	    } else {

		    $this->Flash->error(__('Access denied'));

		    return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
	    }

	    $this->set('caseDetails', $caseDetails);
        $this->set('pageTitle', $this->pageTitle);
	    $this->set('caseId', $caseId);
    }

	private function detachCasesInBulk($childIds, $caseId)
	{
		foreach($childIds as $childCaseId) {

			$caseDetails = $this->getCaseDetails($childCaseId);

			if(!empty($caseDetails)) {

				if($caseDetails['ClientCase']['parent_case_id'] == $caseId) {

					$this->_deleteConnection($childCaseId);
				}
			}
		}
	}

	public function detachCase($childCaseId, $skipSetFlash = false)
	{
		$caseDetails = $this->getCaseDetails($childCaseId);

		if(!empty($caseDetails)) {

			$this->_deleteConnection($childCaseId);
			if($skipSetFlash != true) {

				$this->Flash->success(__('Case detached successfully.'));

				return $this->redirect(array('controller' => 'ConnectCases', 'action' => 'manage', $caseDetails['ClientCase']['parent_case_id']));
			}
		}

		$this->Flash->error(__('Access denied'));

		return $this->redirect(array('controller' => 'ConnectCases', 'action' => 'manage', $childCaseId));
	}

	private function getCaseDetails($caseId)
	{
		$this->ClientCases = $this->Components->load('ClientCases');

		return $this->ClientCases->findByCaseId($caseId, $this->Session->read('UserInfo.lawyer_id'));
	}

	public function addConnections($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Connect Cases';

		$this->loadModel('ClientCase');
		$caseDetails = $this->getCaseDetails($caseId);
		$selectParent = false;
		$selectChild = false;
		if(!empty($caseDetails['ClientCase']['case_number'])) {

			$customSearch = array();
			if (isset($this->request->data['ClientCase']) && !empty($this->request->data['ClientCase'])) {
				foreach ($this->request->data['ClientCase'] as $key => $value) {
					if (!empty($value)) {

						$customSearch[] = "cc1.$key LIKE '%".$value."%'";
					}
				}

				if(!empty($customSearch)) {

					$this->ClientCase->contain('CaseType');
					$listCases = $this->ClientCase->getUnattachedCases($caseId, $this->Session->read('UserInfo.lawyer_id'), $customSearch);

					$this->set('listCases', $listCases);
				}
			}

			$parentId = $caseDetails['ClientCase']['parent_case_id'];
			if(!empty($parentId)) {

				$this->pageTitle = 'Connect To Case';
				$selectParent = true;
			} else {

				$childCases = $this->ClientCase->find('all', array(
					'conditions' => array(
						'ClientCase.parent_case_id' => $caseId,
						'ClientCase.user_id' => $this->Session->read('UserInfo.lawyer_id')
					),
					'order' => 'ClientCase.created ASC'
				));

				if(!empty($childCases)) {

					$selectChild = true;
				}
			}
		} else {

			$this->Flash->error(__('Access denied'));

			return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
		}

		$this->set('selectChild', $selectChild);
		$this->set('selectParent', $selectParent);
		$this->set('caseDetails', $caseDetails);
		$this->set('pageTitle', $this->pageTitle);
		$this->set('caseId', $caseId);
	}

	public function addConnectionsProcess($caseId)
	{
		$this->loadModel('ClientCase');
		$caseDetails = $this->getCaseDetails($caseId);

		if(!empty($caseDetails['ClientCase']['case_number']) && !empty($this->request->data)) {

			$parentId = $caseDetails['ClientCase']['parent_case_id'];
			if(!empty($parentId)) {

				if(!empty($this->request->data['parentId'])) {

					$postedParentId = $this->request->data['parentId'];
					$this->_saveConnection($caseId, $postedParentId);

					$this->Flash->success(__('Case detached successfully.'));
				}
			} else {

				if(!empty($this->request->data['parentId'])) {

					$postedParentId = $this->request->data['parentId'];
					$this->_saveConnection($caseId, $postedParentId);

					$this->Flash->success(__('Case detached successfully.'));
				}elseif(!empty($this->request->data['box'])) {

					$postedChildIds = $this->request->data['box'];

					if(!empty($postedChildIds)) {

						foreach($postedChildIds as $postedChildId) {

							$this->_saveConnection($postedChildId, $caseId);
						}
					}

					$this->Flash->success(__('Case detached successfully.'));
				}
			}

			return $this->redirect(array('controller' => 'ConnectCases', 'action' => 'manage', $caseId));
		} else {

			$this->Flash->error(__('Access denied'));

			return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
		}
	}

	private function _saveConnection($updateCaseId, $parentCaseId)
	{
		$this->loadModel('ClientCase');
		$postedChildArr = $this->ClientCase->read(null, $updateCaseId);

		$postedChildData = $postedChildArr['ClientCase'];
		$postedChildData['is_main_case'] = 0;
		$postedChildData['parent_case_id'] = $parentCaseId;

		$this->ClientCase->save($postedChildData, false);
	}

	private function _deleteConnection($updateCaseId)
	{
		$this->loadModel('ClientCase');
		$postedChildArr = $this->ClientCase->read(null, $updateCaseId);

		$postedChildData = $postedChildArr['ClientCase'];
		$postedChildData['is_main_case'] = 1;
		$postedChildData['parent_case_id'] = 0;

		$this->ClientCase->save($postedChildData, false);
	}
}