// JavaScript Document
var request = false;
var remitentes = [];
var dialogo=null;
var D ={}; // DOM cache object
var busqueda = 0; 	//Simple : 1
					//Avanzada : 2

$(document).ready(function(){		

	$(".caja").focus(function(){
		$(this).attr("class","con_focus");					   
	});
	$(".caja").blur(function(){
		$(this).attr("class","sin_focus");					   
	});
	$('.hidden').removeClass('hidden').hide();
	/************* Clase Escaneo **************/
	$("#terminar_escaneo").click(function() { 						  
         $.blockUI({ message: $('#question'), css: { width: '275px' } }); 
    }); 
    $("#categoria_doc").change(function(){
        $("#span_expediente")[ ( this.value=="TUPA"? "show":"hide" ) ]();
    });
	$('#yes').click(function() { 
  
		$.blockUI({ message: "<p class='Estilo22'>Actualizando...</p>" }); 

		$.ajax({ 
			url: 'Ajax/AjaxEscaneo.php', 
			cache: false, 
			data: "metodo=actualiza&ids="+$("#id_documento").val()+"&est=1",
			dataType: "xml",
			success: function(xml){        
				$.unblockUI();
				location.href="escaneo_acceso_registro.php";
			}
		}); 
	});
 
    $('#no').click(function() { 
		$.blockUI({ message: "<p class='Estilo22'>Actualizando...</p>" }); 
        $.ajax({ 
        	url: 'Ajax/AjaxEscaneo.php', 
            cache: false, 
			data: "metodo=actualiza&ids="+$("#id_documento").val()+"&est=2",
			dataType: "xml",
            success: function() { 
	            $.unblockUI(); 
				location.href="escaneo_acceso_registro.php";
         	} 
    	}); 		
   });
	/***********************************************/
	
	if(document.getElementById("text_remitente")!=null){
        
        function findValueCallback(event, data, formatted) {
            if(!data)
                $("#id_remitente").val('');
            else
                $("#id_remitente").val(data);		
        }
        
        $("#text_remitente").autocomplete("Ajax/AjaxVentanilla.php",{
            autoFill: true,
            selectFirst: false
        });
        $("#text_remitente").removeAttr("readonly");
        
        if(document.getElementById("btnguardar")!=null){
            $("#text_remitente").result(findValueCallback).parent().parent().parent().parent().find("#btnguardar").click(function() {
                $("#text_remitente").search();
            });
        }

	}

	if(document.getElementById("datepicker1")!=null){
		$("#datepicker1").datepicker({
			changeMonth: true,
			changeYear: true						 
		});
	}
	
	if(document.getElementById("datepicker2")!=null){
		$("#datepicker2").datepicker({
			changeMonth: true,
			changeYear: true						 
		});
	}
	
	if(document.getElementById("date_cambio1")!=null){
		$("#date_cambio1").datepicker({
			changeMonth: true,
			changeYear: true						 
		});
	}
	
	if(document.getElementById("date_cambio2")!=null){
		$("#date_cambio2").datepicker({
			changeMonth: true,
			changeYear: true						 
		});
	}
		
	$("#form_buscar_superior").validate({
		error: "error",
		rules: {
			campo: "required",
			valor: "required"
		},
		messages: {
			campo: "",
			valor: ""
		}
	});
	
	$("#form_nueva_accion").validate({
		error: "error",
		rules: {
			txtnombre: "required"
		},
		messages: {
			txtnombre: ""
		}
	});
	
	$("#form_busqueda_simple").validate({
		error: "error",
		rules: {
			registro: "required",
			anio: "required"
		},
		messages: {
			registro: "",
			anio: ""
		}									
	});
	
	$("#form_despacho").validate({
	
		error: "error",
		rules: {
			cboprioridad: "required",
			cboareas: "required",
			cboaccion: "required",
			radiobutton: "required"
		},
		messages: {
			cboprioridad: "",
			cboareas: "",
			cboaccion: "",
			radiobutton: ""
		}
	});
	
	$("#form_despacho_area").validate({
	
		error: "error",
		rules: {
			destino: "required",
			cboaccion2: "required",
			radiobutton: "required"
		},
		messages: {
			destino: "",
			cboaccion2: "",
			radiobutton: ""
		}
	});
	
	$("#form_editar_documento").validate({
	
		error: "error",
		rules: {
			remitente: "required",
			tipo: "required",
			categoria_doc: "required",
			date: "required"
		},
		messages: {
			remitente: "",
			tipo: "",
			categoria_doc: "",
			date: ""
		}
	});
	
	$("#form_registrar_documento").validate({
	
		error: "error",
		rules: {
			remitente: "required",
			tipo: "required",
			categoria_doc: "required",
			date_registrar: "required"
		},
		messages: {
			remitente: "",
			tipo: "",
			categoria_doc: "",
			date_registrar: ""
		}
	});
	
	$("#form_nueva_area").validate({
	
		error: "error",
		rules: {
			txtnombre: "required",
			txtabreviatura: "required"
		},
		messages: {
			txtnombre: "¡Debe ingresar un nombre de area!",
			txtabreviatura: "¡Debe ingresar una abreviatura!"
		}
	});
	
	$("#form_borrador_respuesta").validate({
	
		error: "error",
		rules: {
			comentario: "required",
			accion: "required",
			usuario: "required",
			categoria: "required"
		},
		messages: {
			comentario: "",
			accion: "",
			usuario: "",
			categoria: ""
		}
		});
	
	$("#form_finalizar_documento").validate({
		
		error: "error",
		rules: {
			borrador: "required"
		},
			messages: {
			borrador: ""
		}
	});
		
	agrega_validacion_finalizado("#form_documento_fin_imprimir");
	/**************************************************************/
	$("#cargar_accion_areas").click(function() {
		if($("#form_despacho_area").valid()){								 
			if($("#accion_despacho").val()!=6&&$("#accion_despacho").val()!=8){
				$("#conf_usuario").html($("#destino option:selected").text());
				if($("#copia").is(':checked'))
					$("#conf_categoria").html("Copia");
				else
        			$("#conf_categoria").html("Original");
			
				$.blockUI({ message: $('#question'), css: { width: '275px' } }); 
			}
			else{
				cargar_accion('des_guard',$("#id_documento").val());
			}
		}
    });
	
	$('#yes_d_a').click(function() {								 
  		cargar_accion('des_guard',$("#id_documento").val());		
	});
 
    $('#no_d_a').click(function() { 
		$.unblockUI();	
		return false;
   });
	
	$('#yes_a_d').click(function() {								 
  		AbrirBorradorRespuesta($("#id_doc").val(),$("#tipo").val());	
	});
 
    $('#no_a_d').click(function() { 
		$.unblockUI();	
		return false;
   });
	 
	/***************************************************************/
	
	
	$("#cambiar_destino").click(function(){
		cambiar_usuarios_areas(0);		 
	});	
		
	$("#consulta_avanzada").click(function() {
		if(validar_consulta_avanzada()||validar_consulta_avanzada()=="todos"){
			if(validar_consulta_avanzada()=="todos")
				busqueda_avanzada("&todos='todos'");
			else
				busqueda_avanzada("");
			busqueda = 2;
		}
	});	
	
	$("#consulta_simple").click(function(){
		if($("#form_busqueda_simple").valid()){								 
			busqueda_simple($("#registro").val()+"-"+$("#anio").val(),$("#anp").val());
			busqueda = 1; 
		}
	});
	
	$("#images a").click( function(){
		var title = $(this).attr("title");
		$("#imgp").hide();
		$("#imgp").attr("src", title).fadeIn('slow');
	});
		
	$("#aceptar_b").click( function(){
		$("#form_borrador").submit();
	});
		
	$("#cancelar_b").click( function(){
		cerrar_popups();
	});
		
	$("#vista").live("click",function(){
		form = $(this).parent().parent().parent();							  
		if($(form).valid()){
			window.open('', 'popup', 'width=700,height=700,toolbar=0,location=0,statusbar=0,menubar=0,resizable=0,scrollbars=1');
			$(form).submit();
		}
	});
	
	$("#agregar_doc_fin").live("click",function(){
		agrega_documento_finalizado(this);
	});
	
	$("#elimina_doc_fin").live("click",function(){
		quita_item_finalizado(this);
	});		
		
	$("#cerrar_b").click( function(){
			window.opener.location.reload();
			//Cerramos el popup
			var padre=window.self;
			padre.opener = window.self;
			padre.close();
	});
	
	$("#cerrar_j").click( function(){								   
			window.opener.location.href="atencion_acceso_registro.php";
			//Cerramos el popup
			var padre=window.self;
			padre.opener = window.self;
			padre.close();
	});
	
	$("#cerrar_a").click( function(){								   
		//Obtenermos la Url de la pagina padre sin parametros
		url = window.opener.location.href;
		partes = url.split('/');
		url = partes[partes.length-1];
		partes = url.split('?');
		//redireccionamos al padre
		window.opener.location.href=partes[0];
		//Cerramos la hija
		var padre=window.self;
		padre.opener = window.self;
		padre.close();
	});
	
	
	$("#select_estado").change(function(){
		val_estado = $("#select_estado").val();
		if(val_estado!=''&&val_estado!='RG'){
			if(val_estado == 'DR'){
				habilita_elemento($("#origen"));
				habilita_elemento($("#destino"));
			}else{
				$("#origen").val("");
				deshabilita_elemento($("#origen"));
				$("#destino").val("");
				deshabilita_elemento($("#destino"));
			}
			habilita_elemento($("#date_cambio1"));
			habilita_elemento($("#date_cambio2"));
		}else{
			$("#date_cambio1").val("");
			deshabilita_elemento($("#date_cambio1"));
			$("#date_cambio2").val("");
			deshabilita_elemento($("#date_cambio2"));
			$("#origen").val("");
			deshabilita_elemento($("#origen"));
			$("#destino").val("");
			deshabilita_elemento($("#destino"));			
		}
	});
	
	$("#accion_borrador").change(function(){
		val_accion = $("#accion_borrador").val();
		if(val_accion==24||val_accion==29||val_accion==35||val_accion==36||val_accion==7||val_accion==6){
			if(val_accion==24||val_accion==29){				
				obtener_id_director()				
			}
			else{
				if(val_accion==7)
					$("#usuario").val($("#user").val());
				else
					$("#usuario").val("");
				deshabilita_elemento($("#usuario"));
			}
		}else{					
			$("#usuario").val("");
			habilita_elemento($("#usuario"));
		}
	});
	/*******************************************************************/
	$("#accion_despacho").change(function(){
		val_accion = $("#accion_despacho").val();
		if(val_accion==6||val_accion==8){
			$("#destino").val("");
			deshabilita_elemento($("#destino"));
			deshabilita_elemento($("#comentario"));
		}else{
			habilita_elemento($("#destino"));
					
			if(val_accion == 16){				
				cambiar_usuarios_areas(1);
				$("#destino").attr("class","areas");
			}
			else{
				cambiar_usuarios_areas(0);
				$("#destino").attr("class","usuarios");	
			}
			
		}
	});
	

	$("input[type=radio][name=tcar]").click( function(){
		$("#carac").empty();
		$("#cantidad").val(0);
	});

	$("#clb").click( function(){
		$("#cbusqueda").toggle('slow');
		$("#cfiltrar").hide('slow');
	});

	$("#fil").click( function(){
		$("#cfiltrar").toggle('slow');
		$("#cbusqueda").hide('slow');
	});
	
	$(".tip").tooltip({
		track: true,
		delay: 0,
		showURL: false
	}
	);
});


