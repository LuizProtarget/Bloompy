<?php
/**
 * LogApp Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 no
 */
class LogAppController extends AppController {
	public $name = 'LogApp';
	//public $uses = array('Site.Loja','Site.Estado','Site.Cidade','Site.Representante','Site.LojaVirtual','Site.Pais');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}
	
	//listagem admin
	public function admin_index(){
		
		$this->LogApp->recursive = 1;
		$this->paginate = array('order' => array(
				'LogApp.created' => 'desc'
			));
		
		$paginationScope = array ();
		
		if (isset ( $this->data ['LogApp'] ['filter'] ) || $this->Session->check ( 'LogApp.filter' )) {
				
			if (isset ( $this->data ['LogApp'] ['filter'] ) && empty ( $this->data ['LogApp'] ['filter'] )) {
				$this->Session->delete ( 'LogApp.filter' );
			} else {
				$filter = isset ( $this->data ['LogApp'] ['filter'] ) ? $this->data ['LogApp'] ['filter'] : $this->Session->read ( 'LogApp.filter' );
		
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'LogApp.filter', $filter );
			}
		}
		
		$results = $this->paginate('LogApp', $paginationScope);
		
		foreach($results as $i => $log):
			
			//localizalição
			$results[$i]['LogApp']['geo'] = ( ($log['LogApp']['geo'] != "0 0" && $log['LogApp']['geo'] != null) ? "<a target='_blank' href='https://maps.google.com.br/maps?q=".str_replace(' ','+',$log['LogApp']['geo'])."&hl=pt-BR' >Localizar</a>" : "Não há" );
			
		endforeach;
		
		$this->set(compact('results'));
	}

}