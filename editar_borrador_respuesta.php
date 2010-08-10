<?php	 	
	include_once("includes.php");
	include_once("cls/class.accion.php");
	include_once("cls/class.usuario.php");
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
<script type="text/javascript" src="public_root/js/Editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	language : 'es',
	mode : "exact",
	elements : "rpt_borrador",
	theme : "advanced",
	skin : "o2k7",

		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,fontselect,fontsizeselect,|,forecolor,backcolor,|,print,|,fullscreen",
	theme_advanced_buttons2 :"replace,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,tablecontrols,|,hr,|,template,pagebreak,|,spellchecker",
	theme_advanced_buttons3 : "sub,sup,charmap,|,visualchars,template,blockquote",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	spellchecker_languages : "+Espanol=es"
});
</script>
<?php include_once("includes/inc.header.php"); ?>
<style>
	input:file{
		height:21px;
	}
	td{
		vertical-align:middle;
	}

</style>
<title>STD .:. Editar Borrador de Respuesta</title>
</head>
<body>	
	<fieldset>
		<legend>Editar Borrador de Respuesta</legend>
	<?
	if($_REQUEST["opcion"]=='editrpta'){
		$borrador = new Borrador($_REQUEST['idb']);
		$id_doc = $borrador->getIdDocumento();
		$doc = new Documento($id_doc);
		$finalizado = $doc->ObtenerIdFinalizado();
        $rpta=$borrador->EditarDescripcion($_REQUEST["rpt_borrador"],$finalizado);
        if($rpta){            
            echo  "<div id='error'><p>Se modifico la respuesta correctamente</p></div>";
        }else{
            echo  "<div id='error'>Hubo un error al procesar su consulta</div>";
        }
    ?>
    <br/>
    <br/>
    <input name="cancelar" type="button" class="boton" id="cerrar_b" value="Cerrar" />
    <?
	}else{
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
			<form id="form_borrador" name="form_borrador" method="post" action="javascript:validar_edicion_borrador(<?= $_REQUEST["idb"]?>)">				

		<table width="100%" border="0">
		<tr>
			<td width="10%" height="20" class="Estilo22">Origen</td>
			<td width="2%" class="Estilo22"><div align="center">:</div></td>
			<td width="28%"><?=$usuario->getNombreCompleto()?></td>
		  <td width="7%" class="Estilo22"><div align="left">Categoria</div></td>
		  <td width="2%" class="Estilo22"><div align="center">:</div></td>
			<td colspan="2"><?=($categoria==1)?"Original":"Copia"?></td>
	      </tr>
		<tr>
		  <td height="20" class="Estilo22">Destino</td>
		  <td class="Estilo22"><div align="center">:</div></td>
		  <td><?=$destino->getNombreCompleto()?></td>
		  <td><div align="left" class="Estilo22">Accion</div></td>
		  <td><div align="center" class="Estilo22">:</div></td>
		  <td colspan="2"><?=$accion->getNombre()?></td>
		  </tr>
		<? if(count($destinatario)>0){
			for($i = 0; $i < count($destinatario); $i++){
		?>  
		<tr>
		  <td class="Estilo22" height="19"><? if($i==0){?>Destinatario<? }?></td>
		  <td height="19" class="Estilo22"><div align="center">:</div></td>
		  <td>		  
		  <div align="left">
		    <input name="destinatario[]" type="text" id="destinatario" size="38" value="<?=$destinatario[$i]["descripcion"]?>" class="caja"/>
		  </div>		  </td>
		  <td class="Estilo22"><? if($i==0){?><div align="left">Cargo</div><? }?></td>
		  <td><div align="center" class="Estilo22">:</div></td>
		  <td colspan="2">
	        <div align="left">
	          <input name="cargo[]" type="text" id="cargo" size="43" value="<?=$destinatario[$i]["cargo"]?>" class="caja"/>
          	</div>		  </td>
		</tr>
		<?  }
		  }
		?>
		<tr>
		  <td class="Estilo22" height="19">Asunto</td>
		  <td height="19" class="Estilo22"><div align="center">:</div></td>
		  <td colspan="5"><div align="left">
		    <input name="asunto" type="text" id="asunto" size="105" value="<?=$asunto?>" class="caja"/>
		    </div></td>
		  </tr>
		<tr>
		<? if(count($referencia)>0){
				for($i = 0; $i < count($referencia); $i++){
			?>
		  <td class="Estilo22" height="19"><? if($i==0){?>Referencia<? }?></td>
		  <td height="19" class="Estilo22"><div align="center">:</div></td>
		  <td colspan="5">		  	
		  	<div align="left">
		    	<input name="referencia[]" type="text" id="referencia" size="105" value="<?=$referencia[$i]["descripcion"]?>" class="caja"/>
		    </div>		  </td>
		</tr>
		<?  }
		}
		?>
		<tr>
			<td class="Estilo22" height="19"> Respuesta</td>
			<td height="19" class="Estilo22"><div align="center">:</div></td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td height="371" colspan="7">
				<div align="center">
                    <textarea name="rpt_borrador" cols="120" rows="25" id="rpt_borrador">
                        <?=$descripcion?>
                    </textarea>
				</div>                </td>
		</tr>
		<tr>
			<td height="36" colspan="2" align="center" style="vertical-align:middle">
		  <td>&nbsp;</td>
		  <td colspan="3"><div align="right">
            <input name="aceptar" type="submit" class="boton" id="modificar_b" value="Modificar"/>
          </div></td>
		  <td width="23%"><div align="right">
            <input name="cancelar2" type="button" class="boton" id="cancelar_b" value="Cancelar" />
          </div></td>
		</tr>
	</table>
	</form>
	<? }	
	else{
	?>
	<script>javascript:cerrar_popups</script>
	<? }
	}
	?>
	</fieldset>	
</body>
</html>