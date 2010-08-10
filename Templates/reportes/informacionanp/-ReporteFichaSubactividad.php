<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?>
<?
  include("../../includes.php");
	require_once("../libs/verificar.inc.php");
	require_once("../../formulacion/cls/programacion.cls.php");
	require_once("../../configuracion/cls/actividad.cls.php");
	require_once("../../configuracion/cls/subactividad.cls.php");
require("../libs/verificar.inc.php"); 
	
	if ($id_var>0){
		$id=$id_var;
		$_SESSION['id_ff_anp']="";
		$_SESSION['id_ff_anp'][0]=$id_var;
		$numpags=1;
		$pga=1;
	}else{
			$numpags=count($_SESSION['id_ff_anp']);
	}
	
	if(!$pga){
	$id=$_SESSION['id_ff_anp'][0];
	$pga=1;
	}
	
	$link=new Conexion();
	
	$sql="SELECT * FROM ff_anp_subactividad fas, anp_subactividad asa 
		WHERE fas.id_ff_anp_subactividad='".$id."' AND
			asa.id_anp_subactividad=fas.id_anp_subactividad 	";
			
	$query=new Consulta($sql);
	$row=$query->ConsultaVerRegistro();
	
	$sql_sa="SELECT * FROM subactividad WHERE id_subactividad='".$row['id_subactividad']."'";		
	$query_sa= new Consulta($sql_sa);
	$row_sa=$query_sa->ConsultaVerRegistro();
		
	$sql_ff="SELECT * FROM fuente_financiamiento ff, presupuesto_anp pa, presupuesto_ff pf  
			WHERE pa.id_presupuesto_anp='".$row['id_presupuesto_anp']."' AND
				pf.id_ff=ff.id_ff AND
				pa.id_presupuesto_ff=pf.id_presupuesto_ff";
	$query_ff=new Consulta($sql_ff);
	$row_ff=$query_ff->ConsultaVerRegistro();
	
if(!$moneda || $moneda=="SOLES"){
	$tc=1;
	$moneda="SOLES";
	$money="DOLARES";	
}else if($moneda=='DOLARES'){
	$tc=$row_ff['tipo_cambio_ff'];
	$money="SOLES";
}	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de Programacion</title>
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>
<body >
<? if($_GET[pdf]!='ok'){ ?>
<a href="<?=$_SERVER['PHP_SELF']?>?moneda=<?=$moneda?>&amp;id=<?=$id?>&amp;pga=<?=$pga?>&pdf=ok">
<img src="../../imgs/icon-pdf.gif" width="20" height="25" border="0"> Descargar PDF</a> 
<? }?>

