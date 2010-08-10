<?
class Conexion{
var $link = 0;


var $host ="localhost";
var $user ="areaspro_sistemas";
var $psw  ="AreaProteg2007";
var $db   ="areaspro_dbsiganp1";

/*var $user ="root";
var $psw  ="admin";*/


function Conexion($dbs=""){		
	$this->link=mysql_pconnect($this->host,$this->user,$this->psw) or die(mysql_error() ."error al conectarse al servidor");		
	if($dbs==""){			
		mysql_select_db($this->db,$this->link);		
	}else{
			
		mysql_select_db($dbs,$this->link);		
	}				
		return $this->link;	
	}
}
?>