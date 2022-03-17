<?php
/**
 * Site Controller Hooks
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Site.Controller.Component
 * @version	 1.0
 * @author	 Pronexo By Jingle
 * @link	 http://www.quickappscms.org
 */
class SiteHookComponent extends Component {
	public $Controller = null;

	public function initialize(Controller $Controller) {
		$this->Controller = $Controller;
	}

	public function search_results($query) {
		return $this->Controller->requestAction("/s/{$query}");
	}
}