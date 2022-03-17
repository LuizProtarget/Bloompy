<script>
	function contarCaracteres(box,valor,campospan,IdCampo){ 
		var conta = valor - box.length;
		
		document.getElementById(campospan).innerHTML = "Você ainda pode digitar " + conta + " caracteres";
		if(box.length >= valor){ 
			document.getElementById(campospan).innerHTML = "Opss.. você não pode mais digitar..";
			document.getElementById(IdCampo).value = document.getElementById(IdCampo).value.substr(0,valor); 
		}	 
	}
	
</script>
<?php 
echo $this->Form->create('Representante'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editar')); ?>
	<?php echo $this->Form->input('Representante.id', array('required' => 'required', 'type' => 'hidden')); ?>
	<?php echo $this->Form->input('Representante.name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->input('Representante.id_estado', array('required' => 'required', 'type' => 'select', 'options' => (isset($estados) ? $estados : array(''=>'Selecione')), 'label' => __t('Selecione o estado'))); ?>
	<?php echo $this->Form->input('Representante.desc', array('required' => 'required', 'type' => 'textarea','onkeyup' => 'contarCaracteres(this.value,250,"sprestante_pt","RepresentanteDesc")' , 'after' => '<em id="sprestante_pt" style="font-family:Georgia;display:block"></em>','label' => __t('Descrição :'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>