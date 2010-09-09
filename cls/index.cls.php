<?
class Indice {
		
	function IndiceListarModulos($id=''){
		if(empty($id)){
			$sql="select * from modulos ORDER BY id_modulo";
		}else{
			$sql="select * from modulos where id_modulo ='$id' ORDER BY id_modulo";
		}
		$query=new Consulta($sql);	
		if($query->numcampos()>0){
			while($rows=$query->ConsultaVerRegistro()){
          	 $prg[]=array('id'=>$rows['id_modulo'],
						 'nombre'=>$rows['nombre_modulo'],
						 'descripcion'=>$rows['descripcion_modulo'],
						 'carpeta'=>$rows['carpeta_modulo']);						 
     		}
  		}
		return $prg;
	}	
}	
?>