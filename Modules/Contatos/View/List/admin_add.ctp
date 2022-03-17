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
    <?php echo $this->Html->useTag('fieldsetstart', __t('Adicione novo cadastro de contato')); ?>
        <?php 
            $base_url = Router::url('/', true);
            $base_url = Configure::read('Variable.url_language_prefix') ? preg_replace('/\/[a-z]{3}\/$/s', '', $base_url) : $base_url;
            $base_url = preg_replace('/\/$/s', '', $base_url);
        ?>
        <?php echo $this->Form->input(
                'Contato.subject',
                array('options'=>$assuntos, 'label' => __t('Assunto'))); ?>
        <?php echo $this->Form->input('Contato.name', array('type' => 'text', 'label' => __t('Nome'))); ?>
		 <?php echo $this->Form->input('Contato.birthday', array('type' => 'date','after' => '<em >ex.: dia/mês/ano - 07/07/1992</em>', 'dateFormat' => 'DMY','minYear' => date('Y') - 50,'maxYear' => date('Y') - 18)); ?>
		 
        <?php echo $this->Form->input('Contato.state', array('type' => 'text', 'label' => __t('Estado'))); ?>
        <?php echo $this->Form->input('Contato.city', array('type' => 'text', 'label' => __t('Cidade'))); ?>
        <?php echo $this->Form->input('Contato.email', array('type' => 'text', 'label' => __t('Email'))); ?>
        <?php echo $this->Form->input('Contato.body', array('label' => __t('Mensagem'))); ?>
        <?php echo $this->Form->input('Contato.status', array('type' => 'checkbox', 'label' => __t('Active'))); ?>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <?php echo $this->Form->input(__t('Save'), array('type' => 'submit')); ?>
<?php echo $this->Form->end(); ?>