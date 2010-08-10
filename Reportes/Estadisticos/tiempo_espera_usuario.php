<?php	
	require_once("../../includes.php");
	require_once("../consulta_reporte.php");
	include('../../libs/FusionCharts_Gen.php');
	
	$estilo = "";
	if($_REQUEST["tipo"]==2){
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Reporte_Productividad.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	}elseif($_REQUEST["tipo"]==1){
		require('../../libs/html2pdf/html2fpdf.php');
		ob_start();		
	}else{
		
	}
	
		
	$usuario = new Usuario($_SESSION['session'][0]);
	$reporte = new Reporte();	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Busqueda</title>
<script type="text/javascript" src="../../FusionCharts/FusionCharts.js"></script>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/js/funciones.js"></script>
<script type="text/javascript" src="../../public_root/js/jquery-1.3.js"></script>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/css/general.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/css/admin.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/Reportes/css/reporte.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/Reportes/css/reporte_impr.css" media="print">
<style type="text/css">
<!--
td{
	vertical-align:middle;
}
.Estilo26 {font-size: 14px}
-->
</style>
</head>
<body>	
	<? if(isset($_REQUEST["area_rep"])){?>
		<script type="text/javascript">
			$(document).ready(function(){
			top = distancia_sup(document.getElementById("grafica"));
			$("#ayuda").css("top",top)
		});
		</script>
	<?
		$areas = $reporte->obtener_area($_REQUEST["area_rep"]);
		$area = $areas[0];

 	$FC = new FusionCharts("Column3D","720","350"); 
	$FC->setSWFPath("../../FusionCharts/");
	$strParam="caption=Productividad de Usuarios de ".$area["abreviatura"].";xAxisName=Usuario;yAxisName = Productividad (%)";
 	$FC->setChartParams($strParam);
	?>
	<form name="form_reporte" action="">	
	<table width="92%" border="0" align="center">
	<? if($_REQUEST["tipo"]!=1&&$_REQUEST["tipo"]!=2){?>
	  <tr id = "barra_botones">
	    <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="5%">
			<div align="center">
				<a href="tiempo_espera_usuario.php?area_rep=<?=$_REQUEST["area_rep"]?>&tipo=1">
					<img src="../../public_root/imgs/PDF.png" width="25" height="30" border="0"/>				</a>			</div>		</td>
	    <td width="5%">
			<div align="center">
				<a href="tiempo_espera_usuario.php?area_rep=<?=$_REQUEST["area_rep"]?>&tipo=2">
					<img src="../../public_root/imgs/icon-xls.gif" width="30" height="30" border="0"/>				</a>			</div>		</td>
	    <td width="5%">
			<div align="center">								
				<a href="javascript:">
					<img src="../../public_root/imgs/printer.png" width="30" height="30" border="0"/>				</a>			</div>		</td>
	  </tr>
	  <? }?>
	  <tr>
		<td colspan="14">
			<div align="center">
			<a name="cabecera" id="cabecera">
				<img src="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/imgs/cabecera_reporte.jpg" width="887" height="64" />			</a>			</div>		</td>
	  </tr>
	  <tr>
	    <td height="10" colspan="14" style="font-size:6px"></td>		
      </tr>
	  <?php if($_REQUEST["tipo"]==2){?>
	  <tr>
	  	<td height="10" colspan="14" style="font-size:6px"></td>
	  </tr>
	  <? }?>
	  <tr>
		<td height="30" colspan="14"><h1 align="center"><strong>REPORTE DE PRODUCTIVIDAD - 
		  <?=$area["abreviatura"]?> 
	    </strong></h1></td>
	  </tr>
	  <tr>
		<td width="8%" class="contenido negrita">Usuario :</td>
	    <td width="16%" class="contenido"><?=$usuario->getNombreCompleto()?></td>
	    <td width="11%" class="contenido">&nbsp;</td>
	    <td width="8%" class="contenido">&nbsp;</td>
	    <td width="9%" class="contenido">&nbsp;</td>
	    <td width="8%" class="contenido">&nbsp;</td>
	    <td width="4%" class="contenido">&nbsp;</td>
	    <td width="5%" class="contenido">&nbsp;</td>
	    <td width="4%" class="contenido">&nbsp;</td>
	    <td width="5%" class="contenido">&nbsp;</td>
	    <td width="7%" class="contenido negrita">Fecha :</td>
	    <td colspan="3" class="contenido"><?=date("d/m/Y H:i:s")?></td>
	  </tr>
	  <tr>
	    <td height="18" colspan="14" class="contenido">&nbsp;</td>
      </tr>
	</table>
	<table border="0" align="center" style="border-bottom:none">
	  <tr class="cabecera_documento">
		<td height="21" style="width:160px"><div align="center">Usuario del Area </div></td>
		<td style="width:60px"><div align="center">Enero</div></td>
		<td style="width:60px"><div align="center">Febrero</div></td>
		<td style="width:60px"><div align="center">Marzo</div></td>
	    <td style="width:60px"><div align="center">Abril</div></td>
	    <td style="width:60px"><div align="center">Mayo</div></td>
	    <td style="width:60px"><div align="center">Junio</div></td>
	    <td style="width:60px"><div align="center">Julio</div></td>
	    <td style="width:60px"><div align="center">Agosto</div></td>
	    <td style="width:60px"><div align="center">Setiembre</div></td>
	    <td style="width:60px"><div align="center">Octubre</div></td>
	    <td style="width:60px"><div align="center">Noviembre</div></td>
	    <td style="width:60px"><div align="center">Diciembre</div></td>
	    <td style="width:60px"><div align="center">Promedio</div></td>
	  </tr>
	</table>
	
	<div style="width:995px; margin:auto auto; background:#2873AA">
	<table border="0" align="center" class="contenido" style="table-layout:fixed; <?=$estilo?>">
	  <? 
	  $usuarios = $reporte->obtener_usuarios_area($area["id"]);
	  foreach($usuarios as $usuario){ 
		  $movimientos_e = $reporte->obtener_movimientos_entrantes($usuario["usuario"]);
		  $movimientos_s = $reporte->obtener_movimientos_salientes($usuario["usuario"]);	  
		  $productividad_total = 0;
		  
	  ?>
	  <tr bgcolor="#FFFFFF">		
	  	<td style="width:158px"><?=$usuario["usuario"]?></td>
		<? 
		$pendientes = 0;
				
		$mes_actual = date("m"); //Dentro del año

		for ($cont = 0 ; $cont <= 11 ; $cont++){
			
			if($cont < $mes_actual){
						
				$recibidos = $movimientos_e[$cont];
				$atendidos = $movimientos_s[$cont];
				
				//echo "<font color='white'>".$usuario["usuario"].":".$pendientes." + ".$recibidos." - ".$atendidos."</font><br/>";
				
				if(($pendientes + $recibidos) == 0)
					$productividad = 0;
				elseif(($pendientes + $recibidos)<=$atendidos)
					$productividad = 1;
				elseif(($pendientes + $recibidos) != 0)
					$productividad = $atendidos/($pendientes + $recibidos);
				
				$productividad_total=$productividad_total+$productividad;
				$pendientes = $pendientes + $recibidos - $atendidos;	
				if( $pendientes < 0)
					$pendientes = 0;
			}else{
				$productividad = 0;
			}						
		?>		
		<td style="width:60px"><div align="right"><?=number_format(($productividad)*100,"2",".","")?></div></td>
		<? }		
		?>
		<td style="width:59px">
			<div align="right">
			<?
			$FC->addChartData(number_format(($productividad_total/$mes_actual)*100,"2",".",""),"Label=".$usuario["abreviatura"]);
			echo number_format(($productividad_total/$mes_actual)*100,"2",".","");
			?>
			</div>
		</td>
      </tr>
	  <?php	  	 	  	
	  } ?>	 
	 <?php //} ?>
	</table>
	</div>
	<br/>
	<div id="grafica" style="width:98%; text-align:center">
		<?php 		
			$FC->renderChart();
		?>
	</div>
	<div id="regresar" style="width:98%; text-align:right; margin-bottom:10px;">
		<a href="javascript:history.go(-1)"><strong><img src="../../public_root/imgs/b_firstpage.png" align="absmiddle" width="16" height="13" longdesc="Regresar" /> Regresar</strong></a>
	</div>
	<div id="ayuda" style="top:350px; z-index:3000;position:absolute; background:#FFF; width:100%; height:20px">&nbsp;</div>
	</form>
	<? }else{?>
	<form name="form_busqueda" action="tiempo_espera_usuario.php#cabecera" method="post">
		<table width="40%" border="0" align="center">
		  <tr>
		    <td height="17" colspan="2"><img src="../../public_root/imgs/cabecera.jpg" width="632" height="49" /></td>
	      </tr>
		  <tr>
		    <td height="17">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="2"><div align="center" class="cabecera_documento Estilo26">Filtros del Reporte </div></td>
	      </tr>
		  <tr>
		    <td height="18">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
			<td width="118"><strong class="Estilo22">Nombre del &Aacute;rea </strong></td>
			<td width="318">
				<? 
					$reporte = new Reporte();
					$areas = $reporte->obtener_areas();							
				?>			
				<select name="area_rep">
					<option value="">---------- Seleccione un area --------</option>
				<? foreach($areas as $area){?>
					<option value="<?=$area["id"]?>"><?=$area["area"]?></option>
				<? }?>
				</select>        </td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><div align="right">
			  <input type="submit" name="Submit" value="Ver Reporte" class = "boton"/>
		    </div></td>
		  </tr>
	  </table>
	</form>
	<? }?>
	
</body>
</html>
<?php 
	if($_REQUEST["tipo"]==1){		
		$pdf=new HTML2FPDF('P','mm','a4');
		$htmlbuffer=ob_get_contents();
        ob_end_clean();
    	header("Content-type: application/pdf");
		$pdf->ubic_css="css/reporte.css";
		$pdf->DisplayPreferences('HideWindowUI');

		$pdf->AddPage();
		$pdf->WriteHTML($htmlbuffer);
		$pdf->Output("Reporte_Busqueda.pdf",'I');		
	}
?>