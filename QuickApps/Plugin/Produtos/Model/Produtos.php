<?php
/**
 * Produto Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br>
 * @link	 http://www.pronexo.com.br
 */
class Produtos extends AppModel {
	public $name = 'Produtos';
	public $useTable = "produto";
	public $primaryKey = 'produto_id';
	public $validate = array(
		'name' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Preencha campo nome'),
		'produto_linha_id' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Selecione a linha'),
	);
	public $belongsTo = array
	(
		'Linha' => array
		(
			'className' => 'Produtos.Linha',
			'foreignKey' => 'produto_linha_id',
			'associationForeignKey' => 'produto_linha_id'
		)
	);
	public $hasMany = array
	(
		'Skus' => array
		(
			'className' => 'Produtos.Skus',
			'foreignKey' => 'produto_id',
			'dependent'=> true,
			'order' => 'Skus.referencia asc'
		)
	);
	
	//pega a listagem de produtos, por coleção e categoria
	public function getColecao($site = false,$orderProds = 'position')
	{
		$results = $this->find('all',array('order' => array('Produtos.'.$orderProds => 'asc')));
		
		App::uses('Colecao', 'Produtos.Model');
		$colecaoClass = new Colecao;
	
		if($site):
		
			$dados['thumbBasePath'] = IMAGES_URL.'produtos/thumb';
			$dados['imgBasePath'] = IMAGES_URL.'produtos';
			
		else:
				
			$dados['thumbBasePath'] = IMAGES_URL.'produtos/thumb';
			$dados['imgBasePath'] = IMAGES_URL.'produtos/mobile/';
		
		endif;
		
		$dados = array();
		
		foreach($results as $k=>$result){
			$colecao = array();
			$categoria = array();
			
			if($site):

				if($result['Linha']['exibir_site']):
					if(count($result['Skus']) > 0):
						
						$colecao = $colecaoClass->findByProdutoColecaoId($result['Linha']['produto_colecao_id']);
					
						if($colecao):
							$skus = array();
							foreach($result['Skus'] as $sku):
								
								if($site):
									if((int)$sku['exibir_site']):
											
										$skus[] = array(
												'ref' => $sku['referencia'],
												'cor' => $sku['cor'],
												'data_mod' => strtotime($sku['date_add']),
												'img' 			=> IMAGES_URL.'produtos/'.$this->getFoto($sku['produto_sku_id']),
												'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
										);
										
									endif;
								else:
									if((int)$sku['exibir_mobile']):
										//die('f');
										$skus[] = array(
												'ref' => $sku['referencia'],
												'cor' => $sku['cor'],
												'data_mod' => strtotime($sku['date_add']),
												'img' 			=> IMAGES_URL.'produtos/mobile/'.$this->getFoto($sku['produto_sku_id']),
												'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
										);
										
									endif;
								endif;
							endforeach;
							
							$produto = array(
										'id' => $result['Produtos']['produto_id'],
										'name' =>  $result['Produtos']['name'],
										'desc' =>  $result['Produtos']['description'],
										'skus' => $skus,
										'genero' => $result['Produtos']['genero']
									);
							
							if(!empty($produto['genero'])):
								$colecaoSlug = strtolower(Inflector::slug( $colecao['Colecao']['name']));
								$categoria = trim(strtolower(Inflector::slug($result['Linha']['name'])));
								$dados[$produto['genero']][$colecaoSlug]['id'] =  $colecao['Colecao']['produto_colecao_id'];
								$dados[$produto['genero']][$colecaoSlug]['name'] =  $colecao['Colecao']['name'];
								$dados[$produto['genero']][$colecaoSlug]['slug'] =  $colecaoSlug;
								$dados[$produto['genero']][$colecaoSlug]['categorias'][$categoria]['id'] =   $result['Linha']['produto_linha_id'];
								$dados[$produto['genero']][$colecaoSlug]['categorias'][$categoria]['name'] =  $result['Linha']['name'];
								$dados[$produto['genero']][$colecaoSlug]['categorias'][$categoria]['produtos'][] =   $produto;
							endif;
							
						endif;
					endif;
				endif;
			else:
				if($result['Linha']['exibir_mobile']):
					if(count($result['Skus']) > 0):
					
						$colecao = $colecaoClass->findByProdutoColecaoId($result['Linha']['produto_colecao_id']);
							
						if($colecao):
							$skus = array();
							foreach($result['Skus'] as $sku):
							
								if($site):
									if((int)$sku['exibir_site']):
										
									$skus[] = array(
											'ref' => $sku['referencia'],
											'cor' => $sku['cor'],
											'data_mod' => strtotime($sku['date_add']),
											'img' 			=> IMAGES_URL.'produtos/'.$this->getFoto($sku['produto_sku_id']),
											'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
									);
									
									endif;
								else:
									if((int)$sku['exibir_mobile']):
									//die('f');
									$skus[] = array(
											'ref' => $sku['referencia'],
											'cor' => $sku['cor'],
											'data_mod' => strtotime($sku['date_add']),
											'img' 			=> IMAGES_URL.'produtos/mobile/'.$this->getFoto($sku['produto_sku_id']),
											'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
									);
									
									endif;
								endif;
							endforeach;
								
							$produto = array(
									'id' => $result['Produtos']['produto_id'],
									'name' =>  $result['Produtos']['name'],
									'preco_1' =>  ($result['Produtos']['preco_1'] ? 'R$ '.$result['Produtos']['preco_1'] : ''),
									'preco_2' =>  ($result['Produtos']['preco_2'] ? 'R$ '.$result['Produtos']['preco_2'] : ''),
									'desc' =>  nl2br($result['Produtos']['description']),
									'skus' => $skus
							);
								
							$colecaoSlug = strtolower(Inflector::slug( $colecao['Colecao']['name']));
							$categoria = trim(strtolower($result['Linha']['name']));
							$dados[$colecaoSlug]['id'] =  $colecao['Colecao']['produto_colecao_id'];
							$dados[$colecaoSlug]['name'] =  $colecao['Colecao']['name'];
							$dados[$colecaoSlug]['slug'] =  $colecaoSlug;
							$dados[$colecaoSlug]['categorias'][$categoria]['id'] =   $result['Linha']['produto_linha_id'];
							$dados[$colecaoSlug]['categorias'][$categoria]['name'] =  $result['Linha']['name'];
							$dados[$colecaoSlug]['categorias'][$categoria]['produtos'][] =   $produto;
							
						endif;
					endif;
				endif;
			endif;
		}
		//var_dump($dados);die;
		return $dados;
	}
	
	
	public function getColecaoAlternative($site = false)
	{
		$results = $this->find('all',array('order' => array('Produtos.position' => 'asc')));
		
		App::uses('Colecao', 'Produtos.Model');
		$colecaoClass = new Colecao;
	
		if($site):
		
			$dados['thumbBasePath'] = IMAGES_URL.'produtos/thumb';
			$dados['imgBasePath'] = IMAGES_URL.'produtos';
			
		else:
				
			$dados['thumbBasePath'] = IMAGES_URL.'produtos/thumb';
			$dados['imgBasePath'] = IMAGES_URL.'produtos/mobile/';
		
		endif;
		
		$dados = array();
		
		foreach($results as $k=>$result){
			$colecao = array();
			$categoria = array();
			
			if($site):
				if($result['Linha']['exibir_site']):
					if(count($result['Skus']) > 0):
						
						$colecao = $colecaoClass->findByProdutoColecaoId($result['Linha']['produto_colecao_id']);
					
						if($colecao):
							$skus = array();
							foreach($result['Skus'] as $sku):
								
								if($site):
									if((int)$sku['exibir_site']):
											
										$skus[] = array(
												'ref' => $sku['referencia'],
												'data_mod' => strtotime($sku['date_add']),
												'img' 			=> IMAGES_URL.'produtos/'.$this->getFoto($sku['produto_sku_id']),
												'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
										);
										
									endif;
								else:
									if((int)$sku['exibir_mobile']):
										//die('f');
										$skus[] = array(
												'ref' => $sku['referencia'],
												'data_mod' => strtotime($sku['date_add']),
												'img' 			=> IMAGES_URL.'produtos/mobile/'.$this->getFoto($sku['produto_sku_id']),
												'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
										);
										
									endif;
								endif;
							endforeach;
							
							$produto = array(
										'id' => $result['Produtos']['produto_id'],
										'name' =>  $result['Produtos']['name'],
										'desc' =>  $result['Produtos']['description'],
										'skus' => $skus
									);
							
							$colecaoSlug = strtolower(Inflector::slug( $colecao['Colecao']['name']));
							$dados[$colecaoSlug]['id'] =  $colecao['Colecao']['produto_colecao_id'];
							$dados[$colecaoSlug]['name'] =  $colecao['Colecao']['name'];
							$dados[$colecaoSlug]['slug'] =  $colecaoSlug;
							$dados[$colecaoSlug]['categorias'][strtolower($result['Linha']['name'])]['id'] =   $result['Linha']['produto_linha_id'];
							$dados[$colecaoSlug]['categorias'][strtolower($result['Linha']['name'])]['name'] =  $result['Linha']['name'];
							$dados[$colecaoSlug]['categorias'][strtolower($result['Linha']['name'])]['produtos'][] =   $produto;
							
						endif;
					endif;
				endif;
			else:
				if($result['Linha']['exibir_site']):
					if(count($result['Skus']) > 0):
					
						$colecao = $colecaoClass->findByProdutoColecaoId($result['Linha']['produto_colecao_id']);
							
						if($colecao):
							$skus = array();
							foreach($result['Skus'] as $sku):
							
								if($site):
									if((int)$sku['exibir_site']):
										
									$skus[] = array(
											'ref' => $sku['referencia'],
											'data_mod' => strtotime($sku['date_add']),
											'img' 			=> IMAGES_URL.'produtos/'.$this->getFoto($sku['produto_sku_id']),
											'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
									);
									
									endif;
								else:
									if((int)$sku['exibir_mobile']):
									//die('f');
									$skus[] = array(
											'ref' => $sku['referencia'],
											'data_mod' => strtotime($sku['date_add']),
											'img' 			=> IMAGES_URL.'produtos/mobile/'.$this->getFoto($sku['produto_sku_id']),
											'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
									);
									
									endif;
								endif;
							endforeach;
								
							$produto = array(
									'id' => $result['Produtos']['produto_id'],
									'name' =>  $result['Produtos']['name'],
									'desc' =>  $result['Produtos']['description'],
									'skus' => $skus
							);
								
							$colecaoSlug = strtolower(Inflector::slug( ($colecao['Colecao']['name'])));
							$dados[$colecaoSlug]['id'] =  $colecao['Colecao']['produto_colecao_id'];
							$dados[$colecaoSlug]['name'] = $colecao['Colecao']['name'];
							$dados[$colecaoSlug]['slug'] =  $colecaoSlug;
							$dados[$colecaoSlug]['categorias'][strtolower($result['Linha']['name'])]['id'] =   $result['Linha']['produto_linha_id'];
							$dados[$colecaoSlug]['categorias'][strtolower($result['Linha']['name'])]['name'] =  $result['Linha']['name'];
							$dados[$colecaoSlug]['categorias'][strtolower($result['Linha']['name'])]['produtos'][] =   $produto;
							
						endif;
					endif;
				endif;
			endif;
		}
		//var_dump($dados);die;
		return $dados;
	}
	
