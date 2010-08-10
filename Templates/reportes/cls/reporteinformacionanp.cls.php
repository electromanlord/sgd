<?
class reporteinformacionanp {
var $nombre_reporte;
var $axo_poa;
var $anpid;

 	function reporteinformacionanp(){
	
	} 
	
/***************************************************************************/	
	function reporte_consulta_fuentefinan($anpid){	
	
$soles=0;
$dolares=0;	
$fuente="xx";
$xxx=0;
$sql_F=" SELECT Sum(`pa`.`monto_presupuesto_anp`) AS `monto`, `pa`.`id_presupuesto_ff`, `pff`.`id_ff`, `pff`.`id_axo_poa`,
				`c`.`nombre_categoria`,	`a`.`nombre_anp`
		FROM
		`presupuesto_anp` AS `pa`,
		`presupuesto_ff` AS `pff`,
		`anp` AS `a` ,
		`categoria` AS `c`
		WHERE
		`pa`.`id_presupuesto_ff` = `pff`.`id_presupuesto_ff` and
		`pa`.`id_anp` = `a`.`id_anp` and
		`a`.`id_categoria` = `c`.`id_categoria` and
		`pa`.`id_anp` =  '".$anpid."' AND
		`pff`.`id_axo_poa` =  '".$_SESSION['inrena_4'][2]."'
		GROUP BY
		`pff`.`id_ff` ";
$Query=new Consulta($sql_F);	
while($rows=$Query->ConsultaVerRegistro()){

	$anpnom=$rows[nombre_categoria]." ".$rows[nombre_anp];
	$cod_pre=$rows['id_presupuesto_ff'];
	$monto_anp=$rows['monto'];
						
if($xxx==0){ $xxx=1; ?>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>

	<table border="1"  width="85%" align=center cellspacing=0 cellpadding=0 >
	<tr><td align=center><H5></H5></td></tr>	
	<TR><th colspan=4 bgcolor="#999999"> 
	<font color="#FFFFFF">LISTA DE PRESUPUESTO ASIGNADOS A ANP - <?=$anpnom?>
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
									
								$tip=$rows2['tipo_cambio_ff'];					
								$Importe_Dolar=$monto_anp/$tip;
								$soles+=$monto_anp;
								$dolares+=$Importe_Dolar;
									?><tr>
									<td width='2%'>&nbsp;</td>
									<td align=left><?=$rows2['siglas_ff']?></td>
									<td align=right><?=number_format($monto_anp,2,".",",");?></td>
									<td align=right><?=number_format($Importe_Dolar,2,".",",");?></td>
									</tr><?
					}
					
				}
		?><tr bgcolor="#999999">
						<th align="right">&nbsp;</th>
						<th align="center"><font color="#FFFFFF">Totales</font></th>
						<th align="right"><font color="#FFFFFF"><?=number_format($soles,2,".",",");?></font></th>
						<th align="right"><font color="#FFFFFF"><?=number_format($dolares,2,".",",");?></font></th>
					</tr>
					</table>
					<?
}
/************************************************************************************/	

