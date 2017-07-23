<?php
App::uses('AppController', 'Controller');
/**
 * Cases Controller.
 *
 * @property CaseCivilMisc $CaseCivilMisc
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CasesController extends AppController
{
	public $helpers = array("Form", "Js" => array('Jquery'), 'Validation', 'Session', 'ClientCase');
	//JS and Validation helpers are not in Use right now

	public $components = array('Paginator', 'Flash', 'Session', 'RequestHandler', 'Email', 'PhpExcel');

	public function manage($listType = '')
	{
		$this->ClientCases = $this->Components->load('ClientCases');
		$selectedStatusId = '';

		if ($this->request->isAjax()) {

			$this->layout = 'ajax';
		} else {

			$this->layout = 'basic';
			$selectedStatusId = $this->ClientCases->getCaseStatusByName($listType);
		}

		$this->set('selectedCaseStatus', $selectedStatusId);

		$pageName = 'Manage Cases';
		if($listType == 'deleted') {

			$pageName = 'Manage Deleted Cases';
		}

		$this->pageTitle = $pageName;
		$this->set('pageTitle', $this->pageTitle);

		$this->loadModel('ClientCase');
		$this->loadModel('CaseStatus');

		$stringFields = array('complete_case_number', 'case_title', 'party_name');

		$fields = [];
		$records = array();
		$criteria = [];
		$exportCriteria = [];

		if ($listType != 'deleted' && !empty($this->request->data)) {
			foreach ($this->request->data['ClientCase'] as $key => $value) {
				if (!empty($value)) {

					$value = trim($value);
					$exportCriteria[$key] = $value;
					if(in_array($key, $stringFields)) {

						$criteria[$key] = ' LIKE "%'.$value.'%"';
					} else {

						$criteria[$key] = " = '".$value."'";
					}

					$this->request->params['named'][$key] = $value;
				}
			}
		}

		if ($listType != 'deleted' && !empty($this->request->params['named'])) {
			foreach ($this->request->params['named'] as $key => $value) {
				$exportCriteria[$key] = $value;
				if (!in_array($key, ['page', 'sort', 'direction'])) {

					if (!empty($value)) {

						$value = trim($value);
						if(in_array($key, $stringFields)) {

							$criteria[$key] = ' LIKE "%'.$value.'%"';
						} else {

							$criteria[$key] = " = '".$value."'";
						}

						$this->request->data['ClientCase'][$key] = $value;
					}
				}
			}
		}

		$this->Paginator->settings = array(
			'page' => 1,
			'limit' => LIMIT,
			'fields' => $fields,
			'order' => array('ClientCase.id' => 'desc')
		);

		$criteriaStr = 'ClientCase.user_id='.$this->getLawyerId();

		if($listType == 'deleted') {

			$criteria['is_deleted'] = " = 1";
		} else {

			$criteriaStr .= ' AND ClientCase.is_deleted != 1';
		}

		if(!empty($criteria)) {

			$criteria = $this->ClientCases->listFilterWithStatus($criteria, '');
			foreach($criteria as $criteriaKey => $criteriaVal) {

				$criteriaStr .= ' AND '.$criteriaKey.$criteriaVal;
			}

			$records = $this->Paginator->paginate('ClientCase', $criteriaStr);
		}

		$caseStatuses = $this->CaseStatus->find('all', array(
			'conditions' => array(
				"NOT" => array( "CaseStatus.status" => array('decided', 'not_with_us') )
			),
			'fields' => array('id', 'status')
		));
		$caseStatusesArr = array();
		if(!empty($caseStatuses)) {

			foreach($caseStatuses as $caseStatus){

				$caseStatusesArr[$caseStatus['CaseStatus']['id']] = ucfirst(str_replace('_', ' ', $caseStatus['CaseStatus']['status']));
			}
		}
		$this->set('caseStatuses', $caseStatusesArr);

		$this->loadModel('CaseType');
		$caseTypes = $this->CaseType->find('list', array(
			'fields' => array('CaseType.id', 'CaseType.name'),
			'order' => 'name ASC'
		));
		$this->set("caseTypes", $caseTypes);

		$this->set('listType', $listType);
		$this->set('records', $records);
		$this->set('criteria', $exportCriteria);
	}

	public function exportExcel()
	{
		$this->loadModel('ClientCase');
		$this->loadModel('CaseStatus');

		$stringFields = array('complete_case_number', 'case_title', 'party_name', 'computer_file_no');

		$criteria = [];
		$this->ClientCases = $this->Components->load('ClientCases');

		if (!empty($this->request->data)) {
			foreach ($this->request->data['ClientCase'] as $key => $value) {
				if (!in_array($key, ['page', 'sort', 'direction'])) {

					if (!empty($value)) {

						$value = trim($value);
						if(in_array($key, $stringFields)) {

							$criteria[$key] = ' LIKE "%'.$value.'%"';
						} else {

							$criteria[$key] = " = '".$value."'";
						}
					}
				}
			}
		}

		$orderBy = array('ClientCase.id' => 'desc');

		if((isset($this->request->data['ClientCase']['sort']) && !empty($this->request->data['ClientCase']['sort']))
		&& (isset($this->request->data['ClientCase']['direction']) && !empty($this->request->data['ClientCase']['direction']))) {

			$orderBy = array();
			$orderBy[$this->request->data['ClientCase']['sort']] = $this->request->data['ClientCase']['direction'];
		}

		$count = $this->ClientCase->find('count', array('conditions' => array("ClientCase.user_id" => $this->getLawyerId())));

		$this->Paginator->settings = array(
			'page' => 1,
			'limit' => $count,
			'order' => $orderBy,
			'contain' => array('Court')
		);

		$criteriaStr = 'ClientCase.user_id='.$this->getLawyerId();

		if(!empty($criteria)) {

			$criteria = $this->ClientCases->listFilterWithStatus($criteria, '');
			foreach($criteria as $criteriaKey => $criteriaVal) {

				$criteriaStr .= ' AND '.$criteriaKey.$criteriaVal;
			}

			$records = $this->Paginator->paginate('ClientCase', $criteriaStr);

			// create new empty worksheet and set default font
			$this->PhpExcel->createWorksheet()
				->setDefaultFont('Calibri', 12);

			// define table cells
			$table = array(
				array('label' => 'Case Number', 'filter' => true),
				array('label' => 'Computer File No.', 'filter' => true),
				array('label' => 'Case Title', 'filter' => true),
				array('label' => 'Case Year', 'filter' => true),
				array('label' => 'Party Name', 'filter' => true),
				array('label' => 'Connected Cases', 'filter' => true),
				array('label' => 'Status', 'filter' => true),
				array('label' => 'Created', 'filter' => true),
				array('label' => 'Engaged On', 'filter' => true),
				array('label' => 'Court', 'filter' => true),
				array('label' => 'Presiding Officer', 'filter' => true),
				array('label' => 'Client Type', 'filter' => true),
				array('label' => 'Client Phone', 'filter' => true),
				array('label' => 'Client Email', 'filter' => true),
				array('label' => 'Client Address', 'filter' => true),
				array('label' => 'Fee Settled', 'filter' => true),
				array('label' => 'Payment Received', 'filter' => true),
				array('label' => 'Payment Status', 'filter' => true),
				//array('label' => __('Description'), 'width' => 50, 'wrap' => true),
			);

			// add heading with different font and bold text
			$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

			// add data
			foreach ($records as $record) {

				$caseStatus = 'NA';
				$courtName = '';
				$clientType = ucfirst($record['ClientCase']['client_type']);
				$phone2 = '';
				$feeSettled = '';
				$paymentReceived = '';
				$paymentStatus = '';

				if(!empty($record['CaseStatus']['status'])) {
					$caseStatus = ucfirst(str_replace('_', ' ', $record['CaseStatus']['status']));
				}

				if(!empty($record['Court']['name'])) {
					$courtName = $record['Court']['name'];
				}

				if($record['ClientCase']['client_type']=='petitioner') {
					$clientType = 'Appellant/Petitioner';
				}

				if(!empty($record['ClientCase']['client_phone2'])) {
					$phone2 = ', '.$record['ClientCase']['client_phone2'];
				}

				if(isset($record['ClientCase']['fee_settled'])) {

					$feeSettled = $record['ClientCase']['fee_settled'];
				}

				if(isset($record['ClientCase']['payment_received'])) {

					$paymentReceived = $record['ClientCase']['payment_received'];
				}

				if(isset($record['ClientCase']['payment_status'])) {

					$paymentStatus = ucfirst($record['ClientCase']['payment_status']);
				}

				$this->PhpExcel->addTableRow(array(
					$record['ClientCase']['complete_case_number'],
					$record['ClientCase']['computer_file_no'],
					$record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "Miscellaneous",
					$record['ClientCase']['case_year'],
					$record['ClientCase']['party_name'],
					$record['ClientCase']['client_case_count'] ? $record['ClientCase']['client_case_count']: 0,
					$caseStatus,
					$record['ClientCase']['created'],
					$record['ClientCase']['engaged_on'],
					$courtName,
					$record['ClientCase']['presiding_officer'],
					$clientType,
					$record['ClientCase']['client_phone'].$phone2,
					$record['ClientCase']['client_email'],
					$record['ClientCase']['client_address1'].' '.$record['ClientCase']['client_address2'],
					$feeSettled,
					$paymentReceived,
					$paymentStatus
				));
			}

			// close table and output
			$this->PhpExcel->addTableFooter()
				->output();
		}
		exit;
	}

	public function manageWithList($listType = '')
	{
		if ($this->request->isAjax()) {
			$this->layout = 'ajax';
		} else {
			$this->layout = 'basic';
		}

		$pageName = 'Manage Cases';
		if($listType == 'decided') {

			$pageName = 'List Decided Cases';
		}elseif($listType == 'notwithus') {

			$pageName = 'List Cases Not With Us';
		}

		$this->pageTitle = $pageName;
		$this->set('pageTitle', $this->pageTitle);

		$this->loadModel('ClientCase');
		$this->loadModel('CaseStatus');

		$fields = [];

		$criteria = array();

		$this->ClientCases = $this->Components->load('ClientCases');
		$criteria = $this->ClientCases->listFilterWithStatus($criteria, $listType);

		if (!empty($this->request->data)) {
			foreach ($this->request->data['ClientCase'] as $key => $value) {
				if (!empty($value)) {
					$criteria['ClientCase.'.$key] = " LIKE '%".$value."%'";
					$this->request->params['named'][$key] = $value;
				}
			}
		}

		if (!empty($this->request->params['named'])) {
			foreach ($this->request->params['named'] as $key => $value) {
				if (!in_array($key, ['page', 'sort', 'direction'])) {
					if (!empty($value)) {
						$criteria['ClientCase.'.$key] = " LIKE '%".$value."%'";
						$this->request->data['ClientCase'][$key] = $value;
					}
				}
			}
		}

		$this->Paginator->settings = array(
			'page' => 1,
			'limit' => LIMIT,
			'fields' => $fields,
			'order' => array('ClientCase.id' => 'desc')
		);

		$this->set('paginateLimit', LIMIT);

		$criteriaStr = 'ClientCase.user_id='.$this->getLawyerId();

		if(!empty($criteria)) {

			foreach($criteria as $criteriaKey => $criteriaVal) {

				$criteriaStr .= ' AND '.$criteriaKey.$criteriaVal;
			}
		}
		//echo $criteriaStr; die;
		//pr($criteria); die;

		$records = $this->Paginator->paginate('ClientCase', $criteriaStr);

		$caseStatuses = $this->CaseStatus->find('all', array(
			'conditions' => array(
				"NOT" => array( "CaseStatus.status" => array('decided', 'not_with_us') )
			),
			'fields' => array('id', 'status')
		));
		$caseStatusesArr = array();
		if(!empty($caseStatuses)) {

			foreach($caseStatuses as $caseStatus){

				$caseStatusesArr[$caseStatus['CaseStatus']['id']] = ucfirst(str_replace('_', ' ', $caseStatus['CaseStatus']['status']));
			}
		}
		$this->set('caseStatuses', $caseStatusesArr);

		$this->loadModel('CaseType');
		$caseTypes = $this->CaseType->find('list', array(
			'fields' => array('CaseType.id', 'CaseType.name'),
			'order' => 'name ASC'
		));
		$this->set("caseTypes", $caseTypes);

		$this->set('listType', $listType);
		$this->set('records', $records);
	}

	public function add()
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Add Case';
		$this->set("pageTitle", $this->pageTitle);
		$this->loadModel('ClientCase');

		if ($this->request->data) {

			if ($this->ClientCase->validates()) {

				$this->request->data['ClientCase']['user_id'] = $this->getLawyerId();

				$this->ClientCases = $this->Components->load('ClientCases');
				$data = $this->ClientCases->prepareAddCaseData($this->request->data['ClientCase']);
				$data['reminder_date'] = date('Y-m-d');

				if ($this->ClientCase->save($data)) {

					$caseId = $this->ClientCase->getLastInsertId();

					$data['id'] = $caseId;
					$this->addCaseProceeding($data);

					$this->Flash->success(__(CASE_INFORMATION_ADDED));

					if(isset($this->request->data['ClientCase']['submit']) && $this->request->data['ClientCase']['submit']=='next') {

						$this->redirect(array('controller' => 'cases', 'action' => 'edit', $caseId));
					} else {

						$this->redirect(array('controller' => 'cases', 'action' => 'manage'));
					}
				}
			}
		}

		$this->loadModel('CaseType');
		$caseTypes = $this->CaseType->find('list', array(
			'fields' => array('CaseType.id', 'CaseType.name'),
			'order' => 'name ASC'
		));
		$this->set("caseTypes", $caseTypes);

		$this->set("caseStatuses", $this->listExistingCaseStatuses());

		$this->loadModel('Court');
		$courts = $this->Court->listCourts();
		$this->set("courts", $courts);
	}

	private function listExistingCaseStatuses()
	{
		$this->loadModel('CaseStatus');
		$caseStatuses = $this->CaseStatus->find('all', array(
			'conditions' => array(
				'status' => array('admitted', 'pending', 'decided')
			),
			'fields' => array('CaseStatus.id', 'CaseStatus.status'),
			'order' => 'status ASC'
		));

		$caseStatusesArr = array();
		if(!empty($caseStatuses)) {

			foreach($caseStatuses as $caseStatus){

				$caseStatusesArr[$caseStatus['CaseStatus']['id']] = ucfirst(str_replace('_', ' ', $caseStatus['CaseStatus']['status']));
			}
		}

		return $caseStatusesArr;
	}

	public function edit($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Edit Case';
		$this->set("pageTitle", $this->pageTitle);
		$this->set('caseId',$caseId);

		$this->loadModel('ClientCase');
		$caseDetails = $this->ClientCase->read(null, $caseId);
		$this->checkCaseDetails($caseDetails);
		$this->set('caseDetails', $caseDetails);
	}

	public function ajaxEdit($caseId)
	{
		$this->layout = 'ajax';

		$this->loadModel('ClientCase');

		$this->ClientCase->contain(array('CasePayment' => array('conditions' => array('type' => 'fee')), 'CasePayment.PaymentMethod', 'CaseFiling', 'CaseStatus', 'CaseProceeding'));
		$caseDetails = $this->ClientCase->read(null, $caseId);

		$this->request->data['ClientCase'] = $caseDetails['ClientCase'];

		$this->set('caseDetails',$caseDetails);
		$this->set('caseId',$caseId);

		$this->loadModel('CaseType');
		$this->set("caseTypes", $this->CaseType->find('list', array(
			'fields' => array('CaseType.id', 'CaseType.name'),
			'order' => 'name ASC'
		)));

		$this->loadModel('Court');
		$this->set("courts", $this->Court->listCourts());

		$this->loadModel('UserCompany');
		$this->set("userCompanies", $this->UserCompany->find('list', array(
			'conditions' => array(
				'user_id' => $this->getLawyerId()
			),
			'fields' => array('UserCompany.id', 'UserCompany.name'),
			'order' => 'name ASC'
		)));

		$this->loadModel('PaymentMethod');
		$this->set("paymentMethods", $this->PaymentMethod->find('list', array(
			'fields' => array('id', 'method'),
			'order' => 'method ASC'
		)));

		$defaultCollapseIn = '';
		if(!empty($_REQUEST['defaultCollapseIn'])) {

			$defaultCollapseIn = $_REQUEST['defaultCollapseIn'];
		}

		$this->loadModel('CaseProceeding');
		$this->set("pendingProceeding", $this->CaseProceeding->find('first', array(
			'conditions' => array(
				'client_case_id' => $caseId,
				'proceeding_status' => 'pending'
			),
			'fields' => array('date_of_hearing'),
			'order' => 'date_of_hearing DESC'
		)));

		$mainCaseFile = '';
		if (!empty($caseDetails['ClientCase']['main_file'])) {
			$mainCaseFile = $this->Aws->getObjectUrl($caseDetails['ClientCase']['main_file']);
		}
		$this->set("mainCaseFile", $mainCaseFile);

		$this->ClientCases = $this->Components->load('ClientCases');
		$this->set("essentialWorksArr", $this->ClientCases->listEssentialWorks($caseDetails['ClientCase']['client_type']));

		$this->set("defaultCollapseIn", $defaultCollapseIn);

		$this->set("caseStatuses", $this->listExistingCaseStatuses());
	}

	public function editBasicDetails($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$this->ClientCase->contain('CaseProceeding');
		$caseDetails = $this->ClientCase->read(null, $caseId);

		$this->loadModel('ClientCase');

		$result = array('status' => 'error', 'message' => 'Unable to process data');
		if ($this->request->data) {

			$this->ClientCase->set($this->request->data);
			if ($this->ClientCase->validates()) {

				$this->ClientCases = $this->Components->load('ClientCases');

				$this->request->data['ClientCase']['user_id'] = $this->getLawyerId();
				$data = $this->ClientCases->prepareAddCaseData($this->request->data['ClientCase']);

				if($caseDetails['ClientCase']['completed_step'] > 1) {

					$data['completed_step'] = $caseDetails['ClientCase']['completed_step'];
				}

				if(empty($data['case_status'])) {

					$data['case_status'] = $caseDetails['ClientCase']['case_status'];
				}

				if ($this->ClientCase->save($data)) {

					if(empty($caseDetails['CaseProceeding'])) {

						$this->addCaseProceeding($data);
					}

					$this->setFlashCaseUpdated($this->request->data['ClientCase']);
					$result = array('status' => 'success');
				}
			} else {

				$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
			}
		}

		echo json_encode($result);
		exit;
	}

	public function editClientInfo($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$caseDetails = $this->ClientCase->read(null, $caseId);

		$result = array('status' => 'error', 'message' => 'Unable to process data');


		if ($this->request->data) {

			$this->ClientCase->set($this->request->data);

			$this->ClientCase->validate = $this->ClientCase->validateClientInfo;

			if ($this->ClientCase->validate) {

				$data = $this->request->data['ClientCase'];
				$data = $this->ifSavedIncomplete($data);

				if($caseDetails['ClientCase']['completed_step'] < 2) {

					$data['completed_step'] = 2;
				}

				if ($this->ClientCase->save($data)) {

					$this->setFlashCaseUpdated($this->request->data['ClientCase']);
					$result = array('status' => 'success');
				} else {

					$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
				}
			} else {

				$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
			}
		}

		echo json_encode($result);
		exit;
	}

	public function editRemarks($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$caseDetails = $this->ClientCase->read(null, $caseId);

		$result = array('status' => 'error', 'message' => 'Unable to process data');

		if ($this->request->data) {

			$data = $this->request->data['ClientCase'];
			$data = $this->ifSavedIncomplete($data);

			if ($caseDetails['ClientCase']['completed_step'] < 4) {

				$data['completed_step'] = 4;
			}

			if ($this->ClientCase->save($data, false)) {

				$this->setFlashCaseUpdated($this->request->data['ClientCase']);
				$result = array('status' => 'success');
			}
		}

		echo json_encode($result);
		exit;
	}

	public function addPayment($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('CasePayment');

		if ($this->request->data) {

			$this->CasePayment->set($this->request->data);
			if ($this->CasePayment->validates()) {

				$data = $this->request->data['CasePayment'];
				$data['client_case_id'] = $caseId;
				$data['user_id'] = $this->Session->read('UserInfo.uid');
                unset($data['fee_settled']);

				if(!empty($data['amount'])) {

					$this->CasePayment->save($data);
				}

				$this->addPaymentUpdateCase($caseId, $this->request->data['CasePayment']);

				$this->setFlashCaseUpdated($this->request->data['CasePayment']);
				$result = array('status' => 'success');
			} else {

				$result = array('status' => 'error', 'message' => $this->CasePayment->validationErrors);
			}
		}

		echo json_encode($result);
		exit;
	}

	public function editPayment($caseId, $casePaymentId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');
		$this->loadModel('CasePayment');

		if ($this->request->data) {

			$result = array('status' => 'error');
			$this->CasePayment->set($this->request->data);
			if ($this->CasePayment->validates()) {

				$data = $this->request->data['CasePayment'];
				if(!empty($data['amount'])) {

					$this->CasePayment->save($data);

					$this->ClientCase->contain(array('CasePayment' => array('conditions' => array('type' => 'fee'))));
					$caseDetails = $this->ClientCase->read(null, $caseId);
					$caseData = $this->getPaymentStatus($caseDetails);
					$this->ClientCase->updateAll($caseData, array('ClientCase.id'=> $caseId));

					$result = array('status' => 'success');
				}
			} else {

				$result = array('status' => 'error', 'message' => $this->CasePayment->validationErrors);
			}

			echo json_encode($result);
			exit;
		}

		$caseDetails = $this->CasePayment->read(null, $casePaymentId);
		$this->request->data['CasePayment'] = $caseDetails['CasePayment'];

		$this->set("caseId", $caseId);
		$this->set("casePaymentId", $casePaymentId);

		$this->loadModel('PaymentMethod');
		$this->set("paymentMethods", $this->PaymentMethod->find('list', array(
			'fields' => array('id', 'method'),
			'order' => 'method ASC'
		)));
	}

	private function addPaymentUpdateCase($caseId, $data)
	{
		$this->loadModel('ClientCase');

		$this->ClientCase->contain(array('CasePayment' => array('conditions' => array('type' => 'fee'))));
		$caseDetails = $this->ClientCase->read(null, $caseId);

		$caseData = array();

		$caseData['fee_settled'] = $data['fee_settled'];
		$caseData['submit'] = $data['submit'];

		if($caseDetails['ClientCase']['completed_step'] < 3) {

			$caseData['completed_step'] = 3;
		}

		$caseData = $this->getPaymentStatus($caseDetails, $caseData);

		$caseData = $this->ifSavedIncomplete($caseData);
		unset($caseData['submit']);

		$this->ClientCase->updateAll($caseData, array('ClientCase.id'=> $caseId));
	}

	public function getPaymentStatus($caseDetails, $caseData = array())
	{
		$caseData['ClientCase.payment_status'] = "'nil'";
		if(!empty($caseDetails['CasePayment'])) {

			$amount_paid = 0;
			$feeSettled = $caseDetails['ClientCase']['fee_settled'];

			if(isset($caseData['fee_settled'])) {

				$feeSettled = $caseData['fee_settled'];
			}

			$nonVerifiedPayment = 0;
			foreach($caseDetails['CasePayment'] as $casePayment) {

				$amount_paid = $amount_paid+$casePayment['amount'];

				if($casePayment['is_verified']!=1) {

					$nonVerifiedPayment = $nonVerifiedPayment+$casePayment['amount'];
				}
			}

			$caseData['ClientCase.payment_received'] = $amount_paid;
			$caseData['ClientCase.non_verified_payment'] = $nonVerifiedPayment;

			if(!empty($amount_paid)) {

				$caseData['ClientCase.payment_status'] = "'part'";
				if($amount_paid >= $feeSettled) {

					$caseData['ClientCase.payment_status'] = "'full'";
				} elseif($amount_paid == ($feeSettled / 2)) {

				$caseData['ClientCase.payment_status'] = "'half'";
				}
			}
		}

		return $caseData;
	}

	public function getLawyerId()
	{
		return $this->Session->read('UserInfo.lawyer_id');
	}

	private function setFlashCaseUpdated($data)
	{
		$formBtn = $data['submit'];
		if($formBtn!='next') {

			$this->Flash->success(__('Case updated successfully.'));
		}
	}

	private function ifSavedIncomplete($data)
	{
		if($data['submit']=='saveIncomplete') {

			$data['saved_incomplete'] = 1;
		}

		return $data;
	}

	public function deletePayment($caseId, $casePaymentId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');
		$this->loadModel('CasePayment');

		$result = array('status' => 'error', 'message' => 'Invalid Request');
		if ($this->request->data) {

			$casePayment = $this->CasePayment->find('first',
					array('conditions' => array(
						'id' => $casePaymentId,
						'client_case_id' => $caseId
					)
				)
			);

			if(!empty($casePayment)) {

				$this->CasePayment->delete($casePayment['CasePayment']['id']);

				$this->ClientCase->contain(array('CasePayment' => array('conditions' => array('type' => 'fee'))));
				$caseDetails = $this->ClientCase->read(null, $caseId);
				$caseData = $this->getPaymentStatus($caseDetails);
				$this->ClientCase->updateAll($caseData, array('ClientCase.id'=> $caseId));

				$result = array('status' => 'success');
			}
		}

		echo json_encode($result);
		exit;
	}

	public function addCaseFiling($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('CaseFiling');

		if ($this->request->data) {

			$this->CaseFiling->set($this->request->data);

			if ($this->CaseFiling->validates()) {

				$result = array('status' => 'success');
			} else {

				$result = array('status' => 'error', 'message' => $this->CaseFiling->validationErrors);
			}

			if (isset($_FILES['file']) && $_FILES['file']['error'] > 0) {

				$result['status'] = 'error';
				$result['message']['main_file'][] = $_FILES['file']['error'];
			}

			if($result['status'] == 'success') {

				$data = $this->request->data['CaseFiling'];
				$data['client_case_id'] = $caseId;
				$this->CaseFiling->save($data);

				$this->loadModel('ClientCase');
				$caseDetails = $this->ClientCase->read(null, $caseId);
				if(!empty($_FILES['file']['tmp_name'])) {

					$sourceFile = $_FILES['file']['tmp_name'];
					$fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$_FILES['file']['name'];
					// Upload file to S3
					$this->Aws->upload($sourceFile, $fileKey);
					if(!empty($caseDetails['ClientCase']['main_file'])) {

						// Delete previous attached file
						$this->Aws->delete($caseDetails['ClientCase']['main_file']);
					}
				}

				$updateCaseDetails = array();
				if(empty($caseDetails['ClientCase']['case_number'])) {

					$this->ClientCases = $this->Components->load('ClientCases');
					$case_status = $this->ClientCases->updateCaseStatus('pending_for_registration');
					$updateCaseDetails = array('case_status' => $case_status);
				}

				if(isset($fileKey) && !empty($fileKey)) {

					$updateCaseDetails['main_file'] = "'$fileKey'";
				}

				if(!empty($updateCaseDetails)) {

					$this->ClientCase->updateAll($updateCaseDetails, array('ClientCase.id'=> $caseId));
				}
			}
		}

		echo json_encode($result);
		exit;
	}

	public function editCaseFiling($caseId, $caseFilingId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');
		$this->loadModel('CaseFiling');

		$caseDetails = $this->ClientCase->read(null, $caseId);

		if ($this->request->data) {

			$this->CaseFiling->set($this->request->data);

			if ($this->CaseFiling->validates()) {

				$result = array('status' => 'success');
			} else {

				$result = array('status' => 'error', 'message' => $this->CaseFiling->validationErrors);
			}

			if($result['status'] == 'success') {

				$data = $this->request->data['CaseFiling'];
				$this->CaseFiling->save($data);
			}

			echo json_encode($result);
			exit;
		}

		$caseFilingDetails = $this->CaseFiling->read(null, $caseFilingId);
		$this->request->data['CaseFiling'] = $caseFilingDetails['CaseFiling'];

		$mainCaseFile = '';
		if (!empty($caseDetails['ClientCase']['main_file'])) {
			$mainCaseFile = $this->Aws->getObjectUrl($caseDetails['ClientCase']['main_file']);
		}

		$this->set("caseId", $caseId);
		$this->set("caseFilingId", $caseFilingId);
		$this->set("mainCaseFile", $mainCaseFile);
	}

	public function caseRegistration($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$result = array('status' => 'error', 'message' => 'Unable to process data');

		if ($this->request->data) {

			$this->ClientCase->set($this->request->data);
			$this->ClientCase->validate = $this->ClientCase->validateCaseRegistration;

			if ($this->ClientCase->validate) {

				$data = $this->request->data['ClientCase'];
				$data['id'] = $caseId;


				$this->ClientCases = $this->Components->load('ClientCases');

				$case_status_val = 'pending_for_refiling';
				if(!empty($data['is_registered'])) {

					$case_status_val = 'pending';
				} else {

					$this->ClientCases->updateCaseFilingLimitationExpiry($data);
				}

				$case_status_id = $this->ClientCases->updateCaseStatus($case_status_val);
				$data['case_status'] = $case_status_id;

				if ($this->ClientCase->save($data)) {

					if(!empty($data['is_registered'])) {

						$this->addCaseProceeding($data);
					}

					$result = array('status' => 'success');
				} else {

					$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
				}
			} else {

				$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
			}
		}

		echo json_encode($result);
		exit;
	}

	public function addCaseProceeding($data)
	{
		if(!empty($data['id']) && !empty($data['case_number']) && !empty($data['date_fixed'])) {

			$this->loadModel('CaseProceeding');

			$saveData = array(
				'date_of_hearing' => $data['date_fixed'],
				'client_case_id' => $data['id']
			);

			$this->CaseProceeding->save($saveData);
		}
	}

	public function updateEssentialWorks($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$caseDetails = $this->ClientCase->read(null, $caseId);

		$result = array('status' => 'error', 'message' => 'Unable to process data');

		if (!empty($caseDetails) && $this->request->data) {

			$data = $this->request->data['ClientCase'];

			$this->ClientCases = $this->Components->load('ClientCases');
			$essentialWorksArr = $this->ClientCases->listEssentialWorks($caseDetails['ClientCase']['client_type']);

			foreach($essentialWorksArr as $essentialWorkKey=>$essentialWork) {

				if(!isset($data[$essentialWorkKey])) {

					$data[$essentialWorkKey] = 0;
				}
			}

			if ($this->ClientCase->save($data, false)) {

				//$this->Flash->success(__('Case updated successfully.'));

				$result = array('status' => 'success');
			}
		}

		echo json_encode($result);
		exit;
	}

	public function addDecision($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$result = array('status' => 'error', 'message' => 'Unable to process data');

		if ($this->request->data) {

			$this->ClientCase->set($this->request->data);
			$this->ClientCase->validate = $this->ClientCase->validateCaseDecision;

			if ($this->ClientCase->validate) {

				$data = $this->request->data['ClientCase'];

				if($data['certified_copy_required']==1) {

					$data['decided_procedure_completed'] = 0;
					$data['final_completion_date'] = '';
					if(!empty($data['order_supplied_date'])) {

						$data['decided_procedure_completed'] = 1;
						$data['final_completion_date'] = date('Y-m-d');
					}
				} else {

					$data['decided_procedure_completed'] = 1;
					$data['final_completion_date'] = date('Y-m-d');
					$data['certified_copy_applied_date'] = '';
					$data['certified_copy_received_date'] = '';
					$data['order_supplied_date'] = '';
					$data['supplied_via'] = '';
					$data['alongwith_lcr'] = '';
				}

				if ($this->ClientCase->save($data)) {

					$result = array('status' => 'success');
				} else {

					$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
				}
			} else {

				$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
			}
		}

		echo json_encode($result);
		exit;
	}

	public function checkCaseDetails($caseDetails)
	{
		if((isset($caseDetails['ClientCase']['user_id']) && $caseDetails['ClientCase']['user_id']!=$this->Session->read('UserInfo.lawyer_id')) || !empty($caseDetails['ClientCase']['is_deleted'])) {

			$this->Flash->error(__("The selected case doesn't exist or deleted. Please, try with valid record."));

			return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
		}
	}

	public function view($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'View Case';
		$this->set("pageTitle", $this->pageTitle);
		$this->set('caseId',$caseId);

		$this->loadModel('ClientCase', 'Court');
		$this->ClientCase->contain('CaseStatus', 'CaseType', 'CaseProceeding', 'CaseFiling', 'Dispatch');
		//$this->ClientCase->contain('CasePayment', 'CasePayment.PaymentMethod', 'CaseFiling', 'CaseStatus');
		$caseDetails = $this->ClientCase->read(null, $caseId);
		$this->checkCaseDetails($caseDetails);
		$this->set('caseDetails',$caseDetails);

		$this->ClientCases = $this->Components->load('ClientCases');
		$this->set("essentialWorksArr", $this->ClientCases->listEssentialWorks($caseDetails['ClientCase']['client_type']));

		$this->loadModel('CaseProceeding');
		$this->set("pendingProceeding", $this->CaseProceeding->find('first', array(
			'conditions' => array(
				'client_case_id' => $caseId,
				'proceeding_status' => 'pending'
			),
			'fields' => array('date_of_hearing'),
			'order' => 'date_of_hearing DESC'
		)));

		$this->set('connectedCases',$this->getConnectedCases($caseDetails));
	}

	public function view_print($caseId)
	{
		$this->layout = '';
		$this->pageTitle = 'View Case';
		$this->set("pageTitle", $this->pageTitle);
		$this->set('caseId',$caseId);

		$this->loadModel('ClientCase', 'Court');
		$this->ClientCase->contain('CaseStatus', 'CaseType', 'CaseProceeding', 'CaseFiling', 'Dispatch');
		//$this->ClientCase->contain('CasePayment', 'CasePayment.PaymentMethod', 'CaseFiling', 'CaseStatus');
		$caseDetails = $this->ClientCase->read(null, $caseId);
		$this->checkCaseDetails($caseDetails);
		$this->set('caseDetails',$caseDetails);

		$this->ClientCases = $this->Components->load('ClientCases');
		$this->set("essentialWorksArr", $this->ClientCases->listEssentialWorks($caseDetails['ClientCase']['client_type']));

		$this->loadModel('CaseProceeding');
		$this->set("pendingProceeding", $this->CaseProceeding->find('first', array(
			'conditions' => array(
				'client_case_id' => $caseId,
				'proceeding_status' => 'pending'
			),
			'fields' => array('date_of_hearing'),
			'order' => 'date_of_hearing DESC'
		)));

		$this->set('connectedCases',$this->getConnectedCases($caseDetails));
	}

	public function getConnectedCases($caseDetails)
	{
		$result = array();
		if(isset($caseDetails['ClientCase'])) {

			$this->loadModel('ClientCase');
			$caseId = $caseDetails['ClientCase']['id'];

			$parentId = $caseDetails['ClientCase']['parent_case_id'];
			if(!empty($parentId)) {

				$parentCase = $this->ClientCases->findByCaseId($parentId, $this->Session->read('UserInfo.lawyer_id'));

				$result['is_child_case'] = true;
				$result['parent_case'] = $parentCase;

				$otherConnectedCases = $this->ClientCase->find('all', array(
					'conditions' => array(
						'ClientCase.parent_case_id' => $parentId,
						'ClientCase.id <>' => $caseId,
						'ClientCase.user_id' => $this->Session->read('UserInfo.lawyer_id')
					),
					'order' => 'ClientCase.created ASC'
				));

				$result['other_connected_cases'] = $otherConnectedCases;
			} else {

				$childCases = $this->ClientCase->find('all', array(
					'conditions' => array(
						'ClientCase.parent_case_id' => $caseId,
						'ClientCase.user_id' => $this->Session->read('UserInfo.lawyer_id')
					),
					'order' => 'ClientCase.created ASC'
				));

				if(!empty($childCases)) {

					$result['is_parent_case'] = true;
					$result['child_cases'] = $childCases;
				}
			}
		}

		return $result;
	}

	/**
	 * delete the given ID from DB and its associated attachment from AWS.
	 *
	 * @param string $id
	 */
	public function delete($id = null)
	{
		$this->loadModel('ClientCase');
		$caseData = $this->ClientCase->find('first', array('conditions' => array('ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'ClientCase.id' => $id)));
		if (!empty($caseData)) {
		
			if ($this->request->is(array('get', 'delete'))) {

				$caseInfo = array();
				$caseInfo['ClientCase']['id'] = $id;
				$caseInfo['ClientCase']['is_deleted'] = 1;
				$caseInfo['ClientCase']['parent_case_id'] = NULL;

				if ($this->ClientCase->save($caseInfo)) {
				
					$this->ClientCase->updateAll(array('ClientCase.parent_case_id' => NULL), array('ClientCase.parent_case_id'=> $id));				
					$this->Flash->success(__('Case has been deleted successfully.'));
				} else {
					$this->Flash->error(__('Case could not be deleted. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The selected http method is not allowed.'));
			}
		} else {
			$this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
		}

		return $this->redirect(Router::url($this->referer(), true));
	}

	public function restore($id = null)
	{
		$this->loadModel('ClientCase');
		$caseData = $this->ClientCase->find('first', array('conditions' => array('ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'ClientCase.id' => $id)));
		if (!empty($caseData)) {

			if ($this->request->is(array('get', 'restore'))) {

				$caseInfo = array();
				$caseInfo['ClientCase']['id'] = $id;
				$caseInfo['ClientCase']['is_deleted'] = 0;

				if ($this->ClientCase->save($caseInfo)) {

					$this->Flash->success(__('Case has been restored successfully.'));
				} else {
					$this->Flash->error(__('Case could not be restored. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The selected http method is not allowed.'));
			}
		} else {
			$this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
		}

		return $this->redirect(Router::url($this->referer(), true));
	}
}