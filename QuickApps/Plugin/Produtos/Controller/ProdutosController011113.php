<?php
/**
 * Prodtos Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Controller
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br>
 * @link	 http://www.pronexo.com.br
 */
class ProdutosController extends AppController {
	public $name = 'Produtos';
	public $uses = array('Produtos.Produtos','Produtos.Linha','Produtos.Colecao','Produtos.Skus', 'Produtos.SkusFoto', 'Produtos.Cores');
	public $helpers = array('Js');
	public $components = array(
			'Security' => array(
					'csrfUseOnce' => false
			),
			'RequestHandler'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}
	
	public function index() {
		$this->Skus->recursive = 2;
		if($this->RequestHandler->isXml())
		{
			$produtos = $this->Skus->find('all');
			
			$this->set(array(
					'produtos' => $produtos,
					'_serialize' => array('produtos')
			));
		}
	}
	
	public function admin_index() {
		$this->Produtos->recursive = 2;
		$this->paginate = array('order' => array('Produtos.position' => 'asc'));
		$this->set('results', $this->paginate('Produtos'));
	}
	
	public function admin_add() {
		
		// Caso tenha sido postado os dados
		if(isset($this->data['Produtos']))
		{
			$d = $this->data;
			$d['Produtos']['date_add'] = date('Y-m-d H:i:s');
			$d['Produtos']['date_upd'] = date('Y-m-d H:i:s');
			$d['Produtos']['position'] = $this->getMaxPos();
			$success = false;
			
			if(($success = $this->Produtos->save($d)) == true)
				$this->flashMsg(__t('Produto adicionado com sucesso'), 'success');
			else
				$this->flashMsg(__t('Produto não pode ser adicionado. Por favor tente de novo.'), 'error');
			
			if($success)
				$this->Session->write('Produto.id', $this->Produtos->id);
			
			$this->redirect($this->referer());
		}
		
		
		// Lista de colecoes
		$colecaoList = $this->Colecao->getList();
		$this->set('colecao_list', $colecaoList);
		
		// Lista de cores
		$coresList = $this->Cores->getList();
		$this->set('cores_list', $coresList);
		
		// Caso esteja setada a var ID em sessao, consulta registro
		if($this->Session->check('Produto.id'))
		{
			$product_id = $this->Session->read('Produto.id');
		
			$produto = $this->Produtos->find('first',
				array (
						'conditions' => array('Produtos.produto_id' => $product_id),
						'recursive' => 2
				)
			) or $this->redirect('/admin/produtos/produtos/');
			$this->set('produto', $produto);
				
				
			// Retorna lista de linhas
			$linhas = $this->Linha->getList();
			$this->set('linhas_list', $linhas);
			
			// Retorna lista de SKU
			$skus = $this->Skus->find('all',array(
				'conditions' => array('Skus.produto_id' => $product_id),
				'order' => array('Skus.position' => 'asc')	,
				'recursive' => 0
			));
			$this->set('skus_list', $skus);
			$this->set('session_id', $this->Session->id());
		}
		
		$this->setCrumb(
				'/admin/produtos/produtos/',
				array(__t('Adicionar produto'))
		);
		$this->title(__t('Adicionar produto'));
	}
	
	
	public function admin_clear($id) {
		
		// Caso esteja setada a var ID em sessao, consulta registro
		if($this->Session->check('Produto.id'))
			$this->Session->delete('Produto.id');
		
		if($id>0)
			$this->Session->write('Produto.id', $id);
		
		$this->redirect('/admin/produtos/produtos/add');
	}
	
	
	public function admin_delete($id) {
		$result = $this->Produtos->findByProdutoId($id);

		if (!$result || $result['Produtos']['produto_id'] <1) {
			$this->redirect('/admin/produtos/produtos');
		}
		
		if($this->Produtos->delete($id))
			$this->flashMsg(__t('Produto removido com sucesso'), 'success');
		else 
			$this->flashMsg(__t('Produto não pode ser removido. Por favor tente de novo.'), 'error');
		
		$this->redirect($this->referer());
	}
	
	
	public function admin_foto($produto_id)
	{
		if($produto_id>0)
		{
			$this->Produtos->recursive = 2;
			$result = $this->Produtos->findByProdutoId($produto_id);
			
			$this->setCrumb(
					'/admin/produtos/produtos/foto',
					array(__t('Upload de fotos'))
			);
	
			$this->title(__t('Upload de fotos'));
			
			$this->set('resultDados', $result);
		}
	}
	
	//posição produtos
	public function admin_position()
	{
		$d = $this->data;
		
		$this->Produtos->updatePosition($d['Linha']['linha_id'], $d['Produtos']['produto_id'], $d['Produtos']['position'], $d['way']);
		exit;
	}
	
	protected function getMaxPos()
	{
		$this->Produtos->recursive = -1;
		$resultFotos = $this->Produtos->find('first',array('order' => array('position DESC')));
	
		$posicao = 1;
	
		if(is_array($resultFotos) && count($resultFotos)>0)
			foreach($resultFotos as $rowFotos)
			$posicao = $rowFotos['position'] + 1;
	
		return $posicao;
	}
}