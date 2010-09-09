<?php 

class Prioridad{
	
	var $_id;
	var $_nombre;
	var $_tiempo_horas_respuesta;
	var $_color;
	
	function Prioridad($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM prioridades WHERE id_prioridad = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre 	= $row['nombre_prioridad'];
				 $this->_tiempo_horas_respuesta= $row['tiempo_horas_respuesta_prioridad'];
				 $this->_color	 	= $row['color_prioridad'];
			}
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}
	
	function getTiempoHorasRespuesta(){
		return $this->_tiempo_horas_respuesta;
	}	
	
	function getColor(){
		return $this->_color;
	}	
}
?>