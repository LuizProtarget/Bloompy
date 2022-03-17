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
class LinhaController extends AppController {
	public $name = 'Linha';
	public $uses = array('Produtos.Linha','Produtos.Colecao');

	
	public function admin_index() {
		$this->set('results', $this->paginate('Linha'));
		
	}
	
	public function admin_add() 
	{
		
		// Lista de colecoes
		$colecaoList = $this->Colecao->getList();
		$this->set('colecao_list', $colecaoList);
		
		if(isset($this->data['Linha']))
		{
			$d = $this->data;
			$d['Linha']['date_add'] = date('Y-m-d H:i:s');
			$d['Linha']['date_upd'] = date('Y-m-d H:i:s');
			
			if($this->Linha->save($d))
				$this->flashMsg(__t('Linha salva com sucesso'), 'success');
			else
				$this->flashMsg(__t('Linha não pode ser salva. Por favor tente de novo.'), 'error');
			
			$this->redirect('/admin/produtos/linha');
		}
		
		$this->setCrumb(
				'/admin/produtos/linha',
				array(__t('Adicionar linha'))
		);
		$this->title(__t('Adicionar linha'));
	}
	
	public function admin_edit($id) 
	{
		
		// Lista de colecoes
		$colecaoList = $this->Colecao->getList();
		$this->set('colecao_list', $colecaoList);
		
		if($id>0)
		{
			if(!isset($this->data['Linha']))
			{
				$this->data = $this->Linha->find('first',
					array(
						'conditions' => array('Linha.produto_linha_id' => $id),
						'recursive' => -1
					)
				) or $this->redirect('/admin/produtos/linha');
			}
			else
			{

				$d = $this->data;
				$d['Linha']['produto_linha_id'] = (int)$id;
				$d['Linha']['date_upd'] = date('Y-m-d H:i:s');

				if ($this->Linha->save($d)) {
					$this->flashMsg(__t('Linha salva com sucesso'), 'success');
				} else {
					$this->flashMsg(__t('Linha não pode ser salva. Por favor tente de novo.'), 'error');
				}
			}
			
			$this->setCrumb(
					'/admin/produtos/linha',
					array(__t('Editando linha'))
			);
			$this->title(__t('Editando linha'));
		}
		else
			$this->redirect('/admin/produtos/linha');
	}
	
	
	public function admin_delete($id) {
		
		if($this->Linha->delete($id))
			$this->flashMsg(__t('Linha removida com sucesso'), 'success');
		else 
			$this->flashMsg(__t('Linha não pode ser removida. Por favor tente de novo.'), 'error');
		
		$this->redirect($this->referer());
	}
	
	public function admin_ajaxColecao($cid)
	{
		die( json_encode($this->Linha->getListOfColecao($cid)) );
	}
}