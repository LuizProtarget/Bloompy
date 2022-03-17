$(function(){
	
	var ProdutosProdutoColecaoId = $("#ProdutosProdutoColecaoId");
	var ProdutosProdutoLinhaId = $("#ProdutosProdutoLinhaId");
	
	ProdutosProdutoColecaoId.change(function(){
		if($(this).val().length > 0)
		{
			ProdutosProdutoLinhaId.html('');
			ProdutosProdutoLinhaId.append('<option value="">Selecione</option>');
			$.ajax({
				url:QuickApps.settings.base_url+"admin/produtos/linha/ajaxColecao/"+ProdutosProdutoColecaoId.val(),
				type:"get",
				dataType:"json",
				success:function(resposta)
				{
					for(indice in resposta)
						ProdutosProdutoLinhaId.append('<option value="'+indice+'">'+resposta[indice]+'</option>');
				}
			});
		}
	}).trigger('change');
	$("#SkusAdminAddForm").submit(function(){
		$("#btnAddSku").trigger('click');
		return false; 
	});
	$("#menuContainer .enable").click(function(){
		
		var obj = $(this);
		
		obj.parent().find("a.menuItemSelected").removeClass('menuItemSelected');
		obj.addClass("menuItemSelected");
		obj.parent().parent().find("form").hide();
		$("#"+obj.attr("rel")).show();
	});
	$("#btnAddSku").click(function(){
		
		var fieldObj= $("#SkusReferencia");
		var tpl		= '<tr id="sku_{ID}" class="even">' +
				'<td align="left">{COLUMN_1}</td>' +
				//'<td align="left">{COLUMN_COR}</td>' +
				'<td align="left">{COLUMN_2}</td>' +
				'<td align="left">{COLUMN_3}</td>' +
				'<td align="right">' +
				'<a href="#" class="btnSkusEditar" rel="{ID}">editar</a>'+
				' | <a href="#" rel="{ID}" class="btnSkusFoto">upload de fotos</a>' +
				' | <a href="#" class="btnSkusDelete" rel="{ID}">remover</a>'+
				'</td>'+
			'</tr>';
		
		if(fieldObj.val() == '')
		{
			fieldObj.focus();
			return false;
		}
		
		var input_ref 		= $("#SkusReferencia");
		//var input_cor 		= $("#SkusProdutoCorId");
		var input_site 		= $("#SkusExibirSite");
		var input_celular	= $("#SkusExibirMobile");
		var input_sku_id	= $("#SkusProdutoSkuId");
				
		$(this).attr({'disabled':true});
		input_ref.attr({'readonly':true});
		
		$("#skuLoading").html('salvando, aguarde...').css({"visibility":"visible"});
		
		$.ajax({
			url:action['addSku'],
			dataType:"json",
			type:"POST",
			data:$("#SkusAdminAddForm").serialize(),
			success:function(data){
				
				var tmp_tpl = tpl.replace(/{COLUMN_1}/g, input_ref.val()).replace(/{COLUMN_2}/g, input_site.find(":selected").text()).replace(/{COLUMN_3}/g, input_celular.find(":selected").text()).replace(/{ID}/g, data.product_sku_id);
				
				if(!$("#sku_"+data.product_sku_id).length)
					$("#tableSKU tbody").append(tmp_tpl);
				else
				{
					var tr_obj = $("#sku_"+data.product_sku_id);
					tr_obj.after(tmp_tpl);
					tr_obj.remove();
				}
				$("#skuLoading").css({"visibility":"hidden"});
				$("#btnAddSku").attr({'disabled':false});
				
				// Reseta campos
				input_ref.val('');
				input_ref.attr({'readonly':false});
				//input_cor[0].selectedIndex = 0;
				input_site[0].selectedIndex = 0;
				input_celular[0].selectedIndex = 0;
				input_sku_id.val('');
			}
		});
	});
	$(".btnSkusEditar").live('click',function(){
		var id 				= $(this).attr('rel');
		var input_ref 		= $("#SkusReferencia");
		var input_site 		= $("#SkusExibirSite");
		var input_celular	= $("#SkusExibirMobile");
		var input_sku_id	= $("#SkusProdutoSkuId");
		//var input_cor 		= $("#SkusProdutoCorId");
		
		if(input_sku_id.val() != "")
			$("#sku_"+input_sku_id.val()).removeAttr('style');
		
		$(this).parent().parent().css({"background-color":"rgba(158, 196, 164, 0.4)"});
		 
		$("#skuLoading").html('Carregando informação, aguarde...').css({"visibility":"visible"});
		
		$.ajax({
			url:action['getSku'],
			dataType:"json",
			type:"POST",
			data:$("#SkusAdminAddForm").serialize()+'&data[Skus][produto_sku_id]='+id,
			success:function(data){
							
				$("#skuLoading").css({"visibility":"hidden"});
				
				// Reseta campos
				if(data.length > 0 && data != null)
				{
					for(indice in data)
					{
						input_ref.val(data[indice].referencia);
						//input_cor.val(data[indice].produto_cor_id);
						input_site.val(data[indice].exibir_site);
						input_celular.val(data[indice].exibir_mobile);
						input_sku_id.val(data[indice].produto_sku_id);
						
						$("#skuLoading").html('Você está editando um SKU, <a href="#" class="btnSkusCancelar">clique aqui para cancelar</a>');
						$("#skuLoading").css({"visibility":"visible"});
					}
				}
			}
		});
	});
	$(".btnSkusDelete").live('click',function(){
	
		var id = $(this).attr('rel');
		
		if(confirm("Deseja excluir este registro?"))
			$.ajax({
				url:action['delete'],
				dataType:"json",
				type:"POST",
				data:$("#SkusAdminAddForm").serialize()+'&data[Skus][produto_sku_id]='+id,
				success:function(data)
				{
					$("#skuLoading").css({"visibility":"hidden"});
					
					// Reseta campos
					if(data.length > 0 && data != null)
					{
						for(indice in data)
						{
							if(data[indice].status)
							{
								$("#sku_"+data[indice].produto_sku_id).remove();
								alert("Registro excluído!");
							} 
							else
								alert("Registro não pode ser excluído.");
						}
					}
				}
			});
		
	});
	$(".btnSkusCancelar").live('click',function(){
	
		$(this).parent().css({"visibility":"hidden"});
		
		var input_ref 		= $("#SkusReferencia");
		var input_site 		= $("#SkusExibirSite");
		var input_celular	= $("#SkusExibirMobile");
		var input_sku_id	= $("#SkusProdutoSkuId");
		//var input_cor 		= $("#SkusProdutoCorId");
		
		$("#sku_"+input_sku_id.val()).removeAttr('style');
		
		// Reseta campos
		input_ref.val('');
		input_ref.attr({'readonly':false});
		//input_cor[0].selectedIndex = 0;
		input_site[0].selectedIndex = 0;
		input_celular[0].selectedIndex = 0;
		input_sku_id.val('');
	});
	$(".openFileUpload").click(function() {
	
		 $("#html5_uploader").pluploadQueue({
			// General settings
			runtimes : 'html5,silverlight,html4',
			url : action['upload'],
			max_file_size : '200mb',
			unique_names : true,
			multipart_params:formData,
			file_data_name:'Filedata',
			filters : [
				{title : "Image files", extensions : "jpg"}
			],
	
			// Resize images on clientside if we can
			//resize : {width : 320, height : 240, quality : 90},
			
			silverlight_xap_url : action['urlSilverlight']
		});
		var uploader = $('#html5_uploader').pluploadQueue();
		uploader.bind('UploadComplete',function(uploader, files)
		{
			$(".plupload_buttons").css("display", "inline");
			$(".plupload_upload_status").css("display", "inline");
			uploader.refresh();
			uploader.splice();
			updateGaleria();
		});
		updateGaleria();
	});
	$(".btnSkusFoto").live('click',function(){
		
		var id = $(this).attr('rel');
		
		$("#SkuFotosAdminAddForm legend").html('Upload de fotos - "'+ $(this).parent().parent().find('td:first').html()+'"');
		
		formData = {"data[Skus][produto_sku_id]":id, "_method":"POST", "data[_Token][key]":$("#SkusAdminAddForm input[name='data[_Token][key]']").val(), "data[_Token][fields]":$("#SkusAdminAddForm input[name='data[_Token][fields]']").val(), "data[_Token][unlocked]":$("#SkusAdminAddForm input[name='data[_Token][unlocked]']").val()};
		
		$(".openFileUpload").trigger('click');
	});
	function updateGaleria()
	{
		var fotoGaleriaContainer = $(".produtoFotoGaleria");
		fotoGaleriaContainer.html('');
				
		if(formData == null)
			return false;
				
		  $.ajax({
			url:action['getFotos'],
			dataType:"json",
			type:"POST",
			data:$("#SkusAdminAddForm").serialize()+'&data[Skus][produto_sku_id]='+formData['data[Skus][produto_sku_id]'],
			success:function(data){
											
				// Reseta campos
				if(data.length > 0 && data != null)
				{
					for(indice in data)
					{
						fotoGaleriaContainer.append('<li rel="'+data[indice].produto_sku_id+'" id="sku_foto_'+data[indice].produto_sku_foto_id+'"><img src="'+QuickApps.settings.base_url+data[indice].image+'" width="150" /><a href="javascript:void(0);" class="removerFoto">Remover</a></li>');
					}
				}
				var positions = {'startPos':null,'endPos':null};
			    $( "#sortable" ).sortable({
			      opacity: 0.5,
			      start	: function(event, ui) {
			      	positions.startPos = ui.item.index()+1;
			      },
				  update: function( event, ui ) {
				  	
				  	positions.endPos = ui.item.index()+1;
				  
				  	$.ajax({
						url:action['positionFoto'],
						dataType:"json",
						type:"POST",
						data:$("#SkusAdminAddForm input[type='hidden']").not("[name*='produto_sku_']").serialize()+'&data[Skus][produto_sku_foto_id]='+ui.item.attr('id').replace('sku_foto_','')+'&data[Skus][position]='+parseInt(ui.item.index()+1)+'&way='+(positions.startPos < positions.endPos ? 0 : 1)+'&data[Skus][produto_sku_id]='+ui.item.attr('rel'),
						success:function(data){
						}
					});
				  }
				});
			    $( "#sortable" ).disableSelection();
			}
		});
	}
	$(".removerFoto").live('click',function(){
		
		var obj = $(this);
		var produto_sku_foto_id = obj.parent().attr('id').replace('sku_foto_','');
		
		obj.removeClass('removerFoto').html('Removendo...');
		
		$.ajax({
			url: action['removerFoto'],
			dataType:"json",
			type:"POST",
			data:$("#SkusAdminAddForm input[type='hidden']").not("[name*='produto_sku_']").serialize()+'&data[Skus][produto_sku_foto_id]='+produto_sku_foto_id,
			success:function(data){
				
				if(data.length && data[0].status)
				{
					obj.parent().fadeOut('fast', function(){ obj.remove(); });
				}
				else
					obj.addClass('removerFoto').html('Falhou, tentar denovo?');
			}
		});
	});
	if ( $('.table tbody') ) {
		
		updatePosition();
	}
	if ( $('#tableSKU tbody') ) {
		
		updatePositionSku();
	}
});

