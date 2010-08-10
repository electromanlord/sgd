<?php  
	include("includes.php");
	include_once("cls/class.documentos.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>STD .:. Archivar Documento</title>
<?php include_once("includes/inc.header.php"); ?>
</head>
<body>
<?php  
if( $_SESSION['session'][3] == "SI" ){ 
	
	if($_REQUEST['op']=="cargar_adj"){
		if($_REQUEST['id_hist']&&$_REQUEST['id_hist']!=0){
			Documentos::GuardarArchivoRespuesta($_REQUEST['id_hist']);
			Documentos::GuardarAdjuntosArchivo($_REQUEST['id_hist'],$_REQUEST['cat']);
			echo  "<p>Se propuso correctamente</p></div>";			
		}
		?>
		<input name="cancelar" type="button" class="boton" id="cerrar_a" value="Cerrar" />
		<?
	}else{	
	 
?>
<fieldset>
	<legend>Archivar Documento</legend>
	<form id="form_archivo" name="form_justificacion" method="post" action="javascript:ArchivarCompletado(<?=$_REQUEST['id']?>)" enctype="multipart/form-data">																
	<input type="hidden" value="<?=$_REQUEST["cat"]?>" id="cat">
	<input type="hidden" value="<?=$_REQUEST["tipo"]?>" id="tipo">
	<input type="hidden" value="" id="id_archivo">
	<table border="0">
	<tr>
	  <td height="26" colspan="7" class="Estilo21"><strong>(*) Tama&ntilde;o M&aacute;ximo 2Mb </strong></td>
	  </tr>
	<tr>
	  <td height="26" class="Estilo22">Doc. Respuesta </td>
	  <td height="26" class="Estilo22"><div align="center">:</div></td>
	  <td colspan="5"><span style="float:left">
	    <input id="respuesta" type="file" name="respuesta" size="39" />
	  </span></td>
	  </tr>
	<tr>
	  <td height="26" class="Estilo22"><div align="left">Doc. Adjunto</div></td>
	  <td height="26" class="Estilo22"><div align="center">:</div></td>
	  <td>
	 	<div class="ileft_img">
			<div id='cp_item_0' style="float:left">					
				<input id="doc[]" type="file" name="doc[]" size="39" />
			</div>
		    <div class="iright_img" style="float:left; height:22px;"></div>
		</div>	  </td>
	  <td><div align="center"><img src="public_root/imgs/edit_add.png" alt="" onclick="crearCarchivo(2)" style="margin-top:1px;"/></div></td>
	  <td><div align="center"><img src="public_root/imgs/edit_remove.png" alt="" onclick="quitarCarchivo(2)" style="margin-top:1px;"/></div></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
		<td height="26" class="Estilo22"><div align="left">Descripci&oacute;n</div></td>
	  <td height="26" class="Estilo22"><div align="center">:</div></td>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td height="62" colspan="7">
			
				<div align="center">
					<textarea name="textarea" cols="80" rows="6" id="comentario" class="caja"></textarea>
				</div>		</td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td colspan="4"><div align="right">
		  <input name="Submit" type="submit" class="boton" value="Archivar" />
	    </div></td>
	    <td><div align="right">
	      <input name="Submit2" type="button" class="boton" value="Cancelar" onclick="cerrar_popups();"/>
      </div></td>
	</tr>
</table>
<?	
	}
	}else if($_SESSION['session'][3]=="NO") {
		echo "<div id='error'> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta informacin </div><br><br>";		
	}else{
		echo " ERROR: Usted esta entrando de manera Incorrecta !!! " ;
	}	?>
	</form>
</fieldset>
</body>
</html>
