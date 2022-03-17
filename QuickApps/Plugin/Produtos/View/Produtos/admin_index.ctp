<?php
	echo $this->Layout->script('/system/js/ui/jquery.ui.core.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.widget.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.mouse.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.sortable.min.js');
	echo $this->Layout->script('/produtos/js/produtos/prod');
?>
<script>
	var tpl		= '<li id="sku_{ID}" produto_id="{ID_PRODUCT}" class="even" style="margin-bottom: 5px;">' +
					'<ul class="ul_sku">' +
						'<li class="sku_attr">{COLUMN_1}</li>' +
						'<li class="sku_attr">{COLUMN_2}</li>' +
						'<li class="sku_attr">{COLUMN_3}</li>' +
						'<li class="sku_attr_var_2">' +
							'<a href="#" class="btnSkusEditar" rel="{ID}">editar</a>'+
							' | <a href="#" rel="{ID}" class="btnSkusFoto">upload de fotos</a>' +
							' | <a href="#" class="btnSkusDelete" rel="{ID}">remover</a>'+
						'</li>'+
					'</ul>'+
					'</li>';
					
	var action 					= new Array();
	action['position']	= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "produtos",	"action" => "position")); ?>";
</script>
<style>
.table{
	cursor:row-resize;
}
</style>
<?php
$tSettings = array(
	'columns' => array(
		__t('Produto') => array(
			'value' => '{php} return utf8_encode("{Produtos.name}");{/php}'
		),
		__t('Linha') => array(
			'value' => '{Linha.name}'
		),
		__t('Coleção') => array(
			'value' => '{Linha.Colecao.name}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/produtos/produtos/clear/{Produtos.produto_id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/produtos/produtos/delete/{Produtos.produto_id}{/url}' onclick=\"return confirm('" . __t('Deseja remover este produto?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há produtos no momento'),
	'paginate' => true,
	'trOptions' => array('produto_id' => '{Produtos.produto_id}','linha_id' => '{Linha.produto_linha_id}', 'cellspacing' => 0, 'border' => 0),
	'headerPosition' => 'top'
);

echo $this->Html->table($results, $tSettings);