<?php
	
$tSettings = array(
	'columns' => array(
		__t('Nome') => array(
			'value' => '{TabelaPreco.name}'
		),
		__t('Arquivo') => array(
			'value' => "<a target='_blank' href='{url}/files/tabelaprecos/{TabelaPreco.file}{/url}' > {TabelaPreco.file}</a>"
		),
		__t('Ações') => array(
			'value' => "
				<a href='{url}/admin/site/site/table/{TabelaPreco.id}{/url}' onclick=\"return confirm('" . __t('Deseja remover este Arquivo?') . "'); \">" . __t('remover') . "</a>
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
<?php echo $this->Form->create('TabelaPreco', array('url' => '/admin/site/site/table','class' => 'form-inline','type' => 'file')); ?>
	<!-- Form add -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Add Tabela') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="display:none;">
		
			<?php echo $this->Form->input('name',
					array(
						'type' => 'text',
						'label' => __t('Name')
					)
				);
			?>
			
			<?php echo $this->Form->input('file',
					array(
						'type' => 'file',
						'label' => __t('Arquivo')
					)
				);
			?>
			<?php echo $this->Form->submit(__t('Add')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->table($results, $tSettings); ?>