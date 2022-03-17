<?php
/**
 * Cores Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Cores.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br>
 * @link	 http://www.pronexo.com.br
 */
class Cores extends AppModel {
	public $name = 'Cores';
	public $useTable = "produto_cor";
	public $primaryKey = 'produto_cor_id';
	public $validate = array(
		'name' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => 'Preencha campo nome'),
	);
	
	public $hasMany  = array
	(
		'Skus' => array
		(
			'className' => 'Produtos.Skus',
			'foreignKey' => 'produto_cor_id',
			'associationForeignKey' => 'produto_cor_id',
			'dependent' => false
		)
	);
	
	public function beforeDelete($cascade = true) {
		$count = $this->Skus->find("count", array(
				"conditions" => array("Skus.produto_cor_id" => $this->id)
		));
		if ($count == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getList()
	{
		$coresList = $this->find('all');
		$__tmp_cores_list = array(''=>'Nenhuma');
		
		if($coresList)
			foreach($coresList as $objItem)
				$__tmp_cores_list[$objItem['Cores']['produto_cor_id']] = $objItem['Cores']['name'];
		
		return $__tmp_cores_list;
	}
}