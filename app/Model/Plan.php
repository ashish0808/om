<?php

App::uses('AppModel', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Plan extends AppModel {
	
	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'UserTransaction' => array(
			'className' => 'UserTransaction',
			'foreignKey' => 'plan_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

    public function getPlanDetails($type=null,$conditions=null,$fields=null,$order='',$limit='',$groupBy=''){
        return $this->find($type, array(
                'conditions' => $conditions,
                'fields' => $fields,
                'order' => $order,
                'limit' => $limit,
                'group' => $groupBy
            )
        );
    }
}