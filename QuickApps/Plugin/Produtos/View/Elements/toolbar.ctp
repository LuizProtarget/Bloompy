<?php
	$links = array(
		array(__t('Nova Coleção'), '/admin/produtos/colecao/add', array('title' => __t('Nova coleção'))),
		array(__t('Nova Linha'), '/admin/produtos/linha/add', array('title' => __t('Nova linha'))),
		array(__t('Novo Produto'), '/admin/produtos/produtos/clear', array('title' => __t('Novo produto')))
	);

	echo $this->Menu->toolbar($links);