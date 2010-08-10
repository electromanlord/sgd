<?php 

class ObjetivosEstrategicos{
	
	function ObjetivosEstrategicos(){
		
				
	}
	
	function getObjetivosEstrategicos(){
		
		$result;
		
		$sql = "SELECT * FROM objetivo_estrategico  ";
		$query = new Consulta($sql);
		while($row = $query->ConsultaVerRegistro()){
			$result[] = array(
				'id' => $row['id_objetivo_estrategico'],
				'nombre' => $row['nombre_objetivo_estrategico'],
				'codigo' => $row['codigo_objetivo_estrategico'],
				'indicador' => $row['indicador_objetivo_estrategico'],
				'unidad_medida' => $row['id_unidad_medida']
			);
		}		
		
		return $result;
	}
	
}

?>