<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class CasePayment extends AppModel
{
	public $actsAs = array('Containable');

	var $belongsTo = array(
		'Case' => array(
			'className'  => 'ClientCase',
			'foreignKey' => 'case_id',
			'conditions' => array(),
			'order'      => ''
		)
	);
}