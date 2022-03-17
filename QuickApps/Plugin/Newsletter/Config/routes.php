<?php
	//Newsletter
	Router::connect('/admin/newsletters', array('plugin' => 'newsletter', 'controller' => 'newsletter', 'action' => 'index','admin' => true));
	Router::connect('/newsletter/add', array('plugin' => 'newsletter', 'controller' => 'newsletter', 'action' => 'add'));