<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/informacionsinampe/anp_x_fuente_finan.cls.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
set_time_limit(100);
/*echo "--$id";
echo "**".$_SESSION[inrena_4][2];
*/
$anpid=$_POST['anp'];
if(is_array($_REQUEST[lista_ff])) $ff=implode(',',$_REQUEST[lista_ff]);
else $ff=$_REQUEST[lista_ff];

$lnkmoneda="";
$md=$md;

if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF'].'?md=d&anps='.$anps.'"> Soles</a>';
	$cambio=1;
	$moneda="Soles";
}else{ 
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF'].'?anps='.$anps.'">D&oacute;lares</a>';
	$sql="SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
	$Queryt= new Consulta($sql);
    $rowt=$Queryt->ConsultaVerRegistro();	
	$cambio=$rowt[tipo_cambio];
	$moneda="Dolares";
}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte</title>
<link rel="stylesheet" type="text/css" href="../../style.css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.Estilo4 {font-size: 8px}
-->
</style>
</head>
<body >

<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?id='.$id.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir"><img src="../../imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		  <tr>	
		  <th align='center' class="tit" bgcolor="#999999" >Plan Operativo Institucional&nbsp;<?=axo($_SESSION["inrena_4"][2])?>  </th>  
		  </tr>
		  <tr>
		    <td align="center">Formato Nº5</td>
		  </tr>
		  <tr>
		    <td align="center">Ficha: Programacion Plan Operativo</td>
		  </tr>
</table>
		<hr width="100%">

<br>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
	<td colspan="3"><strong>FTE. FTO.-EJEC. : 
	<?
	$sql="Select siglas_ff FROM fuente_financiamiento WHERE id_ff IN (".$ff.") ORDER BY siglas_ff";
	$Query=new Consulta($sql);	
	while ($row = $Query->ConsultaVerRegistro()){
		echo $row[siglas_ff].",&nbsp;";
	}
	?>
</strong></td>
</tr>
</table>
<table height="240" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tab" id='listado'>
<tr>
  	<th rowspan="4" ><span class="Estilo4">OBJETIVOS GENERALES/OBJETIVOS ESPEC&Iacute;FICOS/TAREAS</span></th> 
	<th rowspan="4" ><span class="Estilo4"> Indicador </span></th>
	<th rowspan="4" ><span class="Estilo4">Linea de Base </span></th>
	<th rowspan="4" ><span class="Estilo4">Unidad de Medida/ Medio de Verificacion</span></th>
	<th colspan="2" ><span class="Estilo4">Programacion 
	  <?=axo($_SESSION["inrena_4"][2])?>
	</span></th>
	<th colspan="24" ><span class="Estilo4">Programacion Trimestral</span></th>
	<th rowspan="4"><span class="Estilo4">Numero de Beneficiarios</span></th>
	<th rowspan="4"><span class="Estilo4">Responsable</span></th>
