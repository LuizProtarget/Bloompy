<?php
class ContatoHookComponent extends Component {
	var $Controller = null;
	var $components = array('Hook');

	function initialize(Controller $Controller){
		$this->Controller = $Controller;
	}
}