<?php

class UsersController extends AppController
{
    public $helpers = array('Form', 'Js' => array('Jquery'), 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Email', 'SendEmail');

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
}