</tr>
<tr><th rowspan="3"><span class="Estilo4">Fisico</span></th>
<th rowspan="3"><span class="Estilo4">Financiero</span></th>
<th colspan="6"><span class="Estilo4">I Trimestre</span></th>
<th colspan="6"><span class="Estilo4">II Trimestre</span></th>
<th colspan="6"><span class="Estilo4">III Trimestre</span></th>
<th colspan="6"><span class="Estilo4">IV Trimestre</span></th>
</tr>
<tr><th colspan="2"><span class="Estilo4">Ene</span></th>
<th colspan="2"><span class="Estilo4">Feb</span></th>
<th colspan="2"><span class="Estilo4">Mar</span></th>
<th colspan="2"><span class="Estilo4">Abr</span></th>
<th colspan="2"><span class="Estilo4">May</span></th>
<th colspan="2"><span class="Estilo4">Jun</span></th>
<th colspan="2"><span class="Estilo4">Jul</span></th>
<th colspan="2"><span class="Estilo4">Ago</span></th>
<th colspan="2"><span class="Estilo4">Sep</span></th>
<th colspan="2"><span class="Estilo4">Oct</span></th>
<th colspan="2"><span class="Estilo4">Nov</span></th>
<th colspan="2"><span class="Estilo4">Dic</span></th>
</tr>
<tr>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
<th><span class="Estilo4">Fis</span></th>
<th><span class="Estilo4">Fin</span></th>
</tr>
<?
	$array_tot=array('0'=>0,'1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0);
	
	$sql="SELECT aao.id_anp_objetivo_estrategico, aao.id_anp_objetivo_especifico, id_tarea, 
			aao.id_asignacion_anp_objetivos, nro_asignacion, id_personal_anp
		FROM asignacion_ff_anp_objetivos AS afao
			Inner Join asignacion_anp_objetivos AS aao 
				ON afao.id_asignacion_anp_objetivos = aao.id_asignacion_anp_objetivos
			Inner Join presupuesto_anp AS pa 
				ON afao.id_presupuesto_anp = pa.id_presupuesto_anp
			Inner Join presupuesto_ff AS pf 
				ON pa.id_presupuesto_ff = pf.id_presupuesto_ff
			Inner Join fuente_financiamiento AS ff 
				ON ff.id_ff = pf.id_ff
			Inner Join anp_objetivo_especifico 
				ON anp_objetivo_especifico.id_anp_objetivo_especifico = aao.id_anp_objetivo_especifico
			Inner Join anp_objetivo_estrategico 
			  ON anp_objetivo_estrategico.id_anp_objetivo_estrategico=anp_objetivo_especifico.id_anp_objetivo_estrategico
			Inner Join objetivo_estrategico 
				ON objetivo_estrategico.id_objetivo_estrategico = anp_objetivo_estrategico.id_objetivo_estrategico
		WHERE aao.id_anp='".$anpid."' AND aao.id_axo_poa='".$_SESSION['inrena_4']['2']."' ".
			permisos_fuente($_SESSION['inrena_4'][1])." AND pf.id_ff IN (".$ff.") ".
		" GROUP BY aao.id_asignacion_anp_objetivos 
		ORDER BY codigo_objetivo_estrategico, codigo_objetivo_especifico,nro_asignacion";	
		
	$from_financ="SELECT sum(programacion_partidas_meses.monto_programacion_partidas_meses) AS monto 
		FROM programacion_partidas_meses
			Inner Join programacion_partidas 
		ON programacion_partidas_meses.id_programacion_partidas = programacion_partidas.id_programacion_partidas
			Inner Join asignacion_ff_anp_objetivos 
		ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = programacion_partidas.id_ff_anp_subactividad
			Inner Join asignacion_anp_objetivos 
		ON asignacion_anp_objetivos.id_asignacion_anp_objetivos = asignacion_ff_anp_objetivos.id_asignacion_anp_objetivos
			Inner Join presupuesto_anp 
		ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
			Inner Join presupuesto_ff 
		ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
			Inner Join fuente_financiamiento 
		ON fuente_financiamiento.id_ff = presupuesto_ff.id_ff 
		WHERE fuente_financiamiento.id_ff IN (".$ff.") ".
			permisos_fuente($_SESSION['inrena_4'][1],'fuente_financiamiento').
			" 	AND asignacion_anp_objetivos.id_anp='".$anpid."' 
				AND asignacion_anp_objetivos .id_axo_poa='".$_SESSION['inrena_4']['2']."' ";
	
	$from_fisico="SELECT sum(metas_meses.cantidad_metas_meses) AS monto FROM asignacion_ff_anp_objetivos
			Inner Join asignacion_anp_objetivos 
		ON asignacion_anp_objetivos.id_asignacion_anp_objetivos = asignacion_ff_anp_objetivos.id_asignacion_anp_objetivos
			Inner Join presupuesto_anp 
		ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
			Inner Join presupuesto_ff 
		ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
			Inner Join fuente_financiamiento 
		ON fuente_financiamiento.id_ff = presupuesto_ff.id_ff
			Inner Join metas_meses 
		ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = metas_meses.id_ff_anp_subactividad 
		WHERE fuente_financiamiento.id_ff IN (".$ff.") ".
			permisos_fuente($_SESSION['inrena_4'][1],'fuente_financiamiento').
			" 	AND asignacion_anp_objetivos.id_anp='".$anpid."' 
				AND asignacion_anp_objetivos .id_axo_poa='".$_SESSION['inrena_4']['2']."' ";
							
	$Query=new Consulta($sql);
	$obj=0; $obj_sp=0; 
	while ($row = $Query->ConsultaVerRegistro()){
		///obj estrat
		if($obj!=$row[id_anp_objetivo_estrategico]){ 
			$obj=$row[id_anp_objetivo_estrategico];?>
			<tr class='reg2'>
			<td align="left" nowrap ><span class="Estilo4"><strong>Objetivo General 
            <? 
			$sq="Select *	FROM objetivo_estrategico oe, 
					anp_objetivo_estrategico aoe
				WHERE aoe.id_objetivo_estrategico=oe.id_objetivo_estrategico 
						AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."'";
			$q=new Consulta($sq);
			$rw=$q->ConsultaVerRegistro();
			$obj_cod=$rw[codigo_objetivo_estrategico];
			echo $rw[codigo_objetivo_estrategico].": ".$rw[nombre_objetivo_estrategico]; ?>
			</strong></span></td>
			<td><?=$rw[indicador_objetivo_estrategico]?></td>
			<td>0</td>
			<td><?=$rw[id_unidad_medida]?></td>
			 <? 
				$sql_m="SELECT id_mes, sum(meta_mes_anp_objetivo_estrategico) as meta 
							FROM anp_objetivo_estrategico AS aoest 
							Inner Join anp_objetivo_estrategico_meta_mes aoem
								ON 	aoem.id_anp_objetivo_estrategico=aoest.id_anp_objetivo_estrategico
							WHERE aoest.id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."'
									AND id_axo_poa='".$_SESSION['inrena_4']['2']."' 
							GROUP BY id_mes";
				$query_m=new Consulta($sql_m);
				$array_mes=array();
				while($row_m=$query_m->ConsultaVerRegistro()){
					$array_mes[$row_m[id_mes]]=$row_m[meta];
				} 
				//print_r($array_mes); 
			  ?>
			
			<td>
			  <div align="right">
			   <?=array_sum($array_mes)?>
		      </div></td>
			<td>
			  <div align="right">
			    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' ";
				$qf=new Consulta($sql_fin);
				$rwf=$qf->ConsultaVerRegistro();
				echo num_format($rwf[monto])."&nbsp;";
			?>
		      </div></td>
			<? for($i=1;$i<13;$i++){?>
				<td>
				  <div align="right">
				    <?=$array_mes[$i]?>
		        </div></td>
				<td>
				  <div align="right">
				    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
						AND id_mes='".$i."'";
					$qf=new Consulta($sql_fin);
					$rwf=$qf->ConsultaVerRegistro();
					echo num_format($rwf[monto]);
					$array_tot[$i]+=$rwf[monto];///total
					$array_tot[0]+=$rwf[monto]."&nbsp;";///total
			?>
		        </div></td>
			<? }?>
			<td><?=$rw[bene_dir_ind]?></td>
			<td>&nbsp;</td>
			</tr>
		<? }
		
		////objet espec
		if($obj_sp!=$row[id_anp_objetivo_especifico]){
				$obj_sp=$row[id_anp_objetivo_especifico];?>
			<tr class='reg1'>
			<td height="38" align="left" nowrap><span class="Estilo4"><strong> Objetivo Específico</strong>&nbsp;
		    <? 
				$sqq="Select * FROM anp_objetivo_especifico
							WHERE id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'";
				$qo=new Consulta($sqq);
				if($rlw=$qo->ConsultaVerRegistro()){
				 	$obj_esp=$rlw[codigo_objetivo_especifico];
					echo $rlw[codigo_objetivo_especifico].": ".$rlw[nombre_objetivo_especifico]; 
				}?>			
		    </span></td>
			<td><?=$rlw[indicador_objetivo_especifico]?></td>
			<td>0</td>
			<td><?=$rlw[unidad_medida]?></td>
			<? 
				$sql_m="SELECT id_mes, sum(meta_mes_anp_objetivo_especifico) as meta 
							FROM anp_objetivo_especifico_meta_mes 
							WHERE id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'
									AND id_axo_poa='".$_SESSION['inrena_4']['2']."' 
							GROUP BY id_mes";
				$query_m=new Consulta($sql_m);
				$array_mes_sp=array();
				while($row_m=$query_m->ConsultaVerRegistro()){
					$array_mes_sp[$row_m[id_mes]]=$row_m[meta];
				} 
				//print_r($array_mes); 
			  ?>
			<td>
			  <div align="right">
			   <?=array_sum($array_mes_sp)?>
		      </div></td>
			<td>
			  <div align="right">
			    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$obj."' 
					AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'";
				$qf=new Consulta($sql_fin);
				$rwf=$qf->ConsultaVerRegistro();
				echo num_format($rwf[monto])."&nbsp;";
			?>
		      </div></td>
			<? for($i=1;$i<13;$i++){?>
				<td>
				  <div align="right">
				 <?=$array_mes_sp[$i]?>
		        </div></td>
				<td>
				  <div align="right">
				    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$obj."' 
						AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' AND id_mes='".$i."'";
					$qf=new Consulta($sql_fin);
					$rwf=$qf->ConsultaVerRegistro();
					echo num_format($rwf[monto])."&nbsp;";
			?>
		        </div></td>
			<? }?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
		<? }
		////tareas
		$sqql="SELECT * FROM `asignacion_anp_objetivos` AS `aff` Inner Join `tarea` AS `t` ON `aff`.`id_tarea` = `t`.`id_tarea` where aff.id_asignacion_anp_objetivos='".$row[id_asignacion_anp_objetivos]."'";
		///$sqql="Select nombre_tarea,medio_verificacion_tarea From tarea WHERE id_tarea='".$row[id_tarea]."'";
		$Qt=new Consulta($sqql);
		$rowt=$Qt->ConsultaVerRegistro();
		?> 
		<tr>
		<td align="left" nowrap ><span class="Estilo4">&nbsp;&nbsp;
		  Tarea&nbsp;<? echo $rowt[nro_asignacion].": ".$rowt[nom_tarea]?></span></td>
		<td><span class="Estilo4"></span></td>	<td><span class="Estilo4"></span></td>	
        <td><div align="center" class="Estilo4">
          <?=$rowt[medio_verificacion_tarea]?>
        </div></td>	
		<td>
			<div align="right" class="Estilo4">
			  <? 	$sql_fis=$from_fisico." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
					AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'
					AND id_tarea='".$row[id_tarea]."'";
				$qx=new Consulta($sql_fis);
				$rwx=$qx->ConsultaVerRegistro();
				echo $rwx[monto]."&nbsp;";
			?>
		  </div></td>
			<td>
			  <div align="right" class="Estilo4">
			    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
					AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' 
					AND id_tarea='".$row[id_tarea]."'";
				$qf=new Consulta($sql_fin);
				$rwf=$qf->ConsultaVerRegistro();
				echo num_format($rwf[monto]);
				
				
			?>
	        </div></td>
			<? for($i=1;$i<13;$i++){?>
				<td>
				  <div align="right" class="Estilo4">
				    <? 	$sql_fis=$from_fisico." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
						AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' 
						AND id_tarea='".$row[id_tarea]."'AND id_mes='".$i."'";
					$qx=new Consulta($sql_fis);
					$rwx=$qx->ConsultaVerRegistro();
					echo $rwx[monto]."&nbsp;";
				?>
		        </div></td>
				<td>
				  <div align="right" class="Estilo4">
				    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
						AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' 
						AND id_tarea='".$row[id_tarea]."'AND id_mes='".$i."'";
					$qf=new Consulta($sql_fin);
					$rwf=$qf->ConsultaVerRegistro();
					echo num_format($rwf[monto])."&nbsp;";
			?>
		        </div></td>
			<? }?>
		<td><span class="Estilo4"></span></td><td>
		  <span class="Estilo4">
		  <? 	$sper="Select * FROM personal_anp where id_personal_anp='".$row[id_personal_anp]."'";
			$Qper=new Consulta($sper); 
			$rper=$Qper->ConsultaVerRegistro();
			echo $rper[2]." ".$rper[3];
		?>
		  </span>		</td>
		</tr>
	
<? }?>
<tr>
<th>Total</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<? foreach($array_tot as $tot){?>
	<td><div align="right">&nbsp;</div></td><td><div align="right">
	  <?=num_format($tot)."&nbsp;"?>
	  </div></td>
<? }?>
<td><div align="right"></div></td><td><div align="right"></div></td>
</tr>
</table>

<script language="javascript">
FullScreen();
</script>

</body>
</html>
<? 
if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
	ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF('P','mm','a4');
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
	
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('programacion_plan_operativo.pdf','D');}?>