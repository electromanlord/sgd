// JavaScript Document

function validar_requerimiento(opcion, idanp, id, temp){
	var frm=eval('document.f1');
	///////valid datos de cabecera
	if(frm.fecha_solicitud.value==""){
		alert('La Fecha de la Solicitud es Necesaria');
			return false;
	}
	//////////////
	var monto=document.f1.elements['monto[]'];
	var just=document.f1.elements['justificacion[]'];
	
	var total=0;
	if(temp==0){ alert('No puede grabar la Solicitud sin Ninguna Partida Programada'); return false;} 
	
	if(temp==2||temp==3){
		if (monto[0]==null){
			if(monto.value>0){
				if(just.value==""){ 
					alert('Una de las Partidas con Monto Asignado, no tiene Justificacion');
					just.focus(); return false; 
				} 
				//else{ total+=parseFloat(monto.value);}	
			}
		}else{
			for(x=0; x<monto.length; x++){
				if(monto[x].value>0){
					if(just[x].value==""){ 
						alert('Una de las Partidas con Monto Asignado, no tiene Justificacion');
						just[x].focus(); return false;
					} 
				}
			}
		}
	}
	////////tempos
	
	if(temp==1||temp==3){
		var monto_t=document.f1.elements['monto_tempo[]'];
		var just_t=document.f1.elements['justif_tempo[]'];
		if (monto_t[0]==null){
			if(monto_t.value>0){
				if(just_t.value==""){ alert('Una de las Partidas con Monto Asignado, no tiene Justificacion');
					just_t.focus(); return false; }
			}
		}else{
			for(x=0; x<monto_t.length; x++){
				if(monto_t[x].value>0){
					if(just_t[x].value==""){ 
						alert('Una de las Partidas con Monto Asignado, no tiene Justificacion');
						just_t[x].focus(); return false;
					} 
				}
			}
		}
	}
	/////
	
	/*if(total==0){
		alert("ERROR: Ingrese al menos un monto!");
		//monto[0].focus();
		return false;		
	}	*/
	//return false
	var addic="";
	//alert(opcion);
	if(opcion=='update'){ addic="&cmd=Edit";}
	frm.action='requerimientos.php?opcion='+opcion+'&idanp='+idanp+'&id='+id+addic;
	frm.submit();
}

function validar_remesa(idanp){
	if(document.f1.fuente.value=="" || document.f1.mes.value=="" || document.f1.monto.value==""){
		alert('Uno o más Campos estan Vacios');
	}else if(parseFloat(document.f1.monto.value)<=0) {alert('El Campo Remesa tiene una cifra Incorrecta');
	}else if(parseFloat(document.f1.monto.value)>parseFloat(document.f1.monto_partida.value)) {
		alert('El Monto de la Remesa no puede ser Mayor que el Saldo Total Anual ');
	}else{
		document.f1.action="disponibilidad_remesas.php?idanp="+idanp+"&opcion=add";
		//alert("disponibilidad_remesas?idanp="+idanp+"&option=add");
		document.f1.submit();
	}
}

function generar_fecha_rendicion(fecha, ant){ 

    var array_fecha = fecha.value.split("-") 
 
    if (array_fecha.length!=3) 
       return false 

	var ano 
    ano = parseInt(array_fecha[2]); 
    if (isNaN(ano)) 
       return false 

    var mes 
    mes = parseInt(array_fecha[1]); 
    if (isNaN(mes)) 
       return false 

	var new_mes
	if(mes<11){
		new_mes=parseInt(mes+1)
	}else if(mes==12){
		new_mes=1
	}else{
		return false
	}
	
    var dia 
    dia = parseInt(array_fecha[0]); 
    if (isNaN(dia)) 
       return false 
	
	var new_fecha
	new_fecha=dia+"-"+new_mes+"-"+ano;
    ant.value=new_fecha;
} 

function combo_partida(idanp,ids,sba,part){
	if(!confirm("Esta Seguro de Aqregar una Nueva Partida Vacia a la Subactividad ")){
		part.value="";
		//return false
	}
	else{
		//var dir="requerimientos.php?opcion=add_part&idanp="+idanp+"&ids="+ids+"&sba="+sba+"&part="+part.value;
		var dir="requerimientos.php?opcion=add_part&idanp="+idanp+"&ids="+ids+"&sba="+sba+"&part="+part.value+"&cmd=Edit#"+sba;
		//alert(" ---Confirmado--***"+dir);
		document.f1.action=dir
		document.f1.submit();
	}
}

