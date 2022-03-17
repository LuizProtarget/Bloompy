<?php
/**
 * Newsletter Controller Hooks
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Newsletter.Controller.Component
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
class NewsletterHookComponent extends Component {
	public $Controller = null;

	public function initialize(Controller $Controller) {
		$this->Controller = $Controller;
	}

	public function search_results($query) {
		return $this->Controller->requestAction("/s/{$query}");
	}
}