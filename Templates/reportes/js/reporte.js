// JavaScript Document

function ver_reporte(id1){
	cuerpo = centrar_popup(750,550)
 	MiBrowWind = window.open("MostrarReporte.php?ID="+id1,'VentanaReporte',cuerpo)
}

function reporte_sinampe(num){
	cuerpo = centrar_popup(750,550)
 	MiBrowWind = window.open("reportes.php?ID="+num,'VentanaReporte',cuerpo)
}


function ver_reporte_x_filtro_infgen(id1, anpid){
	cuerpo = centrar_popup(750,550)
 	MiBrowWind = window.open("MostrarReporteInfGeneral.php?pag=1&ID="+id1+"&anpid="+anpid,'VentanaReporte',cuerpo)
}

function reporte_poa(rep,anpid){
	cuerpo = centrar_popup(600,650)
 	MiBrowWind = window.open("Reportepoa.php?rep="+rep+"&anpid="+anpid,'VentanaReporte',cuerpo)
}

function ver_reporte_x_filtro_infanp(id1, anpid){
	cuerpo = centrar_popup(750,550)
 	MiBrowWind = window.open("ReporteInfAnp.php?ID="+id1+"&anpid="+anpid,'VentanaReporte',cuerpo)
	//MiBrowWind = window.open("objetivosestrategicos.php?ID="+id1+"&anpid="+anpid,'VentanaReporte',cuerpo)

}

function CargarSubActvXFf(cargar){
	document.f1.id_var.disabled=true
	document.f1.submit();
}


function LlamarReporteFichaSB(anpid){
	if (document.f1.id_var.disabled==true){
		alert ("Esta cargando la web...");
		return false;
	}
	document.f1.action="ReporteFichaSubactividad.php?id_anp="+anpid;
	document.f1.submit();
	

}

function mostrar_fisico_financiero(anpid){
	mostrar_reportes(anpid,"fisico_financiero");
}

function mostrar_reportes(anpid,ruta){
	var option = document.forms[0].elements['S2[]']
	var cont=0
	if(option[0]==null){
		if (option.checked==true){
			cont++
		}
	}else{
		
	for (i = 0; i < option.length; i++){
		if(option[i].checked==true){
			cont++
		}
	}
	}
	if (cont>0){
			if(anpid<1){
				document.f1.action=ruta+".php"
								
			}else{
				document.f1.action=ruta+".php?id="+anpid
			}
			
			document.f1.submit();	
	}else{
		alert ("Debe seleccionar por lo menos un Ejecutor");
	}
}

function mostrar_x_ejecutor(){
	//alert(document.f1.ejecutor.value);
	document.f1.action="anp_x_fuente_finan.php?id="+document.f1.ejecutor.value;
	document.f1.submit();
}

function ver_anp_partidamensual(){
	//alert(document.f1.ejecutor.value+"-dddd");
	//if(document.f1.ejecutor.value=="" || document.f1.mes.value=="")	document.f1.anp.disabled=true;
	//else{ 
		document.f1.action="reportes.php?ID=4&eje="+document.f1.ejecutor.value+"&month="+document.f1.mes.value;
		document.f1.submit();
		//document.f1.mostrar.disabled=true;
	//}
}

function activar_ver_partidamensual(){
	//document.f1.mostrar.disabled=false;
}

function mostrar_x_partidamensual(){
	var anp = document.f1.elements['anp[]']
	
	if(document.f1.ejecutor.value==""){
		alert ("Debe seleccionar la Fuente de Financiamiento");
	}
	else if(document.f1.mes.value==""){
		alert ("Debe seleccionar el Mes a Reportar");
	}
	else if(anp[0]==""){
		alert ("Debe seleccionar por lo menos un ANP");
	}
	else{
		document.f1.action=
				"partida_mensual.php?id="+document.f1.ejecutor.value+"&mes="+document.f1.mes.value;
		document.f1.submit();
	}
}

function mostrar_presupuestomensual(anpid){
	mostrar_reportes(anpid,"presupuestomensual");
}

function mostrar_presupuestotrimestral(anpid){
	mostrar_reportes(anpid,"presupuestotrimestral");
}

function mostrar_asignacionporsubactividades(){
	mostrar_reportes(0,"asignacionporsubactividades");
}

function mostrar_asignacionftporsubactividades(){
	mostrar_reportes(0,"asignacionftporsuabctividades");
}

function mostrar_asignacionftporpartidas(){
	mostrar_reportes(0,"asignacionftporpartidas");
}

function mostrar_presupuestoanualporpartidas(anpid){
	mostrar_reportes(anpid,"presupuestoanualporpartidas");
}
function mostrar_presupuestomensualporpartidas(anpid){
	mostrar_reportes(anpid,"presupuestomensualporpartidas");
}
function mostrar_presupuestoporpartidamensual(anpid){
	mostrar_reportes(anpid,"presupuestoporpartidamensual");
}
/////
function mostrar_objetivosestrategicos(anpid){
	mostrar_reportes(anpid,"objetivosestrategicos");
}
function ver_tareas(){
	cuerpo = centrar_popup(750,550)
 	MiBrowWind = window.open("tareas.php",'VentanaReporte',cuerpo)
}
function ver_cargos_anp(){
	cuerpo = centrar_popup(750,550)
 	MiBrowWind = window.open("cargos_anp.php",'VentanaReporte',cuerpo)
}
function ver_tareas_x_anp(){
	var anp = document.f1.elements['lista_anp[]']
	if(anp[0]==""){
		alert ("Debe seleccionar por lo menos un ANP");
	}else{
		document.f1.action="tareas_por_anp.php";
		document.f1.submit();
	}
}
function ver_metas_tareas_x_anp(){
	var ff = document.f1.elements['lista_ff[]']
	var anp = document.f1.elements['lista_anp[]']
	if(anp[0]==""){
		alert ("Debe seleccionar por lo menos un ANP");
	}else if(ff[0]==""){
		alert ("Debe seleccionar por lo menos una Fuente");
	}else{
		document.f1.action="metas_tareas_por_anp.php";
		document.f1.submit();
	}
}

function ver_articulacion_objetivos(){
	var ff = document.f1.elements['lista_ff[]']
	var anp = document.f1.elements['lista_anp[]']
	if(ff[0]==""){
		alert ("Debe seleccionar por lo menos una Fuente");
	}else{
		document.f1.action="articulacion_objetivos.php";
		document.f1.submit();
	}
}


function reporte_objetivos_estrategicos(){
	cuerpo = centrar_popup(600,650)
 	MiBrowWind = window.open("reporte_objetivos_estrategicos.php",'VentanaReporte',cuerpo)
}

function reporte_formato4(){
	//alert("programacion_nivel_indicador.php");
	document.f1.action="programacion_nivel_indicador.php";
	document.f1.submit();
}

function reporte_formato5(){
	document.f1.action="programacion_plan_operativo.php";
	document.f1.submit();
}