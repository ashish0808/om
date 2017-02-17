<?php
App::uses('AppModel', 'Model');
/**
 * PaymentMethod Model
 *
 */
class PaymentMethod extends AppModel {

	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'method' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
