<?php 
class Documento{
	
	var $_id;
	var $_codigo;
	var $_tipo;
	var $_numero;
	var $_referencia;
	var $_anexo;
	var $_numero_folio;
	var $_fecha;
	var $_fecha_registro;
	var $_asunto;
	var $_observacion;
	var $_prioridad;
	var $_destino;
	var $_remitente;
	var $_estado;
	var $_historial; 
	var $_historiala; 
	var $_borradores_respuesta;
	var $_escaneos;

	function Documento($id = 0 ){
		
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM documentos WHERE id_documento = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				$row = $query->VerRegistro();
				 $this->_codigo 	= $row['codigo_documento'];
				 $this->_tipo 		= new TipoDocumento($row['id_tipo_documento']);
				 $this->_remitente 	= new Remitente($row['id_remitente']);
				 $this->_estado 	= new Estado($row['id_estado']);
				 $this->_prioridad 	= new Prioridad($row['id_prioridad']);
				 $this->_numero	 	= $row['numero_documento'];
				 $this->_asunto 	= $row['asunto_documento'];
				 $this->_referencia = $row['referencia_documento'] ;
				 $this->_anexo 		= $row['anexo_documento'] ;
				 $this->_numero_folio = $row['numero_folio_documento'] ;
				 $this->_fecha 		= $row['fecha_documento'] ;
				 $this->_fecha_registro = $row['fecha_registro_documento'] ;
				 $this->_observacion= $row['observacion_documento'] ;	
                 #Indexes no encontrados en la tabla y reemplazados. by @zazk			 
				 #$this->_destino 	= $row['destino_documento'] ;
				 $this->_destino 	= $row['id_documento'] ;
				 $this->sql 		= "";
				 
				 $sql_historial = "SELECT * FROM historial_documentos WHERE id_documento = '".$this->_id."' ";
				 $query_historial = new Consulta($sql_historial);
				 while($rowh = $query_historial->VerRegistro()){
				 	
					$this->_historial[] = array(
						'id'            =>	$rowh['id_historial_documento'],
						'area'          =>	new Area($rowh['id_area']),
                        #Indexes no encontrados en la tabla y reemplazados. by @zazk
						#'destino'       =>	new Usuario($rowh['id_usuario_destino']),
						'destino'       =>	new Usuario($rowh['id_usuario']),
						'fecha'         =>	$rowh['fecha_historial_documento'] ,
						'original'      =>	$rowh['original_historial_documento'] ,
						'accion'        =>	new Accion($rowh['id_accion']) ,
						'estado'        =>	new Estado($rowh['id_estado']),
                        'observacion' 	=>	$rowh['observacion_historial_documento'],
						'usuario'       =>	new Usuario($rowh['id_usuario'])
					); 
				}
				
				$sql_ahistorial = "SELECT * FROM historial_atencion WHERE id_documento = '".$this->_id."' ";
				 $query_ahistorial = new Consulta($sql_ahistorial);
				 while($rowha = $query_ahistorial->VerRegistro()){
				 	
					$this->_historiala[] = array(
						'id' 		=>	$rowha['id_historial_atencion'],
						'area' =>	new Area($rowha['id_area']),
						'destino' 	=>	new Usuario($rowha['id_usuario_destino']),
						'fecha' 	=>	date('d-m-Y H:i:s',strtotime($rowha['fecha_historial_atencion'])),	
						'original'	=>	$rowha['original_historial_atencion'] ,
						'accion' 	=>	new Accion($rowha['id_accion']) ,
						'estado' 	=>	new Estado($rowha['id_estado']),
						'usuario' 	=>	new Usuario($rowha['id_usuario'])								
					); 
				}				
				
				$sql_br = "SELECT * FROM borradores_respuesta WHERE id_documento = '".$this->_id."' ";
				 $query_br = new Consulta($sql_br);
				 while($rowbr = $query_br->VerRegistro()){
				 	
					$this->_borradores_respuesta[] = array(
						'id' 		=>	$rowbr['id_borrador_respuesta'],
						'fecha' 	=>	$rowbr['fecha_borrador_respuesta'] ,
                        #Indexes no encontrados en la tabla y reemplazados. by @zazk
						#'aprobacion'=>	$rowbr['aprobacion_borrador_respuesta'] ,
						#'fecha' 	=>	$rowbr['vobo_borrador_respuesta'] ,
						'aprobacion'=>	$rowbr['aprobacion_respuesta_borrador'] ,
						'fecha' 	=>	$rowbr['fecha_borrador_respuesta'] ,
						'descripcion'=>	$rowbr['descripcion_borrador_respuesta'] ,
						'usuario' 	=>	new Usuario($rowbr['id_usuario'])								
					); 
				}
				
				$sql_de = "SELECT * FROM documentos_escaneados WHERE id_documento = '".$this->_id."' ";
				 $query_de = new Consulta($sql_de);
				 while($rowde = $query_de->VerRegistro()){
				 				 	
					$this->_escaneos[] = array(
						'id' 		=>	$rowde['id_documento_escaneado'],
						'nombre' 	=>	$rowde['nombre_documento_escaneado']
					);					 
				}

                // Get Categoría
				$sql_dc = "SELECT * FROM documentos_categorias WHERE id_documento = '".$this->_id."' ";
				$query_de = new Consulta($sql_dc);
                $dc = mysql_fetch_object( $query_de->Consulta_ID) ;
                $this->categoria = $dc->categoria;
                
                // Get Expediente if that exist
				$sql_ex = "SELECT codigo_expediente as codigo FROM expedientes WHERE id_documento = '".$this->_id."' ";
				$query_ex = new Consulta($sql_ex);
                $expediente = mysql_fetch_object( $query_ex->Consulta_ID) ;
                $this->expediente = $expediente->codigo;
                
			}
		}	
	}
	
	function getFechaRespuesta(){
		
		$fecha_exacta = strtotime($this->_fecha_registro);		
		$tiempo_extra = ($this->_prioridad->getTiempoHorasRespuesta() * 3600);		
		$fecha_respuesta =  date("d/m/Y H:i",$fecha_exacta + $tiempo_extra); 
		
		return $fecha_respuesta;
	}
	
	function setFechaRespuesta($horas){
		
		$fecha_exacta = strtotime($this->_fecha_registro);		
		$tiempo_extra = ($horas * 3600);		
		$fecha_respuesta =  date("d/m/Y H:i",$fecha_exacta + $tiempo_extra); 
		
		return $fecha_respuesta;
	}	
	
	function getId(){
		return $this->_id;
	} 
	
	function getTipoDocumento(){
		return $this->_tipo;
	
	}
	
	function getEscaneos(){
		return $this->_escaneos;
	
	}	
	
	function getPrioridad(){
		return $this->_prioridad;
	}
	
	function getAccion(){
		return $this->_accion;
	}
	
	function getEstado(){
		return $this->_estado;
	}
	
	function getAsunto(){
		return $this->_asunto;
	}
	
	function getNumero(){
		return $this->_numero;
	}
	
	function getNumeroFolio(){
		return $this->_numero_folio;
	}
	
	function getRemitente(){
		return $this->_remitente;
	}
	
	function getHistorial(){
		return $this->_historial;
	}
	
	function getHistorialAtencion(){
		return $this->_historiala;
	}
	
	function getCodigo(){
		return $this->_codigo;
	}
	
	function getReferencia(){
		return $this->_referencia;
	}
	
	function getAnexo(){
		return $this->_anexo;
	}
	
	function getFecha(){
		return date('d/m/Y',strtotime($this->_fecha));
	}
	
	function getFechaRegistro(){
		return date('d/m/Y',strtotime($this->_fecha_registro));
	}
	
	function getHoraRegistro(){
		return date('H:i:s',strtotime($this->_fecha_registro));
	}
	
	function getFechaCompletaRegistro(){
		return $this->_fecha_registro;
	}
		
	function getBorradoresRespuesta(){
		return $this->_borradores_respuesta;
	}

    function getObservacion(){
		return $this->_observacion;
	}
	
	function isOriginalCopia($original){
		$return;
		if( $original == 1){
			$return = "Original";
		}else{
			$return = "Copia";
		}
		return $return;		
	}
		
	function ActivarDocumento($usuario){
		$sql = "INSERT INTO documentos_usuario VALUES( '".$this->_id."', '".$usuario->getId()."', '','".date('Y-m-d H:i:s')."')";
		$query = new Consulta($sql);		
	}
	
	function getAtencion($usuario, $id_documento){
		if( $usuario->verificarDocumentoAtendido($id_documento) == TRUE ){
			echo "Activado";
		}else{
		  	echo "<a href='".$_SERVER['PHP_SELF']."?opcion=activar&id=".$id_documento."'>Activar</a>";
		}		
	} 	
	
	function AprobarDocumento($com){

      $a_destino = new Area($_SESSION['session'][5]);
		$fecha_actual = time();
		$fecha=date("Y-m-d H:i:s",$fecha_actual);
		
		if($_REQUEST['accion']==35){
			$estado=16;
			$est="AA";
            $esta="ARCHIVO APROBADO";
			$tipo = 4;
			
			/*$sql_atencion ="Insert into archivo 
							values('','".$this->_id."','".$fecha."',
							".$_SESSION['session'][5].",
							".$_SESSION['session'][0].",
							'$com')";*/
			$sql_atencion ="INSERT INTO historial_atencion 
							VALUES('','','".$this->_id."',
							'',
							'".$_SESSION['session'][5]."',
							'".$_SESSION['session'][5]."',
							'".$fecha."',
							'1',
							'".$_REQUEST['accion']."',
							'".$_SESSION['session'][0]."',
							'".$estado."',
							'$com','2')";
											
			/*$u_origen = new Usuario($_SESSION['session'][0]);				
			$a_origen = new Area($_SESSION['session'][5]);
			$origen = $a_origen->getNombre();				*/
			$u_origen = new Usuario($_SESSION['session'][0]);
	        $origen = $u_origen->getNombreCompleto();			
		}else{
			$estado=17;
			$est="DRA";
            $esta="DERIVACION APROBADA";
			$tipo = 4;
			$sql_atencion ="INSERT INTO historial_atencion 
							VALUES('','','".$this->_id."',
							'',
							'".$_SESSION['session'][5]."',
							'".$_SESSION['session'][5]."',
							'".$fecha."',
							'1',
							'".$_REQUEST['accion']."',
							'".$_SESSION['session'][0]."',
							'".$estado."',
							'$com','2')";
							
			//Para el historial de movimientos				
			
			$u_origen = new Usuario($_SESSION['session'][0]);
	        $origen = $u_origen->getNombreCompleto();
		}
				
        $query_atencion = new Consulta($sql_atencion);
        $aten = $query_atencion->NuevoId();
		
		//Para el id del reporte
	    $sqlrep =  "SELECT id_documento_reporte as id
					FROM documentos_reporte
					WHERE id_documento=".$this->_id;
	
		$qrep=new Consulta($sqlrep);
		$rowrep=$qrep->VerRegistro();
  
		$accion = new Accion($_REQUEST['accion']);
        
        $n_destino = $a_destino->getNombre();
        $ubicacion = $a_destino->getAbreviatura();
		
    	//Para el reporte
		$sha_r  =  "Insert INTO
					movimientos values('',
					'".$rowrep['id']."',
                    '".$aten."',
					'".$origen."',
					'".$n_destino."',
					'".$accion->getNombre()."',
					'1',
					'".$u_origen->getLogin()."',
					'$com',
					'".$fecha."',
					'".$esta."',
					'".$ubicacion."',
					'".$tipo."')";
	
		$qha_r =new Consulta($sha_r);

        $s_mov="Update documentos_reporte SET
                ubicacion='".$ubicacion."'
				WHERE id_documento=".$this->_id;
				$qact_mov=new Consulta($s_mov);

        $this->actualizarEstado($estado);
        return $aten;   
	}
	
	function addTramitePendiente(){
		
		$fecha_actual = time();
		$fecha=date("Y-m-d H:i:s",$fecha_actual);
		
		$sql_atencion ="INSERT INTO historial_atencion 
						VALUES('','','".$this->_id."',
                        '".$_REQUEST['user']."',
						'".$_REQUEST['area']."',
						'".$_REQUEST['area']."',
						'".$fecha."',
						'1',
						'".$_REQUEST['accion']."',
						'".$_REQUEST['user']."',
						'18',
						'".$_REQUEST['comentario']."','5')";
		
        $query_atencion = new Consulta($sql_atencion);
        $aten = $query_atencion->NuevoId();
		
		//Para el id del reporte
	    $sqlrep =  "SELECT id_documento_reporte as id
					FROM documentos_reporte
					WHERE id_documento=".$this->_id;
	
		$qrep=new Consulta($sqlrep);
		$rowrep=$qrep->VerRegistro();
		
		$accion = new Accion($_REQUEST['accion']);
        $u_origen = new Usuario($_REQUEST['user']);
        $origen = $u_origen->getNombreCompleto();
        $n_destino = $origen;
        $a_destino = $u_origen->getArea();
        $ubicacion = $a_destino->getAbreviatura()."-".$u_origen->getLogin();
		
		
		$est="TP";
        $esta="TRAMITE PENDIENTE";		
		
		//Para el reporte
		$sha_r  =  "Insert INTO
					movimientos values('',
					'".$rowrep['id']."',
                    '".$aten."',
					'".$origen."',
					'".$n_destino."',
					'".$accion->getNombre()."',
					'1',
					'".$u_origen->getLogin()."',
					'".$_REQUEST['comentario']."',
					'".$fecha."',
					'".$esta."',
					'".$ubicacion."',
					'7')";
	
		$qha_r =new Consulta($sha_r);

        $this->actualizarEstado(18);
        return $aten;   
	}
	
	function addHistorialAtencion(){
		
		$fecha_actual = time();
		$fecha=date("Y-m-d H:i:s",$fecha_actual);
		
        $a_destino = new Area($_REQUEST['area']);

		$sql_atencion ="INSERT INTO historial_atencion 
						VALUES('','','".$this->_id."',
                        '".$a_destino->getIdResponsable()."',
						'".$_REQUEST['area']."',
						'".$_REQUEST['area']."',
						'".$fecha."',
						'".$_REQUEST['categoria']."',
						'".$_REQUEST['accion']."',
						'".$_REQUEST['user']."',
						'".$_REQUEST['estado']."',
						'".$_REQUEST['comentario']."','4')";
		
        $query_atencion = new Consulta($sql_atencion);
        $aten = $query_atencion->NuevoId();
		
		//Para el id del reporte
	    $sqlrep =  "SELECT id_documento_reporte as id
					FROM documentos_reporte
					WHERE id_documento=".$this->_id;
	
		$qrep=new Consulta($sqlrep);
		$rowrep=$qrep->VerRegistro();
  
		$accion = new Accion($_REQUEST['accion']);
        $u_origen = new Usuario($_REQUEST['user']);
        $origen = $u_origen->getNombreCompleto();
        $u_destino = new Usuario($a_destino->getIdResponsable());
        $n_destino = $u_destino->getNombreCompleto();
        $a_destino = $u_destino->getArea();
        $ubicacion = $a_destino->getAbreviatura()."-".$u_destino->getLogin();
		
		if($_REQUEST['estado']==14){
			$est="AP";
            $esta="ARCHIVO PROPUESTO";
		}else{
			$est="DRP";
            $esta="DERIVACION PROPUESTA";
		}
		
		//Para el reporte
		$sha_r  =  "Insert INTO
					movimientos values('',
					'".$rowrep['id']."',
                    '".$aten."',
					'".$origen."',
					'".$n_destino."',
					'".$accion->getNombre()."',
					'".$_REQUEST['categoria']."',
					'".$u_origen->getLogin()."',
					'".$_REQUEST['comentario']."',
					'".$fecha."',
					'".$esta."',
					'".$ubicacion."',
					'4')";
	
		$qha_r =new Consulta($sha_r);

        $s_mov="Update documentos_reporte SET
                ubicacion='".$ubicacion."'
				WHERE id_documento=".$this->_id;
				$qact_mov=new Consulta($s_mov);

        $this->actualizarEstado($_REQUEST['estado']);
        return $aten;   
	}
	
	function addHistorialBorrador(){
		
		$fecha_actual = time();
		$fecha=date("Y-m-d H:i:s",$fecha_actual);
		
        $sql_borrador = "INSERT INTO borradores_respuesta 
						VALUES('','".$this->_id.
						"','','".$_REQUEST['user'].
						"','".$_REQUEST['usuario'].
						"','".$_REQUEST['area']."','".
						$_REQUEST['accion']."','".
						$_REQUEST['categoria']."','".
						$fecha."','".
						$_REQUEST['comentario']."','','".
                        $_REQUEST['adicional']."')";

        $query_borrador = new Consulta($sql_borrador);
        $borr = $query_borrador->NuevoId();

		//Para el id del reporte
	    $sqlrep =  "SELECT id_documento_reporte as id
					FROM documentos_reporte
					WHERE id_documento=$this->_id";
	
		$qrep=new Consulta($sqlrep);
		$rowrep=$qrep->VerRegistro();	
        
		//Obtenermos el ultimo estado
		$sql_e =   "SELECT
					m.estado AS estado
					FROM
					movimientos m
					WHERE
					m.id_documento_reporte =  '".$rowrep['id']."' AND
					m.categoria =  '1'
					ORDER BY
					m.fecha_movimiento DESC
					LIMIT 0, 1";
					
		$query_e = new Consulta ($sql_e);
		$row_e   = $query_e->VerRegistro();

		$accion = new Accion($_REQUEST['accion']);
        $u_origen = new Usuario($_REQUEST['user']);
        $origen = $u_origen->getNombreCompleto();
        $u_destino = new Usuario($_REQUEST['usuario']);
        $n_destino = $u_destino->getNombreCompleto();
        $area_actual = $u_destino->getArea();
		$ubicacion = $area_actual->getAbreviatura()."-".$u_destino->getLogin();
		
		//if($_REQUEST['categoria']==1){			
			$est="B";
            $esta="BORRADOR";
		//}else{
			//$est = $row_e['estado'];
		//}
		
		//Para el reporte
		$sha_r  =  "Insert INTO
					movimientos values('',
					'".$rowrep['id']."',
                    '".$borr."',
					'".$origen."',
					'".$n_destino."',
					'".$accion->getNombre()."',
					'".$_REQUEST['categoria']."',
					'".$u_origen->getLogin()."',
					'".$_REQUEST['adicional']."',
					'".$fecha."',
					'".$esta."',
					'".$ubicacion."',
					'3')";
	
		$qha_r =new Consulta($sha_r);		      			
		
		if($_REQUEST['categoria']==1){

           $s_mov="Update documentos_reporte SET
                   ubicacion='".$ubicacion."'
                   WHERE id_documento=".$this->_id;

            $qact_mov=new Consulta($s_mov);
        	
            $this->actualizarEstado(6);
        }
			
		//Destinatario, Asunto y referencia del documento
		if($this->ExisteFinalizado()){
			$id_fin  = $this->ObtenerIdFinalizado();
			
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
                    	WHERE id_documento=".$id_fin;
						
			$qfin=new Consulta($sqlfin);
						
		}else{
			$sqlfin =  "INSERT into documento_finalizado values
                        ('',null,
						$this->_id,'',
						'".$_REQUEST['asunto']."',					
						null,
						null)";
						
			$qfin=new Consulta($sqlfin);
			
			$id_fin = $qfin->NuevoId();
			
			for($j=0; $j<sizeof($_REQUEST['referencia']);$j++){
				if($_REQUEST['referencia'][$j]){
					$sql = "INSERT INTO referencia_finalizado VALUES('','$id_fin','".$_REQUEST['referencia'][$j]."')";
					$query = new Consulta($sql);
				}
			}	
			
			for($j=0; $j<sizeof($_POST['destinatario']);$j++){
				if($_REQUEST['destinatario'][$j]){
					$sql = "INSERT INTO destinatario_finalizado VALUES('','$id_fin','".$_REQUEST['destinatario'][$j]."','".$_REQUEST['cargo'][$j]."')";
					$query = new Consulta($sql);
				}
			}		
		}		        
					
               
        
		return $borr;       
	}

	function ExisteFinalizado(){
		
		$Sql = "SELECT
				df.id_documento_finalizado
				FROM
				documento_finalizado AS df
				WHERE
				df.id_documento = ".$this->_id;
				
		$query = new Consulta($Sql);
		
		if($query->NumeroRegistros()==0){
			return false;
		}
		else{
			return true;
		}
	}

    function deleteHistorialAtencion($id_historial){

        $sql = "DELETE FROM historial_atencion where id_historial_atencion=".$id_historial;
		$query = new Consulta($sql);
    }
	 
	  /**********************************************************/
		////REEMPLAZAR
	  /**********************************************************/
     function deleteHistorialBorrador($id_historial){
	 
		//Solo le pudo llegar de despacho de area o de otro atencion de documentos
		if($_REQUEST["tipo"]==3){
			$sql2 = "DELETE FROM borradores_respuesta
		             where id_borrador_respuesta=".$id_historial;
			$sst_r="DELETE FROM movimientos where id_historial='".$id_historial."' 
                	AND tipo=3";		 
		}else{
			$sql2 = "DELETE FROM historial_atencion
		             where id_historial_atencion=".$id_historial;
			$sst_r="DELETE FROM movimientos where id_historial='".$id_historial."' 
                	AND tipo=2 OR tipo = 4";			 
		}					
		
		$query2 = new Consulta($sql2);        
        $qt_r=new Consulta($sst_r);
		
		$ultimo_estado = $this->UltimoEstadoMovimientos();
		
		$this->ActualizaUbicacion();
        $this->actualizarEstado($ultimo_estado);

    }
	/**********************************************************/
	////FIN REEMPLAZAR
  /**********************************************************/
	
	function UltimoEstadoMovimientos(){
		$sql = "SELECT
				e.id_estado AS estado
				FROM
				movimientos AS m
				Inner Join estados AS e ON m.estado = e.nombre_estado
				WHERE
				m.id_documento_reporte = ".$this->ObtenerIdReporte()." AND
				m.categoria =  '1'
				ORDER BY
				m.id_movimiento DESC
				LIMIT 0, 1";

        $query = new Consulta ($sql);
        $row = $query->VerRegistro();

        return $row["estado"];		
	}
	
	function UltimoEstadoAntesArchivar(){
		$sql = "SELECT
				e.id_estado AS estado
				FROM
				movimientos AS m
				Inner Join estados AS e ON m.estado = e.nombre_estado
				WHERE
				m.id_documento_reporte = ".$this->ObtenerIdReporte()." AND
				m.categoria =  '1'
				ORDER BY
				m.id_movimiento DESC
				LIMIT 1,1";
		echo $sql;
        $query = new Consulta ($sql);
        $row = $query->VerRegistro();

        return $row["estado"];		
	}

    function ActualizaUbicacion(){
        $s_mov="Update documentos_reporte SET
                ubicacion='".$this->UltimaUbicacionMovimientos()."'
                WHERE id_documento=".$this->_id;
        $qact_mov=new Consulta($s_mov);
    }

    function ActualizaUbicacionArchivo($ubicacion){
        $s_mov="Update documentos_reporte SET
                ubicacion='".$ubicacion."'
                WHERE id_documento=".$this->_id;
        $qact_mov=new Consulta($s_mov);
    }
	
	function UltimaUbicacionMovimientos(){
		
		$sql = "SELECT
				m.ubicacion AS ubicacion
				FROM
				movimientos AS m
				WHERE
				m.id_documento_reporte = ".$this->ObtenerIdReporte()." AND
				m.categoria =  '1'
				ORDER BY
				m.id_movimiento DESC
				LIMIT 0, 1";

        $query = new Consulta ($sql);
        $row = $query->VerRegistro();

        return $row["ubicacion"];		
	}
	
    function UltimaUbicacionReporte(){
        
        $sql = "SELECT
                d.ubicacion AS ubicacion
                FROM
                documentos_reporte AS d
                WHERE
                d.id_documento_reporte = ".$this->ObtenerIdReporte();

        $query = new Consulta ($sql);
        $row = $query->VerRegistro();

        return $row["ubicacion"];
    }

    function getNumeroBorradores(){
        $sql = "SELECT * FROM borradores_respuesta WHERE id_documento = '".$this->_id."'";
        $query = new Consulta($sql);

        return $query->NumeroRegistros();
    }

    function getNumeroBorradoresOriginales(){
        $sql = "SELECT * FROM borradores_respuesta WHERE id_documento = '".$this->_id."'
                AND categoria = 1";
        $query = new Consulta($sql);

        return $query->NumeroRegistros();
    }

    function actualizarEstado($estado){

        $fecha=date("Y-m-d H:i");

        $sql3 = "Update documentos set id_estado=$estado where id_documento= ".$this->_id;
        $sql_hist_doc = "Update historial_documentos set id_estado=$estado  where id_documento = ".$this->_id;
        $sql_hist_ate = "Update historial_atencion set id_estado=$estado where id_documento = ".$this->_id;
		
		$c_estado = new Estado($estado);
		
		$s_ma = "Update documentos_reporte SET estado='".$c_estado->getAbreviatura()."'
                 WHERE id_documento='".$this->_id."'";
			
        $query3 = new Consulta($sql3);
        $query4 = new Consulta($sql_hist_doc);
        $query5 = new Consulta($sql_hist_ate);
		$sma=new Consulta($s_ma);
    }

    function finalizarDocumento($id_borrador){

        //borrador como elegido
       $sql_borr = "Update borradores_respuesta
                    set aprobacion_respuesta_borrador = 1
                    where id_borrador_respuesta= ".$id_borrador;

        //modificar documento
        $sql_doc = "Update documentos set id_estado=12 where id_documento = ".$this->_id;

        //modificar historial_documentos        
        $sql_hist_doc = "Update historial_documentos set id_estado=12 where id_documento = ".$this->_id;

        //modificar historial_atencion        
        $sql_hist_ate = "Update historial_atencion set id_estado=12 where id_documento = ".$this->_id;

		//Reportes documento        
        $sql_reporte = "UPDATE documentos_reporte set estado='F'
						WHERE id_documento = ".$this->_id;

        $query1 = new Consulta($sql_borr);
        $query2 = new Consulta($sql_doc);
        $query3 = new Consulta($sql_hist_doc);
        $query4 = new Consulta($sql_hist_ate);
        $query5 = new Consulta($sql_reporte);
        
    }
	
	function getHistorialBorradores($doc){
	
		$sql_borradores = " SELECT
                            b.id_borrador_respuesta as id,
                            b.id_usuario as usuario,
                            b.id_destino as destino,
                            b.id_area as area,
                            b.id_accion as accion,
                            b.categoria as categoria,
                            b.fecha_borrador_respuesta as fecha,
                            b.descripcion_borrador_respuesta as respuesta
                            FROM
                            borradores_respuesta AS b
                            WHERE
                            b.id_documento = $doc
							order by fecha";
							
				 $query_borradores = new Consulta($sql_borradores);
				 				 
				 while($rowha = $query_borradores->VerRegistro()){
				 	
					$historial_b[] = array(
						'id' 		=>	$rowha['id'],
                        'usuario' 	=>	new Usuario($rowha['usuario']),
						'destino' 	=>	new Usuario($rowha['destino']),
                        'area'      =>	new Area($rowha['area']),
                        'accion' 	=>	new Accion($rowha['accion']),
						'original'	=>	$rowha['categoria'] ,												
						'fecha' 	=>	date('d-m-Y H:i:s',strtotime($rowha['fecha'])),						
						'respuesta'	=>	$rowha['respuesta']						
					); 
				}
				
				return $historial_b;
	}

    function getHistorialHastaBorradores($doc){

        $sql_base = "SELECT
                    ha.id_historial_atencion AS id,
                    ha.id_usuario AS usuario,
                    ha.id_area AS area,
                    ha.id_usuario_destino AS destino,
                    ha.id_area_destino AS area_destino,
                    ha.observacion_historial_atencion AS observacion,
                    ha.fecha_historial_atencion AS fecha,
                    ha.original_historial_atencion AS categoria,
                    ha.id_accion AS accion,
                    ha.tipo_historial_atencion AS tipo
                    FROM
                    historial_atencion AS ha
                    WHERE
                    ha.id_documento =  '$doc' AND
                    ((ha.id_usuario_destino =  '".$_SESSION['session'][0]."' AND ha.tipo_historial_atencion = '0') OR
                    (ha.tipo_historial_atencion >  '1' AND ha.id_area_destino =  '".$_SESSION['session'][5]."'))";

     $query_base = new Consulta($sql_base);
				 				 
	 while($rowhb = $query_base->VerRegistro()){
				 	
					$historial_b[] = array(
						'id'            =>	$rowha['id'],
                        'usuario'       =>	new Usuario($rowhb['usuario']),
                        'area'          =>	new Area($rowhb['area']),
						'destino'       =>	new Usuario($rowhb['destino']),
                        'area_destino' 	=>	new Area($rowhb['area_destino']),
                        'observacion' 	=>	$rowhb['observacion'],
                        'accion'        =>	new Accion($rowhb['accion']),
						'original'      =>	$rowhb['categoria'] ,
						'fecha'         =>	date('d-m-Y H:i:s',strtotime($rowhb['fecha'])),
						'tipo'          =>	$rowhb['tipo']
					); 
				}
				
				return $historial_b;
    }

    function getHistorialAtencionDocumentos(){
        $sql= " SELECT
				hd.id_historial_documento AS id,
				'6' AS tipo,
				null AS usuario,
				null AS area,
				null AS destino,
				hd.id_area AS area_destino,				
				hd.id_accion AS accion,
				hd.original_historial_documento AS categoria,
				null AS observacion,
				hd.observacion_historial_documento AS comentario,
				DATE_FORMAT(hd.fecha_historial_documento, '%Y-%m-%d %H:%i') AS fecha
				FROM
				historial_documentos AS hd				
				WHERE
				hd.id_documento =  $this->_id
				UNION
				SELECT
                ha.id_historial_atencion AS id,
                ha.tipo_historial_atencion AS tipo,
                ha.id_usuario AS usuario,
                ha.id_area AS area,
                ha.id_usuario_destino AS destino,
                ha.id_area_destino AS area_destino,
                ha.id_accion AS accion,
                ha.original_historial_atencion AS categoria,
                null AS observacion,
                ha.observacion_historial_atencion AS comentario,
				DATE_FORMAT(ha.fecha_historial_atencion, '%Y-%m-%d %H:%i') AS fecha
                FROM
                historial_atencion AS ha
                WHERE
                ha.id_documento =  $this->_id AND
                (ha.tipo_historial_atencion = 0 OR ha.tipo_historial_atencion = 1
                 OR ha.tipo_historial_atencion = 2 OR ha.tipo_historial_atencion = 4)
                UNION
                SELECT
                b.id_borrador_respuesta AS id,
				3 AS tipo,
                b.id_usuario AS usuario,
                b.id_area AS area,
                b.id_destino AS destino,
                null AS area_destino,
                b.id_accion AS accion,
                b.categoria AS categoria,
                b.descripcion_borrador_respuesta AS observacion,
                b.comentario_adicional AS comentario,
				DATE_FORMAT(b.fecha_borrador_respuesta, '%Y-%m-%d %H:%i') AS fecha
                FROM
                borradores_respuesta AS b
                WHERE
                b.id_documento = $this->_id
                UNION
				SELECT
				d.id_devuelto AS id,
				'7' AS tipo,
				d.id_usuario AS usuario,
				d.id_area AS area,
				null AS destino,
				null AS area_destino,								
				null AS accion,
				'1' AS categoria,
				null AS observacion,
				d.descripcion AS comentario,
				DATE_FORMAT(d.fecha_devolucion, '%Y-%m-%d %H:%i') AS fecha
				FROM
				devuelto AS d
				WHERE
				d.id_documento = $this->_id
				ORDER BY
				fecha ASC,
				categoria ASC";

        $query = new Consulta($sql);

        while($rowhb = $query->VerRegistro()){

					$historial[] = array(
						'id'            =>	$rowhb['id'],
                        'usuario'       =>	new Usuario($rowhb['usuario']),
                        'area'          =>	new Area($rowhb['area']),
						'destino'       =>	new Usuario($rowhb['destino']),
                        'area_destino' 	=>	new Area($rowhb['area_destino']),
                        'observacion' 	=>	$rowhb['observacion'],
                        'comentario' 	=>	$rowhb['comentario'],
                        'accion'        =>	new Accion($rowhb['accion']),
						'original'      =>	$rowhb['categoria'] ,
						'fecha'         =>	date('d-m-Y H:i',strtotime($rowhb['fecha'])),
						'tipo'          =>	$rowhb['tipo']
					);
				}

				return $historial;
    }

	function obtenerBorradoresEscaneados($borr){
		
		$sql = "SELECT a.nombre_archivo
				FROM
				borrador_escaneado AS a
				WHERE a.id_borrador_respuesta =".$borr;
		
		$query_sql=new Consulta($sql);
		
		$borrador = array();
		
		$index = 0;
		
		while($row = $query_sql->ConsultaVerRegistro()){
			$borrador[$index++] = $row['nombre_archivo'];			
		}
		return $borrador;
	}
	
	function obtenerJustificacionesEscaneadas($hist){
		
		$sql = "SELECT a.nombre_archivo
				FROM
				justificado_escaneado AS a
				WHERE a.id_historial_atencion=".$hist;
		
		$query_sql=new Consulta($sql);		
		
		$archivo = array();
		
		$index=0;
		
		while($row = $query_sql->ConsultaVerRegistro()){
			$archivo[$index++] = $row['nombre_archivo'];			
		}
				
		return $archivo;
		
	}
	
	function obtenerAprobacionesEscaneadas($hist){
		
		$sql = "SELECT
				ae.nombre_archivo
				FROM
				aprobacion_escaneado AS ae
				WHERE
				ae.id_historial_atencion = ".$hist;
		
		$query_sql=new Consulta($sql);		
		
		$archivo = array();
		
		$index=0;
		
		while($row = $query_sql->ConsultaVerRegistro()){
			$archivo[$index++] = $row['nombre_archivo'];			
		}
				
		return $archivo;
		
	}
	
	function obtenerArchivadosEscaneados($hist){
		$sql = "SELECT
				'1' as tipo,
				dr.nombre_archivo
				FROM
				documento_respuesta_escaneado AS dr
				WHERE
				dr.id_archivo = ".$hist."
				UNION
				SELECT
				'2' as tipo,
				aa.nombre_archivo
				FROM
				adjuntos_archivado AS aa
				WHERE
				aa.id_archivo = ".$hist;
		
		$query_sql=new Consulta($sql);		
				
		$index=0;
		
		while($row = $query_sql->ConsultaVerRegistro()){
			$archivo[$index++] = array(
				'tipo'		=>	$row['tipo'],
				'nombre'	=>	$row['nombre_archivo']
			);			
		}			
		return $archivo;
	}
	
    function TengoElBorradorOriginal($usu){

        $sql = "SELECT
                id_destino AS destino,
                b.fecha_borrador_respuesta
                FROM
                borradores_respuesta AS b
                WHERE
                b.id_documento =  '".$this->_id."' AND
                b.categoria =  '1'
                ORDER BY
                b.fecha_borrador_respuesta DESC
                LIMIT 1";

        $query_sql=new Consulta($sql);
		$row=$query_sql->VerRegistro();

        if($row["destino"]==$usu)
            return true;
        else
            return false;
    }

    function TengoElDocDAOriginal($usu){

        $sql = "SELECT
                ha.id_usuario_destino
                FROM
                historial_atencion AS ha
                WHERE
                ha.id_documento = '".$this->_id."' AND
                ha.original_historial_atencion =  '1'
                ORDER BY
                ha.id_historial_atencion DESC
                LIMIT 1";

        $query_sql=new Consulta($sql);
		$row=$query_sql->VerRegistro();

        if($row["id_usuario_destino"]==$usu)
            return true;
        else
            return false;
    }

	function DespachoAreaTieneOriginal(){

        $sql = "SELECT
                ha.id_area_destino AS destino,
				ha.fecha_historial_atencion AS fecha
                FROM
                historial_atencion AS ha
                WHERE
                ha.id_documento =  '".$this->_id."' AND
                ha.original_historial_atencion =  '1'
				UNION 
				SELECT
				hd.id_area AS destino,
				hd.fecha_historial_documento AS fecha
				FROM
				historial_documentos hd
				WHERE
				hd.id_documento =  '".$this->_id."' AND
                hd.original_historial_documento =  '1'
                ORDER BY
                fecha DESC
                LIMIT 1";
        
        $query_sql=new Consulta($sql);
		$row=$query_sql->VerRegistro();
	
        if($row["destino"]==$_SESSION['session'][5])
            return true;        	
		else
            return false;
    }

    function ObtenerTamanioHistorialOriginales(){

        $sql = "SELECT *
                FROM
                borradores_respuesta AS b
                WHERE
                b.id_documento =  '".$this->_id."' AND
                b.categoria =  '1'";

        $query_sql=new Consulta($sql);

        return $query_sql->NumeroRegistros();
    }
	
	function ObtenerDescripcionUltimoOriginal($estado){

        $id_accion="";

        $descripcion = $this->UltimaDescripcionOriginal();

        if(empty($descripcion)){
            if($estado==14||$estado==16)
                $id_accion=29;
            elseif($estado==15||$estado==17)
                $id_accion=24;

            $sql = "SELECT
                    ha.observacion_historial_atencion AS observacion
                    FROM
                    historial_atencion AS ha
                    WHERE
                    ha.id_documento =  '".$this->_id."' AND
                    ha.original_historial_atencion =  '1' AND
                    ha.id_accion = $id_accion
                    ORDER BY
                    ha.id_historial_atencion DESC
                    LIMIT 1";

            $query_sql=new Consulta($sql);
            $row=$query_sql->VerRegistro();

            return $row["observacion"];
        }
        else{
            return $descripcion;
        }
	
	}

    function UltimaDescripcionOriginal(){

		$sql = "SELECT
                ha.observacion_historial_atencion AS observacion
                FROM
                historial_atencion AS ha
                WHERE
                ha.id_documento =  '".$this->_id."' AND
                ha.original_historial_atencion =  '1'
                ORDER BY
                ha.id_historial_atencion DESC
                LIMIT 1";

        $query_sql=new Consulta($sql);
		$row=$query_sql->VerRegistro();

		return $row["observacion"];

    }

    function ObtenerIdFinalizado(){

        $sql = "Select id_documento_finalizado
                FROM documento_finalizado
                WHERE id_documento = ".$this->_id;
        $query= new Consulta($sql);

        if($query->NumeroRegistros()==0)
            return 0;
        else{
            $row = $query->VerRegistro();
            return $row["id_documento_finalizado"];
        }


    }

    function ObtenerIdReporte(){

        $sql = "Select id_documento_reporte
                FROM documentos_reporte
                WHERE id_documento = ".$this->_id;
        $query= new Consulta($sql);

        if($query->NumeroRegistros()==0)
            return 0;
        else{
            $row = $query->VerRegistro();
            return $row["id_documento_reporte"];
        }


    }
	
	function actualizarFechaRespuesta($fecha){
		$sql = "UPDATE documentos_reporte
				SET fecha_respuesta = '$fecha'
				WHERE id_documento_reporte = ".$this->ObtenerIdReporte();
        $query= new Consulta($sql);
	}
	
	function copiaArchivadaUsuario(){
		$sql_arch = "SELECT
					 a.id_documento
					 FROM
					 archivo_copia AS a
					 WHERE
					 a.id_documento =  ".$this->_id." AND
					 a.id_area_duenia = ".$_SESSION['session'][5]." AND
					 a.id_usuario_duenio = ".$_SESSION['session'][0];

		$query_arch = new Consulta($sql_arch);

		if($query_arch->NumeroRegistros()>0){
			return true;
		}
		return false;
	}
	
	function ObtenerTodosEscaneados(){
	
		$sql_esc = "SELECT
					je.id_justificado_escaneado AS id,
					ha.id_usuario AS usuario,
					ha.id_usuario_destino AS usuario_destino,
					ha.id_area_destino AS area_destino,
					a.nombre_accion AS accion,
					ha.fecha_historial_atencion AS fecha,
					je.nombre_archivo AS nombre,
					ha.tipo_historial_atencion AS tipo
					FROM
					justificado_escaneado AS je
					Inner Join historial_atencion AS ha ON je.id_historial_atencion = ha.id_historial_atencion
					Inner Join accion AS a ON ha.id_accion = a.id_accion
					WHERE
					ha.id_documento =  ".$this->_id."
					UNION
					SELECT
					be.id_archivo_escaneado AS id,
					br.id_usuario AS usuario,
					br.id_destino AS usuario_destino,
					null AS area_destino,
					accion.nombre_accion AS accion,
					br.fecha_borrador_respuesta AS fecha,
					be.nombre_archivo AS nombre,
					'0' AS tipo					
					FROM 
					borrador_escaneado AS be Inner Join borradores_respuesta AS br 
					ON be.id_borrador_respuesta = br.id_borrador_respuesta
					Inner Join accion ON br.id_accion = accion.id_accion
					WHERE
					br.id_documento =  ".$this->_id."
					UNION
					SELECT
					de.id_documento_escaneado,
					r.nombre_remitente AS usuario,
					'ESCANEO' AS usuario_destino,
					null AS area_destino,
					'ESCANEAR' AS accion,
					de.fecha_escaneo AS fecha,
					de.nombre_documento_escaneado AS nombre,
					'1' AS tipo					
					FROM 
					documentos_escaneados AS de Inner Join documentos AS d ON de.id_documento = d.id_documento
					Inner Join remitentes AS r ON d.id_remitente = r.id_remitente
					WHERE
					d.id_documento =  ".$this->_id."
					ORDER BY fecha";

			$query_esc = new Consulta($sql_esc);
			
			while($row_esc = $query_esc->VerRegistro()){
					if($row_esc['tipo']!=1){
						$usuario = new Usuario($row_esc['usuario']);
						$usuario_destino = new Usuario($row_esc['usuario_destino']);
						$area_destino = new Area($row_esc['area_destino']);
					}else{
						$usuario = $row_esc['usuario'];
						$usuario_destino = $row_esc['usuario_destino'];
						$area_destino = "";
					}
					$escaneados[] = array(
						'id'            	=>	$row_esc['id'],
                        'usuario'       	=>	$usuario,
						'usuario_destino'   =>	$usuario_destino,
                        'area_destino' 		=>	$area_destino,
                        'accion'        	=>	$row_esc['accion'],						
						'fecha'         	=>	date('d-m-Y H:i',strtotime($row_esc['fecha'])),
						'nombre'			=>	$row_esc['nombre'],
						'tipo'          	=>	$row_esc['tipo']
					);
					
				}
		
				return $escaneados;
	}
	
	function ObtenerEstadoCopia($id_doc,$tipo){
		// tipo = 1 ; si es de despacho de area
		// tipo = 2 ; si es de atencion de documentos
		
		if($tipo == 1){
			$area = new Area($_SESSION['session'][5]);
			$n_area = $area->getNombre();
			
			$sql = "SELECT
					m.estado
					FROM
					movimientos AS m
					Inner Join documentos_reporte AS dr ON dr.id_documento_reporte = m.id_documento_reporte
					WHERE
					dr.id_documento =  '".$id_doc."' AND
					m.categoria =  '2' AND
					m.destino =  '".$n_area."'
					ORDER BY
					m.id_movimiento DESC
					LIMIT 0, 1";
		}else{
			$usuario = new Usuario($_SESSION['session'][0]);
			$nusuario = $usuario->GetNombreCompleto();
			$sql = "SELECT
					m.estado
					FROM
					movimientos AS m
					Inner Join documentos_reporte AS dr ON dr.id_documento_reporte = m.id_documento_reporte
					WHERE
					dr.id_documento =  '".$id_doc."' AND
					m.categoria =  '2' AND
					m.destino =  '".$nusuario."'
					ORDER BY
					m.id_movimiento DESC
					LIMIT 0, 1";
		}
		
		$query = new Consulta($sql);
		$row = $query->VerRegistro();
		$estado = $row["estado"];
		
		$sql_est = "SELECT
					e.abrev_nombre_estado AS abreviatura
					FROM
					estados AS e
					WHERE
					e.nombre_estado =  '$estado'";
					
		$query_est = new Consulta($sql_est);
		$row_est = $query_est->VerRegistro();
		
		return $row_est["abreviatura"];
		
	}
	
	function ObtenerUbicacionCopia($id_doc,$tipo){
		// tipo = 1 ; si es de despacho de area
		// tipo = 2 ; si es de atencion de documentos
		
		if($tipo == 1){
		
			$area = new Area($_SESSION['session'][5]);
			$n_area = $area->getNombre();
		
			$sql_ubic = "SELECT
						m.destino,
						m.tipo
						FROM
						movimientos AS m
						Inner Join documentos_reporte AS dr ON m.id_documento_reporte = dr.id_documento_reporte
						WHERE
						dr.id_documento =  '$id_doc' AND
						m.categoria =  '2' AND
						m.origen =  '$n_area' AND
						m.accion <> 'ARCHIVAR'";
		}else{
			$usuario = new Usuario($_SESSION['session'][0]);
			$nusuario = $usuario->GetNombreCompleto();
			
			$sql_ubic = "SELECT
						m.destino,
						m.tipo
						FROM
						movimientos AS m
						Inner Join documentos_reporte AS dr ON m.id_documento_reporte = dr.id_documento_reporte
						WHERE
						dr.id_documento =  '$id_doc' AND
						m.categoria =  '2' AND
						m.origen = '$nusuario' AND
						m.accion <> 'ARCHIVAR'";
		}
		
		$query = new Consulta($sql_ubic);
		
		$ubicacion = null;
		
		while($row = $query->VerRegistro()){
			$ubicacion[] = array(
				'destino'          	=>	$row['destino'],
                'tipo' 		      	=>	$row['tipo']
			);
		}
		
		return $ubicacion;
	}
}
?>