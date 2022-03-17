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
App::import('vendors','upload');

class SkusController extends AppController {
	public $name = 'Skus';
	public $uses = array('Produtos.Produtos','Produtos.Linha','Produtos.Colecao','Produtos.Skus','Produtos.SkusFoto');
	public $helpers = array('Js');
	public $components = array(
			'Security' => array(
				'csrfUseOnce' => false
			)
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}

	public function admin_add()
	{
		if($this->request->is('post'))
		{
			$d = $this->data;
			$d['Skus']['date_add'] = date('Y-m-d H:i:s');
			$d['Skus']['position'] = $this->getMaxPosSku();
			
			$success = false;
			$success = $this->Skus->save($d);
			
			if($success)
				print '{"status":'.(int)$success.', "product_sku_id":'.$this->Skus->id.'}';
			else
				print '{"status":'.(int)$success.', "error_msg":"Não foi possível salvar o SKU"}';
			exit;
		}
	}

	public function admin_get()
	{		
		if($this->params['isAjax'])
		{
			$id 	= (int)$this->data['Skus']['produto_sku_id'];		
			$rows 	= array();
			
			$skus = $this->Skus->find('first',array(
				'conditions' => array('Skus.produto_sku_id' => $id),
				'recursive' => -1
			));
			
			if(is_array($skus))
				foreach($skus as $sku_row)
				{
					$rows[]= '{"referencia":"'.$sku_row['referencia'].'", "produto_cor_id":"'.$sku_row['produto_cor_id'].'", "produto_sku_id":"'.$sku_row['produto_sku_id'].'", "exibir_site":"'.$sku_row['exibir_site'].'", "exibir_mobile":"'.$sku_row['exibir_mobile'].'"}';
				}
				
			print '['.implode(',',$rows).']';
			exit;
		}
	}

	public function admin_getFotos()
	{
		if($this->params['isAjax'])
		{
			$id 	= (int)$this->data['Skus']['produto_sku_id'];
			$rows 	= array();
				
			$skusFoto = $this->SkusFoto->find('all',array(
					'order'=>array('position asc'),
					'conditions' => array('produto_sku_id' => $id),
					'recursive' => -1
			));
				
			if(is_array($skusFoto))
				foreach($skusFoto as $skusFoto_row)
				{
					$rows[]= '{"produto_sku_foto_id":'.$skusFoto_row['SkusFoto']['produto_sku_foto_id'].', "produto_sku_id":'.$skusFoto_row['SkusFoto']['produto_sku_id'].', "image":"img/produtos/thumb/'.$skusFoto_row['SkusFoto']['filename'].'"}';
				}
		
				print '['.implode(',',$rows).']';
				exit;
		}
	}
	
	public function admin_delete()
	{
		if($this->params['isAjax'])
		{
			$id = (int)$this->data['Skus']['produto_sku_id'];
				
			if($this->Skus->delete($id, true))
				print '[{"status":1, "produto_sku_id":'.$id.'}]';
			else
				print '[{"status":0, "produto_sku_id":'.$id.'}]';
		}
		exit;
	}
	
