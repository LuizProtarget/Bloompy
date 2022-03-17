<?php 
$assuntos = array(
        '' => 'Selecione',
        'Onde Encontrar' => 'Onde Encontrar',
        'Elogios' => 'Elogios',
        'Reclamações' => 'Reclamações',
        'Dúvidas/Sugestões/Outros' => 'Dúvidas/Sugestões/Outros',
        'Logista/Representante' => 'Logista/Representante'
);
?>
<?php echo $this->Form->create('Contatos.Contato'); ?>
    <?php echo $this->Html->useTag('fieldsetstart', __t('Editando Contato')); ?>
        <?php 
            $base_url = Router::url('/', true);
            $base_url = Configure::read('Variable.url_language_prefix') ? preg_replace('/\/[a-z]{3}\/$/s', '', $base_url) : $base_url;
            $base_url = preg_replace('/\/$/s', '', $base_url);
        ?>

        <?php echo $this->Form->input('Contato.id'); ?>
        <?php echo $this->Form->input(
                'Contato.subject',
                array('options'=>$assuntos, 'label' => __t('Assunto'))); ?>
        <?php echo $this->Form->input('Contato.name', array('type' => 'text', 'label' => __t('Nome'))); ?>
        <?php echo $this->Form->input('Contato.city', array('type' => 'text', 'label' => __t('Cidade'))); ?>
        <?php echo $this->Form->input('Contato.state', array('type' => 'text', 'label' => __t('Estado'))); ?>
        <?php echo $this->Form->input('Contato.born', array('type' => 'text', 'label' => __t('Nascimento'))); ?>
        <?php echo $this->Form->input('Contato.email', array('type' => 'text', 'label' => __t('Email'))); ?>
        <?php echo $this->Form->input('Contato.subject', array('type' => 'text', 'label' => __t('Assunto'))); ?>
        <?php echo $this->Form->input('Contato.body', array('label' => __t('Corpo'))); ?>
        <?php echo $this->Form->input('Contato.status', array('type' => 'checkbox', 'label' => __t('Active'))); ?>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <?php echo $this->Form->input(__t('Salvar newsletter'), array('type' => 'submit')); ?>
<?php echo $this->Form->end(); ?>