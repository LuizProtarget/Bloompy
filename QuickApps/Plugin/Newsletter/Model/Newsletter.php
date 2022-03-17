<?php
/**
 * Newsletter Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Newsletter.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
class Newsletter extends AppModel {
	public $name = 'Newsletter';
	public $useTable = "newsletter";
	public $validate = array(
		'email' => array(
			'required' => true, 
			'allowEmpty' => false, 
			'rule' => 'email',
			'message' => 'Verifique se é um email válido!'
		),
	);
}