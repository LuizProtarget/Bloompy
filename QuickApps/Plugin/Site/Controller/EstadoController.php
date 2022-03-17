<?php
/**
 * Estado Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 no
 */
class EstadoController extends AppController {
	public $name = 'Estado';
	public $uses = array('Site.Estado','Site.Cidade','Site.Pais');
	
	public function index($param = null) {
		
	}
	
	//listagem Estado admin
	public function admin_index()
	{
		$this->Estado->recursive = 1;
		
		$paginationScope = array ();
		
		if (isset ( $this->data ['Estado'] ['filter'] ) || $this->Session->check ( 'Estado.filter' )) {
		
			if (isset ( $this->data ['Estado'] ['filter'] ) && empty ( $this->data ['Estado'] ['filter'] )) {
				$this->Session->delete ( 'Estado.filter' );
			} else {
				$filter = isset ( $this->data ['Estado'] ['filter'] ) ? $this->data ['Estado'] ['filter'] : $this->Session->read ( 'Estado.filter' );
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'Estado.filter', $filter );
			}
		}
		
		//var_dump($paginationScope);die;
		$this->paginate = array('order' => array('Estado.nome_pt' => 'asc'));
		$results = $this->paginate('Estado', $paginationScope);
		
		foreach($results as $ind => $result):
		
			$pais = $this->Pais->findById($result['Estado']['id_pais'],array('Pais.nome_pt'));
			
			$results[$ind]['Estado']['pais'] = isset($pais['Pais']['nome_pt']) ? $pais['Pais']['nome_pt'] : null;
			
		endforeach;
		
		
		$paises = $this->Pais->getPaisesAdminEstado();
		
		$this->set(compact('paises'));
		//$results = @Set::sort ( ( array ) $results, '{n}.LojaVirtual.settings.display.default.ordering.position', 'asc' );
		$this->set(compact('results'));
	}
	
	//adicionar Estado admin
	public function admin_add(){
		
		if(isset($this->data['Estado'])):
		
			$data = $this->data['Estado'];
			
			if($this->Estado->save($data)):
			
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/estados');
			
			else:
			
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			
			endif;
		endif;
	
		$paises = $this->Pais->getPaisesAdminEstadoSelect();
		$this->set(compact('paises'));
	}
	
	//edit Estado
	public function admin_edit($id){
		
		$result = $this->Estado->findById($id);
		
		if(isset($this->data['Estado'])):
		
			$data = $this->data['Estado'];
			
			if($this->Estado->save($data)):
			
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/estados');
			
			else:
			
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			
			endif;
		endif;
	
		$paises = $this->Pais->getPaisesAdminEstadoSelect();
		$this->set(compact('paises'));
		
		$this->data = $result;
	}
	
	//deleta Estado
	public function admin_delete($id)
	{
		$result = $this->Estado->findById($id);
	
		if($result):
				
			if($this->Estado->delete($result['Estado']['id'])):
	
				$this->flashMsg('Estado excluido !!');
			else:
			
				$this->flashMsg('Erro ao tentar excluir !!','error');
			endif;
		
		else:
		
			$this->flashMsg('Não existe este Estado! contata-te o administrador !!','error');
		
		endif;
	
		$this->redirect('/admin/estados');
	}
	
	protected function getPaisesAndAsso()
	{
	
		$paises = $this->Pais->getPaises();
		return $paises;
	}

}