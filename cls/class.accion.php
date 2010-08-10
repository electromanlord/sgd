<?php 
class Accion{
	
	var $_id;
	var $_nombre;
    var $_abreviatura;
	var $_descripcion;
    var $_estado;
	
	function Accion($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM accion WHERE id_accion = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre = $row['nombre_accion'];
				 $this->_abreviatura = $row['abreviatura_accion'];
                 $this->_descripcion = $row['descripcion_accion'];
                 $this->_estado = $row['estado_accion'];
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

    function getDescripcion(){
		return $this->_descripcion;
	}

    function getEstado(){
		return $this->_estado;
	}
}
?>