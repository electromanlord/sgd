<?php 

class Usuario{
	
	var $_id; 	
	var $_area;
	var $_nombre;
	var $_apellidos;
	var $_email;
	var $_login;
	var $_password;
	var $_fecha_ingreso;
	var $_lectura;  
	var $_estructura;
    var $_iniciales;
    var $_cargo;
	
	function Usuario($id){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM usuarios WHERE id_usuario = '".$this->_id."' ";
			/*
			 * editado el estado porque se borraba el nombre del dueño del documento en el historial
			 * $sql = "SELECT * FROM usuarios WHERE id_usuario = '".$this->_id."' AND estado_usuario = 1";
			 */
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				$row = $query->VerRegistro();				
				$this->_area = new Area($row['id_area']);
				$this->_nombre = $row['nombre_usuario'];
				$this->_apellidos = $row['apellidos_usuario'];
				$this->_email = $row['email_usuario'];
				$this->_login = $row['login_usuario'];
				$this->_password = $row['password_usuario'] ;
				$this->_fecha_ingreso = $row['fecha_ingreso_usuario'];
				$this->_lectura = $row['lectura_usuario'];
				$this->_estructura = $row['escritura_usuario']  ;
            $this->_iniciales = $row['iniciales_usuario'];
            $this->_cargo = $row['cargo_usuario'];
			}
		}	 
	} 
	
	function getIdDocumentos(){
		
		$return;
		
		$sql = "SELECT * FROM historial_documentos 
				WHERE id_usuario = '".$this->_id."' 
				GROUP BY id_documento 
				ORDER BY id_documento ";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$return[]['id'] = $row['id_documento'];	
		}
		
		return $return;		
	}	
	
	function getIdAtencion(){
		
		$return;
		
		$sql = "
				SELECT 
					ha.id_documento AS id,
					ha.original_historial_atencion AS categoria
                FROM 
					historial_atencion AS ha
                INNER JOIN 
					documentos AS d ON ha.id_documento = d.id_documento
                WHERE
					(
					  (ha.id_usuario_destino = $this->_id AND
					   ha.tipo_historial_atencion=0) OR
					  (ha.id_usuario_destino = $this->_id AND 
					   ha.tipo_historial_atencion=4) ) AND
					(
					  (
					   (d.id_estado =  '4' OR d.id_estado =  '6' OR d.id_estado =  '14' 
						OR d.id_estado =  '15' OR d.id_estado =  '18'
					   ) AND ha.original_historial_atencion = 1
					  ) OR ha.original_historial_atencion = 2
					)
                GROUP BY 
					1,2
					
                UNION
				
                SELECT 
					b.id_documento AS id,
					b.categoria AS categoria
                FROM 
					borradores_respuesta AS b
                INNER JOIN 
					documentos AS d ON b.id_documento = d.id_documento
                WHERE
					b.id_destino = $this->_id AND (
					( ( d.id_estado = '4' OR d.id_estado = '6' OR d.id_estado = '14' 
						OR d.id_estado = '15' OR d.id_estado = '18') AND b.categoria =1) 
					OR b.categoria = 2)
                GROUP BY 
					1,2
                ORDER BY 
					id DESC, categoria
			";
		$query = new Consulta($sql);

        $c = 0;
		while($row = $query->VerRegistro()){
			$return[$c]['id'] = $row['id'];
            $return[$c]['original'] = $row['categoria'];
            $c++;
		}
		return $return;		
	}
		
	function getIdAtencionPorFiltro($campo="", $valor=""){
			
		$return;
		if($campo == "nombre_remitente"){
			$where = $campo == "nombre_remitente" ? " AND r.nombre_remitente like '%$valor%' " : "";
		}else{
			$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
		}
		   		
		
		$sql = "
			SELECT 
					ha.id_documento AS id,
					ha.original_historial_atencion AS categoria
				FROM 
					historial_atencion AS ha
                INNER JOIN 
					documentos AS d ON ha.id_documento = d.id_documento
                LEFT JOIN 
					remitentes AS r ON r.id_remitente = d.id_remitente
                WHERE
					((ha.id_usuario_destino = $this->_id AND
					 ha.tipo_historial_atencion=0) OR
					(ha.id_usuario_destino = $this->_id AND
					 ha.tipo_historial_atencion=4))
					$where
                GROUP BY 1,2

                UNION

                SELECT 
					b.id_documento AS id,
					b.categoria AS categoria
                FROM 
					borradores_respuesta AS b
                INNER JOIN 
					documentos AS d ON b.id_documento = d.id_documento
                LEFT JOIN 
					remitentes AS r ON r.id_remitente = d.id_remitente
                WHERE
					b.id_destino = $this->_id 
					$where
                GROUP BY 
					1,2
                ORDER BY 
					id DESC, categoria
			";

		$query = new Consulta($sql);

        $cont = 0;
		while($row = $query->VerRegistro()){
			$return[$cont]['id'] = $row['id'];
            $return[$cont]['original'] = $row['categoria'];
		}
		
		return $return;		
	}
	
	function verificarDocumentoAtendido($id_documento){
		
		$return;
		
		$sql = "SELECT * FROM documentos_usuario WHERE id_usuario = '".$this->_id."' AND id_documento = '".$id_documento."'";
		$query = new Consulta($sql);
		if($query->NumeroRegistros() > 0){
			$return = TRUE; 
		}else{
			$return = FALSE; 
		} 
		
		return $return;		
	}
		
	function getId(){
		return $this->_id;
	}
	
	function getRol(){
		return $this->_rol;
	}
		
	function getNombre(){
		return $this->_nombre;
	}
		
	function getApellidos(){
		return $this->_apellidos;
	}
	
	function getNombreCompleto(){
		return $this->_nombre.' '.$this->_apellidos;
	}

    function getArea(){
        return $this->_area;
    }
    
    function getIniciales(){
        return $this->_iniciales;
    }
    
    function getCargo(){
        return $this->_cargo;
    }

    function getLogin(){
        return $this->_login;
    }

    function esMiArea($otro){

        $sql="SELECT id_area
              FROM usuarios
              WHERE id_usuario=$otro";

        $query_sql = new Consulta($sql);
        $row_reg = $query_sql->VerRegistro();

        $mi_area = $this->_area;
        $id_mi_area = $mi_area->getId();

        if($id_mi_area==$row_reg["id_area"])
            return true;
        else
            return false;

    }
	
	function ObtenerTiposDocumento(){
	
		$return = null;
        $id_area = $this->_area->getId();

        if($id_area == 1){
            $where = "WHERE td.entrada_salida = '3'";
        }elseif($id_area == 3){
            $where = "WHERE td.entrada_salida = '3'
                      OR td.entrada_salida = '2'
                      OR td.entrada_salida = '1'";
        }else{
            $where = "WHERE td.entrada_salida = '2'
                      OR td.entrada_salida = '1'";
        }
        $sql = "SELECT
				td.id_tipo_documento,
				td.nombre_tipo_documento
				FROM
				tipos_documento AS td
				$where
                ORDER BY nombre_tipo_documento";

		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' => $row['id_tipo_documento'],
				'nombre' => $row['nombre_tipo_documento']
			); 		
			
		}	
		return $return;		
	}
	
	function esResponsable(){
	
		$SQL = "SELECT 1
				FROM
				usuarios AS u
				Inner Join areas AS a ON u.id_area = a.id_area
				WHERE
				u.id_usuario =  '".$this->_id."'
				AND 
				u.id_usuario = a.id_responsable_area";
			
		$Query = new Consulta($SQL);	
				
		if($Query->NumeroRegistros()==0)
			return false;
		else
			return true;
		
	}
}

?>
