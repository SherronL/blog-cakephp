<?php
// src/Controller/UsersController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{
    // access restriction
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and login
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['register', 'login']); // array of pages to allow
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());

            }
            else
                $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
      $this->Flash->success('You are logged out');
      return $this->redirect($this->Auth->logout());
    }

    public function index()
    {
        $this->set('users', $this->Users->find('all'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Thanks for registering'));
                return $this->redirect(['action' => 'login']);
            }else {
                $this->Flash->error(__('Unable to register'));
            }   
        }
        $this->set('user', $user);
    }
    
    public function article_index()
    {
        // accessing db
        $articles = $this -> 
        set('articles', $this -> Articles -> find('all'));
    }

}