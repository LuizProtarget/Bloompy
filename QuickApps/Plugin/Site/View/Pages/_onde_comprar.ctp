<section id="onde-comprar" class="onde-comprar page clearfix">
	<script>
	 	JOMOS.engine.findPageByHash('onde-encontrar').data.representantes = <?php echo $representantes; ?>;
        $('body').css({'background-image':"url(../blompy_site_2013/theme/Default/img/onde-encontrar.jpg)"});
	</script>
    <div class="clearfix">
        <h2>Compre Online</h2>
        <p style="margin: 0 0 10px 0;">Selecione abaixo uma loja virtual e compre seu Bloompy online:</p>
        <ul>
        	<?php foreach($linkslj as $dado): ?>
            <li>
				<a href="<?php echo $dado['LojaVirtual']['link']; ?>" target="_blank">
                <?php echo $this->Html->image('lojasvirtuais/thumb/'.$dado['LojaVirtual']['filename'], array('id' => 'img-links')); ?>
				</a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="left clearfix">
            <h2>Lojas no Brasil</h2>
            <p>
                Selecione o estado e a cidade abaixo para<br/>
                visualizar as lojas que você encontra Bloompy:
            </p>
            <select id="lojas_estado">
            	<option>estado</option>
            	<?php 
            		foreach($dados['estados'] as $id =>$estado):
            		
            			echo '<option value="'.$id.'">'.$estado.'</option>';
            		
            		endforeach;
            	?>
            </select>
            <select id="lojas_cidade">
                <option>cidade</option>
            </select>
            <div class="listagem lojas"></div>
        </div>
        <div class="right clearfix">
            <h2>Representantes</h2>
            <p>
                Selecione o estado abaixo e encontre o
                representante Bloompy no seu estado.
            </p>
            <select id="representantes_estado">
                <option><?php echo __t('estado'); ?></option>
            </select>
            <div class="listagem representantes"></div>
        </div>
    </div>
</section>
