
//VARIABLES GLOBALES/////////////////////////
var MiBrowWind=false

var isNS4 = (navigator.appName=="Netscape")?1:0;

/////////////////// procesos globales ///////////////////

window.focus()
if (window != window.top)
window.status==true;

function CabinarEstado(estado){
	window.status=estado;
}

function verificaru(indc){
	if (indc==0){
			window.history.go(-1);
			alert("Acceso Denegado Clave Incorrecta Vuela a Intentar...!");
	}else{
		alert("Exeso de Numero de Intentos Permitios Para el Acceso,!!");
		top.close();
	}
}

							
function Cerrar_Session(){

}



function RetrocederPag(){
		window.history.back()
}

function AvanzarPag(){
		window.history.forward(1)
}

function CerarPag(){
	
}


function IngresoNumero(obj){
	var entero=false;
	if((obj.value)-(Math.round(obj.value,2))==0)	{
		entero=true ;
	}else{
		entero=false;
	}

	if(event.keyCode >47 && event.keyCode <58)  {
		event.returnValue=true;
	}else{
		if ((event.keyCode == 13 || event.keyCode == 46) && entero==true){
			event.returnValue=true;
		}else{
			event.returnValue=false;			
		}
	}
}


function ValidCode(obj){
		/*if ((event.keyCode >=32 && event.keyCode<=47) ||  event.keyCode == 32 || event.keyCode == 255  || event.keyCode ==160 || event.keyCode == 61){						event.returnValue=false;	
		event.returnValue=false;
		}else{
		event.returnValue=true;
		}*/
}

function Calculadora(obj){
	cuerpo = cuerpoventana(288,383,'auto');
	window.open(obj.href, obj.target,cuerpo )
}




function Close(){
	top.close()
}



function ventanaAyuda(){
  cuerpo = centrar_popup(420,305);
  window.open("/siganp/ayuda.php","Ayuda",cuerpo);	
}


function FullScreen(){
	window.moveTo(0,0);
	if (document.all) {
		top.window.resizeTo(screen.availWidth,screen.availHeight);
	}else if (document.layers||document.getElementById) {
		if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
			top.window.outerHeight = screen.availHeight;
			top.window.outerWidth = screen.availWidth;
		}
	}
	window.focus()
}


function ResizeScreen(){
	
}



function prueba(){
	alert("Si esta enlazado")	
}

function cerrar_popups(){
	if (typeof MiBrowWind.document == "object") {
		MiBrowWind.close()
	}
}

function centrar_popup(ancho,largo){
	strwp=cuerpoventana(ancho,largo,'');
	return strwp;
}

function cuerpoventana(ancho,largo,scrll){
	if (scrll==''){
		scrll=1;
	}
	
  screen_height = screen.height;
  screen_width = screen.width;
  left_y = parseInt(screen_width / 2) - parseInt(ancho / 2); 
  top_x = parseInt(screen_height / 2) - parseInt(largo / 2); 
  
 	strwp="toolbar=0,location=0,statusbar=0,menubar=0,resizable=1,";
	s="scrollbars="+scrll;
	w="width="+ancho;
	h="height="+largo;
	l="left="+left_y;
	t="top="+top_x;
	c=",";
	strwp="'"+strwp+s+c+w+c+h+c+l+c+t+"'";
	return strwp;
}

//::::muestra la hora::::
function mueveReloj(){ 
    momentoActual = new Date() 
    hora = momentoActual.getHours() 
    minuto = momentoActual.getMinutes() 
    segundo = momentoActual.getSeconds() 
    str_segundo = new String (segundo) 
    if (str_segundo.length == 1) 
       segundo = "0" + segundo 

    str_minuto = new String (minuto) 
    if (str_minuto.length == 1) 
       minuto = "0" + minuto 

    str_hora = new String (hora) 
    if (str_hora.length == 1) 
       hora = "0" + hora 

    horaImprimible = hora + " : " + minuto + " : " + segundo 
    document.form1.reloj.value = horaImprimible 
    setTimeout("mueveReloj()",1000) 
} 
///////////////
//Define a couple of global variables.
var timerID = null
var timerRunning = false

function stopTimer(){
        //stop the clock
        if(timerRunning) {
                clearTimeout(timerID)
                timerRunning = false
        }
} 

function startTimer(){
     // Stop the clock (in case it's running), then make it go.
    stopTimer()
    runClock()
}

function runClock(){
        //document.clock.face.value = timeNow()
				document.form1.reloj.value = timeNow()
        //Notice how setTimeout() calls its own calling function, runClock().
        timerID = setTimeout("runClock()",1000)
        timerRunning = true
}