if (window.XMLHttpRequest) {
	request = new XMLHttpRequest();
}

function guardar_registro_documento(){
	if(confirm("Esta seguro que desea guardar el documento?")){
		$("#form_registrar_documento").submit();
	}
}

function actualizar_registro_documento(){
	if(confirm("Esta seguro que desea guardar los cambios realizados al documento?")){
		$("#form_editar_documento").submit();
	}
}

function agrega_validacion_finalizado(form){
	$(form).validate({
		
		error: "error",
		rules: {
			asunto: "required",
			referencia: "required",
            destinatario: "required",
			cargo: "required",
			saludo: "required",					
			tipo: "required"			
		},
		messages: {
			asunto: "",
			referencia: "",
            destinatario: "",
			cargo: "",
			saludo: "",			
			tipo: ""
		}
	});
}

function deshabilita_todo_da(){
	deshabilita_elemento($("#accion_despacho"));
	deshabilita_elemento($("#comentario"));
	deshabilita_elemento($("#original"));
	deshabilita_elemento($("#copia"));
	deshabilita_elemento($("#destino"));
	deshabilita_boton($("#cargar_accion_areas"));
}

function quita_archivar(){
	$("#accion_despacho").find("option[value='6']").remove();
}

function exportar_datos(tipo){	
	if(busqueda == 1){		
		window.location.href="Reportes/reporte.php?tipo="+tipo+"&_reg="+$("#registro").val()+"-"+$("#anio").val();
	}else if(busqueda == 2){
		window.location.href="Reportes/reporte.php?tipo="+tipo+"&"+data_busqueda_avanzada();
	}else{
		alert("Debe realizar una consulta");
	}	
}

