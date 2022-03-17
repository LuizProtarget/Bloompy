<?php echo $this->Form->create('Linha'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar linha')); ?>
	<?php echo $this->Form->input('produto_colecao_id', array('required' => 'required', 'type' => 'select', 'options' => $colecao_list, 'label' => __t('Nome da linha'))); ?>
	<?php echo $this->Form->input('name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome da linha'))); ?>
	<?php echo $this->Form->input('exibir_site', array('required' => 'required', 'type' => 'select', 'options' => array('1' => 'Sim','0' => 'Não'), 'label' => __t('Exibir Site: '))); ?>
	<?php echo $this->Form->input('exibir_mobile', array('required' => 'required', 'type' => 'select', 'options' => array('1' => 'Sim','0' => 'Não'), 'label' => __t('Exibir Mobile: '))); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
<?php echo $this->Form->end(); ?>