	public function getFoto($id)
	{
		$id = (int)$id;
		
		$sql = $this->query('SELECT filename FROM  qa_produto_sku_foto Foto WHERE produto_sku_id='.$id.' order by position asc');
	
		return (isset($sql[0]['Foto']['filename']) ? $sql[0]['Foto']['filename'] : '');
	}
	
	public function getProdutos($site = false)
	{
	
		$results = $this->find('all',array('order' => array('Produtos.position' => 'asc')));
		
		if($site):
		
			$dados['thumbBasePath'] = IMAGES_URL.'produtos/thumb';
			$dados['imgBasePath'] = IMAGES_URL.'produtos';
			
		else:
				
			$dados['thumbBasePath'] = IMAGES_URL.'produtos/thumb';
			$dados['imgBasePath'] = IMAGES_URL.'produtos/mobile/';
		
		endif;
		
		foreach($results as $result){
			$skus = array();
			foreach($result['Skus'] as $sku)
			{
				if($site)
				{
					if((int)$sku['exibir_site'])
					{
							
						$skus[] = array(
								'ref' => $sku['referencia'],
								'img' 			=> IMAGES_URL.'produtos/'.$this->getFoto($sku['produto_sku_id']),
								'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
						);
						
					}
				}
				else
				{
					if((int)$sku['exibir_mobile']):
					
						$skus[] = array(
								'ref' => $sku['referencia'],
								'img' 			=> IMAGES_URL.'produtos/mobile/'.$this->getFoto($sku['produto_sku_id']),
								'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($sku['produto_sku_id'])
						);
				
					endif;
				}
			}
				
			$newRow = array(
					'name' 			=> $result['Produtos']['name'],
					'categoria' 			=> strtolower($result['Linha']['name']),
					'cores' => $skus
			);
			
			$dados['produtos'][] = $newRow;
				
		}
	
		return $dados;
	}
	
