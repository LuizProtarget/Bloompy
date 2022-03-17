<?php

class ListController extends AppController {

    public $uses = array('Contatos.Contato');
    
    public $components = array('User.Correio');
    
    public function beforeFilter() {
    	parent::beforeFilter();
    	$this->QuickApps->disableSecurity();
    }

    public function admin_index() {
        if (isset($this->data["Contato"]['update'])
                && isset($this->data["Contato"]['id'])) {
            foreach ($this->data["Contato"]['id'] as $id) {
                switch ($this->data["Contato"]['update']) {
                    case 'enable':
                    case 'disable':
                    case 'delete':
                    default :
                        $method = "admin_{$this->data["Contato"]['update']}";
                        if ($this->{$method}($id))
                            $this->flashMsg(__t('Atualizou com sucesso!'));
                        else
                            $this->flashMsg(__t('Problema ao atualizar, tente novamente!'));
                }
            }

            $this->redirect("/admin/contatos/list/index");
        }
        $this->paginate = array('limit' => 100);
        $results = $this->paginate("Contato");
        $this->set(compact('results'));
        $this->setCrumb(
                "/admin/contatos/list", array(__t("Listar %s", 'Contatos'))
        );
    }

    public function add() {
        if (isset($this->data)) {
        	
        	$data = $this->data;
        	
        	//$data['birthday'] = strtotime( implode('-',array_reverse(explode('/',$data['birthday']))) );
        	
        	if(!$data['ajax']):
        		if(!empty($this->data['upload']) && !$this->data['upload']['error'])
        			unset($data['upload']);
        		
	        	if ($this->Contato->save($data)):
	        		if(!$this->__anexo())
	        			$this->redirect('/#/contato/error/file');
        			if(!$this->__sendContato())
        				$this->redirect('/#/contato/error/email');
        			
	        		$this->redirect('/#/contato/sucesso');
	        	else:
	        		$this->redirect('/#/contato/error/upload');
	        	endif;
        	
        	elseif($data['ajax']):
        		
	        	if ($this->Contato->save($data)):
	        		$this->__sendContato();
		        	print '[{"status":true}]';
		        	exit;
	        	else:
		        	print '[{"status":false}]';
		        	exit;
	        	endif;
        	endif;
	        
        }
        die();
    }

    public function admin_add() {
        if (isset($this->data['Contato'])) {
        	
        	$data = $this->data;
        	//$data['Contato']['birthday'] = implode('/',$this->data['Contato']['birthday']);
        	//$data['Contato']['birthday'] = strtotime($data['Contato']['birthday']);
        	//$data['Contato']['birthday'] = DateTime::createFromFormat('!d/m/Y', $data['Contato']['birthday'])->getTimestamp();
        	
        	//var_dump($data);die;
            if ($this->Contato->save($data)) {
                $this->flashMsg(__t("%s salvo", 'Contato'));
                $this->redirect("/admin/contatos/list/edit/" . $this->Contato->id);
            }
        }
        $this->setCrumb(
                "/admin/contatos/list/", array(__t('Adicionar %s', 'Contato'))
        );
    }

    public function admin_edit($id) {
        $result = $this->Contato->findById($id);

        if (!$result) {
            $this->redirect("/admin/contatos/list/index");
        }
        if (!empty($this->data)) {
            if ($this->Contato->save($this->data)) {
                $this->flashMsg("Contato salvo.");
                $this->redirect("/admin/contatos/list/edit/" . $result["Contato"]['id']);
            } else {
                $this->flashMsg('Problema ao salvar, tente novamente.', 'error');
            }
        } else {
            $this->data = $result;
        }

        $this->setCrumb("/admin/contatos/list", array(__t('Editar')));
    }

    public function admin_enable($id) {
        $this->Contato->id = $id;
        return $this->Contato->saveField('status', 1);
    }

    public function admin_disable($id) {
        $this->Contato->id = $id;
        return $this->Contato->saveField('status', 0);
    }

    public function admin_delete($id) {
        return $this->Contato->delete($id);
    }

