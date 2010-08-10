<?
if($_GET[pdf]=='ok'&&($ID==1||$ID==2)){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?>
<?
require("../../includes.php");
require("../funciones/reportes.php");
require("../cls/fisicofinanciero.php");
require("../cls/reporteinformacionanp.cls.php");
require("../cls/reporte_fichasb.php");
require("../funciones/reportes_meses.php");
require("../cls/informacionanp/presupuestomensual.cls.php");
require("../cls/informacionanp/prepuestotrimestral.cls.php");
require("../cls/informacionanp/presupuestoanualporpartidas.cls.php");
require("../cls/informacionanp/presupuestomensualporpartidas.cls.php");
require("../cls/informacionanp/presupuestoporpartidamensual.cls.php");
require("../cls/informacionanp/objetivosestrategicos.cls.php");
//require("../libs/verificar.inc.php"); 

$_SESSION['anp']['idanp']=$anpid;
$link=new Conexion();
$axo=$_SESSION[inrena_4][2];
$anpid=$anpid;

?>
<head>

<title>Reporte</title>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
<? if(($ID<3||$ID>9)&&$ID!=12){?>	
body { background-color: #FFFFFF;}
<? }?>
-->
</style></head>
<body topmargin="0">
<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'&&($ID==1||$ID==2)){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?ID='.$ID.'&anpid='.$anpid.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir"><img src="../../imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>

<form name="f1" method="post" action="">
<? if($ID>2){ ?>
<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><img src="../../imgs/logo.jpg" border="0" width="100%" height="100"></td>
  </tr>
</table><? }

//consultas para el menu de opciones
switch($ID){

	case 'cr':
		$sql ="select * from anp where id_anp='".$anpid."'";
	break;	
	case 'ng':
	
	break;	
	
/***************************************************************************/		
  	case '1':				
				$sql="Select presupuesto_anp.id_anp,presupuesto_anp.id_presupuesto_anp, 
					categoria.nombre_categoria, anp.nombre_anp,
					sum(monto_programacion_partidas_meses) as monto, presupuesto_anp.id_presupuesto_ff 
					FROM presupuesto_anp
						Inner Join anp ON anp.id_anp = presupuesto_anp.id_anp
						Inner Join categoria ON categoria.id_categoria = anp.id_categoria
						Inner Join asignacion_ff_anp_objetivos ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
						Inner Join programacion_partidas ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = programacion_partidas.id_ff_anp_subactividad
						Inner Join programacion_partidas_meses ON programacion_partidas.id_programacion_partidas = programacion_partidas_meses.id_programacion_partidas
						Inner Join presupuesto_ff ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
						Inner Join fuente_financiamiento ON fuente_financiamiento.id_ff = presupuesto_ff.id_ff
						Inner Join fuente_usuario ON fuente_usuario.id_ff = fuente_financiamiento.id_ff

					WHERE id_usuario='".$_SESSION[inrena_4][1]."' AND fuente_usuario.id_submodulo='1' AND 
					presupuesto_anp.id_anp = '".$anpid."'  and id_axo_poa='".$_SESSION[inrena_4][2]."'
					GROUP BY presupuesto_anp.id_presupuesto_anp Order By siglas_ff";
				//echo $sql;
			break;				
						
/***************************************************************************/		
  	case '2':	/*$sql="Select personal_anp.nombre_personal_anp,personal_anp.apellidos_personal_anp, 
						nombre_cargo_anp,personal_anp.dni_personal_anp,anp.nombre_anp,personal_anp.id_anp
						From personal_anp Inner Join anp ON personal_anp.id_anp =anp.id_anp
						Inner Join cargo_personal_anp 
						ON personal_anp.id_personal_anp=cargo_personal_anp.id_personal_anp
						Inner Join cargo_anp 
						ON cargo_anp.id_cargo_anp=cargo_personal_anp.id_cargo_anp
						WHERE personal_anp.id_anp = '".$anpid."' AND 
						
						(
							( 
								YEAR(fecha_ingreso_personal_anp) <= ".axo($_SESSION[inrena_4][2])."
						 	 	AND YEAR(fecha_egreso_personal_anp) >= ".axo($_SESSION[inrena_4][2])."
							)
							OR
							(
								YEAR(fecha_ingreso_personal_anp) <= ".axo($_SESSION[inrena_4][2])."
						 	 	AND YEAR(fecha_egreso_personal_anp)='0'
							)	
						) 
						order by nro_orden,personal_anp.apellidos_personal_anp,nombre_cargo_anp";
						echo $sql;*/
						
						$sql="Select personal_anp.nombre_personal_anp,personal_anp.apellidos_personal_anp, 
						nombre_cargo_anp,personal_anp.dni_personal_anp,anp.nombre_anp,personal_anp.id_anp
						From personal_anp Inner Join anp ON personal_anp.id_anp =anp.id_anp
						Inner Join cargo_personal_anp 
						ON personal_anp.id_personal_anp=cargo_personal_anp.id_personal_anp
						Inner Join cargo_anp 
						ON cargo_anp.id_cargo_anp=cargo_personal_anp.id_cargo_anp
						WHERE personal_anp.id_anp = '".$anpid."' AND 
						id_axo_poa='".$_SESSION[inrena_4][2]."'
						order by nro_orden,personal_anp.apellidos_personal_anp,nombre_cargo_anp";
						//echo $sql;
		break;	
}

//echo "<br>$sql<br>";
$tam_pag=20;	
$reg1 = ($_GET[pag]-1) * $tam_pag;
//se establece la consulta sql
if (!empty($sql)){
$query=new Consulta($sql);
$row_res_pag=$query->numregistros();
}
//se crea un objeto Reporte para mostrar la respectiva Consulta
$ReporteANP=new reporteinformacionanp();

//se compara si es menor q 20 para la paginacion

$Paginar="";
if($row_res_pag>=21){
			
		///pdf
		if($_GET[pdf]!='ok'){
			if (!$_GET[pag]){
				$sql=$sql." LIMIT 0,$tam_pag";
				$_GET[pag]="1";
			}
			else $sql=$sql." LIMIT $reg1,$tam_pag";
		}
			/******************** para paginar **************/
			$Paginar= '<div align="center" >';
				if($ID==2){
					$Paginar.= paginar($_GET[pag], $row_res_pag , $tam_pag, $tmplweb."?ID=".$ID."&anpid=".$anpid."&pag=");
				}else{
					$Paginar.=paginar($_GET[pag], $row_res_pag , $tam_pag, $tmplweb."?ID=".$ID."&pag=");
				}
			$Paginar.= '</div>';	

}

//$query=new Consulta($sql);	
	switch($ID){

	case 'cr':
		$ReporteANP->reporte_caratula_anp();
	break;	
	case 'ng':
	
	break;			
	case '1':
	//Accion
		$ReporteANP->reporte_consulta_fuentefinan($anpid);
	break;
	case '2':
		$query1=new Consulta($sql);
		echo $ReporteANP->reporte_consulta_personal($query,$query1);
	break;
	
	case '3':
		$Reporte_F_S=new FichaSubactividad($anpid,$axo,$_SESSION[inrena_4][1]);
		$Reporte_F_S->anpid=$anpid;
		$Reporte_F_S->mostrar_chk_ffs($_POST[S2]);
	break;
	case '4':
		$ReporteFF=new FisicoFinanciero();
		$ReporteFF->anpid=$anpid;
		$ReporteFF->mostrar_ff_chk($_POST[S2]);
	break;
	
	case '5':
		$ReportePM=new PresupuestoMensual($anpid,$axo,$_SESSION[inrena_4][1]);
		$ReportePM->anpid=$anpid;
		$ReportePM->mostrar_ff_chk($_POST[S2]);
	break;
	
	case '6':
		$ReportePT=new PresupuestoTrimestral();
		$ReportePT->anpid=$anpid;
		$ReportePT->mostrar_ff_chk($_POST[S2]);
	break;
	
	case '7':
		$ReportePAPP=new PresupuestoAnualPorPartidas();
		$ReportePAPP->anpid=$anpid;
		$ReportePAPP->mostrar_ff_chk($_POST[S2]);
	break;
	case '8':
		$ReportePPPM=new PresupuestoPorPartidasMensual($anpid,$axo,$_SESSION[inrena_4][1]);
		$ReportePPPM->anpid=$anpid;
		$ReportePPPM->mostrar_ff_chk($_POST[S2]);
		break;
	case '9':
		$ObjEst=new ObjetivosEstrategicos($anpid,$_SESSION['anp']['idanp']);
		$ObjEst->anpid=$anpid;
		$ObjEst->mostrar_ff_chk($_POST[S2]);
	break;
	case '10':
		//$ReportePMPP=new FichaMeses($anpid,$axo,$_SESSION[inrena_4][1]);
		$ReportePMPP=new PresupuestoMensualPorPartidas($idmes);
		$ReportePMPP->anpid=$anpid;
		$ReportePMPP->mostrar_ff_chk($_POST[S2]);
	break;
	case '12':
		$ProgPlan=new ObjetivosEstrategicos();
		$ProgPlan->anpid=$anpid;
		$ProgPlan->mostrar_ff_chk($_POST[S2]);
	break;	
}	
		
	if($_GET[pdf]!='ok') echo $Paginar;
		
		
echo'</table>
</form>
<script>
	window.focus()
</script>
</body>
</html>';
?>
<? 
if($_GET[pdf]=='ok'&&($ID==1||$ID==2)){
$htmlbuffer=ob_get_contents();
	ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF();
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
$pdf->AddPage();
//$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}?>