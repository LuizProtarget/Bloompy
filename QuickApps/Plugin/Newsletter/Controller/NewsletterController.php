<?php
/**
 * Newsletter Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Newsletter.Controller
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
class NewsletterController extends AppController {
	public $name = 'Newsletter';
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}
	
	public function admin_index($param = null) {
		
	}
	
	public function add($param = null) {
		$this->autoRender  = false;
		
		if($this->data['email']):
		
			$data = $this->data;
		
			if($this->Newsletter->save($data)):
				
				return json_encode(array('sucesso' => true));
			
			else:
			
				return json_encode(array('sucesso' => false));
			
			endif;
		else:
		
			return json_encode(array('sucesso' => false));
		
		endif;
		
		return json_encode(array('sucesso' => false));
	}

}