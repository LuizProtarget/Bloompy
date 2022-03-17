<?php 
echo $this->Form->create('LojaVirtual',array('enctype' => 'multipart/form-data')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar')); ?>
	<?php echo $this->Form->input('link', array('required' => 'required', 'type' => 'text','style' => 'width:500px', 'label' => __t('Link'))); ?>
	<?php echo $this->Form->input('filename', array('required' => 'required', 'type' => 'file','label' => __t('Imagem :'))); ?>	
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>