function updatePosition()
{
	var positions = {'startPos':null,'endPos':null};
	$( ".table tbody" ).sortable({
		opacity: 0.5,
		start	: function(event, ui) {
		positions.startPos = ui.item.index()+1;
	},
		update: function( event, ui ) {
			positions.endPos = ui.item.index()+1;
		
			$.ajax({
				url:action['position'],
				dataType:"json",
				type:"POST",
				data:'data[Produtos][produto_id]='+ui.item.attr('produto_id')+'&data[Linha][linha_id]='+ui.item.attr('linha_id')+'&data[Produtos][position]='+parseInt(ui.item.index()+1)+'&way='+(positions.startPos < positions.endPos ? 0 : 1),
				success:function(data){}
			});
		}
	});
	$( "#sortable" ).disableSelection();
}
function updatePositionSku()
{
	var positions = {'startPos':null,'endPos':null};
	$( "#tableSKU tbody" ).sortable({
		opacity: 0.5,
		start	: function(event, ui) {
		positions.startPos = ui.item.index()+1;
	},
		update: function( event, ui ) {
			positions.endPos = ui.item.index()+1;
		
			$.ajax({
				url:action['positionSku'],
				dataType:"json",
				type:"POST",
				data:'data[Skus][produto_id]='+ui.item.attr('produto_id')+'&data[Skus][sku_id]='+ui.item.attr('id').replace('sku_','')+'&data[Skus][position]='+parseInt(ui.item.index()+1)+'&way='+(positions.startPos < positions.endPos ? 0 : 1),
				success:function(data){}
			});
		}
	});
	$( "#sortable" ).disableSelection();
}