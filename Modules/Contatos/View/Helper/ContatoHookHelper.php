<?php
/**
 * Seo View Hooks
 *
 * PHP version 5
 *
 * @package  QuickApps.Modules.Newsletters.View.Helper
 * @version  0.1
 * @author   Ricardo Negri<riconegri@quickapps.es>
 * @link     http://quickapps.com.br
 */
class ContatoHookHelper extends AppHelper {

    public function beforeLayout($layoutFile) {
        # urls toolbar:
        if (isset($this->request->params['admin']) &&
            $this->request->params['plugin'] == 'contatos'
        ) {
            $this->_View->Block->push(array('body' => $this->_View->element('toolbar') . '<!-- ContatosHookHelper -->' ), 'toolbar');
        }    

        return true;
    }

        // Block, user login form
    public function user_login() {
        return array(
            'title' => __t('Inscrever'),
            'body' => $this->_View->element('Newsletters.addnewsletter_block')
        );
    }


    public function beforeRender($viewFile) {
//        $_url = empty($this->_View->request->url) ? '/' : $this->_View->request->url;
//        $_url = str_replace('//', '/', "/{$_url}");
//        $cache = Cache::read('seo_url_' . md5($_url), 'seo_tools_optimized_url');
//
//        if ($cache && $cache['status']) {
//            $this->__url = array_merge($this->__url, $cache);
//            $this->__url['url'] = $_url;
//
//            if ($this->__url['redirect']) {
//                header('Location: ' . $this->__url['redirect']);
//                die();
//            }
//
//            if ($this->__url['description']) {
//                $this->_View->viewVars['Layout']['meta']['description'] = $this->__url['description'];
//            }
//
//            if ($this->__url['keywords']) {
//                $this->_View->viewVars['Layout']['meta']['keywords'] = $this->__url['keywords'];
//            }
//
//            if ($this->__url['header']) {
//                $this->_View->viewVars['Layout']['header'][] = $this->__url['header'];
//            }
//
//            if ($this->__url['footer']) {
//                $this->_View->viewVars['Layout']['footer'][] = $this->__url['footer'];
//            }
//        }
    }

    public function title_for_layout_alter(&$title) {
        if ($this->__url['title']) {
            $title = $this->__url['title'];
        }
    }
}