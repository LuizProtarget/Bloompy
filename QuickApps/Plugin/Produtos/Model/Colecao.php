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
class Colecao extends AppModel {
	public $name = 'Colecao';
	public $useTable = "produto_colecao";
	public $primaryKey = 'produto_colecao_id';
	public $validate = array(
		'name' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Preencha campo nome'),
	);
	
	public $hasMany  = array
	(
		'Linha' => array
		(
			'className' => 'Produtos.Linha',
			'foreignKey' => 'produto_colecao_id',
			'associationForeignKey' => 'produto_colecao_id',
			'dependent' => false
		)
	);
	
	public function beforeDelete($cascade = true) {
		$count = $this->Linha->find("count", array(
				"conditions" => array("Linha.produto_colecao_id" => $this->id)
		));
		if ($count == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getList()
	{
		$colecaoList = $this->find('all');
		$__tmp_colecao_list = array(''=>'Selecione');
		
		if($colecaoList)
			foreach($colecaoList as $objItem)
				$__tmp_colecao_list[$objItem['Colecao']['produto_colecao_id']] = $objItem['Colecao']['name'];
		
		return $__tmp_colecao_list;
	}
	
	public function getListFront()
	{
		$colecaoList = $this->find('all');
		$__tmp_colecao_list = array();
		
		if($colecaoList):
			foreach($colecaoList as $ind => $objItem):
				
				$__tmp_colecao_list[$ind]["id"] = $objItem['Colecao']['produto_colecao_id'];
				$__tmp_colecao_list[$ind]["name"] = $objItem['Colecao']['name'];
				$__tmp_colecao_list[$ind]["slug"] = strtolower(Inflector::slug($objItem['Colecao']['name']));
				
			endforeach;
		endif;
		
		return $__tmp_colecao_list;
	}
}