function accion_por_defecto_area(estado){
    if(estado==16){
		$("#accion_despacho").val(6);
		deshabilita_elemento($("#destino"));
	}
	else{
		if(estado==17){
			$("#accion_despacho").val(16);
			cambiar_usuarios_areas(1);
			$("#destino").attr("class","areas");
		}
	}
}

function accion_por_defecto(estado){

	if(estado==14){
		$("#accion_borrador").val(35);
		deshabilita_elemento($("#usuario"));
	}
	else{
		if(estado==15){
			$("#accion_borrador").val(36);
			deshabilita_elemento($("#usuario"));
		}
	}
}

function editar_asunto(id){
	$("#editar_guardar_asunto").html("");
	$("#editar_guardar_asunto").html("<a href='javascript:guardar_asunto("+id+")'><img src='public_root/imgs/b_save.png' border='0'/></a>");
	habilita_asunto();
}

function guardar_asunto(id){
	$.ajax({
      type: "POST",
      url: "Ajax/AjaxMesa.php",
	  cache: false,
      data: "opcion=actualiza&ids="+id+"&asunto="+$("#asunto").val(),
      dataType: "xml",
      success: function(xml){
        $(xml).find('option').each(function(){
            if($(this).attr('value')== "OK"){
                alert("Se actualizo el asunto con exito");
				$("#asunto_anterior").val($("#asunto").val());
				deshabilita_asunto(id);
            }
            else{
				if($(this).attr('value')== "ERROR"){                
					$("#asunto").val($("#asunto_anterior").val());
                	alert("Ocurrio un error al guardar el asunto, intente nuevamente");					
				}
				else{
					$("#asunto").val($("#asunto_anterior").val());
					alert("No puede ingresar un asunto vacio");	
				}
            }
      	});   	    
      }
    });
}

function verDetalleEstado(){
	$("#detalleEstado").slideToggle("slow");
}

function cambiar_usuarios_areas(tipo){
	
	if($("#destino").attr("class")=="usuarios"||tipo==1){
		$("#destino").removeAttr("class");
		listarAreas($("#idArea").val());		
		$("#destino").attr("class","areas");
		$("#cambiar_destino").text("Usuarios");
	}
	else{
		$("#destino").removeAttr("class");
		listarUsuariosArea($("#idArea").val(),"Ajax/Ajax.php");
		$("#destino").attr("class","usuarios");
		$("#cambiar_destino").text("Areas");
	}	
}

function obtener_id_director(){
	
	var id_area = $("#id_area").val();
	
	$.ajax({
      type: "POST",
      url: "Ajax/Ajax.php",
	  cache: false,
      data: "metodo=director_area&area="+id_area,
      dataType: "xml",
      success: function(xml){        
        $(xml).find('option').each(function(){
            $("#usuario").val($(this).attr('value'));			
      	});
      }
   	});	
}

function imprimir_documento_reg(id){
	url = "Ventanillas/ficha_registro.php?id="+id;
	window.open(url,'popup','width=380,height=580,toolbar=0,location=0,statusbar=0,menubar=0,resizable=0,scrollbars=1');
}

function actualiza_input(check,id){

	if(!$(check).is(":checked"))
		$("#act"+id).val($(check).val());
	else
		$("#act"+id).val("");
}

function VerDetalleBusqueda(id){

		var url = "detalle_documento.php?id="+id;
		ancho = screen.width-20;
		AbrirPopUp(url,'archivo',ancho,550);
}

function busqueda_simple(registro,anp){
	jQuery("#frmgrid").setGridParam({url:"Ajax/AjaxBusqueda.php?reg="+registro+"&anp="+anp,page:1}).trigger("reloadGrid"); 
}

function data_busqueda_avanzada(){
	rem=$("#text_remitente").val();
	ubi=$("#ubicacion").val();
	doc=$("#documento").val();
	asu=$("#asunto").val();	
	ori=$("#origen").val();	
	des=$("#destino").val();	
	fecha1=$("#datepicker1").val();
	fecha2=$("#datepicker2").val();
	fecha3=$("#date_cambio1").val();
	fecha4=$("#date_cambio2").val();
	
	if(fecha3==''&&ori==''&&des==''){
		est=$("#select_estado").val();
	}
	else{
		combo=document.getElementById("select_estado");
		est=combo[combo.selectedIndex].text;		
	}
	
	return "rem="+rem+"&asu="+asu+"&doc="+doc+"&ubi="+ubi+"&fecha1="+fecha1+"&fecha2="+fecha2+"&est="+est+"&ori="+ori+"&des="+des+"&fecha3="+fecha3+"&fecha4="+fecha4;
}

function busqueda_avanzada(cad){
	if(cad!="")
		datos = data_busqueda_avanzada()+cad;
	else
		datos = data_busqueda_avanzada()

	jQuery("#frmgrid").setGridParam({url:"Ajax/AjaxBusqueda.php?"+datos,page:1}).trigger("reloadGrid"); 
}

function validar_consulta_avanzada(){
		
	$("#msg_dialogo").html("");	
		
	if($("#text_remitente").val()==''&&$("#asunto").val()==''&&$("#datepicker1").val()==''&&$("#datepicker2").val()==''&&$("#documento").val()==''&&$("#ubicacion").val()==''&&$("#select_estado").val()==''){
		//$("#msg_dialogo").html("Debe ingresar al menos uno de los campos de busqueda"); 
		//crea_dialogo();		
		return "todos"
	}
	else{
		if(valida_fechas($("#datepicker1"),$("#datepicker2")))
			if(valida_fechas($("#date_cambio1"),$("#date_cambio2")))
				return true;
			else
				return false;
		else
			return false;
	}
		
}

