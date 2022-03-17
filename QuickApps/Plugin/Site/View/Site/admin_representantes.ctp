<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{Representante.name}'
		),
		__t('Estado') => array(
			'value' => '{Representante.estado}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/representante/edit/{Representante.id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/representante/delete/{Representante.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover este Representante?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há representantes no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);

?>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Filter Options') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['Representante']['filter']) ? '' : 'display:none;'; ?>">
		
			<?php echo $this->Form->input('Representante.filter.Representante|name LIKE',
					array(
						'type' => 'text',
						'label' => __t('Name')
					)
				);
			?>
			
			<?php echo $this->Form->input('Representante.filter.Representante|id_pais LIKE',
					array(
						'type' => 'select',
						'label' => __t('País'),
						'options' => array('' => 'Selecione')+$paises
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Filter')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end();

echo $this->Html->table($results, $tSettings);

?>