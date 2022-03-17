<?php 
echo $this->Form->create('Loja',array('type' => 'file')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar')); ?>
	<?php echo $this->Form->input('arquivo', array('required' => 'required', 'type' => 'file', 'label' => 'Arquivo')); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>