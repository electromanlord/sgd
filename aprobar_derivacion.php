<?php  
	include_once("includes.php");
	include_once("cls/class.accion.php");
	include_once("cls/class.usuario.php");
	include_once("cls/class.documentos.php");	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<?php include_once("includes/inc.header.php"); ?>
<style>
	input{
		height:21px;
	}
	td{
		vertical-align:middle;
	}
	fieldset{
		margin:0px 4px 4px 4px;
		width:95%;
	}
	
</style>
<title>STD .:. Aprobar Derivacion</title>
</head>
<body>
	<fieldset>
		<legend>Aprobaci&oacute;n de la Derivaci&oacute;n de &Aacute;rea </legend>							
	    <?
		if($_REQUEST["opcion"]=='addha'){
			$documento = new Documento($_REQUEST['id']);
			$atencion  = $documento->addHistorialAtencion();
			if($atencion!=0){
				Documentos::GuardarArchivoJustificacion($atencion);
				echo  "<p>Se propuso correctamente</p></div>";
			}else{
				echo  "<div id='error'>Hubo un error al procesar su consulta</div>";
			}
    	}else{		
		if($_REQUEST["id"]){			
			$accion= new Accion($_REQUEST["acc"]);
			$categoria=($_REQUEST["cat"]==1)?"Original":"Copia";					                             			  
		?>
		<form id="form_justificacion" name="form_justificacion" method="post" action="javascript:validar_aprobacion(<?= $_REQUEST["id"]?>)" enctype="multipart/form-data">			
				<input type="hidden" id="area" name="area" value="<?php echo $_SESSION['session'][5] ?>" />
				<input type="hidden" id="user" name="user" value="<?php echo $_SESSION['session'][0] ?>" />			
				<input type="hidden" id="categoria" name="categoria" size="30" value="<?=$_REQUEST["cat"]?>"/>
				<input type="hidden" id="accion" name="accion" value="<?=$accion->getId()?>"/>	

		<table width="100%" height="275" border="0">
		<tr>
			<td width="10%" height="21" class="Estilo22">Acci&oacute;n</td>
			<td width="1%" class="Estilo22"><div align="center">:</div></td>
			<td ><?=$accion->getNombre()?></td>
		    <td colspan="3" class="Estilo22" width="7%">Categoria</td>
		    <td width="1%" class="Estilo22"><div align="center">:</div></td>
		    <td colspan="2" width="7%"><?=$categoria?></td>
		</tr>
		
		<tr>
		  <td height="24" colspan="3" class="Estilo21"><strong>(*) Tama&ntilde;o M&aacute;ximo 2Mb </strong></td>
		  <td colspan="4" style="vertical-align:top;">&nbsp;</td>
		  <td colspan="2" class="Estilo21" style="vertical-align:top; padding-top:2px;">&nbsp;</td>
		  </tr>
		<tr>
			<td height="24" style="vertical-align:top;"><label style="margin-top:1px;" class="Estilo22">Documento</label></td>
			<td class="Estilo22" style="vertical-align:top; text-align:center;padding-top:4px;"><div align="center">:</div></td>
			<td>
				<div class="ileft_img">
				<div id='cp_item_0' style="float:left">					
					<input id="doc[]" type="file" name="doc[]" size="39" />
				</div>
				 <div class="iright_img" style="float:left; height:22px;"></div>
			  </div>			</td>
		    <td width="3%" style="vertical-align:top;"><img src="public_root/imgs/edit_add.png" alt="" onclick="crearCarchivo(2)" style="margin-top:1px;"/></td>
		    <td width="3%" style="vertical-align:top;"><img src="public_root/imgs/edit_remove.png" alt="" onclick="quitarCarchivo(2)" style="margin-top:1px;"/></td>
		    <td style="vertical-align:top;" colspan="2">&nbsp;</td>
		    <td colspan="2">&nbsp;</td>
	      </tr>
		<tr>
			<td class="Estilo22" height="19"> Comentario </td>
			<td height="19" class="Estilo22"><div align="center">:</div></td>
			<td colspan="7">&nbsp;</td>
		</tr>
		<tr>
			<td height="137" colspan="9">
				<div align="center"><textarea name="comentario" cols="80" rows="10" id="comentario"></textarea>
				</div>			</td>
		</tr>
		<tr>
			<td height="36" colspan="2" align="center" style="vertical-align:middle">
		  <td>&nbsp;</td>
		  <td colspan="5">		    <div align="right">
		    <input name="aceptar" type="submit" class="boton" id="aceptar_b" value="Aceptar"/>	      
	      </div></td>
		  <td width="12%"><div align="right">
		    <input name="cancelar" type="button" class="boton" id="cancelar_b" value="Cancelar" />
	      </div></td>
		</tr>
	</table>
	</form>
	<?
	}else{
	?>
		<script>javascript:cerrar_popups</script>
	<? }
	}
	?>
	</fieldset>
</body>
</html>
