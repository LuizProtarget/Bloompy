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
class SkusFoto extends AppModel {
	public $name = 'SkusFoto';
	public $useTable = "produto_sku_foto";
	public $primaryKey = 'produto_sku_foto_id';
	public $validate = array(
		'filename' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Foto é obrigatória'),
		'produto_sku_id' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Código do SKU não existe'),
	);
	
	public $belongsTo = array
	(
		'Skus' => array
		(
			'className' => 'Produtos.Skus',
			'foreignKey' => 'produto_sku_id',
			'associationForeignKey' => 'produto_sku_id'
		)
	);
	
	
	public function updatePosition($produto_sku_id, $produto_sku_foto_id, $position, $way)
	{
		
		$resultPosition = $this->query("select position from qa_produto_sku_foto SkusFoto where produto_sku_foto_id=".$produto_sku_foto_id);
		$myPostion 		= null;
		if(count($resultPosition) > 0)
			foreach($resultPosition as $tblPosition)
				foreach($tblPosition as $rowPosition)
					$myPostion = $rowPosition['position'];
		
		
		if(!is_null($myPostion))
		{
			if(!$way)
				$this->query("update qa_produto_sku_foto SET position=position-1 where produto_sku_id=".$produto_sku_id." and position <= ".$position." and position >= ".$myPostion);
			else
				$this->query("update qa_produto_sku_foto SET position=position+1 where produto_sku_id=".$produto_sku_id." and position >= ".$position." and position <= ".$myPostion);
			
			$this->query("update qa_produto_sku_foto SET position=".$position." where produto_sku_foto_id=".$produto_sku_foto_id);
		}
		
		return true;
	}
	
	public function removerFoto($produto_sku_foto_id)
	{	
		
		$result = $this->query('select * from qa_produto_sku_foto where produto_sku_foto_id = '.$produto_sku_foto_id);
		
		$posicao = null;
		foreach($result as $tbl)
			foreach($tbl as $row)
				{
					$posicao = $row['position'];
					
					@unlink(WWW_ROOT . 'img/produtos/mobile/'.$row['filename']);
					@unlink(WWW_ROOT . 'img/produtos/thumb/'.$row['filename']);
					@unlink(WWW_ROOT . 'img/produtos/'.$row['filename']);
				}
				
		$this->query("update qa_produto_sku_foto SET position=position-1 where position > ".$posicao);
		
		return true;
	}
	
	
	public function beforeDelete($cascade=true)
	{
		return $this->removerFoto($this->id);
	}
}