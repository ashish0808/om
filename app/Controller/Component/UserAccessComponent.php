<?php
 
class UserAccessComponent extends Component
{
    //var $allowedActions = array('users/dashboard');

	public function check()
    {
        if($this->isAdminLoggedIn()){
            return true;
        }

        if(!$this->checkAllowedActions()){
            if($this->isUserLoggedIn()){
                if($this->Session->read('UserInfo.UserAccessPermissions')!=''){
                    $currentUrl = $this->params['controller'].'/'.$this->params['action'];
                    $userPermissions = array_map('strtolower',$this->Session->read('UserInfo.UserAccessPermissions'));
                    if(in_array(strtolower($currentUrl),$userPermissions)){
                        return true;
                    }
                }
            }
        }else{
            return true;
        }
        return false;
    }

    public function isUserLoggedIn()
    {
        if ($this->Session->read('UserInfo.uid') != ''){
            return true;
        }
        return false;
    }

    public function isAdminLoggedIn()
    {
        if ($this->Session->read('UserInfo.uid') != ''){
            return true;
        }
        return false;
    }

    public function checkAllowedActions()
    {
        $currentUrl = $this->params['controller'].'/'.$this->params['action'];
        $listAllowedActions = array_map('strtolower',array('users/dashboard'));
        if(in_array(strtolower($currentUrl),$listAllowedActions)){
            return true;
        }
        return false;
    }
}