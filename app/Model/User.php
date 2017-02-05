<?php

App::uses('AppModel', 'Model');

/**
 *
 */
class User extends AppModel
{
    public $actsAs = array('Containable');

    public $validate = array(
        'first_name' => array(
            'NotEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter first name',
                'last' => true,
            ),
            'ValidFirstName' => array(
                'rule' => array('custom', "/^[a-zA-Z']*$/i"),
                'message' => 'You cannot use special characters in first name',
            ),
        ),
        'last_name' => array(
            'NotEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter last name',
                'last' => true,
            ),
            'ValidLastName' => array(
                'rule' => array('custom', "/^[a-zA-Z']*$/i"),
                'message' => 'You cannot use special characters in last name',
            ),
        ),
        'email' => array(
            'email' => array(
                'on' => 'create',
                'rule' => 'email',
                'message' => 'Please enter valid email address',
                'required' => true,
                'allowEmpty' => false,
                'last' => true,
            ),
            'unique' => array(
                'on' => 'create',
                'rule' => 'isUnique',
                'message' => 'This Email already exist',
                'required' => true,
                'allowEmpty' => false,
                'last' => true,
            ),
        ),
        'user_pwd' => array(
            'rule2' => array(
                'rule' => array('minLength', '5'),
                'allowEmpty' => false,
                'message' => 'Password must be mimimum 5 characters long',
            ),
            'rule1' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Please enter a password',
            ),
        ),
        'confirm_password' => array(
            'ruleName' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter confirm password',
                'last' => true,
            ),
            'ruleName2' => array(
                'rule' => array('compareFields', 'user_pwd'),
                'message' => 'Confirm password and password must be same',
            ),
        )
    );

    public $validateLogin = array(
        'login_email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Please enter valid email address',
                'required' => true,
                'allowEmpty' => false,
                'last' => true,
            ),
        ),
        'user_pwd' => array(
            'required' => array(
                'rule' => array('minLength', '5'),
                'message' => 'Password minimum 5 characters long',
                'required' => true,
                'allowEmpty' => false,
                'last' => true,
            ),
        ),
    );

    public $validateForgotPassword = array(
        'forgot_email' => array(
            'email' => array(
                'on' => 'create',
                'rule' => 'email',
                'message' => 'Please enter valid email address',
                'required' => true,
                'allowEmpty' => false,
                'last' => true,
            ),
        ),
    );

    public $validateChangePassword = array(
        'new' => array(
            'required' => array(
                'on' => 'create',
                'rule' => array('minLength', '5'),
                'message' => 'Password minimum 5 characters long',
                'required' => true,
                'allowEmpty' => false,
                'last' => true,
            ),
        ),
        'confirm' => array(
            'required' => array(
                'rule' => array('equalToField', 'new'),
                'message' => 'New and confirm password should be same',
                'required' => true,
                'last' => true,
            ),
        ),
    );

    public function equalToField($field = array(), $compare_field = null)
    {
        foreach ($field as $key => $value) {
            $v1 = $value;
            $v2 = $this->data[$this->name][$compare_field];
            if ($v1 !== $v2) {
                return false;
            } else {
                continue;
            }
        }

        return true;
    }

    public function getDetails($type = null, $conditions = null, $fields = null, $order = '', $limit = '', $groupBy = '')
    {
        return $this->find($type, array(
                'conditions' => $conditions,
                'fields' => $fields,
                'order' => $order,
                'limit' => $limit,
                'group' => $groupBy,
            )
        );
    }

    public function updateUserInfo($data, $model)
    {
        return true;
        if ($this->$model->save($data)) {
        }
    }

    //Comparing confirm fields with fields Starts
    public function compareFields($field = array(), $compare_field = null)
    {
        foreach ($field as $key => $value) {
            $v1 = trim($value);
            $v2 = trim($this->data[$this->name][$compare_field]);
            if ($v1 != '' && $v2 != '' && $v1 != $v2) {
                return false;
            } else {
                return true;
            }
        }
    }
    //Comparing confirm fields with fields Ends

    //Checks if user is active or not
    public function isUserActive($userDetails)
    {
        if (isset($userDetails['User']['status']) && $userDetails['User']['status'] == 1) {
            return true;
        }

        return false;
    }

    //Checks if user is deleted
    public function isUserDeleted($userDetails)
    {
        if (isset($userDetails['User']['is_deleted']) && $userDetails['User']['is_deleted'] == 1) {
            return true;
        }

        return false;
    }

    public function detailsWithPermissions($conditions = null)
    {
        $options = array();
        $options['joins'] = array();
        $options['conditions'] = $conditions;
        $options['contain'] = false;
        $options['fields'] = array('Address.*', 'Location.*');
        $this->find('all', $options);
        /*return $this->find($type, array(
                'conditions' => $conditions,
                'fields' => $fields,
                'order' => $order,
                'limit' => $limit,
                'group' => $groupBy
            )
        );*/
    }

    public function userSessionRequiredModelJoins()
    {
    }
}