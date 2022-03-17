<?php echo $this->Html->tag('h4', $resultDados['Linha']['Colecao']['name'] . ' / ' . $resultDados['Linha']['name'] . ' / ' . $resultDados['Produtos']['name']); ?>
<?php echo $this->Form->create('Sku',array('type'=>'file', 'action'=>'upload')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Upload de fotos')); ?>
	<?php echo $this->Form->input('referencia', array('required' => 'required', 'type' => 'text', 'label' => __t('Referência do produto'))); ?>
	<?php echo $this->Form->input('exibir_site', array('required' => 'required', 'type' => 'select', 'options' => array(1 => 'Sim', 0 => 'Não'), 'label' => __t('Exibir no site?'))); ?>
	<?php echo $this->Form->input('exibir_mobile', array('required' => 'required', 'type' => 'select', 'options' => array(1 => 'Sim', 0 => 'Não'), 'label' => __t('Exibir no celular?'))); ?>
	<?php echo $this->Form->input('filename', array('required' => 'required', 'type' => 'file', 'label' => __t('Selecione a foto do produto'))); ?>
	<?php echo $this->Form->input('produto_id', array('required' => 'required', 'type' => 'hidden', 'value' =>  $resultDados['Produtos']['produto_id'])); ?>
	<?php echo $this->Form->submit(__t('Upload')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php if(isset($resultFotos[0]) && is_array($resultFotos)): ?>
<?php echo $this->Form->create('Sku',array('action'=>'remove')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Fotos enviadas')); ?>
	<ul class="containerGalery">
		<?php foreach($resultFotos as $foto): ?>
		<li>
			<span class="galery_ref">Ref.: <?php print $foto['Skus']['referencia']; ?></span>
			<input type="checkbox" name="data[Sku][foto][]" value="<?php print $foto['Skus']['produto_sku_id']; ?>" id="SkuFoto">
			<hr />
			<?php print $this->Html->image('/img/produtos/thumb/' . $foto['Skus']['filename'], array('height' => '100', 'alt' => 'Ref.: ' .$foto['Skus']['referencia'], 'title' => 'Ref.: ' .$foto['Skus']['referencia'])); ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php echo $this->Form->submit(__t('Remover fotos selecionadas')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>
<?php endif; ?>