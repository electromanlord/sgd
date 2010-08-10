<?
class Login {
	
	function LoginUsuarios($id=''){
		
		if(empty($id)){
			$sql="select * from usuarios ORDER BY nombre_usuario ASC";
		}else{
			$sql="select * from usuarios where id_usuario ='$id' ORDER BY id_usuario ASC";
		}
		
		$query=new Consulta($sql);
		if($query->numregistros()>0){
			while($rows=$query->ConsultaVerRegistro()){
            	$prg[]=array('id_usuario'=>$rows['id_usuario'],
	                        'usuario'=>$rows['usuario_usuario'],
							'password_usuario'=>"XXsApItOXXX",							 
							'nombre_usuario'=>$rows['nombre_usuario'],
							'apellido_usuario'=>$rows['apellido_usuario'],
							'correo_usuario'=>$rows['correo_usuario']);
			}
  		}
     return $prg;
	}
		
	function ListarAxo($id=''){
		if(empty($id)){
			$sql="select * from axo_poa order by axo_axo_poa";
		}else{
			$sql="select * from axo_poa where id_axo_poa_poa=".$id."  order by axo_axo_poa";
		}
		$query=new Consulta($sql);
		if($query->numregistros()>0){
				while($rows=$query->ConsultaVerRegistro()){
            $prg[]=array('id_axo_poa'=> $rows[id_axo_poa],
	                    'axo'=> $rows[axo_axo_poa],
						'descripcion'=> $rows[descripcion_axo_poa]
		 		);
      		}
  		}
  	return $prg;		
	}
	
	function LoginAxoUsuario(){
		$sql="select * from usuario_axo_poa order by id_usuario, id_axo_poa";
		$query=new Consulta($sql);
		if($query->numregistros()>0){
			while($rows=$query->ConsultaVerRegistro()){
           $prg[]=array('id_axo_poa'=>$rows[id_axo_poa],
                       'id_usuario'=>$rows[id_usuario]);
     		}
 		}
  		return $prg;		
	}
	
	function LoginSessionAxo($anyo,$ruta){
	global $AuthVar,$mnuconsug,$calc;
		$sql="SELECT `usuarios`.`id_usuario`, `axo_poa`.`axo_axo_poa`,`usuario_axo_poa`.`id_axo_poa` 
				FROM `usuario_axo_poa`
					Inner Join `usuarios` ON `usuarios`.`id_usuario` =
					`usuario_axo_poa`.`id_usuario`
				Inner Join `axo_poa` ON `axo_poa`.`id_axo_poa` = `usuario_axo_poa`.`id_axo_poa` 
				WHERE
					`usuarios`.`id_usuario` =  '".$AuthVar['idu']."'
			    ORDER BY `axo_poa`.`axo_axo_poa` ASC ";
				
		//echo "<br>".$AuthVar['idu'];
		$query=new Consulta($sql);
		if($query->numregistros() != 0) {
		while($rows=$query->ConsultaVerRegistro()){
           $prg[]=array('id_usuario'=>$rows[id_usuario],
                       'axo'=>$rows[axo_axo_poa],
					   'id_axo'=>$rows[id_axo_poa],
											 );
     			}
				
		}
	
		$ARaxos=$prg;
		if (is_array($ARaxos)){
			for ($i=0;$i<count($ARaxos);$i++){
				if ($ARaxos[$i][id_axo]==$anyo){
					$AxoAnt=$ARaxos[$i-1][id_axo];
					$AxoPost=$ARaxos[$i+1][id_axo];
					
				}
				//echo "Usuario ".$ARaxos[$i][id_usuario]. " Año ".$ARaxos[$i][axo]." AÑO AC.".$anyo."<br>";
			}
			
	
		}
		
		if (isset($AxoAnt)){
			$LinkA= '<a href="#" onclick="top.location='."'../axopoa.php?filename=".$ruta."&axo=".$AxoAnt."'".'" title="Anterior Año"><img src="../imgs/b_firstpage.png" alt="Anterior Año" width="16" height="13" border="0"> </a>';
		}
		
		if (isset($AxoPost)){
			$LinkB='<a href="#" onclick="top.location='."'../axopoa.php?filename=".$ruta."&axo=".$AxoPost."'".'" title="Siguiente Año" ><img src="../imgs/b_lastpage.png" alt="Siguiente Año" width="16" height="13" border="0"></a>';
		}
		

		$Links=array($LinkA,$LinkB,$mnuconsug);
		return $Links;
	}	
	///////////////////////////////////////
	function ListarQ($id=''){
		if(empty($id)){
			$sql="select * from quinquenio order by nombre_quinquenio";
		}else{
			$sql="select * from quinquenio where id_quinquenio=".$id." 
															order by nombre_quinquenio";
		}
		$query=new Consulta($sql);
		if($query->numregistros()>0){
				while($rows=$query->ConsultaVerRegistro()){
            $prg[]=array('id_quinquenio'=> $rows[id_quinquenio],
	                    'quinquenio'=> $rows[nombre_quinquenio],
						'descripcion'=> $rows[descripcion_quinquenio]
		 		);
      		}
  		}
  	return $prg;		
	}
	
