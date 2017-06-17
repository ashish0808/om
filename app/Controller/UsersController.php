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

                        $userDetails = $userModel->getDetails('first', array('User.email' => $this->request->data['User']['login_email'], 'User.user_pwd' => $this->request->data['User']['user_pwd']), array('id', 'first_name', 'last_name', 'email', 'user_type', 'status', 'is_deleted'));

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

    /**
     * Displays Dashboard Page as per the User Role.
     */
    public function dashboard()
    {
        //echo '<pre>'; print_r($this->Session->read()); die;
        $this->layout = 'basic';
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

        $caseData = $this->ClientCase->find('all', array('conditions' => array('case_status' => array(PENDING_FOR_FILING, PENDING_FOR_REFILING, PENDING_FOR_REGISTRATION), 'ClientCase.user_id' => $this->Session->read('UserInfo.uid')), 'order' => 'limitation_expires_on asc'));
        if (!empty($caseData)) {
            foreach ($caseData as $key => $value) {
                if ($value['ClientCase']['case_status'] == PENDING_FOR_FILING) {
                    if ($pending_for_filing_count < 5) {
                        $pending_for_filing_data[] = $caseData[$key];
                        $pending_for_filing_count++;
                    }
                } else if ($value['ClientCase']['case_status'] == PENDING_FOR_REFILING) {
                    if ($pending_for_refiling_count < 5) {
                        $pending_for_refiling_data[] = $caseData[$key];
                        $pending_for_refiling_count++;
                    }
                } else if ($value['ClientCase']['case_status'] == PENDING_FOR_REGISTRATION) {
                    if ($pending_for_registration_count < 5) {
                        $pending_for_registration_data[] = $caseData[$key];
                        $pending_for_registration_count++;
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
        return $this->ClientCase->find('all', array('conditions' => array('case_status' => array(PENDING, ADMITTED), 'ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'OR' => array('is_ememo_filed' => false, 'is_paper_book' => false, 'is_diary_entry' => false, 'is_letter_communication' => false, 'is_lcr' => false)), 'limit' => $limit));
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

    private function __getCasesWithNoNextDate($limit) {
        $this->loadModel('CaseProceeding');
        $this->CaseProceeding->bindModel(array('belongsTo' => array('ClientCase' => array('type' => 'INNER'))));
        return $this->CaseProceeding->find('all', array('contain' => array('ClientCase' => array('conditions' => array('ClientCase.case_status' => array(PENDING), 'is_main_case' => true, 'user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => array('proceeding_status' => 'pending', 'next_date_of_hearing' => null, 'date_of_hearing <' => date('Y-m-d')), 'limit' => $limit));
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

	function change_password()
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Change Password';
		$this->set("pageTitle", $this->pageTitle);

		if (!empty($this->data)) {

			$this->User->set($this->request->data);

			$this->User->validate = $this->User->validateChangePassword;
			if ($this->User->validate) {

				$saveData = array();

				$saveData['User'] = array(
					'id' => $this->data['User']['id'],
					'user_pwd' => $this->data['User']['new']
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
						/*App::import('Component','SendEmailComponent');
						$SendEmail = & new SendEmail();*/

						$emailData = array();
						if ($this->SendEmail->send($emailData, 'FORGOT_PASSWORD')) {

							$userInfo = array();
							$userInfo['User']['id'] = $userDetails['User']['id'];
							$userInfo['User']['is_forgot'] = 1;
							$userModel->updateUserInfo($userDetails, 'User');
							$this->Flash->success(__('Email sent successfully'));
						} else {

							$this->Flash->error(__('Email cannot be sent, Please try again later'));
						}
					} else {

						$this->Flash->error(__('The user could not be found. Please fill the correct information'));
					}

					$this->redirect(array('controller' => 'users', 'action' => 'forgot_password'));
				}

			}
		} else {
			$this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
			exit();
		}
	}
}
