<?
require_once("../includes.php");
//If you use a php >= 5 this file is not needed
 ini_set('display_errors', 1);
$get = (object) $_GET;
if( $get->ubi){
    
    $sql = "
        SELECT
            CONCAT(u.nombre_usuario,' ',u.apellidos_usuario) as nombres,
            u.login_usuario
        FROM usuarios  u
        WHERE 
            u.id_area = '$get->ubi'
		ORDER BY
			u.nombre_usuario
    ";
    $q = new Consulta($sql);
}

// return the formated data
echo json_encode( $q->getRows() );
?>