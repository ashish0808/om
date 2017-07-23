<?php
class AdminsController extends AppController
{
    public $components = array('RequestHandler', 'Flash');
    //public $helpers = array('Validation','Js');
    public $helpers = array('Js' => array('Jquery'));

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function add()
    {
        $this->layout = 'add';
    }

    public function manage()
    {
        $this->layout = 'main';
    }

    public function manageLawyers()
    {
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'admin';
        }

        $this->loadModel('User');

        $this->pageTitle = 'Lawyers Management';
        $this->set("pageTitle", $this->pageTitle);

        $conditions = array('User.user_type' => 2, 'User.is_deleted' => 0);
        $fields = array();

        if (isset($this->data['User']['status']) && !empty($this->data['User']['status'])) {
            $this->lawyersBulkAction($this->data['User']['status']);
        }

        $paginateLimit = LIMIT;
        if (isset($this->request->data) && !empty($this->request->data)) {
            foreach ($this->request->data['User'] as $key => $value) {
                if (!empty($value)) {
                    $this->request->params['named'][$key] = base64_encode($value);
                }
            }
        }

        if (isset($this->request->params['named']) && !empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] as $key => $value) {
                if (!empty($value)) {
                    $this->request->data['User'][$key] = base64_decode($value);
                    if ($key == 'paging_limit') {
                        $paginateLimit = base64_decode($value);
                    }
                }
            }
        }
        
        $criteria = "";
        $criteria .= " User.user_type=2 AND User.is_deleted=0";
        if (isset($this->data['User']) || !empty($this->params['named'])) {

            if (isset($this->data['User']['first_name']) && ($this->data['User']['first_name'] != '')) {
                $criteria .= " AND User.first_name LIKE '%" . $this->data['User']['first_name'] . "%'";
            } elseif (isset($this->params['named']['first_name']) && $this->params['named']['first_name'] != '') {
                if (!isset($this->data['User']['first_name'])) {
                    $criteria .= " AND User.first_name LIKE '%" . $this->params['named']['first_name'] . "%'";
                }
            }

            if (isset($this->data['User']['last_name']) && ($this->data['User']['last_name'] != '')) {
                $criteria .= " AND User.last_name LIKE '%" . $this->data['User']['last_name'] . "%'";
            } elseif (isset($this->params['named']['last_name']) && $this->params['named']['last_name'] != '') {
                if (!isset($this->data['User']['last_name'])) {
                    $criteria .= " AND User.last_name LIKE '%" . $this->params['named']['last_name'] . "%'";
                }
            }

            if (isset($this->data['User']['email']) && ($this->data['User']['email'] != '')) {
                $criteria .= " AND User.email LIKE '%" . $this->data['User']['email'] . "%'";
            } elseif (isset($this->params['named']['email']) && $this->params['named']['email'] != '') {
                if (!isset($this->data['User']['email'])) {
                    $criteria .= " AND User.email LIKE '%" . $this->params['named']['email'] . "%'";
                }
            }
        }

        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'page' => 1,
            'limit' => $paginateLimit,
            'fields' => $fields,
            'order' => array('User.id' => 'desc'),
            //'contain' => array('Customer' => array('Country', 'State', 'City'))
        );
        $records = $this->Paginator->paginate('User', $criteria);
        
        $this->set('records', $records);
        $this->set('paginateLimit', $paginateLimit);
    }

    public function addLawyerOld()
    {
        $this->layout = 'admin';
        $this->pageTitle = 'Add Lawyer';
        $this->set("pageTitle", $this->pageTitle);

        App::import('model', 'Plan');
        $modelPlan = new Plan();
        $listPlans = $modelPlan->getPlanDetails('list', array(), array('id_amount', 'name'));
        $this->set('listPlans', $listPlans);
		
		App::import('model', 'Coupon');
        $modelCoupon = new Coupon();
        $listCoupons = $modelCoupon->getCouponDetails('list', array(), array('id_value_type', 'name'));
        $this->set('listCoupons', $listCoupons);

        $this->loadModel('User');
        $this->loadModel('Profile');
        $this->loadModel('UserTransaction');
		
		if($this->request->data){
			$isUserValidate = false;
			$isUserProfileValidate = false;
			$isUserTransactionValidate = false;

			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$isUserValidate = true;
			} else {
				$isUserValidate = false;
			}

			$this->Profile->set($this->request->data);
			if ($this->Profile->validates()) {
				$isUserProfileValidate = true;
			} else {
				$isUserProfileValidate = false;
			}

			$this->UserTransaction->set($this->request->data);
			if ($this->UserTransaction->validates()) {
				$isUserTransactionValidate = true;
			} else {
				$isUserTransactionValidate = false;
			}
			
			if ($isUserValidate && $isUserProfileValidate && $isUserTransactionValidate) {
				if(isset($this->request->data['UserTransaction']['plan_id']) && !empty($this->request->data['UserTransaction']['plan_id'])){
					$this->request->data['UserTransaction']['plan_id'] = strstr($this->request->data['UserTransaction']['plan_id'],'_',true);
				}
				//pr($this->request->data); die;
				$this->request->data['User']['user_type'] = 2;
				$planDetails = $modelPlan->getPlanDetails('first', array('Plan.id' => $this->request->data['UserTransaction']['plan_id']), array());
				$planExpiryDate = '';
				if (isset($planDetails['Plan']['no_of_days']) && !empty($planDetails['Plan']['no_of_days'])) {
					$planExpiryDate = date('Y-m-d H:i:s', strtotime("+" . $planDetails['Plan']['no_of_days'] . " days"));
				}
				$this->request->data['User']['plan_expiry_date'] = $planExpiryDate;
				$this->request->data['User']['created_by'] = $this->Session->read("uid");
				if ($this->User->save($this->request->data)) {
					$lastInsertedId = $this->User->getLastInsertId();
					$this->request->data['Profile']['user_id'] = $lastInsertedId;
					$this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
					$this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
					$this->request->data['Profile']['email'] = $this->request->data['User']['email'];
					if ($this->Profile->save($this->request->data)) {
						$this->request->data['UserTransaction']['user_id'] = $lastInsertedId;
						if (!empty($planExpiryDate)) {
							if(isset($this->request->data['UserTransaction']['coupon_id']) && !empty($this->request->data['UserTransaction']['coupon_id'])){
								$this->request->data['UserTransaction']['coupon_id'] = strstr($this->request->data['UserTransaction']['coupon_id'],'_',true);
							}
							$couponDetails = $modelCoupon->getCouponDetails('first', array('Coupon.id' => $this->request->data['UserTransaction']['coupon_id']), array());
							
							$transactionDetails = array();
							$transactionDetails['user_name'] = $this->request->data['User']['first_name'].' '.$this->request->data['User']['last_name'];
							$transactionDetails['plan_description'] = $planDetails['Plan']['description'];
							$this->request->data['UserTransaction']['details'] = json_encode($transactionDetails);
							$this->request->data['UserTransaction']['plan_name'] = $planDetails['Plan']['name'];
							//$this->request->data['UserTransaction']['plan_description'] = $planDetails['Plan']['plan_description'];
							$this->request->data['UserTransaction']['no_of_days'] = $planDetails['Plan']['no_of_days'];
							$this->request->data['UserTransaction']['plan_expiry_date'] = $planExpiryDate;
							$this->request->data['UserTransaction']['created_by'] = $this->Session->read("UserInfo.uid");
							$discountAmount = 0;
							if (isset($couponDetails['Coupon']['type']) && !empty($couponDetails['Coupon']['type'])) {
								$discountType = $couponDetails['Coupon']['type'];
								switch ($discountType) {
									case 1:
										$discountAmount = $couponDetails['Coupon']['value'] / 100 * $planDetails['Plan']['price'];
										break;
									case 2:
										$discountAmount = $couponDetails['Coupon']['value'];
										break;
								}
								
								$this->request->data['UserTransaction']['discount_type'] = $couponDetails['Coupon']['type'];
								$this->request->data['UserTransaction']['discount_value'] = $couponDetails['Coupon']['value'];
							}
							$this->request->data['UserTransaction']['amount'] = $planDetails['Plan']['price'] - $discountAmount;
							$this->request->data['UserTransaction']['discount_amount'] = $discountAmount;
						}
						if ($this->UserTransaction->save($this->request->data)) {
							$this->Session->setFlash(Configure::read('LAWYER_ADDED'));
							$this->redirect(array('controller' => 'admins', 'action' => 'manageLawyers'));
						}
					}
				}
			} else {
				$userTblValidationErrors = $this->User->validationErrors;
				$userProfileTblValidationErrors = $this->Profile->validationErrors;
				$userUserTransactionTblValidationErrors = $this->UserTransaction->validationErrors;
				$this->request->data += array_merge($userTblValidationErrors, $userProfileTblValidationErrors, $userUserTransactionTblValidationErrors);
			}
		}
    }
    
    public function addLawyer()
    {
      $this->layout = 'admin';
      $this->pageTitle = 'Add Lawyer';
      $this->set("pageTitle", $this->pageTitle);
      $this->loadModel('User');		
	    if($this->request->data){
	       
        $this->User->set($this->request->data);
		    if ($this->User->validates()) {
        		    
			    $this->request->data['User']['user_type'] = 2;				
			    $this->request->data['User']['created_by'] = $this->Session->read('UserInfo.uid');
			    if ($this->User->save($this->request->data)) {
			    
						$this->Flash->success(__('Lawyer added successfully.'));
						$this->redirect(array('controller' => 'admins', 'action' => 'manageLawyers'));					
				  }
			  }
		  }
    }
    
    public function editLawyer($id)
    {
        $this->layout = 'admin';
        $this->pageTitle = 'Edit Lawyer';
        $this->set("pageTitle", $this->pageTitle);

        $this->loadModel('User');		
    		if($this->request->data){
    
    			$this->User->set($this->request->data);    			
    			if ($this->User->validates()) {
    			
    				$this->request->data['User']['created_by'] = $this->Session->read('UserInfo.uid');
    				if ($this->User->save($this->request->data)) {
    					
    					$this->Flash->success(__('Lawyer updated successfully.'));    						
    					$this->redirect(array('controller' => 'admins', 'action' => 'manageLawyers'));
    				}
    			}
    		} else {
          
            $this->request->data = $this->User->read(null, $id);
        }
        
	      $this->set('id',$id);
    }
    

	public function editLawyerOld($id)
    {
        $this->layout = 'admin';
        $this->pageTitle = 'Edit Lawyer';
        $this->set("pageTitle", $this->pageTitle);

        $this->loadModel('User');
        $this->loadModel('Profile');
		
		if($this->request->data){
			$isUserValidate = false;
			$isUserProfileValidate = false;

			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$isUserValidate = true;
			} else {
				$isUserValidate = false;
			}

			$this->Profile->set($this->request->data);
			if ($this->Profile->validates()) {
				$isUserProfileValidate = true;
			} else {
				$isUserProfileValidate = false;
			}
			
			if ($isUserValidate && $isUserProfileValidate) {
				$this->request->data['User']['created_by'] = $this->Session->read("uid");
				if ($this->User->save($this->request->data)) {
					$this->request->data['Profile']['user_id'] = $id;
					$this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
					$this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
					$this->request->data['Profile']['email'] = $this->request->data['User']['email'];
					if ($this->Profile->save($this->request->data)) {
						$this->Session->setFlash(LAWYER_UPDATED);
						$this->redirect(array('controller' => 'admins', 'action' => 'manageLawyers'));
					}
				}
			} else {
				$userTblValidationErrors = $this->User->validationErrors;
				$userProfileTblValidationErrors = $this->Profile->validationErrors;
				$this->request->data += array_merge($userTblValidationErrors, $userProfileTblValidationErrors);
			}
		}
		$this->request->data = $this->User->read(null, $id);
		//pr($this->request->data);
	    $this->set('id',$id);
    }
	
    function lawyersBulkAction($statusValue)
    {
        if (isset($statusValue) && !empty($statusValue)) {
			$data = array();
			switch ($statusValue) {
                case 1:
                    $action = 'Activated';
					$data['User']['status'] = $statusValue;
                    break;
                case 2:
                    $action = 'Deactivated';
					$data['User']['status'] = $statusValue;
                    break;
                case 3:
                    $action = 'Deleted';
					$data['User']['is_deleted'] = 1;
                    break;
            }
		
            for ($i = 0; $i < count($_POST['box']); $i++) {
                $this->User->id = $_POST['box'][$i];
                $data['User']['modified_by'] = $this->Session->read("uid");
                $this->User->save($data, array('validate' => false));
            }
            
            $this->Session->setFlash('<span class="setFlash success">Lawyers ' . $action . ' successfully.</span>');
        } else {
            $this->Session->setFlash(ERROR_OCCURRED);
        }
        $this->redirect($this->referer());
    }
	
	function deleteLawyer($id=null) {
		$this->loadModel('User');
		$this->User->id = $id;
		$data['User']['is_deleted'] = 1;
		if($this->User->save($data,array('validate'=>false))) {
			
			$this->Flash->success(__('Lawyer deleted successfully.'));
		} else {
		
		  $this->Flash->error(__('Lawyer could not be deleted. Please, try again.'));
		}
		
		$this->redirect($this->referer());
	}
}