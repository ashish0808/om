<?php

App::uses('Component', 'Controller');

class ClientCasesComponent extends Component
{
	public function prepareAddCaseData($data, $caseDetails = NULL)
	{
		$data['completed_step'] = 1;

		if(!isset($data['id']) || empty($data['id'])) {

			$data['computer_file_no'] = $this->generateFileNumber($data);
		}

		$data['complete_case_number'] = $this->generateCaseNumber($data);
		
		if((!isset($data['case_status']) || empty($data['case_status'])) && (isset($data['is_existing']) && $data['is_existing'] == 0)) {
			
			if(isset($data['date_fixed']) && $this->existingCaseStatusChecks($caseDetails)) {

				if(isset($data['client_type']) && $data['client_type']=='respondent') {

					$caseStatus = "pending";
				} else {

					$caseStatus = "pending_for_filing";
					if(!empty($data['date_fixed'])) {

						$caseStatus = "pending";
					}
				}

				$data['case_status'] = $this->updateCaseStatus($caseStatus);
			}
		}

		if($data['submit']=='saveIncomplete') {

			$data['saved_incomplete'] = 1;
		}

		if(isset($data['client_type'])) {

			if($data['client_type']=='respondent') {

				$data['limitation_expires_on'] = '';
			}

			if($data['client_type']=='petitioner') {

				$data['is_ememo_filed'] = 1;
			}
		}

		$data = $this->updateEssentialWorks($data);

		return $data;
	}
	
	public function existingCaseStatusChecks($caseDetails)
	{
		if(!empty($caseDetails['ClientCase']['case_status'])) {
			
			App::import('Model','CaseStatus');
			$caseStatusObj = new CaseStatus();

			$caseStatusData = $caseStatusObj->find('first', array(
				'conditions' => array(
					'id' => $caseDetails['ClientCase']['case_status']
				),
				'fields' => array('status')
			));
			
			if(!empty($caseStatusData['CaseStatus']['status']) && !in_array($caseStatusData['CaseStatus']['status'], array('pending_for_filing'))) {

				return false;
			}
		}
		
		return true;
	}

	public function updateEssentialWorks($data)
	{
		if(!empty($data['case_status'])) {

			App::import('Model','CaseStatus');
			$caseStatusObj = new CaseStatus();

			$caseStatusData = $caseStatusObj->find('first', array(
				'conditions' => array(
					'id' => $data['case_status']
				),
				'fields' => array('id', 'status')
			));

			if(!empty($caseStatusData['CaseStatus']['status']) && $caseStatusData['CaseStatus']['status']=='decided') {

				$essentialWorks = $this->listEssentialWorks();

				foreach($essentialWorks as $essentialWorkKey=>$essentialWork) {

					$data[$essentialWorkKey] = 1;
				}
			}
		}

		return $data;
	}

	public function updateCaseStatus($caseStatus)
	{
		App::import('Model','CaseStatus');
		$caseStatusObj = new CaseStatus();

		$caseStatusData = $caseStatusObj->find('first', array(
			'conditions' => array(
				'status' => $caseStatus
			),
			'fields' => array('id')
		));

		if(!empty($caseStatusData['CaseStatus']['id'])) {

			return $caseStatusData['CaseStatus']['id'];
		}

		return 0;
	}

	public function generateCaseNumber($data)
	{
		$caseNumber = '';

		$caseTypeName = '';
		if(!empty($data['case_type_id'])) {

			App::import('Model','CaseType');
			$caseType = new CaseType();

			$caseTypeObj = $caseType->find('first', array(
				'conditions' => array(
					'id' => $data['case_type_id']
				),
				'fields' => array('id', 'name')
			));

			if(!empty($caseTypeObj['CaseType']['name'])) {

				$caseTypeName = $caseTypeObj['CaseType']['name'];
			}
		}

		$caseNumberArr = array();
		if(!empty($caseTypeName)) {

			$caseNumberArr[] = $caseTypeName;
		}

		if(!empty($data['case_number'])) {

			$caseNumberArr[] = $data['case_number'];
		}

		if(!empty($data['case_year'])) {

			$caseNumberArr[] = $data['case_year'];
		}

		if(!empty($caseNumberArr)) {

			$caseNumber = implode('-', $caseNumberArr);
		}

		return $caseNumber;
	}

