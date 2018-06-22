<?php

App::uses('Component', 'Controller');

class UserComponent extends Component
{
	public function addDemoPlan($userId, $createdBy = NULL)
	{
		App::import('Model','User');
		$userObj = new User();

		$userDetails = $userObj->find('first', array(
			'conditions' => array(
				'id' => $userId
			),
			'contain' => array('UserTransaction')
		));
		
		if(!empty($userDetails)) {
			
			if(empty($userDetails['UserTransaction'])) {
				
				App::import('Model','Plan');
				$planObj = new Plan();

				$demoPlanData = $planObj->find('first', array(
					'conditions' => array(
						'slug' => 'demo'
					)
				));

				if(!empty($demoPlanData)) {
					
					App::import('Model','UserTransaction');
					$this->utObj = new UserTransaction();
					
					$days = $demoPlanData['Plan']['no_of_days'];
					
					$data = array(
						'user_id' => $userId,
						'plan_id' => $demoPlanData['Plan']['id'],
						'amount' => $demoPlanData['Plan']['price'],
						'plan_name' => $demoPlanData['Plan']['name'],
						'plan_description' => $demoPlanData['Plan']['description'],
						'no_of_days' => $days,
						'plan_expiry_date' => date('Y-m-d'),
						'created_by' => $createdBy
					);
					
					if(!empty($days)) {
						
						$data['plan_expiry_date'] = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$days.' days'));
					}
					
					if($this->utObj->save($data)) {
						
						$userModel = new User();
						
						$userData = array();
						$userData['User']['id'] = $userId;
						$userData['User']['plan_expiry_date'] = $data['plan_expiry_date'];
						
						$userModel->save($userData, false);
					}
				}
			}
		}
	}
	
	public function updateSubscription($userId, $planId)
	{
		App::import('Model','User');
		$userObj = new User();
		
		$userDetails = $userObj->find('first', array(
			'conditions' => array(
				'id' => $userId
			)
		));
		
		if(!empty($userDetails)) {
			
			if($this->subscriptionUpdateCheck($userDetails)) {
			
				App::import('Model','Plan');
				$planObj = new Plan();
				
				$planData = $planObj->find('first', array(
					'conditions' => array(
						'id' => $planId,
						'slug !=' => 'demo'
					)
				));

				if(!empty($planData)) {
					
					$previousDate = date('Y-m-d');
					if(!empty($userDetails['User']['plan_expiry_date'])) {
						
						$previousDate = $userDetails['User']['plan_expiry_date'];
					}
					
					App::import('Model','UserTransaction');
					$this->utObj = new UserTransaction();
					
					$days = $planData['Plan']['no_of_days'];
					
					$data = array(
						'user_id' => $userId,
						'plan_id' => $planData['Plan']['id'],
						'amount' => $planData['Plan']['price'],
						'plan_name' => $planData['Plan']['name'],
						'plan_description' => $planData['Plan']['description'],
						'no_of_days' => $days,
						'plan_expiry_date' => date('Y-m-d'),
						'created_by' => $userId
					);
					
					if(!empty($days)) {
						
						$data['plan_expiry_date'] = date('Y-m-d', strtotime($previousDate. ' + '.$days.' days'));
					}
					
					if($this->utObj->save($data)) {
						
						$userModel = new User();
						
						$userData = array();
						$userData['User']['id'] = $userId;
						$userData['User']['plan_expiry_date'] = $data['plan_expiry_date'];
						
						$userModel->save($userData, false);
						
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	public function subscriptionUpdateCheck($userDetails)
	{
		if(!empty($userDetails['User']['plan_expiry_date'])) {
			
			$expiryDateAlert = date('Ymd', strtotime('-30 days', strtotime($userDetails['User']['plan_expiry_date'])));
			if($expiryDateAlert < date('Ymd')) {
				
				return true;
			}
		}
		
		return false;
	}
}