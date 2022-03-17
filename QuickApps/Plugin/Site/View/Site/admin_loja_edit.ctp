<script>
<?php if(isset($id_cidade)) { ?> 
	id_cidade = parseInt(<?php echo $id_cidade;?>); 
<?php }else{ ?>
	id_cidade = null;
<?php } ?>
	
	function contarCaracteres(box,valor,campospan,IdCampo){ 
		var conta = valor - box.length;
		
		document.getElementById(campospan).innerHTML = "Você ainda pode digitar " + conta + " caracteres";
		if(box.length >= valor){ 
			document.getElementById(campospan).innerHTML = "Opss.. você não pode mais digitar..";
			document.getElementById(IdCampo).value = document.getElementById(IdCampo).value.substr(0,valor); 
		}	 
	}
	
	$(document).ready(function(){
		id_pais = <?php echo $this->data['Loja']['id_pais']; ?>;
		id_estado = <?php echo $this->data['Loja']['id_estado']; ?>;
		id_cidade = <?php echo $this->data['Loja']['id_cidade']; ?>;
		
		paises = <?php echo $paises; ?>; 
		
		getPaises();
		
		if($('#LojaIdPais').val() > 0)
			getEst($('#LojaIdPais').val());
		if($('#LojaIdEstado').val() > 0 && $('#LojaIdPais').val() > 0)
		{
			getCid($('#LojaIdPais').val(),$('#LojaIdEstado').val());
		}
			
		$('#LojaIdPais').change(function(){
			var element = $(this);
			if($(element).val().length > 0){
				
				getEst($(element).val());
				
			}
			else
			{
				$('#LojaIdEstado').html('<option value="">Selecione</option>');
				$('#LojaIdCidade').html('<option value="">Selecione</option>');
			}
			
		});
		
		$('#LojaIdEstado').change(function(){
			element = $(this);
			elementPais = $('#LojaIdPais').val();
			
			if($(element).val().length > 0 && elementPais > 0){
				
				getCid(elementPais,$(element).val());
				
			}
			else
				$('#LojaIdCidade').html('<option value="">Selecione</option>');
			
		});
	});
	
	function getPaises(id)
	{	
		var html = '';
		var element = $('#LojaIdPais');
		
		html = '<option>Selecione</option>'
		for(ind in paises)
		{
			html += "<option "+(id_pais == ind ? 'selected=selected' : '' )+" value='"+ind+"'>"+paises[ind].nome+"</option>";
		}
		
		element.html(html);
	}
	
	function getEst(id)
	{	
		var html = '';
		var element = $('#LojaIdEstado');
		var estados = paises[id].estados;
		
		html = '<option>Selecione</option>'
		for(ind in estados)
		{
			html += "<option "+(id_estado == ind ? 'selected=selected' : '' )+" value='"+ind+"'>"+estados[ind].nome+"</option>";
		}
		$('#LojaIdCidade').html('<option value="">Selecione</option>');
		
		element.html(html);
	}
	
	function getCid(id_pais,id_estado)
	{
		var html = '';
		var cidades = paises[id_pais].estados[id_estado].cidades;
		
		element = $('#LojaIdCidade');
		html = '<option>Selecione</option>'
		for(ind in cidades)
		{
			html += "<option "+(id_cidade == ind ? 'selected=selected' : '' )+" value='"+ind+"'>"+cidades[ind].nome+"</option>";
		}
		
		element.html(html);
		
	}
</script>
<?php 
echo $this->Form->create('Loja'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editar')); ?>
	<?php echo $this->Form->input('Loja.id', array('required' => 'required', 'type' => 'hidden')); ?>
	<?php echo $this->Form->input('Loja.name', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->input('Loja.id_pais', array('required' => 'required', 'type' => 'select', 'options' => array(''=>'Selecione'), 'label' => __t('Selecione o País'))); ?>
	<?php echo $this->Form->input('Loja.id_estado', array('required' => 'required', 'type' => 'select', 'options' => array(''=>'Selecione'), 'label' => __t('Selecione o estado'))); ?>
	<?php echo $this->Form->input('Loja.id_cidade', array('required' => 'required', 'type' => 'select', 'options' => array(''=>'Selecione'), 'label' => __t('Selecione a cidade'))); ?>
	<?php echo $this->Form->input('Loja.desc', array('required' => 'required', 'type' => 'textarea','onkeyup' => 'contarCaracteres(this.value,250,"sprestante_pt","LojaDesc")' , 'after' => '<em id="sprestante_pt" style="font-family:Georgia;display:block"></em>','label' => __t('Descrição :'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>