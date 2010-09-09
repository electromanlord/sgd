<?php

class Borrador{

	var $_id;
    var $_id_documento;
    var $_id_usuario;
    var $_id_destino;
    var $_id_area;
    var $_id_accion;
    var $_categoria;
    var $_fecha;
    var $_decripcion;
    var $_aprobacion;

	function Borrador($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT
                    b.id_borrador_respuesta AS id,
                    b.id_documento AS id_documento,
                    b.id_usuario AS id_usuario,
                    b.descripcion_borrador_respuesta AS descripcion,
                    b.fecha_borrador_respuesta AS fecha,
                    b.categoria AS categoria,
                    b.id_accion AS id_accion,
                    b.id_area AS id_area,
                    b.id_destino AS id_destino,
                    b.aprobacion_respuesta_borrador AS aprobacion
                    FROM
                    borradores_respuesta AS b
                    WHERE
                    b.id_borrador_respuesta =  '$this->_id'";

			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				$row = $query->VerRegistro();

				$this->_id_documento= $row['id_documento'];
                $this->_id_usuario 	= $row['id_usuario'];
                $this->_decripcion 	= $row['descripcion'];
                $this->_fecha       = $row['fecha'];
                $this->_categoria 	= $row['categoria'];
                $this->_id_accion 	= $row['id_accion'];
                $this->_id_area 	= $row['id_area'];
                $this->_id_destino 	= $row['id_destino'];
                $this->_aprobacion	= $row['aprobacion'];
			}
		}
	}

	function getId(){
		return $this->_id;
	}

	function getIdDocumento(){
		return $this->_id_documento;
	}

	function getUsuario(){
		return new Usuario($this->_id_usuario);
	}

    function getDescripcion(){
		return $this->_decripcion;
	}

    function getFecha(){
		return $this->_fecha;
	}

    function getCategoria(){
		return $this->_categoria;
	}

    function getArea(){
		return new Area($this->_id_area);
	}

    function getAccion(){
		return new Accion($this->_id_accion);
	}

    function getAprobacion(){
		return $this->_aprobacion;
	}

    function getDestino(){
		return new Usuario($this->_id_destino);
	}

    function EditarDescripcion($descripcion,$id_fin){

        $sql = "UPDATE borradores_respuesta
                SET descripcion_borrador_respuesta =' $descripcion'
                WHERE id_borrador_respuesta = $this->_id";

       $query_sql = new Consulta($sql);
		
		//Borramos todas las referencias
		$sql_d = "DELETE FROM referencia_finalizado where id_documento_finalizado=".$id_fin;
		$query_d = new Consulta($sql_d);
			
		for($j=0; $j<sizeof($_REQUEST['referencia']);$j++){
			if($_REQUEST['referencia'][$j]){
				$sql = "INSERT INTO referencia_finalizado VALUES('','$id_fin','".$_REQUEST['referencia'][$j]."')";
				$query = new Consulta($sql);
			}
		}
			
		//Borramos todos los destinatarios
		$sql_d = "DELETE FROM destinatario_finalizado where id_documento_finalizado=".$id_fin;
		$query_d = new Consulta($sql_d);
			
		for($j=0; $j<sizeof($_POST['destinatario']);$j++){
			if($_REQUEST['destinatario'][$j]){
				$sql = "INSERT INTO destinatario_finalizado VALUES ('','$id_fin','".$_REQUEST['destinatario'][$j]."','".$_REQUEST['cargo'][$j]."')";
				$query = new Consulta($sql);
			}
		}
		
       $sqlfin =  "UPDATE documento_finalizado
             	   SET asunto = '".$_REQUEST['asunto']."'				   
                   WHERE id_documento=".$this->_id_documento;

       $qfin=new Consulta($sqlfin);

        if($query_sql!=0)
            return true;
        else
            return false;
    }
}
?>