<?php $this->Layout->script("/produtos/js/plupload/jquery.plupload.queue/jquery.plupload.queue.js"); ?>
<?php $this->Layout->css("/produtos/js/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css"); ?>
<?php $this->Layout->script("/produtos/js/plupload/plupload.full.js"); ?>
<?php $this->Layout->script("/produtos/js/plupload/i18n/pt-br.js"); ?>
<?php $this->Layout->script("/produtos/js/jquerymask/money/jquery.maskMoney.min.js"); ?>
<?php 
	echo $this->Layout->script('/system/js/ui/jquery.ui.core.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.widget.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.mouse.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.sortable.min.js');
	echo $this->Layout->script('/produtos/js/produtos/prod');
?>
<script>
var id_linha = parseInt(<?php echo (isset($produto['Linha']['produto_linha_id']) ? $produto['Linha']['produto_linha_id'] : 0); ?>);
</script>
<?php print $this->element('produto_menu'); ?>
<?php echo $this->Form->create('Produtos',array('enctype' => 'multipart/form-data')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar/Editar')); ?>
	<?php echo $this->Form->input('produto_colecao_id', array('selected' => (isset($produto['Linha']['Colecao']) ? $produto['Linha']['Colecao']['produto_colecao_id'] : ''), 'required' => 'required', 'type' => 'select', 'options' => $colecao_list, 'label' => __t('Selecione a coleção'))); ?>
	<?php echo $this->Form->input('produto_linha_id', array('selected' => (isset($produto['Linha']['produto_linha_id']) ? $produto['Linha']['produto_linha_id'] : ''), 'required' => 'required', 'type' => 'select', array(''=>'Selecione'), 'label' => __t('Selecione a linha'))); ?>
	<?php echo $this->Form->input('genero', array('selected' => (isset($produto['Produtos']['genero']) ? $produto['Produtos']['genero'] : ''),'options' => array('' => 'Gênero','menino' => 'Menino','menina' => 'Menina' ) , 'required' => 'required', 'type' => 'select', array(''=>'Selecione'), 'label' => __t('Selecione o gênero'))); ?>
	<?php echo $this->Form->input('name', array('value' => (isset($produto['Produtos']['name']) ? $produto['Produtos']['name'] : '') ,'required' => 'required', 'type' => 'text', 'label' => __t('Nome do produto'))); ?>
	<?php echo $this->Form->input('description', array('required' => 'required', 'value' => (isset($produto['Produtos']['description']) ? $produto['Produtos']['description'] : ''),'type' => 'textarea', 'label' => __t('Descrição'))); ?>
	<?php echo $this->Form->input('preco_1', array('value' => (isset($produto['Produtos']['preco_1']) ? $produto['Produtos']['preco_1'] : '') , 'type' => 'text', 'label' => __t('Preço Tabela 1'))); ?>
	<?php echo $this->Form->input('preco_2', array('value' => (isset($produto['Produtos']['preco_2']) ? $produto['Produtos']['preco_2'] : '') ,'type' => 'text', 'label' => __t('Preço Tabela 2'))); ?>
	<?php echo $this->Html->tag('hr'); ?>
	<?php if(isset($produto['Produtos']['produto_id'])) echo $this->Form->hidden('produto_id', array('value'=>$produto['Produtos']['produto_id'])); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php if($this->Session->check('Produto.id')): ?>
<?php echo $this->Form->create('Skus',array('style'=>'display:none;','action'=>'/sku/add', 'id'=>'SkusAdminAddForm')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar/Editar')); ?>
	<?php echo $this->Form->input('referencia', array('required' => 'required', 'type' => 'text', 'label' => __t('Referência do produto'))); ?>
	<?php echo $this->Form->input('cor', array('required' => 'required', 'type' => 'text', 'label' => __t('Cor'))); ?>
	<?php echo $this->Form->input('exibir_site', array('required' => 'required', 'type' => 'select', 'options' => array(1 => 'Sim', 0 => 'Não'), 'label' => __t('Exibir no site?'))); ?>
	<?php echo $this->Form->input('exibir_mobile', array('required' => 'required', 'type' => 'select', 'options' => array(1 => 'Sim', 0 => 'Não'), 'label' => __t('Exibir no celular?'))); ?>
	<?php if(isset($produto['Produtos']['produto_id'])) echo $this->Form->hidden('produto_id', array('value'=>$produto['Produtos']['produto_id'])); ?>
	<?php if(isset($produto['Produtos']['produto_id'])) echo $this->Form->hidden('produto_sku_id', array('value'=>'')); ?>
	<?php echo $this->Form->submit(__t(' + '), array('type' => 'button', 'id'=>"btnAddSku")); ?>
	<div id="skuLoading"> salvando, aguarde... </div>
	<?php echo $this->Html->tag('hr'); ?>
	
	<table id="tableSKU" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
		<thead>
			<tr>		
				<th align="left">Referência</th>
				<th align="left">Cor</th>
				<th align="left">Exibir no site</th>
				<th align="left">Exibir no celular</th>
				<th align="right">Ações</th> 
			</tr>
		</thead>
		<tbody>
		<?php 
			if(isset($skus_list) && is_array($skus_list)):
			
				$legends = array( 1 => 'Sim', 0 => 'Não');

				foreach($skus_list as $sku_row):
		?>
			<tr id="sku_<?php print $sku_row['Skus']['produto_sku_id']; ?>" produto_id="<?php print $sku_row['Skus']['produto_id']; ?>" class="even">
				<td align="left"><?php print $sku_row['Skus']['referencia']; ?></td>
				<td align="left"><?php print $sku_row['Skus']['cor']; ?></td>
				<td align="left"><?php print $legends[$sku_row['Skus']['exibir_site']]; ?></td>
				<td align="left"><?php print $legends[$sku_row['Skus']['exibir_mobile']]; ?></td>
				<td align="right">
				<a href="#" rel="<?php print $sku_row['Skus']['produto_sku_id']; ?>" class="btnSkusEditar">editar</a>
				| <a href="#" rel="<?php print $sku_row['Skus']['produto_sku_id']; ?>" class="btnSkusFoto">upload de fotos</a>
				| <a href="#" rel="<?php print $sku_row['Skus']['produto_sku_id']; ?>" class="btnSkusDelete">remover</a>
				</td>
			</tr>
		<?php 
				endforeach;
			endif;
		?>
		</tbody>
	</table>
	
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Form->create('Skus',array('style'=>'display:none;','action'=>'/sku/upload', 'id'=>'SkuFotosAdminAddForm')); ?>
<?php echo $this->Html->useTag('fieldsetstart', __t('Upload de fotos')); ?>
<div id="html5_uploader" class="control-group" style="margin-top: 50px;">You browser doesn't support native upload. Try Firefox 3 or Safari 4.</div>
<?php echo $this->Html->tag('hr'); ?>
<ul id="sortable" class="produtoFotoGaleria">
</ul>
<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php endif; ?>



<script type="text/javascript">

var formData 				= null;
var action 					= new Array();
	action['removerFoto'] 	= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus","action" => "removerFoto")); ?>";
	action['getFotos'] 		= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus","action" => "getFotos")); ?>";
	action['urlSilverlight']= "<?php echo $this->Html->url('/produtos/js/plupload/plupload.silverlight.xap' ); ?>";
	action['upload']		= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus","action" => "upload")); ?>";
	action['delete']		= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus","action" => "delete")); ?>";
	action['getSku']		= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus","action" => "get")); ?>";
	action['addSku']		= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus","action" => "add")); ?>";
	action['positionFoto']	= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus",	"action" => "position")); ?>";
	action['positionSku']	= "<?php echo $this->Html->url(array("plugin" => "produtos","controller" => "skus",	"action" => "positionSku")); ?>";
	
</script>