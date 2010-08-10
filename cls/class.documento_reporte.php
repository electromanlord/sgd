<?php
class Documento_Reporte{

	var $_id;	
    var $_id_documento;
	var $_codigo;
    var $_numero;
    var $_remitente;
    var $_asunto;
	var $_tipo;
    var $_numero_folio;
    var $_referencia;
    var $_anexo;
    var $_observacion;
	var $_prioridad;	
	var $_fecha_documento;		
	var $_fecha_registro;
	var $_fecha_respuesta;
	var $_estado;
    var $_movimientos;

	function Documento_Reporte($id_documento_reporte){

		$this->_id = $id_documento_reporte;
		if( $this->_id > 0 ){
			$sql = "SELECT 
                    id_documento,
                    numero_registro,
                    numero_documento,
                    remitente,
                    asunto,
                    tipo,
                    folio,
                    referencia,
                    anexo,
                    observacion,
                    prioridad,
                    fecha_documento,
                    fecha_registro,
                    IF( p.tiempo_horas_respuesta_prioridad, 
                        ADDDATE(dr.fecha_registro, 
                            p.tiempo_horas_respuesta_prioridad/24  )
                        , '-')  AS fecha_respuesta,
                    estado
                FROM documentos_reporte dr
                LEFT JOIN prioridades as p ON p.nombre_prioridad = dr.prioridad
                WHERE id_documento_reporte = '".$this->_id."'";
            
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				 $row = $query->VerRegistro();
                 $this->_id_documento   = $row['id_documento'];
				 $this->_codigo         = $row['numero_registro'];
                 $this->_numero         = $row['numero_documento'];
                 $this->_remitente      = $row['remitente'];
                 $this->_asunto         = $row['asunto'];
				 $this->_tipo           = $row['tipo'];
				 $this->_numero_folio   = $row['folio'];
				 $this->_referencia     = $row['referencia'];
				 $this->_anexo		    = $row['anexo'];
				 $this->_observacion    = $row['observacion'];
				 $this->_prioridad      = $row['prioridad'];	
				 $this->_fecha_documento= $row['fecha_documento'];			 				 
				 $this->_fecha_registro = $row['fecha_registro'];
				 $this->_fecha_respuesta= $row['fecha_respuesta'];
                 $this->_estado         = $row['estado'];

				 $sql_movimientos = "SELECT * 
				 					FROM movimientos 
									WHERE id_documento_reporte = '".$this->_id."' 
									ORDER BY fecha_movimiento";
									
				 $query_movimientos = new Consulta($sql_movimientos);
				 while($rowh = $query_movimientos->VerRegistro()){

					$this->_movimientos[] = array(
						'id'            =>	$rowh['id_documento_reporte'],
						'origen'        =>	$rowh['origen'],
						'destino'       =>	$rowh['destino'],
                        'accion'        =>	$rowh['accion'],
                        'categoria'     =>	$rowh['categoria'],
						'usuario'     	=>	$rowh['usuario'],
                        'observacion'   =>	$rowh['observacion'],
						'fecha'         =>	date('d/m/Y H:i',strtotime($rowh['fecha_movimiento'])),
						'estado'        =>	$rowh['estado'],
						'tipo'        =>	$rowh['tipo']
					);
				}
			}
		}
	}

    function getId(){
		return $this->_id;
	}

    function getIdDocumento(){
		return $this->_id_documento;
	}

    function getCodigo(){
		return $this->_codigo;
	}
    
    function getNumero(){
		return $this->_numero;
	}

    function getRemitente(){
		return $this->_remitente;
	}

    function getAsunto(){
		return $this->_asunto;
	}

    function getTipoDocumento(){
		return $this->_tipo;

	}

	function getNumeroFolio(){
		return $this->_numero_folio;
	}
	
	function getReferencia(){
		return $this->_referencia;
	}
	
	function getAnexo(){
		return $this->_anexo;
	}
	
	function getObservacion(){
		return $this->_observacion;
	}

	function getPrioridad(){
		return $this->_prioridad;
	}
	
	function getFechaDocumento(){
		return date('d/m/Y',strtotime($this->_fecha_documento));
	}
	
    function getFechaRegistro(){
		return date('d/m/Y H:i',strtotime($this->_fecha_registro));
	}

    function getFechaRespuesta(){
		return date('d/m/Y H:i',strtotime($this->_fecha_respuesta));
	}

	function getEstado(){
		return $this->_estado;
	}

	function getMovimientos(){
		return $this->_movimientos;
	}
	
	function getComentarioArchivo(){
	
		$sql = "SELECT
				m.observacion AS observacion
				FROM
				movimientos AS m
				WHERE
				m.id_documento_reporte = '".$this->_id."'
				ORDER BY
				m.fecha_movimiento DESC
				LIMIT 0, 1";
				
		$query = new Consulta($sql);	
		$row = $query->VerRegistro();
		return $row["observacion"];
	}
	
	function getEstadoMovimientos(){
		
		$sql = "SELECT
				m.estado AS estado
				FROM
				movimientos AS m
				WHERE
				m.id_documento_reporte = '".$this->_id."'
				ORDER BY
				m.fecha_movimiento DESC,
				m.id_movimiento DESC
				LIMIT 0, 1";
				
		$query = new Consulta($sql);	
		$row = $query->VerRegistro();
		
		$sqle= "SELECT
				id_estado AS estado
				FROM
				estados AS e
				WHERE
				e.nombre_estado = '".$row["estado"]."'";
		
		$querye = new Consulta($sqle);	
		$rowe = $querye->VerRegistro();

		return $rowe["estado"];
	}
}