<table align="center" bgcolor="#FFFFFF" width="100%" id="ficha">
	<tr><td align="center" colspan="5">
		<div align="center" style=" azimuth:center; font: bold 11px tahoma"><b>Plan Operativo -<?=axo($_SESSION[inrena_4][2])?></b></div>
	</td></tr>
	<tr><td align="center" colspan="5"><div align="center"><b>Ficha de Subactividad</b></div>
	</td></tr>
	<tr><td align="center" colspan="5"><div align="center"></div>
	</td></tr>
	<tr>
	<tr class="titulo" bgcolor="#999999">
		<td class="titulo" align="center">C&oacute;digo <b>
		  <?=strtoupper(anp($_SESSION['anp']['idanp']))?>
		</b></td>
		<td colspan="3" class="titulo" align="center">Nombre</td>
		<td width="18%" class="titulo" align="center">Fte. Fto. - Ejec. </td>
	</tr>
	<tr>
		<td class="descripcion"><?=Actividad::ActividadCodigo($row_sa['id_actividad'])?></td>
		<td colspan="3" class="descripcion">Actividad : <?=Actividad::ActividadNombre($row_sa['id_actividad'])?></td>
		<td rowspan="2" class="descripcion" align="center"><?=$row_ff['siglas_ff']?></td>
	</tr>
	<tr>
		<td class="descripcion"><?=$row_sa['codigo_completo_subactividad']?></td>
		<td colspan="3" class="descripcion">Subatividad : <?=Subactividad::SubactividadNombre($row_sa['id_subactividad'])?></td>					
	</tr>
	<tr class="titulo" bgcolor="#999999">
	<td class="titulo" colspan="4" align="center" >Resultado al cual contribuye la Subactividad</td>
	<td class="titulo"  align="center">Moneda</td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td class="descripcion" colspan="4"><?=$row['resultado_esperado_anp_subactividad']?></td>
		<td class="descripcion" align="center">
		<? if($_GET[pdf]!='ok'){ ?>
		<a href="ReporteFichaSubactividad.php?moneda=<?=$money?>&amp;id=<?=$id?>&amp;pga=<?=$pga?>"> <?=$moneda?> </a><? } else echo $moneda;?></td>
	</tr>
	<tr>
		<td colspan="5" class="titulo" bgcolor="#999999" align="center">Descripci&oacute;n de Subactividad</td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td class="descripcion"  colspan="5"><?=$row['descripcion_anp_subactividad']?></td>
	</tr>
	<tr bgcolor="#999999">
		<td class="titulo" colspan="3" align="center">Medio de Verificaci&oacute;n</td>
		<td class="titulo" width="18%" align="center">Unidad de Medida </td>
		<td class="titulo" align="center">Meta</td>
	</tr>	
	<tr bgcolor="#eeeeee">
		<td class="descripcion" colspan="3"><?=$row['medio_verificacion_subactividad']?></td>
	    <td width="21%" align="center" class="descripcion"><? $sq_um=new Consulta("SELECT * FROM unidad_medida WHERE id_unidad_medida='".$row['id_unidad_medida']."'"); 
					$row_um=$sq_um->ConsultaVerRegistro(); 
					echo $row_um['nombre_unidad_medida']?></td>
	    <td align="center" class="descripcion"><?
					$sq_meta=new Consulta("SELECT SUM(cantidad_meta) AS cant FROM metas WHERE id_ff_anp_subactividad='".$id."'");
					$row_meta=$sq_meta->ConsultaVerRegistro();
					echo $row_meta['cant']; ?></td>
	</tr>
	<tr class="titulo" bgcolor="#999999">
		<td class="titulo" colspan="4" align="center">Responsable</td>
		<td class="titulo" align="center">Cargo</td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td class="descripcion" colspan="4"><?
			$sq_personal=new Consulta("SELECT * FROM personal_anp WHERE id_personal_anp='".$row['id_personal_anp']."' order by nombre_personal_anp asc,apellidos_personal_anp asc");
					$row_per=$sq_personal->ConsultaVerRegistro();
					echo $row_per['apellidos_personal_anp']." ".$row_per['nombre_personal_anp']
		?></td>
		<td class="descripcion" align="center"> <?=$row_per['cargo_personal_anp']?></td>
	</tr>
	<tr>
		<td colspan="5" class="titulo" bgcolor="#999999" align="center">Ejecución Trimestral</td>
	</tr>
	<tr bgcolor="#CCCCCC">
		<td class="sub_titulo" width="28%" align="center">Trimestres</td>
		<td width="18%" class="sub_titulo" align="center"> I Trimestre </td>
		<td width="18%" class="sub_titulo" align="center"> II Trimestre </td>
		<td width="18%" class="sub_titulo" align="center"> III Trimestre </td>
		<td width="18%" class="sub_titulo" align="center"> IV Trimestre </td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td class="descripcion">Avance por Metas</td><?
				$sq_trimestre=new Consulta("SELECT * FROM trimestre"); 
				$cants=0;
				while($rtrim=$sq_trimestre->ConsultaVerRegistro()){
				$sq_metas=new Consulta("SELECT * FROM metas	WHERE id_ff_anp_subactividad='$id' AND id_trimestre='$rtrim[0]'");
				$rmetas=$sq_metas->ConsultaVerRegistro();
				$cants+=$rmetas[3]; ?>
		<td align="center"  class="descripcion"><?=$rmetas[3]?></td>
				<? 
				}	?>
	</tr><? $sq_trims=new Consulta("SELECT * FROM programacion_metas WHERE id_ff_anp_subactividad='".$id."'");
				$ptrim="";
				$strim="";
				$ttrim="";
				$ctrim="";
				while($rtrim=$sq_trims->ConsultaVerRegistro()){
					$sql_mm=new Consulta("SELECT * FROM programacion_metas_meses WHERE id_programacion_metas='".$rtrim[0]."' ");
					while($rmm=$sql_mm->ConsultaVerRegistro()){
						if($rmm[1] > 0 && $rmm[1] < 4){ if($ptrim==""){ $ptrim=$rtrim[3]; }else{ 
							if(buscar_trimestre($rtrim[3], $ptrim)==false){$ptrim.=",".$rtrim[3];}}}
							
						if($rmm[1] > 3 && $rmm[1] < 7){ if($strim==""){ $strim=$rtrim[3]; }else{ 
							if(buscar_trimestre($rtrim[3], $strim)==false){$strim.=",".$rtrim[3];}}}
							
						if($rmm[1] > 6 && $rmm[1] < 10){if($ttrim==""){ $ttrim=$rtrim[3]; }else{ 
							if(buscar_trimestre($rtrim[3], $ttrim)==false){$ttrim.=",".$rtrim[3];}}}
							
						if($rmm[1] > 9 && $rmm[1] < 13){if($ctrim==""){ $ctrim=$rtrim[3]; }else{ 
							if(buscar_trimestre($rtrim[3], $ctrim)==false){$ctrim.=",".$rtrim[3];}}}
					}
				}?>			
	<tr bgcolor="#eeeeee">
		<td class="descripcion">Avance por Fases de Ejecución</td>
		<td class="descripcion" align="center"><?=$ptrim?></td>				
		<td class="descripcion" align="center" ><?=$strim?></td>
		<td class="descripcion" align="center" ><?=$ttrim?></td>
		<td class="descripcion" align="center" ><?=$ctrim?></td>
  	</tr>
