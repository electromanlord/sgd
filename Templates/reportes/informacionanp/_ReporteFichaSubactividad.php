<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?>
<?
  	include("../../includes.php");
	require_once("../libs/verificar.inc.php");
	//require_once("../../libs/lib.php");
	$link=new Conexion();
	
	$sql="SELECT * FROM asignacion_ff_anp_objetivos afao, asignacion_anp_objetivos aao
		WHERE id_asignacion_ff_anp_objetivos='".$id."' AND 
				aao.id_asignacion_anp_objetivos=afao.id_asignacion_anp_objetivos";
	$query=new Consulta($sql);
	$row=$query->ConsultaVerRegistro();
	
	//echo  $id."id_subactividad".$row['id_subactividad']."<br>";
	$sql_sa="SELECT * FROM tarea WHERE id_tarea='".$row['id_tarea']."'";		
	$query_sa= new Consulta($sql_sa);
	$row_sa=$query_sa->ConsultaVerRegistro();
		
	//echo "num";$query->numregistros();
	$sql_ff="SELECT * FROM fuente_financiamiento ff, presupuesto_anp pa, presupuesto_ff pf  
			WHERE pa.id_presupuesto_anp='".$row['id_presupuesto_anp']."' AND
				pf.id_ff=ff.id_ff AND
				pa.id_presupuesto_ff=pf.id_presupuesto_ff";
	$query_ff=new Consulta($sql_ff);
	$row_ff=$query_ff->ConsultaVerRegistro();

//monto total asignado	
$sql="SELECT Sum(afao.monto_asignacion_ff_anp_objetivos) as monto
 			FROM asignacion_ff_anp_objetivos afao 
			WHERE id_asignacion_ff_anp_objetivos='".$id."'";							
$Query=new Consulta($sql);	
$row_monto = $Query->ConsultaVerRegistro();
	
if(!$moneda || $moneda=="SOLES"){
	$tc=1;
	$moneda="SOLES";
	$money="DOLARES";	
}else if($moneda=='DOLARES'){
	$Q_axo=new Consulta("Select tipo_cambio FROM axo_poa WHERE id_axo_poa='".$_SESSION['inrena_2']['2']."'");
	$row_cambio = $Q_axo->ConsultaVerRegistro();
	$tc=$row_cambio['0'];
	$money="SOLES";
}	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de Programacion</title>
<link href="../../style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../../js/js.js"></script> 
</head>
<body >
<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?moneda='.$moneda.'&amp;id='.$id.'&amp;pga='.$pga.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir"><img src="../../imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>

