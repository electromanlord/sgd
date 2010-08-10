<?php
	/**
	 * Edited by Enrique Juan de Dios 
	 * 12JUL2010
	 */
	include("includes.php");  
    
	require_once("cls/atencion.cls.php");
    require_once('cls/class.areas.php');
	
    if (!ini_get('display_errors')) {
        ini_set('display_errors', 1);
    }

    $areas = new Areas();
	$usuario = new Usuario($_SESSION['session'][0]);
	if(!$_SESSION['session'][3] == "SI" ){
	?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}
    
    $get = (object)$_GET;
    $filtro = 'atencion';
    $areas = $areas->lista();
	set_time_limit(100);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include("includes/inc.header.php"); ?>
		<script type="text/javascript" src="public_root/js/calendar/calendar.js"></script>
		<script>
			function abre_ventana(ref){
				screen_width = screen.width;
				str = 'width='+screen_width+',height=600,top=20,left=3,scrollbars=yes';
				window.open(ref.href, ref.target,str);
			}			
		</script>
        <title>Atenci&oacute;n de documentos</title>
    </head>
<body>

<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td colspan="2" align="left"> 
        <?php Plantilla::PlantillaEncabezado("REPORTE DE ATENCION DE DOCUMENTOS ");?> 
       </td>		
	</tr>
	<tr>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">	
            								
				<tr>								
					<td style="width:100%; height:417px">	
                    <div id="panel">
                        <form id="filters" action="" method="post">
                            <p>
                                <label>Area</label>
                                <select name="area" id="area">
                                    <option value="">Seleccionar...</option>
                                    <?foreach($areas as $area){?>
                                        <option value="<?=$area->id_area?>"
                                            <?=($get->area == $area->id_area)?"selected='selected'":'';?>
                                            ><?=$area->Nombre?></option>
                                    <?}?>
                                </select>
                            </p>
                            <p>
                                <span>
                                    <input name="pendientes" id="pendientes" type="checkbox" value="1"
                                    <?=($get->pendientes)?"checked='checked'":'';?>
                                        />
                                    <label for="pendientes">Pendientes (No estan archivados ni finalizados)</label>
                                </span>
                                <!--
                                -->
                                <span>
                                    <input name="atendidos" id="atendidos" type="checkbox" value="1"
                                        <?=($get->atendidos)?"checked='checked'":'';?>
                                        />
                                    <label for="atendidos">Atendidos (Archivados o finalizados)</label>
                                </span>
                                <span>
                                    <input name="vencidos" id="vencidos" type="checkbox" value="1" 
                                        <?=($get->vencidos)?"checked='checked'":'';?>
                                        />
                                    <label for="vencidos">Vencidos</label>
                                </span>  
                            </p>
                        </form>
                        <div id="list">
                            <?			
                                Atencion::listado( $filtro ,true);	
                            ?>
                        </div>
                        
                    </div>
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