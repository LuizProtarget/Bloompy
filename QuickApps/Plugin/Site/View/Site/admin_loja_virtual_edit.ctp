<?php 
echo $this->Form->create('LojaVirtual',array('enctype' => 'multipart/form-data')); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editar')); ?>
	<?php echo $this->Form->input('LojaVirtual.id', array('required' => 'required', 'type' => 'hidden','style' => 'width:500px')); ?>
	<?php echo $this->Form->input('LojaVirtual.link', array('required' => 'required', 'type' => 'text','style' => 'width:500px', 'label' => __t('Link'))); ?>
	<?php echo $this->Form->input('LojaVirtual.filename', array( 'type' => 'file','label' => __t('Imagem :'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<div id="img" style="margin-top: 60px;">
	<?php 
		echo $this->Html->useTag('fieldsetstart', __t('Imagem Atual'));
		echo "<div style='margin:15px;display: inline-block;'>";
		echo $this->Html->image('lojasvirtuais/thumb/'.$this->data['LojaVirtual']['filename'], array('id' => 'img-user'));
		
		echo "</div>";
	echo $this->Html->useTag('fieldsetend');
	?>
</div>