<table align="center" bgcolor="#FFFFFF" width="100%" id="ficha">
  <!--DWLayoutTable-->
	<tr><td colspan="7" align="center">
		<div align="center" style=" azimuth:center; font: bold 11px tahoma"><b>Plan Operativo -<?=axo($_SESSION['inrena_2'][2])?></b></div>
	</td></tr>
	<tr><td colspan="7" align="center"><div align="center"><b>Ficha de Tarea </b></div>
	</td></tr>
	<tr><td colspan="7" align="center"><div align="center"><b>
		<?=strtoupper(anp($_SESSION['anp']['idanp']))?></b></div>
	</td></tr>
	<tr>
	  <td width="64" height="0"></td>
	  <td width="142"></td>
	  <td width="311"></td>
	  <td width="194"></td>
	  <td width="3"></td>
	  <td width="95"></td>
	  <td width="88"></td>
    <tr class="titulo" bgcolor="#999999">
		<td align="center" class="titulo">C&oacute;digo </td>
		<td colspan="3" class="titulo" align="center">Nombre</td>
		<td colspan="3" align="center" class="titulo">Fte. Fto. - Ejec. </td>
	</tr>
	<tr>
		<td class="descripcion"><? 
			$sqq="Select nombre_objetivo_estrategico,codigo_objetivo_estrategico 
					FROM objetivo_estrategico oe, anp_objetivo_estrategico aoe
				WHERE aoe.id_objetivo_estrategico=oe.id_objetivo_estrategico 
						AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."'";
			$q=new Consulta($sqq);
			$rws=$q->ConsultaVerRegistro();
			echo $rws[1]."."; ?></td>
		<td valign="top" class="descripcion"><div align="left">Estrategia General :</div></td>
		<td colspan="2" valign="top" class="descripcion"><?=$rws[0]?></td>
		<td colspan="3" align="center" class="descripcion"><?=$row_ff['siglas_ff']?></td>
	</tr>
	<tr>
		<td class="descripcion">
		<? $sqq="Select nombre_objetivo_especifico,codigo_objetivo_especifico FROM anp_objetivo_especifico
				WHERE id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'";
			$q=new Consulta($sqq);
			$rw=$q->ConsultaVerRegistro(); echo $rws[1].".".$rw[1].".";?></td>
		<td valign="top" class="descripcion"><div align="left">Estrategia Espec&iacute;fica  : </div></td>					
	    <td colspan="2" valign="top" class="descripcion"><?=$rw[0]?></td>
	    <td colspan="2" valign="top" class="titulo">Monto</td>
	    <td valign="top" class="titulo">Moneda</td>
	</tr>
	<tr>
		<td class="descripcion"><?=$rws[1].".".$rw[1].".".$row_sa['nro_orden']?></td>
		<td valign="top" class="descripcion"><div align="left">Tarea : </div></td>					
	    <td colspan="2" valign="top"class="descripcion"><?=$row_sa['nombre_tarea']?></td>
	    <td colspan="2" valign="top" class="descripcion" align="center"><?=number_format(($row_monto[monto]/$tc),2)?></td>
    <td align="center" valign="top" class="descripcion">
	<? if($_GET[pdf]!='ok'){ ?>
		<a href="ficha_programacion_tareas.php?moneda=<?=$money?>&amp;id=<?=$id?>&amp;pga=<?=$pga?>"> <?=$moneda?> </a><? } else echo $moneda;?></td>
	</tr>
	<tr>
		<td colspan="3" valign="top" bgcolor="#999999" class="titulo">Descripci&oacute;n de Subactividad</td>
	<td colspan="2" valign="top" class="titulo">Unidad de Medida </td>
		<td colspan="2" valign="top" class="titulo">Meta</td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td colspan="3" valign="top" class="descripcion"><?=$row['desc_asig_ff_anp_obj']?></td>
	<td   colspan="2" align="center" valign="top" class="descripcion"><?=$row_sa['medio_verificacion_tarea']?></td>
	    <td   colspan="2" align="center" valign="top" class="descripcion"><?
					$sq_meta=new Consulta("SELECT SUM(cantidad_metas_meses) AS cant FROM metas_meses 
						WHERE id_ff_anp_subactividad='".$id."'");
					$row_meta=$sq_meta->ConsultaVerRegistro();
					echo $row_meta['cant']; ?></td>
	</tr>
	<tr class="titulo" bgcolor="#999999">
		<td colspan="4" class="titulo">Responsable</td>
		<td colspan="3" class="titulo">Cargo</td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td colspan="4" class="descripcion"><?
			$sq_personal=new Consulta("SELECT * FROM personal_anp WHERE id_personal_anp='".$row['id_personal_anp']."' order by nombre_personal_anp asc,apellidos_personal_anp asc");
					$row_per=$sq_personal->ConsultaVerRegistro();
					echo $row_per['apellidos_personal_anp']." ".$row_per['nombre_personal_anp']
		?></td>
		<td colspan="3" align="center" class="descripcion"> <?=$row_per['cargo_personal_anp']?></td>
	</tr>
</table>
<table align="center" bgcolor="#FFFFFF"  style="border:1px solid #999999" width="100%" id="ficha">
	<tr bgcolor="#999999">
		<td class="titulo" colspan="14" align="center">Cronograma por Fases de Ejecución</td>
	</tr><tr bgcolor="#cccccc">
	<td class="sub_titulo" align="center">Fases de Ejecución</td><?
			$sq_mes=new Consulta("SELECT * FROM mes"); 
			while($rmes=$sq_mes->ConsultaVerRegistro()){?>
		<td class="sub_titulo" nowrap="nowrap"><?=substr($rmes['nombre_mes'],0,3)?></td>
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
        <? //if($_GET[pdf]!='ok'){	?>
		<td class="sub_titulo" nowrap width="25">Part</td>
		<td align="center" class="sub_titulo">Descripción</td>
	<? /*} else{?>
        <td>Part&nbsp;-&nbsp;&nbsp;Descripción</td>
        <? } */
		/*
				$sq_m=new Consulta("SELECT * FROM mes ");
				while($rm=$sq_m->ConsultaVerRegistro()){?>
		<td class="sub_titulo" width="40" nowrap><?=substr($rm['nombre_mes'],0,3)?></td>
		<? 
							}*/?>
        <td class="sub_titulo">Ene</td>
        <td class="sub_titulo" >Feb</td>
        <td class="sub_titulo" >Mar</td>
        <td class="sub_titulo">Abr</td>
        <td class="sub_titulo" >May</td>
        <td class="sub_titulo" >Jun</td>
        <td class="sub_titulo" >Jul</td>
        <td class="sub_titulo" >Ago</td>
        <td class="sub_titulo" >Set</td>
        <td class="sub_titulo" >Oct</td>
        <td class="sub_titulo" >Nov</td>
        <td class="sub_titulo" >Dic</td>
        <td class="sub_titulo">Total</td>
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
        <? //if($_GET[pdf]!='ok'){	?>
			<td class="descripcion"><?=$r_pp['codigo_partida']?></td>
            <td class="descripcion"><?=$r_pp['nombre_partida']?></td>
        
		<? /*} else{	echo'<td class="descripcion">'.$r_pp['codigo_partida'].
						'&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;'.$r_pp['nombre_partida'].'</td>';
        	}*/
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
        <td colspan="2" 
		class="descripcion" > TOTAL</td>
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
        <td align="right" class="descripcion" nowrap="nowrap"><?=num_format($total/$tc)?></td>
      </tr>
</table>
<table align="center" bgcolor="#ffffff" width="100%" id="ficha" >
<tr>
		<td colspan="5" class="titulo" bgcolor="#999999">Ejecución Trimestral</td>
  </tr>
	<tr bgcolor="#CCCCCC">
		<td class="sub_titulo" width="28%">Trimestres</td>
		<td width="18%" class="sub_titulo"> I Trimestre </td>
		<td width="18%" class="sub_titulo"> II Trimestre </td>
		<td width="18%" class="sub_titulo"> III Trimestre </td>
		<td width="18%" class="sub_titulo"> IV Trimestre </td>
	</tr>
	<tr bgcolor="#eeeeee">
		<td class="descripcion">Avance por Metas</td><?
				$sq_trimestre=new Consulta("SELECT * FROM trimestre"); 
				$cants=0;
				while($rtrim=$sq_trimestre->ConsultaVerRegistro()){
					if($rtrim[0]=='1') $rango="1,2,3";
					if($rtrim[0]=='2') $rango="4,5,6";
					if($rtrim[0]=='3') $rango="7,8,9";
					if($rtrim[0]=='4') $rango="10,11,12";
						
				$sq_metas=new Consulta("SELECT sum(cantidad_metas_meses) FROM metas_meses WHERE id_ff_anp_subactividad='$id' AND id_mes IN (".$rango.")");
				$rmetas=$sq_metas->ConsultaVerRegistro();
				$cants+=$rmetas[0]; ?>
		<td align="center"  class="descripcion"><?=$rmetas[0]?></td>
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
  	</tr></table>	

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
//$pdf = new HTML2FPDF();
$pdf = new HTML2FPDF('P','mm','a4x');
$pdf->ubic_css="../../style.css"; //agreg mio
$pdf->DisplayPreferences('HideWindowUI');
//$pdf->SetAutoPageBreak(false);
//$pdf->usetableheader=true; $pdf->Header('Objetivos Estrategicos');  //titulo
$pdf->AddPage();
//$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('ficha_subactividad.pdf','D');}?>