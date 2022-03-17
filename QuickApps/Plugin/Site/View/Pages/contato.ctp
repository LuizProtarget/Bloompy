<section id="contato" class="contato page clearfix">
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
    <div class="contato-fale" style="padding: 90px 0 0 0;">
        <h2>
            <?php echo $translate['contato'][0] ?>
        </h2>
        <p>
            <?php echo $translate['contato'][1] ?>
        </p>
        <form action="contato/site/add" method="post">
            <input type="hidden" name="ajax"  value="1"/>
			<input type="text" name="name" required placeholder="<?php echo $translate['contato'][2] ?>" value=""/>
            <input type="text" name="email" required placeholder="<?php echo $translate['contato'][3] ?>" value=""/>
            <input type="text" name="fone" placeholder="<?php echo $translate['contato'][4] ?>" value=""/>
            <input type="text" name="state" placeholder="<?php echo $translate['contato'][5] ?>" value=""/>
            <input type="text" name="city" placeholder="<?php echo $translate['contato'][6] ?>" value=""/>
            <input type="text" name="subject" required placeholder="<?php echo $translate['contato'][7] ?>" value=""/>
            <textarea name="body" placeholder="<?php echo $translate['contato'][8] ?>" required style="margin: 2px 0 0 2px;"></textarea>
			<span class="message" styel="display:none;"></span>
            <button type="submit"><?php echo $translate['contato'][9] ?> ></button>
        </form>
        <div class="map">
            <!-- <div class="map1"></div> -->

            <iframe style="margin-top: 12px;" width="235" height="175" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m17!1m11!1m3!1d1488.6994129788295!2d-50.79228112699589!3d-29.33384932728009!2m2!1f0!2f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe6226855ef8ad67!2sCal%C3%A7ados+Bloompy!5e1!3m2!1spt-BR!2sus!4v1500984293066"></iframe>
            <p class="contato-end">
                <strong>BLOOMPY, CALÇADOS HOFFLLES LTDA</strong><br/>
                (54) 3282-4046<br/>
                Rua dos Metais, 398, Distrito Industrial, Canela / RS - Brasil
            </p>
        </div>
    </div>
</section>
