<?php
App::uses('AppModel', 'Model');
/**
 * CaseFiling Model
 *
 * @property ClientCase $ClientCase
 */
class CaseFiling extends AppModel {

	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'filing_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Please enter filing date',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filing_type' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please select filing type',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filing_no' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter filing number',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		)
	);
}
