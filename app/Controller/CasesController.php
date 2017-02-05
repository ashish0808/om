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
	    }else{
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

    public function add($caseId=null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Case';
	    if(!empty($caseId)) {
		    $this->pageTitle = 'Edit Case';
	    }

        $this->set("pageTitle", $this->pageTitle);

	    $this->loadModel('Case');
	    //$this->loadModel('CaseHearing');
	    $this->loadModel('CasePayment');

	    if($this->request->data){
		    //pr($this->request->data); die;
		    if ($this->Case->validates()) {
			    //$hearingDate = $this->dateTimeSqlFormat($this->request->data['CaseHearing']['date']);
			    $this->request->data['Case']['next_hearing_date'] = '';
			    if ($this->Case->save($this->request->data)) {
				    if(empty($caseId)) {
					    $caseId = $this->Case->getLastInsertId();
				    }

				    $this->Session->setFlash(CASE_INFORMATION_ADDED);
				    $this->redirect(array('controller' => 'cases', 'action' => 'manage'));
			    }
		    }
	    }
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

  	function delete($id=null) {
    		$this->loadModel('Case');
    		$this->Case->id = $id;
    		$data['Case']['is_deleted'] = 1;
    		if($this->Case->save($data,array('validate'=>false))) {
    			$this->Session->setFlash(CASE_DELETED);
    		} else {
    			$this->Session->setFlash(ERROR_OCCURRED);
    		}
    		$this->redirect($this->referer());
  	}
}