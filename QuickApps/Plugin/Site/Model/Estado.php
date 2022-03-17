<?php
/**
 * Estado Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
App::uses('Cidade', 'Site.Model');
class Estado extends AppModel {
	public $name = 'Estado';
	public $useTable = "estados";
	public $primaryKey = 'id';
	public $validate = array(
			'sigla' => array('required' => true, 'allowEmpty' => false, 'rule' => array('maxLength',2), 'message' => 'Máximo 2 digitos.')
	);
	
	public function getEstados($id_pais,$cidadeSim = true)
	{
		
		$estadosBanco = $this->find('all',array(
						'conditions' => array('Estado.id_pais' => $id_pais),
						'order' => array('Estado.nome_pt' => 'ASC')
					)
				);
		$estados = array();
		$cidade = new Cidade();
		if(count($estadosBanco) > 0)
		{
			foreach($estadosBanco as $ind => $estado)
			{
				$estados[$estado['Estado']['id']] = array(
							'sigla' => $estado['Estado']['sigla'],
							'nome' => $estado['Estado']['nome_pt'],
							'cidades' => ($cidadeSim ? $cidade->getCidades($estado['Estado']['id']) : null)
						);
			}
		}
		
		return $estados;
	}
	
	public function getEstadosFront($id_pais)
	{
		$estadosBanco = $this->query("
				SELECT 
					`Estado`.`id`, `Estado`.`nome_pt` 
				FROM 
					`qa_estados` AS `Estado`
				WHERE
				 `Estado`.`id_pais` = ".(int)$id_pais."
				And
					EXISTS ( select 1 from qa_lojas as Loja where Loja.id_estado = Estado.id limit 1)
				ORDER BY 
					`Estado`.`nome_pt` ASC");
	
		$estados = array();
		
		if(count($estadosBanco) > 0)
		{
			foreach($estadosBanco as $ind => $estado)
			{
				$estados[$estado['Estado']['id']] = $estado['Estado']['nome_pt'];
			}
		}
	
		return $estados;
	}
	
	//pega o id do estado pela SIGLA
	public function getEstadoIdBySigla($sigla)
	{
		
		$estadosBanco = $this->query("
				SELECT
					`Estado`.`id`
				FROM
					`qa_estados` AS `Estado`
				WHERE
					`Estado`.`sigla` LIKE '%".$sigla."%'
				limit 1");
		//var_dump($estadosBanco);die;
		if($estadosBanco && count($estadosBanco) > 0)
			return (int)$estadosBanco[0]['Estado']['id'];
		else
			return 0;
		
	}
	
	
}