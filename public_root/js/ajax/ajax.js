function obj_ajax(){
  	var xmlhttp=false;
	 try {
	  	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	  } catch (e) {
		  try {
		 	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		  } catch (E) {
		  	xmlhttp = false;
		  }
	  }
	  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		  xmlhttp = new XMLHttpRequest();
	  }
	
	if (!xmlhttp) {
         alert('No se pudo crear el Objeto AJAX... Navegator No Soportado');
         return false;
    }
	else return xmlhttp;
}

