<?php

class Contato extends AppModel {

    public $useTable = 'contatos';
    public $validate = array(
        'name' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('notEmpty'),
            'message' => "Informe seu nome."
            ),
        'email' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('email'),
        	'message' => "Informe um email válido."
        ),
    	'state' => array(
    		'required' => true,
    		'allowEmpty' => false,
    		'rule' => array('notEmpty'),
    		'message' => "Informe seu Estado."
    	),
    	'city' => array(
    		'required' => true,
    		'allowEmpty' => false,
    		'rule' => array('notEmpty'),
    		'message' => "Informe sua Cidade."
    	),
    	'fone' => array(
    		'required' => true,
    		'allowEmpty' => false,
    		'rule' => array('notEmpty'),
    		'message' => "Informe sue Telefone."
    	),
        'subject' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('minLength',3),
            'message' => "Informe um assunto com mais de duas letras!"
            ),
        'body' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('minLength',10),
            'message' => "A mensagem deve ao menos ter 10 letras."
            ),
    );

    public function beforeSave($options = Array()) {
        return true;
    }

    public function beforeDelete($cascade = true) {
        return true;
    }

    public function afterDelete() {

    }

    public function afterSave($created) {
        
    }

}