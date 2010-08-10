<?php	 	
	include_once("includes.php");
	require_once("cls/class.documento_reporte.php");
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
<link href="public_root/css/impresion_movimiento.css" media="print" rel="stylesheet">  
</head>
<body>
<?
    $doc_reporte = new Documento_Reporte($_REQUEST["id"]);
	$verComentario = false;
	$comentario = "";
	
    if($doc_reporte->getEstado()=="A"){
        $textRpta = "Fecha de Respuesta";		
		$verComentario = true;
		$comentario = $doc_reporte->getComentarioArchivo();
	}
    else{
        $textRpta = "Fecha Estimada de Respuesta";		
	}
	   
?>
<form id="form_detalle_documento" name="form_detalle_documento" method="post" action="">
  <fieldset>
  <legend>DATOS DEL DOCUMENTO</legend>
  <table border="0" align="center" class="formularios" width="100%">
    <tr>
      <td width="15%"  height="21" align="center" class="Estilo22"><div align="left">N&ordm; Registro</div></td>
      <td width="2%" align="center" class="Estilo22"><div align="center">:</div></td>
      <td width="53%" align="center"><div align="left">
        <?=$doc_reporte->getCodigo()?>
      </div>      </td>
      <td width="13%" align="center" class="Estilo22"><div align="left" class="Estilo22">Fecha de Registro</div></td>
      <td width="1%" align="center"><div align="center" class="Estilo22">:</div></td>
      <td width="16%" align="center"><div align="left">
        <?=$doc_reporte->getFechaRegistro()?>
      </div></td>
    </tr>
    <tr>
      <td  height="21" align="center" class="Estilo22"><div align="left">N&ordm; Documento </div></td>
      <td align="center" class="Estilo22"><div align="center">:</div></td>
      <td  height="21" align="center"><div align="left">
        <?=$doc_reporte->getNumero()?>
      </div>      </td>
      <td  height="21" align="center"><div align="left" class="Estilo22"><?=$textRpta?></div></td>
      <td  height="21" align="center"><div align="center" class="Estilo22">:</div></td>
      <td  height="21" align="center"><div align="left">
        <?=$doc_reporte->getFechaRespuesta()?>
      </div></td>
    </tr>
    <tr>
      <td  height="21" align="center"><div align="left" class="Estilo22">Remitente</div></td>
      <td align="center"><div align="center" class="Estilo22">:</div></td>
      <td  height="21" colspan="4" align="center"><div align="left">
        <?=$doc_reporte->getRemitente()?>
      </div></td>
    </tr>
    <tr>
      <td  height="21" align="center"><div align="left" class="Estilo22">Asunto </div></td>
      <td align="center"><div align="center" class="Estilo22">:</div></td>
      <td  height="21" colspan="4" align="center"><div align="left">
        <?=$doc_reporte->getAsunto()?>
      </div></td>
    </tr>
    <tr>
      <td  height="21" align="center"><div align="left" class="Estilo22">Doc. Digitalizado </div></td>
      <td align="center"><div align="center" class="Estilo22">:</div></td>
      <td  height="21" colspan="4" align="center">
	  <div align="left">
        <?
			$escaneo = "SELECT *
						from documentos_escaneados de
						where de.id_documento = ".$doc_reporte->getIdDocumento();
			$qescaneo = new Consulta($escaneo);
	  		$index = 1;
			
			$doc = new Documento ($doc_reporte->getIdDocumento());
			
			while($row_reg = $qescaneo->ConsultaVerRegistro()){
				if(is_null($row_reg['fecha_escaneo']))
					$ref = "Escaneo/".$row_reg['nombre_documento_escaneado'];
				else
					$ref = "../sad/Escaneado_completo/".$doc->getCodigo()."/".$row_reg['nombre_documento_escaneado'];
			?>
			<a href="<?=$ref?>"	id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank"><?=$index?></a>
			<?
				$index++;
			} ?>
		</div>
	</td>
    </tr>
	<? if($verComentario){?>
    <tr>
      <td  height="21" align="center"><div align="left" class="Estilo22">Comentario de Archivo </div></td>
      <td align="center"><div align="center" class="Estilo22">:</div></td>
      <td  height="21" colspan="4" align="center"><div align="left">
        <?=$comentario?>
      </div>      </td>
    </tr>
	<? } ?>
  </table>
  <p align="left" id="verDetalles"><a href="javascript:verDetalleDoc()" id = "control" class="v" >Ver Detalles </a></p>
  <div id="detalle_documento" style="display:none">
    <table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" width="100%">
      <tr>
        <td width="15%" class="Estilo22"><div align="left" class="Estilo22">Referencia</div></td>
        <td width="2%"  class="Estilo22"><div align="center" class="Estilo22">:</div></td>
        <td width="60%"><div align="left">
          <?=$doc_reporte->getReferencia()?>
        </div></td>
        <td width="18%"><div align="left" class="Estilo22">Tipo</div></td>
        <td width="2%"><div align="center" class="Estilo22">:</div></td>
        <td><div align="left">
          <?=$doc_reporte->getTipoDocumento()?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left" class="Estilo22">Anexo</div></td>
        <td  class="Estilo22"><div align="center" class="Estilo22">:</div></td>
        <td><div align="left">
          <?=$doc_reporte->getAnexo()?>
        </div></td>
        <td><div align="left" class="Estilo22">Folio</div></td>
        <td><div align="center" class="Estilo22">:</div></td>
        <td><div align="left">
          <?=$doc_reporte->getNumeroFolio()?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Observaci&oacute;n de Registro</div></td>
        <td  class="Estilo22"><div align="center">:</div></td>
        <td colspan="4"><div align="left"><?=$doc_reporte->getObservacion()?></div></td>
      </tr>     
    </table>
  </div>
  </fieldset>  
  <div align="center">
  	<br/>
    <table width="98%" border="0"  align="center" cellpadding="0" cellspacing="0" class="formularios" id="movimientos">
      <tr bgcolor="#6699CC" class="Estilo7">
        <td width="4%"><div align="center"><span class="msgok1">N&ordm; </span></div></td>
        <td width="23%"><div align="center"><span class="msgok1">Origen</span></div></td>
        <td width="23%"><div align="center"><span class="msgok1"> Destino</span></div></td>
        <td width="15%"><div align="center"><span class="msgok1">Accion</span></div></td>
        <td width="5%" align="center"><span class="msgok1">Categoria</span></td>
        <td width="13%" align="center"><span class="msgok1">Fecha Movimiento</span></td>
        <td align="center"><span class="msgok1">Estado</span></td>
      </tr>
      <? 
	  	 $movimientos = $doc_reporte->getMovimientos();
		
		 $tmov = count($movimientos);
         $cont = 1;
         for( $h = 0; $h < $tmov; $h++ ){
      ?>
      <tr>
        <td>
          <div align="center">
            <?=$h+1?>
          </div></td>
        <td><?=$movimientos[$h]["origen"]?></td>
        <td><?=$movimientos[$h]["destino"]?></td>
        <td><div align="center">
          <?=$movimientos[$h]["accion"]?>
        </div></td>
        <td align="center" ><?=($movimientos[$h]["categoria"]==1)?"Original":"Copia"?></td>
        <td align="center" ><?=$movimientos[$h]["fecha"]?></td>
        <td align="center" ><?=$movimientos[$h]["estado"]?></td>
      </tr>
      <? }?>
    </table>
	<br/>
    <p align="right" style="width:98%;">
      <input name="imprimir" type="submit" class="boton" onclick="javascript:imprimirDocumento()" value="Imprimir" id="imprimir"/>
    </p>
  </div>
</form>
</body>
</html>