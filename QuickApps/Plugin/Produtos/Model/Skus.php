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
class Skus extends AppModel {
	public $name = 'Skus';
	public $useTable = "produto_sku";
	public $primaryKey = 'produto_sku_id';
	public $validate = array(
		'referencia' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Digite o nome da referência'),
		'cor' => array('required' => false, 'allowEmpty' => true, 'rule' => 'notEmpty', 'message' => 'Digite o nome da cor'),
		'produto_id' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Código do produto não existe'),
	);
	public $order = array("Skus.position" => "asc");
	public $belongsTo = array
	(
		'Produto' => array
		(
			'className' => 'Produtos.Produtos',
			'foreignKey' => 'produto_id',
			'associationForeignKey' => 'produto_id'
		),
		'Cores' => array
		(
				'className' => 'Produtos.Cores',
				'foreignKey' => 'produto_cor_id',
				'associationForeignKey' => 'produto_cor_id',
				'dependent' => false
		)
	);
	
	public $hasMany = array(
		'SkusFoto' => array(
			'className' => 'Produtos.SkusFoto',
			'foreignKey' => 'produto_sku_id',
			'dependent'=> true
		)
	);
	
	public function updatePosition($produto_id, $sku_id, $position, $way)
	{
	
		$resultPosition = $this->query("select position from qa_produto_sku Skus where produto_sku_id=".$sku_id);
	
		$myPostion 		= null;
		if(count($resultPosition) > 0)
			foreach($resultPosition as $tblPosition)
			foreach($tblPosition as $rowPosition)
			$myPostion = $rowPosition['position'];
	
		if(!is_null($myPostion))
		{
			if(!$way)
				$this->query("update qa_produto_sku SET position=position-1 where produto_id=".$produto_id." and position <= ".$position." and position >= ".$myPostion);
			else
				$this->query("update qa_produto_sku SET position=position+1 where produto_id=".$produto_id." and position >= ".$position." and position <= ".$myPostion);
	
			$this->query("update qa_produto_sku SET position=".$position." where produto_sku_id=".$sku_id);
		}
	
		return true;
	}
	
	/*  
	 * Busca todos os Skus
	 * 
	 */
	public function getListFront(){
		
		$results = $this->find('all',array('order' => array('Skus.position' => 'asc')));
		$skus = array();
		if($results):
			foreach($results as $result):
				if((int)$result['Skus']['exibir_mobile']):
					
					$skus[] = array(
							'id' => $result['Skus']['produto_sku_id'],
							'produto_id' => $result['Skus']['produto_id'],
							'ref' => $result['Skus']['referencia'],
							'img' 			=> IMAGES_URL.'produtos/mobile/'.$this->getFoto($result['Skus']['produto_sku_id']),
							'thumb' 			=> IMAGES_URL.'produtos/thumb/'.$this->getFoto($result['Skus']['produto_sku_id'])
					);
			
				endif;
			endforeach;
		endif;
		//var_dump($skus);die;
		return $skus;
	}
	
	/*
	 * Busca a imagem do sku por id do próprio
	 * 
	 */
	public function getFoto($id)
	{
		$id = (int)$id;
	
		$sql = $this->query('SELECT filename FROM  qa_produto_sku_foto Foto WHERE produto_sku_id='.$id.' order by position asc');
	
		return (isset($sql[0]['Foto']['filename']) ? $sql[0]['Foto']['filename'] : '');
	}
}