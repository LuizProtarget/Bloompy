<?php echo $this->Form->create('Colecao'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar coleção')); ?>
	<?php echo $this->Form->input('name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome da coleção'))); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
<?php echo $this->Form->end(); ?>