	function LoginQUsuario(){
		$sql="select * from usuario_quinquenio order by id_usuario, id_quinquenio";
		$query=new Consulta($sql);
		if($query->numregistros()>0){
			while($rows=$query->ConsultaVerRegistro()){
           $prg[]=array('id_quinquenio'=>$rows[id_quinquenio],
                       'id_usuario'=>$rows[id_usuario]);
     		}
 		}
  		return $prg;		
	}
	
	function LoginSessionQ($anyo,$ruta){
	global $AuthVar,$mnuconsug,$calc;
		$sql="SELECT u.id_usuario, q.nombre_quinquenio, uq.id_quinquenio 
				FROM usuario_quinquenio uq Inner Join usuarios u ON u.id_usuario=uq.id_usuario
					Inner Join quinquenio q ON q.id_quinquenio=uq.id_quinquenio 
			WHERE u.id_usuario='".$AuthVar['idu']."'
			ORDER BY q.id_quinquenio ASC ";
				
		//echo "<br>".$sql;
		$query=new Consulta($sql);
		if($query->numregistros() != 0) {
			while($rows=$query->ConsultaVerRegistro()){
			   $prg[]=array('id_usuario'=>$rows[id_usuario],
						   'quinquenio'=>$rows[nombre_quinquenio],
						   'id_quinquenio'=>$rows[id_quinquenio],
												 );
     		}
				
		}
	
		$ARaxos=$prg;
		if (is_array($ARaxos)){
			for ($i=0;$i<count($ARaxos);$i++){
				if ($ARaxos[$i][id_quinquenio]==$anyo){
					$AxoAnt=$ARaxos[$i-1][id_quinquenio];
					$AxoPost=$ARaxos[$i+1][id_quinquenio];
					
				}
				//echo "Usuario ".$ARaxos[$i][id_usuario]. " Año ".$ARaxos[$i][axo]." AÑO AC.".$anyo."<br>";
			}
			
	
		}
		
		if (isset($AxoAnt)){
			$LinkA= '<a href="#" onclick="top.location='."'../axopoa.php?filename=".$ruta."&axo=".$AxoAnt."'".'" title="Anterior Quinquenio"><img src="../imgs/b_firstpage.png" alt="Anterior Quinquenio" width="16" height="13" border="0"> </a>';
		}
		
		if (isset($AxoPost)){
			$LinkB='<a href="#" onclick="top.location='."'../axopoa.php?filename=".$ruta."&axo=".$AxoPost."'".'" title="Siguiente Quinquenio" ><img src="../imgs/b_lastpage.png" alt="Siguiente Quinquenio" width="16" height="13" border="0"></a>';
		}
		

		$Links=array($LinkA,$LinkB,$mnuconsug);
		return $Links;
	}
}
?>