<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{Pdv.name}'
		),
		__t('Arquivo') => array(
			'value' => "<a target='_blank' href='{url}/files/pdv/{Pdv.img}{/url}' > {Pdv.img}</a>"
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/site/site/pdv/{Pdv.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover este Arquivo?') . "'); \">" . __t('remover') . "</a>
				",
			'thOptions' => array('align' => 'right'),
			'tdOptions' => array('align' => 'right')
		),
	),
	'noItemsMessage' => __t('Não há tabelas no momento'),
	'paginate' => true,
	'headerPosition' => 'top',
	'tableOptions' => array('width' => '100%')
);
?>
<?php echo $this->Form->create('Pdv', array('url' => '/admin/site/site/pdv','class' => 'form-inline','type' => 'file')); ?>
	<!-- Form add -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Add Pdv') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="display:none;">
		
			<?php echo $this->Form->input('name',
					array(
						'type' => 'text',
						'label' => __t('Name')
					)
				);
			?>
			
			<?php echo $this->Form->input('img',
					array(
						'type' => 'file',
						'label' => __t('Foto')
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Add')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>