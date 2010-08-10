<?php  
	include_once("includes.php");
	include_once("cls/class.accion.php");
    include_once("cls/class.documento_finalizado.php");
	include_once("cls/class.usuario.php");
	include_once("cls/class.documentos.php");
	
	if(!$_SESSION['session'][3] == "SI" ){
		header("location: error_permisos.php");
 	}		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<script type="text/javascript" src="public_root/js/Editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script>
tinyMCE.init({
	language : 'es',
	mode : "exact",
	elements : "rpt_borrador",
	theme : "advanced",
	skin : "o2k7",
	
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,fontselect,fontsizeselect,|,forecolor,backcolor,|,sub,sup,charmap,|,print,|,fullscreen",
	theme_advanced_buttons2 :"replace,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,tablecontrols,|,hr,|,template,pagebreak,|,spellchecker",
	theme_advanced_buttons3 : "visualchars,template,blockquote",
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
		vertical-align:top;
		padding-top:3px;
	}
</style>
<title>STD .:. Elaborar Borrador de Respuesta</title>
</head>
<body>
	<fieldset>
		<legend>Borrador de Respuesta</legend>							

	<?
	if($_REQUEST["opcion"]=='addha'){
		$documento = new Documento($_REQUEST['id']);
        $borr=$documento->addHistorialBorrador();
        if($borr!=0){
            Documentos::GuardarArchivo($borr);
            echo  "<p>Se Elaboro el borrador correctamente</p></div>";
        }else{
            echo  "<div id='error'>Hubo un error al procesar su consulta</div>";
        }
    ?>
    <br/>
    <br/>
    <input name="cancelar" type="button" class="boton" id="cerrar_b" value="Cerrar" />
    <?
	}else{
		$usuario= new Usuario($_REQUEST["usu"]);
		$accion= new Accion($_REQUEST["acc"]);
		$categoria=($_REQUEST["cat"]==1)?"Original":"Copia";
		
		if($_REQUEST["id"]){
			
			$documento = new Documento($_REQUEST["id"]);
            $finalizado = $documento->ObtenerIdFinalizado();
			
            if($finalizado==0){ //No existe				
                $remitente = $documento->getRemitente();
                $dest = $remitente->getNombre();				
                $ref = $documento->getReferencia();	
                $asunto = "";
				$cargo = "";
            }else{			
                $cls_finalizado = new DocumentoFinalizado($finalizado);				
				$destinatario = $cls_finalizado->getDestinatario();							
				$referencia = $cls_finalizado->getReferencia();
				$asunto = $cls_finalizado->getAsunto();			
            }
			
		?>
		
		<?php  
			if( $_SESSION['session'][3] == "SI" ){  
		?>
			<form id="form_borrador" name="form_borrador" method="post" action="javascript:validar_historial_atencion(<?= $_REQUEST["id"]?>)" enctype="multipart/form-data">			
				<input type="hidden" id="area" name="area" value="<?php echo $_SESSION['session'][5] ?>" />
				<input type="hidden" id="user" name="user" value="<?php echo $_SESSION['session'][0] ?>" />			
				<input type="hidden" id="usuario" name="usuario" value="<?=$usuario->getId()?>" readonly="readonly"/>
				<input type="hidden" id="categoria" name="categoria" size="30" value="<?=$_REQUEST["cat"]?>"/>
				<input type="hidden" id="accion" name="accion" value="<?=$accion->getId()?>"/>			
				<textarea id="comentario" name="comentario" style="display:none"></textarea>			

		<table width="100%" border="0">
		<tr>
			<td width="11%" class="Estilo22">Pase a </td>
	  	  	<td width="3%" class="Estilo22"><div align="center">:</div></td>
			<td><?=$usuario->getNombreCompleto()?></td>
		    <td class="Estilo22" width="8%">Categoria</td>
      	  <td class="Estilo22" width="3%"><div align="center">:</div></td>
		    <td width="44%" colspan="2"><?=$categoria?></td>
		</tr>
		<tr>
			<td class="Estilo22">Accion</td>
			<td class="Estilo22"><div align="center">:</div></td>
			<td colspan="5"><?=$accion->getNombre()?></td>
		</tr>
		<tr>
			<td><span class="Estilo22">Comentario</span></td>
			<td class="Estilo22" style="vertical-align:top; text-align:center;padding-top:4px;"><div align="center">:</div></td>
			<td colspan="5"><input name="adicional" type="text" id="adicional" style="width:645px" class="caja"/></td>
		</tr>
		<tr>
			<td class="Estilo22">Asunto</td>
			<td class="Estilo22"><div align="center">:</div></td>
			<td colspan="5"><input name="asunto" type="text" id="asunto"  style="width:645px"value="<?=$asunto?>" class="caja"/></td>
		</tr>
		<tr>
			<td class="Estilo22">Referencia</td>
			<td class="Estilo22"><div align="center">:</div></td>
			<td colspan="4">
				<div class="contenedor">
				<? if(count($referencia)>0){
					for($i = 0; $i < count($referencia); $i++){
				?>
				<div align="left" class="item" id="primero">
				  <input name="referencia[]" type="text" id="referencia"  style="width:645px" value="<?=$referencia[$i]["descripcion"]?>"/>
				  <span>
				  <img src="public_root/imgs/edit_remove.png" onclick="quita_item_borrador(this)" style="margin-top:1px;" border="none"/>
				  </span>
				 </div>
				 <? }?>
				<? }else{?>
				<div align="left" class="item" id="primero">
				  <input name="referencia[]" type="text" id="referencia"  style="width:645px" value="<?=$ref?>" class="caja"/>
				  <span>
				  <img src="public_root/imgs/edit_remove.png" onclick="quita_item_borrador(this)" style="margin-top:1px;" border="none"/>
				  </span>
				 </div>
				<? }?> 
				</div>
			</td>
			<td width="5%" style="vertical-align:top;">
		    	<div align="center">
					<img src="public_root/imgs/edit_add.png" onclick="agrega_item_borrador(this)" style="margin-top:1px;" border="none"/>				</div>
			</td>
		</tr>
		<tr>
			<td class="Estilo22">Destinatario</td>
			<td class="Estilo22"><div align="center">:</div></td>
			<td colspan="4">				
				<div class="contenedor">
				<? if(count($destinatario)>0){
					for($i = 0; $i < count($destinatario); $i++){
				?>
				<table border="0" width="100%" cellspacing="0" cellpadding="0" class="item" id="primero">
              	<tr>
                	<td width="48%">
					<input name="destinatario[]" type="text" id="destinatario" size="54" value="<?=$destinatario[$i]["descripcion"]?>" class="caja"/>
					</td>
					<td width="9%" class="Estilo22"> Cargo </td>
					<td width="3%" class="Estilo22"><div align="center">:</div></td>
					<td width="40%">
						<input type="text" name="cargo[]" id="cargo" style="width:241px" value="<?=$destinatario[$i]["cargo"]?>" class="caja"/>
						<img src="public_root/imgs/edit_remove.png" onclick="quita_item_borrador(this)" style="margin-top:1px;" border="none"/>
					</td>
              </tr>
            </table>			
				 	<? }?>
				<? }else{?>
					<table border="0" width="100%" cellspacing="0" cellpadding="0" class="item" id="primero">
              		<tr>
                		<td width="48%">
							<input name="destinatario[]" type="text" id="destinatario" size="54" value="<?=$dest?>"/>
						</td>
						<td width="9%" class="Estilo22"> Cargo </td>
						<td width="3%" class="Estilo22"><div align="center">:</div></td>
						<td width="40%">
							<input type="text" name="cargo[]" id="cargo" style="width:241px" value="<?=$cargo?>" class="caja"/>
							<img src="public_root/imgs/edit_remove.png" onclick="quita_item_borrador(this)" style="margin-top:1px;" border="none"/>
						</td>
              		</tr>
            		</table>
				<? }?>
			</div>
			</td>
			<td style="vertical-align:top;">		  	
				<div align="center"><img src="public_root/imgs/edit_add.png" onclick="agrega_item_borrador(this)" style="margin-top:1px;" border="none"/>			</div></td>
		</tr>
		<tr>
			<td>
				<label class="Estilo22" >Documento</label>			</td>
			<td class="Estilo22" style="vertical-align:top;"><div align="center">:</div></td>
			<td>
				<div class="contenedor">
					<div style="float:left" class="item"  id="primero">
					  <input id="doc[]" type="file" name="doc[]" size="39" /> 
					  <span><img src="public_root/imgs/edit_remove.png" onclick="quita_item_borrador(this)" style="margin-top:1px;" border="none"/></span>				</div>
				</div>			</td>
			<td style="vertical-align:top;">
		  		<div align="left">
					<img src="public_root/imgs/edit_add.png" onclick="agrega_item_borrador(this)" style="margin-top:1px;" border="none"/>				</div>			</td>
			<td colspan="3" class="Estilo21" style="vertical-align:top; padding-top:2px;">
			<strong>(*) Tama&ntilde;o M&aacute;ximo 2Mb </strong>			</td>
	      </tr>
		<tr>
			<td class="Estilo22"><a href="javascript:mostrar_word()" class="oculto" id="ver_mas">Ver M&aacute;s</a></td>
			<td class="Estilo22"><div align="center">:</div></td>
			<td colspan="5"></td>
		</tr>
		<tr>
			<td colspan="8">
				<div align="center" id="word"></div>			</td>
		</tr>
		<tr>
			<td colspan="7" align="center" style="vertical-align:middle">
				<div align="right" style="float:left; width:80%">
				  <input name="aceptar" type="submit" class="boton" id="aceptar_b" value="Aceptar"/>
				</div>
				<div align="right">
				  <input name="cancelar2" type="button" class="boton" id="cancelar_b" value="Cancelar" />
				</div>			</td>
		  </tr>
	</table>
	</form>
	<?
	}else if($_SESSION['session'][3]=="NO") {
		echo "<div id='error'> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta informacin </div><br><br>";		
			}else{
				echo " ERROR: Usted esta entrando de manera Incorrecta !!! " ;
			}	?>
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
