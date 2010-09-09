<?php 

class Estado{
	
	var $_id;
	var $_nombre;
	var $_abreviatura;
	
	function Estado($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM estados WHERE id_estado = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre 	= $row['nombre_estado'];
				 $this->_abreviatura= $row['abrev_nombre_estado']; 
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