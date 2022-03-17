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
class CoresController extends AppController {
	public $name = 'Cores';
	public $uses = array('Produtos.Cores');

	
	public function admin_index() {
		$this->set('results', $this->paginate('Cores'));
		
	}
	
	public function admin_add() {
		
		if(isset($this->data['Cores']))
		{
			$d = $this->data;
			$d['Cores']['date_add'] = date('Y-m-d H:i:s');
			$d['Cores']['date_upd'] = date('Y-m-d H:i:s');
			
			if($this->Cores->save($d))
				$this->flashMsg(__t('Cor salva com sucesso'), 'success');
			else
				$this->flashMsg(__t('Cor não pode ser salva. Por favor tente de novo.'), 'error');
			
			$this->redirect('/admin/produtos/cores');
		}
		
		$this->setCrumb(
				'/admin/produtos/cores',
				array(__t('Adicionar cor'))
		);
		$this->title(__t('Adicionar cor'));
	}
	
	public function admin_edit($id) {
		
		if($id>0)
		{
			
			if(!isset($this->data['Cores']))
			{
				$this->data = $this->Cores->find('first',
					array(
						'conditions' => array('Cores.produto_cor_id' => $id),
						'recursive' => -1
					)
				) or $this->redirect('/admin/produtos/cores');
			}
			else
			{
				$d = $this->data;
				$d['Cores']['produto_cor_id'] = $id;
				$d['Cores']['date_upd'] = date('Y-m-d H:i:s');
				
				if ($this->Cores->save($d)) {
					$this->flashMsg(__t('Cor salva com sucesso'), 'success');
				} else {
					$this->flashMsg(__t('Cor não pode ser salva. Por favor tente de novo.'), 'error');
				}
			}
			
			$this->setCrumb(
					'/admin/produtos/cores',
					array(__t('Editando cor'))
			);
			$this->title(__t('Editando cor'));
		}
		else
			$this->redirect('/admin/produtos/cores');
	}
	
	
	public function admin_delete($id) {
			
		if($this->Cores->delete($id))
			$this->flashMsg(__t('Cor removida com sucesso'), 'success');
		else 
			$this->flashMsg(__t('Cor não pode ser removida. Por favor tente de novo.'), 'error');
		
		$this->redirect($this->referer());
	}
}