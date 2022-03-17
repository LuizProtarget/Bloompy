<?php
/**
 * Locale View Hooks
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Locale.View.Helper
 * @version	 1.0
 * @author	 Christopher Castro <chris@qucikapps.es>
 * @link	 http://www.quickappscms.org
 */
class ProdutosHookHelper extends AppHelper {
/**
 * Toolbar menu for section: `Languages`.
 *
 * @return void
 */
	public function beforeLayout($layoutFile) {
		if (Router::getParam('admin') && $this->request->params['plugin'] == 'produtos') {
			$this->_View->Block->push(array('body' => $this->_View->element('toolbar') . '<!-- ProdutosHookHelper -->'), 'toolbar');
		}

		return true;
	}
}