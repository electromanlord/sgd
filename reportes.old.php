<?php
	/**
	 * Edited by Enrique Juan de Dios 
	 * 12JUL2010
	 */
	include("includes.php");
	include("includes.php");  
    
	require_once("cls/atencion.cls.php");
    require_once('cls/class.areas.php');
    require_once('cls/class.remitentes.php');
	
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include("includes/inc.header.php"); ?>
		<style type="text/css">
			@import url(public_root/js/calendar/calendar-blue2.css);
		</style>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
		<script type="text/javascript" src="public_root/js/calendar/calendar.js"></script>
		<script type="text/javascript" src="public_root/js/calendar/calendar-es.js"></script>
		<script type="text/javascript" src="public_root/js/calendar/calendar-setup.js"></script>
		<script type="text/javascript" src="public_root/js/jquery.autocomplete.js"></script>
		<link href="public_root/css/jquery.autocomplete.css" rel="stylesheet">
		<script>
			function abre_ventana(ref){
				screen_width = screen.width;
				str = 'width='+screen_width+',height=600,top=20,left=3,scrollbars=yes';
				window.open(ref.href, ref.target,str);
			}			
		</script>
        <title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO</title>
    </head>
<body>

<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td colspan="2" align="left"> <?php Plantilla::PlantillaEncabezado("REGISTRO	DE DOCUMENTOS ");?> </td>		
	</tr>
	<tr>
		<td class="menu" ><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">									
				<tr>								
					<td style="width:100%; height:417px">	
						<p class="main_links">
							<a href="Reportes/Estadisticos/tiempo_espera_usuario.php" 
								target="_blank" onClick="abre_ventana(this); return false;"
								>Reporte de Productividad por Usuario</a>			|		 
							<a href="Reportes/Estadisticos/movimientos_por_usuario.php" 
								target="_blank" onClick="abre_ventana(this); return false;"
								>Reporte por Area</a>				|		
							<a href="reportes.php?atencion=1" class="<?=(isset($get->atencion)? 'active':'')?>"
								>Reporte por area de atenci&oacute;n</a>		|		
							<a href="reportes.php?remitentes=1"  class="<?=(isset($get->remitentes)? 'active':'')?>"
								>Reporte por Remitentes</a>						
				        </p>
                        
                        <?if( isset($get->atencion) || isset($get->remitentes) ){?>
                        <div id="panel">
                            <div id="loading" class="hidden">
                                <div class="overlay">
                                </div>
                                <div class="loading_msg">
                                    Cargando...
                                </div>
                            </div>
                            <form id="filters" action="" method="post">
                                <p>
                                <?if( isset($get->remitentes) ){?>
                                    <label>Remitente</label>
                                    <select name="remitente" id="remitente">
                                        <option value="">Seleccionar...</option>
                                        <?foreach($remitentes as $remitente){?>
                                            <option value="<?=$remitente->abreviatura_remitente?>"
                                                <?=($get->remitente == $remitente->abreviatura_remitente)?"selected='selected'":'';?>
                                                ><?=$remitente_etiquetas[ $remitente->abreviatura_remitente ]?></option>
                                        <?}?>
                                    </select>
                                    <input name="remitentes" value="1" type="hidden" />
                                <?}else{?>
                                    <label>Area</label>
                                    <select name="area" id="area">
                                        <option value="">Seleccionar...</option>
                                        <?foreach($areas as $area){?>
                                            <option value="<?=$area->id_area?>"
                                                <?=(isset($get->area) && $get->area == $area->id_area)?"selected='selected'":'';?>
                                                ><?=$area->Nombre?></option>
                                        <?}?>
                                    </select>
                                    <input name="atencion" value="1" type="hidden" />
                                <?}?>
                                </p>
                                <p>
                                    <span>
                                        <input name="pendientes" id="pendientes" type="checkbox" value="1"
                                                <?=($pendientes?"checked='checked'":'')?>
                                            <?=( $vencidos?"disabled='disabled'":'')?>
                                            />
                                        <label for="pendientes" <?=( $vencidos ?"class='disabled'":'')?>>Pendientes (No archivados)</label>
                                    </span>
                                    <!--
                                    -->
                                    <span>
                                        <input name="atendidos" id="atendidos" type="checkbox" value="1"
                                            <?=( $atendidos?"checked='checked'":'')?>
                                            />
                                        <label for="atendidos">Atendidos (Archivados)</label>
                                    </span>
                                    <span>
                                        <input name="vencidos" id="vencidos" type="checkbox" value="1" 
                                            
                                                <?=( $vencidos ?"checked='checked'":'')?>
                                            <?=( $pendientes?"disabled='disabled'":'')?>
                                            />
                                        <label for="vencidos" <?=( $pendientes ?"class='disabled'":'')?>>Vencidos</label>
                                    </span>
                                    <input type="hidden" value="<?=( (isset($get->pag) && is_numeric($get->pag) )? $get->pag :'')?>" name="pag" id="pag" />
                                </p>
                            </form>
                            
                            <div id="list">
                                <?			
                                    Atencion::listado( $filtro ,true);	
                                ?>
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