<?php

App::uses('Component', 'Controller');

class ClientCasesComponent extends Component
{
	public function prepareAddCaseData($data)
	{
		$data['completed_step'] = 1;

		if(empty($data['is_existing'])) {

			$data['computer_file_no'] = $this->generateFileNumber($data['user_id']);
		}

		$data['complete_case_number'] = $this->generateCaseNumber($data);

		if((!isset($data['case_status']) || empty($data['case_status'])) && isset($data['date_fixed'])) {

			$caseStatus = "pending_for_filing";
			if(!empty($data['date_fixed'])) {

				$caseStatus = "pending";
			}

			$data['case_status'] = $this->updateCaseStatus($caseStatus);
		}

		if($data['submit']=='saveIncomplete') {

			$data['saved_incomplete'] = 1;
		}

		if(isset($data['client_type']) && $data['client_type']=='respondent') {

			$data['limitation_expires_on'] = '';
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

	public function generateFileNumber($userId)
	{
		App::import('Model','ClientCase');
		$caseObj = new ClientCase();

		$currYear = date('Y');

		$clientCase = $caseObj->find('first', array(
			'conditions' => array(
				'user_id' => $userId,
				'is_existing' => 0,
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

	public function listEssentialWorks($clientType)
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
				'ClientCase.user_id' => $userId
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
}