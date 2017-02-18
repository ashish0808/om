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
		//echo '<pre>'; print_r($records); die;
		$this->set('records', $records);
		$this->set('paginateLimit', $paginateLimit);
	}

	public function add()
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Add Case';

		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('ClientCase');
		//$this->loadModel('CaseHearing');
		$this->loadModel('CasePayment');

		if ($this->request->data) {
			//pr($this->request->data); die;
			if ($this->ClientCase->validates()) {

				$this->request->data['ClientCase']['user_id'] = $this->getLawyerId();

				$this->ClientCases = $this->Components->load('ClientCases');
				$data = $this->ClientCases->prepareAddCaseData($this->request->data['ClientCase']);

				if ($this->ClientCase->save($data)) {

					$caseId = $this->ClientCase->getLastInsertId();

					$this->Session->setFlash(CASE_INFORMATION_ADDED);
					$this->redirect(array('controller' => 'cases', 'action' => 'edit', $caseId));
				} /*else {

					pr($this->ClientCase->validationErrors, true); die;
				}*/
			}/* else {

				pr($this->validationErrors['ClientCase']); die;
			}*/
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

	public function getLawyerId()
	{
		return $this->Session->read('UserInfo.lawyer_id');
	}

	public function edit($caseId)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Edit Case';

		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('ClientCase');
		//$this->loadModel('CaseHearing');
		$this->loadModel('CasePayment');

		if ($this->request->data) {
			//pr($this->request->data); die;
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


		$this->ClientCase->editCaseRequiredModelJoins();
		$caseDetails = $this->ClientCase->read(null, $caseId);
		$this->request->data['ClientCase'] = $caseDetails['ClientCase'];

		$this->set('caseDetails',$caseDetails);
		$this->set('caseId',$caseId);

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

	public function ajaxEdit($caseId)
	{
		$this->layout = 'ajax';

		$this->loadModel('ClientCase');

		$this->ClientCase->editCaseRequiredModelJoins();
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
	}

	function bulkAction($statusValue)
	{
		if (isset($statusValue) && !empty($statusValue)) {
			$data = array();
			$data['Case']['stage'] = $statusValue;

			for ($i = 0; $i < count($_POST['box']); $i++) {
				$this->Case->id = $_POST['box'][$i];
				$this->Case->save($data, array('validate' => false));
			}

			$this->Session->setFlash('<span class="setFlash success">Case ' . $statusValue . ' successfully.</span>');
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	function delete($id = null)
	{
		$this->loadModel('Case');
		$this->Case->id = $id;
		$data['Case']['is_deleted'] = 1;
		if ($this->Case->save($data, array('validate' => false))) {
			$this->Session->setFlash(CASE_DELETED);
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}
}