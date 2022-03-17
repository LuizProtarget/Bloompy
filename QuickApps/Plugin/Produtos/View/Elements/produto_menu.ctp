<?php

$enable = array(
'sku' => '',
'fotos' => ''
);
if($this->Session->check('Produto.id'))
	$enable['sku'] = 'enable';

?>
<div id="menuContainer" class="menuContainer">
	<a href="#" rel="ProdutosAdminAddForm" class="menuItem enable menuItemSelected">Produto</a>
	<a href="#" rel="SkusAdminAddForm" class="menuItem <?php echo $enable['sku']; ?>">SKU</a>
	<a href="#" rel="SkuFotosAdminAddForm" class="openFileUpload menuItem <?php echo $enable['sku']; ?>">Fotos</a>
</div>