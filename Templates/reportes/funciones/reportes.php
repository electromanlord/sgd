<?
function VerChkff($functjs='',$ClassObj=''){
		$anpid=$ClassObj->anpid;
		$query=new Consulta($sql=$ClassObj->set_sql("ff.id_fuentefinanciamiento",
		" ","ff.id_fuentefinanciamiento"));
		//echo $sql;
		if ($query->numregistros()){
					echo'<br>	
					<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
								<td width="9%" align="right">&nbsp;</td>
							<td width="91%"><u><strong>Fuentes y Ejecutores Asociados </strong></u></td>
					  	</tr>
					</table>		
					
					<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center"> 
							<tr>
							  <td colspan="3" align="right">&nbsp;</td>
							  <td>&nbsp;</td>
					 		 </tr>';
					 while($row=$query->ConsultaVerRegistro()){
						$row_ff=table_row($row['id_fuentefinanciamiento'],"fuentefinanciamiento");
							echo '<tr>
							  <td width="9%" align="right">&nbsp;</td>
							  <td colspan="3" align="left">
						        <em><strong>'.$row_ff[nombre_fuentefinanciamiento].'</strong></em></td>
						     </tr>';
							 	
									$querryject=new 
												Consulta (
														$sqlejct= 
														$ClassObj->set_sql(
																			"ff.id_ff,ff.nombre_ff",
																			" AND ff.id_fuentefinanciamiento='".$row[id_fuentefinanciamiento]."'","ff.id_ff",
																			"ff.id_ff")
														);
														//echo $sqlejct;
										while($rowej=$querryject->ConsultaVerRegistro()){

										echo'	 <tr>
												<td colspan="2" align="right">
													 <!-- <input type="checkbox" name="checkbox" value="checkbox" /> -->
													  <input type="checkbox" name="S2[]" value="'.$rowej['id_ff'].'" />
												</td>
												<td width="2%">&nbsp;</td>
												<td width="76%">'.$rowej[nombre_ff].'</td>
											</tr>';
											} 
								
									
							} 
							
							echo '<tr>
								<td colspan="2">&nbsp; 			</td>
								<td>&nbsp; 			</td>
								<td>&nbsp; 			</td>
							</tr>
							
							<tr>
									<td colspan=4 align=center>
										<br /><br />	
										Mostrar el Reporte	
											';
											if (empty($anpid)){
												 $functjs=$functjs."()";
											}else{
												 $functjs= $functjs."('".$anpid."')";
											}
										///echo "'.$functjs.'";	
							echo '<a href="#" onclick="'.$functjs.'">	
									<img src="../../imgs/b_select.png" border="0">	 </a>				
									</td>
							</tr>
						</table>';
				}else{
					 echo '<center> <strong style="font:Verdana, Arial, Helvetica, sans-serif; color:#FF0000"> Anp no tiene datos programados En este AÑO</strong></center>';
				}	
}

function ResolverArrayFF($A){
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

	

	function suma_meta_anp_subactividad($anp_subactividad,$SqlFts='',$istrim=''){
			
			$sql="SELECT m.*, Sum(m.cantidad_metas_meses) AS total_metas 
					FROM
					metas_meses AS m,
					asignacion_ff_anp_objetivos AS ffas, 
					presupuesto_anp AS pa ,
					presupuesto_ff AS pf
					WHERE
					ffas.id_asignacion_ff_anp_objetivos = m.id_ff_anp_subactividad and
					pa.id_presupuesto_anp = ffas.id_presupuesto_anp and
					 pf.id_presupuesto_ff = pa.id_presupuesto_ff and
					ffas.id_asignacion_ff_anp_objetivos = '{$anp_subactividad[id_asignacion_ff_anp_objetivos]}' {$SqlFts} ";
					

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
	
function chekar_cronogramas_anp_suba($anp_subactividad,$SqlFts=''){

	$sql=" SELECT pmm.id_mes, pf.id_ff
			FROM programacion_metas_meses AS pmm,
			programacion_metas AS pm ,
			asignacion_ff_anp_objetivos AS fas, 
			asignacion_anp_objetivos AS asb, 
			presupuesto_ff AS pf,
			presupuesto_anp AS pa 
			WHERE
			pmm.id_programacion_metas = pm.id_programacion_metas and
			pm.id_ff_anp_subactividad = fas.id_asignacion_ff_anp_objetivos and
			asb.id_asignacion_anp_objetivos = fas.id_asignacion_anp_objetivos and
			pf.id_presupuesto_ff = pa.id_presupuesto_ff AND
			 pa.id_presupuesto_anp = fas.id_presupuesto_anp and
			asb.id_tarea ='".$anp_subactividad[id_tarea]."' and   
			asb.id_asignacion_anp_objetivos = '".$anp_subactividad[id_asignacion_anp_objetivos]."'".$SqlFts." 
			GROUP BY pmm.id_mes
			Order by pmm.id_mes";

		$query=new Consulta($sql);
		//die(msql($sql));
		while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_mes];
			$meses[$id]="X";
		}
		
		return 	$meses;
	}
	

	function sumar_mes_programado($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_mes];
				if($row[total_monto]>0){
					$meses[13]=$meses[13]+$row[total_monto];
					$meses[$id]=num_format($row[total_monto]);
				}
		}
		$meses[13]=num_format($meses[13]);
		return $meses;
	}
	
	function DevValTrimestre($mes,$valor){
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
	
	function sumar_trimestral_programado($sql){ //suma de montos programados
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
	
	
	function sumar_anp_programado($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_anp];
				if($row[total_monto]>0){
					$anp[0]=$anp[0]+$row[total_monto];
					$anp[$id]=num_format($row[total_monto]);
				}
		}
		$anp[0]=num_format($anp[0]);
		return $anp;
	}
	

	
	
		function sumar_ff_programado($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_ff];
				if($row[total_monto]>0){
					$ffto[0]=$ffto[0]+$row[total_monto];
					$ffto[$id]=num_format($row[total_monto]);
				}
		}
		$ffto[0]=num_format($ffto[0]);
		return $ffto;
	}
	
	function sumar_partidas_programado($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_partida];
			if($row[total_monto]>0){
					$partida[0]=$partida[0]+$row[total_monto];
					$partida[$id]=num_format($row[total_monto]);
			}
		}
		$partida[0]=num_format($partida[0]);
		return $partida;
	}
	
		function sumar_partida_mes_programado($sql){
		$query=new Consulta($sql);
			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_mes];
				if($row[total_monto]>0){
					$meses[0]=$meses[0]+$row[total_monto];
					$meses[$id]=num_format($row[total_monto]);
				}
		}
		$meses[0]=num_format($meses[0]);
		$meses[13]=$meses[0];
		return $meses;
	}
	
	
	function ObjetivoEstrategico($sql){
		//die ($sql);
		$query=new Consulta($sql);
		$row=$query->ConsultaVerRegistro();
		return $row;
	}
	
?>