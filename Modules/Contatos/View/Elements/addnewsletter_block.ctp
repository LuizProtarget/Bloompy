<div class="newsletter form">
    <?php echo $this->Form->create('Newsletter', array('url' => '/newsletter/list/add'));?>
        <fieldset>
        <?php
            echo $this->Form->input('name', array('label' => __t('Nome')));
            echo $this->Form->input('email', array('label' => __t('Email')));
        ?>
        </fieldset>
    <?php echo $this->Form->end(__t('Cadastrar'));?>
</div>