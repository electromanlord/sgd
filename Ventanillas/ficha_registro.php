<? 
 
	///http://localhost/std/php-barcode-0.3pl1/barcode.php
	session_start();
	if($_GET[pdf]=='ok'){
		require_once('../../pdf/html2fpdf.php');
		
		ob_start();
	}
	
	include("../includes.php");
	require_once("../cls/ventanillas_acceso_registro.cls.php");
	$link=new Conexion();
	#ini_set("display_errors",1);	
	$sql="Select * from documentos as d where d.id_documento='".$_GET['id']."'";
	$q_reg=new Consulta($sql);		
	$rowreg=$q_reg->ConsultaVerRegistro();
	$doc = new Documento($_GET['id']);
	#dump($doc);
    
	$tipo=$rowreg["id_tipo_documento"];
	$remitente=$rowreg["id_remitente"];
?>

<title> Reporte de Tramite Documentario - Registro de Documentos </title>
<link rel="stylesheet" type="text/css" href="../../std/style.css">
<script language="javascript" src="js/js.js"></script> 

<style type="text/css">
<!--
.primeracolumna {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;	
}
.titulo {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;	
}
.detalle {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.numero{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Estilo1 {font-size: 10px}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.Estilo3 {font-size: 10px}
-->
</style>
<body topmargin="0" leftmargin="0">

<div id="barraBotones" name="barraBotones">
	<?
		$med_t='100%';
	
		if($_GET['pdf']!='ok'){ $med_t='90%';
			$dir_pdf=$_SERVER['PHP_SELF'].'?idcons='.$idcons.'&md='.$md.'&pdf=ok';
		
		}
	?>
</div>

	<table width="32%"  border="0" align="left">
		<tr>
			<td><p><img src="../public_root/imgs/cabecera.jpg" width="345" height="60"/></p></td>
		</tr>
	</table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table bordercolor="" width="32%"  border="0" align="left">
		<tr class="Estilo33">
			<td width="36%" height="23" align="right">&nbsp;</td>
			<td height="23" colspan="3" align="right"><div align="right"><b>
			  <?=$rowreg[1]?>
		    </b></div></td>
	    </tr>
        <tr class="Estilo33">
			<td height="20" colspan="4" align="center"><span class="titulo">Hoja de Tramite</span></td>
        </tr>
        <tr class="Estilo1">
			<?
				$sql_remi = "Select * FROM remitentes AS r 
							INNER JOIN tipo_remitente AS tr ON tr.id_tipo_remitente = r.id_tipo_remitente 
							WHERE r.id_remitente='".$rowreg['id_remitente']."'";
							
				$q_remi=new Consulta($sql_remi);		
				$rowremi=$q_remi->ConsultaVerRegistro();			
			?>
			<td align="left" class="primeracolumna">
			  	<span class="Estilo15">Origen</span>			</td>
			<td colspan="3" align="left" class="detalle" >
		  		<span class="Estilo16"><?=$rowremi['tipo_remitente_nombre']?></span>			</td>
        </tr>
        <tr class="Estilo1">
			<td align="left" class="primeracolumna">
		  		<span class="Estilo15">Fecha de Registro</span>			</td>
			<td colspan="3" align="left" class="detalle">
				<span class="Estilo16"><?=$rowreg['fecha_registro_documento']?></span>			</td>
        </tr>
        <tr class="Estilo1">
			<td align="left" class="primeracolumna">
				<span class="Estilo15">Remitente</span>			</td>
			<td colspan="3" align="left" class="detalle">
				<span class="Estilo17"><?=$rowremi['nombre_remitente']?></span>			</td>
        </tr>
        <tr class="Estilo1">
			<td align="left" class="primeracolumna">
				<span class="Estilo15">Nro. Documento</span>			</td>
			<td colspan="3" align="left" class="detalle">
				<span class="Estilo17"><?=$rowreg['numero_documento']?></span>			</td>
        </tr>
        <? if($doc->expediente){ ?>
        <tr class="Estilo1">
			<td align="left" class="primeracolumna">
		  		<span class="Estilo15">Nro. Expediente</span>			</td>
			<td colspan="3" align="left" class="detalle">
				<span class="Estilo16"> <?=$doc->expediente?></span>			</td>
        </tr>
        <?}?>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td align="left" class="Estilo1" >Derivado a:</td>
			<td align="left" class="Estilo1" >Fecha:</td>
			<td width="13%" align="right" class="Estilo1" >Accion:</td>
			<td width="22%" align="center" class="Estilo2" >&nbsp;</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
        </tr>
        <tr class="primeracolumna">
			<td colspan="4" align="left" class="detalle">
				<span class="Estilo3">Observacion:</span>			</td>
        </tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
		</tr>
		<tr>
			<td height="21" colspan="4" align="left">
				<p>___________________________________________</p>			</td>
		</tr>
		<tr>
			<td height="34" colspan="4" align="left">
				<div align="center">
					<img src="../php-barcode/barcode.php?code=<?=$rowreg[1]?>&encoding=EAN&scale=1&mode=png" alt=""/>				</div>			</td>
		</tr>
	</table>
</body>
<script>
	javascript:salida_impresora();
	window.close();
</script>