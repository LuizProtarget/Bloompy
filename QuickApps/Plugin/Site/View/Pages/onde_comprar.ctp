<section id="onde-comprar" class="onde-comprar page clearfix">
    <div class="header">
            <div class="icone-mobile" id="abre">
                <a href="javascript:void(0);">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 28 28" style="padding:5vw;" xml:space="preserve">
                    <style type="text/css">
                        .st0{fill-rule:evenodd;clip-rule:evenodd;fill:dodgerblue;}
                    </style>
                    <path class="st0" d="M0,0h28v4H0V0z"/>
                    <path class="st0" d="M7,12h14v4H7V12z"/>
                    <path class="st0" d="M0,24h28v4H0V24z"/>
                    </svg>
                </a>
            </div>
    </div>    
	<script>
	 	JOMOS.engine.findPageByHash('onde-encontrar').data.representantes = <?php echo $representantes; ?>;
        $('body').css({'background-image':"url(../blompy_site_2013/theme/Default/img/onde-encontrar.jpg)"});
	</script>
    <div class="clearfix">
        <h2><?php echo $translate['lojas'][0] ?></h2>
        <p style="margin: 0 0 10px 0;"><?php echo $translate['lojas'][1] ?></p>
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
            <h2><?php echo $translate['lojas'][2] ?></h2>
            <p>
                <?php echo $translate['lojas'][3] ?>
            </p>
            <select id="lojas_estado">
            	<option><?php echo $translate['lojas'][4] ?></option>
            	<?php 
            		foreach($dados['estados'] as $id =>$estado):
            		
            			echo '<option value="'.$id.'">'.$estado.'</option>';
            		
            		endforeach;
            	?>
            </select>
            <select id="lojas_cidade">
                <option><?php echo $translate['lojas'][5] ?></option>
            </select>
            <div class="listagem lojas"></div>
        </div>
        <div class="right clearfix">
            <h2><?php echo $translate['lojas'][6] ?></h2>
            <p>
                <?php echo $translate['lojas'][7] ?>
            </p>
            <select id="representantes_estado">
                <option><?php echo $translate['lojas'][8] ?></option>
            </select>
            <div class="listagem representantes"></div>
        </div>
    </div>
</section>
