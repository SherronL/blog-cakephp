<?php
// src/Controller/UsersController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Firebase\JWT\JWT;
use Cake\Utility\Security;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $tokenUser = $this->Auth->identify();
        if($tokenUser){
           $this->Auth->setUser($tokenUser);
        }

      //  dd($tokenUser);
        $this->Auth->allow(['login', 'add', 'token']);
    }

    public function login()
    {

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
          //  dd([$this->Auth->identify(),$this->Auth->user()]);
            if ($user) {
            //    dd($user);
                $this->Auth->setUser($user);
            //    dd($this->Auth->redirectUrl());
             //   dd($this->request->getHeaderLine('content-type'));
                if(($this->request->getHeaderLine('content-type')) === 'application/json; charset=utf-8'){
                    $this->set([
                        'success' => true,
                        'data' => [
                            'token' => JWT::encode([
                            'sub' => $user['id'],  
                            'exp' =>  time() + 3600, // 1 hour
                            'role' => $user['role']
                            ],
                            Security::salt())
                        ],
                                '_serialize' => ['success', 'data']
                    ]);
                }
                else
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
     //   dd($user);
     //   dd($this->Auth->setUser(($this->Auth->identify())));
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
         //   dd($user);
          // && $this->request->getData('role') === 'author'
            if ($this->Users->save($user)) {
                // if the person making the request has a admin token
                // if()
                if(($this->request->getHeaderLine('content-type')) === 'application/json; charset=utf-8'){
                    $this->Flash->success(__('Thanks for registering'));
                    return $this->redirect($this->Auth->redirectUrl()); // redirect API requests to the articles page
                }
                else{
                    return $this->redirect(['action' => 'login']); // redirect regular requests to login page
                }

            }else {
                $this->Flash->error(__('Unable to register'));
            }   
        }
        $this->set('user', $user);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and login
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['register']); // array of pages to allow
    }
    
}