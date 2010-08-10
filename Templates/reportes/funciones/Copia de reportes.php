<?
function VerChkff($functjs='',$ClassObj=''){
		$anpid=$ClassObj->anpid;
		$query=new Consulta($sql=$ClassObj->set_sql("ff.id_fuentefinanciamiento","","ff.id_fuentefinanciamiento"));

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
				$sql="SELECT m.*,
				Sum(m.cantidad_meta) AS total_metas,
				nombre_unidad_medida
				FROM metas AS m
				Inner Join ff_anp_subactividad AS ffas ON ffas.id_ff_anp_subactividad = m.id_ff_anp_subactividad ,
				unidad_medida
				Inner Join anp_subactividad ON unidad_medida.id_unidad_medida = anp_subactividad.id_unidad_medida AND anp_subactividad.id_anp_subactividad = ffas.id_anp_subactividad
				Inner Join presupuesto_anp AS pa ON pa.id_presupuesto_anp = ffas.id_presupuesto_anp
				Inner Join presupuesto_ff AS pf ON pf.id_presupuesto_ff = pa.id_presupuesto_ff
				WHERE ffas.id_anp_subactividad =  '".$anp_subactividad[id_anp_subactividad]."' ".$SqlFts." GROUP BY ffas.id_anp_subactividad";

				if ($istrim){
				$sql.=", m.id_trimestre ";
				}
				$sql.=" ORDER BY m.id_trimestre ASC ";
				//die ($sql);
			$querymeta=new Consulta($sql);
			while($rowmeta=$querymeta->ConsultaVerRegistro()){
				$id=$rowmeta[id_trimestre];
				$retval[cantidad][$id]=$rowmeta[total_metas];
				$retval[cantidad][0]+=$rowmeta[total_metas];
				$retval[nombre][0]=$rowmeta[nombre_unidad_medida];
			}
			return $retval;
	}
	
function chekar_cronogramas_anp_suba($anp_subactividad,$SqlFts=''){

	$sql=" SELECT pmm.id_mes, pf.id_ff
			FROM programacion_metas_meses AS pmm
			Inner Join programacion_metas AS pm ON pmm.id_programacion_metas = pm.id_programacion_metas
			Inner Join ff_anp_subactividad AS fas ON pm.id_ff_anp_subactividad = fas.id_ff_anp_subactividad
			Inner Join anp_subactividad AS asb ON asb.id_anp_subactividad = fas.id_anp_subactividad ,
			presupuesto_ff AS pf
			Inner Join presupuesto_anp AS pa ON pf.id_presupuesto_ff = pa.id_presupuesto_ff AND pa.id_presupuesto_anp = fas.id_presupuesto_anp
			WHERE  asb.id_subactividad ='".$anp_subactividad[id_subactividad]."' and   
			asb.id_anp_subactividad = '".$anp_subactividad[id_anp_subactividad]."'".$SqlFts." order by pmm.id_mes";

		$query=new Consulta($sql);
		
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
	
	
	
	function sumar_trimestral_programado($sql){ //suma de montos programados
		$query=new Consulta($sql);
		$num=$query->numregistros();

			while($row=$query->ConsultaVerRegistro()){
			$id=$row[id_trimestre];

				if($row[total_monto]>0){
					$trimestre[0]=$trimestre[0]+$row[total_monto];
					$trimestre[$id]=num_format($row[total_monto]);
				}

		}
		$trimestre[0]=num_format($trimestre[0]);
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
		return $meses;
	}
	
	
	function ObjetivoEstrategico($sql){
	
	}
	
	

function BuscarAr($Aa='',$dato=''){
if  (empty($dato)){
	return false;
}
	for ($i=0;$i<count($Aa);$i++){
		if($Aa[$i]==$dato){
			return true;	
		}
	}
	return false;
}
?>