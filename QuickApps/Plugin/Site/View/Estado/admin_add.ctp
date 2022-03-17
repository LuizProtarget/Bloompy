<?php echo $this->Form->create('Estado'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar')); ?>
	<?php echo $this->Form->input('nome_pt', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->input('sigla', array('required' => 'required', 'type' => 'text', 'maxlength' =>'2','label' => __t('Sigla'))); ?>
	<?php echo $this->Form->input('id_pais', array('required' => 'required', 'type' => 'select', 'options' => (isset($paises) ? array(''=>'Selecione')+$paises : array(''=>'Selecione')), 'label' => __t('Selecione o País'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>