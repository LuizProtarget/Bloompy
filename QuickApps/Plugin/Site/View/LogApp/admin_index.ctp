<?php
	
$tSettings = array(
	'columns' => array(
		__t('Acesso') => array(
			'value' => '{LogApp.dataCreated}',
			'sort' => 'LogApp.dataCreated'
		),
		__t('Nome de Usuário') => array(
			'value' => '{LogApp.username}',
			'sort' => 'LogApp.username'
		),
		__t('Device') => array(
			'value' => '{LogApp.device}'
		),
		__t('Localizar') => array(
			'value' => '{LogApp.geo}',
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		)
	),
	'noItemsMessage' => __t('Não há estados no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);
?>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Opções de Filtro') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['LogApp']['filter']) ? '' : 'display:none;'; ?>">
		
			<?php echo $this->Form->input('LogApp.filter.LogApp|username LIKE',
					array(
						'type' => 'text',
						'label' => __t('Nome de Usuário')
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Filter')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>