function valida_fechas(f1,f2){
	if($(f1).val()!=''&&$(f2).val()!=''){
			fecha1=convierteFecha($(f1).val());
			fecha2=convierteFecha($(f2).val());
			
			if(es_mayor($(f1).val(),$(f2).val())||fecha1 == fecha2){
				$("#msg_dialogo").html("La segunda fecha debe ser mayor que la primera");
				crea_dialogo();
				return false
			}
			else
				return true;
			
		}else{
			if($(f1).val()==''&&$(f2).val()!=''){
				$("#msg_dialogo").html("Debe ingresar la primera fecha para la busqueda");
				crea_dialogo();
				return false
			}
			else	
				return true;
		}
}

function es_mayor(fecha, fecha2){
  
     var xMonth=fecha.substring(3, 5);  
     var xDay=fecha.substring(0, 2);  
     var xYear=fecha.substring(6,10);  
     var yMonth=fecha2.substring(3, 5);  
     var yDay=fecha2.substring(0, 2);  
     var yYear=fecha2.substring(6,10);  
     if (xYear> yYear)  
     {  
         return(true)  
     }  
     else  
     {  
       if (xYear == yYear)  
       {   
         if (xMonth> yMonth)  
         {  
             return(true)  
         }  
         else  
         {   
           if (xMonth == yMonth)  
           {  
             if (xDay> yDay)  
               return(true);  
             else  
               return(false);  
           }  
           else  
             return(false);  
         }  
       }  
       else  
         return(false);  
     }  
 }  

function crea_dialogo(){
	
	$("#dialog").css("display","block");	
	
	if(dialogo == null){
	dialogo = $("#dialog").dialog({
			bgiframe: true,					  
			resizable: false,
			minHeight: 100,
			height:120,
			width:400,
			modal: true,
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				Aceptar: function() {
					$(this).dialog('close');
				}
			}
		});
	}else{		
		$('#dialog').dialog( 'open' );
	}
	
}

function cargar_accion(opcion,id){
	
	if($("#accion_despacho").val()==6||$("#accion_despacho").val()==8){
		if($("#accion_despacho").val()==6){ //Archivar
			ArchivarDocumento(id,0);
		}else{
			if($("#copia").is(':checked')){
				alert("No puede devolver una Copia");
			}
			else{
				DevolverDocumento(id);				
			}
		}
	}else{
		if($("#form_despacho_area").valid()){
			form=document.getElementById("form_despacho_area");
			form.action="areas_acceso_registro.php?opcion="+opcion+"&ids="+id;
			form.submit();
		}
	}
}

function cargar_remitentes(){
	/*$.ajax({
		type: "POST",
		url: "Ajax/AjaxVentanilla.php",
		cache: false,
		data:"metodo=cargar_remitentes",
		dataType: "html",

      success: function(html){		  
 	    		    
			$(html).find('option').each(function(){
				var remit = {};									
				remit.id = $(this).attr('value');
				remit.name = $(this).attr('class');
				remitentes.push(remit);    			
        	});			
      }
	  
	});*/
}

function QuitarFinalizar(id){	
	$.ajax({
		type: "POST",
		url: "areas_acceso_registro.php",
		cache: false,
		data: "opcion=desfin&id="+id,
		success: function(){
			location.href="areas_acceso_registro.php";
		}
	});	   
}

function QuitarArchivado(id){
	
	   $.ajax({
		type: "POST",
		url: "areas_acceso_registro.php",
		cache: false,
		data: "opcion=desarch&id="+id,
		success: function(){
			location.href="areas_acceso_registro.php";
		}
 		});
	   
}

function CargarPlantilla(){
		CargarCabecera();
		CargarPie();
		$("#saludo_documento").html($("#saludo").val());
		$("#despedida_documento").html($("#despedida").val());

}

function CargarCabecera(){
    
	$.ajax({
      type: "POST",
      url: "Ajax/AjaxPlantilla.php",
	  cache: false,
      data: "parte=0&asu="+$("#asunto").val()+"&ref="+$("#referencia").val()+"&tipo="+$("#tipo").val()+"&remit="+$("#remitente").val()+"&cargo="+$("#cargo").val(),
      dataType: "html",

      success: function(html){
   	   // alert("Y ahora se van a listar las areas");
		$("#cabecera_documento").html("");
        $("#cabecera_documento").html(html);
      }
    });
}

function CargarPie(){
	$.ajax({
      type: "POST",
      url: "Ajax/AjaxPlantilla.php",
	  cache: false,
      data: "parte=1&tipo="+$("#tipo").val(),
      dataType: "html",

      success: function(html){
   	   // alert("Y ahora se van a listar las areas");
		$("#pie_documento").html("");
		$("#pie_documento").html(html);
      }
    });
}

function imprimir_documento_final(){
	var bName = navigator.appName;
	var bVer = parseFloat(navigator.appVersion);

	var contenido = document.getElementById("contenido_documento").innerHTML;
	ventana=window.open("","ventana","width=560");
	ventana.document.open();
	ventana.document.write('<html><head><title>Titulo< \/title><link rel="stylesheet" type="text/css" href="css/css.css"><\/head><body style=\"background-color: #FFFFFF\">');
	ventana.document.write(contenido);
	ventana.document.close();
	ventana.print();
	ventana.focus();
}

function imprimirDocumento(){
	if($("#codigo_fin").val()=="")	
		guardar_finalizado($("#id_fin").val(),$("#tipo").val());
	else
		window.print();
}

function guardar_finalizado(id,tipo){
	$.ajax({
      type: "POST",
      url: "Ajax/AjaxFinalizado.php",
	  cache: false,
      data: "opcion=guarda&id="+id+"&tipo="+tipo,
      dataType: "xml",
      success: function(xml){
        $(xml).find('option').each(function(){
            if($(this).attr('value')!= "ERROR"){
				$("#codigo_fin").val($(this).attr('value'));
				$("#codigo").html($(this).attr('value'));
				$("#codigo").css("color","inherit")
				window.print();
            }            
      	});   	    
      }
    });	
}

function EditarBorrador(idb){
    var url = "editar_borrador_respuesta.php?idb="+idb;
	AbrirPopUp(url,'editar',700,630);
}

