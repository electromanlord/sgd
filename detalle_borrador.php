<?php	 	
	include_once("includes.php");
	include_once("cls/class.documentos.php");
    include_once("cls/class.borrador.php");
	include_once("cls/class.documento_finalizado.php");
	
	if(!$_SESSION['session'][3] == "SI" ){
		header("location: error_permisos.php");
 	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include_once("includes/inc.header.php"); ?>
<style>
	input:file{
		height:21px;
	}
	td{
		vertical-align:middle;
	}
</style>
<title>STD .:. Visualizar Borrador de Respuesta</title>
</head>
<body>	
	<fieldset>
		<legend>Borrador de Respuesta</legend>
		<?
		if($_REQUEST["idb"]){?>
		<?php
			$borrador = new Borrador($_REQUEST["idb"]);
            $usuario = $borrador->getUsuario();
            $categoria = $borrador->getCategoria();
            $destino = $borrador->getDestino();
            $accion = $borrador->getAccion();
            $descripcion = $borrador->getDescripcion();
            $doc = new Documento($borrador->getIdDocumento());
            $finalizado = $doc->ObtenerIdFinalizado();
			
			$documento = new DocumentoFinalizado($finalizado);
			$destinatario = $documento->getDestinatario();							
			$referencia = $documento->getReferencia();
			$asunto = $documento->getAsunto();
		?>
		<table width="100%" height="360" border="0">
		<tr>
			<td width="10%" height="20" class="Estilo22">Origen</td>
		  <td width="1%" class="Estilo22"><div align="center">:</div></td>
			<td colspan="2"><?=$usuario->getNombreCompleto()?></td>
		    <td width="12%" class="Estilo22">Destino</td>
	      <td width="2%" class="Estilo22"><div align="center">:</div></td>
		    <td colspan="2"><?=$destino->getNombreCompleto()?></td>
		    <td width="1%">&nbsp;</td>
		</tr>		
		<tr>
		  <td class="Estilo22" height="19">Asunto</td>
		  <td height="19" class="Estilo22"><div align="center">:</div></td>
		  <td colspan="8"><?=$asunto?></td>
		  </tr>
	  <? if(count($referencia)>0){
			for($i = 0; $i < count($referencia); $i++){
		?>
		<tr>		
		  <td class="Estilo22" height="19"><? if($i==0){?>Referencia<? }?></td>
		  <td height="19" class="Estilo22"><div align="center">:</div></td>
		  <td colspan="8"><?=$referencia[$i]["descripcion"]?></td>
		</tr>
		<?  }
		}
		?>
		<? if(count($destinatario)>0){
			for($i = 0; $i < count($destinatario); $i++){
		?>
		<tr>
		  <td class="Estilo22" height="19"><? if($i==0){?>Destinatario<? }?></td>
		  <td height="19" class="Estilo22"><div align="center">:</div></td>
		  <td><?=$destinatario[$i]["descripcion"]?></td>
		  <td>&nbsp;</td>
		  <td class="Estilo22"><? if($i==0){?>Cargo<? }?></td>
		  <td class="Estilo22"><div align="center">:</div></td>
		  <td colspan="2"><?=$destinatario[$i]["cargo"]?></td>
		  <td>&nbsp;</td>
		</tr>
		<?  }
		}
		?>
		<tr>
			<td class="Estilo22" height="19"> Respuesta</td>
			<td height="19" class="Estilo22"><div align="center">:</div></td>
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>
			<td height="183" colspan="10">
				<div id="borrador_rpa_view" style="border:#74AFCF solid 1px;height:200px; width:570px">
	             <?=$descripcion?>
				</div>		  </td>
		</tr>
		<tr>
			<td height="36" colspan="2" align="center" style="vertical-align:middle">
			<td width="32%">&nbsp;</td>
			<td width="18%">&nbsp;</td>
			<td colspan="3">
				<?
				if($_SESSION['session'][6]&&$categoria==1){?>					   
						<form method="post" id="form_finalizar_documento" name="form_finalizar_documento" action="javascript:finalizar_documento(<?=$borrador->getIdDocumento()?>,<?=$borrador->getId()?>)">
					  <input type="submit" name="finalizar" id = "finalizar" value="Finalizar" class="boton"/>
					  </form>
			  <? } ?>			</td>
			<td width="20%"><div align="right">
			<input name="cancelar" type="button" class="boton" id="cerrar_b" value="Cerrar" />
			</div></td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<? }	
	else{
	?>
	<script>javascript:cerrar_popups</script>
	<? }
	?>
	</fieldset>	
</body>
</html>