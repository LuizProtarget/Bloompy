<?php
/**
 * Representante Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
App::import("Model", "Estado");
App::import("Model", "Pais");
class Representante extends AppModel {
	public $name = 'Representante';
	public $useTable = "representantes";
	public $validate = array(
		'name' => array(
			'required' => true, 
			'allowEmpty' => false, 
			'rule' => 'notEmpty',
			'message' => 'Preencha campo nome'
		),
	);
	
	
	//pegar os representantes
	public function getRepre()
	{
		$results = $this->find('all');
		
		
		$dados = array();
		$estados = array();
		foreach($results as $k => $result){
				
				$estado = ClassRegistry::init('Estado')->findById($result['Representante']['id_estado'],array('Estado.id','Estado.nome_pt'));
				
				$representante = array(
						'id' => $result['Representante']['id'],
						'nome' => $result['Representante']['name'],
						'desc' => $result['Representante']['desc']
				);
					
				$estados[$estado['Estado']['id']]['name'] = $estado['Estado']['nome_pt'];
				$estados[$estado['Estado']['id']]['representantes'][] = $representante;
	
			
		}
		
		//var_dump($dados);die;
		return $estados;
	}
}