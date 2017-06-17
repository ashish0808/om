<?php
 
class SendEmailComponent extends Component {

	public function send($data='',$type=null){

        switch ($type){

            case 'FORGOT_PASSWORD':

                App::uses('CakeEmail', 'Network/Email');

                $Email = new CakeEmail();
	            $Email->config('default');
	            $Email->template('forgot_password', 'basic')
		            ->emailFormat('html')
		            ->to($data['User']['email'])
		            ->from(array('ashish.chopra0808@gmail.com' => 'Office Management'))
		            ->subject('Office Management - Forgot Password')
		            ->viewVars(array('data' => $data))
		            ->send();

                break;
        }
    }
}