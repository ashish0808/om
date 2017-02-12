<?php

App::uses('Component', 'Controller');

class ClientCasesComponent extends Component
{
	public function prepareAddCaseData($data)
	{
		$data['completed_step'] = 1;

		if(empty($data['is_existing'])) {

			$data['file_number'] = $this->generateFileNumber($data['lawyer_id']);
		}

		$data['complete_case_number'] = $this->generateCaseNumber($data);

		if($data['submit']=='saveIncomplete') {

			$data['saved_incomplete'] = 1;
		}

		return $data;
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

	public function generateFileNumber($lawyerId)
	{
		App::import('Model','ClientCase');
		$caseObj = & new ClientCase();

		$currYear = date('Y');

		$clientCase = $caseObj->find('first', array(
			'conditions' => array(
				'lawyer_id' => $lawyerId,
				'is_existing' => 0,
				'file_number LIKE' => '%/'.$currYear
			),
			'fields' => array('id', 'file_number'),
			'order' => 'file_number DESC'
		));

		if(!empty($clientCase['ClientCase']['file_number'])) {

			$fileNumArr = explode('/', $clientCase['ClientCase']['file_number']);

			if(!empty($fileNumArr[0])) {

				$newFileNum = $fileNumArr[0]+1;

				return $newFileNum.'/'.$currYear;
			}
		}

		return '301/'.$currYear;
	}
}