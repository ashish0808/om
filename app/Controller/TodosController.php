<?php

App::uses('AppController', 'Controller');
/**
 * Todos Controller.
 *
 * @property Todo $Todo
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class TodosController extends AppController
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
        $this->pageTitle = 'Manage Todos';
        $this->set('pageTitle', $this->pageTitle);

        $fields = [];

        $criteria = [];
        $containCriteria = [];
        if (!empty($this->request->data)) {
            foreach ($this->request->data['Todo'] as $key => $value) {
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
                        $this->request->data['Todo'][$key] = $value;
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
            'order' => array('Todo.id' => 'desc'),
            'contain' => array('ClientCase'),
        );

        if (!empty($containCriteria)) {
            $this->Paginator->settings['contain'] = array('ClientCase' => array('conditions' => array($containCriteria)));
        }
        $this->set('paginateLimit', LIMIT);
        $records = $this->Paginator->paginate('Todo', $criteria);

        // To see if the page has been accessed from case detail page or dispatches main page then only show add button
        $this->set('show_add', false);
        $this->set('Todos', $records);
    }

    /**
     * It will add a new Todo for the given case of the user or as misc.
     *
     * @param $computer_file_no It will be given if one comes directly from a case to add Todo
     */
    public function add($computer_file_no = '')
    {
        $computer_file_no = str_replace('_', '/', $computer_file_no);
        $this->layout = 'basic';
        $this->pageTitle = 'Add New Todo';
        $this->set('pageTitle', $this->pageTitle);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['Todo']['computer_file_no'])) {
                // Get case ID for the given Computer File No
                $caseData = $this->Todo->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['Todo']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                if (!empty($caseData)) {
                    $this->request->data['Todo']['client_case_id'] = $caseData['ClientCase']['id'];
                } else {
                    $this->Todo->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                }
            }

            if (empty($this->Todo->validationErrors)) {
                $this->request->data['Todo']['user_id'] = $this->Session->read('UserInfo.uid');

                $this->Todo->create();
                $this->Todo->set($this->request->data['Todo']);
                if ($this->Todo->validates()) {
                    if ($this->Todo->save($this->request->data)) {
                        $this->Flash->success(__('The Todo has been saved.'));
                        if ($this->data['Todo']['referer'] == 'caseTodos') {
                            return $this->redirect(array('controller' => 'Todos', 'action' => 'caseTodos', $this->data['Todo']['case_id']));
                        } else {
                            return $this->redirect(array('controller' => 'Todos', 'action' => 'index'));
                        }
                    } else {
                        $this->Flash->error(__('The Todo could not be saved. Please, try again.'));
                    }
                }
            }
        }
        // To see if the page has been accessed from case detail page or dispatches main page
        $referer_url_params = Router::parse($this->referer('/', true));
        $this->set('action', $referer_url_params['action']);
        if (!empty($referer_url_params['pass'])) {
            $this->set('caseId', $referer_url_params['pass'][0]);
        } else {
            $this->set('caseId', 0);
        }
        $this->set(compact('computer_file_no'));
    }

    /**
     * edit method.
     *
     * @param string $id
     */
    public function edit($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Edit Todo';
        $this->set('pageTitle', $this->pageTitle);
        $computer_file_no = '';

        $TodoData = $this->Todo->find('first', array('contain' => array('ClientCase'), 'conditions' => array('Todo.user_id' => $this->Session->read('UserInfo.uid'), 'Todo.id' => $id)));

        if (!empty($TodoData)) {
            if (!empty($TodoData['ClientCase']['computer_file_no'])) {
                $computer_file_no = $TodoData['ClientCase']['computer_file_no'];
            }

            if ($this->request->is(array('post', 'put'))) {
                if (empty($this->request->data['Todo']['computer_file_no'])) {
                    $this->request->data['Todo']['client_case_id'] = null;
                }

                // If computer file_no has been updated then find the associated case_id and update in CM/CRM
                if ($TodoData['ClientCase']['computer_file_no'] != $this->request->data['Todo']['computer_file_no'] && !empty($this->request->data['Todo']['computer_file_no'])) {
                    $caseData = $this->Todo->ClientCase->find('first', array('conditions' => array('computer_file_no' => $this->request->data['Todo']['computer_file_no'], 'user_id' => $this->Session->read('UserInfo.uid'))));
                    if (!empty($caseData)) {
                        $this->request->data['Todo']['client_case_id'] = $caseData['ClientCase']['id'];
                    } else {
                        $this->Todo->validationErrors['computer_file_no'] = ['Please enter valid computer_file_no'];
                    }
                }

                if (empty($this->Todo->validationErrors)) {
                    $this->request->data['Todo']['user_id'] = $this->Session->read('UserInfo.uid');
                    $this->Todo->set($this->request->data['Todo']);
                    if ($this->Todo->validates()) {
                        $this->Todo->id = $id;
                        if ($this->Todo->save($this->request->data)) {
                            $this->Flash->success(__('The Todo has been saved.'));
                            if ($this->data['Todo']['referer'] == 'caseTodos') {
                                return $this->redirect(array('controller' => 'Todos', 'action' => 'caseTodos', $this->data['Todo']['case_id']));
                            } else {
                                return $this->redirect(array('controller' => 'Todos', 'action' => 'index'));
                            }
                        } else {
                            $this->Flash->error(__('The Todo could not be saved. Please, try again.'));
                        }
                    }
                }
            } else {
                $this->request->data = $TodoData;
            }
            $this->set(compact('id', 'computer_file_no'));

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
        $TodoData = $this->Todo->find('first', array('conditions' => array('Todo.user_id' => $this->Session->read('UserInfo.uid'), 'Todo.id' => $id)));
        if (!empty($TodoData)) {
            if ($this->request->is(array('get', 'delete'))) {
                $this->Todo->id = $id;
                if ($this->Todo->delete()) {
                    $this->Flash->success(__('The Todo has been deleted successfully.'));
                } else {
                    $this->Flash->error(__('The Todo could not be deleted. Please, try again.'));
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
     * view the details of the given Todo ID.
     *
     * @param string $id
     */
    public function view($id = null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Todo Details';
        $this->set('pageTitle', $this->pageTitle);
        $TodoData = $this->Todo->find('first', array('contain' => array('ClientCase'), 'conditions' => array('Todo.user_id' => $this->Session->read('UserInfo.uid'), 'Todo.id' => $id)));
        if (!empty($TodoData)) {
            $this->set('Todo', $TodoData);

            // To see if the page has been accessed from case detail page or dispatches main page
            $referer_url_params = Router::parse($this->referer('/', true));
            $this->set('action', $referer_url_params['action']);
            if (!empty($referer_url_params['pass'])) {
                $this->set('caseId', $referer_url_params['pass'][0]);
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));

            return $this->redirect(Router::url($this->referer(), true));
        }
    }

    /**
     * Change status of given todo ID like Mark complete or Reopen.
     *
     * @param string $id
     */
    public function changeStatus($id = null)
    {
        $TodoData = $this->Todo->find('first', array('contain' => array('ClientCase'), 'conditions' => array('Todo.user_id' => $this->Session->read('UserInfo.uid'), 'Todo.id' => $id)));
        if (!empty($TodoData)) {            
            if ($TodoData['Todo']['status'] == 'pending') {
                $this->request->data['Todo']['status'] = 'completed';
            } else {
                $this->request->data['Todo']['status'] = 'pending';
            }
            $this->request->data['Todo']['title'] = $TodoData['Todo']['title'];
            $this->request->data['Todo']['priority'] = $TodoData['Todo']['priority'];
            $this->request->data['Todo']['completion_date'] = $TodoData['Todo']['completion_date'];
            
            $this->Todo->id = $id;
            if ($this->Todo->save($this->request->data)) {
                $this->Flash->success(__('The Todo has been updated.'));
                $this->redirect(Router::url($this->referer(), true));
            } else {
                $this->Flash->error(__('The Todo could not be updated. Please, try again.'));
                $this->redirect(Router::url($this->referer(), true));
            }
        } else {
            $this->Flash->error(__("The selected record doesn't exist. Please, try with valid record."));
            $this->redirect(Router::url($this->referer(), true));
        }
    }

    /**
     * Get all the CM/CRM of a case
     * @param  integer $caseId Case ID for which CM/CRM has to be fetched
     * @return [html]  View of case CM/CRM page
     */
    public function caseTodos($caseId)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Case Todos';
        $this->set('pageTitle', $this->pageTitle);

        $caseDetails = $this->_getCaseDetails($caseId);

        $this->Todo->bindModel(array('belongsTo' => array('ClientCase' => array('type' => 'INNER'))));
        $Todos = $this->Todo->find('all', array('contain' => array('ClientCase' => array('conditions' => array('ClientCase.id' => $caseId, 'ClientCase.user_id' => $this->Session->read('UserInfo.uid')))), 'conditions' => array('client_case_id' => $caseId), 'order' => 'completion_date DESC'));

        // To see if the page has been accessed from case detail page or dispatches main page then only show add button
        $this->set('show_add', true);
        $this->set(compact('caseDetails', 'caseId', 'Todos'));
    }

    private function _getCaseDetails($caseId)
    {
        $this->ClientCases = $this->Components->load('ClientCases');

        return $this->ClientCases->findByCaseId($caseId, $this->Session->read('UserInfo.lawyer_id'));
    }

    public function checkList()
    {
        # code...
        // If attachment has been given upload it to aws S3
        if (!empty($this->request->data['Todo']['attachment']['name'])) {
            $str = file_get_contents($this->request->data['Todo']['attachment']['tmp_name']);
            pr($str);
            die;
        }
    }
}
