<?php
$assuntos = array(
    '' => 'Selecione',
    'Comercial / Vendas' => 'Comercial / Vendas',
    'SAC / Dúvidas' => 'SAC / Dúvidas',
    'Recursos Humanos' => 'Recursos Humanos',
    'Marketing' => 'Marketing'
);
?>
<div id="hlcontato" class="container">
 
    
        <div id="hlcontato_top">
            <h2>Contato</h2>
            <p>A Proshows aguarda suas dúvidas e sugestões!</p>
            <p>Entre em contato conosco pelo formulário de e-mail abaixo.</p>
           
                    <div id="sending" style="display: none;font-size:60%;margin-left: 123px;float:left">Enviando, aguarde...</div>
                    <div id="scss" style="font-size:40%;margin-left: 123px;float:left"></div>
        </div>
    
        <div id="hlcont_2" class="boxStyle">
            <div id="clp-ed">
                        <div id="hlcontato_left">
                                    <?php
                                    echo $this->Form->create(
                                            'Contatos.Contato', array(
                                        'url' => array(
                                            'plugin' => 'contatos',
                                            'controller' => 'list',
                                            'action' => 'add'
                                        ),
                                        'class' => 'customForm'
                                            )
                                    );
                                    ?>
                                    <?php
                                    $base_url = Router::url('/', true);
                                    $base_url = Configure::read('Variable.url_language_prefix') ? preg_replace('/\/[a-z]{3}\/$/s', '', $base_url) : $base_url;
                                    $base_url = preg_replace('/\/$/s', '', $base_url);
                                    ?>
                
                            <h2>queremos ouvir Voce!</h2>
                        	<?php echo $this->Html->useTag('fieldsetstart', __t('')); ?>
                            <?php echo $this->Form->input('Contato.name', array( 'label' => 'Nome')); ?>
                            <?php echo $this->Form->input('Contato.email', array( 'label' => 'E-mail')); ?>
                            <?php echo $this->Form->input('Contato.state', array( 'label' => 'Estado')); ?>
                            <?php echo $this->Form->input('Contato.city', array( 'label' => 'Cidade')); ?>
                            <div class="checkbox-contato">
                                <input type="checkbox" name="data[Contato][dpto][]" value="Lojista" />
                                <label id="lojis">Lojista</label>
                                <input type="checkbox" name="data[Contato][dpto][]" value="Consumidor" />
                                <label id="consumis">Consumidor</label>
                            </div>
                            <?php echo $this->Form->input('Contato.subject', array( 'label' => 'Assunto')); ?>
                            <?php  // echo $this->Form->input('Contato.upload', array('type' => 'file')); ?>
                            <?php echo $this->Form->input('Contato.body', array( 'label' => 'Mensagem')); ?>
                            <?php if ($sessionFlash = $this->Layout->sessionFlash('contato')): ?>
                            <div style="display: block; width: 330px;  float: right;margin: -14px 28px 0px 0px;"><?php print $sessionFlash; ?></div>
                            <?php endif; ?>
                            <?php echo $this->Form->end('Enviar'); ?>
                            <?php echo $this->Html->useTag('fieldsetend'); ?>
                            <div style="clear: both;"></div>
                            
                          
                        </div>
                        <div id="hlcontato_right">
                            <div class="redesS"></div>
                            <p><a href="">fb.com/ProShows</a></p>
                            <p><a href="">twitter.com/Proshows</a></p>
                            <p><a href="">flicker.com/Proshows</a></p>
                            <div class="localiza">
                                <a href="https://maps.google.com.br/maps?q=51+3034-8100++R.+Anchieta,+48+%2F+Kurashiki++Sapucaia+do+Sul+-+RS&hl=pt&ll=-29.814974,-51.166077&spn=0.013014,0.026157&sll=-30.416657,-53.667865&sspn=13.227703,26.784668&t=h&hnear=R.+Anchieta,+48+-+Kurashiki,+Sapucaia+do+Sul+-+Rio+Grande+do+Sul,+93212-730&z=16" target="blank"></a>
                            </div>
                            <p>51 3034-8100</p>
                            <p>R. Anchieta, 48 / Kurashiki</p>
                            <p>Sapucaia do Sul - RS</p>
                        </div>
            </div> 
            <div class="sombra"></div>
            
      
        </div>
    
</div>
