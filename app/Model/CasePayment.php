<?php
App::uses('AppModel', 'Model');
/**
 * CasePayment Model
 *
 * @property ClientCase $ClientCase
 */
class CasePayment extends AppModel {
	
	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'fee_settled' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter fee amount',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter amount in numeric',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mode_of_payment' => array(
			'ruleCaseType' => array(
				'rule' => array('validateWithPayment', 'amount'),
				'message' => 'Please select mode of payment',
			),
		),
		'date_of_payment' => array(
			'ruleCaseNumber' => array(
				'rule' => array('validateWithPayment', 'amount'),
				'message' => 'Please enter date of payment',
			),
			'date' => array(
				'rule' => array('date'),
				'allowEmpty' => true,
				'message' => 'Please enter date in format (Y-m-d)',
			),
		)
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'ClientCase' => array(
			'className' => 'ClientCase',
			'foreignKey' => 'client_case_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PaymentMethod' => array(
			'className' => 'PaymentMethod',
			'foreignKey' => 'mode_of_payment',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function validateWithPayment($field = array(), $compare_field = null)
	{
		foreach ($field as $key => $value) {

			$v1 = trim($value);
			$v2 = trim($this->data[$this->name][$compare_field]);

			if(!empty($v2) && empty($v1)) {

				return false;
			}

			return true;
		}
	}
}
