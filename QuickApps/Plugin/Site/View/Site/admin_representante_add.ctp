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
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar')); ?>
	<?php echo $this->Form->input('name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->input('id_estado', array('required' => 'required', 'type' => 'select', 'label' => __t('Selecione o estado'),'options' => array(''=>'Selecione')+$estados )); ?>
	<?php echo $this->Form->input('desc', array('required' => 'required', 'type' => 'textarea','onkeyup' => 'contarCaracteres(this.value,250,"sprestante_pt","RepresentanteDesc")' , 'after' => '<em id="sprestante_pt" style="font-family:Georgia;display:block"></em>','label' => __t('Descrição :'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>