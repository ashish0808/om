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
	public $helpers = array("Form", "Js" => array('Jquery'), 'Validation', 'Session');
	//JS and Validation helpers are not in Use right now

	public $components = array('Paginator', 'Flash', 'Session', 'RequestHandler', 'Email');

	public function manage($listType = '')
	{
		echo Router::url( $this->referer(), true ); die;
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

		$criteriaStr = 'ClientCase.user_id='.$this->getLawyerId().' AND ClientCase.is_main_case=1';

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

	public function index()
	{
		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
		} else {
			$this->layout = 'basic';
		}

		$this->loadModel('ClientCase');

		$this->pageTitle = 'Manage Cases';
		$this->set("pageTitle", $this->pageTitle);

		$fields = array();

		if (isset($this->data['ClientCase']['stage']) && !empty($this->data['ClientCase']['stage'])) {
			$this->bulkAction($this->data['ClientCase']['stage']);
		}

		$paginateLimit = LIMIT;
		if (isset($this->request->data) && !empty($this->request->data)) {
			foreach ($this->request->data['ClientCase'] as $key => $value) {
				if (!empty($value)) {
					$this->request->params['named'][$key] = base64_encode($value);
				}
			}
		}

		if (isset($this->request->params['named']) && !empty($this->request->params['named'])) {
			foreach ($this->request->params['named'] as $key => $value) {
				if (!empty($value)) {
					$this->request->data['ClientCase'][$key] = base64_decode($value);
					if ($key == 'paging_limit') {
						$paginateLimit = base64_decode($value);
					}
				}
			}
		}

		$criteria = "";
		$criteria .= "1=1";
		if (isset($this->data) || !empty($this->params['named'])) {
			if (isset($this->data['ClientCase']['client_name']) && ($this->data['ClientCase']['client_name'] != '')) {
				$criteria .= " AND (ClientCase.client_first_name LIKE '%" . $this->data['ClientCase']['client_name'] . "%' OR ClientCase.client_last_name LIKE '%" . $this->data['ClientCase']['client_name'] . "%')";
			} elseif (isset($this->params['named']['client_name']) && $this->params['named']['client_name'] != '') {
				if (!isset($this->data['ClientCase']['client_name'])) {
					$criteria .= " AND (ClientCase.first_name LIKE '%" . $this->params['named']['client_name'] . "%' OR ClientCase.last_name LIKE '%" . $this->params['named']['client_name'] . "%')";
				}
			}

			if (isset($this->data['ClientCase']['client_email']) && ($this->data['ClientCase']['client_email'] != '')) {
				$criteria .= " AND (ClientCase.client_email LIKE '%" . $this->data['ClientCase']['client_email'] . "%')";
			} elseif (isset($this->params['named']['client_email']) && $this->params['named']['client_email'] != '') {
				if (!isset($this->data['ClientCase']['client_email'])) {
					$criteria .= " AND (ClientCase.client_email LIKE '%" . $this->params['named']['client_email'] . "%')";
				}
			}

			if (isset($this->data['ClientCase']['opponent_name']) && ($this->data['ClientCase']['opponent_name'] != '')) {
				$criteria .= " AND (ClientCase.opponent_first_name LIKE '%" . $this->data['ClientCase']['opponent_name'] . "%' OR ClientCase.opponent_last_name LIKE '%" . $this->data['ClientCase']['opponent_name'] . "%')";
			} elseif (isset($this->params['named']['opponent_name']) && $this->params['named']['opponent_name'] != '') {
				if (!isset($this->data['ClientCase']['opponent_name'])) {
					$criteria .= " AND (ClientCase.first_name LIKE '%" . $this->params['named']['opponent_name'] . "%' OR ClientCase.last_name LIKE '%" . $this->params['named']['opponent_name'] . "%')";
				}
			}
		}

		$this->Paginator->settings = array(
			'conditions' => array('ClientCase.is_deleted' => 0),
			'page' => 1,
			'limit' => $paginateLimit,
			'fields' => $fields,
			'order' => array('ClientCase.id' => 'desc'),
			//'contain' => array('Customer' => array('Country', 'State', 'City'))
		);
		$records = $this->Paginator->paginate('ClientCase', $criteria);

		$this->set('records', $records);
		$this->set('paginateLimit', $paginateLimit);
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

		$this->loadModel('Court');
		$courts = $this->Court->listCourts();
		$this->set("courts", $courts);
	}

	public function edit($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Edit Case';
		$this->set("pageTitle", $this->pageTitle);
		$this->set('caseId',$caseId);

		$this->loadModel('ClientCase');
		$caseDetails = $this->ClientCase->read(null, $caseId);
		$this->set('caseDetails', $caseDetails);
	}

	public function ajaxEdit($caseId)
	{
		$this->layout = 'ajax';

		$this->loadModel('ClientCase');

		$this->ClientCase->contain('CasePayment', 'CasePayment.PaymentMethod', 'CaseFiling', 'CaseStatus', 'CaseProceeding');
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

					$this->ClientCase->contain('CasePayment');
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

		$this->ClientCase->contain('CasePayment');
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

				$this->ClientCase->contain('CasePayment');
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

			if(empty($_FILES['file']['tmp_name'])) {

				$result['status'] = 'error';
				$result['message']['main_file'][] = 'Please upload case file';
			} elseif (isset($_FILES['file']) && $_FILES['file']['error'] > 0) {

				$result['status'] = 'error';
				$result['message']['main_file'][] = $_FILES['file']['error'];
			}

			if($result['status'] == 'success') {

				$data = $this->request->data['CaseFiling'];
				$data['client_case_id'] = $caseId;
				$this->CaseFiling->save($data);

				$sourceFile = $_FILES['file']['tmp_name'];
				$fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$_FILES['file']['name'];
				// Upload file to S3
				$this->Aws->upload($sourceFile, $fileKey);

				$this->loadModel('ClientCase');
				$caseDetails = $this->ClientCase->read(null, $caseId);

				if(!empty($caseDetails['ClientCase']['main_file'])) {

					// Delete previous attached file
					$this->Aws->delete($caseDetails['ClientCase']['main_file']);
				}

				$this->ClientCases = $this->Components->load('ClientCases');
				$case_status = $this->ClientCases->updateCaseStatus('pending_for_registration');

				$this->ClientCase->updateAll(array('case_status' => $case_status, 'main_file' => "'$fileKey'"), array('ClientCase.id'=> $caseId));
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

			if (isset($_FILES['file']) && $_FILES['file']['error'] > 0) {

				$result = array('status' => 'error', 'message' => array(
					'main_file' => array($_FILES['file']['error'])
				));
			}

			if($result['status'] == 'success') {

				$data = $this->request->data['CaseFiling'];
				$this->CaseFiling->save($data);

				if(!empty($_FILES['file']['tmp_name'])) {

					$sourceFile = $_FILES['file']['tmp_name'];
					$fileKey = time().'-'.$this->Session->read('UserInfo.uid').'-'.$_FILES['file']['name'];
					// Upload file to S3
					$this->Aws->upload($sourceFile, $fileKey);

					$this->loadModel('ClientCase');

					if(!empty($caseDetails['ClientCase']['main_file'])) {

						// Delete previous attached file
						$this->Aws->delete($caseDetails['ClientCase']['main_file']);
					}

					$this->ClientCase->updateAll(array('main_file' => "'$fileKey'"), array('ClientCase.id'=> $caseId));
				}
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

	public function view($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'View Case';
		$this->set("pageTitle", $this->pageTitle);
		$this->set('caseId',$caseId);

		$this->loadModel('ClientCase', 'Court');
		$this->ClientCase->contain('CaseStatus', 'CaseType');
		$caseDetails = $this->ClientCase->read(null, $caseId);
		$this->set('caseDetails',$caseDetails);

		$this->loadModel('CaseProceeding');
		$this->set("pendingProceeding", $this->CaseProceeding->find('first', array(
			'conditions' => array(
				'client_case_id' => $caseId,
				'proceeding_status' => 'pending'
			),
			'fields' => array('date_of_hearing'),
			'order' => 'date_of_hearing DESC'
		)));
	}
}