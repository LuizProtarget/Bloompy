<script>

$(document).ready(function(){
		paises = <?php echo $paises; ?>; 
		
		getPaises();
		
		if($('#CidadeFilterCidadeidPais').val() > 0)
			getEst($('#CidadeFilterCidade|idPais').val());
			
		$('#CidadeFilterCidadeIdPais').change(function(){
			var element = $(this);
			if($(element).val().length > 0){
				
				getEst($(element).val());
				
			}
			else
			{
				$('#CidadeFilterCidadeIdEstado').html('<option value="">Selecione</option>');
				$('#CidadeFilterCidadeIdCidade').html('<option value="">Selecione</option>');
			}
			
		});
	});
	
	function getPaises(id)
	{	
		var html = '';
		var element = $('#CidadeFilterCidadeIdPais');
		
		html = '<option value>Selecione o País</option>';
		for(ind in paises)
		{
			html += "<option value='"+ind+"'>"+paises[ind].nome+"</option>";
		}
		
		element.html(html);
	}
	
	function getEst(id)
	{	
		var html = '';
		var element = $('#CidadeFilterCidadeIdEstado');
		var estados = paises[id].estados;
		
		html = '<option value>Selecione o Estado</option>';
		for(ind in estados)
		{
			html += "<option value='"+ind+"'>"+estados[ind].nome+"</option>";
		}
		
		element.html(html);
	}
</script>

<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{Cidade.nome_pt}',
			'sort' => 'Cidade.nome_pt'
		),
		__t('País') => array(
			'value' => '{Cidade.pais}'
		),
		__t('Estado') => array(
			'value' => '{Cidade.estado}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/cidade/edit/{Cidade.id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/cidade/delete/{Cidade.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover esta Cidade?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há cidades no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);
?>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Filter Options') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['Cidade']['filter']) ? '' : 'display:none;'; ?>">
		
			<?php echo $this->Form->input('Cidade.filter.Cidade|nome_pt LIKE',
					array(
						'type' => 'text',
						'label' => __t('Name'),
						'style' => 'height: 30px;'
					)
				);
			?>
			<?php echo $this->Form->input('Cidade.filter.Cidade|id_pais',
					array(
						'type' => 'select',
						'label' =>false,
						'id' => 'CidadeFilterCidadeIdPais',
						'options' => array('' => 'Selecione um País')
					)
				);
			?>
			<?php echo $this->Form->input('Cidade.filter.Cidade|id_estado',
					array(
						'type' => 'select',
						'label' =>false,
						'id' => 'CidadeFilterCidadeIdEstado',
						'options' => array('' => 'Selecione um Estado')
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Filter')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>