	public function generateFileNumber($data)
	{
		$userId = $data['user_id'];

		App::import('Model','ClientCase');
		$caseObj = new ClientCase();

		$engagedOn = strtotime($data['engaged_on']);
		$currYear = date('Y', $engagedOn);

		$clientCase = $caseObj->find('first', array(
			'conditions' => array(
				'user_id' => $userId,
				//'is_existing' => 0,
				'computer_file_no LIKE' => '%/'.$currYear
			),
			'fields' => array('id', 'computer_file_no'),
			'order' => 'computer_file_no DESC'
		));

		if(!empty($clientCase['ClientCase']['computer_file_no'])) {

			$fileNumArr = explode('/', $clientCase['ClientCase']['computer_file_no']);

			if(!empty($fileNumArr[0])) {

				$newFileNum = $fileNumArr[0]+1;

				return $newFileNum.'/'.$currYear;
			}
		}

		return '301/'.$currYear;
	}

	public function listEssentialWorks($clientType = '')
	{
		$essentialWorks = array(
			'is_ememo_filed' => 'E-memo filed',
			'is_paper_book' => 'Paper book',
			'is_diary_entry' => 'Diary Entry',
			'is_letter_communication' => 'Letter/Communication',
			'is_lcr' => 'LCR'
		);

		if($clientType == 'petitioner') {

			unset($essentialWorks['is_ememo_filed']);
		}

		return $essentialWorks;
	}

	public function findByCaseId($caseId, $userId)
	{
		App::import('Model','ClientCase');
		$clientCase = new ClientCase();

		$clientCase->contain('CaseType');

		return $clientCase->find('first', array(
			'conditions' => array(
				'ClientCase.id' => $caseId,
				'ClientCase.user_id' => $userId,
				'is_deleted' => false
			)
		));
	}

	public function listFilterWithStatus($criteria, $listType)
	{
		if(!empty($listType)) {

			if($listType == 'decided') {

				$criteria = $this->_addListFilterWithStatusId($criteria, $listType);
			}elseif($listType == 'notwithus') {

				$criteria = $this->_addListFilterWithStatusId($criteria, 'not_with_us');
			}
		} else {

			App::import('Model','CaseStatus');
			$caseStatusObj = new CaseStatus();

			$caseStatuses = $caseStatusObj->find('all', array(
				'conditions' => array(
					'status' => array('decided', 'notwithus')
				),
				'fields' => array('id')
			));

			if(!empty($caseStatuses)) {

				$caseStatusIds = array();
				foreach($caseStatuses as $caseStatus) {

					$caseStatusIds[] = $caseStatus['CaseStatus']['id'];
				}

				$criteria['ClientCase.case_status'] = ' NOT IN ('.implode(', ', $caseStatusIds).')';
			}

			return $criteria;
		}


		return $criteria;
	}

	private function _addListFilterWithStatusId($criteria, $listType)
	{
		App::import('Model','CaseStatus');
		$caseStatusObj = new CaseStatus();

		$caseStatusData = $caseStatusObj->find('first', array(
			'conditions' => array(
				'status' => $listType
			),
			'fields' => array('id')
		));

		if(!empty($caseStatusData['CaseStatus']['id'])) {

			$criteria['ClientCase.case_status'] = ' = '.$caseStatusData['CaseStatus']['id'];
		}

		return $criteria;
	}

	public function updateCaseFilingLimitationExpiry($data)
	{
		if(!empty($data['id']) && !empty($data['limitation_expires_on'])) {

			App::import('Model','CaseFiling');
			$caseFilingObj = new CaseFiling();
			$caseFiling = $caseFilingObj->find('first', array(
				'conditions' => array(
					'client_case_id' => $data['id']
				),
				'order' => 'created DESC'
			));

			if(!empty($caseFiling)) {

				$limitation_expires_on = $data['limitation_expires_on'];
				$caseData = array('limitation_expires_date' => "'".$limitation_expires_on."'");

				$caseFilingObj->updateAll($caseData, array('CaseFiling.id'=> $caseFiling['CaseFiling']['id']));
			}
		}
	}

	public function getCaseStatusByName($listType)
	{
		if(!empty($listType) && $listType != 'deleted') {

			App::import('Model','CaseStatus');
			$caseStatusObj = new CaseStatus();
			$caseStatus = $caseStatusObj->find('first', array(
				'conditions' => array(
					'status' => $listType
				),
				'fields' => array('CaseStatus.id', 'CaseStatus.status')
			));

			if(!empty($caseStatus)) {

				return $caseStatus['CaseStatus']['id'];
			}
		}

		return '';
	}
}