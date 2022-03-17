<script>
	
	$(document).ready(function(){
		paises = <?php echo $paises; ?>; 
		
		getPaises();
		
		if($('#CidadeIdPais').val() > 0)
			getEst($('#CidadeIdPais').val());
		if($('#CidadeIdEstado').val() > 0 && $('#CidadeIdPais').val())
			getCidade($('#CidadeIdPais').val(),$('#CidadeIdEstado').val());
			
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
	});
	
	function getPaises(id)
	{	
		var html = '';
		var element = $('#CidadeIdPais');
		
		html = '<option value>Selecione</option>'
		for(ind in paises)
		{
			html += "<option value='"+ind+"'>"+paises[ind].nome+"</option>";
		}
		
		element.html(html);
	}
	
	function getEst(id)
	{	
		var html = '';
		var element = $('#CidadeIdEstado');
		var estados = paises[id].estados;
		
		html = '<option value>Selecione</option>'
		for(ind in estados)
		{
			html += "<option value='"+ind+"'>"+estados[ind].nome+"</option>";
		}
		
		element.html(html);
	}
	
</script>
<?php 
echo $this->Form->create('Cidade'); ?>
	<?php echo $this->Html->useTag('fieldsetstart', __t('Adicionar')); ?>
	<?php echo $this->Form->input('nome_pt', array('required' => 'required', 'type' => 'text', 'label' => __t('Nome'))); ?>
	<?php echo $this->Form->input('id_pais', array('required' => 'required', 'type' => 'select', 'options' => array(''=>'Selecione'), 'label' => __t('Selecione o País'))); ?>
	<?php echo $this->Form->input('id_estado', array('required' => 'required', 'type' => 'select', 'options' => (isset($estados) ? $estados : array(''=>'Selecione')), 'label' => __t('Selecione o Estado'))); ?>
	<?php echo $this->Form->submit(__t('Salvar')); ?>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>