function timeNow() {
        //Grabs the current time and formats it into hh:mm:ss am/pm format.
        now = new Date()
        hours = now.getHours()
        minutes = now.getMinutes()
        seconds = now.getSeconds()
        timeStr = "" + ((hours > 12) ? hours - 12 : hours)
        timeStr  += ((minutes < 10) ? ":0" : ":") + minutes
        timeStr  += ((seconds < 10) ? ":0" : ":") + seconds
        timeStr  += (hours >= 12) ? " PM" : " AM"
        return timeStr
}
///////////////fin mostrar hora
///////////////////////////////////////////END FUNCTION GLOBAL//////////////
////////////////////////////////script for index.html///////////////////////
function popup_acceso(){
	if (typeof MiBrowWind.document == "object") {
		MiBrowWind.close()
	}
  cuerpo = centrar_popup(400,200);
  //MiBrowWind= 
  window.open("login.php?SIS=1",'',cuerpo);

}
////////////////////////////////end script index.html///////////////////////
///////////////////////////////script of frm30_mb.php////////////////////////////
function Evaluacion_Key(){
  if (event.keyCode < 48 || event.keyCode > 57){
		event.returnValue = false;
	}
  if (event.keyCode == 13){
		event.returnValue = true;
	}	
}
///////////////////////////////////////////////////////////////////////////
function entrar(src,color_entrada) {
	src.bgColor=color_entrada;
	src.style.cursor="hand";
}

function salir(src,color_default) {
	src.bgColor=color_default;
	src.style.cursor="default";

}

function checkear(control, Obj){
	var obj=document.f1.elements[Obj];	
	if(control.checked==true){		
		for(i=0; i<obj.length ; i++){
			obj[i].checked=1;		
		}
	}else{
		for(i=0; i<obj.length ; i++){
			obj[i].checked=0;		
		}	
	}
}
function activar_modulo(control,Obj,inicio,final ){
	var obj=document.f1.elements[Obj];	
	if(control.checked==true){		
		for(i=inicio; i< final; i++){
			obj[i].checked=1;		
		}
	}else{
		for(i=inicio; i< final; i++){
			obj[i].checked=0;		
		}	
	}
}
///////////////////////////
/////////////////////////////
/// funciones de calendario
//////////////////////////////
var ventanaCalendario=false

function muestraCalendario(raiz,formulario_destino,campo_destino,mes_destino,ano_destino){
	if (typeof ventanaCalendario.document == "object") {
		ventanaCalendario.close()
	}
	ventanaCalendario = window.open(raiz+"calendario/index.php?formulario=" + formulario_destino + "&nomcampo=" + campo_destino,"calendario","width=300,height=300,left=100,top=100,scrollbars=no,menubars=no,statusbar=NO,status=NO,resizable=YES,location=NO")
}

//moverse con las listas de menu;
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function vermas(objDiv, indice){
	
	if(document.getElementById([objDiv + indice]).style.display == "" ){
		document.getElementById([objDiv + indice]).style.display = "none";
		
	}else if(document.getElementById([objDiv + indice]).style.display == "none"){	
		document.getElementById([objDiv + indice]).style.display = "";
	}
}

function validnum(e) { 
	tecla = (document.all) ? e.keyCode : e.which; 
	//alert(tecla)
    if (tecla==8 || tecla==46) return true; //Tecla de retroceso (para poder borrar) 
    // dejar la línea de patron que se necesite y borrar el resto 
    //patron =/[A-Za-z]/; // Solo acepta letras 
    patron = /\d/; // Solo acepta números
    //patron = /\w/; // Acepta números y letras 
    //patron = /\D/; // No acepta números 
    // patron = /[\d.-]/; numeros el punto y el signo -
    te = String.fromCharCode(tecla); 
    return patron.test(te);  
	// uso  onKeyPress="return validnum(event)"
}


function mantenimiento(url, id, opcion){
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

function comparar_cantidad(monto, disponible){		
	//alert("hola "+disponible);
	if(parseFloat(monto.value) > parseFloat(disponible)){
		alert("ERROR: el monto que esta ingresando "+ monto.value +" \n supera el monto disponible "+ disponible ); 
		monto.value="";
		monto.focus();		
		return false;			
	}		
}

function monto_minimo(monto, monto_minimo){		
	//alert("hola "+disponible);
	if(parseFloat(monto.value) < parseFloat(monto_minimo)){
		alert("ERROR: el monto que esta ingresando "+ monto.value +" \n es menor al monto minimo "+ monto_minimo ); 
		monto.focus();
		document.f1.reset();
		return false;			
	}		
}

function comparar_maximo(monto_ingresar, disponible, monto_actual){		
	maximo_permitido=parseFloat(monto_actual)+parseFloat(disponible);
	if(parseFloat(monto_ingresar.value) > parseFloat(maximo_permitido)){
		alert("ERROR: el monto que esta ingresando "+ monto_ingresar.value +" \n supera el monto disponible "+ maximo_permitido ); 
		monto_ingresar.value="";
		monto_ingresar.focus();
		return false;			
	}		
}


ns=document.layers
ie=document.all

function esconde() {
	if(ie) precarga.style.visibility="hidden";
	if(ns) document.precarga.visibility="hide";
}

function Pregardago(v) {
	p=1;
	if (ie) {
		if(document.all.precarga==null){
			p=0;
		}
	}
	
	if(ns){
		if(document.precarga==null){
		p=0;
		}
	}
	
	/*if (p==0){
		document.write('<div id="precarga" align="center" ><img src="../imgs/reloj.gif"><br> Procesando informacion. Por favor Espere...<br></div>');
	}*/
	
	if (v==1){
			if(ie) precarga.style.visibility="visible";
			if(ns) document.precarga.visibility="visible";
	}else{
			if(ie) precarga.style.visibility="hidden";
			if(ns) document.precarga.visibility="hide";
	}
	
}

function valida_fechas(caja)
{ 
   if (caja)
   {  
      borrar = caja;
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
			{
               borrar = '-';
               break;  
			}  
         }
	     if (borrar)
	     { 
	        a = caja.substr(6,4);
		    m = caja.substr(3,2);
		    d = caja.substr(0,2);
		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		       borrar = '-';
		    else
		    {
		       if((a%4 != 0) && (m == 2) && (d > 28))	   
		          borrar = '-'; // Año no viciesto y es febrero y el dia es mayor a 28
			   else	
			   {
		          if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			         borrar = '-';	      				  	 
			   }  // else
		    } // fin else
         } // if (error)
      } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	  else
	     borrar = '-';
	  if (borrar == '-') return false;
	  else return true;
	     
   }
   else return false// if (caja)   
} // FUNCION

