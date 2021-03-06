<?php

class UsersController extends AppController
{
    public $helpers = array('Form', 'Js' => array('Jquery'), 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Flash', 'Email', 'SendEmail');

    /**
     * Function performs two actions i.e. Login and Forgot Password.
     */
    public function login()
    {
        $this->layout = 'login';
        $this->pageTitle = SITE_NAME;
        $this->set('pageTitle', $this->pageTitle);
        $this->set('token', $this->generateToken());

        App::import('model', 'User');
        $userModel = new User();
        if (!$this->Session->read('uid')) {
            if ($this->request->data) {
                $this->User->set($this->request->data);
                if ($this->request->data['User']['action'] == 'login') {
                    $this->User->validate = $this->User->validateLogin;
                    if ($this->User->validate) {
                        $userModel->userSessionRequiredModelJoins();

                        $this->User->recursive = 3;

                        $userDetails = $userModel->getDetails('first', array('User.email' => $this->request->data['User']['login_email'], 'User.user_pwd' => $this->request->data['User']['user_pwd']), array('id', 'first_name', 'last_name', 'email', 'user_type', 'status', 'is_deleted', 'is_forgot'));

                        if ($userDetails) {
                            if (!$userModel->isUserActive($userDetails)) {
                                $this->Session->setFlash(Configure::read('INACTIVE_USER'));
                                $this->redirect(array('controller' => 'users', 'action' => 'login'));
                            }

                            if ($userModel->isUserDeleted($userDetails)) {
                                $this->Session->setFlash(Configure::read('DELETED_USER'));
                                $this->redirect(array('controller' => 'users', 'action' => 'login'));
                            }

                            $this->writeUserSession($userDetails);

                            $this->User->id = $userDetails['User']['id'];
                            $userInfo['User']['last_login'] = time(); //date(Configure::read('DB_DATE_FORMAT'));
                            $userInfo['User']['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                            $userInfo['User']['is_forgot'] = 0;
                            $userInfo['User']['forgot_password_key'] = '';
                            $userInfo['User']['forgot_password_time'] = null;
                            $this->User->save($userInfo, array('validate' => false));

                            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                            exit();
                        } else {
                            $this->Session->setFlash(Configure::read('USER_NOT_FOUND'));
                        }
                    }
                }
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }
    }

    /**
     * Destroys all sessions of logged in user.
     */
    public function logout()
    {
        $this->Session->delete('UserInfo');
        $this->Session->destroy();
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
        exit();
    }
	
	public function register()
    {
		//ALTER TABLE `users` ADD `register_key` VARCHAR(100) NULL AFTER `forgot_password_key`;
		//ALTER TABLE `users` ADD `plan_expiry_date` DATETIME NULL AFTER `register_key`;
		
        $this->layout = 'login';
        $this->pageTitle = 'Register';
        $this->set('pageTitle', $this->pageTitle);
        $this->set('token', $this->generateToken());
		
		$this->loadModel('User');
		
        if (!$this->Session->read('uid')) {
            if ($this->request->data) {
                $this->User->set($this->request->data);
				if ($this->User->validates()) {
					
					$registerKey = md5($this->request->data['User']['email'].'_'.time());
					
					$this->request->data['User']['register_key'] = $registerKey;
					$this->request->data['User']['status'] = 2;
					$this->request->data['User']['user_type'] = 2;				
					$this->request->data['User']['created_by'] = NULL;
					if ($this->User->save($this->request->data)) {
						
						$this->SendEmail = $this->Components->load('SendEmail');

						$activateAccountUrl = Router::url([
							'controller' => 'users',
							'action' => 'activate',
							$registerKey,
						], true);

						$emailData = array('User' => $this->request->data['User'], 'registerKey' => $activateAccountUrl);
						$this->SendEmail->send($emailData, 'ACTIVATE_ACCOUNT');
					
						$this->Flash->success(__('Please check your email to confirm your account registration.'));
						$this->redirect(array('controller' => 'users', 'action' => 'register'));
					}
				}
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }
    }
	
	public function activate($activateKey)
    {
        $this->layout = 'login';
        $this->pageTitle = SITE_NAME;
        $this->set('pageTitle', $this->pageTitle);

        if (!$this->Session->read('uid')) {
            //echo date("Y-m-d H:i:s"); die;
            App::import('model', 'User');
            $userModel = new User();
            $userDetails = $userModel->getDetails('first', array(
                'User.register_key' => $activateKey,
            ), array('id', 'status', 'last_login'));

            if (empty($userDetails) || !empty($userDetails['User']['last_login']) || $userDetails['User']['status'] != 2) {
                
				$this->Flash->error(__('Invalid URL'));
            } else {

				$userInfo = array();
				$userInfo['User']['id'] = $userDetails['User']['id'];
				$userInfo['User']['status'] = 1;
				$userInfo['User']['register_key'] = '';
				
				if ($this->User->save($userInfo, false)) {
					
					$this->Uc = $this->Components->load('User');
					$this->Uc->addDemoPlan($userDetails['User']['id']);
					
					$this->Flash->success(__('Account activated, please login!'));
				} else {
					
					$this->Flash->error(__('Unable to activate account, please contact admin!'));
				}
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }

		$this->redirect(array('controller' => 'users', 'action' => 'login'));
		exit();
    }

    /**
     * Displays Dashboard Page as per the User Role.
     */
    public function dashboard()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Dashboard';
        $this->set('pageTitle', $this->pageTitle);
    }

    public function admin_dashboard()
    {
        $this->layout = 'admin';
        $this->pageTitle = 'Dashboard';
        $this->set('pageTitle', $this->pageTitle);
    }

    public function getCasesForDashboard()
    {
        $this->layout = '';
        $this->loadModel('ClientCase');

        $pending_for_filing_count = 0;
        $pending_for_refiling_count = 0;
        $pending_for_registration_count = 0;

        $pending_for_filing_data = [];
        $pending_for_refiling_data = [];
        $pending_for_registration_data = [];

        $caseData = $this->ClientCase->find('all', array('conditions' => array('case_status' => array(PENDING_FOR_FILING, PENDING_FOR_REFILING, PENDING_FOR_REGISTRATION), 'ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'is_deleted' => false), 'order' => 'limitation_expires_on asc'));
        if (!empty($caseData)) {
            foreach ($caseData as $key => $value) {
                if ($value['ClientCase']['case_status'] == PENDING_FOR_FILING) {
                    if ($pending_for_filing_count < 5) {
                        $pending_for_filing_data[] = $caseData[$key];
                        ++$pending_for_filing_count;
                    }
                } elseif ($value['ClientCase']['case_status'] == PENDING_FOR_REFILING) {
                    if ($pending_for_refiling_count < 5) {
                        $pending_for_refiling_data[] = $caseData[$key];
                        ++$pending_for_refiling_count;
                    }
                } elseif ($value['ClientCase']['case_status'] == PENDING_FOR_REGISTRATION) {
                    if ($pending_for_registration_count < 5) {
                        $pending_for_registration_data[] = $caseData[$key];
                        ++$pending_for_registration_count;
                    }
                }
            }
        }
        $this->set('pending_for_filing_data', $pending_for_filing_data);
        $this->set('pending_for_filing_count', $pending_for_filing_count);
        $this->set('pending_for_refiling_data', $pending_for_refiling_data);
        $this->set('pending_for_refiling_count', $pending_for_refiling_count);
        $this->set('pending_for_registration_data', $pending_for_registration_data);
        $this->set('pending_for_registration_count', $pending_for_registration_count);
    }

    public function getDecidedCases()
    {
        $this->layout = '';
        $records = $this->__getDecidedCases(5);
        $this->set('decided_cases', $records);
        $this->set('decided_cases_count', count($records));
    }

    public function getDecidedCasesAll()
    {
        $this->layout = 'basic';
        $records = $this->__getDecidedCases(0);
        $this->set('records', $records);
        $this->set('pageTitle', 'Pending Decided Case Procedure');
    }

    private function __getDecidedCases($limit)
    {
        $this->loadModel('ClientCase');
        $records = $this->ClientCase->find('all', array('conditions' => array('case_status' => array(DECIDED), 'ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'decided_procedure_completed' => false, 'certified_copy_required' => true, 'is_deleted' => false), 'limit' => $limit));
        if (!empty($records)) {
            foreach ($records as $key => $value) {
                if (empty($value['ClientCase']['certified_copy_applied_date'])) {
                    $records[$key]['ClientCase']['message'] = 'Apply Certified Copy';
                } elseif (empty($value['ClientCase']['certified_copy_received_date'])) {
                    $records[$key]['ClientCase']['message'] = 'Receive Certified Copy';
                } elseif (!$value['ClientCase']['is_order_supplied_to_party']) {
                    $records[$key]['ClientCase']['message'] = 'Supply Certified Copy to Client';
                }
            }
        }

        return $records;
    }

    public function getCasesWithPendingActions()
    {
        $this->layout = '';

        $cases_with_pending_actions = $this->__getCasesWithPendingActions(5);
        $cases_with_pending_actions_count = count($cases_with_pending_actions);
        $this->set('cases_with_pending_actions', $cases_with_pending_actions);
        $this->set('cases_with_pending_actions_count', $cases_with_pending_actions_count);
    }

    public function getCasesWithPendingActionsAll()
    {
        $this->layout = 'basic';

        $records = $this->__getCasesWithPendingActions(0);
        $this->set('records', $records);
        $this->set('pageTitle', 'Cases with Pending Actions');
    }

    private function __getCasesWithPendingActions($limit)
    {
        $this->loadModel('ClientCase');

        return $this->ClientCase->find('all', array('conditions' => array('case_status' => array(PENDING, ADMITTED), 'ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'OR' => array('is_ememo_filed' => false, 'is_paper_book' => false, 'is_diary_entry' => false, 'is_letter_communication' => false, 'is_lcr' => false, 'is_deleted' => false)), 'limit' => $limit));
    }

    public function getCasesWithNoNextDate()
    {
        $this->layout = '';

        $cases_with_no_next_date = $this->__getCasesWithNoNextDate(5);

        $cases_with_no_next_date_count = count($cases_with_no_next_date);
        $this->set('cases_with_no_next_date', $cases_with_no_next_date);
        $this->set('cases_with_no_next_date_count', $cases_with_no_next_date_count);
    }

    public function getCasesWithNoNextDateAll()
    {
        $this->layout = 'basic';
        $records = $this->__getCasesWithNoNextDate(0);
        $this->set('records', $records);
        $this->set('pageTitle', 'Cases with No Proceeding Date');
    }

    private function __getCasesWithNoNextDate($limit)
    {
        $this->loadModel('CaseProceeding');
        $this->CaseProceeding->bindModel(array('belongsTo' => array('ClientCase' => array('type' => 'INNER'))));

        return $this->CaseProceeding->find('all', array('contain' => array('ClientCase' => array('conditions' => array('ClientCase.case_status' => array(PENDING), 'is_main_case' => true, 'user_id' => $this->Session->read('UserInfo.uid'), 'is_deleted' => false))), 'conditions' => array('proceeding_status' => 'pending', 'next_date_of_hearing' => null, 'date_of_hearing <' => date('Y-m-d')), 'limit' => $limit));
    }

    public function getTodos()
    {
        $this->layout = '';
        $this->loadModel('Todo');

        $todos = $this->Todo->find('all', array('contain' => array('ClientCase' => array('conditions' => array('ClientCase.user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => array('Todo.completion_date <=' => date('Y-m-d'), 'status' => 'pending', 'Todo.user_id' => $this->Session->read('UserInfo.uid')), 'order' => 'Todo.completion_date ASC', 'limit' => 5));
        $todos_count = count($todos);
        $this->set('todos', $todos);
        $this->set('todos_count', $todos_count);
    }

    public function change_password()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Change Password';
        $this->set('pageTitle', $this->pageTitle);

        if (!empty($this->data)) {
            $this->User->set($this->request->data);

            $this->User->validate = $this->User->validateChangePassword;
            if ($this->User->validate) {
                $saveData = array();

                $saveData['User'] = array(
                    'id' => $this->data['User']['id'],
                    'user_pwd' => $this->data['User']['new'],
                );

                if ($this->User->save($saveData)) {
                    $this->Flash->success(__('Password has been changed.'));
                    $this->redirect(array('controller' => 'Users', 'action' => 'change_password'));
                }
            }
        } else {
            $this->data = $this->User->findById($this->Session->read('UserInfo.uid'));
        }
    }

    public function forgot_password()
    {
        $this->layout = 'login';
        $this->pageTitle = SITE_NAME;
        $this->set('pageTitle', $this->pageTitle);
        $this->set('token', $this->generateToken());

        App::import('model', 'User');
        $userModel = new User();

        if (!$this->Session->read('uid')) {
            if ($this->request->data) {
                $this->User->set($this->request->data);

                $this->User->validate = $this->User->validateForgotPassword;
                if ($this->User->validate) {
                    $userDetails = $userModel->getDetails('first', array('User.email' => $this->request->data['User']['forgot_email']), array('id', 'first_name', 'last_name', 'email', 'user_type'));

                    if ($userDetails) {
                        $forgot_password_key = md5($userDetails['User']['email'].'_'.time());
                        $this->SendEmail = $this->Components->load('SendEmail');

                        $resetPasswordUrl = Router::url([
                            'controller' => 'users',
                            'action' => 'reset_password',
                            $forgot_password_key,
                        ], true);

                        $emailData = array('User' => $userDetails['User'], 'forgotPasswordKey' => $resetPasswordUrl);
                        $this->SendEmail->send($emailData, 'FORGOT_PASSWORD');

                        $userInfo = array();
                        $userInfo['User']['id'] = $userDetails['User']['id'];
                        $userInfo['User']['is_forgot'] = 1;
                        $userInfo['User']['forgot_password_key'] = $forgot_password_key;
                        $userInfo['User']['forgot_password_time'] = date('Y-m-d H:i:s');

                        $userModel->updateUserInfo($userInfo, 'User');
                        $this->Flash->success(__('Email sent successfully'));
                    } else {
                        $this->Flash->error(__('The user could not be found. Please fill the correct information'));
                    }
                }

                $this->redirect(array('controller' => 'users', 'action' => 'forgot_password'));
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }
    }

    public function reset_password($resetKey)
    {
        $this->layout = 'login';
        $this->pageTitle = SITE_NAME;
        $this->set('pageTitle', $this->pageTitle);

        if (!$this->Session->read('uid')) {
            //echo date("Y-m-d H:i:s"); die;
            App::import('model', 'User');
            $userModel = new User();
            $userDetails = $userModel->getDetails('first', array(
                'User.forgot_password_key' => $resetKey,
            ), array('id', 'forgot_password_time'));

            if (empty($userDetails) || empty($userDetails['User']['forgot_password_time']) || (strtotime($userDetails['User']['forgot_password_time']) < strtotime(date('Y-m-d H:i:s', strtotime('-2 hours'))))) {
                $this->Flash->error(__('Invalid URL'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }

            if ($this->request->data) {
                $this->User->set($this->request->data);

                $this->User->validate = $this->User->validateResetPassword;
                if ($this->User->validate) {
                    $userInfo = array();
                    $userInfo['User']['id'] = $userDetails['User']['id'];
                    $userInfo['User']['user_pwd'] = $this->data['User']['new'];
                    $userInfo['User']['is_forgot'] = 0;
                    $userInfo['User']['forgot_password_key'] = '';
                    $userInfo['User']['forgot_password_time'] = null;

                    if ($this->User->save($userInfo)) {
                        $this->Flash->success(__('Password has been changed'));
                    }
                }
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }

		$this->set('resetKey', $resetKey);
    }
  
    public function admin_manage()
    {
      if ($this->request->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'admin';
        }
        $this->pageTitle = 'Manage Users';
        $this->set('pageTitle', $this->pageTitle);

        $fields = [];

        $criteria = [];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['User'] as $key => $value) {
                if (!empty($value)) {
                    $criteria[$key] = $value;
                    $this->request->params['named'][$key] = $value;
                }
            }
        }

        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] as $key => $value) {
                if (!in_array($key, ['page', 'sort', 'direction'])) {
                    if (!empty($value)) {
                        $criteria[$key] = $value;
                        $this->request->data['User'][$key] = $value;
                    }
                }
            }
        }

        if (empty($criteria)) {
            $criteria = '1=1';
        }

        $this->Paginator->settings = array(
            'page' => 1,
            'limit' => LIMIT,
            'fields' => $fields,
            'order' => array('User.created' => 'desc'),
            'conditions' => array('User.user_type' => 2),
        );
        
        $this->set('paginateLimit', LIMIT);
        $records = $this->Paginator->paginate('User', $criteria);
        $this->set('Users', $records);
    }
	
	public function update_subscription()
	{
		$this->layout = 'basic';
        $this->pageTitle = 'Update Subscription';
        $this->set('pageTitle', $this->pageTitle);
		
		$this->loadModel('Plan');
		$plansData = $this->Plan->find('all', array('conditions' => array('slug !=' => 'demo'), 'order' => 'id asc'));
		$this->set('plansData', $plansData);
	}
	
	public function update_subscription_action($planId)
	{
		if ($this->Session->read('UserInfo.lawyer_id')) {
			
			$this->Uc = $this->Components->load('User');
			$result = $this->Uc->updateSubscription($this->Session->read('UserInfo.lawyer_id'), $planId);
			
			if($result == true) {
				
				$this->Flash->success(__('Subscription updated successfully.'));
			} else {
				
				$this->Flash->error(__('Invalid access or data'));
			}
		} else {
			
			$this->Flash->error(__('Invalid access or data'));
		}
		
		$this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
	}
}
//ALTER TABLE `users` ADD `forgot_password_key` VARCHAR(100) NOT NULL AFTER `is_forgot`, ADD `forgot_password_time` DATETIME NOT NULL AFTER `forgot_password_key`;
//ALTER TABLE `users` CHANGE `forgot_password_time` `forgot_password_time` DATETIME NULL;
