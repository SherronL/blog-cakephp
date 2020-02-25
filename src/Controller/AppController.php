<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{
   
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        // AUTH 
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'users',
                'action' => 'login',
                // 'admin' => false
            ],
            'loginRedirect' => [
                'controller' => 'Articles',
                'action' => 'index',
                // 'admin' => false
            ],
            'logoutRedirect' => [
                'controller' => 'Articles',
                'action' => 'index',
                'admin' => false
            ],
            'authorize' => 'Controller',
            'authError' => 'Access denied',

            'storage' => 'Session',

            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ]
                  //   'contain' => ['role']
                ],
                'ADmad/JwtAuth.Jwt' => [
                    'parameter' => 'token',
                    'userModel' => 'Users',
                    'fields' => [
                        'username' => 'id'
                    ],
                    'queryDatasource' => true
                ]
            ],
            'unauthorizedRedirect' => false,
          //  'checkAuthIn' => 'Controller.initialize' // this is fucking things up
        ]);

     //   dd([$this->Auth->user(),$this->request]);
    }

    public function beforeFilter(Event $event)
    {
        // dd([
        //     $this->request->getParam('action'),
        //     $this->request->getParam('controller')
        // ]);

        parent::beforeFilter($event);
        $this->Auth->allow('view');

        // check if user is logged in
        if($this->Auth->user()) {
            //dd($this->Auth->user());
            $this->set('loggedIn', true);
            if($this->Auth->user('role') === 'admin'){
                $this->set('isAdmin', true);
                
                $this->Auth->config([
                    'unauthorizedRedirect' => false,
                ]);
            }
            else{
                $this->set('isAdmin', false);
            }

        }
        else {
            $this->set('loggedIn', false);
        }
  
    }   

    public function isAuthorized($user)
    {

        // Any registered user can access public functions
        if (!$this->request->getParam('prefix')) {
            return true;
        }

        // Only admins can access admin functions
        if ($this->request->getParam('prefix') === 'admin') {
            return (bool)($user['role'] === 'admin');
        }

        // Default deny
        return false;
     }

}


