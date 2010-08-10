<?php
class Conexion_Selpo{

	var $link = 0;
	
	//var $host ="www.areasprotegidasperu.com";
	var $host ="localhost";
	//var $user ="areaspro_sistema";
	var $user ="root";
	var $psw  ="root";
	//var $psw  ="AreaProteg2007";
	var $db   ="areaspro_dbsiganp1";

function Conexion_Selpo($dbs=""){		
	
	$this->link_selpo = mysql_connect($this->host,$this->user,$this->psw) or die(mysql_error() ."error al conectarse al servidor");
		
	if($dbs==""){			
		mysql_select_db($this->db,$this->link);		
	}else{
			
		mysql_select_db($dbs,$this->link);		
	}				
		return $this->link_selpo;	
	}	
}
?>
