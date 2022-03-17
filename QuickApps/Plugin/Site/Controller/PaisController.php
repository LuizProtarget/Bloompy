<?php
/**
 * Pais Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 no
 */
class PaisController extends AppController {
	public $name = 'Pais';
	public $uses = array('Site.Estado','Site.Cidade','Site.Pais');
	
	public function index($param = null) {
		
	}
	
	//listagem Pais admin
	public function admin_index()
	{
		$this->Estado->recursive = 1;
		
		$paginationScope = array ();
		
		if (isset ( $this->data ['Pais'] ['filter'] ) || $this->Session->check ( 'Pais.filter' )) {
		
			if (isset ( $this->data ['Pais'] ['filter'] ) && empty ( $this->data ['Pais'] ['filter'] )) {
				$this->Session->delete ( 'Pais.filter' );
			} else {
				$filter = isset ( $this->data ['Pais'] ['filter'] ) ? $this->data ['Pais'] ['filter'] : $this->Session->read ( 'Pais.filter' );
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'Pais.filter', $filter );
			}
		}
		
		//var_dump($paginationScope);die;
		$this->paginate = array('order' => array('Pais.nome_pt' => 'asc'));
		$results = $this->paginate('Pais', $paginationScope);
		
		$this->set(compact('results'));
	}
	
	//adicionar Pais admin
	public function admin_add(){
		
		if(isset($this->data['Pais'])):
		
			$data = $this->data['Pais'];
			
			if($this->Pais->save($data)):
			
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/paises');
			
			else:
			
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			
			endif;
		endif;
	}
	
	//edit Pais
	public function admin_edit($id){
		
		$result = $this->Pais->findById($id);
		
		if(isset($this->data['Pais'])):
		
			$data = $this->data['Pais'];
			
			if($this->Pais->save($data)):
			
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/paises');
			
			else:
			
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			
			endif;
		endif;
		
		$this->data = $result;
	}
	
	//deleta Estado
	public function admin_delete($id)
	{
		$result = $this->Pais->findById($id);
	
		if($result):
				
			if($this->Pais->delete($result['Pais']['id'])):
	
				$this->flashMsg('Pais excluido !!');
			else:
			
				$this->flashMsg('Erro ao tentar excluir !!','error');
			endif;
		
		else:
		
			$this->flashMsg('Não existe este Pais! contata-te o administrador !!','error');
		
		endif;
	
		$this->redirect('/admin/paises');
	}

}