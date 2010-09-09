<?php 

class Remitente{
	
	var $_id;
	var $_nombre;
	var $_abreviatura;
	var $_tipo;
	
	function Remitente($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM remitentes WHERE id_remitente = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre 	= $row['nombre_remitente'];
				 $this->_abreviatura= $row['abreviatura_remitente'];
				 $this->_tipo	 	= $row['tipo_remitente'];
			}
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}
	
	function getAbreviatura(){
		return $this->_abreviatura;
	}	
	
	function getTipo(){
		return $this->_tipo;
	}	
}
?>