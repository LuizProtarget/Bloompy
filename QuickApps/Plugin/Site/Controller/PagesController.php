<?php
/**
 * Pages Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 no
 */
class PagesController extends AppController {
	public $name = 'Pages';
	public $uses = array('Produtos.Produtos','Site.Representante','Site.Estado','Site.Loja','Site.LojaVirtual','Produtos.Linha','Produtos.Colecao','Produtos.Skus','User.User','Site.LogApp','Site.TabelaPreco','Site.Pdv');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}
	
	public function index($param = null) {
		
		$render = str_replace('.html', '', $param);
		
		//categorias
		$categorias = $this->Linha->getList();
		$t_categorias = count($categorias);
		
		//colecao
		$colecao = $this->Colecao->getListFront();
		
		$this->set(compact('categorias','t_categorias','colecao'));
		
		if($render == 'colecao'){
			$dados = '';
			
			$dados['colecoes'] = $this->Produtos->getColecao(true);
			//var_dump($dados);die;
			$dados =  json_encode($dados);
			//var_dump($dados);
			
			$this->set(compact('dados'));
			$this->render('colecao');
		}elseif($render == 'confirmacao-news'){
			$dados = '';
			
			$this->render('confirmacao-news');
		}elseif($render == 'confirmacao-contato'){
			$dados = '';
			
			$this->render('confirmacao-contato');
		}elseif($render == 'produto')
		{
			$dados = '';
			
			$dados = $this->Produtos->getProdutos(true);
			
			$dados = utf8_encode(json_encode($dados));
			
			$this->set(compact('dados'));
			$this->render('produtos');
		}
		elseif($render == 'onde-encontrar')
		{
			App::uses('Pais', 'Site.Model');
			App::uses('Estado', 'Site.Model');
			$objEstado = new Estado;
			$objPais = new Pais;
			
			$dados = '';
			$links = array();
			
			$representantes = $this->Representante->getRepre();
			$lojas = $this->Loja->getLojas();
			//var_dump($lojas);die;
			$id_pais = 1;
			$dados['estados'] = $objEstado->getEstadosFront(1);
			
			$linkslj = $this->LojaVirtual->find('all');
			
			$representantes = json_encode($representantes);
			
			$this->set(compact('dados','representantes','linkslj'));
			$this->render('onde_comprar');
		}
		elseif(strlen($render) > 0)
			$this->render($render);
		else
			$this->render('home');
	}
	
	public function produto($param = null)
	{
		if($param)
		{
			$produto['produto'] = $this->Produtos->findByName($param);
			
			$produto['reference'] = $produto['produto']['Produtos']['name'];
			$produto['id'] = $produto['produto']['Produtos']['produto_id'];
			$produto['categoria'] = $produto['produto']['Linha']['name'];
			$produto['referenceSku'] = (isset($produto['produto']['Skus'][0]['referencia']) ? $produto['produto']['Skus'][0]['referencia'] : '');
			$produto['img'] = (isset($produto['produto']['Skus'][0]['referencia']) ? 'http://bloompy.com.br'.Router::url('/'.IMAGES_URL.'produtos/'.$this->Produtos->getFoto($produto['produto']['Skus'][0]['produto_sku_id'])) : '');
			
			unset($produto['produto']);
			//var_dump($produto);die;
			//var_dump($produto);die;
			$this->set(compact('produto'));
			$this->autoLayout = false;
			$this->render('produto_url');
		}
		$this->render('produto_url');
		
	}
	
	public function aplicativo($param = null)
	{
		$render = str_replace('.html', '', $param);
		
		$categorias = $this->Linha->getList();
		$t_categorias = count($categorias);
		
		$this->set(compact('categorias','t_categorias'));
		
		if($render == 'colecao'){
			$dados = '';
				
			$dados = $this->Colecao->getListFront();
			
			$dados = utf8_encode(json_encode($dados));
			$this->autoLayout = false;
			die($dados);
		}
		elseif($render == 'completo'){
			$dados = '';
			$token = '';
			

			if(isset($_GET['user']) && isset($_GET['password'])){
				$user = $_GET['user'];
				$pass = $_GET['password'];
			}elseif(isset($this->data['user']) && isset($this->data['password'])){
				$user = $this->data['user'];
				$pass = $this->data['password'];
			}
			
			if($user && $pass){
				// pega as informações extras
				if(isset($this->data['device']) && isset($this->data['geo'])):
					$data = array(
							'device' => $this->data['device'],
							'geo' => $this->data['geo']
					);
				endif;
				$data['username'] = $user;
			
				$verify = $this->__login($user,$pass,$data);
			
				if(!$verify)
					die('USERNAME OU SENHA INVALIDOS');
			
			} else if(isset($this->data['token']) && isset($this->data['uid'])) {
			
				// pega as informações extras
				$data = array();
				if(isset($this->data['device']) && isset($this->data['geo'])):
				$data = array(
						'device' => $this->data['device'],
						'geo' => $this->data['geo']
				);
				endif;
			
				//pega usuario e senha do banco
				$verify = $this->__tokenAccess($this->data['uid'],$this->data['token'],$data);
			
				if(!$verify)
					die('TOKEN INVALIDO');
			
			} else {
			
				die('VOCE PRECISA SE AUTENTICAR PARA PEGAR AS INFORMACOES.');
			}
			
			
			$dados = $this->__getColecao(false);
			
			
			$dados['tabelas'] = $this->__getTable();
			$dados['pdvs'] = $this->__getPdv();
			$dados['uid'] = $verify['id'];
			$dados['token'] = $verify['token'];
			//var_dump($dados);die;
			//$dados = iconv('UTF-8', 'UTF-8//IGNORE', $dados);
			//$dados = $this->json_transform($dados);
			$dados = json_encode($dados);
			
			//var_dump($dados);die;
			$this->autoLayout = false;
			die($dados);
		}
		elseif($render == 'produto')
		{
			$dados = '';
				
			$dados = $this->Produtos->getListFront();
			
			$dados = utf8_encode(json_encode($dados));
				
			$this->set(compact('dados'));
			$this->autoLayout = false;
			die($dados);
		}
		elseif($render == 'linha')
		{
			$dados = '';
		
			//$lang = Configure::read('Variable.language.code_1');
		
			$dados = $this->Linha->getListFront();
		
			$dados = utf8_encode(json_encode($dados));
		
			$this->set(compact('dados'));
			$this->autoLayout = false;
			die($dados);
		}
		elseif($render == 'sku')
		{
			$dados = '';
		
			//$lang = Configure::read('Variable.language.code_1');
		
			$dados = $this->Skus->getListFront();
		
			$dados = utf8_encode(json_encode($dados));
		
			$this->set(compact('dados'));
			$this->autoLayout = false;
			die($dados);
		}
		else
		{
			die('Está página não existe');
		}
	}
	
	protected function __getColecao(){
		
		return $this->Produtos->getColecao(false,'name');
		
	}
	
	protected function __getTable(){
		
		$results = $this->TabelaPreco->find('all');
		$retorno = array();
		$path = 'files' . DS . 'tabelaprecos' . DS;
		
		if(count($results) > 0):
			foreach($results as $result):
			
				$retorno[] = array(
							'id' => $result['TabelaPreco']['id'],
							'name' => $result['TabelaPreco']['name'],
							'file' => $path.$result['TabelaPreco']['file']
						);
			
			endforeach;
		endif;
		
		return $retorno;
		
	}
	
	protected function __getPdv(){
	
		$results = $this->Pdv->find('all');
		$retorno = array();
		$path = 'files' . DS . 'pdv' . DS;
	
		if(count($results) > 0):
			foreach($results as $result):
				
				$retorno[] = array(
						'name' => $result['Pdv']['name'],
						'file' => $path.$result['Pdv']['img']
				);
				
			endforeach;
		endif;
	
		return $retorno;
	
	}
	
	//verify user and password
	protected function __login($username,$password,$data){
		
		
		$conditions = array(
				'User.username' => $username,
				'User.password' => $this->_password($password),
		);
		
		$result = $this->User->find('first',array(
						'conditions' => $conditions,
						'recursive' => 0
					));
		if(!$result)
			return false;
		
		//salva o log
		$this->LogApp->save($data);
		
		$stringHash = $result['User']['username'].$result['User']['password'];
		
		return array(
					'id' => base64_encode($result['User']['id']),
					'token' => $this->__getHash($stringHash)
				);
	}
	
	//hash password
	protected function _password($password) {
		return Security::hash($password, null, true);
	}
	
	//hash user and password
	protected function __getHash($string){
		return Security::hash($string, null, true);
	}
	
	//access by token
	protected function __tokenAccess($id,$token,$data){
		
		if(!$id && !$token)
			return false;
		
		$result = $this->User->findById(base64_decode($id));
		
		if(!$result)
			return false;
		
		$stringHash = $result['User']['username'].$result['User']['password'];
		$stringHash = $this->__getHash($stringHash);
		
		if($token == $stringHash):
			//salva o log
			$data['username'] = $result['User']['username'];
			$this->LogApp->save($data);
			
			return array(
						'id' => base64_encode($result['User']['id']),
						'token' => $stringHash
					);
		else:
		
			return false;
		
		endif;
	}
	
	/*protected function json_transform($dados){
		
		//var_dump($dados);die;
		if(!$dados)
			return false;
		
		$json  = '';
		
		$json .='[';
		$contCol = 0;
		$totalCol = count($dados);
		foreach($dados as $i => $colecao):
			$contCol++;
		
			$json .= '{';
			
			$json .= '"'.$i.'" : ';
			
			if($i == "pdvs"):
			
				
			
			elseif($i == "tabelas"):
				
			
			else:
				
				$json .= '{';
				$json .= '"id" : "'.$colecao['id'].'",';
				$json .= '"name" : "'.$colecao['id'].'",';
				$json .= '"slug" : "'.$colecao['id'].'",';
				$json .= '"categorias" : {';
				
				$contCat = 0;
				$totalCat = count($colecao["categorias"]);
				foreach($colecao["categorias"] as $b => $linha):
					$contCat++;
					$json .= '"'.$b.'"';
					$json .= '{';
					
						$json .= '"id" : "'.$linha['id'].'",';
						$json .= '"name" : "'.$linha['name'].'",';
						$json .= '"produtos" : [';
						
						$contProd = 0;
						$totalProd = count($linha['produtos']);
						foreach($linha['produtos'] as $c => $produto):
							$contProd++;
							$json .= '{';
								
								$json .= '"id" : "'.$produto['id'].'"';
								$json .= '"name" : "'.$produto['name'].'"';
								$json .= '"desc" : "'.$produto['desc'].'"';
								$json .= '"skus" : [';
								
								$contSku = 0;
								$totalSku = count($produto['skus']);
								foreach($produto['skus'] as $d => $sku):
									$contSku++;
									$json .= '{';
									
										$json .= '"ref" : "'.$sku['ref'].'",';
										//$json .= '"data_mod" : "'.$sku['data_mod'].'",';
										$json .= '"img" : "22222';
										//$json .= '"thumb" : "'.$sku['thumb'].'"';
									
									$json .= ($totalSku == $contSku ? '},' : '}');
								endforeach;
								
								$json .= ']';
						
							$json .= ($totalProd == $contProd ? '},' : '}');
						endforeach;
						
						$json .= ']';
						
					$json .= ($totalCat == $contCat ? '},' : '}');
				
				endforeach;
				
			endif;
			
			$json .= ($totalCol == $contCol ? '},' : '}');
			
			
		endforeach;
		$json .=']';
		
		print strlen($json);die;
	}*/
	
	
}