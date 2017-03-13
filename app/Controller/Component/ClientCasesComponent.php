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


		$caseStatus = "pending_for_filing";
		if(!empty($data['date_fixed'])) {

			$caseStatus = "pending";
		}

		$data['case_status'] = $this->updateCaseStatus($caseStatus);

		if($data['submit']=='saveIncomplete') {

			$data['saved_incomplete'] = 1;
		}

		if($data['client_type']=='respondent') {

			$data['limitation_expires_on'] = '';
		}

		return $data;
	}

	public function updateCaseStatus($caseStatus)
	{
		App::import('Model','CaseStatus');
		$caseStatusObj = & new CaseStatus();

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
			$caseType = & new CaseType();

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

		if(!empty($caseTypeName) && !empty($data['case_number']) && !empty($data['case_year'])) {

			$caseNumber = $caseTypeName.'-'.$data['case_number'].'-'.$data['case_year'];
		}

		return $caseNumber;
	}

	public function generateFileNumber($userId)
	{
		App::import('Model','ClientCase');
		$caseObj = & new ClientCase();

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
		$clientCase = & new ClientCase();

		$clientCase->contain('CaseType');

		return $clientCase->find('first', array(
			'conditions' => array(
				'ClientCase.id' => $caseId,
				'ClientCase.user_id' => $userId
			)
		));
	}
}