function combo_partida_new(idanp,sba,part){
	if(!confirm("Esta Seguro de Aqregar una Nueva Partida Vacia a la Subactividad... ")){
		part.value="";
		//return false
	}
	else{
		var dir="requerimientos.php?opcion=add_part_new&idanp="+idanp+"&sba="+sba+"&part="+part.value+
					"#"+sba;
		//alert(" ---Confirmado--***"+dir);
		document.f1.action=dir
		document.f1.submit();
	}
}

function valida_just_partida(elem){
	//alert('----'+i);
	if(elem.value==""){
		alert('La Justificación de la Partida es Necesaria');
		elem.focus();
		return false; 
	}
}

function form_solicitud(){
	if(document.f1.idanp.value!=""){
		var xxx = cuerpoventana(750,550,'1');
		MiBrowWind = window.open('reporte_RO-RDR.php?idanp='+document.f1.idanp.value+'&opcion=reg_rep',
							 'VentanaReporte',xxx)
	}
}

function form_solicitud_req(dir){
	var xxx = cuerpoventana(750,550,'1');
	dir='reporte_RO-RDR.php?opcion=reg_rep'+dir;
	//alert('**'+dir);
	MiBrowWind = window.open(dir,'VentanaReporte',xxx)
}

function valida_reporte(idanp){
	if(document.f1.fuente.value=="" || document.f1.mes.value=="" || document.f1.senor.value=="" 
	   || document.f1.direcc.value=="" || document.f1.TpSol.value=="" || document.f1.NroSol .value=="" 
	   || document.f1.FechaSol.value=="") 
	{
		alert("Existen Campos Obligatorios sin llenar en el Formulario");
	}
	else{ 
		/*if(!valida_fechas(document.f1.FechaSol.value)){
			alert('La Fecha de la Solicitud tiene un formato Erroneo');
		}else if(document.f1.fech_rendicion.value!=""){
			if(!valida_fechas(document.f1.fech_rendicion.value)){
				alert('La Fecha de Rendicion tiene un formato Erroneo');
			}
		}else{*/
			document.f1.action="solicitudes.php?idanp="+idanp;
			document.f1.submit();
		//}
	}
}

function valida_monto(mnt,i,sal,tot){
	if(mnt.value==""){
		alert('Por Favor Ingrese un Monto');
		mnt.focus();
		mnt.vcalue='0';
		return false;
	}
	else{
		var m=parseFloat(mnt.value);
		//alert(opc+"--");
		//registrados
		var total_s=0;
		var total_solicitado=0;
		
		//if(opc==2||opc==3){		
			var monto=document.f1.elements['monto[]'];
			if (monto[0]==null){
				total_s+=parseFloat(monto.value);
				total_solicitado+=parseFloat(monto.value);
			}else{
				for(x=0; x<monto.length; x++){	
					if(monto[x].id==i){
						total_s+=parseFloat(monto[x].value);
					}
					total_solicitado+=parseFloat(monto[x].value);
				}
			}
		//}
		
		//temporales
		var total_s_t=0;
		var total_solicitado_t=0;
		//alert ('entro'+opc);
		//if(opc==1||opc==3){
			var monto_t=document.f1.elements['monto_tempo[]'];
			if (monto_t[0]==null){
				total_s_t+=parseFloat(monto_t.value);
				total_solicitado_t+=parseFloat(monto_t.value);
			}else{
				for(x=0; x<monto_t.length; x++){	
					if(monto_t[x].id==i){
						total_s_t+=parseFloat(monto_t[x].value);
					}
					total_solicitado_t+=parseFloat(monto_t[x].value);
				}
			}
		//}
		//detectar monto_solicitado
		var monto_solicitud=0;
		var mnt_sol=document.f1.elements['monto_solicitado'];
				
		if (mnt_sol[0]==null){
			monto_solicitud=mnt_sol;
		}else{
			for(x=0; x<mnt_sol.length; x++){ 
				if(mnt_sol[x].id==i){
					monto_solicitud=mnt_sol[x];
				}
			}
		}
		
		var agreg=1;
		agreg=total_s+total_s_t-tot;
		//alert(total_s+"+"+total_s_t+"-"+tot+"="+agreg);
		
		if(document.f1.remesas.value!='nn'){
			if((total_solicitado+total_solicitado_t)>parseFloat(document.f1.remesas.value)){ 
				alert('El monto es mayor que la Remesa Disponible'); 
				 mnt.focus(); mnt.value="0"; return false;
			}
		}else if(agreg>sal){ 
			alert('El monto es mayor que el Saldo Anual Disponible');
			mnt.focus(); mnt.value="0";  return false; 
		}else{
			
			monto_solicitud.value=total_s+total_s_t;
			document.f1.total_solicitado.value=total_solicitado+total_solicitado_t;
			return true;
		}
	}
}


