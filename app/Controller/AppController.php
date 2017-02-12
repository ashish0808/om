<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $isApi = false;
    public $components = array('Session', 'Paginator');

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function generateToken()
    {
        $token = uniqid();
        $this->Session->write('token', $token);

        return uniqid();
    }

    public function isTokenValid($token)
    {
        if (!empty($token) && $this->Session->read('token') == $token) {
            return true;
        }

        return false;
    }

    public function isUserLoggedIn()
    {
        if ($this->Session->read('UserInfo.uid') != '') {
            return true;
        }

        return false;
    }

    public function writeUserSession($userDetails)
    {
        if (isset($userDetails) && !empty($userDetails)) {
        
            $userType = $userDetails['User']['user_type'];
            
            
            $this->Session->write('isLawyer', 1);
            $this->Session->write('UserInfo.lawyer_id', $userDetails['User']['id']);

            $this->Session->write('UserInfo.uid', $userDetails['User']['id']);
            $this->Session->write('UserInfo.email', $userDetails['User']['email']);
            $this->Session->write('UserInfo.first_name', $userDetails['User']['first_name']);
            $this->Session->write('UserInfo.last_name', $userDetails['User']['last_name']);
            $this->Session->write('UserInfo.user_type', $userDetails['User']['user_type']);
        }
    }

    public function updateInfo($data, $model)
    {
        $this->loadModel($model);
        if ($this->$model->save($data)) {
        }
    }

    public function checkUserAccess($currentUrl)
    {
        return true;
    }

    public function dateTimeSqlFormat($dateTime)
    {
	    if(!empty($dateTime)) {

		    $dateTime = strtotime($dateTime);

		    return date('Y-m-d H:i:s', $dateTime);
	    }

        return $dateTime;
    }

    public function dateTimeDisplayFormat($dateTime)
    {
        $dateTime = strtotime($dateTime);

        return date('m/d/Y g:i A', $dateTime);
    }
}