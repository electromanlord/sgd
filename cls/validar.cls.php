<?

class validar{

	function validarBuscarModulo($id_user){
			$sql="SELECT sm.id_modulo FROM submodulo_usuario su, submodulo sm
				WHERE su.id_usuario='".$id_user."' AND su.id_submodulo=sm.id_submodulo ";	
			$query=new Consulta($sql);
			$ids=array();	
			while($row=$query->ConsultaVerRegistro()){
				
				if(!in_array($row[0], $ids)&&$estado==0){
					array_push($ids, $row[0]);
				}		
				
			}			
		
			$IN="";
			while(list($key, $value)= each($ids)){
				if(empty($IN)){
					$IN=$value;
				}else{
					$IN.=",".$value;
				}								
			}
			
			if(empty($IN)){ $IN=0;}
			
			$sql="select id_modulo, carpeta_modulo 
						from modulos 
						where id_modulo IN(".$IN.") ";
						
			$querys=new Consulta($sql);
			
			if($querys->numregistros()>0){
				while($rows=$querys->ConsultaVerRegistro()){
			   		$prg[]=array('id'=>$rows['id_modulo'],						
						'carpeta'=>$rows['carpeta_modulo']);
				}
			}
		return $prg;	
	}
		
	function ValidarBuscarId($dato){
		$sql="SELECT * from usuarios 
				WHERE usuario_usuario='".$dato."' 
				ORDER BY id_usuario ASC";
		$query=new Consulta($sql);
		$rows=$query->ConsultaVerRegistro();
		if($query->numregistros()>0){
			return $rows[id_usuario];
		}else{
			return 0;
		}
	}	
	
		
	function ValidarUsuario($LogUser,$LogPassw){
	
	$ergP=ereg(" ",strtolower(trim($LogPassw)));
	$ergU=ereg(" ",strtolower(trim($LogUser)));
	
	$ergPI=ereg("=",strtolower(trim($LogPassw)));
	$ergUI=ereg("=",strtolower(trim($LogUser)));
	
	if ($ergPI ==true || $ergUI==true){
		return false;
	}
	
	if ($ergP ==true || $ergU==true){
		return false;
	}
		$sql="SELECT
				id_usuario,
				usuario_usuario,
				password_usuario
			FROM usuarios
			WHERE usuario_usuario = '$LogUser' AND
				password_usuario = '$LogPassw' 
			ORDER BY id_usuario ASC";
					
					//echo $sql;
		$query=new Consulta($sql);
		if($query->numregistros() != 0) {
			$data = $query->ConsultaVerRegistro();
				if($data['password_usuario'] == $LogPassw && $data['usuario_usuario']==$LogUser) {
							$valido=true;
						} else {
				}
		}
	return $valido;
	}
	
	function ValidarListarUsuarios($id=''){

		if(empty($id)){
				return $prg;
		}else{
			$sql="SELECT * FROM usuarios u, rol r 
				WHERE u.id_usuario ='$id' AND
					r.id_rol=u.id_rol 
				ORDER BY u.id_usuario ASC";
		}
		
		$query=new Consulta($sql);
		if($query->numregistros()>0){
			while($rows=$query->ConsultaVerRegistro()){
		    	$prg[]=array('id_usuario'=>$rows[id_usuario],
	            	'usuario'=>$rows[usuario_usuario],
					'password_usuario'=>$rows[password_usuario],							 
					'nombre_usuario'=>$rows[nombre_usuario],
					'apellido_usuario'=>$rows[apellidos_usuario],
					'nombre_rol'=>$rows[nombre_rol],
					'correo_usuario'=>$rows[correo_usuario],
					'id_rol'=>$rows[id_rol]	);
      		}
  		}
     	return $prg;
	}	


	function ValidarListarSubmodulos($id_modulo, $id_usuario){
		$sql="SELECT s.nombre_submodulo, s.url_submodulo, su.lectura, su.escritura, 
			cad_submodulo 
			FROM submodulo_usuario su, submodulo s 
			WHERE su.id_submodulo=s.id_submodulo AND 
				su.id_usuario='".$id_usuario."'	AND
				s.id_modulo='".$id_modulo."'
				ORDER BY s.orden_submodulo,s.id_submodulo";
				//echo $sql;
		$query=new Consulta($sql);
			if($query->numregistros()>0){
				while($rows=$query->ConsultaVerRegistro()){
					///caducidad
					$estado=0;
					if($rows[cad_submodulo]!='0'){
						//echo "===>".$_SESSION['inrena_'.$_SESSION[Module]][2];
					  if($rows[cad_submodulo]==1&&$_SESSION['inrena_'.$_SESSION[Module]][2]>2)
					  		$estado=1;
					  if($rows[cad_submodulo]==2&&$_SESSION['inrena_'.$_SESSION[Module]][2]<3)	
					  		$estado=1;
					}	
					//fin caducidad
					if($estado==0){	
						$prg[]=array('submodulo'=>$rows['nombre_submodulo'],
								'url'=>$rows['url_submodulo'],
								'lectura'=>$rows['lectura'],
								'escritura'=>$rows['escritura']);
					}
				}
  			}
     		return $prg;
		}
}
	
?>