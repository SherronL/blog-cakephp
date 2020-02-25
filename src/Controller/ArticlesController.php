<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class ArticlesController extends AppController
{
     public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 100,
        'fields' => [
             'title', 'body', 'user_id'
        ],
        'sortWhitelist' => [
            'title', 'body'
        ]
    ];


    public function initialize()
    {
        parent::initialize();
        $this -> loadcomponent('Flash'); // includes FlashComponent
    }

    public function index()
    {
        // accessing db
        $articles = $this -> 
        set('articles', $this -> Articles -> find('all'));
        $this->set('_serialize', 'articles'); // serialize to json structure

    }

    // if user request /articles/view/3, then 3 gets passed to id
    public function view($id = null)
    {
        $article = $this -> Articles -> get($id);
        // set passes data from the controller to the view
        $this -> set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            // Prior to 3.4.0 $this->request->data() was used.
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            // set user_id in Articles table to the users id
            $article->user_id = $this->Auth->user('id');
            
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
    
    }

    public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
    }
    
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
      }
  
    // overrides isAuthorized in AppController
    public function isAuthorized($user)
    {
        // All registered users can add articles
        // Prior to 3.4.0 $this->request->param('action') was used.
        if ($this->request->getParam('action') === 'add') {
            return true;
        }

        // The owner of an article can edit and delete it
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $articleId = (int)$this->request->getParam('pass.0');
           // dd($this->request->getParam('pass.0'));
            if (!$this->Articles->isOwnedBy($articleId, $user['id'])) {

                if($user['role'] === 'admin'){
                    return true;
                }
                else{
                    return false;
                }
            }

       //     return true;
        }
        return parent::isAuthorized($user);
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->Auth->allow('index','view');
        //$this->Auth->allow();
    }

}
