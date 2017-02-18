<?php

App::uses('AppModel', 'Model');
/**
 * CaseCivilMisc Model.
 *
 * @property ClientCase $ClientCase
 * @property User $User
 */
class CaseCivilMisc extends AppModel
{
    /**
     * Use table.
     *
     * @var mixed False or table name
     */
    public $useTable = 'case_civil_misc';

    public $actsAs = array('Containable');

    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = array(
        'client_case_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
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
        'cm_type' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'cm_no' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
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
        'attachment' => array(
	        'rule' => array(
	            'extension',
	            array('gif', 'jpeg', 'png', 'jpg', 'pdf', 'doc', 'docx', 'rtf', 'odt', 'xls', 'xlsx'),
	        ),
	        'message' => 'Please supply a valid image.',
	    ),
    );

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = array(
        'ClientCase' => array(
            'className' => 'ClientCase',
            'foreignKey' => 'client_case_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
    );
}
