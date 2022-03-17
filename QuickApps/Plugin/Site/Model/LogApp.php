<?php
/**
 * Loja Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */

class LogApp extends AppModel {
	public $name = 'LogApp';
	public $useTable = "log_app";
		
	public $validate = array(
		'username' => array(
			'required' => true, 
			'allowEmpty' => false, 
			'rule' => 'notEmpty'
			//'message' => 'Preencha campo'
		)
	);
	
	public $virtualFields = array(
			'dataCreated' => 'DATE_FORMAT(FROM_UNIXTIME(`LogApp.created`), "%d-%m-%Y %H:%i:%s")'
	);
		
}