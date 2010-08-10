<?


function paginadeerror(){


}

function StartsWith($Haystack, $Needle){
    // Recommended version, using strpos
    return strpos($Haystack, $Needle) === 0;
}

function paginar($actual, $total, $por_pagina, $enlace) {
  $total_paginas = ceil($total/$por_pagina);
  $anterior = $actual - 1;
  $posterior = $actual + 1;
  if ($actual>1)
    $texto = "<a href=\"$enlace$anterior\">&laquo;</a> ";
  else
    $texto = "<b>&laquo;</b> ";
  for ($i=1; $i<$actual; $i++)
    $texto .= "<a href=\"$enlace$i\">$i</a> ";
  $texto .= "<b>$actual</b> ";
  for ($i=$actual+1; $i<=$total_paginas; $i++)
    $texto .= "<a href=\"$enlace$i\">$i</a> ";
  if ($actual<$total_paginas)
    $texto .= "<a href=\"$enlace$posterior\">&raquo;</a>";
  else
    $texto .= "<b>&raquo;</b>";
  return $texto;
}

function cambiar_caracter($comodin,$deseado,$cadena){

	$ucadena = "";

	if(empty($cadena)) $ucadena="";
	else{
		$ncadena=explode($comodin,$cadena);
			
			foreach($ncadena as $reg){
				if($ucadena == "") //es el primero
					$ucadena = $reg;
				else	
					$ucadena = $ucadena.$deseado.$reg;
			}
	}		
	return $ucadena;	

}

function formato_date($comodin,$fecha){
	if(empty($fecha)) $ufecha="";
	else{
		$nfecha=explode($comodin,$fecha);
		$dia=$nfecha[0];
		$mes=$nfecha[1];
		$anio=$nfecha[2];
		$ufecha=$anio."-".$mes."-".$dia;
	}		
	return $ufecha;
}

function formato_slash($comodin,$fecha){
	if(empty($fecha)) $ufecha="";
	else{
		$nfecha=explode($comodin,$fecha);
		$dia=$nfecha[2];
		$mes=$nfecha[1];
		$anio=$nfecha[0];
		$ufecha=$dia."/".$mes."/".$anio;
	}
	return $ufecha;
}
function formato_ultimo_dia($fecha, $mes){
	$nfecha=explode('-',$fecha);
	$dia=$nfecha[2];
	$mess=$nfecha[1];
	$anio=$nfecha[0];
	switch($mes){
		case 1:										
			$day=31;	
		break;	
		case 2:										
			$day=18;
		break;	
		case 3:										
			$day=31;	
		break;
		case 4:										
			$day=30;
		break;
		case 5:										
			$day=31;
		break;
		case 6:										
			$day=30;
		break;
		case 7:										
			$day=31;
		break;
		case 8:										
			$day=31;
		break;
		case 9:										
			$day=30;
		break;
		case 10:										
			$day=31;
		break;
		case 11:										
			$day=30;
		break;
		case 12:										
			$day=31;
		break;
	}
	
	$ufecha=$anio."-".$mes."-".$day;
	return $ufecha;
}
function axo($id){
	$query=new Consulta("SELECT * FROM axo_poa WHERE id_axo_poa='".$id."'");
	$row=$query->ConsultaVerRegistro();
	$name=$row['axo_axo_poa'];
	return $name;
}

function anp($id){
	$query=new Consulta("SELECT CONCAT(c.nombre_categoria,' ',a.nombre_anp )AS anp FROM anp a, categoria c
	WHERE a.id_anp='".$id."' AND
	a.id_categoria=c.id_categoria");
	$row=$query->ConsultaVerRegistro();
	$name=$row['anp'];
	return $name;
}
function fuente($id){
	$dato=fuente_row($id);
	return $dato[nombre_ff];
}

function fuente_row($id){
	$query=new Consulta("SELECT * FROM fuente_financiamiento
	WHERE id_ff='".$id."' ");
	return $query->ConsultaVerRegistro();
}


function fuente_siglas($id){
	$dato=fuente_row($id);
	return $dato[siglas_ff];
}

function mes($id){
	$query=new Consulta("SELECT * FROM mes	WHERE id_mes='".$id."' ");
	$row=$query->ConsultaVerRegistro();
	$name=$row['nombre_mes'];
	return $name;
}

function buscar_trimestre($new, $array){
	$av=explode(",",$array);
	$bolean=false;
	for($i=0;$i<sizeof($av);$i++ ){
		if($new==$av[$i]){
			$bolean=true;
		}
	}
	return $bolean;				
}

/////////////////////////////////////////////////////////////////////////////////////////
//my funcion //att efrain
	function GeneraSqlArray($array,$campo,$condi,$signo=''){
					$o=$condi;
					
					
					if (empty($signo)){
					$field="$campo='";
					}else{
					$field="$campo {$signo} '";
					}
					
					$sql="";
					if (count($array)>0){
						for ($i=0;$i<count($array);$i++){
							$sql.=$field.$array[$i]."'";
							if (($i+1)==count($array)){
							}else{ $sql.=$o;}
						}
						$sql=$sql;
					}
					return $sql;
	}
	
	function table_row($id,$table,$campo='',$where=''){
		if(empty($campo)){
			$campo="id_".$table;
		}
		
		if (empty($where)){
			$sql="SELECT * FROM $table WHERE $campo='".$id."' ";
		}else{
			$sql="SELECT * FROM $table WHERE {$campo}='{$id}' and {$where}";
		}
		//echo "<br>".$sql;
		//die ($sql."aqui !!");
		$query=new Consulta($sql);
		return $query->ConsultaVerRegistro();
	}
	
	function msql($sql){
		echo "<br>".$sql."<br>";
	}
	
	function num_format($valor='',$defaultret='',$ndecimal='',$sepdecimal='',$sepmillar=''){
	//string number_format ( float numero [, int decimales [, string punto_dec, string sep_miles]] )


		if (empty($defaultret)){
			$defaultret="&nbsp;";
		}
		
		if(substr($defaultret,0,1)=='.'){
			$defaultret=substr($defaultret,1);
		} 
			
		if (empty($sepmillar)){
			$sepmillar=',';
		}

		if (empty($valor)){
			return $defaultret;
		}else{
			if(is_numeric($valor)){	
				if($valor==0) return $defaultret;
				else return number_format($valor, $ndecimal, $sepdecimal, $sepmillar);
			}
			else return $valor;
		}
		
	}
	
	function mes_castellano($fecha){/*
		//fecha de tipo Y-m-d
		$fch=explode("-",$fecha);
		$dd=$fch[2]; $mm=$fch[1];  $aa=$fch[0];
		
		return $dd." ".$mm.*/
	}
	
	function resta_fechas($fecha1,$fecha2){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$anio1)=split("/",$fecha1);
      	if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$anio1)=split("-",$fecha1);
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$anio2)=split("/",$fecha2);
      	if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$anio2)=split("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$anio1) - mktime(0,0,0,$mes2,$dia2,$anio2);
      	$ndias=floor($dif/(24*60*60));
 		
		return($ndias);
 	}
	
