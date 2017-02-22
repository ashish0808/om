<?php

class CasesController extends AppController
{
	public $helpers = array("Form", "Js" => array('Jquery'), 'Validation');
	//JS and Validation helpers are not in Use right now

	public $components = array('RequestHandler', 'Email');

	public function manage()
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

				if ($this->ClientCase->save($data)) {

					$caseId = $this->ClientCase->getLastInsertId();

					$this->Session->setFlash(CASE_INFORMATION_ADDED);
					$this->redirect(array('controller' => 'cases', 'action' => 'edit', $caseId));
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
	}

	public function ajaxEdit($caseId)
	{
		$this->layout = 'ajax';

		$this->loadModel('ClientCase');

		$this->ClientCase->contain('CasePayment', 'CasePayment.PaymentMethod');
		$caseDetails = $this->ClientCase->read(null, $caseId);

		//pr($caseDetails); die;

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

		$this->set("defaultCollapseIn", $defaultCollapseIn);
	}

	public function editBasicDetails($caseId)
	{
		$this->layout = 'ajax';
		$this->loadModel('ClientCase');

		$result = array('status' => 'error', 'message' => 'Unable to process data');
		if ($this->request->data) {

			$this->ClientCase->set($this->request->data);
			if ($this->ClientCase->validates()) {

				$this->ClientCases = $this->Components->load('ClientCases');
				$data = $this->ClientCases->prepareAddCaseData($this->request->data['ClientCase']);

				if ($this->ClientCase->save($data)) {

					$this->setFlashCaeUpdated($this->request->data);
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

					$this->setFlashCaeUpdated($this->request->data);
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

	public function addPayment($caseId, $casePaymentId)
	{
		$this->layout = 'ajax';

		$this->loadModel('CasePayment');

		if ($this->request->data) {

			$this->CasePayment->set($this->request->data);
			if ($this->CasePayment->validates()) {

				$data = $this->request->data['CasePayment'];

				if ($this->ClientCase->save($data)) {

					$this->setFlashCaeUpdated($this->request->data);
					$result = array('status' => 'success');
				}
			} else {

				$result = array('status' => 'error', 'message' => $this->ClientCase->validationErrors);
			}
		}



		if(!empty($casePaymentId)) {

			$this->request->data['CasePayment'] = $this->CasePayment->find('first', array(
				'conditions' => array(
					'client_case_id' => $caseId,
					'id' => $casePaymentId
				)
			));
		}

		$this->set('caseId',$caseId);
		$this->set('casePaymentId',$casePaymentId);
	}

	public function getLawyerId()
	{
		return $this->Session->read('UserInfo.lawyer_id');
	}

	private function setFlashCaeUpdated($data)
	{
		$formBtn = $data['ClientCase']['submit'];
		if($formBtn!='next') {

			$this->Session->setFlash('<span class="setFlash success">Case updated successfully.</span>');
		}
	}

	private function ifSavedIncomplete($data)
	{
		if($data['submit']=='saveIncomplete') {

			$data['saved_incomplete'] = 1;
		}

		return $data;
	}
}