</table>
	<table align="center" bgcolor="#FFFFFF"  style="border:1px solid #999999" width="100%" id="ficha">
	<tr bgcolor="#999999">
		<td class="titulo" colspan="14" align="center">Cronograma por Fases de Ejecución</td>
	</tr><tr bgcolor="#cccccc">
	<td class="sub_titulo" align="center">Fases de Ejecución</td><?
			$sq_mes=new Consulta("SELECT * FROM mes"); 
			while($rmes=$sq_mes->ConsultaVerRegistro()){?>
		<td class="sub_titulo" width="35"><?=substr($rmes['nombre_mes'],0,3)?></td>
		<? }?>
	</tr><?								
			$sq_crono=new Consulta("SELECT * FROM programacion_metas 
				WHERE id_ff_anp_subactividad='".$id."' 
				ORDER BY codigo_programacion_metas");
			$mes=array();
			while($rcrono=$sq_crono->ConsultaVerRegistro()){ ?>
	<tr bgcolor="#eeeeee">
		<td class="descripcion">
			<?=$rcrono['codigo_programacion_metas']?> .- &nbsp;&nbsp;
			<?=$rcrono['fase_ejecucion_programacion_metas'];?></td><?				
			for($x=1;$x<13;$x++){ 							
				$ver_mes=new Consulta("SELECT * FROM programacion_metas_meses 
								WHERE id_programacion_metas='".$rcrono[0]."' AND
									id_mes='".$x."'");
				if($ver_mes->numregistros()>0){	if(!array_key_exists($x, $mes)){ $mes[$x]=$x; }	}	?>												
		<td align="center" class="descripcion"><? if($ver_mes->numregistros()>0){										
				if(!array_key_exists($x, $mes)){ 
						$mes[$x]=$x;
				}
				echo"x"; 											
				}else{ echo "&nbsp;";}?></td>
				<? } ?>							
	</tr><?
			}		 ?>
	<tr>
		<td class="descripcion">Resumen Anual</td><?
				for($z=1;$z<13;$z++){?>
		<td align="center" class="descripcion"><? if(array_key_exists($z,$mes)){ echo "x";}?></td>
								<? 
								} ?>								
	</tr></table>
	<table align="center" bgcolor="#ffffff" width="100%" id="ficha" >
      <tr bgcolor="#999999">
	  <? if($_GET[pdf]!='ok'){ ?>
        <td colspan="15" class="titulo" align="center"> Presupuesto por Partidas </td>
      <? } else{ echo '<td colspan="14" class="titulo"> Presupuesto por Partidas </td>';} ?>
	  </tr>
      <tr bgcolor="#cccccc">
        <? if($_GET[pdf]!='ok'){	?>
		<td class="sub_titulo" width="20">Part</td>
		<td align="center" class="sub_titulo">Descripción</td>
	<? } else{?>
        <td>Part&nbsp;-&nbsp;&nbsp;Descripción</td>
        <? } 
		/*
				$sq_m=new Consulta("SELECT * FROM mes ");
				while($rm=$sq_m->ConsultaVerRegistro()){?>
		<td class="sub_titulo" width="40" nowrap><?=substr($rm['nombre_mes'],0,3)?></td>
		<? 
							}*/?>
        <td class="sub_titulo" width="43">Ene</td>
        <td class="sub_titulo" width="43">Feb</td>
        <td class="sub_titulo" width="43">Mar</td>
        <td class="sub_titulo" width="43">Abr</td>
        <td class="sub_titulo" width="43">May</td>
        <td class="sub_titulo" width="43">Jun</td>
        <td class="sub_titulo" width="43">Jul</td>
        <td class="sub_titulo" width="43">Ago</td>
        <td class="sub_titulo" width="43">Set</td>
        <td class="sub_titulo" width="43">Oct</td>
        <td class="sub_titulo" width="43">Nov</td>
        <td class="sub_titulo" width="43">Dic</td>
        <td width="50" class="sub_titulo">Total</td>
      </tr>
	  <?				
		$sql_partidas="SELECT *, SUM(ppm.monto_programacion_partidas_meses) AS MONTO 
				FROM programacion_partidas pp, programacion_partidas_meses ppm, partida p
						WHERE id_ff_anp_subactividad='".$id."' AND
						ppm.id_programacion_partidas=pp.id_programacion_partidas AND
						p.id_partida=pp.id_partida 
						GROUP BY pp.id_programacion_partidas";	
				$query_partidas=new Consulta($sql_partidas);
			$col;					 
			while($r_pp=$query_partidas->ConsultaVerRegistro()){
			$fila=0; ?>
      <tr bgcolor="#eeeeee">
        <? if($_GET[pdf]!='ok'){	?>
			<td class="descripcion"><?=$r_pp['codigo_partida']?></td>
            <td class="descripcion"><?=$r_pp['nombre_partida']?></td>
        
		<? } else{	echo'<td class="descripcion">'.$r_pp['codigo_partida'].
						'&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;'.$r_pp['nombre_partida'].'</td>';
        	}
				for($s=1;$s<13;$s++){
					$sq_montos=new Consulta("SELECT monto_programacion_partidas_meses FROM programacion_partidas_meses
					WHERE id_programacion_partidas='".$r_pp['id_programacion_partidas']."' AND
					id_mes='".$s."'");
					$rp=$sq_montos->ConsultaVerRegistro(); ?>
        <td class="descripcion" align="right"><? if(!empty($rp[0])){ echo round($rp[0]/$tc); $fila+=$rp[0];}?>
        </td>
        <?
					if($s==1){ $col[$s]+=$rp[0]; }
					if($s==2){ $col[$s]+=$rp[0]; }
					if($s==3){ $col[$s]+=$rp[0]; }
					if($s==4){ $col[$s]+=$rp[0]; }
					if($s==5){ $col[$s]+=$rp[0]; }
					if($s==6){ $col[$s]+=$rp[0]; }
					if($s==7){ $col[$s]+=$rp[0]; }
					if($s==8){ $col[$s]+=$rp[0]; }
					if($s==9){ $col[$s]+=$rp[0]; }
					if($s==10){ $col[$s]+=$rp[0];}
					if($s==11){ $col[$s]+=$rp[0];}
					if($s==12){ $col[$s]+=$rp[0];}						
				} ?>
        <td class="descripcion" align="right"><?=num_format($fila/$tc)?></td>
        <? 
			} ?>
      </tr>
      <tr bgcolor="#cccccc">
        <td colspan="<? if($_GET[pdf]!='ok') echo 2; else echo 1;?>" class="descripcion" > TOTAL</td>
        <?
				$total=0;
				for($p=1;$p<13;$p++){
					$total+=$col[$p];
					$numero=num_format($col[$p]/$tc);
					if(empty($numero)){
						$numero="&nbsp;";
					}
					
					?>
        <td class="descripcion" align="right"><?=$numero?></td>
        <?		
				} ?>
        <td align="right" class="descripcion"><?=num_format($total/$tc)?></td>
      </tr>
</table>
	<? if ($_GET[pdf]!='ok'){?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<?
	if ($numpags>1){
		echo "Pagina: ".$pga." de: ".$numpags."&nbsp;&nbsp; <<" ;
		for ($i=0;$i<$numpags;$i++){
			$cPga=($i+1);
				if ($pga==$cPga){
					$cPgan='<font style="font:bold; color:#FF0000">'.$cPga.'</font>';
				}else{
					$cPgan=$cPga;
				}
	
				
			$plink='<a href="'.$PHP_SELF."?id=".$_SESSION['id_ff_anp'][$i]."&pga=".$cPga.'">'.$cPgan.'</a>'."\n";
			echo "&nbsp;".$plink;
		}
		echo " >>";
	}
}//pdf ?>&nbsp;	</td>
  </tr>
</table>
</body>
</html>
<? 
if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF();
$pdf->ubic_css="../../style.css"; //agreg mio
$pdf->DisplayPreferences('HideWindowUI');
//$pdf->SetAutoPageBreak(false);
//$pdf->usetableheader=true; $pdf->Header('Objetivos Estrategicos');  //titulo
$pdf->AddPage();
//$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('ficha_subactividad.pdf','D');}?>