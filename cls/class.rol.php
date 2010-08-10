<?php 

class Rol{
	
	var $_id;
	var $_nombre;
	var $_orden;
	
	function Rol($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM rol WHERE id_rol = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre 	= $row['nombre_rol'];
				 $this->_rol 		= new Rol($row['orden_rol']);
			}
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}
	
	function getOrden(){
		return $this->_orden;
	}
	
	function getMiOrden(){
		
		$sql = "SELECT
				r.orden_rol
				FROM
				rol AS r
				Inner Join usuarios AS u ON r.id_rol = u.id_rol
				WHERE
				u.id_usuario =  '".$_SESSION['session'][0]."'";
		
		$query = new Consulta($sql);
		$row = $query->ConsultaVerRegistro(); 
		return $row["orden_rol"];
	}
	
	function getMiRol(){
		
		$sql = "SELECT
				r.id_rol
				FROM
				rol AS r
				Inner Join usuarios AS u ON r.id_rol = u.id_rol
				WHERE
				u.id_usuario =  '".$_SESSION['session'][0]."'";
		
		$query = new Consulta($sql);
		$row = $query->ConsultaVerRegistro(); 
		return $row["id_rol"];
	}
}
?>