<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{Estado.nome_pt}',
			'sort' => 'Estado.nome_pt'
		),
		__t('País') => array(
			'value' => '{Estado.pais}'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/estado/edit/{Estado.id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/estado/delete/{Estado.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover este Estado?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há estados no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);
?>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Filter Options') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['Estado']['filter']) ? '' : 'display:none;'; ?>">
		
			<?php echo $this->Form->input('Estado.filter.Estado|nome_pt LIKE',
					array(
						'type' => 'text',
						'label' => __t('Name')
					)
				);
			?>
			<?php echo $this->Form->input('Estado.filter.Estado|id_pais',
					array(
						'type' => 'select',
						'label' =>false,
						'options' => array('' => 'Selecione um País')+$paises
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Filter')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>