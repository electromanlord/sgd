<?
	require_once("../includes.php");   
	header('charset="iso-8859-1"');
		
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
		$met = "cargar_remitentes";
	
		switch($met){
		  case "cargar_remitentes":
					$query = cargar_remitentes();
					?>
						<?php
						 while($row_remitentes = $query->ConsultaVerRegistro()){
						 	echo $row_remitentes['nombre']."|".$row_remitentes['id']."\n";
						 }
						 ?>
					  <?php
					  break;
		}?>
	<?
	

function cargar_remitentes(){

       $sql_remitentes="SELECT 
						id_remitente as id,
						nombre_remitente as nombre
						FROM remitentes 
						WHERE nombre_remitente like '%".strtolower($_GET["q"])."%' 
						AND estado_remitente = 1
						ORDER BY nombre ASC";

        $query_remitentes = new Consulta($sql_remitentes);

        return $query_remitentes;

}

?>