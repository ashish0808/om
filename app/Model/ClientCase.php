<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class ClientCase extends AppModel
{
	public $actsAs = array('Containable');

	public function editCaseRequiredModelJoins()
	{
		$this->bindModel(array
		(
			'hasMany' => array
			(
				'CasePayment' => array
				(
					'className'  => 'CasePayment',
					'foreignKey' => "case_id",
					'conditions' => array(),
					'fields' => array()
				)
			)
		), false);
	}
}