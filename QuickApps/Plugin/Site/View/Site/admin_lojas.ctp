<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{Loja.name}'
		),
		__t('País') => array(
			'value' => '{Loja.pais}'
		),
		__t('Estado') => array(
			'value' => '{Loja.estado}'
		),
		__t('Cidade') => array(
			'value' => '{Loja.cidade}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/loja/edit/{Loja.id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/loja/delete/{Loja.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover esta Loja?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há lojas no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);
?>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Filter Options') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['Loja']['filter']) ? '' : 'display:none;'; ?>">
		
			<?php echo $this->Form->input('Loja.filter.Loja|name LIKE',
					array(
						'type' => 'text',
						'label' => __t('Name')
					)
				);
			?>
			
			<?php echo $this->Form->input('Loja.filter.Loja|id_pais LIKE',
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
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>