function valida_monto_original(mnt,i,sal,tot,opc){
	if(mnt.value==""){
		alert('Por Favor Ingrese un Monto');
		mnt.focus();
		mnt.vcalue='0';
		return false;
	}
	else{
		var m=parseFloat(mnt.value);
		//alert(opc+"--");
		//registrados
		var total_s=0;
		var total_solicitado=0;
		
		if(opc==2||opc==3){		
			var monto=document.f1.elements['monto[]'];
			if (monto[0]==null){
				total_s+=parseFloat(monto.value);
				total_solicitado+=parseFloat(monto.value);
			}else{
				for(x=0; x<monto.length; x++){	
					if(monto[x].id==i){
						total_s+=parseFloat(monto[x].value);
					}
					total_solicitado+=parseFloat(monto[x].value);
				}
			}
		}
		//temporales
		var total_s_t=0;
		var total_solicitado_t=0;
		//alert ('entro'+opc);
		if(opc==1||opc==3){
			
			var monto_t=document.f1.elements['monto_tempo[]'];
			if (monto_t[0]==null){
				total_s_t+=parseFloat(monto_t.value);
				total_solicitado_t+=parseFloat(monto_t.value);
			}else{
				for(x=0; x<monto_t.length; x++){	
					if(monto_t[x].id==i){
						total_s_t+=parseFloat(monto_t[x].value);
					}
					total_solicitado_t+=parseFloat(monto_t[x].value);
				}
			}
		}				
		//detectar monto_solicitado
		var monto_solicitud=0;
		var mnt_sol=document.f1.elements['monto_solicitado'];
				
		if (mnt_sol[0]==null){
			monto_solicitud=mnt_sol;
		}else{
			for(x=0; x<mnt_sol.length; x++){ 
				if(mnt_sol[x].id==i){
					monto_solicitud=mnt_sol[x];
				}
			}
		}
		
		var agreg=1;
		agreg=total_s+total_s_t-tot;
		//alert(total_s+"+"+total_s_t+"-"+tot+"="+agreg);
		
		if(document.f1.remesas.value!='nn'){
			if((total_solicitado+total_solicitado_t)>parseFloat(document.f1.remesas.value)){ 
				alert('El monto es mayor que la Remesa Disponible'); 
				 mnt.focus(); mnt.value="0"; return false;
			}
		}else if(agreg>sal){ 
			alert('El monto es mayor que el Saldo Anual Disponible');
			mnt.focus(); mnt.value="0";  return false; 
		}else{
			
			monto_solicitud.value=total_s+total_s_t;
			document.f1.total_solicitado.value=total_solicitado+total_solicitado_t;
			return true;
		}
	}
}

function ventana_reporte(dir){
	var xxx = cuerpoventana(750,550,'1');
	//dir=dir+seleccion.value;
	//alert dir;
	window.open(dir,'VentanaReporte',xxx);
}

function confirma_eliminar(anp,solic,fuente,mes){
	if(!confirm("Esta Seguro que desea Eliminar la Solicitud")){
		return false;	
	}else{
		//alert('eliminado');
		location.replace("requerimientos.php?opcion=delete&idanp="+anp+"&ids="+solic+
						 "&fuente="+fuente+"&mes="+mes);
	}	
}
