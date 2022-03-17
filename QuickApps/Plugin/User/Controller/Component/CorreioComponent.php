<?php

/**
 * User Mailer Component
 *
 * PHP version 5
 *
 * @package  QuickApps.Plugin.User.Controller.Component
 * @version  1.0
 * @author   Christopher Castro <chris@qucikapps.es>
 * @link     http://cms.quickapps.es
 */
class CorreioComponent extends Component {

    public $Controller;
    //public $components = array('Email');
    public $errors = array();
    public $from = false;
    public $quebra_linha = "\n";
    public $toName = false;
    public $toEmail = false;
    public $emaildestinatario = false;
    public $comcopia = false;
    public $comcopiaoculta = false;
    public $assunto = false;
    public $mensagem = false;
    public $mensagemHtml = false;
    public $responderPara = false;
    public $headers = false;
    public $formato = false;

    public function initialize(Controller $Controller) {
        $this->Controller = & $Controller;
        return true;
    }

    public function simpleSend() {
        $this->mensagemHtml = $this->corpoHtml();
        $this->headers = $this->header();
        $this->toEmail . $this->assunto . $this->mensagemHtml . $this->headers;
        if ($this->sendEmail()) {
            return true;
        } else {
            return false;
        }
    }

    public function send($user_id, $type) {
        $user = is_numeric($user_id) ? ClassRegistry::init('User.User')->findById($user_id) : $user_id;
        if (!$user) {
            $this->errors[] = __t('User not found.');

            return false;
        }
        //$this->toEmail = $user['User']['email'];
        //$this->toName = $user['User']['name'];
        //echo Configure::read('Variable.site_mail');die;
        //$this->from = 'proshows@proshows.com.br';

        if (!is_array($type)) {
            if (is_integer($type)) {
                switch ($type) {
                    case 0: $type = 'blocked';
                        break;
                    case 1: $type = 'activation';
                        break;
                    case 2: $type = 'canceled';
                        break;
                    case 3: $type = 'password_recovery';
                        break;
                    case 4: $type = 'welcome';
                        break;
                }
            }

            $variables = $this->mailVariables();

            if (isset($variables["user_mail_{$type}_body"]) && isset($variables["user_mail_{$type}_subject"])) {
                if (isset($variables["user_mail_{$type}_notify"]) && !$variables["user_mail_{$type}_notify"]) {
                    $this->errors[] = __t('This message has been marked as "do not notify".');

                    return false;
                }

                $this->assunto = $this->parseVariables($user, $variables["user_mail_{$type}_subject"]);
                $this->mensagem = $this->parseVariables($user, $variables["user_mail_{$type}_body"]);
                $this->mensagemHtml = $this->corpoHtml();
                $this->headers = $this->header();
                if ($this->sendEmail()) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return false;
    }

    public function header() {
        $headers = "MIME-Version: 1.1" . $this->quebra_linha;
        $headers .= "Content-type: text/html; charset=utf-8" . $this->quebra_linha;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
        $headers .= "From: " . $this->from . $this->quebra_linha;
        if ($this->comcopia)
            $headers .= "Cc: " . $this->comcopia . $this->quebra_linha;
        if ($this->comcopiaoculta)
            $headers .= "Bcc: " . $this->comcopiaoculta . $this->quebra_linha;
        if ($this->responderPara)
            $headers .= "Reply-To: " . $this->responderPara . $this->quebra_linha;
        return $headers;
    }

    public function sendEmail() {
        if (!mail($this->toEmail, $this->assunto, $this->mensagemHtml, $this->headers, "-r" . $this->from)) { // Se for Postfix
            $this->headers .= "Return-Path: " . $this->from . $this->quebra_linha; // Se "não for Postfix"
            if (mail($this->toEmail, $this->assunto, $this->mensagemHtml, $this->headers)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    public function mailVariables() {
        $v = array();
        $this->Variable = ClassRegistry::init('System.Variable');
        $variables = $this->Controller->Variable->find('all', array(
            'conditions' => array(
                'Variable.name LIKE' => 'user_mail_%'
            )
                )
        );
        $this->__smtp = $this->Controller->Variable->find('all', array(
            'conditions' => array(
                'Variable.name LIKE' => 'smtp_%'
            )
                ));

        foreach ($variables as $var) {
            $v[$var['Variable']['name']] = $var['Variable']['value'];
        }

        return $v;
    }

    public function corpoHtml() {
    	
    	return 
    		'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    			<html xmlns="http://www.w3.org/1999/xhtml">
    				<head>
    					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    					<title>Untitled Document</title>
    				</head>
    			<body>
    				<center>
    					<table width="587" border="0" cellspacing="0" cellpadding="0">
    						<tr>
    							<td>
    								<table width="588" border="0" style="background-color:#FFFFFF" cellspacing="0" cellpadding="0">
    									<tbody>
    										<tr>
    											<td width="310" style="padding:20px;">' . $this->mensagem . '</td>
    										</tr>
    									</tbody>
    								</table>
    							</td>
    						</tr>
    					</table>
    				</center>
    			</body>
    			</html>
    	';
    }

    public function parseVariables($user, $text) {
        if (is_numeric($user)) {
            $user = ClassRegistry::init('User.User')->findById($user);
        }

        if (!isset($user['User']) || empty($text)) {
            return false;
        }

        preg_match_all('/\[user_(.+)\]/iUs', $text, $userVars);
        foreach ($userVars[1] as $var) {
            if (isset($user['User'][$var])) {
                $text = str_replace("[user_{$var}]", $user['User'][$var], $text);
            } else {
                switch ($var) {
                    case 'activation_url':
                        $text = str_replace("[user_{$var}]", Router::url("/user/activate/{$user['User']['id']}/{$user['User']['key']}", true), $text);
                        break;

                    case 'cancel_url':
                        $text = str_replace("[user_{$var}]", Router::url("/user/cancell/{$user['User']['id']}/{$user['User']['key']}", true), $text);
                        break;
                }
            }
        }

        preg_match_all('/\[site_(.+)\]/iUs', $text, $siteVars);
        foreach ($siteVars[1] as $var) {
            if ($v = Configure::read("Variable.site_{$var}")) {
                $text = str_replace("[site_{$var}]", $v, $text);
            } else {
                switch ($var) {
                    case 'url':
                        $text = str_replace("[site_{$var}]", Router::url("/", true), $text);
                        break;

                    case 'login_url':
                        $text = str_replace("[site_{$var}]", Router::url("/user/login", true), $text);
                        break;
                }
            }
        }

        if (Configure::read('Variable.url_language_prefix') && isset($user['User']['language']) && !empty($user['User']['language'])) {
            preg_match_all('/\/([a-z]{3})\//s', $text, $lang);

            foreach ($lang[0] as $m) {
                $text = str_replace($m, "/{$user['User']['language']}/", $text);
            }
        }

        return $text;
    }

}