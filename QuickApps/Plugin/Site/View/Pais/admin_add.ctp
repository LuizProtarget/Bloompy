<?php echo $this->Form->create('Pais'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar')); ?>
	<?php echo $this->Form->input('nome_pt', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>