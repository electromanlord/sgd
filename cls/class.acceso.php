<?php
class Acceso{

	function AccesoValida(){
		$sql =	"SELECT a.id_usuario, 
					CONCAT(a.nombre_usuario,' ',a.apellidos_usuario )AS user, 
					r.nombre_rol, 
					a.lectura_usuario AS lectura, 
					a.escritura_usuario AS escritura, 
					id_area, 
					id_anp
					FROM 
					usuarios a, rol r
					WHERE 
					a.id_rol=r.id_rol AND
					a.login_usuario='".$_POST['usuario']."' AND
					a.password_usuario='".$_POST['password']."' AND
					a.estado_usuario = 1";
					
		$query=mysql_query($sql) or die(mysql_error());

		$nums=mysql_num_rows($query);
		if($nums==0){
			$sesion=$nums;
		}else{		
			while($row=mysql_fetch_array($query)){
				$sesion[]=array('id'            =>	$row['id_usuario'],
							  	'user'          =>	$row['user'],
							   	'rol'           =>	$row['nombre_rol'],
							   	'lectura'       =>	$row['lectura'],
							   	'escritura'     =>  $row['escritura'],
							   	'area'          =>  $row['id_area'],
								'anp'           =>  $row['id_anp'],
                           		'responsable'	  =>  false
                );
			}

            $sql = "select * from areas where id_area=".$sesion[0]['area']."
                    and id_responsable_area = ".$sesion[0]['id'];
            $que=mysql_query($sql) or die(mysql_error());

            $nums=mysql_num_rows($que);

            if($nums != 0){
                $sesion[0]['responsable']=true;
            }

		}
		return $sesion;
	}

	function AccesoRecuperar($_POST){
		$query=mysql_query("SELECT a.login_usuario, password_usuario, CONCAT(a.nombre_usuario,' ',a.apellidos_usuario )AS user, r.nombre_rol FROM usuarios a, rol r WHERE a.id_rol=r.id_rol AND a.email_usuario='".$_POST['email']."' ") or die(mysql_error());
		$nums=mysql_num_rows($query);
		if($nums==0){
			$sesion=$nums;
		}else{		
			while($row=mysql_fetch_array($query)){
				$sesion[]=array( 'usuario'=>$row['login_usuario'],
								'password'=>$row['password_usuario'],
							  		'user'=>$row['user'],
							   		 'rol'=>$row['nombre_rol']);
			}
	
			$email=$_POST['email'];
			$titulo="Recuperacion de contrase�a";
			$msg=" Estimado ".$sesion[0]['rol']." ".$sesion[0]['user']." 

			A continuci�n le informo que por su solicitud le ha sido enviado sus datos de acceso al sistema de usuarioistraci�n 
			de la tienda virtual Tecnocompeter: 		
			
			Usuario  :".$sesion[0]['usuario']."
			Password : ".$sesion[0]['password']."
		
		
			Atentamente 
			Soporte del Sistema
			
			";
			$from= "from: jdenegri@perunetcomp.com";
			if(!mail($email, titulo, $mensaje, $from)){
				echo "ERROR: NO SE PUDO ENVIAR EL CORREO... ";
			}else{
				$sesion=$nums;
			}
		}
		return $sesion;
	}

//acceso a las seciones da como resultado el menu que corresponde al usuario
	
	function AccesoSecciones($id_usuario){
		$query=mysql_query("SELECT id_modulo, nombre_modulo FROM modulos WHERE id_modulo = 1");
		$nums=mysql_num_rows($query) or die(mysql_error());		
		if($nums==0){
			return 0;
		}else{
			while($row=mysql_fetch_array($query)){				
				$queryPS=mysql_query("SELECT * FROM  usuarios_paginas ap, paginas sp 
					WHERE ap.id_pagina=sp.id_pagina AND 
						ap.id_usuario='".$id_usuario."' AND
						sp.id_modulo='".$row['id_modulo']."'	 ");
				$numsPS=mysql_num_rows($queryPS);
				if($numsPS!=0){
					$modulo[]=array('id_modulo'=>$row['id_modulo'],
									'modulo'=>$row['nombre_modulo']);
				}
				
			}
			return $modulo;
		}
	}
	
	function AccesoPaginasSecciones($id_modulo="", $id_usuario){
		$query=mysql_query("SELECT sp.id_pagina,sp.nombre_pagina, sp.url_pagina
							FROM  usuarios_paginas ap, usuarios a, paginas sp 
							WHERE a.id_usuario=ap.id_usuario AND 
							ap.id_pagina=sp.id_pagina AND 
							ap.id_usuario='$id_usuario' AND
							sp.id_modulo='$id_modulo'							
							ORDER BY sp.id_pagina ");
		$nums=mysql_num_rows($query) or die(mysql_error());		
		if($nums==0){
			return 0;
		}else{
			while($row=mysql_fetch_array($query)){
				$paginas[]=array('id'=>$row['id_pagina'],
                                 'pagina'=>$row['nombre_pagina'],
								 'url'=>$row['url_pagina']
                                );
			}
			return $paginas;
		}
	}
}

?>