function VerDetalleBorrador(idb){
	var url = "detalle_borrador.php?idb="+idb;
	AbrirPopUp(url,'editar',620,450);
}

function VerComentario(id){
	$("#detalle_borrador"+id).slideToggle("slow");
}

function VerDetalleObservacion(id){
	$("#detalle_observacion"+id).slideToggle("slow");
}

function ArchivarCompletado(id){

	 $.ajax({
		type: "POST",
		url: "Ajax/AjaxArea.php",
		cache: false,
		data: "opcion=arch&id="+id+"&cat="+$("#cat").val()+"&tipo="+$("#tipo").val()+"&com="+$("#comentario").val(),
		dataType: "xml",
		success: function(xml){
			$(xml).find('option').each(function(){
            	$("#id_archivo").val($(this).attr('value'));			
      		});	
			
			hist = $("#id_archivo").val();			
			document.getElementById("form_archivo").action = "archivar_documento_comentario.php?id_hist="+hist+"&op=cargar_adj&cat="+$("#cat").val();
			document.getElementById("form_archivo").submit();
		}
 		});
}

function DevolverCompletado(id){

    //location.href="areas_acceso_registro.php?opcion=arch&id="+id+"&com="+$("#comentario").val();
    $.ajax({
		type: "POST",
		url: "Ajax/AjaxArea.php",
		cache: false,
		data: "opcion=devol&id="+id+"&com="+$("#comentario").val(),
		success: function(){
			window.opener.location.href="areas_acceso_registro.php";
			var padre=window.self;
			padre.opener = window.self;
			padre.close();
		}
 		});
}

function validar_historial_atencion(id){
		var borrador = "";
		if(tinyMCE.get('rpt_borrador'))
			borrador = tinyMCE.get('rpt_borrador').getContent();
		
        if( borrador == '' && $("#adicional").val()==''){
			alert("ERROR: Por favor ingrese una Respuesta al borrador o Ingrese un Comentario");
		}else{
         if(valida_archivos(1)){
				$("#comentario").val(borrador);
				document.getElementById("form_borrador").action = "elaborar_borrador.php?opcion=addha&id="+id;
				document.getElementById("form_borrador").submit();
        }
			
    }
}

function validar_justificacion(id){
	
        if($("#comentario").val()==''){
			alert("ERROR: Por favor ingrese un comentario");
		}else{
         if(valida_archivos(2)){
             if($("#tipo").val()==1){
                document.getElementById("form_justificacion").action = "proponer_archivar_derivar.php?opcion=addhd&id="+id;
             }
             else{
				document.getElementById("form_justificacion").action = "proponer_archivar_derivar.php?opcion=addha&id="+id;
             }
             document.getElementById("form_justificacion").submit();
        }
			
    }
}

function validar_aprobacion(id){
	
        if($("#comentario").val()==''){
			alert("ERROR: Por favor ingrese un comentario");
		}else{
         if(valida_archivos(2)){
			document.getElementById("form_justificacion").action = "aprobar_derivacion_archivo.php?opcion=addha&id="+id;
			document.getElementById("form_justificacion").submit();
        }
			
    }
}


function validar_tramitacion(id){
	
        if($("#comentario").val()==''){
			alert("ERROR: Por favor ingrese un comentario");
		}else{
         if(valida_archivos(2)){
			 document.getElementById("form_justificacion").action = "tramite_pendiente.php?opcion=addha&id="+id;
			document.getElementById("form_justificacion").submit();
        }
			
    }
}

function validar_edicion_borrador(id){
   if(tinyMCE.get('rpt_borrador').getContent()==''){
			alert("ERROR: Por favor ingrese una Respuesta al borrador");
	}
    else{
        document.getElementById("form_borrador").action = "editar_borrador_respuesta.php?opcion=editrpta&idb="+id;
        document.getElementById("form_borrador").submit();
    }
}

function mostrar_confirmacion(){
 
	var acc = $("#accion_borrador").val();
         
	if(acc!=6&&acc!=35&&acc!=36){
		$("#conf_usuario").html($("#usuario option:selected").text());
		
		if($("#copia").is(':checked'))
			$("#conf_categoria").html("Copia");
		else
        	$("#conf_categoria").html("Original");			
			
		$.blockUI({ message: $('#question'), css: { width: '275px' } });
	}else{
		AbrirBorradorRespuesta($("#id_doc").val(),$("#tipo").val());
	}		
}

function AbrirBorradorRespuesta(id,tipo){
	$.unblockUI();
	var acc = $("#accion_borrador").val();
	var usu = "";
    var cat = "";
    var url = "";

		if(acc!=24&&acc!=7&&acc!=29&&acc!=35&&acc!=36&&acc!=6){
			usu = $("#usuario").val();	
			cat	= $("input[name='categoria']:checked").val();
			url = "elaborar_borrador.php?id="+id+"&usu="+usu+"&acc="+acc+"&cat="+cat;	
			AbrirPopUp(url,'archivo',850,640);
		}else{
			if(acc==6)
				ArchivarDocumento(id,1);
			else{
				if($("#copia").is(':checked'))
					alert("Esta accion solo se puede realizar con el documento Original");
				else{                
					if(acc!=35&&acc!=36&&acc!=7){
						cat	= $("input[name='categoria']:checked").val();
						url = "proponer_archivar_derivar.php?id="+id+"&acc="+acc+"&cat="+cat;	
						AbrirPopUp(url,'archivo',560,350);
					}else{
						if(acc==7){
							url = "tramite_pendiente.php?id="+id+"&acc="+acc;	
							AbrirPopUp(url,'archivo',560,350);
						}else{
							/*if(tipo==1){
								cat	= $("input[name='categoria']:checked").val();
								url = "proponer_archivar_derivar.php?id="+id+"&acc="+acc+"&cat="+cat+"&tipo=1";	
								AbrirPopUp(url,'archivo',560,350);
							}else{*/
								cat	= $("input[name='categoria']:checked").val();
								AprobarArchivarDerivar(id,acc,cat);												
							//}
						}
					}
				}
			}
		}		
}

function AprobarArchivarDerivar(id,acc,cat){
    //location.href="atencion_acceso_registro.php?opcion=aprobar&id="+id+"&accion="+acc;
	url = "aprobar_derivacion_archivo.php?id="+id+"&acc="+acc+"&cat="+cat;	
	AbrirPopUp(url,'aprobar',620,380);
}

