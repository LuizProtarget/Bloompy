<?php
	
$tSettings = array(
	'columns' => array(
		__t('Linha') => array(
			'value' => '{Linha.name}'
		),
		__t('Coleção') => array(
			'value' => '{Colecao.name}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/produtos/linha/edit/{Linha.produto_linha_id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/produtos/linha/delete/{Linha.produto_linha_id}{/url}' onclick=\"return confirm('" . __t('Deseja remover esta linha?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há linhas no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);

echo $this->Html->table($results, $tSettings);