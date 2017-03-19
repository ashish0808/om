<?php

App::uses('AppController', 'Controller');
/**
 * UserCompanies Controller.
 *
 * @property UserCompany $UserCompany
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class UserCompaniesController extends AppController
{
    /**
     * Components.
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash', 'Session');

    /**
     * index method.
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'basic';
        }
        $this->pageTitle = 'Manage Companies';
        $this->set('pageTitle', $this->pageTitle);

        $records = $this->UserCompany->find('all', array('conditions' => array('user_id' => $this->Session->read('UserInfo.uid'))));
        // pr($records);die;
        $this->set('UserCompanies', $records);
    }

    /**
     * It will add a new UserCompany for the given case of the user or as misc.
     *
     * @param $computer_file_no It will be given if one comes directly from a case to add UserCompany
     */
    public function add()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add New Company';
        $this->set('pageTitle', $this->pageTitle);
        if ($this->request->is('post')) {
            $this->request->data['UserCompany']['user_id'] = $this->Session->read('UserInfo.uid');
            $this->UserCompany->create();
            $this->UserCompany->set($this->request->data['UserCompany']);
            if ($this->UserCompany->validates()) {
                if ($this->UserCompany->save($this->request->data)) {
                    $this->Flash->success(__('The Company has been saved.'));
                    return $this->redirect(array('controller' => 'UserCompanies', 'action' => 'index'));
                } else {
                    $this->Flash->error(__('The Company could not be saved. Please, try again.'));
                }
            }
        }
    }

    /**
     * edit method.
     *
     * @param string $id
     */
    public function edit($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Edit Company';
        $this->set('pageTitle', $this->pageTitle);

        $UserCompanyData = $this->UserCompany->find('first', array('conditions' => array('UserCompany.user_id' => $this->Session->read('UserInfo.uid'), 'UserCompany.id' => $id)));

        if (!empty($UserCompanyData)) {
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['UserCompany']['user_id'] = $this->Session->read('UserInfo.uid');
                $this->UserCompany->set($this->request->data['UserCompany']);
                if ($this->UserCompany->validates()) {
                    $this->UserCompany->id = $id;
                    if ($this->UserCompany->save($this->request->data)) {
                        $this->Flash->success(__('The UserCompany has been saved.'));

                        return $this->redirect(array('controller' => 'UserCompanies', 'action' => 'index'));
                    } else {
                        $this->Flash->error(__('The UserCompany could not be saved. Please, try again.'));
                    }
                }
            } else {
                $this->request->data = $UserCompanyData;
            }
            $this->set(compact('id'));
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
            return $this->redirect(array('controller' => 'UserCompanies', 'action' => 'index'));
        }
    }

    /**
     * delete the given ID from DB and its associated attachment from AWS.
     *
     * @param string $id
     */
    public function delete($id = null)
    {
        $UserCompanyData = $this->UserCompany->find('first', array('conditions' => array('UserCompany.user_id' => $this->Session->read('UserInfo.uid'), 'UserCompany.id' => $id)));
        if (!empty($UserCompanyData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->UserCompany->id = $id;
                if ($this->UserCompany->delete()) {
                    $this->Flash->success(__('The UserCompany has been deleted successfully.'));
                } else {
                    $this->Flash->error(__('The UserCompany could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The selected http method is not allowed.'));
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
        }

        return $this->redirect(array('controller' => 'UserCompanies', 'action' => 'index'));
    }
}
