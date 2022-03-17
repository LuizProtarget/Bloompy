<?php
/**
 * Loja Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
App::uses('Estado', 'Site.Model');
App::uses('Cidade', 'Site.Model');
class Loja extends AppModel {
	public $name = 'Loja';
	public $useTable = "lojas";
	public $validate = array(
		'name' => array(
			'required' => true, 
			'allowEmpty' => false, 
			'rule' => 'notEmpty',
			'message' => 'Preencha campo nome'
		),
	);
	
	//pegar as lojas
	public function getLojas()
	{
		
		$objLojas = new stdClass();
		$objLojas->lojas = new stdClass();
		
		
		$results = $this->find('all');
	
	
		$dados = array();
		foreach($results as $k => $result){
	
			
			$estado = ClassRegistry::init('Estado')->findById($result['Loja']['id_estado']);
			
			$cidade = ClassRegistry::init('Cidade')->findById($result['Loja']['id_cidade']);
	
			$loja = array(
					'id' => $result['Loja']['id'],
					'name' => $result['Loja']['name'],
					'desc' => $result['Loja']['desc']
			);
			
			$cidades = array(
					'id' => $cidade['Cidade']['id'],
					'name' => $cidade['Cidade']['nome_pt']
			);
			
			$dados[$estado['Estado']['sigla']]['name'] = $estado['Estado']['nome_pt'];
			
			if(!isset($dados[$estado['Estado']['sigla']]['cidades'][$cidade['Cidade']['id']]))
				$dados[$estado['Estado']['sigla']]['cidades'][$cidade['Cidade']['id']] = $cidades;
			
			
			$dados[$estado['Estado']['sigla']]['cidades'][$cidade['Cidade']['id']]['lojas'][] = $loja;
			
		}
		
		return $dados;
	}
	
	//pegar as lojas front
	public function getLojasFront($id_cidade)
	{
		
		$results = $this->find('all',array('conditions' => array('Loja.id_cidade' => $id_cidade)));
	
	
		$dados = array();
		foreach($results as $k => $result){
	
			$dados[] = array(
					'id' => $result['Loja']['id'],
					'name' => $result['Loja']['name'],
					'desc' => $result['Loja']['desc']
			);
				
		}
	
		return $dados;
	}
	
	//importador lojas
	public function importacao($csv, $delimeter = ';'){
		//die($csv);
		$dataSource = $this->getDataSource();
		$estado = new Estado;
		$cidade = new Cidade;
		try {
			$row = 1;
			$fields = array();    		//limpa a tabela temporária antes de importar
			$this->query('TRUNCATE TABLE qa_lojas');
			$sql = "INSERT INTO qa_lojas (name,`desc`,id_pais,id_cidade,id_estado,criado) VALUES ";
			if (($handle = fopen($csv, "r")) !== FALSE) {
				
				$dataSource->begin();
				while (($data = fgetcsv($handle, 0,";")) !== FALSE){
					$num = 6;
					$row++;
					$fields = null;
					
					for ($c=0; $c < $num; $c++) :
					
						if($c == 1):
							
							$fields[] = '"'.utf8_decode(trim($data[2])).' - '.utf8_decode(trim($data[5])).' <br/> '.utf8_decode(trim($data[1])).'"';
							$fields[] = 1;
							unset($data[5]);
						elseif($c == 3):
							
							$fields[] = ''.$cidade->getCidadeIdByName(trim($data[$c])).'';
					
						elseif($c == 4):
							
							$fields[] = ''.$estado->getEstadoIdBySigla(trim($data[$c])).'';
						
						elseif($c == 0):
							
							$fields[] = '"'.utf8_decode(str_replace('"', "", trim($data[$c]))).'"';
						
						endif;
					endfor;
					
					$fields[] = '"'.date('Y-m-d H:i:s').'"';
					
					$_tmp[] = '('.implode(',',$fields).')';
					
				}

				fclose($handle);
				
				$sql .= implode(',',$_tmp);
				//echo $sql;die;
				$this->query($sql);
	
				$dataSource->commit();
				return true;
			}
		}
		catch(Exception $e)
		{
			$dataSource->rollback();
			 
			return false;
		}
	
	}
}