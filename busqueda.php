<?php  	
	include("includes.php");
	require_once("libs/lib.php");
	require_once("cls/class.documento_reporte.php");
	
	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}
	
	$table="registro";
	if(!isset($pag)){ $pag = 1; } 
	$tampag = 20;
	$reg1 = ($pag-1) * $tampag;
	 
	$pags=array($pag,$tampag,$table,$reg1);
	set_time_limit(100);
$menu = array(0,1,0,0,1,0); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include("includes/inc.header.php"); 
    ?>
    <script type="text/javascript" src="public_root/js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="public_root/js/jquery.bgiframe.min.js"></script>
    <script type="text/javascript" src="public_root/js/ui/ui.core.js"></script>
    <script type="text/javascript" src="public_root/js/ui/ui.draggable.js"></script>
    <script type="text/javascript" src="public_root/js/ui/ui.droppable.js"></script>
    <script type="text/javascript" src="public_root/js/ui/ui.datepicker.js"></script>
    <script type="text/javascript" src="public_root/js/ui/ui.datepicker-es.js"></script>
    <script type="text/javascript" src="public_root/js/ui/ui.dialog.js"></script>
    <script src="public_root/js/jgrid/jquery.layout.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/grid.import.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/JsonXml.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/json2.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/jquery.jqGrid.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/jqModal.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/jqDnR.js" type="text/javascript"></script>
    <script src="public_root/js/jgrid/grid.setcolumns.js" type="text/javascript"></script>
    <script type="text/javascript" src="public_root/js/leyendas/cargar_estados.js"></script>
    <link href="public_root/css/jquery.autocomplete.css" rel="stylesheet">
    <link href="public_root/css/start/ui.all.css" rel="stylesheet">
    <link href="public_root/css/ui.jqgrid.css" rel="stylesheet">

    <script type="text/javascript">
    var gridimgpath = 'public_root/css/start/images';
    jQuery(document).ready(function(){

        $.jgrid.defaults = $.extend($.jgrid.defaults,{loadui:"enable"});	

        jQuery("#frmgrid").jqGrid({
        url:'Ajax/AjaxBusqueda.php',
        datatype: "json",
        colNames:['asunto','N&ordm; Registro','Remitente', 'Documento', 'Registrado','F. Respuesta','Estado','Ubicacion'],
        colModel:[
            {name:'asunto',index:'asunto',hidden:true},
            {name:'registro',index:'registro', width:135,formatter:'link',formatoptions: {baseLinkUrl: 'VerDetalleBusqueda', addParam: '',showAction: 'popup'},align:"center"},
            {name:'remitente',index:'remitente', width:190},
            {name:'documento',index:'documento', width:190},
            {name:'fecha',index:'fecha', width:95, align:"center"},
            {name:'fecha_r',index:'fecha_r', width:95, align:"center"},
            {name:'estado',index:'estado', width:45,align:"center"},
            {name:'ubicacion',index:'ubicacion',width:70,align:'center'}
            
        ],
        rowNum:15,
        rowList:[10,15,20],
        imgpath: gridimgpath,
        pager: '#pfrmgrid',
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        caption:"",
        height:330
        });

    });
    </script>
    <title>MODULO DE TR&Aacute;MITE DOCUMENTARIO/B&Uacute;SQUEDA DE DOCUMENTOS</title>
</head>
<body>
<div id="#contenedor">
<span id="toolTipBox" width="200"></span>
<table  id="principal"  align="left" cellpadding="0" cellspacing="0" height="100%">
	<tr>		
		<td  align="left" colspan="2"> <?php Plantilla::PlantillaEncabezado("DESPACHO DE AREA ");?></td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">	
             <tr>
					<td><?php  Plantilla::menuSuperior("areas_acceso_registro.php",$menu,$_GET['id'],false);?></td>
				</tr>									
												
				<tr>								
				  <td style="width:100%; height:417px">
						<?php
                            include("buscador.php");
                        ?>
					</td>					
				</tr>			
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="2" class="pie"><?php Plantilla::PlantillaPie();?>	</td>
	</tr>	
</table>
</div>
</body>
</html>