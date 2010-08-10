<?php 
class Sesion{
	
	function SesionLogear($array=""){
		if(isset($array)){	
			if(is_array($array)){				
					$_SESSION['session'][0]=$array[0]['id'];
					$_SESSION['session'][1]=$array[0]['user'];
					$_SESSION['session'][2]=$array[0]['rol'];
					$_SESSION['session'][3]=$array[0]['lectura'];	
					$_SESSION['session'][4]=$array[0]['escritura'];
					$_SESSION['session'][5]=$array[0]['area'];
                    $_SESSION['session'][6]=$array[0]['responsable'];
					$_SESSION['session'][7]=$array[0]['anp'];
					
					$_SESSION['filtro'][0] = '';
					$_SESSION['filtro'][1] = '';
					$_SESSION['filtro'][2] = '';
					$_SESSION['filtro'][3] = '';
					$_SESSION['filtro'][4] = '';
					
			}else{ echo "<br> no es array";}
		}else{			
			Header("Location: index.php");
		}
	}

	function SesionLogeado( $url=""){
		if(isset($_SESSION['session'] )){	
			Header("Location: $url");
		}
	}

	function SesionSiNoLogeado($url=""){
		if(!isset($_SESSION['session'])){	
			Header("Location: $url");
		}
	}

	function SessionDelete( $url=""){
			session_unset();
			session_destroy();		
		header("Location: $url");
	}
}


?>