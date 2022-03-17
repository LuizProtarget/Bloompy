<?php
/**
 * Cidade Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */

class Cidade extends AppModel {
	public $name = 'Cidade';
	public $useTable = "cidades";
	
	public function getCidades($id_estado)
	{
		
		$cidadesBanco = $this->find('all',array('conditions' => array('Cidade.id_estado' => $id_estado),'order' => array('Cidade.nome_pt' => 'ASC')));
		
		$cidades = array();
		
		if(count($cidadesBanco) > 0)
		{
			foreach($cidadesBanco as $ind => $cidade)
			{
					
				$cidades[$cidade['Cidade']['id']] = array(
						'nome' => $cidade['Cidade']['nome_pt']
				);
			}
		}
		
		return $cidades;
	}
	
	public function getCidadesFront($id_estado)
	{
		
		$id_estado = str_replace(array('"',"'"),'',$id_estado);
		//$cidadesBanco = $this->find('all',array('conditions' => array('Cidade.id_estado' => (int) $id_estado, 'Loja.id_cidade' => 'Cidade.id'),'order' => array('Cidade.nome_pt' => 'ASC')));
		
		$cidadesBanco = $this->query("SELECT `Cidade`.`id`, `Cidade`.`nome_pt` FROM `qa_cidades` AS `Cidade` 
		WHERE `Cidade`.`id_estado` = ".$id_estado." AND 
		EXISTS ( select 1 from qa_lojas as Loja where Loja.id_cidade = Cidade.id limit 1)
		ORDER BY `Cidade`.`nome_pt` ASC");
		
		$cidades = array();
	
		if(count($cidadesBanco) > 0)
		{
			foreach($cidadesBanco as $ind => $cidade)
			{
				$cidades[$cidade['Cidade']['id']] = trim($cidade['Cidade']['nome_pt']);
			}
		}
	
		return $cidades;
	}
	
	//pega o id da cidade pelo nome
	public function getCidadeIdByName($nome)
	{
		$cidadesBanco = $this->query("
				SELECT
					`Cidade`.`id`
				FROM
					`qa_cidades` AS `Cidade`
				WHERE
					`Cidade`.`nome_pt` LIKE '%".$nome."%'
				LIMIT 1");
	
		if($cidadesBanco && count($cidadesBanco) > 0)
			return (int)$cidadesBanco[0]['Cidade']['id'];
		else
			return 0;
	
	}
	
}