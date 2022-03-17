<?php
/**
 * Pais Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
App::uses('Estado', 'Site.Model');
class Pais extends AppModel {
	public $name = 'Pais';
	public $useTable = "pais";
	
	
	public function getPaises($cidade = false){
		
		$paisesBanco = $this->find('all',array('fields' => array('Pais.id','Pais.nome_pt')),array('order' => array('Pais.nome_pt' => 'ASC')));
		//var_dump($paisesBanco);die;
		
		$paises = array();
		$estado = new Estado();
		if(count($paisesBanco) > 0)
		{
			foreach($paisesBanco as $ind => $pais)
			{
				
				$paises[$pais['Pais']['id']] = array(
						
						'nome' => $pais['Pais']['nome_pt'],
						'estados' => $estado->getEstados($pais['Pais']['id'],(!$cidade ? false : true))
						);
			}
		}
		
		return $paises;
	}
	
	public function getPaisesAdminEstadoSelect($id_lang = false){
	
		$paisesBanco = $this->query("
				SELECT
					`Pais`.`id`, `Pais`.`nome_pt`
				FROM
					`qa_pais` AS `Pais`
				ORDER BY
					`Pais`.`nome_pt` ASC");
		$paises = array();
		if(count($paisesBanco) > 0):
	
		foreach($paisesBanco as $ind => $pais):
			
		$paises[$pais['Pais']['id']] = $pais['Pais']['nome_pt'];
			
		endforeach;
			
		endif;
	
		return $paises;
	}
	
	public function getPaisesAdminEstado($id_lang = false){
		
		$paisesBanco = $this->query("
				SELECT 
					`Pais`.`id`, `Pais`.`nome_pt` 
				FROM 
					`qa_pais` AS `Pais`
				WHERE
					EXISTS ( select 1 from qa_lojas as Loja where Loja.id_pais = Pais.id ". ($id_lang ? ' AND Loja.id_lang = '.(int)$id_lang : '')." limit 1)
				ORDER BY 
					`Pais`.`nome_pt` ASC");
		$paises = array();
		if(count($paisesBanco) > 0):
		
			foreach($paisesBanco as $ind => $pais):
			
				$paises[$pais['Pais']['id']] = $pais['Pais']['nome_pt'];
			
			endforeach;
			
		endif;
	
		return $paises;
	}
	
	public function getPaisesAdminRepresentante($id_lang = false){
	
		$paisesBanco = $this->query("
				SELECT
				`Pais`.`id`, `Pais`.`nome_pt`
				FROM
				`qa_pais` AS `Pais`
				WHERE
				EXISTS ( select 1 from qa_representantes as Representante where Representante.id_pais = Pais.id ". ($id_lang ? ' AND Representante.id_lang = '.(int)$id_lang : '')." limit 1)
				ORDER BY
				`Pais`.`nome_pt` ASC");
		//var_dump($paisesBanco);die;
		
		$paises = array();
		if(count($paisesBanco) > 0):
	
		foreach($paisesBanco as $ind => $pais):
			
		$paises[$pais['Pais']['id']] = $pais['Pais']['nome_pt'];
			
		endforeach;
			
		endif;
	
		return $paises;
	}
	
}