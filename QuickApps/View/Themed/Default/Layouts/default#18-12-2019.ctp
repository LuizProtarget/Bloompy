<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->Layout->title(); ?></title>
		<?php echo $this->Layout->meta(); ?>
		<?php 
			echo $this->Html->css('main.css?c=' . time()); 
			echo $this->Html->css('font-awesome/css/font-awesome.min.css?c=' . time()); 
			echo $this->Html->css('owl-carousel/owl.carousel.css');
			echo $this->Html->css('owl-carousel/owl.theme.css');
			echo $this->Html->css('flags/flags.css');

		?>

		<?php echo $this->Layout->header(); ?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-81431897-1', 'auto');
		  ga('send', 'pageview');

		</script>

		<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window,document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		 fbq('init', '181736902569961'); 
		fbq('track', 'PageView');
		</script>
		<noscript>
			 <img height="1" width="1" 
			src="https://www.facebook.com/tr?id=181736902569961&ev=PageView
			&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
	</head>
	<body>
		<aside class="menu-bloompy-mobile" id="menu-mobile">
			<a href="javascript:void(0);"><i class="fa fa-times fecha close-menu" id="fecha"></i></a>
			<div id="logo"><a href="#/home"></a></div>

			<nav>	
				<ul>
					<li><a href="#/empresa">
							<span><?php echo $translate['menu'][0] ?></span>
						</a>
					</li>
					<li class="Menucolecao">
						<!-- <a href="#/colecao/primavera_verao_2017"> -->
						<!-- <a href="#/colecao/outono_inverno_2018"> -->
						<a class="menu-col-button" href="javascript:void(0);">
							<span><?php echo $translate['menu'][1] ?></span>
						</a>
						<!-- <ul> 
							<?php if(isset($colecao)): ?>
								<?php foreach($colecao as $value): ?>
									<li><a href="#/colecao/<?php echo $value['slug']; ?>"><?php echo $value['name']; ?></a></li>
								<?php endforeach;?>
							<?php endif; ?>
						</ul> -->
						<ul class="sub-menu-col"> 
							<li>
								<a class="subcolecao-button" href="#/colecao/menino/primavera_verao_2019_ii">
									<span><?php echo $translate['menu'][5]; ?></span>
								</a>
							</li>
							<li>
								<a class="subcolecao-button" href="#/colecao/menina/primavera_verao_2019_ii">
									<span><?php echo $translate['menu'][6]; ?></span>
								</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#/conforto">
							<span><?php echo $translate['menu'][2] ?></span>
						</a>
					</li>
					<li>
						<a href="#/onde-encontrar">
							<span><?php echo $translate['menu'][3] ?></span>
						</a>
					</li>
					<li>
						<a href="#/contato">
							<span><?php echo $translate['menu'][4] ?></span>
						</a>
					</li>
				</ul>
			</nav>

			<div class="newsletter">
				<h2>Newsletter</h2>
				<form method="post" action="newsletter/add">
					<input type="email" name="email" placeholder="<?php echo $translate['newsletter'][0] ?>" required />
					<button type="submit">></button>
				</form>

			</div>
			<div class="social-list">
				<a class="action" href="https://www.facebook.com/bloompyoficial/" target="_blank">
					<i class="fa fa-facebook"></i>
				</a>
				<a class="action" href="https://www.instagram.com/bloompyoficial/" target="_blank">
					<i class="fa fa-instagram"></i>
				</a>
			</div>

			<div class="social-list">
				<a class="language" href="?lang=pt">PT <span class="flag flag-br"> </a></span>
				<a class="language" href="?lang=en">EN <span class="flag flag-us"></a></span>
				<a class="language" href="?lang=es">ES <span class="flag flag-es"></a></span>
			</div>

			<div class="legal" style="color: #fff;text-align: center;padding-top: 20px;">
				© Copyright Calçados Hofflles Ltda. Todos os direitos reservados
			</div>

		</aside>

		<div class="pageMobile" id="pageContainer"></div>

		<footer>

		</footer>
		<?php echo $this->Html->script('vendor/jquery-1.9.1.min.js'); ?>
		<?php echo $this->Html->script('plugins.js'); ?>
		<?php echo $this->Html->script('main.js'); ?>
	</body>
	
</html>
