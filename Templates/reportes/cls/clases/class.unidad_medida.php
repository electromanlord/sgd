<?php 

class UnidadMedida{
	
	var $id;
	var $nombre;
	var $descripcion; 
	
	function UnidadMedida($id = 0){
				
		$this->id = $id;
		if($this->id > 0){
			$sql =" SELECT * FROM unidad_medida";
			$query = new Consulta($sql);
			if($query->numregistros() > 0){
				$row = $query->ConsultaVerRegistro();
				$this->nombre = $row['nombre_unidad_medida'];
				$this->descripcion = $row['descripcion_unidad_medida'];				
			}
		}		
	}
	
	function getId(){
		return $this->id;
	}

	function getNombre(){
		return $this->nombre;
	}
	
	function getDescripcion(){
		return $this->descripcion;
	}	
}

?>