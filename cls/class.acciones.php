<?php 
class Acciones{
	
	function Acciones(){}
	
	function getAcciones($cat,$usu){
		$return;
		$sql = "SELECT
				a.id_accion,
				a.nombre_accion
				FROM
				accion_categoria AS ac
				Inner Join categoria AS c ON c.id_categoria = ac.id_categoria
				Inner Join accion AS a ON ac.id_accion = a.id_accion
				WHERE
				c.id_categoria =  '$cat'  AND
				a.estado_accion = 1 AND 
				ac.id_accion NOT IN  (
				SELECT id_accion
				FROM
				acciones_deshabilitadas_usuario
				WHERE
				id_usuario = '$usu' AND
				c.id_pagina = id_pagina
				)
				ORDER BY nombre_accion
				";

		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' => $row['id_accion'],
				'nombre' => $row['nombre_accion']			
			); 		
			
		}	
		return $return;
	}	
}
?>