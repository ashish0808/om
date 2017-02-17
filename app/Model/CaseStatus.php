<?php
App::uses('AppModel', 'Model');
/**
 * CaseStatus Model
 *
 */
class CaseStatus extends AppModel {

	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'status' => array(
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