	public function admin_foto($produto_id)
	{
		if($produto_id>0)
		{
			// Dados do produto
			$this->Produtos->recursive = 2;
			$result = $this->Produtos->findByProdutoId($produto_id);
			
			// Galeria de imanges do produto
			$this->Skus->recursive = -1;
			$resultFotos = $this->Skus->find('all',array('condition' => array('produto_id'=> $produto_id)));
			
			$this->setCrumb(
					'/admin/produtos/produtos/',
					array(__t('Upload de fotos'))
			);
	
			$this->title(__t('Upload de fotos'));
			
			$this->set('resultDados', $result);
			$this->set('resultFotos', $resultFotos);
		}
	}
	
	
	public function admin_upload()
	{

		$success = false;
		
		$d 								= $this->data;
		$d['SkusFoto']['date_add'] 		= date('Y-m-d H:i:s');
		$d['SkusFoto']['produto_sku_id']= $d['Skus']['produto_sku_id'];
		
		$_FILES['data']['name'] 	= $_FILES['Filedata']['name'];
		$_FILES['data']['type'] 	= $_FILES['Filedata']['type'];
		$_FILES['data']['tmp_name'] = $_FILES['Filedata']['tmp_name'];
		$_FILES['data']['error'] 	= $_FILES['Filedata']['error'];
		$_FILES['data']['size'] 	= $_FILES['Filedata']['size'];
		
		$handle = new upload($_FILES['data']);
		
	   if ($handle->uploaded) 
	   {
	   		$fileext = $handle->file_src_name_ext;
	   		$filename = uniqid(time());
	   		//print $handle->image_src_x;
	   		// Salva imagem do produto FULL para o site
	   		$handle->file_new_name_body   = $filename;
	   		$handle->image_resize         = true;
	   		$handle->image_x              = 650;
	   		$handle->image_ratio_y        = true;
	   		//$handle->image_ratio_pixels   = true;
	   		//$handle->image_ratio_pixels              = true;
	   		$handle->jpeg_quality         = 99;
	   		$handle->allowed = array('image/*');
	   		$handle->forbidden = array('application/*');
			$handle->process(WWW_ROOT . 'img/produtos/');
	   		
	   	   // Salva imagem do produto THUMB para o site
	   	   
	       $handle->file_new_name_body   = $filename;
	       //$handle->image_convert = 'jpg';
	       $handle->image_resize         = true;
	       $handle->image_x              = 150;
	       //$handle->jpeg_quality       = 99;
	       $handle->image_ratio_y        = true;
	       $handle->allowed 			 = array('image/*');
	       $handle->forbidden 			 = array('application/*');
	       $handle->process(WWW_ROOT . 'img/produtos/thumb/');
	       
	       // Salva imagem do produto FULL para App Mobile
	       $handle->file_new_name_body   = $filename;
	       $handle->image_resize         = true;
	       //$handle->image_convert = 'jpg';
	       //$handle->jpeg_quality         = 99;
	       $handle->image_x              = $handle->image_src_x >= 2000 ? 2000 : $handle->image_src_x;
	       $handle->image_ratio_y        = true;
	       $handle->allowed = array('image/*');
	       $handle->forbidden = array('application/*');
	       $handle->process(WWW_ROOT . 'img/produtos/mobile/');
	       	       
	       if ($handle->processed) {
	           $success = true;
	           $handle->clean();
	       } 
	   }
	   
	   $status = 0;
	   if($success)
	   {
			$d['SkusFoto']['filename'] = $filename . '.' . $fileext;
			$d['SkusFoto']['position'] = $this->getMaxPos();
			
			if($this->SkusFoto->save($d))
				$status = 1;
	   }
	   
	   print '{"status":'.$status.'}';
	   exit;
	}
	
	//posição foto
	public function admin_position()
	{
		$d = $this->data;
		
		$this->SkusFoto->updatePosition($d['Skus']['produto_sku_id'], $d['Skus']['produto_sku_foto_id'], $d['Skus']['position'], $d['way']);
		exit;
	}
	
	protected function getMaxPos()
	{
		$this->SkusFoto->recursive = -1;
		$resultFotos = $this->SkusFoto->find('first',array('order' => array('position DESC')));
		
		$posicao = 1;
		
		if(is_array($resultFotos) && count($resultFotos)>0)
			foreach($resultFotos as $rowFotos)
				$posicao = $rowFotos['position'] + 1;
		
		return $posicao;
	}
	
	//remover fotos
	public function admin_removerFoto()
	{
		$d = $this->data;
	
		if($this->SkusFoto->delete($d['Skus']['produto_sku_foto_id']))
			$status=1;
		else 
			$status=0;
		
		print '[{"status":'.$status.'}]';
		exit;
	}
	
	//posição sku
	public function admin_positionSku()
	{
		$d = $this->data;
		//App::uses('Skus', 'Produtos.Model');
		$this->Skus->updatePosition($d['Skus']['produto_id'], $d['Skus']['sku_id'], $d['Skus']['position'], $d['way']);
		exit;
	}
	
	protected function getMaxPosSku()
	{
		$this->Skus->recursive = -1;
		$resultFotos = $this->Skus->find('first',array('order' => array('position DESC')));
	
		$posicao = 1;
	
		if(is_array($resultFotos) && count($resultFotos)>0)
			foreach($resultFotos as $rowFotos)
			$posicao = $rowFotos['position'] + 1;
	
		return $posicao;
	}
}