    public function __sendContato() {
        $emaildestinatario = 'assistente2@pronexo.com.br';
        
    	/*if ($this->data['subject'] == 'estrangeiro')
    		$emaildestinatario = 'vendas@bloompy.com.br';
    	else if ($this->data['subject'] == 'Comercial / Vendas')
    		$emaildestinatario = 'vendas@bloompy.com.br';
    	else if ($this->data['subject'] == 'Seja Fornecedor Blompy')
    		$emaildestinatario = 'compras@bloompy.com.br';
    	else if ($this->data['subject'] == 'SAC / Dúvidas')
    		$emaildestinatario = 'sac@bloompy.com.br';
    	else if ($this->data['subject'] == 'Recursos Humanos')
    		$emaildestinatario = 'graciela@bloompy.com.br';
    	else if ($this->data['subject'] == 'Marketing')
    		$emaildestinatario = 'patricia@bloompy.com.br';
    	*/
        $this->Correio->toEmail = $emaildestinatario;
        $this->Correio->responderPara = $this->data['email'];
        $this->Correio->from = $this->data['email'];
        //$this->Correio->responderPara = $this->data['Contato']['email'];
        $this->Correio->assunto = 'Contato pelo site - ' . $this->data['subject'];
        $this->Correio->mensagem = $this->__conteudoEmail();
        $this->Correio->formato = 'html';
        $this->Correio->simpleSend();
        return true;
    }

    public function __conteudoEmail() {
    	if(isset($this->nome_arquivo)){
    		$anexo =  '<br/><br/><b>Arquivo anexo:</b><a href="http://bloompy.com.br/2013/files/anexos/'.$this->nome_arquivo.'">Clique aqui para ver o anexo</a>';
    	} else {
    		$anexo = '';
    	}
    	
        $message= "Mensagem enviada automaticamento pelo site da Bloompy
        <br /><b>Nome:</b> {$this->data['name']}<br />
		<b>Email:</b> {$this->data['email']}<br />
		<b>Estado:</b> {$this->data['state']}<br />
		<b>Cidade:</b> {$this->data['city']}<br />
		<b>Assunto:</b> {$this->data['subject']}<br />
		<br />
		<b>Mensagem:</b><br />
		{$this->data['body']}  

		
		{$anexo}
		";
		return $message;
    }

    private function __sendContLocaweb() {
        if (eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER['HTTP_HOST'])) {
            $emailsender = 'desenvolvimento@pronexo.com.br'; // Substitua essa linha pelo seu e-mail@seudominio
        } else {
            $emailsender = "webmaster@" . $_SERVER[HTTP_HOST];
        }

        if (PATH_SEPARATOR == ";")
            $quebra_linha = "\r\n"; //Se for Windows
        else
            $quebra_linha = "\n";


// Passando os dados obtidos pelo formulário para as variáveis abaixo
        $nomeremetente = $this->data['Contato']['name'];
        $emailremetente = $this->data['Contato']['email'];
        $emaildestinatario = 'riconegri@gmail.com';
        //$comcopia = $_POST['comcopia'];
        //$comcopiaoculta = $_POST['comcopiaoculta'];
        $assunto = $this->data['Contato']['subject'];
        //$mensagem = $this->__conteudoEmail();


        /* Montando a mensagem a ser enviada no corpo do e-mail. */
        $mensagemHTML = $this->__htmlEmail();

        $headers = "MIME-Version: 1.1" . $quebra_linha;
        $headers .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
        $headers .= "From: " . $emailsender . $quebra_linha;
        $headers .= "Reply-To: " . $emailremetente . $quebra_linha;
// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)

        /* Enviando a mensagem */

//É obrigatório o uso do parâmetro -r (concatenação do "From na linha de envio"), aqui na Locaweb:

        if (!mail($emaildestinatario, $assunto, $mensagemHTML, $headers, "-r" . $emailsender)) { // Se for Postfix
            $headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "não for Postfix"
            mail($emaildestinatario, $assunto, $mensagemHTML, $headers);
        }
        return true;
    }
    
    public function __anexo() {
    	if (!empty($this->data['upload']) && !$this->data['upload']['error']) {
    		 
    		$img_path = WWW_ROOT . 'files' . DS . 'anexos' . DS;
    		App::import('Vendor', 'Upload');
    		$Upload = new Upload($this->data['upload'], 'pt_BR');
    		if ($Upload->uploaded) {
    			$eu = $Upload->Process($img_path);
    			//pr($Upload);die;
    			$this->nome_arquivo = $Upload->file_dst_name;
    			if ($Upload->processed) {
    				return true;
    			} else {
    				return false;
    			}
    		}
    	}
    }

}
