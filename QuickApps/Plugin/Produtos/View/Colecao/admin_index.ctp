<?php
	
$tSettings = array(
	'columns' => array(
		__t('Coleção') => array(
			'value' => '{Colecao.name}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/produtos/colecao/edit/{Colecao.produto_colecao_id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/produtos/colecao/delete/{Colecao.produto_colecao_id}{/url}' onclick=\"return confirm('" . __t('Deseja remover esta coleção?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há coleções no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);

echo $this->Html->table($results, $tSettings);