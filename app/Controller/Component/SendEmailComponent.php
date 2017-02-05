<?php
 
class SendEmailComponent extends Component {

	public function send($data='',$type=null){
        switch ($type){
            case 'FORGOT_PASSWORD':
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail();
                $Email->sendAs = 'both'; // both = html + plain text
                $Email->to = 'ashish.chopra1@yahoo.in';
                $Email->from = 'noreply@aivenhi.com';
                $Email->subject = 'your amazing subject here';
                $Email->template = 'forgot_password';
                // set some variables for your templates
                //$this->set('contentDetails', array('name'=>'ashish','data'=>$data));
                $Email->send();

                break;
        }
    }
}