<?php echo $this->Html->useTag('fieldsetstart', __t('contatos', 'Contatos')); ?>
    <?php echo $this->Form->input('Module.settings.emailaviso_key',array('type'=>'checkbox','label'=>__t('Enviar email de aviso?'))); ?>
    <?php echo $this->Form->input('Module.settings.recebedor_key',array('label'=>'Recebedor da mensagem:')); ?>
<?php echo $this->Html->useTag('fieldsetend'); ?>