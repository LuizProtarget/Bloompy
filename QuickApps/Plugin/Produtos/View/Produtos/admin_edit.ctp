<?php echo $this->Form->create('Produtos'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editar produto')); ?>
	<?php echo $this->Form->input('name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome do produto'))); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
<?php echo $this->Form->end(); ?>