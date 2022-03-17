<?php
	//lojas
	Router::connect('/admin/lojas', array('plugin' => 'site', 'controller' => 'site', 'action' => 'lojas','admin' => true));
	Router::connect('/admin/loja/add/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'loja_add','admin' => true));
	Router::connect('/admin/loja/edit/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'loja_edit','admin' => true));
	Router::connect('/admin/loja/delete/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'loja_delete','admin' => true));
	
	//ajax back and front
	Router::connect('/admin/loja/ajax/estado', array('plugin' => 'site', 'controller' => 'site', 'action' => 'getCid'));
	
	//representantes
	Router::connect('/admin/representantes', array('plugin' => 'site', 'controller' => 'site', 'action' => 'representantes','admin' => true));
	Router::connect('/admin/representante/add/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'representante_add','admin' => true));
	Router::connect('/admin/representante/edit/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'representante_edit','admin' => true));
	Router::connect('/admin/representante/delete/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'representante_delete','admin' => true));
	
	//lojas virtuais
	Router::connect('/admin/lojasvirtuais', array('plugin' => 'site', 'controller' => 'site', 'action' => 'lojas_virtuais','admin' => true));
	Router::connect('/admin/lojavirtual/add/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'loja_virtual_add','admin' => true));
	Router::connect('/admin/lojavirtual/edit/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'loja_virtual_edit','admin' => true));
	Router::connect('/admin/lojavirtual/delete/*', array('plugin' => 'site', 'controller' => 'site', 'action' => 'loja_virtual_delete','admin' => true));
	
	//cidades
	Router::connect('/admin/cidades', array('plugin' => 'site', 'controller' => 'cidade', 'action' => 'index','admin' => true));
	Router::connect('/admin/cidade/add/*', array('plugin' => 'site', 'controller' => 'cidade', 'action' => 'add','admin' => true));
	Router::connect('/admin/cidade/edit/*', array('plugin' => 'site', 'controller' => 'cidade', 'action' => 'edit','admin' => true));
	Router::connect('/admin/cidade/delete/*', array('plugin' => 'site', 'controller' => 'cidade', 'action' => 'delete','admin' => true));
	
	//estados
	Router::connect('/admin/estados', array('plugin' => 'site', 'controller' => 'estado', 'action' => 'index','admin' => true));
	Router::connect('/admin/estado/add/*', array('plugin' => 'site', 'controller' => 'estado', 'action' => 'add','admin' => true));
	Router::connect('/admin/estado/edit/*', array('plugin' => 'site', 'controller' => 'estado', 'action' => 'edit','admin' => true));
	Router::connect('/admin/estado/delete/*', array('plugin' => 'site', 'controller' => 'estado', 'action' => 'delete','admin' => true));
	
	//paises
	Router::connect('/admin/paises', array('plugin' => 'site', 'controller' => 'pais', 'action' => 'index','admin' => true));
	Router::connect('/admin/pais/add/*', array('plugin' => 'site', 'controller' => 'pais', 'action' => 'add','admin' => true));
	Router::connect('/admin/pais/edit/*', array('plugin' => 'site', 'controller' => 'pais', 'action' => 'edit','admin' => true));
	Router::connect('/admin/pais/delete/*', array('plugin' => 'site', 'controller' => 'pais', 'action' => 'delete','admin' => true));
	
	//aplicativos
	Router::connect('/aplicativo/*', array('plugin' => 'site', 'controller' => 'pages', 'action' => 'aplicativo'));