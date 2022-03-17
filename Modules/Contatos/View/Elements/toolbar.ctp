<?php
    $links = array(
        array(__t('Listar'), '/admin/contatos/list/index'),
        array(__t('Add'), '/admin/contatos/list/add')
    );
    echo $this->Menu->toolbar($links);