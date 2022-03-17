<section class="page home clearfix">
	<div class="pokeball">
		<div class="header">
			<div class="icone-mobile" id="abre">
				<a href="javscript:void(0);">
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
		<div class="titulos">
		<?php //print_r($translate); ?>
			<h2><?php echo $translate['home'][0] ?></h2>
			<h3><?php echo $translate['home'][1] ?>/<?php echo $translate['home'][2] ?> 2021</i></h3>
		</div>
		<div class="BannerHome">
			<div class="position">
				<div id="owl-example" class="owl-carousel">
			<div class="item">
				<a href="#/colecao/menina/outono_inverno_2021">
					<?php echo $this->Html->image('banner/OutonoInverno2021/3520-02.png', array('title'=>'Ref: 3520-02', 'alt'=>'Ref: 3520-02')); ?>
				</a>
			</div>
				<div class="item">
				<a href="#/colecao/menino/outono_inverno_2021">
					<?php echo $this->Html->image('banner/OutonoInverno2021/3711-01.png', array('title'=>'Ref: 3711-01', 'alt'=>'Ref: 3711-01')); ?>
				</a>
			</div>
			<div class="item">
				<a href="#/colecao/menino/outono_inverno_2021">
					<?php echo $this->Html->image('banner/OutonoInverno2021/5033-04.png', array('title'=>'Ref: 5033-04', 'alt'=>'Ref: 5033-04')); ?>
				</a>
			</div>
			<div class="item">
				<a href="#/colecao/menina/outono_inverno_2021">
					<?php echo $this->Html->image('banner/OutonoInverno2021/8111-01.png', array('title'=>'Ref: 8111-01', 'alt'=>'Ref: 8111-01')); ?>
				</a>
			</div>
			
				</div>
			</div>
		</div>
	</div>
	
</section>