function pasarVariables(pagina, nombres, valores) {
	pagina +="?";
	nomVec = nombres.split(",");
	valVec = nombres.split(",");
	for (i=0; i<nomVec.length; i++)
	pagina += nomVec[i] + "=" + escape(valVec[i])+"&";
	pagina = pagina.substring(0,pagina.length-1);
	return pagina;
}

function recibeVariables(){
	
	cadVariables = location.search.substring(1,location.search.length);
	arrVariables = cadVariables.split("&");
	
	for (i=0; i<arrVariables.length; i++) {
		arrVariableActual = arrVariables[i].split("=");
		alert(arrVariableActual[0]+"='"+unescape(arrVariableActual[1]));
		if (isNaN(parseFloat(arrVariableActual[1])))
		eval(arrVariableActual[0]+"='"+unescape(arrVariableActual[1])+"';");
		else
		eval(arrVariableActual[0]+"="+arrVariableActual[1]+";");
	}	
}

function ArchivarDocumento(id,tipo){
	var url = "archivar_documento_comentario.php?id="+id+"&cat="+$("#cat").val()+"&tipo="+tipo;
	AbrirPopUp(url,'archivo',550,300);
}

function DevolverDocumento(id){
	var url = "devolver_documento_comentario.php?id="+id;
	AbrirPopUp(url,'devuelto',400,250);
}

function listarAreas(id_area){
	
	/***Para navegadores primitivos...que guardan TODO en la cache :)**/

    $.ajax({
      type: "POST",
      url: "Ajax/Ajax.php",
	  cache: false,
      data: "metodo=cargar_areas&areas="+id_area,
      dataType: "xml",
      success: function(xml){
   	   // alert("Y ahora se van a listar las areas");
		$("#destino").html("");
        $(xml).find('option').each(function(){
            var id = $(this).attr('value');
            var name = $(this).text();
            $("#destino").append('<option value="'+id+'">'+name+'</option>');
        });
      }
    });
}

function listarUsuariosArea(id_area,url){	
	
    $.ajax({
      type: "POST",
      url: url,
	  cache: false,
      data: "metodo=cargar_usuarios_area&areas="+id_area,
      dataType: "xml",

      success: function(xml){
		//alert("Y ahora se van a listar los usuarios");
        $("#destino").html("");
        $(xml).find('option').each(function(){
            var id = $(this).attr('value')
            var name = $(this).text();
            $("#destino").append('<option value="'+id+'">'+name+'</option>');
//			alert(name);
        });
      }
   });
}

function mostrarDetalle(id){
    $("#borrador"+id).toggle("fast");
    $("#detalle"+id).slideToggle("slow");
}

function verDetalleDoc(){

	$("#detalle_documento").slideToggle("slow");

	if($("#control").attr("class")=="v"){
        $("#control").text("Ocultar Detalles");
        $("#control").removeAttr("class");
        $("#control").attr("class","o");
    }else{
        $("#control").text("Ver Detalles");
        $("#control").removeAttr("class");
        $("#control").attr("class","v");
    }
}

function imprimir(direccion){
	alert(direccion);
	window.open(direccion,'nada','width=380,height=520,resizable=no,scrollbars=no,toolbar=no,status=no,top=5000');

}

function finalizar_documento(ids,id){
	url = "atencion_acceso_registro.php?opcion=fin&id="+ids+"&borrador="+id;
    window.opener.location.href=url;
    //Cerramos el popup
    var padre=window.self;
    padre.opener = window.self;
    padre.close();
}

function habilitar_finalizar(){

	if($("#mantenimientod")!=null){
		var filas = document.getElementById("mantenimientod").rows.length;
		if(filas<2){
			$("#mantenimientod").css("display","none");
		}
	}
}

function deshabilita_asunto(id){
    if(document.getElementById("asunto")){
		$("#asunto").attr("disabled","disabled");
		$("#asunto").attr("class","disabled");
		$("#editar_guardar_asunto").html("<a href='javascript:editar_asunto("+id+")'><img src='public_root/imgs/b_edit.png' border='0'/></a>");
		$("#editar_guardar_asunto").css("display","block")
	}
}

function habilita_asunto(){
	if(document.getElementById("asunto")){
		$("#asunto").removeAttr("disabled");
		$("#asunto").removeAttr("class");
	}
}

function deshabilita_prioridad(id){
    $("#cboprioridad").val(id);
    cambia_saldo(id);
    if(document.getElementById("cboprioridad")){
		$("#cboprioridad").attr("disabled","disabled");
		$("#cboprioridad").attr("class","disabled");
	}
}

function habilita_prioridad(){
    if(document.getElementById("cboprioridad")){
		$("#cboprioridad").removeAttr("disabled");
		$("#cboprioridad").removeAttr("class");
	}
}

function deshabilitado(){
	if(document.getElementById("original")){
		$("#original").attr("disabled","disabled");
		$("#original").attr("class","disabled");
	}
}

function habilitado(){
	if(document.getElementById("original")){
		$("#original").removeAttr("disabled");
		$("#original").removeAttr("class");
	}
}

function habilita_copia(){    
    if(document.getElementById("copia")){
		$("#copia").removeAttr("disabled");
		$("#copia").removeAttr("class");
	}
}

function deshabilita_copia(){    
	if(document.getElementById("copia")){
		$("#copia").attr("disabled","disabled");
		$("#copia").attr("class","disabled");    
	}   
		
}

function processReqChange() {

    var result = document.getElementById("result");

    if (request.readyState == 4) {
        if (request.status == 200) {
            result.innerHTML = request.responseText;
        }
    } else {
        result.innerHTML = "Buscando Usuarios Existentes...";
    }
}

function cargar(Obj){
		Obj.focus()
}

function nuevoAjax(){

	var xmlhttp=false;
	
	try {

   		// Creaci?n del objeto ajax para navegadores diferentes a Explorer
	   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
	   // o bien
   try {
     // Creaci?n del objet ajax para Explorer
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (E) {
     xmlhttp = false;
   }
  }

  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
  }

	return xmlhttp;
}

function valida(){

	if(document.f1.usuario.value==""){
		alert("ERROR: Por favor ingrese Usuario");
		document.f1.usuario.focus();
		return false();
	}else if(document.f1.password.value==""){
		alert("ERROR: Por favor ingrese Password");
		document.f1.password.focus();
		return false();
	}

	document.f1.action='validacion.php';
	document.f1.submit();
}


