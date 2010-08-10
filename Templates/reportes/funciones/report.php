

<?
function PresupuestoMensualPorPartidas(){
	
	
	$this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1],$_POST["idmes"]);
	
$sql="SELECT m.*
FROM
`programacion_partidas_meses` AS `ppm`
Inner Join `programacion_partidas` AS `pp` ON `ppm`.`id_programacion_partidas` = `pp`.`id_programacion_partidas`
Inner Join `asignacion_ff_anp_objetivos` AS `afao` ON `afao`.`id_asignacion_ff_anp_objetivos` = `pp`.`id_ff_anp_subactividad`
Inner Join `asignacion_anp_objetivos` AS `aao` ON `aao`.`id_asignacion_anp_objetivos` = `afao`.`id_asignacion_anp_objetivos`
Inner Join `presupuesto_anp` AS `pa` ON `pa`.`id_presupuesto_anp` = `afao`.`id_presupuesto_anp`
Inner Join `presupuesto_ff` AS `pf` ON `pf`.`id_presupuesto_ff` = `pa`.`id_presupuesto_ff`
Inner Join `fuente_financiamiento` AS `ff` ON `ff`.`id_ff` = `pf`.`id_ff`
Inner Join `anp_objetivo_especifico` AS `aoesp` ON `aoesp`.`id_anp_objetivo_especifico` = `aao`.`id_anp_objetivo_especifico`
Inner Join `tarea` AS `t` ON `t`.`id_tarea` = `aao`.`id_tarea`
Inner Join `anp_objetivo_estrategico` AS `aoest` ON `aoest`.`id_anp_objetivo_estrategico` = `aoesp`.`id_anp_objetivo_estrategico`
Inner Join `objetivo_estrategico` AS `oe` ON `oe`.`id_objetivo_estrategico` = `aoest`.`id_objetivo_estrategico`
Inner Join `mes` AS `m` ON `ppm`.`id_mes` = `m`.`id_mes`
WHERE
aao.id_anp =  '".$_SESSION['anp']['idanp']."' AND
aao.id_axo_poa =  '".$_SESSION["inrena_4"][2]."'

GROUP BY
`ppm`.`id_mes`";
$Q_m=new Consulta($sql);?>
					


<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<br>
<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="9%" align="right">&nbsp;</td>
    <td width="91%"><u><span class="Estilo5"><strong>Fuentes y Ejecutores Asociados </strong></span></u></td>
  </tr>
</table>
<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4" align="center"><form name="form1" method="post" action="">
      <label><span class="Estilo5">Seleccione el Mes<br>
        <select name="select">
          <option value="0">Elija el Mes</option>
        </select>
        </span></label>
    </form>
    </td>
  </tr>
  <tr>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <? while($row=$query->ConsultaVerRegistro()){
						$row_ff=table_row($row['id_fuentefinanciamiento'],"fuentefinanciamiento");?>
  <tr>
    <td width="9%" align="right">&nbsp;</td>
    <td colspan="3" align="left"><em><strong>
      <?=$row_ff[nombre_fuentefinanciamiento]?>
    </strong></em></td>
  </tr>
  <?	$querryject=new 
												Consulta (
														$sqlejct= 
														$ClassObj->set_sql(
																			"ff.id_ff,ff.nombre_ff",
																			" AND ff.id_fuentefinanciamiento='".$row[id_fuentefinanciamiento]."' and m.id_mes='".$_POST[idmes]."'","ff.id_ff",
																			"ff.id_ff")
														);
														//echo $sqlejct;
										while($rowej=$querryject->ConsultaVerRegistro()){

										?>
  <tr>
    <td colspan="2" align="right"><!-- <input type="checkbox" name="checkbox" value="checkbox" /> -->
        <input name="S2[]" type="checkbox" value="<?=$rowej['id_ff']?>" method="post" />
    <td width="76%"><?=$rowej[nombre_ff]?>
      </a></td>
  </tr>
  <?
											} 
								
									
							} 
							
							?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=4 align=center><p><br />
            <br />
            <span class="Estilo5">Mostrar el Reporte </span></p>
        <p>
          <?
											if (empty($anpid)){
												 $functjs=$functjs."()";
											}else{
												 $functjs= $functjs."('".$anpid."')";
											}
											
							?>
      <a href="../informacionanp/presupuestomensualporpartidas.php" onclick="'.$functjs.'"> <img src="../../imgs/b_select.png" border="0"> </a> </p></td>
  </tr>
