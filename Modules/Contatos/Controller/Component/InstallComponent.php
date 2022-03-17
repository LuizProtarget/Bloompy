<?php
class InstallComponent extends Component {
    public $table = 'contatos';
    public function beforeInstall() {
        $dSource = $this->Installer->Controller->Module->getDataSource();
        $query = "
            CREATE TABLE IF NOT EXISTS `{$dSource->config['prefix']}{$this->table}` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `dpto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `body` text COLLATE utf8_unicode_ci DEFAULT NULL,
              `status` tinyint(1) NOT NULL,
              `created` datetime NOT NULL,
              `created_by` int(11) NOT NULL,
              `modified` datetime NOT NULL,
              `modified_by` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";        

        $this->Installer->menuLink(array(
            'title' => ucfirst($this->table),
            'url' => "/admin/{$this->table}/list"
        ), 1, 1);

        return $dSource->execute($query);
    }

    public function beforeUninstall() {
        return true;
    }

    public function afterUninstall() {
        $dSource = $this->Installer->Controller->Module->getDataSource();
        return $dSource->execute("DROP TABLE `{$dSource->config['prefix']}{$this->table}`;");
    }
}