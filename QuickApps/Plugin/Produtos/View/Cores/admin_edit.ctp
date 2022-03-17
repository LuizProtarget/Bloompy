<?php echo $this->Form->create('Cores'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editar cor')); ?>
	<?php echo $this->Form->input('name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome da cor'))); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
<?php echo $this->Form->end(); ?>