</table>
<?
						
				
						
						
						
				}else{
					 ?>
<center>
  <strong style="font:Verdana, Arial, Helvetica, sans-serif; color:#FF0000"> Anp no tiene datos programados En este A&Ntilde;O</strong>
</center>
<?
				}	
}
function ResolverArrayF($A){
$B[]=$A[0][idff];
for ($i=0;$i<count($A);$i++){
	$dato=$A[$i][idff];
	if (BuscarAr($B,$dato)==false){
		$B[]=$dato;
	}	
}
sort($B);

for ($i=0;$i<count($B);$i++){
	$dato=$B[$i];
	
	
	for ($j=0;$j<count($A);$j++){
		if ($dato==$A[$j][idff]){
			echo "<br>".$dato." ".$A[$j][idej];
		}
	}
}
}

	

	function suma_meta_anp_subactividad_tareas($anp_subactividad,$SqlFts='',$istrim=''){
			
			$sql="SELECT m.*, Sum(m.cantidad_metas_meses) AS total_metas FROM
					metas_meses AS m Inner Join asignacion_ff_anp_objetivos AS ffas 
							ON ffas.id_asignacion_ff_anp_objetivos = m.id_ff_anp_subactividad
					Inner Join presupuesto_anp AS pa ON pa.id_presupuesto_anp = ffas.id_presupuesto_anp
					Inner Join presupuesto_ff AS pf ON pf.id_presupuesto_ff = pa.id_presupuesto_ff
					WHERE m.id_mes='".$_POST[idmes]."' and ffas.id_asignacion_ff_anp_objetivos = '{$anp_subactividad[id_asignacion_ff_anp_objetivos]}' {$SqlFts} ";
					
	echo $sql;
				if ($istrim){
					$sql.=" GROUP BY m.id_mes ";
				}else{
					$sql.=" GROUP BY ffas.id_asignacion_ff_anp_objetivos";
				}
				$sql.=" ORDER BY m.id_mes ASC ";

			
			$querymeta=new Consulta($sql);
			$retval=array();
			$trim1=array(1,2,3);
			$trim2=array(4,5,6);
			$trim3=array(7,8,9);
			$trim4=array(10,11,12);
			
			while($rowmeta=$querymeta->ConsultaVerRegistro()){
				if(in_array($rowmeta[id_mes],$trim1)) $id=1;
				elseif(in_array($rowmeta[id_mes],$trim2)) $id=2;
				elseif(in_array($rowmeta[id_mes],$trim3)) $id=3;
				elseif(in_array($rowmeta[id_mes],$trim4)) $id=4;
								
				$retval[cantidad][$id]=$rowmeta[total_metas];
				$retval[cantidad][0]+=$rowmeta[total_metas];
			}


			return $retval;



	}
	
