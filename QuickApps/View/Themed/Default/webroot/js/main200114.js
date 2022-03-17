JOMOS.app = {
	version:'0.1',
	title:'Bloompy',
	baseURL:'',
	defaultHash:'#/home',
	currentPage:null,
	currentHash:null,
	pages:[
		{
			hash:'home',
			type:'ajax',
			config:{
				url:'pages/home.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			ownPronto:false,
			onInitialize:function(){

				$('footer').show();

				if(!this.ownPronto){
					this.ownPronto = $(this.domElement).find("#owl-example").html();
				} else {
					$(this.domElement).find("#owl-example").html(this.ownPronto);
				}

				$(this.domElement).find("#owl-example").owlCarousel({
			        autoPlay: 3000, //Set AutoPlay to 3 seconds
			 
			      items : 1,
			      itemsDesktop : [1199,3],
			      itemsDesktopSmall : [979,3],
			        responsive: false,
			        navigation: true,
			        navigationText : true,
			        pagination: true
			    });

			       $(this.domElement).find('.toy_one').parallax(

			            {mouseport: this.domElement}, {xparallax: '1px',    yparallax: '20px'}, {}
			        );
			        $(this.domElement).find('.toy_two').parallax(

			            {mouseport: this.domElement}, {xparallax: '25px',    yparallax: '25px'}, {}
			        );
			        $(this.domElement).find('.toy_three').parallax(

			            {mouseport: this.domElement}, {xparallax: '30px',    yparallax: '1px'}, {}
			        );
			        $(this.domElement).find('.park').parallax(

			            {mouseport: this.domElement}, {xparallax: '7px',    yparallax: '7px'}, {}
			        );
			        
    			$(JOMOS.app.currentPage.domElement).mouseenter();

				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').delay(350).animate({opacity:1},350,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
				
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:0},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
				
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},
		{
			hash:'empresa',
			type:'ajax',
			config:{
				url:'pages/empresa.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').show();
				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},
		{
			hash:'colecao',
			type:'ajax',
			config:{
				url:'pages/colecao.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').hide();
				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){
				$(this.domElement).find('.ListagemProdutos ul').html('');
				$(this.domElement).find('.box3').remove();
				if(h.length == 1 || (h.length > 1 && h[1] == '')){
					document.location.hash = '#/colecao/baby';
				} else {
					var colecaoData = this.data.colecoes[h[1]];
					$('nav').find('.Menucolecao li').removeClass('selected').find('a[href="#/colecao/'+h[1]+'"]').parent().addClass('selected');
					$(this.domElement).find('.box1 ul li').removeClass('selected');
					
					if(typeof colecaoData != 'undefined' && typeof colecaoData.categorias != 'undefined'){
						$(this.domElement).find('ul.ListagemProdutos').html('');
						
						var lookFor=false;
						if(h.length == 3 && h[2] != '' && h[2] != 'linha') {
							lookFor = true; 
						} else {

							$(this.domElement).find('.modalProduto').hide(200);
							$(this.domElement).find('.dark').fadeOut(100);
							$('html').css({'overflowY':'auto'});
						}
	
						var linhasHTML = '';
						var href = '';
						for(var y in colecaoData.categorias){
							var catData = colecaoData.categorias[y];
							var currentCat = y;
							
							if(h[2] == 'linha'){
								if(h[3] != y) {
									linhasHTML += '<li><a href="#/colecao/'+h[1]+'/linha/'+y+'">'+catData.name+'</a></li>';
									continue;
								} else linhasHTML += '<li class="selected"><a href="#/colecao/'+h[1]+'/linha/'+y+'">'+catData.name+'</a></li>';	
							} else
								linhasHTML += '<li><a href="#/colecao/'+h[1]+'/linha/'+y+'">'+catData.name+'</a></li>';
							
							for(var x in catData.produtos){
								var row = catData.produtos[x];
								console.log(row);
								
								if(lookFor!=''){
									var asideHTML = '';
									for(var y in row.skus){
										var sku = row.skus[y];
										
										if(sku.ref == h[2]){
											href = '#/colecao/'+h[1]+'/linha/'+currentCat;
											$(this.domElement).find('.modalProduto>a').attr('href',href);
											$(this.domElement).find('.dark').fadeIn(200);
											$(this.domElement).find('.modalProduto').css('display','block').find('.pdtleft p').html('Ref: '+h[2]);
											$(this.domElement).find('.modalProduto').find('.ibagemtop img').attr('src',''+sku.img);
											$('html').css({'overflowY':'hidden'});

											for(var k in row.skus){
												var otherSku = row.skus[k];
												if(sku.ref != otherSku.ref)
													asideHTML += '<li><a href="#/colecao/'+h[1]+'/'+otherSku.ref+'"><img src="'+otherSku.thumb+'"/></a></li>';
											}
											$(this.domElement).find('.asideAnother ul').html(asideHTML);
										} 
										
									}
								}
								$(this.domElement).find('ul.ListagemProdutos').append('<li> <a href="#/colecao/'+h[1]+'/'+row.skus[0].ref+'"><img src="'+row.skus[0].thumb+'"/> </a> </li>');	
							}
							
						}
						
						$(this.domElement).find('.box1 ul').html(linhasHTML);
						
						if(h[2] == 'linha'){
							$(this.domElement).find('.box1 ul li a[href="#/colecao/linha/'+h[3]+'"]').parent().addClass('selected');	
						}
					}
					
					
				}
			}
		},
		{
			hash:'produto',
			type:'ajax',
			config:{
				url:'pages/produtos.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').show();
				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},
		{
			hash:'conforto',
			type:'ajax',
			config:{
				url:'pages/conforto.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').show();
				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},
		{
			hash:'diversao',
			type:'ajax',
			config:{
				url:'pages/diversao.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').show();
				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},
		{
			hash:'onde-encontrar',
			type:'ajax',
			config:{
				url:'pages/onde-encontrar.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').show();
				var that = this;
				
				$(this.domElement).css('min-height',(JOMOS.window.height-130)+'px');
				
				$(this.domElement).find('select').change(function(){
					var id = $(this).attr('id');
					var val = $(this).val();
					var changedElement = this;
					if(id == 'lojas_estado'){
						JOMOS.engine.setLoading(true);
						$(that.domElement).find('select#lojas_cidade').html('<option>Carregando...</option>');
						if(parseInt(val)){
							$.ajax({
								url: 'site/ajax',
								type: 'POST',
								async:true,
								data:{type:'cidades','id_estado':val},
								dataType: 'json'
							}).complete(function(data,code){
								JOMOS.engine.setLoading(false);
								
								if(data.responseText.charAt(0) != '{' && data.responseText.charAt(0) != '[') {
									$(changedElement).change();
									return;
								}
								
								$(that.domElement).find('.listagem.lojas').html('');
								$(that.domElement).find('select#lojas_cidade').html('<option>cidade</option>');
								var cidades = $.parseJSON(data.responseText);
								var toSort = [];
								var cidadesHTML = '';
								for(var x in cidades){
									toSort.push({id:x,name:cidades[x]});
									//cidadesHTML += '<option value="'+x+'">'+cidades[x]+'</option>';
								}
								
								function compare(a,b) {
								  if (a.name < b.name)
									 return -1;
								  if (a.name > b.name)
									return 1;
								  return 0;
								}
	
								toSort.sort(compare);
								
								for(var x = 0;x<toSort.length;x++){
									cidadesHTML += '<option value="'+toSort[x].id+'">'+toSort[x].name+'</option>';
								}
								console.log(cidadesHTML);
								$(that.domElement).find('select#lojas_cidade').append(cidadesHTML);
								
							});
						}else{
							$(that.domElement).find('select#lojas_cidade').html('<option>cidade</option>');
							$(that.domElement).find('.listagem.lojas').html('');
						}
					} else if(id == 'lojas_cidade'){
						$(that.domElement).find('.listagem.lojas').html('Carregando...');
						if(parseInt(val)){
							$.ajax({
								url: 'site/ajax',
								type: 'POST',
								async:true,
								data:{type:'lojas','id_cidade':val},
								dataType: 'json'
							}).complete(function(data,code){
								JOMOS.engine.setLoading(false);
								if(data.responseText.charAt(0) != '{' && data.responseText.charAt(0) != '[') {
									$(changedElement).change();
									return;
								}
								
								$(that.domElement).find('.listagem.lojas').html('');
								var lojas = $.parseJSON(data.responseText);
								var lojasHTML = '';
								for(var x in lojas){
									var row = lojas[x];
									row.desc = row.desc.replace('Telefone:','<br/>Telefone:');
									lojasHTML += '<h5>'+row.name+'</h5><p>'+row.desc+'</p>';
								}
								$(that.domElement).find('.listagem.lojas').html(lojasHTML);
								//$(that.domElement).find('select#lojas_cidade').append(cidadesHTML);
								
							});
						}else{
							$(that.domElement).find('.listagem.lojas').html('');
						}
					}else if(id == 'representantes_estado'){
						$(that.domElement).find('.listagem.representantes').html('');
						if(parseInt(val)){
							for(var x in JOMOS.app.currentPage.data.representantes[val].representantes){
								var row = JOMOS.app.currentPage.data.representantes[val].representantes[x];	
								$(that.domElement).find('.listagem.representantes').append('<h5>'+row.nome+'</h5><p>'+row.desc.replace(/\n/g,'<br/>')+'</p>');
							}
						}
					}
						
				});
				
				
				for(var x in JOMOS.app.currentPage.data.representantes){
					$(this.domElement).find('#representantes_estado').append('<option value="'+x+'">'+JOMOS.app.currentPage.data.representantes[x].name+'</option>');
				}
				$(JOMOS.engine).trigger('initialize_completed');	
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},
		{
			hash:'contato',
			type:'ajax',
			config:{
				url:'pages/contato.html',
				keepalive:false,
				additionalAjaxSettings:null,
				containerSelector:'#pageContainer'
			},
			data:{
				
			},
			onInitialize:function(){
				$('footer').show();
				$(JOMOS.engine).trigger('initialize_completed');
			},
			onTransitionIn:function(){
				$(this.domElement).css('opacity','0').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionin_completed');
				});
			},
			onTransitionOut:function(){
				$(this.domElement).css('opacity','1').animate({opacity:1},300,function(){
					$(JOMOS.engine).trigger('trasitionout_completed');
				});
			},
			onHashChange:function(h){JOMOS.engine.defaultPageOnHashChange(h)}
		},

	],
	functions:{
		
		
		
	},
	events:{
		onLoad:function(){
		
		},
		onReady:function(){
			$('aside .newsletter form').each(function(i,el){
				
			}).submit(function(){
				var emailElement = $(this).find('input[name="email"]').eq(0);
				var form = this;
				if(!$(emailElement).val()){
					alert('Por favor, digite um e-mail válido para receber nossa newsletter.');
				} else {
					JOMOS.engine.setLoading(true);
					$.ajax({
						url: $(this).attr('action'),
						type: 'POST',
						async:false,
						data:$(this).serialize(),
						dataType: 'json'
					}).complete(function(data,code){
						JOMOS.engine.setLoading(false);
						$(form).get(0).reset()
						alert('Seu e-mail foi cadastrado com sucesso na nossa Newsletter. Obrigado!');
					});
	
					
				}
				
				return false;
			});
		}	
	}
}


$(window).load(function(){
	JOMOS.window.isLoaded = true;
	if(typeof JOMOS.app.events.onLoad == 'function') JOMOS.app.events.onLoad();
});

$(document).ready(function(){
	$(window).resize(function(){
		JOMOS.window.width = $(window).width();
		JOMOS.window.height = $(window).height();
        $('#pageContainer').width(JOMOS.window.width - $('body>aside').width());
		
		if(JOMOS.app.currentPage != null && typeof JOMOS.app.currentPage.domElement != 'undefined')
			$(JOMOS.app.currentPage.domElement).css('min-height',(JOMOS.window.height-130)+'px');
		
	}).resize();
	
	if(document.location.hash == "") document.location.hash = JOMOS.app.defaultHash;
	
	$(window).bind('hashchange', JOMOS.engine.onHashChange).trigger('hashchange');
	if(typeof JOMOS.app.events.onLoad == 'function') JOMOS.app.events.onReady();
});