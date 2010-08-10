<?
class reporteinformacionanp {
var $nombre_reporte;
var $axo_poa;
var $anpid;

 	function reporteinformacionanp(){
	
	} 
	
/***************************************************************************/	
	function reporte_consulta_fuentefinan($query1){	
	
$soles=0;
$dolares=0;	
$fuente="xx";
$xxx=0;
while($rows=$query1->ConsultaVerRegistro()){

	$anpnom=$rows[nombre_categoria]." ".$rows[nombre_anp];
	$cod_pre=$rows['id_presupuesto_ff'];
	$monto_anp=$rows['monto'];
						
if($xxx==0){ $xxx=1; ?>
<table border="1"  width="85%" align=center cellspacing=0 cellpadding=0 >
	<tr><td align=center><H5></H5></td></tr>	
	<TR><th colspan=4 bgcolor="#999999"> 
	<font color="#FFFFFF">LISTA DE PRESUPUESTO PROGRAMADOS A ANP - <?=$anpnom?>
	</font></th>
	</TR></table>
	<table border=0 bgcolor=white width="85%" align="center" cellspacing=1 cellpadding=2>
	<tr bgcolor=#EEEEEE>
		<td colspan=2 align=center> Siglas </td>
		<td align=center>Soles S/.</td>
		<td align=center>Dolares $</td></tr>	
					<?	}
											
						$sql1="Select fuente_financiamiento.id_ff,	fuente_financiamiento.siglas_ff,
							presupuesto_ff.tipo_cambio_ff
							From fuente_financiamiento Inner Join presupuesto_ff 
							ON fuente_financiamiento.id_ff =presupuesto_ff.id_ff and 
							presupuesto_ff.id_presupuesto_ff='".$cod_pre."'
							ORDER BY fuente_financiamiento.siglas_ff";
						
						$query2=new Consulta($sql1);
								while($rows2=$query2->ConsultaVerRegistro()){
								
								//echo "<tr><td><b><u>Fuente</u>: xx".$rm['id_ff']."xx</b></td></tr>";
								$ff=$rows2['id_ff'];		
								$sqlF="SELECT p.id_fuentefinanciamiento, p.nombre_fuentefinanciamiento 
									FROM fuente_financiamiento ff, fuentefinanciamiento p
									WHERE ff.id_ff=".$ff." and p.id_fuentefinanciamiento=ff.id_fuentefinanciamiento
									Order By siglas_fuentefinanciamiento";
									$QueryF=new Consulta($sqlF);
									while($r=$QueryF->ConsultaVerRegistro()){
										if($fuente!=$r[0]){  $fuente=$r[0];
							?> <tr><td colspan='4' bgcolor='#EEEEcc'><b><u>Fuente</u>: <?=$r[1]?>
													</b></td></tr><? 
										}
									}
								///tipo cambio año
								$sql="SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
								$Queryt= new Consulta($sql);
								$tp=$Queryt->ConsultaVerRegistro();	
								$tip=$tp[tipo_cambio];				
								////////
								$Importe_Dolar=$monto_anp/$tip;
								$soles+=$monto_anp;
								$dolares+=$Importe_Dolar;
									?><tr>
									<td width='2%'>&nbsp;</td>
									<td align=left><?=$rows2['siglas_ff']?></td>
									<td align=right><?=num_format($monto_anp)?></td>
									<td align=right><?=num_format($Importe_Dolar)?></td>
									</tr><?
					}
					
				}
		?><tr bgcolor="#999999">
						<th align="right">&nbsp;</th>
						<th align="center"><font color="#FFFFFF">Totales</font></th>
						<th align="right"><font color="#FFFFFF"><?=num_format($soles)?></font></th>
						<th align="right"><font color="#FFFFFF"><?=num_format($dolares)?></font></th>
					</tr>
					</table>
					<?
}
/************************************************************************************/	

