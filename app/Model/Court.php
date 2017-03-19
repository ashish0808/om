<?php
App::uses('AppModel', 'Model');
/**
 * Court Model
 *
 * @property ClientCase $ClientCase
 */
class Court extends AppModel {

	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
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

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ClientCase' => array(
			'className' => 'ClientCase',
			'foreignKey' => 'court_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/**
	 * It will list all the courts for a user
	 * @param  [type] $user_id [description]
	 * @return [type]            [description]
	 */
	public function listCourts()
	{
		return $this->find('list', array(
				'fields' => array('id', 'name'),
				'order' => 'name ASC'
			)
		);
	}

}