	//posição
	public function updatePosition($linha_id, $produto_id, $position, $way)
	{
	
		$resultPosition = $this->query("select position from qa_produto Produto where produto_id=".$produto_id);
	
		$myPostion 		= null;
		if(count($resultPosition) > 0)
			foreach($resultPosition as $tblPosition)
				foreach($tblPosition as $rowPosition)
					$myPostion = $rowPosition['position'];
	
		if(!is_null($myPostion))
		{
			if(!$way)
				$this->query("update qa_produto SET position=position-1 where produto_linha_id=".$linha_id." and position <= ".$position." and position >= ".$myPostion);
			else
				$this->query("update qa_produto SET position=position+1 where produto_linha_id=".$linha_id." and position >= ".$position." and position <= ".$myPostion);
	
			$this->query("update qa_produto SET position=".$position." where produto_id=".$produto_id);
		}
	
		return true;
	}
	
	public function getListFront()
	{
	
		$results = $this->find('all',array('order' => array('Produtos.position' => 'asc')));
		$__tmp_produto_list = array();
		
		if($results):
			foreach($results as $ind => $result):
				
				$__tmp_produto_list[$ind]["id"] = $result['Produtos']['produto_id'];
				$__tmp_produto_list[$ind]["linha_id"] = $result['Produtos']['produto_linha_id'];
				$__tmp_produto_list[$ind]["name"] = $result['Produtos']['name'];
				$__tmp_produto_list[$ind]["desc"] = $result['Produtos']['description'];
				
			endforeach;
		endif;
		
		return $__tmp_produto_list;
	}
}