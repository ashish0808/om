<?php
App::uses('AppModel', 'Model');
/**
 * ClientCase Model
 *
 * @property User $User
 * @property CaseType $CaseType
 * @property Court $Court
 * @property UserCompanies $UserCompanies
 * @property CaseCivilMisc $CaseCivilMisc
 * @property CaseFile $CaseFile
 * @property CaseFiling $CaseFiling
 * @property CasePayment $CasePayment
 * @property CaseProceeding $CaseProceeding
 * @property Dispatch $Dispatch
 * @property Todo $Todo
 */
class ClientCase extends AppModel {

	public $actsAs = array('Containable');

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'computer_file_no' => array(
			'rule1' => array(
				'rule' => array('validateFileNumber', 'is_existing'),
				'message' => 'Please enter file number',
			)
		),
		'presiding_officer' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter presiding officer name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_deleted' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		/*'party_type' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fee_settled' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'payment_received' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'payment_status' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'non_verified_payment' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'case_status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_ememo_filed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_paper_book' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_diary_entry' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_letter_communication' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_lcr' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'certified_copy_required' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_order_supplied_to_party' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'alongwith_lcr' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'completed_step' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'saved_incomplete' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
	);


	public $validateClientInfo = array(
		'party_type' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Please select party type'
			)
		),
		'user_companies_id' => array(
			'ruleCaseType' => array(
				'rule' => array('validateWithPartyTypeCompany', 'party_type'),
				'message' => 'Please select company',
			),
		),
		'reference_no' => array(
			'ruleCaseNumber' => array(
				'rule' => array('validateWithPartyTypeCompany', 'party_type'),
				'message' => 'Please enter reference number',
			),
		),
		'client_phone' => array(
			'ruleCaseNumber' => array(
				'rule' => array('validateWithPartyTypeClient', 'party_type'),
				'message' => 'Please enter phone number',
			),
		)
	);

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

			if(empty($value)) {

				return true;
			}

			if($value>1900 && $value <= date('Y')) {

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

	public function validateWithPartyTypeCompany($field = array(), $compare_field = null)
	{
		foreach ($field as $key => $value) {

			$v1 = trim($value);
			$v2 = trim($this->data[$this->name][$compare_field]);

			if($v2=='Company' && empty($v1)) {

				return false;
			}

			return true;
		}
	}

	public function validateWithPartyTypeClient($field = array(), $compare_field = null)
	{
		foreach ($field as $key => $value) {

			$v1 = trim($value);
			$v2 = trim($this->data[$this->name][$compare_field]);

			if($v2=='Private Client' && empty($v1)) {

				return false;
			}

			return true;
		}
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CaseType' => array(
			'className' => 'CaseType',
			'foreignKey' => 'case_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Court' => array(
			'className' => 'Court',
			'foreignKey' => 'court_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserCompanies' => array(
			'className' => 'UserCompanies',
			'foreignKey' => 'user_companies_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'CaseCivilMisc' => array(
			'className' => 'CaseCivilMisc',
			'foreignKey' => 'client_case_id',
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
		'CaseFile' => array(
			'className' => 'CaseFile',
			'foreignKey' => 'client_case_id',
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
		'CaseFiling' => array(
			'className' => 'CaseFiling',
			'foreignKey' => 'client_case_id',
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
		'CasePayment' => array(
			'className' => 'CasePayment',
			'foreignKey' => 'client_case_id',
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
		'CaseProceeding' => array(
			'className' => 'CaseProceeding',
			'foreignKey' => 'client_case_id',
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
		'Dispatch' => array(
			'className' => 'Dispatch',
			'foreignKey' => 'client_case_id',
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
		'Todo' => array(
			'className' => 'Todo',
			'foreignKey' => 'client_case_id',
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

	//ALTER TABLE `client_cases` CHANGE `case_number` `case_number` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `complete_case_number` `complete_case_number` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `case_year` `case_year` INT(5) NULL, CHANGE `case_title` `case_title` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `party_type` `party_type` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'Private Client or Company';

	//ALTER TABLE `client_cases` CHANGE `fee_settlled` `fee_settled` FLOAT(9,2) NOT NULL DEFAULT '0.00';
}