<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{Pais.nome_pt}',
			'sort' => 'Pais.nome_pt'
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/pais/edit/{Pais.id}{/url}'>" . __t('editar') . "</a> |
				<a href='{url}/admin/pais/delete/{Pais.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover este Pais?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há países no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);
?>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Filter Options') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['Pais']['filter']) ? '' : 'display:none;'; ?>">
		
			<?php echo $this->Form->input('Pais.filter.Pais|nome_pt LIKE',
					array(
						'type' => 'text',
						'label' => __t('Name')
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Filter')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>