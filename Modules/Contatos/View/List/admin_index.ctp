<?php
$tSettings = array(
    'columns' => array(
        '<input type="checkbox" onclick="QuickApps.checkAll(this);">' => array(
            'value' => '<input type="checkbox" name="data[Contato][id][]" value="{Contato.id}">',
            'thOptions' => array('align' => 'center'),
            'tdOptions' => array('width' => '25', 'align' => 'center')
        ),
        __t('Nome') => array(
            'value' => '<a href="{url}/admin/contatos/list/edit/{Contato.id}{/url}">{Contato.name}</a>',
            'sort' => 'Contato.name',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __t('Email') => array(
            'value' => '{Contato.email}',
            'sort'    => 'Contato.email',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __t('Data de Nascimento') => array(
            'value' => '{php} return (date("d/m/Y",{Contato.birthday})); {/php}',
            'sort'    => 'Contato.birthday',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __t('Estado') => array(
            'value' => '{Contato.state}',
            'sort'    => 'Contato.state',
            'tdOptions' => array('width' => '10%', 'align' => 'left')
        ),
        __t('Cidade') => array(
            'value' => '{Contato.city}',
            'sort'    => 'Contato.city',
            'tdOptions' => array('width' => '15%', 'align' => 'left')
        ),
        __t('Criado') => array(
            'value' => '{php} return (date("d/m/Y H:i",{Contato.created})); {/php}',
            'sort'    => 'Contato.created',
            'tdOptions' => array('width' => '10%', 'align' => 'left')
        ),
        __t('Status') => array(
            'value' => '{php} return ("{Contato.status}" == 0 ? "' . __t('inativo') . '" : "' . __t('active') . '" ); {/php}',
            'sort'    => 'Contato.status'
        )
    ),
    'noItemsMessage' => __t('Sem cadastros de Contatos'),
    'paginate' => true,
    'headerPosition' => 'top',
    'tableOptions' => array('width' => '100%') # table attributes
);
?>

<?php echo $this->Form->create(null, array('onsubmit' => 'return confirm("' . __t('Are you sure about this changes ?') . '");')); ?>
    <!-- Update -->
    <?php echo $this->Html->useTag('fieldsetstart', '<span id="toggle-update_fieldset" style="cursor:pointer;">' . __t('Update Options') . '</span>' ); ?>
        <div id="update_fieldset" class="horizontalLayout" style="<?php echo isset($this->data['Contato']['update']) ? '' : 'display:none;'; ?>">
            <?php echo $this->Form->input('Contato.update',
                    array(
                        'type' => 'select',
                        'label' => false,
                        'options' => array(
                            'delete' => __t('Apagar contatos selecionada'),
                            'enable' => __t('Ativar contatos selecionados'),
                            'disable' => __t('Desativar contatos selecionados')
                        )
                    )
                );
            ?>
            <?php echo $this->Form->input(__t('Update'), array('type' => 'submit', 'label' => false)); ?>
        </div>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <!-- table results -->
    <?php echo $this->Html->table($results, $tSettings); ?>
    <!-- end: table results -->
<?php echo $this->Form->end(); ?>

<script type="text/javascript">
    $("#toggle-update_fieldset").click(function () {
        $("#update_fieldset").toggle('fast', 'linear');
    });
</script>