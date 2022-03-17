<?php
/**
 * Menu Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Controller
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br>
 * @link	 http://www.pronexo.com.br
 */
class ColecaoController extends AppController {
	public $name = 'Colecao';
	public $uses = array('Produtos.Colecao');

	
	public function admin_index() {
		$this->set('results', $this->paginate('Colecao'));
		
	}
	
	public function admin_add() {
		
		if(isset($this->data['Colecao']))
		{
			$d = $this->data;
			$d['Colecao']['date_add'] = date('Y-m-d H:i:s');
			$d['Colecao']['date_upd'] = date('Y-m-d H:i:s');
			
			if($this->Colecao->save($d))
				$this->flashMsg(__t('Coleção salva com sucesso'), 'success');
			else
				$this->flashMsg(__t('Coleção não pode ser salva. Por favor tente de novo.'), 'error');
			
			$this->redirect('/admin/produtos/colecao');
		}
		
		$this->setCrumb(
				'/admin/produtos/colecao',
				array(__t('Adicionar coleção'))
		);
		$this->title(__t('Adicionar coleção'));
	}
	
	public function admin_edit($id) {
		
		if($id>0)
		{
			
			if(!isset($this->data['Colecao']))
			{
				$this->data = $this->Colecao->find('first',
					array(
						'conditions' => array('Colecao.produto_colecao_id' => $id),
						'recursive' => -1
					)
				) or $this->redirect('/admin/produtos/colecao');
			}
			else
			{
				$d = $this->data;
				$d['Colecao']['produto_colecao_id'] = $id;
				$d['Colecao']['date_upd'] = date('Y-m-d H:i:s');
				
				if ($this->Colecao->save($d)) {
					$this->flashMsg(__t('Coleção salva com sucesso'), 'success');
				} else {
					$this->flashMsg(__t('Coleção não pode ser salva. Por favor tente de novo.'), 'error');
				}
			}
			
			$this->setCrumb(
					'/admin/produtos/colecao',
					array(__t('Editando coleção'))
			);
			$this->title(__t('Editando coleção'));
		}
		else
			$this->redirect('/admin/produtos/colecao');
	}
	
	
	public function admin_delete($id) {
		$result = $this->Colecao->findByProdutoColecaoId($id);

		if (!$result || $result['Colecao']['produto_colecao_id'] <1) {
			$this->redirect('/admin/produtos/colecao');
		}
		
		if($this->Colecao->delete($id))
			$this->flashMsg(__t('Coleção removida com sucesso'), 'success');
		else 
			$this->flashMsg(__t('Coleção não pode ser removida. Por favor tente de novo.'), 'error');
		
		$this->redirect($this->referer());
	}
}