function permisos_fuente($user,$var='ff'){
	$ff="";
	if($_SESSION[Module]<5) $modulo=1; else $modulo=5;
	$q=new Consulta("SELECT id_ff FROM fuente_usuario 
						WHERE id_usuario='".$user."' AND id_submodulo='".$modulo."'");
	while($row=$q->ConsultaVerRegistro()) $ff.=$row[id_ff].",";
	return " AND $var.id_ff IN (".substr($ff,0,(strlen($ff)-1)).")";
}

function permisos_fuente_asignaciones($user){
	$asignaciones=array(0);
	if($_SESSION[Module]<5) $modulo=1; else $modulo=5;
	$sql="SELECT asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos
			FROM fuente_usuario
				Inner Join presupuesto_ff ON fuente_usuario.id_ff = presupuesto_ff.id_ff
				Inner Join presupuesto_anp ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
				Inner Join asignacion_ff_anp_objetivos 
					ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
			WHERE id_usuario='".$user."' AND id_submodulo='".$modulo."'";
	$q=new Consulta($sql);
	while($row=$q->ConsultaVerRegistro()) $asignaciones[]=$row[0];		
	return $asignaciones;
}

function axo_quinq($id_axo,$atrib='q.id_quinquenio',$dt=''){
	$q=new Consulta("SELECT * FROM quinquenio q Inner Join quinquenio_axo qa 
		ON q.id_quinquenio=qa.id_quinquenio WHERE id_axo_poa='".$id_axo."'");
	$resultado="";
	$quinq=array();
	if($row=$q->ConsultaVerRegistro()){
	 	
		$quinq['id']=$row[id_quinquenio];
		$quinq['nombre']=$row[nombre_quinquenio];
		///a�os
		$qa=new Consulta("SELECT id_axo_poa FROM quinquenio_axo 
			WHERE id_quinquenio='".$row[id_quinquenio]."'");
		$axos=array();
		while($r=$qa->ConsultaVerRegistro()) $axos[]=$r[0];
		$quinq['axo_poa']=implode(',', $axos);
		$quinq['atributo']= $atrib." IN (".$quinq['axo_poa'].") ";
	}
	if(!empty($dt)) return $quinq[$dt];
	else return $quinq;
}

function quinq($id,$dt='nom'){
	$query=new Consulta("SELECT * FROM quinquenio WHERE id_quinquenio='".$id."'");
	$row=$query->ConsultaVerRegistro();
	//axos
	$qa=new Consulta($sql="SELECT id_axo_poa FROM quinquenio_axo WHERE id_quinquenio='".$id."'"); //echo $sql;
	$axos=array();
	while($r=$qa->ConsultaVerRegistro()) $axos[]=$r[0];
	$q['axo_poa']=implode(',', $axos);
	$q['atributo']= " IN (".$q['axo_poa'].") ";
	$q['id']=$row[id_quinquenio];
	$q['nom']=$row[nombre_quinquenio];
	
	if($dt=='*') return $q;
	elseif($dt!='nom') return $q[$dt];
	return $q['nom'];
}

function ObtenerDiasFaltantes($id, $fecha_registro){
	
	$sql = "SELECT
			p.tiempo_horas_respuesta_prioridad/24 AS dias
			FROM
			documentos AS d
			Inner Join prioridades AS p ON p.id_prioridad = d.id_prioridad
			WHERE
			d.id_documento =  '$id'";
	#echo($sql);

     /*
        Vencidos se pasaron sus dias.
        
        Atendidos: archivados y finalizados.
        Los demas estados son pendientes.
     */
	$query = new Consulta($sql);
	
	$row=$query->VerRegistro();
	
	//echo "fecha registro".$fecha_registro."<br/>";
	//echo "hoy".date("d-m-Y")."<br/>";
	
	$dias_transcurridos = resta_fechas(date("d-m-Y"),$fecha_registro);
	//echo "dias transcurridos".$dias_transcurridos;
	
	$dia_falta = $row["dias"]-$dias_transcurridos;
	//echo "falta".$dia_falta."<br/><br/>";
	return $dia_falta;
	
}

/**
 * Stylized Dumper
 */
function dump($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
?>