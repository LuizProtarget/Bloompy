<script>
<?php if(isset($id_cidade)) { ?> 
	id_cidade = parseInt(<?php echo $id_cidade;?>); 
<?php }else{ ?>
	id_cidade = null;
<?php } ?>
	
	$(document).ready(function(){
		id_pais = <?php echo $id_pais; ?>;
		id_estado = <?php echo $this->data['Cidade']['id_estado']; ?>;
		
		paises = <?php echo $paises; ?>; 
		
		getPaises();
		
		if($('#CidadeIdPais').val() > 0)
			getEst($('#CidadeIdPais').val());
		if($('#CidadeIdEstado').val() > 0 && $('#CidadeIdPais').val() > 0)
		{
			getCid($('#CidadeIdPais').val(),$('#CidadeIdEstado').val());
		}
			
		$('#CidadeIdPais').change(function(){
			var element = $(this);
			if($(element).val().length > 0){
				
				getEst($(element).val());
				
			}
			else
			{
				$('#CidadeIdEstado').html('<option value="">Selecione</option>');
				$('#CidadeIdCidade').html('<option value="">Selecione</option>');
			}
			
		});
		
		$('#CidadeIdEstado').change(function(){
			element = $(this);
			elementPais = $('#CidadeIdPais').val();
			
			if($(element).val().length > 0 && elementPais > 0){
				
				getCid(elementPais,$(element).val());
				
			}
			else
				$('#CidadeIdCidade').html('<option value="">Selecione</option>');
			
		});
	});
	
	function getPaises(id)
	{	
		var html = '';
		var element = $('#CidadeIdPais');
		
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
		var element = $('#CidadeIdEstado');
		var estados = paises[id].estados;
		
		html = '<option>Selecione</option>'
		for(ind in estados)
		{
			html += "<option "+(id_estado == ind ? 'selected=selected' : '' )+" value='"+ind+"'>"+estados[ind].nome+"</option>";
		}
		$('#CidadeIdCidade').html('<option value="">Selecione</option>');
		
		element.html(html);
	}
	
	function getCid(id_pais,id_estado)
	{
		var html = '';
		var cidades = paises[id_pais].estados[id_estado].cidades;
		
		element = $('#CidadeIdCidade');
		html = '<option>Selecione</option>'
		for(ind in cidades)
		{
			html += "<option "+(id_cidade == ind ? 'selected=selected' : '' )+" value='"+ind+"'>"+cidades[ind].nome+"</option>";
		}
		
		element.html(html);
		
	}
</script>
<?php 
echo $this->Form->create('Cidade'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editar')); ?>
	<?php echo $this->Form->input('Cidade.id', array('required' => 'required', 'type' => 'hidden')); ?>
	<?php echo $this->Form->input('Cidade.nome_pt', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->input('id_pais', array('required' => 'required', 'type' => 'select', 'options' => array(''=>'Selecione'), 'label' => __t('Selecione o País'))); ?>
	<?php echo $this->Form->input('Cidade.id_estado', array('required' => 'required', 'type' => 'select', 'options' => array(''=>'Selecione'), 'label' => __t('Selecione o estado'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>