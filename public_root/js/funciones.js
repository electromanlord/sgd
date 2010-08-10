// JavaScript Document

function distancia_izq(objeto){

	// calula la distancia de un objeto con el lado izquierdo del navegador
	dis_izq = objeto.offsetLeft;
	objeto = objeto.offsetParent;
	
	while (objeto.tagName != 'BODY' && objeto.tagName != 'HTML'){
		dis_izq += objeto.offsetLeft;
		objeto = objeto.offsetParent;
	}
	dis_izq += objeto.offsetLeft;
	return dis_izq;
 }
 
function distancia_sup(objeto){

	// calcula la distancia de un objeto con el lado superior del navegador
 	dis_sup = objeto.offsetTop;
	objeto = objeto.offsetParent;
	
	while (objeto.tagName != 'BODY' && objeto.tagName != 'HTML'){
		dis_sup += objeto.offsetTop;
		objeto = objeto.offsetParent;
	}
	dis_sup += objeto.offsetTop;
	return dis_sup;
 }