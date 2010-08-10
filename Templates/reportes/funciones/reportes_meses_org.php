<?
session_start();
function Verkff($functjs='',$ClassObj=''){
		$anpid=$ClassObj->anpid;
		//$this=$ClassObj->$this;
		//$anpid=$_SESSION['anp']['idanp'];
		$query=new Consulta($sql=$ClassObj->set_sql("m.id_mes, m.nombre_mes","","m.id_mes"));
		//echo $sql;
		?>
<style type="text/css">
<!--
.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body,td,th {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
body {
	background-color: #00CCCC;
}
-->
</style>
		
					<br>
					<table width="85%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#00CCCC"> 
						<tr>
						  <td colspan="4" align="center"><span class="Estilo1"><br />
					          <span class="Estilo3">Seleccione el Mes </span></span></td>
		 			  </tr>
						<tr>
						  <td height="46" colspan="4" align="center"><p class="Estilo1">
						    <select name="idmes" >
                              <option value="">Elija el Mes</option>
                              
                              <?
						while($row_ffs=$query->ConsultaVerRegistro()){
						if($_POST[idmes]==$row_ffs['id_mes']) $select="selected"; else $select=""; ?>
                        <option value="<?=$row_ffs['id_mes']?>"><?=$row_ffs['nombre_mes']?></option><?  } ?>
                            </select>  
                                                                                                                
						  </p>				                  </td>
				    </tr>
			
					<? 
					/*$queryfte=new Consulta($row_ffs=$ClassObj->set_sql("ff.id_fuentefinanciamiento", " and m.id_mes='".$_POST[idmes]."'","ff.id_fuentefinanciamiento"));*/
					$queryfte=new Consulta($row_ffs=$ClassObj->set_sql("ff.id_fuentefinanciamiento", " ","ff.id_fuentefinanciamiento"));
					if ($queryfte->numregistros()){
			
					while($row=$queryfte->ConsultaVerRegistro()){
						$row_ff=table_row($row['id_fuentefinanciamiento'],"fuentefinanciamiento");?>
							<tr>
							  <td width="9%" align="right">&nbsp;</td>
							  <td colspan="3" align="left">
						        <em><strong><?=$row_ff[nombre_fuentefinanciamiento]?></strong></em></td>
						     </tr>
							 	<?
////$querryject=new Consulta ($sqlejct= $ClassObj->set_sql("ff.id_ff,ff.nombre_ff"," AND ff.id_fuentefinanciamiento='".$row[id_fuentefinanciamiento]."' and m.id_mes='".$_POST[idmes]."'","ff.id_ff","ff.id_ff"));

$querryject=new Consulta ($sqlejct= $ClassObj->set_sql("ff.id_ff,ff.nombre_ff"," AND ff.id_fuentefinanciamiento='".$row[id_fuentefinanciamiento]."' ","ff.id_ff","ff.id_ff"));


							//echo $sqlejct;
					while($rowej=$querryject->ConsultaVerRegistro()){?>

						
											  <tr>
												<td colspan="2" align="right">
											    <!-- <input type="checkbox" name="checkbox" value="checkbox" /> -->
											    <input name="S2[]" type="checkbox"  value="<?=$rowej[id_ff]?>"  /></td>
												<td width="2%">&nbsp;</td>
												<td width="76%"><?=$rowej[nombre_ff]?></td>
											</tr>
										<?			}						
								
									
							} 
							
							?><tr>
								<td colspan="2">&nbsp; 			</td>
								<td>&nbsp; 			</td>
								<td>&nbsp; 			</td>
							</tr>
							
							<tr>
								<td colspan=4 align=center>
								<p><br /><br />	
								<span class="Estilo5 Estilo1">Mostrar el Reporte </span></p>
										<p align="center">
										  <?
							 
		
											if (empty($anpid)){
											$functjs=$functjs."()";
											}
											else{
											$functjs= $functjs."('".$anpid."')";
											}
											
											$_SESSION[idmes]=$_POST[idmes];
											
							?>
				                 <!--   <a href="../informacionanp/presupuestomensualporpartidas.php" onclick="'.$functjs.'"> -->
										<a href="#" onclick="'.$functjs.'">
				              <img src="../../imgs/b_select.png" width="16" height="16" border="0" align="middle"> </a>                              </p>                              </td>
							</tr>
						</table>
				   
			        <div align="center" class="Estilo3">
			          <? 
				
				} else { ?>
			          <strong style="font:Verdana, Arial, Helvetica, sans-serif; color:#FF0000"> Seleccione el Mes o su Anp no tiene datos programados En este AÑO</strong>		              </div>
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
					WHERE
					m.id_mes='".$_SESSION[idmes]."' and
					ffas.id_asignacion_ff_anp_objetivos = '{$anp_subactividad[id_asignacion_ff_anp_objetivos]}' {$SqlFts} ";
					
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

	$sql=" SELECT *
			
			FROM programacion_metas_meses AS pmm,
			programacion_metas AS pm,
			asignacion_ff_anp_objetivos AS fas,
			asignacion_anp_objetivos AS asb,
			presupuesto_ff AS pf,
			presupuesto_anp AS pa
			WHERE
			pmm.id_programacion_metas = pm.id_programacion_metas AND
			pm.id_ff_anp_subactividad = fas.id_asignacion_ff_anp_objetivos AND
			asb.id_asignacion_anp_objetivos = fas.id_asignacion_anp_objetivos AND
			pa.id_presupuesto_anp = fas.id_presupuesto_anp AND
			pf.id_presupuesto_ff = pa.id_presupuesto_ff AND 
			pmm.id_mes='".$_SESSION[idmes]."' and
			asb.id_tarea ='".$anp_subactividad[id_tarea]."' and   
			asb.id_asignacion_anp_objetivos = '".$anp_subactividad[id_asignacion_anp_objetivos]."'".$SqlFts." 
			Order by pmm.id_mes";

		$query=new Consulta($sql);
		//die(msql($sql));
		while($row=$query->ConsultaVerRegistro()){
			$id=$_SESSION[idmes];
			$meses[$id]="X";
		}
		
		return 	$meses;
	}
	

/*	function sumar_mes_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
				if($row[total_monto]>0){
					$meses[13]=$meses[13]+$row[total_monto];
					$meses[$id]=number_format($row[total_monto],2,".",",");
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
	}*/
	
	
	/*function sumar_anp_programado_tareas($sql){
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
	}*/
	
	function sumar_partidas_programado_tareas($sql){
	
	/*$sql=" SELECT ****Sum(`ppm`.`monto_programacion_partidas_meses`) AS `total_monto`,pp.*,pf.*,pa.*
			FROM
			`asignacion_ff_anp_objetivos` AS `fas` ,
			`asignacion_anp_objetivos` AS `asb` ,
			`presupuesto_ff` AS `pf` ,
			`presupuesto_anp` AS `pa` ,
			`programacion_partidas_meses` AS `ppm` ,
			`programacion_partidas` AS `pp`
			WHERE
			`fas`.`id_asignacion_ff_anp_objetivos` =  `pp`.`id_ff_anp_subactividad` AND
			`pp`.`id_programacion_partidas` =  `ppm`.`id_programacion_partidas` AND
			`asb`.`id_asignacion_anp_objetivos` =  `fas`.`id_asignacion_anp_objetivos` AND
			`pa`.`id_presupuesto_anp` =  `fas`.`id_presupuesto_anp` AND
			`pf`.`id_presupuesto_ff` =  `pa`.`id_presupuesto_ff` AND
			asb.id_asignacion_anp_objetivos = '".$anp_subactividad[id_asignacion_anp_objetivos]."'".$SqlFts." and
			ppm.id_mes= '".$_SESSION[idmes]."'
			GROUP BY			`pp`.`id_partida`
			ORDER BY
			`ppm`.`id_mes` ASC,
			`pp`.`id_partida` ASC ";*/

		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_partida];
			if($row[total_monto]>0){
					$partida[0]=$partida[0]+$row[total_monto];
					$partida[$id]=number_format($row[total_monto],2,".",",");
			}
		}
		$partida[0]=number_format($partida[0],2,".",",");
		//echo $partida[0];
		return $partida;
	}
	
		/*function sumar_partida_mes_programado_tareas($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
				if($row[total_monto]>0){
					$meses[0]=$meses[0]+$row[total_monto];
					$meses[$id]=number_format($row[total_monto],2,".",",");
				}
		}
		$meses[0]=number_format($meses[0],2,".",",");
		$meses[13]=$meses[0];
		echo $meses[13];
		return $meses;
	}*/
	
	
	function ObjetivoEstrategico_tareas($sql){
		//die ($sql);
		$query=new Consulta($sql);
		$row=$query->ConsultaVerRegistro();
		
		//echo $row;
		return $row;
	}
	
?>