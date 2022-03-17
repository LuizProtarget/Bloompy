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
class Linha extends AppModel {
	public $name = 'Linha';
	public $useTable = "produto_linha";
	public $primaryKey = 'produto_linha_id';
	public $validate = array(
		'name' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Preencha campo nome'),
		'produto_colecao_id' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Selecione a coleção'),
	);
	public $belongsTo = array
	(
		'Colecao' => array
		(
			'className' => 'Produtos.Colecao', 
			'foreignKey' => 'produto_colecao_id',
			'associationForeignKey' => 'produto_colecao_id'
		)
	);
	
	public $hasMany = array(
		'Produtos' => array(
				'className' => 'Produtos.Produtos',
				'foreignKey' => 'produto_linha_id',
				'dependent'=> true
		)
	);
	
	/**
	 * Retorna lista de linha de acordo com a colecao
	 * @param int $cid
	 * @return array
	 */
	public function getListOfColecao($cid)
	{
		$linhaList = $this->find('all',array(
			"conditions" => array("Linha.produto_colecao_id" => $cid)
		));
		$__tmp_linha_list = array();
	
		if($linhaList)
			foreach($linhaList as $objItem)
			$__tmp_colecao_list[$objItem['Linha']['produto_linha_id']] = $objItem['Linha']['name'];
	
		return $__tmp_colecao_list;
	}
	
	
	/**
	 * Retorna lista de linhas
	 */
	public function getList()
	{
		$_List = $this->find('all');
		$__tmp_list = array(''=>'Selecione');
	
		if($_List)
			foreach($_List as $objItem)
			$__tmp_list[$objItem['Linha']['produto_linha_id']] = $objItem['Linha']['name'];
	
		return $__tmp_list;
	}
	
	/**
	 * Retorna lista de linhas para o front
	 */
	public function getListFront()
	{
		$_List = $this->find('all');
		$__tmp_list = array();
		
		if($_List):
			foreach($_List as $ind => $objItem):
				if($objItem['Linha']['exibir_mobile']):
				
					$__tmp_list[$ind]["id"] = $objItem['Linha']['produto_linha_id'];
					$__tmp_list[$ind]["colecao_id"] = $objItem['Linha']['produto_colecao_id'];
					$__tmp_list[$ind]["name"] = utf8_encode($objItem['Linha']['name']);
					
				endif;
			endforeach;
		endif;
	
		return $__tmp_list;
	}
}