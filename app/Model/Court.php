<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class Court extends AppModel
{
	public $actsAs = array('Containable');

	public function listLawyerCourts($lawyer_id)
	{
		return $this->find('list', array(
				'conditions' => array(
					'user_id' => array(0, $lawyer_id)
				),
				'fields' => array('id', 'name'),
				'order' => 'name ASC'
			)
		);
	}
}