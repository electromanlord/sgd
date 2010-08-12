<?php
	/**
	 * Edited by Enrique Juan de Dios 
	 * 12JUL2010
	 */
	include("includes.php");
    
	require_once("cls/atencion.cls.php");
    require_once('cls/class.areas.php');
    require_once('cls/class.remitentes.php');
	require_once("cls/class.documento_reporte.php");
    
    
    if (!ini_get('display_errors')) {
        ini_set('display_errors', 1);
    }
    
    
	if(!$_SESSION['session'][3] == "SI" ){
        ?>
            <script>location.href="error_permisos.php";</script>
        <?
        exit;
	}
    $areas = new Areas();
    $remitentes = new Remitentes();
    $remitente_etiquetas = array(
        'MEF'=>'Ministerio de Econom&iacute;a y Finanzas',
        'CONG'=>"Congreso de la Rep&uacute;blica",
        'MINAM'=>"Ministerio del Ambiente",
        'CONT'=>'Contralor&iacute;a general de la Rep&uacute;blica');

    $params = array('pendientes','atendidos','vencidos');
    $get = (object)$_GET;
    $filtro = 'atencion';
    
    $pendientes = isset($get->pendientes) && $get->pendientes;
    $vencidos = isset($get->vencidos) && $get->vencidos;
    $atendidos = isset($get->atendidos) && $get->atendidos;
    
    $areas = $areas->lista();
    
    $remitentes = $remitentes->urgentes();
    
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
        <?php include("includes/inc.header.php"); ?>
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
var now = "";
var list;
jQuery(document).ready(function(){

    /****************REPORTES****************/
	list = $(".ch",document);
	for(var i = 0,t = list.length; i<t; i++){
		var id = list[i].getAttribute('id');
		D[ id ] = $('#'+id);
	}
	
    D.loading.removeClass('hidden').hide();
    D.area = D.filters.find('select').change(changeFilter);
    D.filters.find('input.checkbox').click(changeFilter);
    D.filters.submit(changeFilter);
	
    function changeFilter(e){
		
		var id =this.getAttribute('id');
		if( id=='filters' ){
			e.preventDefault();
		}
		D.reg.val(D.doc.val());
		//D.asu.val(D.doc.val());
		
		// When Remitents is active, disable search by remitente
		if( D.rem ){
			D.rem_bk.attr('disabled','disabled');
		}else{
			//D.rem_bk.val(D.reg.val()); 
		}
		
        if(this.getAttribute('id') == "pendientes" || this.getAttribute('id') == "atendidos" ){
            D.est.val( this.checked? this.value:"" );
        }
        if(this.name == 'ubi'){

            if(this.value !="" ){
                D.usuarios.empty();
                D.despacho.hide().find('input').removeAttr('checked');
                var id = this.options[this.selectedIndex].getAttribute('param');
                $.get('Ajax/AjaxUsuarios.php',{ubi:id},function(r){
                    if(typeof(r) == 'object' && r.length > 0){
                        var options = '<option value=""> Todos...</option>';
                        for(var i=0,t=r.length;i<t;i++){
                            options +='<option value="'+r[i].login_usuario+'">'+ r[i].nombres +'</option>';
                        }
                        D.usuarios.html(options);
                        D.selectUsuario.show();
                    }
                },'json');
            }else {
                D.despacho.show();
                D.selectUsuario.hide();
                D.usuarios.empty();        
            }
                D.selectCopias.hide();
                D.copias.val("");
        }
        if(this.name == 'usuarios' ){
			if( this.value == ''){
				D.selectCopias.hide();
                D.copias.val(""); 
			}else{
				D.selectCopias.show();
			}
		}

        if(this.name=='nodespachado' && this.checked ){
            D.doc.val("");
            if(D.ubi){
                D.ubi.val("");
                D.selectUsuario.hide();
                D.usuarios.empty();
            }
            D.vencidos.attr('checked',''); 
            D.pendientes.attr('checked','');
        }
        setFilter();
    }
    
    
    function setFilter(e){
        jQuery("#frmgrid").setGridParam({url:"Ajax/AjaxReporte.php?"+D.filters.serialize() ,page:1}).trigger("reloadGrid"); 
    }
    
    /************************************************/
    
	$.jgrid.defaults = $.extend($.jgrid.defaults,{loadui:"enable"});	

   	$grid = jQuery("#frmgrid").jqGrid({
        url:'Ajax/AjaxReporte.php?todos=1',
        datatype: "json",
        colNames:['asunto','N&ordm; Registro','Remitente', 'Documento', 'Registrado','Respuesta','Estado','Ubicacion','Dias'],
        colModel:[
            {name:'asunto',index:'asunto',hidden:true},
            {name:'registro',index:'registro', width:135,formatter:'link',formatoptions: {baseLinkUrl: 'VerDetalleBusqueda', addParam: '',showAction: 'popup'},align:"center"},
            {name:'remitente',index:'remitente', width:190},
            {name:'documento',index:'documento', width:190},
            {name:'fecha',index:'fecha', width:70, align:"center"},
            {name:'fecha_r',index:'fecha_r', width:70, align:"center"},
            {name:'estado',index:'estado', width:45,align:"center"},
            {name:'ubicacion',index:'ubicacion',width:70,align:'center'},
            {name:'dias_faltantes',index:'dias_faltantes',width:30,align:'center'}
            
        ],
        rowNum:15,
        rowList:[10,15,20],
        imgpath: gridimgpath,
        pager: '#pfrmgrid',
        sortname: 'fecha',
        viewrecords: true,
        sortorder: "desc",
        caption:"",
        height:330,
        loadComplete:function(){
            jQuery("#frmgrid").find('tr td:eq(8)').each(function(i,e){
                    var el = $(e), dias =  parseInt( $(e).text(),10 );
                    if (dias<0){ el.parent().addClass('ended');}
                    else if(dias ==0){el.parent().addClass('warning')}
            })
        }
	});

    
});
</script>
<title>MODULO DE TR&Aacute;MITE DOCUMENTARIO REPORTE DE DOCUMENTOS</title>
</head>
<body>
<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td colspan="2" align="left"> <?php Plantilla::PlantillaEncabezado("REGISTRO	DE DOCUMENTOS ");?> </td>		
	</tr>
	<tr>
		<td class="menu" ><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td class="wrapper">
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">
             
				<tr>								
					<td style="width:100%; height:417px">	

						<p class="main_links">
							<a href="Reportes/Estadisticos/tiempo_espera_usuario.php" 
								target="_blank" onClick="abre_ventana(this); return false;"
								>Reporte de Productividad por Usuario</a>
					<? #print_r($_SESSION);

						if( $_SESSION["session"][2] == "Admin. Area" || $_SESSION["session"][2] == "Admin. Total" ) {?>			|		 
							<a href="reportes.php?atencion=1" class="<?=(isset($get->atencion)? 'active':'')?>"
								>Reporte por area de atenci&oacute;n</a>		|		
							<a href="reportes.php?remitentes=1"  class="<?=(isset($get->remitentes)? 'active':'')?>"
								>Reporte por Remitentes</a>						
					<?}?>
				        </p>
                        
                        <?if( isset($get->atencion) || isset($get->remitentes) ){?>
                        <div id="panel">
                            <div id="loading" class="hidden ch">
                                <div class="overlay">
                                </div>
                                <div class="loading_msg">
                                    Cargando...
                                </div>
                            </div>
                            <form id="filters" action="" method="post" class="ch">
                                <p class="busqueda"> 
                                    <input name="doc" id="doc" class="ch" value="" type="text" size="50" />
                                    <input type="submit" value="Buscar por No. Registro" />
                                </p>
                                <p>
                                <?if( isset($get->remitentes) ){?>
                                    <label>Remitente</label>
                                    <select class="ch" name="rem" id="rem">
                                        <option value="">Todos...</option>
                                        <?foreach($remitentes as $remitente){?>
                                            <option value="<?=$remitente->abreviatura_remitente?>"
                                                <?=($get->remitente == $remitente->abreviatura_remitente)?"selected='selected'":'';?>
                                                ><?=$remitente_etiquetas[ $remitente->abreviatura_remitente ]?></option>
                                        <?}?>
                                    </select>
                                    <input name="remitentes" value="1" type="hidden" />
                                <?}else{?>
                                    <label>Ubicaci&oacute;n</label>
                                    <select class="ch" name="ubi" id="ubi">
                                        <option value="">Todos...</option>
                                        <?foreach($areas as $area){?>
                                            <option value="<?=$area->Abreviatura?>"
                                                <?=(isset($get->ubi) && $get->ubi == $area->Abreviatura)?"selected='selected'":'';?> param="<?=$area->id_area?>"
                                                ><?=$area->Nombre?></option>
                                        <?}?>
                                    </select>
                                    <span id="selectUsuario" class="hidden ch">
                                    <label>Usuario</label>
                                        <select name="usuarios" id="usuarios" class="ch">
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </span>
                                    
                                    <span id="selectCopias" class="hidden ch">
                                    <label>Ver</label>
                                        <select name="copias" id="copias" class="ch">
                                            <option value="">Originales</option>
                                            <option value="1">Copias</option>
                                        </select>
                                    </span>
                                    
                                    <input name="atencion" value="1" type="hidden" />
                                <?}?>
                                </p>
                                <p>
                                    <span id="despacho" class="ch">
                                        <input class="checkbox ch" id="nodespachado" type="checkbox" value="1" name="nodespachado" />
                                        <label for="nodespachado" >Por Despachar</label>
                                    </span>
                                    
                                    <span style="display:none;">
                                        <input class="checkbox ch" id="pendientes" type="checkbox" value="TP"
                                                <?=($pendientes?"checked='checked'":'')?>
                                            <?=( $vencidos?"disabled='disabled'":'')?>
                                            />
                                        <label for="pendientes" <?=( $vencidos ?"class='disabled'":'')?>>Pendientes (No archivados)</label>
                                    </span>
                                    <!--
                                    <span>
                                        <input  id="atendidos" type="checkbox" value="1"
                                            <?=( $atendidos?"checked='checked'":'')?>
                                            />
                                        <label for="atendidos">Atendidos (Archivados)</label>
                                    </span>
                                    -->
                                    <span>
                                        <input class="checkbox ch" name="vencidos" id="vencidos" type="checkbox" value="1" 
                                            
                                                <?=( $vencidos ?"checked='checked'":'')?>
                                            <?=( $pendientes?"disabled='disabled'":'')?>
                                            />
                                        <label for="vencidos" <?=( $pendientes ?"class='disabled'":'')?>>Vencidos</label>
                                    </span>
                                    <input type="hidden" value="<?=( (isset($get->pag) && is_numeric($get->pag) )? $get->pag :'')?>" name="pag" id="pag" />
                                    <input type="hidden" value="" name="est" id="est" class="ch" />
                                    <input type="hidden" value="1" name="todos" id="todos" class="ch" />
                                    <input type="hidden" value="" name="rem" id="rem_bk" class="ch" />
                                    <input type="hidden" value="" name="asu" id="asu" class="ch" />
                                    <input type="hidden" value="" name="reg" id="reg" class="ch" />
                                </p>
                            </form>
                            
                            <div id="list">
                             
                                                  
                                <div id="resultado" style="text-align:center">
                                    <table id="frmgrid" class="scroll" cellpadding="0" cellspacing="0" align="left"></table>
                                    <div id="pfrmgrid" class="scroll" style="text-align:center;"></div>	
                                </div>
                                <div id="dialog" title="Mensaje de error" style="display:none">
                                    <table width="100%" border="0" id="msg">
                                      <tr>
                                        <td width="10%" style="vertical-align:middle"><div align="center"><img src="public_root/imgs/warning_2_1.png" border="0" style="border:none"></div></td>
                                        <td style="vertical-align:middle; padding-left:10px;"><span id="msg_dialogo" style="padding:7px 0 7px 0;"></span></td>
                                      </tr>
                                    </table>	
                                </div>           
                             
                             
                            </div>
                        
                        </div>
                        <?}?>
                        
						
					</td>					
				</tr>			
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="2" class="pie"><?php Plantilla::PlantillaPie();?>	</td>
	</tr>	
</table>	
</body>
</html>
