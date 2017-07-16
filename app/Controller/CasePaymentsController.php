<?php

App::uses('AppController', 'Controller');
/**
 * CasePayments Controller.
 *
 * @property CasePayment $CasePayment
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CasePaymentsController extends AppController
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
        $this->pageTitle = 'Manage Expenses';
        $this->set('pageTitle', $this->pageTitle);

        $fields = [];

        $criteria = [];
        $containCriteria = ['is_deleted' => false];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['CasePayment'] as $key => $value) {
                if (!empty($value)) {
                    $criteria[$key] = $value;
                    $this->request->params['named'][$key] = $value;
                }
            }
        }

        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] as $key => $value) {
                if (!in_array($key, ['page', 'sort', 'direction'])) {
                    if (!empty($value)) {
                        $criteria[$key] = $value;
                        $this->request->data['CasePayment'][$key] = $value;
                    }
                }
            }
        }

        if (empty($criteria)) {
            $criteria = '1=1';
        }

        $this->Paginator->settings = array(
            'page' => 1,
            'limit' => LIMIT,
            'fields' => $fields,
            'order' => array("CasePayment.date_of_payment" => "DESC"),
            'conditions' => array('CasePayment.user_id' => $this->Session->read('UserInfo.uid'), 'type' => 'expense'),
            'contain' => array('ClientCase' => array('conditions' => array($containCriteria)), 'PaymentMethod'),
        );

        $this->set('paginateLimit', LIMIT);
        $records = $this->Paginator->paginate('CasePayment', $criteria);

        foreach ($records as $key => $value) {
            if (!empty($value['CasePayment']['client_case_id']) && empty($value['ClientCase']['id'])) {
                unset($records[$key]);
            }
        }
        $records = array_values($records);

        // To see if the page has been accessed from case detail page or dispatches main page then only show add button
        $this->set('show_add', false);
        $this->set('Expenses', $records);
    }

    /**
     * It will add a new Expense for the given case of the user or as misc.
     *
     * @param $computer_file_no It will be given if one comes directly from a case to add Expense
     */
    public function add($computer_file_no = '')
    {
        $computer_file_no = str_replace('_', '/', $computer_file_no);
        $this->layout = 'basic';
        $this->pageTitle = 'Add New Expense';
        $this->set('pageTitle', $this->pageTitle);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['CasePayment']['computer_file_no'])) {
                // Get case ID for the given Computer File No
                $caseData = $this->CasePayment->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['CasePayment']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'), 'is_deleted' => false)));
                if (!empty($caseData)) {
                    $this->request->data['CasePayment']['client_case_id'] = $caseData['ClientCase']['id'];
                } else {
                    $this->CasePayment->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                }
            }

            if (empty($this->CasePayment->validationErrors)) {
                $this->request->data['CasePayment']['user_id'] = $this->Session->read('UserInfo.uid');
                $this->request->data['CasePayment']['type'] = 'expense';

                $this->CasePayment->create();
                $this->CasePayment->set($this->request->data['CasePayment']);
                if ($this->CasePayment->validates()) {
                    if ($this->CasePayment->save($this->request->data)) {
                        $this->Flash->success(__('The Expense has been saved.'));
                        if ($this->data['CasePayment']['referer'] == 'caseExpenses') {
                            return $this->redirect(array('controller' => 'CasePayments', 'action' => 'caseExpenses', $this->data['CasePayment']['case_id']));
                        } else {
                            return $this->redirect(array('controller' => 'CasePayments', 'action' => 'index'));
                        }
                    } else {
                        $this->Flash->error(__('The Expense could not be saved. Please, try again.'));
                    }
                }
            }
        }
        $this->loadModel('PaymentMethod');
        $PaymentMethods = $this->PaymentMethod->find('list', array('fields' => array('id', 'method')));
        // To see if the page has been accessed from case detail page or dispatches main page
        $referer_url_params = Router::parse($this->referer('/', true));
        $this->set('action', $referer_url_params['action']);
        if (!empty($referer_url_params['pass'])) {
            $this->set('caseId', $referer_url_params['pass'][0]);
        } else {
            $this->set('caseId', 0);
        }
        $this->set(compact('computer_file_no', 'PaymentMethods'));
    }

    /**
     * edit method.
     *
     * @param string $id
     */
    public function edit($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Edit Expense';
        $this->set('pageTitle', $this->pageTitle);
        $computer_file_no = '';

        $CasePaymentData = $this->CasePayment->find('first', array('contain' => array('ClientCase'), 'conditions' => array('CasePayment.user_id' => $this->Session->read('UserInfo.uid'), 'CasePayment.id' => $id)));

        if (!empty($CasePaymentData)) {
            $CasePaymentData = $this->CasePayment->find('first', array('contain' => array('ClientCase'), 'conditions' => array('CasePayment.user_id' => $this->Session->read('UserInfo.uid'), 'CasePayment.id' => $id)));
            $this->loadModel('PaymentMethod');
            $PaymentMethods = $this->PaymentMethod->find('list', array('fields' => array('id', 'method')));

            if (!empty($CasePaymentData['ClientCase']['computer_file_no'])) {
                $computer_file_no = $CasePaymentData['ClientCase']['computer_file_no'];
            }

            if ($this->request->is(array('post', 'put'))) {
                if (empty($this->request->data['CasePayment']['computer_file_no'])) {
                    $this->request->data['CasePayment']['client_case_id'] = null;
                }

                // If computer file_no has been updated then find the associated case_id and update in CM/CRM
                if ($CasePaymentData['ClientCase']['computer_file_no'] != $this->request->data['CasePayment']['computer_file_no'] && !empty($this->request->data['CasePayment']['computer_file_no'])) {
                    $caseData = $this->CasePayment->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['CasePayment']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'), 'is_deleted' => false)));
                    if (!empty($caseData)) {
                        $this->request->data['CasePayment']['client_case_id'] = $caseData['ClientCase']['id'];
                    } else {
                        $this->CasePayment->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                    }
                }

                if (empty($this->CasePayment->validationErrors)) {
                    $this->request->data['CasePayment']['user_id'] = $this->Session->read('UserInfo.uid');
                    $this->CasePayment->set($this->request->data['CasePayment']);
                    if ($this->CasePayment->validates()) {
                        $this->CasePayment->id = $id;
                        if ($this->CasePayment->save($this->request->data)) {
                            $this->Flash->success(__('The Expense has been saved.'));
                            if ($this->data['CasePayment']['referer'] == 'caseExpenses') {
                                return $this->redirect(array('controller' => 'CasePayments', 'action' => 'caseExpenses', $this->data['CasePayment']['case_id']));
                            } else {
                                return $this->redirect(array('controller' => 'CasePayments', 'action' => 'index'));
                            }
                        } else {
                            $this->Flash->error(__('The Expense could not be saved. Please, try again.'));
                        }
                    }
                }
            } else {
                $this->request->data = $CasePaymentData;
            }
            $this->set(compact('id', 'computer_file_no', 'PaymentMethods'));

            // To see if the page has been accessed from case detail page or dispatches main page
            $referer_url_params = Router::parse($this->referer('/', true));
            $this->set('action', $referer_url_params['action']);
            if (!empty($referer_url_params['pass'])) {
                $this->set('caseId', $referer_url_params['pass'][0]);
            } else {
                $this->set('caseId', 0);
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));

            $this->redirect(Router::url($this->referer(), true));
        }
    }

    /**
     * delete the given ID from DB and its associated attachment from AWS.
     *
     * @param string $id
     */
    public function delete($id = null)
    {
        $CasePaymentData = $this->CasePayment->find('first', array('conditions' => array('CasePayment.user_id' => $this->Session->read('UserInfo.uid'), 'CasePayment.id' => $id)));
        if (!empty($CasePaymentData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->CasePayment->id = $id;
                if ($this->CasePayment->delete()) {
                    $this->Flash->success(__('The Expense has been deleted successfully.'));
                } else {
                    $this->Flash->error(__('The Expense could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The selected http method is not allowed.'));
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
        }

        return $this->redirect(Router::url($this->referer(), true));
    }

    /**
     * view the details of the given Expense ID.
     *
     * @param string $id
     */
    public function view($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Expense Details';
        $this->set('pageTitle', $this->pageTitle);
        $CasePaymentData = $this->CasePayment->find('first', array('contain' => array('ClientCase' => array('conditions' => array('is_deleted' => false)), 'PaymentMethod'), 'conditions' => array('CasePayment.user_id' => $this->Session->read('UserInfo.uid'), 'CasePayment.id' => $id)));

        if (empty($CasePaymentData) || (!empty($CasePaymentData['CasePayment']['client_case_id']) && empty($CasePaymentData['ClientCase']['id']))) {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
            return $this->redirect(Router::url($this->referer(), true));
        } else {
            $this->set('CasePayment', $CasePaymentData);

            // To see if the page has been accessed from case detail page or dispatches main page
            $referer_url_params = Router::parse($this->referer('/', true));
            $this->set('action', $referer_url_params['action']);
            if (!empty($referer_url_params['pass'])) {
                $this->set('caseId', $referer_url_params['pass'][0]);
            }
        }
    }

    /**
     * Get all the CM/CRM of a case
     * @param  integer $caseId Case ID for which CM/CRM has to be fetched
     * @return [html]  View of case CM/CRM page
     */
    public function caseExpenses($caseId)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Case Expenses';
        $this->set('pageTitle', $this->pageTitle);

        $caseDetails = $this->_getCaseDetails($caseId);

        if (!empty($caseDetails)) {
            $this->CasePayment->bindModel(array('belongsTo' => array('ClientCase' => array('type' => 'INNER'))));
            $Expenses = $this->CasePayment->find('all', array('contain' => array('PaymentMethod', 'ClientCase' => array('conditions' => array('ClientCase.id' => $caseId, 'ClientCase.user_id' => $this->Session->read('UserInfo.uid'), 'is_deleted' => false))), 'conditions' => array('client_case_id' => $caseId, 'type' => 'expense'), 'order' => 'date_of_payment DESC'));

            // To see if the page has been accessed from case detail page or dispatches main page then only show add button
            $this->set('show_add', true);
            $this->set(compact('caseDetails', 'caseId', 'Expenses'));
        } else {
            $this->Flash->error(__("The selected case doesn't exist or deleted. Please, try with valid record."));
            return $this->redirect(array('controller' => 'cases', 'action' => 'manage'));
        }
    }

    private function _getCaseDetails($caseId)
    {
        $this->ClientCases = $this->Components->load('ClientCases');

        return $this->ClientCases->findByCaseId($caseId, $this->Session->read('UserInfo.lawyer_id'));
    }
}
