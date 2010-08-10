<?php	 	
	include_once("includes.php");
	include_once("cls/class.accion.php");
	include_once("cls/class.usuario.php");
	include_once("cls/class.documentos.php");
	include_once("cls/class.plantilla_finalizado.php");
	
	if(!$_SESSION['session'][3] == "SI" ){
		header("location: error_permisos.php");
 	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>STD .:. Impresion Documento Finalizado</title>
<?php include_once("includes/inc.header.php"); ?>
<style type="text/css">
	body, table{
		color:#000000;
		font-family:Arial;
		font-size:13px
	}
	table h1{
		font-weight:bold;
		font-family:Arial, Helvetica, sans-serif;
		font-size:15px;
	}	
	p{
		margin: 3px auto 3px auto;
	}
	.firma{
		font-size:11px;
	}
</style>
<link href="public_root/css/impresion.css" media="print" rel="stylesheet">  
</head>
<body>
<?
if($_REQUEST["id"]){
	
	$doc = new Documento($_REQUEST["id"]);
	$id_fin = $doc->ObtenerIdFinalizado();
	
	$codigo = ObtenerCodigoFinalizado($_REQUEST["id"]);
	
	$sql_borrador = "SELECT * 
					FROM borradores_respuesta 
					where id_documento = '".$_REQUEST["id"]."' and
					aprobacion_respuesta_borrador=1";
						
	$query_borrador = new Consulta($sql_borrador);
	$row_borrador = $query_borrador->verRegistro();	
	
	$sql_des = "SELECT descripcion
				FROM saludo_despedida
				WHERE id_saludo_despedida='".$_REQUEST["despedida"]."'";
					
	$query_sql_des = new Consulta($sql_des);
	$row_des = $query_sql_des->verRegistro();			
	
	$despedida_doc=$row_des["descripcion"];	
	
	$jefe = new Usuario(ObtenerJefe());
    $nombre = $jefe->getNombreCompleto();
    $iniciales = $jefe->getIniciales();
    $cargo_j = $jefe->getCargo();
    $usuario = new Usuario($_SESSION['session'][0]);
	
	$tipo_doc = new TipoDocumento($_REQUEST["tipo"]);
		
?>
		<input type="hidden" name="asunto" id="asunto" value="<?=$_REQUEST["asunto"]?>">
		<input type="hidden" name="referencia" id="referencia" value="<?=$_REQUEST["referencia"]?>">
		<input type="hidden" name="tipo" id="tipo" value="<?=$_REQUEST["tipo"]?>">
		<input type="hidden" name="saludo" id="saludo" value="<?=$_REQUEST["saludo"]?>">
		<input type="hidden" name="despedida" id="despedida" value="<?=$_REQUEST["despedida"]?>">
		<input type="hidden" name="remitente" id="remitente" value="<?=$_REQUEST["destinatario"]?>">						
		<input type="hidden" name="cargo" id="cargo" value="<?=$_REQUEST["cargo"]?>">
		<input type="hidden" name="id_fin" id="id_fin" value="<?=$id_fin?>">						
		<input type="hidden" name="codigo_fin" id="codigo_fin" value="<?=$codigo?>">						
		
		<script>//javascript:CargarPlantilla();</script>
				
		<div id="contenido_documento">
			<table width="100%" border="0" id="contenedor">
              <tr>
                <td width="3%" height="17">&nbsp;</td>
                <td width="90%">&nbsp;</td>
                <td width="3%">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3"><div id="membretado" style="display:none; height:80px;"></div></td>
              </tr>
              <tr>
                <td height="18">&nbsp;</td>
                <td>
				  <div id="cabecera_documento">
                  		<p>Lima, <?=ObtenerFecha()?> </p>
                  		<h1 style="text-decoration:underline">
							<strong>
							<?=$tipo_doc->getNombre()?> 
							<? if(sizeof($_REQUEST["destinatario"]) > 1){?> MÚLTIPLE <? }?> SGD  N&ordm;
							<? if(empty($codigo)){?><span id = "codigo" style="color:#FFFFFF;"> 00000-2009</span><? }else{
							echo $codigo;}?>-SERNANP-
       		                </strong>
       		                <?=ObtenerAbreviaturaArea()?>
	                	</h1>
                  		<p>Se&ntilde;or<p/>
						 <? if(sizeof($_REQUEST["destinatario"])>0){
						  		for($j=0; $j<sizeof($_REQUEST['destinatario']);$j++){
						  ?>
						<p>
                      		<strong><?=strtoupper($_REQUEST["destinatario"][$j])?></strong><br />
							<strong><?=strtoupper($_REQUEST["cargo"][$j])?></strong>
						</p>
						<? 		}
							}
						?>	
                      	<br/>
                      	<p><u>Presente</u>.-</p>
					    <table border="0" cellspacing="0" cellpadding="0" width="468" align="right">
						  <tr>
						    <td width="93" valign="top"><p><strong>Asunto</strong></p></td>
							  <td width="30" valign="top"><div align="center"><strong>:</strong></div></td>
						    <td width="343" valign="top"><p><?=$_REQUEST["asunto"]?></p></td>
						  </tr>
						  
						  <?
						  	$reft = sizeof($_REQUEST["referencia"]);
						  	if($reft>0){
						  		for($j=0; $j<sizeof($_REQUEST['referencia']);$j++){
						  ?>
						  <tr>
						    <td width="93" valign="top"><p><strong>Referencia <? echo ($reft > 1)?($j+1):""?></strong></p></td>
						    <td width="30" valign="top"><div align="center"><strong>:</strong></div></td>
						    <td width="343" valign="top"><p><?=$_REQUEST["referencia"][$j]?></p></td>
						  </tr>
						  <? 	}
						  	}
						  ?>
					    </table>
                  <p></p>
                </div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
			  	<td>&nbsp;</td>
                <td>
					<div style="margin-top: 15px;">
						<?=$row_borrador["descripcion_borrador_respuesta"]?>
                	</div>				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
					<div id="despedida_documento"><?=$despedida_doc?></div>				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
			  	<td>&nbsp;</td>
                <td>
					<div id="pie_documento">
						<p align="left">Atentamente,</p>
						<p>&nbsp;</p>
						<? if($_REQUEST["tipo"] < 6){?>
						<div id="inferior" style="width:200px;">
						<? }?>
						<p align="center"><strong><?=$nombre?></strong><br />
						  <span class="firma"><?=$cargo_j?></span><br />
						  <span class="firma">Servicio  Nacional de &Aacute;reas Naturales </span><br />
						<span class="firma">Protegidas por el  Estado</span></p>
						<? if($_REQUEST["tipo"] < 6){?>
					  </div>
						<? }?>
						<p align="left"><?=$iniciales?>/<?=$usuario->getIniciales()?></p>
                	</div>				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="32">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2">
					<div align="right">
                  		<input type="submit" name="imprimir" id="imprimir" value="Imprimir" class="boton" onclick="javascript:imprimirDocumento()"/>
                	</div>				</td>
              </tr>
            </table>
		</div>
<? }?>		
</body>
</html>