function validar_usuarios(opcion, id){

	if(document.f1.nombre.value==""){
		alert(" ERROR: Por favor ingrese el nombre ");
		document.f1.nombre.focus();
		return false

	}else if(document.f1.apellidos.value==""){
		alert(" ERROR: Por favor ingrese el apellido ");
		document.f1.apellidos.focus();
		return false
	}else if(document.f1.email.value==""){
		alert(" ERROR: Por favor ingrese el email ");
		document.f1.email.focus();
		return false
	}else if(document.f1.rol.value==""){
		alert(" ERROR: Por favor Seleccione un rol ");
		document.f1.rol.focus();
		return false
	}else if(document.f1.usuario.value==""){
		alert(" ERROR: Por favor ingrese un admin \n que le servira para logearse en el sistema ");
		document.f1.usuario.focus();
		return false
	}else if(document.f1.password.value==""){
		alert(" ERROR: Por favor ingrese el password \n que le servira para ingresar al sistema ");
		document.f1.password.focus();
		return false;
	}else{
		document.f1.action='usuarios.php?opcion='+opcion+'&id='+id;
		document.f1.submit();
}
}

function mantenimiento_categoria(url,opcion,id1,id){

	if(opcion!="deletep" && opcion!="deletec"){
		location.replace(url+'?id='+id+'&opcion='+opcion+'&id1='+id1);
	}else if(opcion=="delete"){
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;
		}else{
			location.replace(url+'?id='+id+'&opcion='+opcion+'&id1='+id1);
		}
	}
}

function mantenimiento(url,id,opcion){

	if(opcion!="delete"){
		location.replace(url+'?id='+id+'&opcion='+opcion);
	}else if(opcion=="delete"){
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;
		}else{
			location.replace(url+'?id='+id+'&opcion='+opcion);
		}
	}
}

function mantenimiento_det(url, id1){
	location.replace(url+'?id1='+id1);
}

function validar_delete(){

	if(!confirm("Esta Seguro que desea Eliminar el Registro")){
		return false;
	}else{
		return true;
	}
}

function doRound(x, places) {

  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);

}

function removerDiv(HijoE){

	$("#"+HijoE).fadeOut('slow', function() { $(this).remove();});

}

function mantenimiento_det(url, id1){

	location.replace(url+'?id1='+id1);

}

function delete_escaneo(){

	var f1 = eval("document.fe");
	$("#msg_delete").hide();

	if(f1.qdocumento.length > 0){
		for(var i=0; i < f1.qdocumento.length; i++){
			if(f1.qdocumento[i].checked == 1){
				var id = f1.qdocumento[i].value;
				$(".escaneo" + id).fadeOut('slow');
				$("#msg_delete").load("delete_escaneo.php?id="+id).fadeIn("slow");
			}
		}
	}else{
		if(f1.qdocumento.checked == 1){
			var id = f1.qdocumento.value;
			$(".escaneo" + id).fadeOut('slow');
			$("#msg_delete").load("delete_escaneo.php?id="+id).fadeIn("slow");
		}
	}
}

function valida_archivos(tipo){
	var tot=0;
	if(tipo==1){
		var f1 = eval("document.form_borrador");
		if(document.form_borrador.elements['doc[]'])
		tot	= document.form_borrador.elements['doc[]'];
	}
	else{
		if(tipo==2){
			var f1 = eval("document.form_justificacion");
			if(document.form_justificacion.elements['doc[]'])
			tot	= document.form_justificacion.elements['doc[]'];		
		}
		else{
			var f1 = eval("document.fe");
			if(document.fe.elements['doc[]'])
			tot	= document.fe.elements['doc[]'];
		}
	}
	if(tot.length > 0){
		for(var t = 0; t < tot.length; t++){
			if(tot[t].value == ""){
				if(tipo>0){
					tot[t].remove();
				}else{
					alert(" Ingrese la ruta del archivo a subir ");
					tot[t].focus();
					return false;
				}
			}
		}
	}else if(tot.value == ""){
		if(tipo>0){
			return true;
		}
		alert(" Ingrese la ruta del archivo ");
		tot.focus();
		return false;
	}
	if(tipo>0)
		return true;
	else
		f1.submit();
}


function checkTheKey(keyCode){
	if(event.keyCode==13){
		valida();
		return true ;
	}
	return false ;
}


var theObj="";

function toolTips(text,me){

	   theObj=me;
       theObj.onmousemove=updatePos;
       document.getElementById('toolTipBox').innerHTML=text;
       document.getElementById('toolTipBox').style.display="block";
       window.onscroll=updatePos;
}

function updatePos() {

       var ev=arguments[0]?arguments[0]:event;
       var x=ev.clientX;
       var y=ev.clientY;
       diffX=24;
       diffY=0;
       document.getElementById('toolTipBox').style.top  = y-2+diffY+document.body.scrollTop+ "px";
       document.getElementById('toolTipBox').style.left = x-2+diffX+document.body.scrollLeft+"px";
       theObj.onmouseout=hideMe;
}

function hideMe() {
	document.getElementById('toolTipBox').style.display="none";
}

num_cp = 0;

function crearCarchivo(tipo){

    if(tipo==1){
        var tot_atrib = document.form_borrador.elements['doc[]'];
    }else{
		if(tipo==2){
        	var tot_atrib = document.form_justificacion.elements['doc[]'];
	    }else{
        	var tot_atrib = document.fe.elements['doc[]'];
		}
    }
	if(typeof tot_atrib == 'undefined'){
		var tota = 0;
	}else if(tot_atrib.value == ""){
		var tota = 1;
	}else{
		var tota = tot_atrib.length;
	};

	
	if(tipo>0){
        $(".ileft_img").append("<div id='cp_item_"+ tota + "' class='desc' ></div>");                            
        $("#cp_item_"+ tota).append("<input type='file' id='doc[]' name='doc[]' size='39' />");
    }else{
        $(".ileft_img").append("<div id='cp_item_"+ tota + "' class='desc'></div>");
        $("#cp_item_"+ tota).append("<label for='imagen' class='Estilo22'>Documento :</label><input type='file' id='doc[]' name='doc[]' size='40' />");
    }
	$("#cp_item_"+ tota).fadeIn("slow");    
    num_cp ++;
}

