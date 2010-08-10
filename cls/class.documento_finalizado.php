<?php 
class DocumentoFinalizado{
	
	var $_id;
	var $_id_documento;
	var $_codigo;
	var $_tipo;
	var $_referencia;
	var $_fecha_finalizado;
	var $_asunto;
	var $_destinatario;
	var $_cargo;
	var $_usuario;

	function DocumentoFinalizado($id = 0 ){
		
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM documento_finalizado WHERE id_documento_finalizado = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				$row = $query->VerRegistro();
				 $this->_codigo 		= $row['codigo_documento_finalizado'];
				 $this->_id_documento	= $row['id_documento'];
				 $this->_tipo 			= new TipoDocumento($row['id_tipo_documento']);
				 $this->_asunto 		= $row['asunto'];
				 $this->_fecha_finalizado = $row['fecha_registro_documento'] ;
				 $this->_usuario	 	= $row['usuario'] ;				 
				 
			}								 				 
		}	
	}
	
	function getId(){
		return $this->_id;
	} 
	
	function getTipoDocumento(){
		return $this->_tipo;
	
	}
	
	function getAsunto(){
		return $this->_asunto;
	}

	function getDestinatario(){
		$sql = "SELECT
				df.id_destinatario_finalizado,
				df.descripcion,
				df.cargo
				FROM
				destinatario_finalizado AS df
				WHERE
				df.id_documento_finalizado =  '$this->_id'";
		
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$destinatarios[] = array(
				'id' 			=>	$row['id_destinatario_finalizado'],
                'descripcion' 	=>	$row['descripcion'],
				'cargo' 		=>	$row['cargo']
			); 
		}
		
		return $destinatarios;
	}
	
	function getCodigo(){
		return $this->_codigo;
	}
	
	function getReferencia(){
		
		$sql = "SELECT
				df.id_referencia_finalizado,
				df.descripcion
				FROM
				referencia_finalizado AS df
				WHERE
				df.id_documento_finalizado =  '$this->_id'";
		
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$referencias[] = array(
				'id' 			=>	$row['id_referencia_finalizado'],
                'descripcion' 	=>	$row['descripcion']
			); 
		}
		
		return $referencias;
	}
	
	function getFechaFinalizado(){
		return date('d-m-Y',strtotime($this->_fecha_finalizado));
	}
}
?>