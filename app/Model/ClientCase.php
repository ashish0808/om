<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class ClientCase extends AppModel
{
	public $actsAs = array('Containable');

	/*public $hasOne = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'lawyer_id',
			'conditions' => array(),
			'order' => '',
		),
	);*/

	public $validate = array(
		'is_existing' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Please select if existing case'
			)
		),
		'client_type' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Please select client type'
			)
		),
		'party_name' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Please enter party name'
			)
		),
		'case_type_id' => array(
			'ruleCaseType' => array(
				'rule' => array('validateWithClientType', 'client_type'),
				'message' => 'Please select case type',
			),
		),
		'case_number' => array(
			'ruleCaseNumber' => array(
				'rule' => array('validateWithClientType', 'client_type'),
				'message' => 'Please enter case number',
			),
		),
		'case_year' => array(
			'rule1' => array(
				'rule' => array('validateWithClientType', 'client_type'),
				'message' => 'Please enter case year',
			),
			'rule2' => array(
				'rule' => array('validateValidYear'),
				'message' => 'Please enter valid year',
			)
		),
		'case_title' => array(
			'ruleName1' => array(
				'rule' => array('validateWithClientType', 'client_type'),
				'message' => 'Please enter case title',
			),
		),
		'court_id' => array(
			'ruleName1' => array(
				'rule' => array('validateWithClientType', 'client_type'),
				'message' => 'Please select court',
			),
		),
		'file_number' => array(
			'rule1' => array(
				'rule' => array('validateFileNumber', 'is_existing'),
				'message' => 'Please enter file number',
			)
		),
	);

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

	public function validateWithClientType($field = array(), $compare_field = null)
	{
		foreach ($field as $key => $value) {

			$v1 = trim($value);
			$v2 = trim($this->data[$this->name][$compare_field]);

			if($v2=='petitioner' && empty($v1)) {

				return false;
			}

			return true;
		}
	}

	public function validateValidYear($field = array())
	{
		foreach ($field as $key => $value) {

			$value = trim($value);

			if(!empty($value) && ($value>1900 && $value <= date('Y'))) {

				return true;
			}

			return false;
		}
	}

	public function validateFileNumber($field = array(), $compare_field = null)
	{
		foreach ($field as $key => $value) {

			$v1 = trim($value);
			$v2 = trim($this->data[$this->name][$compare_field]);

			if($v2==1 && empty($v1)) {

				return false;
			}

			return true;
		}
	}
}