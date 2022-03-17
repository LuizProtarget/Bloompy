<?php 
	echo $this->Layout->script('/system/js/ui/jquery.ui.core.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.widget.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.mouse.min.js');
	echo $this->Layout->script('/system/js/ui/jquery.ui.sortable.min.js');
?>

<script>
var action 					= new Array();
	action['position']	= "<?php echo $this->Html->url(array("plugin" => "site","controller" => "site",	"action" => "position")); ?>";
$(document).ready(function(){
		
		updatePosition();
});
	
function updatePosition()
{
	var positions = {'startPos':null,'endPos':null};
	$( "#sortable" ).sortable({
		opacity: 0.5,
		start	: function(event, ui) {
		positions.startPos = ui.item.index()+1;
	},
		update: function( event, ui ) {
			positions.endPos = ui.item.index()+1;
		
			$.ajax({
				url:action['position'],
				dataType:"json",
				type:"POST",
				data:'&data[LojaVirtual][id]='+ui.item.attr('id').replace('loja_','')+'&data[LojaVirtual][position]='+parseInt(ui.item.index()+1)+'&way='+(positions.startPos < positions.endPos ? 0 : 1),
				success:function(data){}
			});
		}
	});
	$( "#sortable" ).disableSelection();
}
</script>
<?php echo $this->Form->create(null, array('class' => 'form-inline')); ?>
	<!-- Filter -->
	<?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __t('Filter Options') . '</span>'); ?>
		<div class="fieldset-toggle-container" style="<?php echo isset($this->data['LojaVirtual']['filter']) ? '' : 'display:none;'; ?>">
			
			<?php echo $this->Form->submit(__t('Filter')); ?>
		</div>
	<?php echo $this->Html->useTag('fieldsetend'); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Html->useTag('fieldsetstart', __t('')); ?>
<?php if(count($results) > 0): ?>
<ul id="sortable" style="list-style:none;margin-top:5px;">
<?php 
	foreach($results as $ind => $result):
		
		echo "<li style='padding:5px;background: #e7e7e7;margin-bottom:5px' id='loja_".$result['LojaVirtual']['id']."' >".$this->Html->image('lojasvirtuais/thumb/'.$result['LojaVirtual']['filename'])."<span><a href='lojavirtual/edit/".$result['LojaVirtual']['id']."'>Editar</a> || <a href='lojavirtual/delete/".$result['LojaVirtual']['id']."'>Deletar</a></span></li>";
		
	endforeach; 
?>
</ul>
<?php else: ?>
	<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">×</button>Não há lojas virtuais no momento</div>
<?php endif; ?>
<?php echo $this->Html->useTag('fieldsetend'); ?>