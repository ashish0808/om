<?php
class UserTransaction extends AppModel {
    var $name = 'UserTransaction';
    var $validate = array();
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Plan' => array(
			'className' => 'Plan',
			'foreignKey' => 'plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	//ALTER TABLE `user_transactions` CHANGE `amount` `amount` FLOAT(7,2) NULL, CHANGE `mode_of_payment` `mode_of_payment` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `transaction_id` `transaction_id` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `notes` `notes` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `created_by` `created_by` INT(11) NULL;
}