	function reporte_consulta_personal($query1,$query2){	
		?> <table border=0  width='85%' align=center cellspacing=0 cellpadding=0 >		
		<?
			$cont=0;
			while($rows1=$query1->ConsultaVerRegistro()){
				if($cont==0){
			?> <tr bgcolor=whitesmoke>
			<td colspan=5 align="center" bgcolor="#eeeeee" ><font size="+1">
			<b><?=$rows1['nombre_anp']?></b></font></td>
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
			?></table> <?
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
					?>	  
					</td>				</tr>
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
			     <table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr><td>&nbsp;</td></tr>
				 	<tr><td class="altn" bgcolor="#999999"><strong>Estrategias</strong></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td><?=$row[estrategias_anp]?></td></tr>
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
	?><table width="100%" border="0" cellpadding="0" cellspacing="0" class="altn">
          <tr>
            <td class="altn"><strong>Desarollo Program&aacute;tico </strong></td>
        </table><br />
		<? $this->reporte_d_prg_an_p();
}

function reporte_d_prg_an_p(){
/*
				$sqlprg="SELECT p.*, aop.descripcion_anp_objetivo_programa FROM programa AS p Inner Join anp_objetivo_programa AS aop ON aop.id_programa = p.id_programa WHERE aop.id_anp =  '".$this->anpid."' AND aop.id_axo_poa =  '".$this->axo_poa."' ORDER BY p.id_programa ASC";*/
				
				$sqlprg="SELECT p.*, aop.descripcion_anp_objetivo_programa FROM programa p,anp_objetivo_programa aop 
						WHERE aop.id_programa = p.id_programa AND aop.id_anp = '".$this->anpid."' 
						AND aop.id_axo_poa = '".$this->axo_poa."' 
						ORDER BY p.id_programa ASC";
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
				<td class="altn" width="15%"><strong><?=$rowprg[codigo_programa]."."?></strong></td>
				<td class="altn"><strong><?='Programa de '.$rowprg[nombre_programa]?></strong>
				</td></tr>
				  <tr>
					<td colspan="2"><?=$rowprg[descripcion_anp_objetivo_programa]?></td>
				  </tr>
				</table>			
				<hr />
				<?	$this->reporte_d_prg_an_sp($rowprg);?>
				<br /><?
			}
}


function reporte_d_prg_an_sp($rowprg){
		$sqlsbprg="SELECT sb.*, aos.descripcion_anp_objetivo_subprograma FROM anp_objetivo_subprograma AS aos Inner Join subprograma AS sb ON sb.id_subprograma = aos.id_subprograma
					WHERE aos.id_axo_poa =  '".$this->axo_poa."' AND sb.id_programa =  '".$rowprg[id_programa]."' AND aos.id_anp =  '".$this->anpid."' ORDER BY sb.id_subprograma ASC";
					
					//echo $sqlsbprg;
					
			$querysbprg=new Consulta($sqlsbprg);
			
			//$rowsbprg=$querysbprg->ConsultaVerRegistro();
										
			while($rowsbprg=$querysbprg->ConsultaVerRegistro()){
			$id_subprograma=$rowsbprg[id_subprograma];
			?> <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666" id="subprograma">
			  <tr bgcolor="#CCCCCC">
			<td class="altn" width="15%">
			<strong><?=$rowprg[codigo_programa].".".$rowsbprg[codigo_subprograma]."."?>
			</strong></td><td class="altn">
			<strong><?='SubPrograma '.$rowsbprg[nombre_subprograma]?></strong></td>
							  </tr>
							  <tr>
								<td colspan="2" nowrap="nowrap">
								<?=$rowsbprg[descripcion_anp_objetivo_subprograma]?>
                                 </td>
							  </tr>
							  </table>
						     <hr />					  									  
							<?
							 	$this->reporte_d_prg_an_a($rowsbprg,$rowprg);
		            }
}



function reporte_d_prg_an_a($rowsbprg,$rowprg){
							  
				$sqla="SELECT a.* FROM anp_subactividad AS asa
				Inner Join subactividad AS sa ON asa.id_subactividad = sa.id_subactividad
				Inner Join actividad AS a ON sa.id_actividad = a.id_actividad
				Inner Join subprograma AS sp ON sp.id_subprograma = a.id_subprograma
				WHERE asa.id_anp =  '".$this->anpid."' AND asa.id_axo_poa =  '".$this->axo_poa."' AND sp.id_subprograma=  '".$rowsbprg[id_subprograma]."' GROUP BY a.id_actividad  ORDER BY a.id_actividad ASC";
			//	echo $sqla;
					$querya=new Consulta($sqla);
					
					//$rowa=$querya->ConsultaVerRegistro();

					while($rowa=$querya->ConsultaVerRegistro()){
					$id_actividad=$rowa[id_actividad];
					?><table width="100%" border="0" cellpadding="0" cellspacing="0" 
									bordercolor="#666666" id="actividad">
                           <tr bgcolor="#CCCCCC">
							<td class="altn" width="15%"><strong>
	<?=$rowprg[codigo_programa].".".$rowsbprg[codigo_subprograma].".".$rowa[codigo_actividad]."."?>
	</strong></td><td class="altn"><strong><?=$rowa[nombre_actividad]?></strong></td>
                                      </tr>
                                  </table>
						<br />		  
						<?  $this->reporte_d_prg_an_sba($rowsbprg,$rowprg,$rowa);
				}										
}






function reporte_d_prg_an_sba($rowsbprg,$rowprg,$rowa){
	$sqlsa= "select asa.*,sa.nombre_subactividad,sa.codigo_completo_subactividad
	FROM anp_subactividad AS asa Inner Join subactividad AS sa ON asa.id_subactividad = sa.id_subactividad Inner Join actividad AS a ON sa.id_actividad = a.id_actividad Inner Join subprograma AS sp ON sp.id_subprograma = a.id_subprograma
	WHERE asa.id_anp = '".$this->anpid."' AND asa.id_axo_poa = '".$this->axo_poa."' AND a.id_actividad= '".$rowa[id_actividad]."'	ORDER BY sa.id_subactividad ASC";
	
	//echo $sqlsa;
	$querysa=new Consulta($sqlsa);
	//$rowsa=$querysa->ConsultaVerRegistro();
	
	while($rowsa=$querysa->ConsultaVerRegistro()){
?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666" 
			id="subactividad">
				<tr bgcolor="#CCCCCC">
					<td class="altn" width="15%"><strong>
					<?=$rowsa[codigo_completo_subactividad]?></strong></td>
					<td class="altn" width="85%"><strong>
							<?='  Sub Actividad	'.$rowsa[nombre_subactividad]?>
											  </strong></td></tr>
							  <tr>
								  <td colspan="2" width="100%" >
								  <br /><strong>Descripci&oacute;n</strong></td>
							</tr>
								<tr>
								  <td colspan="2" >
								  <?=nl2br($rowsa[descripcion_anp_subactividad])?><br /><br />
								  </td>
								</tr>
								<tr>
								  <td colspan="2"><strong>Resultados Esperados</strong> </td>
								</tr>
								<tr>
				 <td colspan="2" >
				 <?=$rowsa[resultado_esperado_anp_subactividad]?><br /><br /></td>
								</tr>
								<tr>
								  <td colspan="2"><strong>Meta</strong></td>
								</tr>
								<tr>
								  <td colspan="2"><?
								  $rowm=$this->reporte_meta_sa($rowsa);
								  echo $rowm[cantidad][0]." ".$rowm[nombre][0];
								  ?><br /><br /></td>
								</tr>
								<tr>
								  <td colspan="2"><strong>Costo Programado</strong></td>
								</tr>
								<? 
										$this->reporte_ff_sa($rowsa);
								 ?>
								</table><hr /><br /><?	}
}

		function reporte_ff_sa($rowsa){
			$sql="SELECT fas.monto_ff_anp_subactividad as monto,  asa.siglas_ff, fas.id_ff_anp_subactividad
			FROM ff_anp_subactividad AS fas Inner Join anp_subactividad AS asb ON asb.id_anp_subactividad = fas.id_anp_subactividad
			Inner Join presupuesto_anp AS pa ON pa.id_presupuesto_anp = fas.id_presupuesto_anp Inner Join presupuesto_ff AS pf ON pf.id_presupuesto_ff = pa.id_presupuesto_ff
			Inner Join fuente_financiamiento AS asa ON asa.id_ff = pf.id_ff Inner Join subactividad AS sa ON sa.id_subactividad = asb.id_subactividad
			WHERE asb.id_axo_poa =  '".$this->axo_poa."' AND asb.id_anp =  '".$this->anpid."' AND asb.id_subactividad =  '".$rowsa[id_subactividad]."'
			GROUP BY pf.id_ff
			ORDER BY sa.id_subactividad ASC";
			//echo ($sql."<br>");
			$queryff=new Consulta($sql);
			while($rowff=$queryff->ConsultaVerRegistro()){
					$monto=$this->sumar_programacion_meses($rowff);
					if (!empty($monto[monto])){ ?>
					<tr>
						<td width="9%" nowrap><?=$rowff[siglas_ff]?></td>
						<td width="91%"><?=' S/ '.num_format($monto[monto])?></td>
					</tr>
				<?
				}
			
			}
		}

	function reporte_meta_sa($rowsa){
		return  suma_meta_anp_subactividad($rowsa,'',true);
	}
	
	function sumar_programacion_meses($rowff){
		$sql="SELECT
		ppm.id_mes,
		Sum(ppm.monto_programacion_partidas_meses) AS monto
		FROM
		ff_anp_subactividad AS fas
		Inner Join programacion_partidas AS pp ON pp.id_ff_anp_subactividad = fas.id_ff_anp_subactividad
		Inner Join programacion_partidas_meses AS ppm ON ppm.id_programacion_partidas = pp.id_programacion_partidas
		where fas.id_ff_anp_subactividad='".$rowff[id_ff_anp_subactividad]."'
		group by fas.id_ff_anp_subactividad
		";
		//echo $sql."<br>";
			$queryffmonto=new Consulta($sql);
		return	$queryffmonto->ConsultaVerRegistro();
		
	
	}
/************************************************************************************/	
//fin de clase
}
?>