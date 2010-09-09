<?php 

class TipoDocumento{
	
	var $_id;
	var $_nombre;
	var $_abreviatura;
	
	function TipoDocumento($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM tipos_documento WHERE id_tipo_documento = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre = $row['nombre_tipo_documento'];
				 $this->_abreviatura = $row['abreviatura_tipo_documento'];
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
}
?>