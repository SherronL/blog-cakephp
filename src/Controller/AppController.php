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
                'admin' => false
            ],
            'loginRedirect' => [
                'controller' => 'Articles',
                'action' => 'index',
                'admin' => false
            ],
            'logoutRedirect' => [
                'controller' => 'Articles',
                'action' => 'index',
                'admin' => false
            ],
            'authError' => 'Access denied',
            'storage' => 'Session',
            'authorize' => 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ]
                ]
            ],

        ]);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // $this->Auth->allow(['index', 'view', 'display']);
        $this->Auth->allow('view');

        // check if user is logged in
        if($this->request->session()->read('Auth.User')) {
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


