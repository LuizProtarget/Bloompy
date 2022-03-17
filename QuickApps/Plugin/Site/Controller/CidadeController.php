<?php
/**
 * Cidade Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 no
 */
class CidadeController extends AppController {
	public $name = 'Cidade';
	public $uses = array('Site.Estado','Site.Cidade','Site.Pais');
	
	public function index($param = null) {
		
	}
	
	//listagem cidades admin
	public function admin_index()
	{
		$this->Cidade->recursive = 1;
		
		$paginationScope = array ();
		
		if (isset ( $this->data ['Cidade'] ['filter'] ) || $this->Session->check ( 'Cidade.filter' )) {
		
			if (isset ( $this->data ['Cidade'] ['filter'] ) && empty ( $this->data ['Cidade'] ['filter'] )) {
				$this->Session->delete ( 'Cidade.filter' );
			} else {
				$filter = isset ( $this->data ['Cidade'] ['filter'] ) ? $this->data ['Cidade'] ['filter'] : $this->Session->read ( 'Cidade.filter' );
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'Cidade.filter', $filter );
			}
		}
		
		if(isset($paginationScope['Cidade.id_pais']))
		{
			$filtroPais = $paginationScope['Cidade.id_pais'];
			unset($paginationScope['Cidade.id_pais']);
		}
		//var_dump($paginationScope);die;
		$this->paginate = array('order' => array('Cidade.nome_pt' => 'asc'));
		$results = $this->paginate('Cidade', $paginationScope);
		
		foreach($results as $ind => $result)
		{
			if(isset($filtroPais)):
				$exist = $this->Estado->findByIdAndId_pais($result['Cidade']['id_estado'],$filtroPais);
				
				if(!$exist):
					unset($results[$ind]);
					continue;
				endif;
				
				$estado = $this->Estado->findById($result['Cidade']['id_estado'],array('Estado.nome_pt','Estado.id_pais'));
				$pais = $this->Pais->findById($estado['Estado']['id_pais'],array('Pais.nome_pt'));
				
			else:
				
				$estado = $this->Estado->findById($result['Cidade']['id_estado'],array('Estado.nome_pt','Estado.id_pais'));
				$pais = $this->Pais->findById($estado['Estado']['id_pais'],array('Pais.nome_pt'));
			
			endif;
			
			$results[$ind]['Cidade']['pais'] = isset($pais['Pais']['nome_pt']) ? $pais['Pais']['nome_pt'] : null;
			$results[$ind]['Cidade']['estado'] = isset($estado['Estado']['nome_pt']) ? $estado['Estado']['nome_pt'] : null;
		}
		
		
		$paises = json_encode($this->getPaisesAndAsso());
		$this->set(compact('paises'));
		//$results = @Set::sort ( ( array ) $results, '{n}.LojaVirtual.settings.display.default.ordering.position', 'asc' );
		$this->set(compact('results'));
	}
	
	//adicionar cidades admin
	public function admin_add(){
	
	
		if(isset($this->data['Cidade']))
		{
			$data = $this->data['Cidade'];
			
			unset($data['id_pais']);
			
			if($this->Cidade->save($data))
			{
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/cidades');
			}
			else
			{
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			}
		}
	
		$paises = json_encode($this->getPaisesAndAsso());
		$this->set(compact('paises'));
	}
	
	//edit cidades
	public function admin_edit($id){
		
		$result = $this->Cidade->findById($id);
		
		if(isset($this->data['Cidade'])):
		
			$data = $this->data['Cidade'];
			
			unset($data['id_pais']);
			if($this->Cidade->save($data)):
			
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/cidades');
				
			else:
			
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			
			endif;
			
		endif;
		
		
		$estado = $this->Estado->findById($result['Cidade']['id_estado'],array('Estado.id_pais'));
		$id_pais = 0;
		if($estado):
		
			$pais = $this->Pais->findById($estado['Estado']['id_pais'],array('Pais.id'));
			
			if($pais):
				$id_pais = $pais['Pais']['id'];
			endif;
			
		endif;
		
		
		$paises = json_encode($this->getPaisesAndAsso());
		$this->set(compact('paises','id_pais'));
		
		$this->data = $result;
	}
	
	//deleta cidades
	public function admin_delete($id)
	{
		$result = $this->Cidade->findById($id);
	
		if($result):
				
			if($this->Cidade->delete($result['Cidade']['id'])):
	
				$this->flashMsg('Cidade excluida !!');
			else:
			
				$this->flashMsg('Erro ao tentar excluir !!','error');
			endif;
		
		else:
		
			$this->flashMsg('Não existe esta Cidade! contata-te o administrador !!','error');
		
		endif;
	
		$this->redirect('/admin/cidades');
	}
	
	protected function getPaisesAndAsso()
	{
	
		$paises = $this->Pais->getPaises();
		return $paises;
	}

}