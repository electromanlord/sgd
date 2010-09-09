<?php include("includes.php"); 
	$id = isset($_GET['id']) ? $_GET['id'] : 0; 
	
	unlink('../sad/Escaneado_completo/'.$_REQUEST["cod"].'/'.$_REQUEST["nom"]);
	

/*
/////////////////////7


        $sql_Big="SELECT id_documento,nombre_documento_escaneado  FROM documentos_escaneados    WHERE id_documento_escaneado = '".$id."' ";
             //   SELECT id_documento,nombre_documento_escaneado  FROM documentos_escaneados    WHERE id_documento_escaneado = '17456'
   $queryB = new Consulta($sql_Big);


$row_reg=$queryB->ConsultaVerRegistro();

$sql2 = " DELETE FROM arch_documentos_escaneados_completos   where id_documento='".$row_reg['0']."' and nombre_documento_escaneado_completo='".$row_reg['1']."' ";
        //DELETE FROM arch_documentos_escaneados_completos   where id_documento='17676'           and nombre_documento_escaneado_completo='big_17687_.pdf'
$query = new Consulta($sql2);




        ///////////////////////////////
*/


        $sql = " DELETE FROM documentos_escaneados WHERE id_documento_escaneado = '".$id."' ";
        $query = new Consulta($sql);
	echo "Se eliminaron correctamente lo(s) documentos escaneados";	
?>