<?php 
class Anp{
	
	var $_id;
	var $_nombre;
    	var $_siglas;
	
	function Anp($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM areaspro_dbsiganp1.anp WHERE id_anp = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre = $row['nombre_anp'];
				 $this->_siglas = $row['siglas_anp'];
			}
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}
	
	function getSiglas(){
		return $this->_siglas;
	}
}
?>