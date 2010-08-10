
<?
require_once("conexion.cls.php")


$query=new Consulta($sql="SELECT
`t`.`id_tarea`,
`t`.`nombre_tarea`,
`aao`.`nom_tarea`,
`aao`.`id_tarea`
from asignacion_anp_objetivos aao, tarea t
where aao.id_tarea=t.id_tarea");
	if ($query->numregistros()){
	while($row=$query->ConsultaVerRegistro()){		
					$sql="UPDATE asignacion_anp_objetivos 
						  SET nom_tarea='".$row['nombre_tarea']."'
								  WHERE id_tarea='".$row[id_tarea]."'";
				}
							 
	
	
	}

?>


