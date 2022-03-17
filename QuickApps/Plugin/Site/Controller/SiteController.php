<?php
/**
 * Site Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 no
 */
class SiteController extends AppController {
	public $name = 'Site';
	public $uses = array('Site.Loja','Site.Estado','Site.Cidade','Site.Representante','Site.LojaVirtual','Site.Pais','Site.TabelaPreco','Site.Pdv');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}
	
	public function index($param = null) {
		
	}
	
	
	//listagem admin lojas
	public function admin_lojas(){
		
		$this->Loja->recursive = 1;
		$paginationScope = array ();
		
		if (isset ( $this->data ['Loja'] ['filter'] ) || $this->Session->check ( 'Loja.filter' )) {
				
			if (isset ( $this->data ['Loja'] ['filter'] ) && empty ( $this->data ['Loja'] ['filter'] )) {
				$this->Session->delete ( 'Loja.filter' );
			} else {
				$filter = isset ( $this->data ['Loja'] ['filter'] ) ? $this->data ['Loja'] ['filter'] : $this->Session->read ( 'Loja.filter' );
		
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'Loja.filter', $filter );
			}
		}
		
		$results = $this->paginate('Loja', $paginationScope);
		
		foreach($results as $k => $result){
			
			$pais = $this->Pais->findById($result['Loja']['id_pais']);
			$estado = $this->Estado->findById($result['Loja']['id_estado']);
			$cidade = $this->Cidade->findById($result['Loja']['id_cidade']);
			$this->Language->recursive = 1;
			
			
			$results[$k]['Loja']['pais'] = $pais['Pais']['nome_pt'];
			$results[$k]['Loja']['estado'] = $estado['Estado']['nome_pt'];
			$results[$k]['Loja']['cidade'] = $cidade['Cidade']['nome_pt'];
		}
		
		$paises = $this->Pais->getPaisesAdminEstadoSelect();
		//echo $paises;die;
		$this->set(compact('paises'));
		
		$this->set(compact('results'));
	}
	
	//adicionar loja admin
	public function admin_loja_add(){
		
		if(isset($this->data['Loja']))
		{
			$data = $this->data['Loja'];
				
			if($this->Loja->save($data))
			{
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/lojas');
			}
			else
			{
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			}
		}
		
		//pega países, estados e cidades
		$paises = json_encode($this->getPaisesAndAsso());
		//echo $paises;die;
		$this->set(compact('paises'));
	}
	
	//editar loja admin
	public function admin_loja_edit($id){
	
		
		if(isset($this->data['Loja']))
		{
			$data = $this->data['Loja'];
			
			if($this->Loja->save($data))
			{
				
				$this->flashMsg('Atualizado !!');
				$this->redirect('/admin/lojas');
			}
			else
			{
				$this->flashMsg('Erro ao atualizar !!','error');
			}
		}
		
		$result = $this->Loja->findById($id);
		
		$this->data = $result;
		
		//pega países, estados e cidades
		$paises = json_encode($this->getPaisesAndAsso());
		//echo $paises;die;
		$this->set(compact('paises'));
	}
	
	//deletar loja admin
	public function admin_loja_delete($id){
	
		$ex = $this->Loja->findById($id);
		if($ex)
		{
	
			if($this->Loja->delete($id))
			{
	
				$this->flashMsg('Excluido !!');
				$this->redirect('/admin/lojas');
			}
			else
			{
				$this->flashMsg('Erro ao excluir !!','error');
			}
		}
	}
	
	//importar
	public function admin_loja_import(){
		
		if(!empty($this->data)):
			if(!$this->data['Loja']['arquivo']['error']):
				
				$filename = $this->data['Loja']['arquivo']['tmp_name'];
				$destination = WWW_ROOT.'files' . DS . 'lojas' . DS . microtime();
				
				move_uploaded_file($filename, $destination);
				
				if($this->__import($destination))
					$this->flashMsg('Arquivo importado com sucesso!');
				else
					$this->flashMsg('Arquivo não foi importado!','error');
				
			endif;
			//$csv = file_get_contents($destination);		
			
		endif;
		
	}
	
	function __import($csv, $delimeter = ','){
		 
		if($this->Loja->importacao($csv,$delimeter)):
		
			return true;
		
		else:
		
			return false;
		
		endif;
	}
	
	protected function getPaisesAndAsso()
	{
		
		$paises = $this->Pais->getPaises(1,false);
		return $paises;
	}
	
	protected function getEstados($select = false)
	{
		$estados = $this->Estado->getEstados(1,false);
		
		if($select):
			foreach($estados as $ind => $estado):
			
				unset($estados[$ind]['cidades']);
				unset($estados[$ind]['sigla']);
				unset($estados[$ind]['nome']);
				$estados[$ind] = $estado['nome'];
			
			endforeach;
		endif;
		
		return $estados;
	}
	
	//pega os estados e as cidades conforme o id do pais
	public function ajax(){
		
		if(isset($this->data['id_pais']))
		{
			$id = $this->data['id_pais'];
			$lang = Configure::read('Variable.language.id');
			$estados = $this->Estado->getEstadosFront($id,($lang ? $lang : null));
				
			$estados = json_encode($estados);
			die($estados);
		}
		if(isset($this->data['id_estado']))
		{
			$id = $this->data['id_estado'];
			$lang = Configure::read('Variable.language.id');
			$cidades = $this->Cidade->getCidadesFront($id,($lang ? $lang : null));
			
			$cidades = json_encode($cidades);
			die($cidades);
		}
		
		if(isset($this->data['id_cidade']))
		{
			$id_cidade = $this->data['id_cidade'];
			$lojas = $this->Loja->getLojasFront($id_cidade);
				
			$lojas = json_encode($lojas);
			die($lojas);
		}
	}
	
	//listagem de representantes admin
	public function admin_representantes()
	{
		
		$this->Representante->recursive = 1;
		
		$paginationScope = array ();
		
		if (isset ( $this->data ['Representante'] ['filter'] ) || $this->Session->check ( 'Representante.filter' )) {
		
			if (isset ( $this->data ['Representante'] ['filter'] ) && empty ( $this->data ['Representante'] ['filter'] )) {
				$this->Session->delete ( 'Representante.filter' );
			} else {
				$filter = isset ( $this->data ['Representante'] ['filter'] ) ? $this->data ['Representante'] ['filter'] : $this->Session->read ( 'Representante.filter' );
		
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'Representante.filter', $filter );
			}
		}
		
		$results = $this->paginate('Representante', $paginationScope);
		
		foreach($results as $k => $result){
			
			$estado = $this->Estado->findById($result['Representante']['id_estado']);
			
			$this->Language->recursive = 1;
			
			$results[$k]['Representante']['estado'] = $estado['Estado']['nome_pt'];
			
			
		}
		
		$paises = $this->Pais->getPaisesAdminRepresentante();
		//echo $paises;die;
		$this->set(compact('paises'));
		
		$this->set(compact('results'));
		
	}
	
	//adicionar representante admin
	public function admin_representante_add(){
	
	
		if(isset($this->data['Representante']))
		{
			$data = $this->data['Representante'];
	
			if($this->Representante->save($data))
			{
	
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/representantes');
			}
			else
			{
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			}
		}
		
		$estados = $this->getEstados(true);
		//echo $paises;die;
		$this->set(compact('estados'));
	}
	
	//editar representante admin
	public function admin_representante_edit($id){
	
	
		if(isset($this->data['Representante']))
		{
			$data = $this->data['Representante'];
				
			if($this->Representante->save($data))
			{
	
				$this->flashMsg('Atualizado !!');
				$this->redirect('/admin/representantes');
			}
			else
			{
				$this->flashMsg('Erro ao atualizar !!','error');
			}
		}
	
		$result = $this->Representante->findById($id);
		$this->data = $result;
		
		$estados = $this->getEstados(true);
		//echo $paises;die;
		$this->set(compact('estados'));
	}
	
	//deletar representante admin
	public function admin_representante_delete($id){
	
		$ex = $this->Representante->findById($id);
		if($ex)
		{
	
			if($this->Representante->delete($id))
			{
	
				$this->flashMsg('Excluido !!');
				$this->redirect('/admin/representantes');
			}
			else
			{
				$this->flashMsg('Erro ao excluir !!','error');
			}
		}
	}
	
	//listagem lojas virtuais admin
	public function admin_lojas_virtuais()
	{
		$this->LojaVirtual->recursive = 1;
		
		
		$paginationScope = array ();
		
		if (isset ( $this->data ['LojaVirtual'] ['filter'] ) || $this->Session->check ( 'LojaVirtual.filter' )) {
		
			if (isset ( $this->data ['LojaVirtual'] ['filter'] ) && empty ( $this->data ['LojaVirtual'] ['filter'] )) {
				$this->Session->delete ( 'LojaVirtual.filter' );
			} else {
				$filter = isset ( $this->data ['LojaVirtual'] ['filter'] ) ? $this->data ['LojaVirtual'] ['filter'] : $this->Session->read ( 'LojaVirtual.filter' );
		
				foreach ( $filter as $field => $value ) {
					if ($value !== '') {
						$paginationScope [str_replace ( '|', '.', $field )] = strpos ( $field, 'LIKE' ) !== false ? "%{$value}%" : $value;
					}
				}
		
				$this->Session->write ( 'LojaVirtual.filter', $filter );
			}
		}
		
		$this->paginate = array('order' => array('LojaVirtual.position' => 'asc'));
		$results = $this->paginate('LojaVirtual', $paginationScope);
		
		//$results = @Set::sort ( ( array ) $results, '{n}.LojaVirtual.settings.display.default.ordering.position', 'asc' );
		$this->set(compact('results'));
	}
	
	//adicionar loja virtual admin
	public function admin_loja_virtual_add(){
	
	
		if(isset($this->data['LojaVirtual']))
		{
			$data = $this->data['LojaVirtual'];
			$data['position'] =  $this->getMaxPos();
			
			unset($data['filename']);
			
			if($this->LojaVirtual->save($data))
			{
				$this->__processImage();
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/lojasvirtuais');
			}
			else
			{
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			}
		}
		
	}
	
	//edit loja virtual admin
	public function admin_loja_virtual_edit($id){
	
		$result = $this->LojaVirtual->findById($id);
		
		
		if(isset($this->data['LojaVirtual']))
		{
			$data = $this->data['LojaVirtual'];
				
			unset($data['filename']);
				
			if($this->LojaVirtual->save($data))
			{
				if(!$this->data['LojaVirtual']['filename']['error'])
				{
					$this->__deleteImage($result['LojaVirtual']['filename']);
					$this->__processImage();
				}
				$this->flashMsg('Cadastrado !!');
				$this->redirect('/admin/lojasvirtuais');
			}
			else
			{
				$this->flashMsg('Erro ao tentar cadastrar !!','error');
			}
		}
		
		
		
		$this->data = $result;
	}
	
	//deleta lojas virtuais admin
	public function admin_loja_virtual_delete($id)
	{
		$result = $this->LojaVirtual->findById($id);
		
		if($result)
		{
			
			if($this->LojaVirtual->delete($result['LojaVirtual']['id']))
			{
				$this->__deleteImage($result['LojaVirtual']['filename']);
				
				$this->flashMsg('Loja excluida !!');
			}
			else
			{
				$this->flashMsg('Erro ao tentar excluir !!','error');
			}
		}
		else
		{
			$this->flashMsg('Não existe esta loja! contata-te o administtrador !!','error');
		}
		
		
		$this->redirect('/admin/lojasvirtuais');
	}
	
	public function admin_position()
	{
		$d = $this->data;
	
		$this->LojaVirtual->updatePosition($d['LojaVirtual']['id'] , $d['LojaVirtual']['position'], $d['way']);
		exit;
	}
	
	//tabela de preços
	public function admin_table($id = false){
		
		if($id):
		
			$id = (int) $id;
			$tabela = $this->TabelaPreco->findById($id);
			
			if($tabela):
				if($this->TabelaPreco->delete($id)):
				
					//deletar a imagem
					$path = WWW_ROOT . 'files' . DS . 'tabelaprecos' . DS.$tabela['TabelaPreco']['file'];
					@unlink($path);
					
					$this->flashMsg('Deletado !!');
					$this->redirect('/admin/site/site/table');
				
				endif;
			endif;
		endif;
		
		if(isset($this->data['TabelaPreco'])):
		
			$data = $this->data['TabelaPreco'];
			unset($data['file']);
			if($this->TabelaPreco->save($data)):
				
				$this->__processFile();
				
				$this->flashMsg('Salvo !!');
				$this->redirect('/admin/site/site/table');
				
			endif;
		endif;
		
		$results  = $this->paginate('TabelaPreco');
		$this->set(compact('results'));
		
	}
	
	
	//tabela de preços
	public function admin_pdv($id = false){
	
		if($id):
	
			$id = (int) $id;
			$tabela = $this->Pdv->findById($id);
			
			if($tabela):
				if($this->Pdv->delete($id)):
			
					//deletar a imagem
					$path = WWW_ROOT . 'files' . DS . 'pdv' . DS.$tabela['Pdv']['img'];
					@unlink($path);
						
					$this->flashMsg('Deletado !!');
					$this->redirect('/admin/site/site/pdv');
				
				endif;
			endif;
		endif;
	
		if(isset($this->data['Pdv'])):
	
			$data = $this->data['Pdv'];
			unset($data['img']);
			if($this->Pdv->save($data)):
	
				$this->__processImagePdv();
	
				$this->flashMsg('Salvo !!');
				$this->redirect('/admin/site/site/pdv');
	
			endif;
		endif;
	
		$results  = $this->paginate('Pdv');
		$this->set(compact('results'));
	
	}
	
	private function __processFile() {
		//pr($this->data['User']['file']);
		//die;
		if (!empty($this->data['TabelaPreco']['file']) && !$this->data['TabelaPreco']['file']['error']) {
			$path = WWW_ROOT . 'files' . DS . 'tabelaprecos' . DS;
			//pr($img_path);echo "<br /> ";pr($thumb_path);die;
			App::import('Vendor', 'Upload');
			$Upload = new Upload($this->data['TabelaPreco']['file'], 'pt_BR');
			if ($Upload->uploaded) {
	
				$Upload->file_auto_rename = false;
	
				$fileName = $this->data['TabelaPreco']['file']['name'];
				
				$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
	
				$ext = strrpos($fileName, '.');
				$fileName_a = substr($fileName, 0, $ext);
				$fileName_b = substr($fileName, $ext);
	
				$nome_file = md5(uniqid(time()));
	
				$Upload->file_new_name_body = $nome_file;
	
				$Upload->Process($path);
	
				if ($Upload->processed) {
					
					$this->TabelaPreco->saveField('file',$nome_file.$fileName_b);
				} else {
					$this->flashMsg(__t('Problema ao subir arquivo do link.'), 'error');
				}
			}
		}
	}
	
	private function __processImage() {
		//pr($this->data['User']['file']);
		//die;
		if (!empty($this->data['LojaVirtual']['filename']) && !$this->data['LojaVirtual']['filename']['error']) {
			$img_path = WWW_ROOT . 'img' . DS . 'lojasvirtuais' . DS;
			$thumb_path = WWW_ROOT . 'img' . DS . 'lojasvirtuais' . DS . 'thumb' . DS;
			//pr($img_path);echo "<br /> ";pr($thumb_path);die;
			App::import('Vendor', 'Upload');
			$Upload = new Upload($this->data['LojaVirtual']['filename'], 'pt_BR');
			if ($Upload->uploaded) {
	
				$Upload->file_auto_rename = false;
	
				$fileName = $this->data['LojaVirtual']['filename']['name'];
				$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
	
				$ext = strrpos($fileName, '.');
				$fileName_a = substr($fileName, 0, $ext);
				$fileName_b = substr($fileName, $ext);
	
				$nome_imagem = md5(uniqid(time()));
	
				$Upload->file_new_name_body = $nome_imagem;
	
				$Upload->Process($img_path);
	
				if ($Upload->processed) {
					$Upload->image_resize = true;
					$Upload->image_x = 210;
					$Upload->image_y = 91;
					$Upload->file_auto_rename = false;
					$Upload->file_new_name_body = $nome_imagem;
					$Upload->Process($thumb_path);
					$this->LojaVirtual->saveField('filename',$nome_imagem.$fileName_b);
				} else {
					$this->flashMsg(__t('Problema ao subir imagem do link.'), 'error');
				}
			}
		}
	}
	
	private function __processImagePdv() {
		//pr($this->data['User']['file']);
		//die;
		if (!empty($this->data['Pdv']['img']) && !$this->data['Pdv']['img']['error']) {
			$img_path = WWW_ROOT . 'files' . DS . 'pdv' . DS;
			//pr($img_path);echo "<br /> ";pr($thumb_path);die;
			App::import('Vendor', 'Upload');
			$Upload = new Upload($this->data['Pdv']['img'], 'pt_BR');
			if ($Upload->uploaded) {
				
				$Upload->file_is_image = true;
				$Upload->file_auto_rename = false;
	
				$fileName = $this->data['Pdv']['img']['name'];
				$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
	
				$ext = strrpos($fileName, '.');
				$fileName_a = substr($fileName, 0, $ext);
				$fileName_b = substr($fileName, $ext);
	
				$nome_imagem = md5(uniqid(time()));
	
				$Upload->file_new_name_body = $nome_imagem;
	
				$Upload->Process($img_path);
	
				if ($Upload->processed) {
					$this->Pdv->saveField('img',$nome_imagem.$fileName_b);
				} else {
					$this->flashMsg(__t('Problema ao subir imagem do link.'), 'error');
				}
			}
		}
	}
	
	private function __deleteImage($file) {
	
		if($file)
		{
			$targetDir = 'img/lojasvirtuais';
			unlink($targetDir.'/'.$file);
			$targetDirThumb = 'img/lojasvirtuais/thumb';
			unlink($targetDirThumb.'/'.$file);
		}
	}
	
	protected function getMaxPos()
	{
		App::uses('LojaVirtual', 'Site.Model');
		$lojaVt = new LojaVirtual;
		$resultFotos = $lojaVt->find('first',array('order' => array('position DESC')));
	
		$posicao = 1;
	
		if(is_array($resultFotos) && count($resultFotos)>0)
			foreach($resultFotos as $rowFotos)
			$posicao = $rowFotos['position'] + 1;
	
		return $posicao;
	}

}
