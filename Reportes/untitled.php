<?php	
	require_once("../../includes.php");
	require_once("../consulta_reporte.php");
	
	$estilo = "";
	if($_REQUEST["tipo"]==2){
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Reporte_Busqueda.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	}elseif($_REQUEST["tipo"]==1){
		require('../../libs/html2pdf/html2fpdf.php');
		ob_start();
		$estilo = "font-size:8px;";
	}
		
	$usuario = new Usuario($_SESSION['session'][0]);
	$reporte = new Reporte();	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Busqueda</title>
<link rel="stylesheet" type="text/css" href="../../public_root/css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/reporte.css">
<style type="text/css">
<!--
.Estilo25 {font-size: 18px}
td{
	vertical-align:middle;
}
-->
</style>
</head>
<body>	
	<? if(isset($_REQUEST["area_rep"])){
		$areas = $reporte->obtener_area($_REQUEST["area_rep"]);
	?>	
	<table width="92%" border="0" align="center">
	  <tr>
		<td colspan="6"><div align="center"><img src="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/imgs/cabecera_reporte.jpg" width="887" height="64" /></div></td>
	  </tr>
	  <tr>
		<td height="51" colspan="6"><h1 align="center">REPORTE XXX </h1></td>
	  </tr>
	  <tr>
		<td width="8%" class="contenido negrita">Usuario :</td>
	    <td width="27%" class="contenido"><?=$usuario->getNombreCompleto()?></td>
	    <td width="34%" class="contenido">&nbsp;</td>
	    <td width="9%" class="contenido">&nbsp;</td>
	    <td width="7%" class="contenido negrita">Fecha :</td>
	    <td width="15%" class="contenido"><?=date("d/m/Y H:i:s")?></td>
	  </tr>
	  <tr>
	    <td height="18" colspan="6" class="contenido">&nbsp;</td>
      </tr>
	</table>
	<table border="0" align="center" style="border-bottom:none">
	  <tr class="cabecera_documento">
		<td height="21" style="width:210px"><div align="center">Usuario del Area </div></td>
		<td style="width:45px"><div align="center">Enero</div></td>
		<td style="width:45px"><div align="center">Febrero</div></td>
		<td style="width:45px"><div align="center">Marzo</div></td>
	    <td style="width:45px"><div align="center">Abril</div></td>
	    <td style="width:45px"><div align="center">Mayo</div></td>
	    <td style="width:45px"><div align="center">Junio</div></td>
	    <td style="width:45px"><div align="center">Julio</div></td>
	    <td style="width:50px"><div align="center">Agosto</div></td>
	    <td style="width:55px"><div align="center">Setiembre</div></td>
	    <td style="width:50px"><div align="center">Octubre</div></td>
	    <td style="width:55px"><div align="center">Noviembre</div></td>
	    <td style="width:55px"><div align="center">Diciembre</div></td>
	    <td style="width:55px"><div align="center">Promedio</div></td>
	  </tr>
	</table>
	
	<div style="width:913px; margin:auto auto; background:#2873AA">
	<table border="0" align="center" class="contenido" style="table-layout:fixed; <?=$estilo?>">
	<?php 	  
	  foreach($areas as $area){
	  ?>
	  <!--<tr bgcolor="#FFFFFF">	  	
		<td style="width:208px"><?=$area["area"]?></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:45px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:50px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:59px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:50px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:62px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:58px"><div align="right">
		  <?=aaaa?>
	    </div></td>
		<td style="width:53px"><div align="right">
		  <?=aaaa?>
	    </div></td>				
	  </tr>-->
	  <? 
	  $usuarios = $reporte->obtener_usuarios_area($area["id"]);
	  foreach($usuarios as $usuario){ 
		  $movimientos_e = $reporte->obtener_movimientos_entrantes($usuario["id"]);
		  $movimientos_s = $reporte->obtener_movimientos_salientes($usuario["id"]);
	  ?>
	  <tr bgcolor="#FFFFFF">
	    <td style="width:208px"><?=$usuario["usuario"]?></td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:45px">&nbsp;</td>
	    <td style="width:50px">&nbsp;</td>
	    <td style="width:59px">&nbsp;</td>
	    <td style="width:50px">&nbsp;</td>
	    <td style="width:62px">&nbsp;</td>
	    <td style="width:58px">&nbsp;</td>
	    <td style="width:53px">&nbsp;</td>
      </tr>
	  <?php }?>	 
	 <?php } ?>
	</table>
	</div>
	<? }else{?>
	<form name="form_busqueda" action="tiempo_espera_usuario.php" method="post">
		<table width="46%" border="0" align="center">
		  <tr>
		    <td height="17">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="2"><div align="center" class="Estilo22 Estilo25">Filtros del Reporte </div></td>
	      </tr>
		  <tr>
		    <td height="18">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
			<td width="118">Nombre del &Aacute;rea </td>
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