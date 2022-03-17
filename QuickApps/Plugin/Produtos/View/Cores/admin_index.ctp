<?php
	
$tSettings = array(
	'columns' => array(
		__t('Cor') => array(
			'value' => '{Cores.name}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/produtos/cores/edit/{Cores.produto_cor_id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/produtos/cores/delete/{Cores.produto_cor_id}{/url}' onclick=\"return confirm('" . __t('Deseja remover esta cor?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há cores no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);

echo $this->Html->table($results, $tSettings);