	function reporte_consulta_personal($query1,$query2){	
		?><div align="center" style="font-size:16px;"><strong>Reporte de Personal <?=axo($_SESSION[inrena_4][2])?></strong></div> 
		<table border=0  width='85%' align=center cellspacing=0 cellpadding=0 >		
		<?
			$cont=0;
			while($rows1=$query1->ConsultaVerRegistro()){
				if($cont==0){
			?> <tr bgcolor=whitesmoke>
			<td colspan=5 align="center" bgcolor="#eeeeee" ><font size="+1">
			<b><?=anp($rows1['id_anp'])?></b></font></td>
				</tr><? } 
			$cont++;	}			
			?><tr bgcolor=#dddddd>
				<th width=25%>Apellidos</th>
				<th width=25%>Nombres</th>
				<th width=30%>Cargo</th>
				<th width=20%>DNI</th></TR> <?
				while($rows=$query2->ConsultaVerRegistro()){ ?>
				<tr>
					<td align=left><?=$rows['apellidos_personal_anp']?></td>
					<td align=left><?=$rows['nombre_personal_anp']?></td>
					<td align=left><?=$rows['nombre_cargo_anp']?></td>
					<td align=left><?=$rows['dni_personal_anp']?></td>
					
					</tr><?
								}
			?><?
	}
/************************************************************************************/	
/************************************************************************************/	
/************************************************************************************/	
/************************************************************************************/	
/************************************************************************************/	
/************************************************************************************/	


function reporte_caratula_anp($row){
	?> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td height="100%"><table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr><td height="100%"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<tr><td width="11%" height="2%" align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<tr><td  align="center"><table width="61" height="70" border="0" cellpadding="2" cellspacing="2">    <tr><td width="61" height="70"><img src="/selpo/imgs/logo4.jpg" width="50" height="49" hspace="2" vspace="2" /></td></tr>
        </table></td>
		<td width="600" align="center" bgcolor="#FFFFFF"><p style="font-size:11px"><strong>MINISTERIO DE AGRICULTURA</strong><br>
		<em><strong>INSTITUTO NACIONAL DE RECURSOS NATURALES</strong></em><br>
			<strong style="font-size:12px">INTENDENCIA DE &Aacute;REAS NATURALES PROTEGIDAS</strong></p></td><td  align="center"><table width="61" height="70" border="0" cellpadding="2" cellspacing="2">
        <tr>
		<td><img src="/selpo/imgs/inrena.jpg" width="61" height="70" /></td>
        </tr></table></td>
		</tr>
		<tr>
		<td height="50" colspan="3">&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td  height="50" align="center" bgcolor="#CCCCCC">
		<p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:22px; ">
		<strong>PLAN OPERATIVO ANUAL -<?=axo($this->axo_poa)?></strong></p></td>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td height="50" colspan="3">&nbsp;</td>
		 </tr>
		 </table></td>
		</tr>
		<tr>
		 <td align="center"><table width="520" height="420" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
		<td><?
			$archivo=$row[foto_anp];
							$ruta='../../anpfoto/';
						  if ($archivo){
							if (ereg("/imgs/",$archivo)){
								$Arimg=explode("/imgs/",$archivo);
								$ruta=$ruta.$Arimg[1];
							}else{
								$ruta='../'.$archivo;
							}
							
							if (file_exists($ruta)){
								echo '<img src="'.$ruta.'" width="520" height="420">';
							}else{
								echo "&nbsp;";
								echo "No existe archivo :: ".$ruta." ::";
							}
						  }else{
							echo "&nbsp;";
							echo "ANP no tiene foto";
						  }
					?>					</td>				</tr>
					  </table></td>
					</tr>
					<tr>
					  <td align="center" valign="bottom"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
						  <tr>
							<td>&nbsp;</td>
							<td height="50" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px">&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td height="2%" align="center" 
							style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:22px"><strong>
							  <?=$row['nombre_categoria']." de ".$row['nombre_anp']?>						</strong> </td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td><table width="61" height="70" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
							<td width="600" height="80">&nbsp;</td>
							<td><table width="61" height="70" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
						  </tr>
						  <tr>
							<td height="20">&nbsp;</td>
							<td height="20" align="center"  
							style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px; color:#FFFFFF" ><strong><!--REPROGRAMACI&Oacute;N DE--></strong> </td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td height="20">&nbsp;</td>
							<td height="50">&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
					  </table></td>
					</tr>
				</table></td>
			  </tr>
			</table></td>
		  </tr>
</table><?

}


/**************************************************************/
/**************************************************************/
/**************************************************************/
/**************************************************************/

function reporte_infomacion_poa($row){
	//print_r($row);
			?><table width="100%" align="center" border="0" cellspacing="2" cellpadding="2">
				  <tr><td class="altn" colspan="2" bgcolor="#999999"><strong>Informaci&oacute;n General
				  </strong></td></tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr><td width="14%" nowrap><strong>Siglas</strong></td>
							<td width="86%"><?=$row[siglas_anp]?></td>
						  </tr>
						  <tr>
							<td nowrap><strong>Extensi&oacute;n</strong></td>
							<td><?=number_format($row[extencion_anp])?>&nbsp;ha</td>
						  </tr>
						  <tr>
							<td nowrap><strong>Ubicaci&oacute;n</strong></td>
							<td><?=$row[nombre_departamento]?></td>
						  </tr>
						  <tr>
							<td nowrap><strong>Norma de Creaci&oacute;n </strong></td>
							<td><?=$row[norma_creacion_anp]?></td>
						  </tr>
						  <tr>
							<td nowrap><strong>Fecha de Creaci&oacute;n </strong></td>
							<td><?=$row[fecha_creacion_anp]?></td>
						  </tr>
						  <tr>
							<td valign="top" nowrap><strong>Objetivo de Creaci&oacute;n </strong>                  </td>
							<td align="justify"><?=$row[objetivo_creacion_anp]?></td>
						  </tr>
						  <tr>
							<td valign="top" nowrap><strong>Objetivo de Conservaci&oacute;n</strong></td>
							<td align="justify"><?=$row[objetivo_conservacion_anp]?></td>
						  </tr>
				</table>
			  
			  
				<table border="0" cellspacing="2" cellpadding="2" width="100%" align="center">
					<tr><td>&nbsp;</td></tr>
				    <tr><td class="altn" bgcolor="#999999"><strong>Situaci&oacute;n Actual</strong></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><?=$row[situacion_actual_anp]?></td></tr>
				</table>
			  	<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr><td>&nbsp;</td></tr>
				  	<tr><td class="altn" bgcolor="#999999"><strong>Amenazas</strong></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><?=$row[amenazas_anp]?></td></tr>
				</table>
			  	<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr><td>&nbsp;</td></tr>
					<tr><td class="altn" bgcolor="#999999"><strong>Visi&oacute;n</strong></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><?=$row[vision_anp]?></td></tr>
				</table>
			  	<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr><td>&nbsp;</td></tr>
					<tr><td class="altn" bgcolor="#999999"><strong>Misi&oacute;n</strong></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><?=$row[mision_anp]?></td></tr>
				</table>
			     <?
}


/************************************/
/*************************************/
/************************************/
/*************************************/
/************************************/
/*************************************/


function reporte_desarollo_programatico(){
	?>
	<div align="center" style="background:#FFFFFF; font-size:16px;"><strong><?=anp($_SESSION['anp']['idanp'])?></strong></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="altn">
          <tr>
            <td class="altn"><strong>Desarollo Estrat&eacute;gico </strong></td>
        </table><br />
		<? $this->reporte_d_prg_an_p();
}

function reporte_d_prg_an_p(){
		/*$sqlprg = "SELECT * FROM anp_objetivo_estrategico aoe,objetivo_estrategico oe, anp_objetivo_estrategico_meta m 
			WHERE aoe.id_objetivo_estrategico=oe.id_objetivo_estrategico 
				AND m.id_anp_objetivo_estrategico=aoe.id_anp_objetivo_estrategico
				AND id_anp='".$_SESSION['anp']['idanp']."' AND id_axo_poa='".$_SESSION['inrena_4']['2']."'
				AND id_quinquenio='".axo_quinq($_SESSION['inrena_4']['2'],'','id')."'
			ORDER BY codigo_objetivo_estrategico  ";*/
			$sqlprg="SELECT * FROM tarea Inner Join asignacion_anp_objetivos 
							ON tarea.id_tarea = asignacion_anp_objetivos.id_tarea
						Inner Join anp_objetivo_especifico aoe 
							ON aoe.id_anp_objetivo_especifico=asignacion_anp_objetivos.id_anp_objetivo_especifico
						INNER JOIN anp_objetivo_estrategico	aoet
							ON aoet.id_anp_objetivo_estrategico=aoe.id_anp_objetivo_estrategico
						INNER JOIN objetivo_estrategico oe 
							ON	aoet.id_objetivo_estrategico=oe.id_objetivo_estrategico
						INNER JOIN anp_objetivo_estrategico_meta m
							ON m.id_anp_objetivo_estrategico=aoe.id_anp_objetivo_estrategico	
				  WHERE	asignacion_anp_objetivos.id_axo_poa =  '".$_SESSION['inrena_4']['2']."' AND
						asignacion_anp_objetivos .id_anp =  '".$_SESSION['anp']['idanp']."' AND id_quinquenio='".
							axo_quinq($_SESSION['inrena_4']['2'],'','id')."'".
				" GROUP BY aoet.id_anp_objetivo_estrategico ORDER BY codigo_objetivo_estrategico";				
				//echo $sqlprg." - ";
				
				$queryprg=new Consulta($sqlprg);
				
				$nregs=$queryprg->numregistros();

				/*if ($nregs=='0'){
					 echo("<strong>El reporte no contiene datos</strong>");
					 return false;
				}*/
				
				//$rowprg=$queryprg->ConsultaVerRegistro();
				while($rowprg=$queryprg->ConsultaVerRegistro()){
				$id_programa=$rowprg[id_programa];
				?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" 
				bordercolor="#666666" id="programa">
				<tr bgcolor="#CCCCCC">
				<td class="altn" width="5%"><strong><?=$rowprg[codigo_objetivo_estrategico]."."?></strong></td>
				<td width="95%" class="altn"><strong><?=' '.$rowprg[nombre_objetivo_estrategico]?></strong></td>
				</tr>
				  <!--<tr>
					<td colspan="2"><?="<strong>Indicador:&nbsp;&nbsp;</strong>".$rowprg[indicador_objetivo_estrategico].
						"<br><strong>Unidad de Medida:&nbsp;&nbsp;</strong>".$rowprg[id_unidad_medida]?></td>
				  </tr>-->
				</table>			
				<hr />
				<?	$this->reporte_d_prg_an_sp($rowprg);?>
				<br /><?
			}
}


function reporte_d_prg_an_sp($rowprg){
			$sqlsbprg="SELECT * FROM tarea Inner Join asignacion_anp_objetivos 
							ON tarea.id_tarea = asignacion_anp_objetivos.id_tarea
						Inner Join anp_objetivo_especifico aoe 
							ON aoe.id_anp_objetivo_especifico=asignacion_anp_objetivos.id_anp_objetivo_especifico
						INNER JOIN anp_objetivo_especifico_meta m 
							ON m.id_anp_objetivo_especifico=aoe.id_anp_objetivo_especifico
				  WHERE	asignacion_anp_objetivos.id_anp_objetivo_estrategico ='".$rowprg[id_anp_objetivo_estrategico]."' AND
						asignacion_anp_objetivos.id_axo_poa =  '".$_SESSION['inrena_4']['2']."' AND
						id_anp =  '".$_SESSION['anp']['idanp']."'".
				" GROUP BY aoe.id_anp_objetivo_especifico ORDER BY codigo_objetivo_especifico";
				
			/*$sqlsbprg="SELECT * FROM anp_objetivo_especifico aoe, anp_objetivo_especifico_meta m 
				WHERE id_anp_objetivo_estrategico='".$rowprg[id_anp_objetivo_estrategico]."'
					AND id_axo_poa='".$_SESSION['inrena_4']['2']."'
					AND m.id_anp_objetivo_especifico=aoe.id_anp_objetivo_especifico
				ORDER BY codigo_objetivo_especifico  ";		*/
					
					//echo $sqlsbprg;
					
			$querysbprg=new Consulta($sqlsbprg);
			
			//$rowsbprg=$querysbprg->ConsultaVerRegistro();
										
			while($rowsbprg=$querysbprg->ConsultaVerRegistro()){
			$id_subprograma=$rowsbprg[id_subprograma];
			?> <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666" id="subprograma">
			  <tr bgcolor="#CCCCCC">
			<td class="altn" width="5%">
			<strong><?=$rowprg[codigo_objetivo_estrategico].".".$rowsbprg[codigo_objetivo_especifico]."."?>
			</strong></td>
			<td width="95%" class="altn">
			<strong><?=' '.$rowsbprg[nombre_objetivo_especifico]?></strong></td>
				  </tr>
							  <!--<tr>
								<td colspan="2" nowrap="nowrap">
								<?=$rowsbprg[descripcion_anp_objetivo_subprograma]?>                                 </td>
							  </tr>-->
							  </table>
						     <hr />					  									  
							<?
							 	$this->reporte_d_prg_an_a($rowsbprg,$rowprg);
		            }
}



function reporte_d_prg_an_a($rowsbprg,$rowprg){
							  
				$sql="SELECT * FROM tarea Inner Join asignacion_anp_objetivos 
						ON tarea.id_tarea = asignacion_anp_objetivos.id_tarea
				  WHERE	asignacion_anp_objetivos.id_anp_objetivo_estrategico ='".$rowprg[id_anp_objetivo_estrategico]."' AND
						asignacion_anp_objetivos.id_anp_objetivo_especifico ='".$rowsbprg[id_anp_objetivo_especifico]."' AND
						id_axo_poa =  '".$_SESSION['inrena_4']['2']."' AND
						id_anp =  '".$_SESSION['anp']['idanp']."'".
				" ORDER BY nro_asignacion";
			//	echo $sqla;
					$querya=new Consulta($sql);
					
					//$rowa=$querya->ConsultaVerRegistro();

					while($rowa=$querya->ConsultaVerRegistro()){
					$id_actividad=$rowa[id_actividad];
					?><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666" id="subactividad">
				<tr bgcolor="#CCCCCC">
					<td class="altn" width="5%"><strong>
				<?=$rowprg[codigo_objetivo_estrategico].".".$rowsbprg[codigo_objetivo_especifico].".".$rowa[nro_asignacion]."."?>
					</strong></td>
					<td class="altn" width="95%"><strong><?=' '.$rowa[nombre_tarea]?></strong></td>
				</tr>
				 <!-- <tr><td colspan="2" width="100%" >
					  <br /><strong>Descripci&oacute;n</strong></td>
					</tr>
					<tr><td colspan="2" ><? //=nl2br($rowsa[resultado_esperado_asignacion])?><br /><br /></td></tr>-->
					<tr><td colspan="2"><strong>Resultados Esperados</strong> </td></tr>
					<tr><td colspan="2" ><?=$rowa[resultado_esperado_asignacion]?><br /><br /></td></tr>
					<tr><td colspan="2"><strong>Meta</strong></td></tr>
					<tr><td colspan="2"><? echo $this->sumar_metas_meses($rowa)." ".$rowa[medio_verificacion_tarea];
								  ?><br /><br /></td>
								</tr>
								<tr>
								  <td colspan="2"><strong>Costo Programado</strong></td>
								</tr>
								<? 
										$this->reporte_ff_sa($rowa);
								 ?>
								</table><hr /><br />	  
						<? //$this->reporte_ff_sa($rowa);
				}										
}

function reporte_ff_sa($rowsa){
			$sql="SELECT Sum(programacion_partidas_meses.monto_programacion_partidas_meses) as monto ,
							fuente_financiamiento.siglas_ff
					FROM programacion_partidas
						Inner Join programacion_partidas_meses 
					ON programacion_partidas.id_programacion_partidas = programacion_partidas_meses.id_programacion_partidas
						Inner Join asignacion_ff_anp_objetivos 
				ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = programacion_partidas.id_ff_anp_subactividad
					Inner Join presupuesto_anp 
						ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
					Inner Join presupuesto_ff ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
					Inner Join fuente_financiamiento ON fuente_financiamiento.id_ff = presupuesto_ff.id_ff
					WHERE id_asignacion_anp_objetivos = '".$rowsa[id_asignacion_anp_objetivos]."' ".
					permisos_fuente($_SESSION['inrena_4'][1],'presupuesto_ff').
					" GROUP BY fuente_financiamiento.id_ff ORDER BY fuente_financiamiento.siglas_ff";
			//echo ($sql."<br>");
			$queryff=new Consulta($sql);
			while($rowff=$queryff->ConsultaVerRegistro()){
					if (!empty($rowff[monto])){ ?>
					<tr>
						<td width="9%" nowrap><?=$rowff[siglas_ff]?></td>
						<td width="91%"><?='&nbsp;&nbsp; S/ '.num_format($rowff[monto])?></td>
					</tr>
				<?
				}
			
			}
		}

	function reporte_meta_sa($rowsa){
		return  suma_meta_anp_subactividad($rowsa,'',true);
	}
	
	function sumar_metas_meses($row){
		$sql="SELECT Sum(metas_meses.cantidad_metas_meses) FROM metas_meses
				Inner Join asignacion_ff_anp_objetivos 
					ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = metas_meses.id_ff_anp_subactividad
				Inner Join presupuesto_anp 
						ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
				Inner Join presupuesto_ff ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
			WHERE id_asignacion_anp_objetivos='".$row[id_asignacion_anp_objetivos]."' ".
				permisos_fuente($_SESSION['inrena_4'][1],'presupuesto_ff');
		//echo $sql."<br>";
		$queryffmonto=new Consulta($sql);
		$row=$queryffmonto->ConsultaVerRegistro();
		$monto=0; 
		if($row[0]>0) $monto=$row[0];
		return	$monto;	
	}
/************************************************************************************/	
//fin de clase
}
?>