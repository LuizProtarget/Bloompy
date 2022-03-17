<section class="page conforto clearfix">
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
	<?php $language = $this->Session->read('laguange'); ?>
	<div class="promo <?php echo $language; ?>">
		<div class="textBlock one">
		    <h2><?php echo $translate['conforto'][0] ?></h2>
		    <p>
		       <?php echo $translate['conforto'][1] ?>
		    </p>
		    <div class="confort-mobile-img">
		    	<?php echo $this->Html->image('../img/img-1.png'); ?>
		    </div>	
		</div>
		<div class="textBlock two">
			<h2><?php echo $translate['conforto'][2] ?></h2>
		    <p>
		       <?php echo $translate['conforto'][3] ?>
		    </p>
		    <div class="confort-mobile-img-two">
		    	<?php echo $this->Html->image('../img/img-2.png'); ?>
		    </div>
		</div>
	</div>

</section>