function chekar_cronogramas_anp_suba_tareas($anp_subactividad,$SqlFts=''){

	$sql=" SELECT pmm.id_mes, pf.id_ff
			FROM programacion_metas_meses AS pmm
			Inner Join programacion_metas AS pm ON pmm.id_programacion_metas = pm.id_programacion_metas
			Inner Join asignacion_ff_anp_objetivos AS fas ON pm.id_ff_anp_subactividad = fas.id_asignacion_ff_anp_objetivos
			Inner Join asignacion_anp_objetivos AS asb ON asb.id_asignacion_anp_objetivos = fas.id_asignacion_anp_objetivos ,
			presupuesto_ff AS pf
			Inner Join presupuesto_anp AS pa ON pf.id_presupuesto_ff = pa.id_presupuesto_ff AND pa.id_presupuesto_anp = fas.id_presupuesto_anp
			WHERE  
			pmm.id_mes='".$_POST[idmes]."' and
			asb.id_tarea ='".$anp_subactividad[id_tarea]."' and   
			asb.id_asignacion_anp_objetivos = '".$anp_subactividad[id_asignacion_anp_objetivos]."'".$SqlFts." 
			Order by pmm.id_mes";

		$query=new Consulta($sql);
		//die(msql($sql));
		while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_mes];
			$meses[$id]="X";
		}
		
		return 	$meses;
	}
	

	function sumar_mes_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$_POST[idmes];
				if($row[total_monto]>0){
					$meses[13]=$meses[13]+$row[total_monto];
					$meses[$id]=num_format($row[total_monto]);
				}
		}
		$meses[13]=number_format($meses[13],2,".",",");
		echo $meses[13];
		return $meses;
	}
	
	function DevValTrimestre_tareas($mes,$valor){
		if (empty($mes)){
			return false;
		}
		
		if	($mes>=1 && $mes<=3){
			$idtrim=1;
		}

		if	($mes>=4 && $mes<=6){
		$idtrim=2;
		}

		if	($mes>=7 && $mes<=9){
			$idtrim=3;
		}

		if	($mes>=10 && $mes<=12){
			$idtrim=4;
		}
		$RetVal['trimestre']=$idtrim;
		$RetVal['valor']=$valor;
		return $RetVal;
	}
	
	function sumar_trimestral_programado_tareas($sql){ //suma de montos programados
		$query=new Consulta($sql);
		$num=$query->numregistros();
			while($row=$query->ConsultaVerRegistro()){
			//$id_trimestre
			$id=$row[id_mes];
				if($row[total_monto]>0){
					$trimestre[0]=$trimestre[0]+$row[total_monto];
					 $Dtrim=DevValTrimestre($id,$row[total_monto]);
					 $idtrim=$Dtrim['trimestre'];
					 $vartrim=$Dtrim['valor'];
					$trimestre[$idtrim]=$trimestre[$idtrim]+$vartrim;
					
				}
			
				

		}
		return $trimestre;
	}
	
	
	function sumar_anp_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_anp];
				if($row[total_monto]>0){
					$anp[0]=$anp[0]+$row[total_monto];
					$anp[$id]=number_format($row[total_monto],2,".",",");}
				
				
		}
		$anp[0]=number_format($anp[0],2,".",",");
		//echo $anp[0];
		return $anp;
	}
	

	
	
		function sumar_ff_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_ff];
				if($row[total_monto]>0){
					$ffto[0]=$ffto[0]+$row[total_monto];
					$ffto[$id]=number_format($row[total_monto],2,".",",");
				}
		}
		$ffto[0]=number_format($ffto[0],2,".",",");
		//echo $ffto[0];
		return $ffto;
	}
	
	function sumar_partidas_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			//$id=$_POST[idmes];
			$id=$row[id_partida];
			if($row[total_monto]>0){
					$partida[0]=$partida[0]+$row[total_monto];
					$partida[$id]=number_format($row[total_monto],2,".",",");
			}
		}
		$partida[0]=number_format($partida[0],2,".",",");
		echo $partida[0];
		return $partida;
	}
	
		function sumar_partida_mes_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$_POST[idmes];
				if($row[total_monto]>0){
					$meses[0]=$meses[0]+$row[total_monto];
					$meses[$id]=number_format($row[total_monto],2,".",",");
				}
		}
		$meses[0]=number_format($meses[0],2,".",",");
		$meses[13]=$meses[0];
		//echo $meses[13];
		return $meses;
	}
	
	
	function ObjetivoEstrategico_tareas($sql){
		//die ($sql);
		$query=new Consulta($sql);
		$row=$query->ConsultaVerRegistro();
		
		echo $row;
		return $row;
	}
	
?>
