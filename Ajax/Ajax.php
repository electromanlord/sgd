<?php 
	require_once("../includes.php");   
	header('Content-Type: text/xml; charset="iso-8859-1"');
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';
	//header('Content-Type: text/html; charset="iso-8859-1"'); 
	?>
      <?		
	    if($_REQUEST["metodo"]){
        	$met = $_REQUEST["metodo"];
        }

    switch($met){
      case "cargar_usuarios_area":
                $query = cargar_usuarios();
                ?>
                  <usuarios>
                    <option value="">-Seleccione un Usuario-</option>
                    <?php
                     while($row_usuario = $query->ConsultaVerRegistro()){
                     ?>
                    <option value="<?=($row_usuario["id"])?>">
                      <?=$row_usuario["nombre"]?>
                    </option>
                    <?php
                     }
                     ?>
                  </usuarios>
                  <?php
                  break;

     case "cargar_areas":
                $query = cargar_areas();
                ?>
              <areas>
                <option value="">-Seleccione un Area-</option>
                <?php
                        while($row_usuario = $query->ConsultaVerRegistro()){
                        ?>
                <option value="<?=($row_usuario["id"])?>">
                  <?=$row_usuario["nombre"]?>
                </option>
                <?php
                        } ?>
              </areas>
            <?php
                break;
				
		case "director_area":
                $query = cargar_director_area();
                ?>
              <usuarios>               
                <?php
                        while($row_usuario = $query->ConsultaVerRegistro()){
                        ?>
                <option value="<?=($row_usuario["id"])?>">
                  <?=$row_usuario["nombre"]?>
                </option>
                <?php
                        } ?>
              </usuarios>
            <?php
                break;		
            }
            ?>
    <?php

function cargar_usuarios(){

 $id_areas=$_REQUEST["areas"];

    if ($id_areas){

        $sql_usuario = "SELECT u.id_usuario AS id,
                        concat(u.nombre_usuario,' ',u.apellidos_usuario) AS nombre
                        FROM usuarios AS u 								
                        WHERE u.id_area = $id_areas
								AND u.estado_usuario = 1";

        $query_usuario = new Consulta($sql_usuario);

        return $query_usuario;
    }
}

function cargar_areas(){

 $id_areas=$_REQUEST["areas"];

    if ($id_areas){

        $sql_area = "SELECT a.id_responsable_area AS id
                        , a.nombre_area AS nombre
                        FROM areas_areas r
                        INNER JOIN areas a
                        ON a.id_area = r.id_area_secundaria
                        WHERE r.id_area_primaria =".$id_areas;

        $query_area = new Consulta($sql_area);

        return $query_area;
    }
}

function cargar_director_area(){

 $id_areas=$_REQUEST["area"];

    if ($id_areas){

        $sql_usuario = "SELECT a.id_responsable_area AS id,
								a.nombre_area AS nombre
                        FROM areas a
                        WHERE id_area=$id_areas";

        $query_usuario = new Consulta($sql_usuario);

        return $query_usuario;
    }
}
?>