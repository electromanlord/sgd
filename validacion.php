<?php
require_once("includes.php");


if(!isset($_SESSION['session'])){ 
	 
	$valida = Acceso::AccesoValida();

	if($valida==0){
		$msg="ERROR: Usuario o Password Incorrecto ";
		$error=$error+1;
		header("Location: index.php?error=".$error);	
	}else{		
		
		$_SESSION['session'];
		Sesion::SesionLogear($valida); 
		header("Location: index.php");
	}
}else{
	Header("Location: index.php");
}
?>