function comparar_fechas(Obj1,Obj2) 
{
String1 = Obj1;
String2 = Obj2;
// Si los dias y los meses llegan con un valor menor que 10 
// Se concatena un 0 a cada valor dentro del string 
if (String1.substring(1,2)=="/") {
String1="0"+String1
}
if (String1.substring(4,5)=="/"){
String1=String1.substring(0,3)+"0"+String1.substring(3,9)
}

if (String2.substring(1,2)=="/") {
String2="0"+String2
}
if (String2.substring(4,5)=="/"){
String2=String2.substring(0,3)+"0"+String2.substring(3,9)
}

dia1=String1.substring(0,2);
mes1=String1.substring(3,5);
anyo1=String1.substring(6,10);
dia2=String2.substring(0,2);
mes2=String2.substring(3,5);
anyo2=String2.substring(6,10);


if (dia1 == "08") // parseInt("08") == 10 base octogonal
dia1 = "8";
if (dia1 == '09') // parseInt("09") == 11 base octogonal
dia1 = "9";
if (mes1 == "08") // parseInt("08") == 10 base octogonal
mes1 = "8";
if (mes1 == "09") // parseInt("09") == 11 base octogonal
mes1 = "9";
if (dia2 == "08") // parseInt("08") == 10 base octogonal
dia2 = "8";
if (dia2 == '09') // parseInt("09") == 11 base octogonal
dia2 = "9";
if (mes2 == "08") // parseInt("08") == 10 base octogonal
mes2 = "8";
if (mes2 == "09") // parseInt("09") == 11 base octogonal
mes2 = "9";

dia1=parseInt(dia1);
dia2=parseInt(dia2);
mes1=parseInt(mes1);
mes2=parseInt(mes2);
anyo1=parseInt(anyo1);
anyo2=parseInt(anyo2);

if (anyo1>anyo2)
{
return false;
}

if ((anyo1==anyo2) && (mes1>mes2))
{
return false;
}
if ((anyo1==anyo2) && (mes1==mes2) && (dia1>dia2))
{
return false;
} 

return true;
}

function redondear(cantidad, decimales) {
	var cantidad = parseFloat(cantidad);
	var decimales = parseInt(decimales);
	return Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
} 

function ouput_page(){  
	/*if(document.all) {  
		document.all.barraBotones.style.visibility = 'hidden';  
		window.print();  
		document.all.barraBotones.style.visibility = 'visible';  
	} else {*/  
		document.getElementById('barraBotones').style.visibility = 'hidden';  
		document.getElementById('no_print').style.visibility = 'hidden';  
		window.print();  
		document.getElementById('barraBotones').style.visibility = 'visible';
		document.getElementById('no_print').style.visibility = 'visible';  
	//} 
}
function salida_impresora(){  
	document.getElementById('barraBotones').style.visibility = 'hidden'; 
	document.getElementById('ocultar').style.visibility = 'hidden'; 
	window.print();  
	document.getElementById('barraBotones').style.visibility = 'visible';
}
///////nuevo
function agrega_otro(id){
	alert('intir')
	var filas='';
	var fila=document.f1.cont.value;
	var n=parseInt(document.f1.nro_add.value)+1;
	for(var i=0;i<n;i++){ filas+=fila; }
	//document.getElementById("subp").appendChild(tabla);
	document.f1.nro_add.value=n;
	document.getElementById(id).innerHTML=document.f1.cabez.value+filas+document.f1.pie.value;
}

function inArray(valor,array){
	for (var i=0; i < array.length; i++) {
		if (array[i]==valor) return true;
	}
	return false;
}