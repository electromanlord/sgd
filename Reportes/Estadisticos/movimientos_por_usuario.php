<?php	
	require_once("../../includes.php");
	require_once("../consulta_reporte.php");
	include('../../libs/FusionCharts_Gen.php');

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
	$usuario_r = new Usuario($_REQUEST['destino']);
	$reporte = new Reporte();	
	$fecha_ini = $_REQUEST["fecha_inicio"];
	$fecha_fin = $_REQUEST["fecha_fin"];
	
	$movimientos_u = $reporte->obtener_movimientos_usuario($usuario_r->getLogind(), $fecha_inicio, $fecha_fin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Busqueda</title>
<script type="text/javascript" src="../../FusionCharts/FusionCharts.js"></script>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/js/funciones.js"></script>
<script type="text/javascript" src="../../public_root/js/jquery-1.3.js"></script>
<script type="text/javascript" src="../../public_root/js/ui/ui.core.js"></script>
<script type="text/javascript" src="../../public_root/js/ui/ui.datepicker.js"></script>
<script type="text/javascript" src="../../public_root/js/ui/ui.datepicker-es.js"></script>
<script type="text/javascript">
$(document).ready(function(){	

	$("#area_rep").live("click",function(){
		url = "../../Ajax/Ajax.php";
		listarUsuariosArea($("#area_rep").val(),url);		 
	});		
		
	$(".caja").focus(function(){
		$(this).attr("class","con_focus");					   
	});
	$(".caja").blur(function(){
		$(this).attr("class","sin_focus");					   
	});
	
	$("#datepicker1").datepicker({
		changeMonth: true,
		changeYear: true						 
	});
	
	$("#datepicker2").datepicker({
		changeMonth: true,
		changeYear: true						 
	});
	
});

function listarUsuariosArea(id_area,url){	
	
    $.ajax({
      type: "POST",
      url: url,
	  cache: false,
      data: "metodo=cargar_usuarios_area&areas="+id_area,
      dataType: "xml",

      success: function(xml){
        $("#destino").html("");
        $(xml).find('option').each(function(){
            var id = $(this).attr('value')
            var name = $(this).text();
            $("#destino").append('<option value="'+id+'">'+name+'</option>');
        });
     }
   });
}
</script>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/css/general.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/css/admin.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/css/start/ui.all.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/Reportes/css/reporte.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/std/Reportes/css/reporte_impr.css" media="print">
<style type="text/css">
td{vertical-align:middle;}
.Estilo26 {font-size: 14px}
</style>
</head>
<body>	
	<? if(isset($_REQUEST["destino"])){?>		
	<form name="form_reporte" action="">	
	<table width="1000" border="0" align="center">
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
				<img src="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/imgs/cabecera_reporte.jpg" width="887" height="64"/>			</a>			</div>		</td>
	  </tr>	  
	  <?php if($_REQUEST["tipo"]==2){?>
	  <tr>
	  	<td height="26" colspan="14" style="font-size:6px"></td>
	  </tr>
	  <? }?>
	  <tr>
		<td height="30" colspan="14">
			<h1 align="center">
				<strong>REPORTE DE MOVIMIENTO POR USUARIO- <?=$usuario_r->getNombreCompleto()?></strong>			</h1>		</td>
	  </tr>
	  <tr>
	    <td class="contenido negrita">Desde : </td>
	    <td class="contenido"><?=$fecha_inicio?></td>
	    <td class="contenido negrita">Hasta :</td>
	    <td class="contenido"><?=$fecha_fin?></td>
	    <td class="contenido">&nbsp;</td>
	    <td class="contenido">&nbsp;</td>
	    <td class="contenido">&nbsp;</td>
	    <td class="contenido">&nbsp;</td>
	    <td class="contenido">&nbsp;</td>
	    <td class="contenido">&nbsp;</td>
	    <td class="contenido negrita">&nbsp;</td>
	    <td colspan="3" class="contenido">&nbsp;</td>
     </tr>
	  <tr>
		<td width="8%" class="contenido negrita">Usuario :</td>
	    <td width="16%" class="contenido"><?=$usuario->getNombreCompleto()?></td>
	    <td width="8%" class="contenido">&nbsp;</td>
	    <td width="11%" class="contenido">&nbsp;</td>
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
	  <tr>
	    <td height="18" colspan="14">
		 <div class="tabla-reporte">
			 <table border="1" align="center" style="border-collapse:collapse; border-color:#FFFFFF" width="1000" 
			 cellpadding="0" cellspacing="0">
				<tr class="cabecera_documento">
				  <th width="115"><div align="center">Reg</div></th>
				  <th width="125"><div align="center">De</div></th>
				  <th width="192"><div align="center">Asunto</div></th>
				  <th width="108"><div align="center">Fecha Reg. </div></th>
				  <th width="108"><div align="center">Fecha Mov. </div></th>
				  <th width="102"><div align="center">Accion Realizada </div></th>
				  <th width="65"><div align="center">Estado</div></th>
				  <th width="65"><div align="center">Ubicacion</div></th>
				  <th width="100"><div align="center">Comentario</div></th>
				</tr>
			 </table>
			 <table border="1" align="center" style="border-collapse:collapse; border:#2873AA 1px solid;" width="1000"
			 cellpadding="0" cellspacing="0">
			 <? 
		  		if( count($movimientos_u) > 0 ){
			  		foreach($movimientos_u as $mov){?>
				 <tr>
					<td width="115"><div align="center"><?=$mov["registro"]?></div></td>
				   <td width="125"><div align="left"><?=$mov["remitente"]?></div></td>
				   <td width="192"><div align="left"><?=$mov["asunto"]?></div></td>
					 <td width="108"><div align="center"><?=$mov["fecha_registro"]?></div></td>
					 <td width="108"><div align="center"><?=$mov["fecha_movimiento"]?></div></td>
				   <td width="102"><div align="left"><?=$mov["accion"]?></div></td>
				   <td width="65"><div align="left"><?=$mov["estado"]?></div></td>
				   <td width="65"><div align="left"><?=$mov["ubicacion"]?></div></td>
					 <td width="100"><div align="left"><?=$mov["comentario"]?></div></td>
			   </tr>
				  <? 
				}
			}else{?>
				  <tr bgcolor="#FFFFFF">
					 <td colspan="9">El usuario no realizo movimientos en el periodo especificado</td>
				  </tr>
				  <? }
			?>
				</table>
			</div>
			</td>
     </tr>
	</table>
	<br/>	
	<div id="regresar" style="width:98%; text-align:right; margin-bottom:10px;">
		<a href="movimientos_por_usuario.php"><strong><img src="../../public_root/imgs/b_firstpage.png" align="absmiddle" width="16" height="13" longdesc="Regresar" /> Regresar</strong></a>
	</div>	
	</form>
	<? }else{?>
	<form name="form_busqueda" action="movimientos_por_usuario.php#cabecera" method="post">
		<table width="40%" border="0" align="center">
		  <tr>
		    <td height="17" colspan="4"><img src="../../public_root/imgs/cabecera.jpg" width="632" height="49" /></td>
	      </tr>
		  <tr>
		    <td height="17">&nbsp;</td>
		    <td colspan="3">&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="4"><div align="center" class="cabecera_documento Estilo26">Filtros del Reporte </div></td>
	      </tr>
		  <tr>
		    <td height="18">&nbsp;</td>
		    <td colspan="3">&nbsp;</td>
	      </tr>
		  <tr>
			<td width="163"><strong class="Estilo22">Nombre del Area </strong></td>
			<td colspan="3">
				<? 
					$reporte = new Reporte();
					$areas = $reporte->obtener_areas();							
				?>			
				<select name="area_rep" id="area_rep" style="width:250px" class="caja">
					<option value="">--------------- Seleccione un Area -------------</option>
				<? foreach($areas as $area){?>
					<option value="<?=$area["id"]?>"><?=$area["area"]?></option>
				<? }?>
				</select>        </td>
		  </tr>
		  <tr>
		    <td><strong class="Estilo22">Nombre del Usuario </strong></td>
		    <td colspan="3">
				 <select name="destino" id="destino" style="width:250px" class="caja">
					<option value="">-------------- Seleccione un Usuario ------------</option>					
				 </select>
			 </td>
	     </tr>
		  <tr>
		    <td><strong class="Estilo22">Periodo </strong></td>
		    <td width="120">
			 	<input type="text" id="datepicker1" name="fecha_inicio" style="width:100px;" class="caja"/>			 </td>
	       <td width="42"> hasta </td>
	       <td width="295">
			 	<input type="text" id="datepicker2" name="fecha_fin" style="width:100px;" class="caja"/>			 </td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td colspan="3"><div align="right">
			  <input type="submit" name="Submit" value="Ver Reporte" class = "boton"/>
		    </div>
		  </td>
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