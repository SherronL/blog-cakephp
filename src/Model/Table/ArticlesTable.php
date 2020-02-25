<?php
// src/Model/Table/ArticlesTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ArticlesTable extends Table{

    public function initialize(array $config){
        $this->addBehavior('Timestamp');
    }

    // validates data when save
    public function validationDefault(Validator $validator){
        $validator
            ->notEmpty('title')
            ->requirePresence('title')
            ->notEmpty('body')
            ->requirePresence('body');

        return $validator;
    }
    
    // check ownership
    public function isOwnedBy($articleId, $userId){
       // dd(func_get_args());
       // dd($this->exists(['user_id' => $userId, 'id' => $articleId]));
        return $this->exists(['user_id' => $userId, 'id' => $articleId]);   
    }

}