function quitarCarchivo(tipo){
	
	if(tipo==0)
		var tot_atrib = document.fe.elements['doc[]'];
	else{
		if(tipo==2)
			var tot_atrib = document.form_justificacion.elements['doc[]'];
		else
			var tot_atrib = document.form_borrador.elements['doc[]'];
	}
	
	if(typeof tot_atrib == 'undefined'){
		var tota = 0;
	}else if(tot_atrib.value == ""){
		var tota = 0;
	}else {
		var tota = parseInt(tot_atrib.length - 1);
	}

	var div = "cp_item_"+ tota;
    if(tipo>0){
        $("#"+div).fadeOut('slow', function() { $(this).remove();});
    }else{
        removerDiv(div);
    }
	
	num_cp--;

}

function AbrirPopUp(url, title, ancho, alto){
	cuerpo = centrar_popup(ancho,alto);	
	window.open(url,title,cuerpo);	
}

function centrar_popup(ancho,largo){

	strwp=cuerpoventana(ancho,largo,'');
	return strwp;
}

function cuerpoventana(ancho,largo,scrll){
	if (scrll==''){
		scrll=1;
	}
	
  screen_height = screen.height-100;
  screen_width = screen.width-10;
  left_y = parseInt(screen_width / 2) - parseInt(ancho / 2); 
  top_x = parseInt(screen_height / 2) - parseInt(largo / 2); 

 	strwp="toolbar=0,location=0,statusbar=0,menubar=0,resizable=0,";
	s="scrollbars="+scrll;
	w="width="+ancho;
	h="height="+largo;
	l="left="+left_y;
	t="top="+top_x;
	c=",";
	strwp="'"+strwp+s+c+w+c+h+c+l+c+t+"'";
	return strwp;
}

function cerrar_popups(){
	if (confirm("Esta seguro que desea salir?")) {
		var padre=window.self;
		padre.opener = window.self;
		padre.close(); 
	}
}

function eliminar_sesion(){
	location.replace('salir.php');
}

function removerDiv(HijoE){
	$("#"+HijoE).fadeOut('slow', function() { $(this).remove();});
}

function VerSubMenu(){	
	$("#submenu").slideToggle("medium");

	if($("#admin").attr("class")=="item cerrado"){
		$("#admin").removeAttr("class");
		$("#admin").attr("class","item abierto");
	}else{
		$("#admin").removeAttr("class");
		$("#admin").attr("class","item cerrado");
	}
}

function ver_busqueda_avanzada(){
	$("#busqueda_avanzada").slideToggle("medium");
}

function convierteFecha(fecha){
	if(fecha!=null){
	fechar=fecha.split('/');
	return fechar[1]+"/"+ fechar[0]+"/"+fechar[2];
	}else
		return '';
}

function deshabilita_boton(elemento){
	$(elemento).attr("disabled","disabled");	
}

function deshabilita_elemento(elemento){
	$(elemento).attr("disabled","disabled");
	$(elemento).attr("class","disabled");
}

function habilita_elemento(elemento){
	$(elemento).removeAttr("disabled");
	$(elemento).removeAttr("class");
}

function ver_mas_adjuntos(ref){	
	var celda=$(ref).parent().parent();
	var adjuntos = $(celda).find(".doc_adjuntos");	
	$(adjuntos).slideToggle('slow');
}
 
function mostrar_word(){	
	
	if($("#ver_mas").attr("class")=="oculto"){
		cargarDIV("word_borrador.php","#word");
		$("#ver_mas").text("Respuesta");
		$("#ver_mas").attr("class","visto");		
	}else{
		$("#ver_mas").text("Ver Mas");
		$("#ver_mas").attr("class","oculto");
		tinyMCE.execCommand('mceRemoveControl', false, 'rpt_borrador');
		$("#word").html("");
	}	
}

function cargarDIV(url,div){

	$.ajax({
        url: url,
		type: "POST",
		data:"",
        async:false,
        contentType: "application/x-www-form-urlencoded",
        dataType: "html",
        error: function(objeto, quepaso, otroobj){
              alert("Pasó lo siguiente: "+quepaso);
        },
        global: true,
        ifModified: false,
        processData:true,
        success: function(datos){			
			$(div).html("");			
			$(div).html(datos);
			tinyMCE.execCommand('mceAddControl', false, 'rpt_borrador');
        },
        timeout: 3000       
	});
}

function agrega_item(contenedor,molde,limpia){
	_item = $(contenedor).find(molde);
	nuevo = $(_item).clone();
	
	$(nuevo).removeAttr("id");

	if(limpia)
		$(nuevo).find(":text").val(""); //Limpiamos los inputs
	$(nuevo).find(".no_se_copia").html(""); //Ponen en blanco lo que no se copia
		
	$(contenedor).fadeIn('slow', function() { $(contenedor).append(nuevo);});
	
	return nuevo;
}

function quita_item(_item, minimo, clase_item, nombre_primero){
	contenedor = $(_item).parent();
	items = $(contenedor).find(clase_item);
	
	if(items.length > minimo)
		$(_item).fadeOut('slow', function() { 
			$(this).remove();
			items_n = $(contenedor).find(clase_item);	
			//ponemos al primero siempre "primero"
			var primero = items_n[0];
			$(primero).attr("id",nombre_primero);
		});
	else
		alert("Ya no puede seguir eliminando");	
	
}

function agrega_item_borrador(disparador){	
	fila = $(disparador).parent().parent().parent(); //Fila
	contenedor = $(fila).find(".contenedor");	
	agrega_item(contenedor,"#primero",true);
}

function quita_item_borrador(disparador){
	
	_item = $(disparador).parent().parent();
	
	if($(_item).attr("class") != "item") //para la tabla
		_item = $(_item).parent().parent();
		
	quita_item(_item, 1,".item", "primero");
		
}

function agrega_documento_finalizado(disparador){
	contenedor = $(disparador).parent().parent().parent().parent().parent();
	nuevo = agrega_item(contenedor,"#primer_fin",false);
	//Guardar en la BD
	form = nuevo.find("#form_documento_fin_imprimir");
	agrega_validacion_finalizado(form);
}

function quita_item_finalizado(disparador){
	_item = $(disparador).parent().parent().parent().parent();
	quita_item(_item, 1,".item_fin","primer_fin");
}
