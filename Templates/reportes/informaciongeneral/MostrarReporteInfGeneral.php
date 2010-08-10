<? if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require("../libs/verificar.inc.php");
require("../../includes.php");
require("../cls/reporteinformaciongeneral.cls.php");

$link=new Conexion();
/*if (isset($pag)||!empty($pag)){ $pag=$_GET[pag];}
else{ $pag = 1;} */
$tam_pag=20;	
$reg1 = ($pag-1) * $tam_pag;


//TIPO CAMBIO ANUAL
$sql="SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
$Queryt= new Consulta($sql);
$tp=$Queryt->ConsultaVerRegistro();	
$tipo_cambio=$tp[tipo_cambio];
?>
<title>Reporte</title>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script> 
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style><body topmargin="0">
<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?ID='.$ID.'&pag='.$pag.'&pdf=ok';
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
<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor='#fffff'>
  <tr>
    <td><!--<img src="../../imgs/logo.jpg" border="0" width="100%" height="100">--></td>
  </tr>
</table><?


//consultas para el menu de opciones
switch($ID){
/***************************************************************************/		
  	case '1':$sql="SELECT id_categoria as Nro,nombre_categoria as Categoria FROM categoria";	
		break;	
/***************************************************************************/		
  	case '2':$sql="select codigo_programa,nombre_programa,id_programa from programa order by id_programa";
		break;	
/***************************************************************************/		
  	case '3':$sql="SELECT id_unidad_medida as Nro,nombre_unidad_medida as Descripción 
					FROM unidad_medida 
					Order By id_unidad_medida";
		break;	
/***************************************************************************/		
  	case '4':$sql="
			SELECT codigo_partida as Nro,nombre_partida as Nombre,descripcion_partida as Descripción 
			FROM partida where id_axo_poa='{$_SESSION[inrena_4][2]}'
			ORDER BY codigo_partida";
		break;	
/***************************************************************************/		
  	case '5':$sql="Select  anp.siglas_anp  as Siglas,  categoria.nombre_categoria as 'Categoria', anp.nombre_anp as 'Nombre de ANP'
					From anp Inner Join categoria ON anp.id_categoria = categoria.id_categoria 
					ORDER BY codigo_anp";
	break;	
/***************************************************************************/		
  	case '6':
	$sql="Select  fuente_financiamiento.siglas_ff as Siglas, 
	CONCAT(`fuentefinanciamiento`.`nombre_fuentefinanciamiento`,'-',`ejecutor`.`nombre_ejecutor`) as 'Fuente de Financiamiento/Ejecutor',
	presupuesto_ff.monto_presupuesto_ff as Importe_Soles, 
	ROUND(presupuesto_ff.monto_presupuesto_ff/".$tipo_cambio.",2) as Importe_Dólares
FROM `ejecutor` 
Inner Join `fuente_financiamiento` ON `ejecutor`.`id_ejecutor` = `fuente_financiamiento`.`id_ejecutor`
Inner Join `fuentefinanciamiento` ON `fuentefinanciamiento`.`id_fuentefinanciamiento` = `fuente_financiamiento`.`id_fuentefinanciamiento`
Inner Join `presupuesto_ff` ON `fuente_financiamiento`.`id_ff` = `presupuesto_ff`.`id_ff`
Inner Join `fuente_usuario` ON `fuente_financiamiento`.`id_ff` = `fuente_usuario`.`id_ff`
WHERE id_axo_poa='".$_SESSION[inrena_4][2]."' AND fuente_usuario.id_submodulo='1' AND id_usuario='".$_SESSION['inrena_4'][1]."'
ORDER BY `fuente_financiamiento`.`siglas_ff` ASC";
break;	
/***************************************************************************/
}


//se establece la consulta sql
$query=new Consulta($sql);
//se obtiene el numero de registros totales
$row_res_pag=$query->numregistros();

//se crea un objeto Reporte para mostrar la respectiva Consulta
$Reporte=new reporteinformaciongeneral();

//se compara si es menor q 20 para la paginacion
if($row_res_pag<=20){
		if($ID==2){
		$cont=0;
		//se define una nueva consulta limitada por $tam_pag para la paginacion		
		//Para el Reporte de Estructura Programatica 
		$tam_pag=20;
		$reg1 = ($pag-1) * $tam_pag;
		if($_GET[pdf]!='ok') $sql=$sql." LIMIT $reg1,$tam_pag";	
		
		$query1=new Consulta($sql);
		echo $Reporte->reporte_estructura_programatica($query1,$reg1);
		$this->sql .= '<table border=0  width="85%" align=center cellspacing=1 cellpadding=2><tr>
		<td colspan="10" align="center" bgcolor="#FFFFFF"><br>';
		$this->sql.=paginar($pag, $row_res_pag , $tam_pag, $tmplweb."?ID=".$ID."&pag=");
		$this->sql.='</td></tr>';	
		$cdata=$this->sql;
		$this->sql="";
		 if($_GET[pdf]!='ok') echo $cdata;
		}
		else{if($ID==4){
						 echo $Reporte->reporte_partidas($query,$reg1);
						}
					else{
						  if($ID==6){echo $Reporte->reporte_fuente($query,$reg1);}
						  else{			
		//se ejecuta el Reporte y se le pasa por parametro un objeto $query
		echo $Reporte->reporte_informacion_general($query,$reg1);}}
		}
}
else
{		//se define una nueva consulta limitada por $tam_pag para la paginacion
		//$reg1=0;
		if($_GET[pdf]!='ok') $sql=$sql." LIMIT $reg1,$tam_pag";	
		$query=new Consulta($sql);		
		if($ID==2){
		//se ejecuta el Reporte y se le pasa por parametro un objeto $query
		echo $Reporte->reporte_estructura_programatica($query1,$query2,$query3,$query4,$reg1);
		}
		else{
		if($ID==4){
						 echo $Reporte->reporte_partidas($query,$reg1);
						}
					else{
						  if($ID==6){echo $Reporte->reporte_fuente($query,$reg1);}
						  else{			
		//se ejecuta el Reporte y se le pasa por parametro un objeto $query
		echo $Reporte->reporte_informacion_general($query,$reg1);}}
		}
		
		$this->sql .= '<table border=0  width="85%" align=center cellspacing=1 cellpadding=2><tr>
		<td colspan="10" align="center" bgcolor="#FFFFFF"><br>';
		if($_GET[pdf]!='ok') 
			$this->sql.=paginar($pag, $row_res_pag , $tam_pag, $tmplweb."?ID=".$ID."&pag=");
		$this->sql.='</td></tr>';	
		$cdata=$this->sql;
		$this->sql="";
		echo $cdata;

		$this->sql2.= '<tr>
		<td colspan="10" align="center" bgcolor="#FFFFFF"><br>';
		$this->sql2.='';
		$this->sql2.='</td></tr>';	
		$cdata1=$this->sql2;
		$this->sql2="";
		echo $cdata1;		
}	
echo "</table>
</form>
<script>
	window.focus()
</script>
</body>
</html>";

if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
	ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF('P','mm','a4');
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
	
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}?>