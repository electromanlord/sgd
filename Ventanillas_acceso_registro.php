<?php
    include("includes.php");
	require_once("libs/lib.php");
	require_once("cls/ventanillas_acceso_registro.cls.php");
	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}    
    if (!ini_get('display_errors')) {
        #ini_set('display_errors', 1);
    }
    

	$table="registro";
	set_time_limit(100);

    $menu = array(1,1,0,0,1,0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include("includes/inc.header.php"); ?>
		<style type="text/css">
			@import url(public_root/js/calendar/calendar-blue2.css);
		</style>
		<script type="text/javascript" src="public_root/js/calendar/calendar.js"></script>
		<script type="text/javascript" src="public_root/js/calendar/calendar-es.js"></script>
		<script type="text/javascript" src="public_root/js/calendar/calendar-setup.js"></script>
		<script type="text/javascript" src="public_root/js/jquery.autocomplete.js"></script>
		<script type="text/javascript" src="public_root/js/leyendas/cargar_estados.js"></script>
		<link href="public_root/css/jquery.autocomplete.css" rel="stylesheet" />
        <title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ REGISTRO	DE	DOCUMENTOS </title>
    </head>
<body>

<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td colspan="2" align="left"> <?php Plantilla::PlantillaEncabezado("REGISTRO	DE DOCUMENTOS ");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">	
            	<tr>
					<td><?php  Plantilla::menuSuperior("Ventanillas_acceso_registro.php",$menu,$_GET['id'],false);?></td>
				</tr>									
				<tr>								
					<td style="width:100%; height:417px">								
					<?php
                        	$opcion = $_REQUEST['opcion'];
				$id = $_REQUEST['id'];
				$ide = $_REQUEST['ide'];
				$campo = $_REQUEST['campo'];
				$valor = $_REQUEST['valor'];
				switch($opcion){
							
                            case 'new':
                                Registro::RegistraAgregar();
                            break;

                            case 'edit':
                                Registro::RegistraEditar($id);
                            break;

                            case 'update':
                                Registro::RegistraUpdate($id);
                                Registro::RegistraListado($ide);
                            break;

                            case 'delete':
                                Registro::RegistraDelete($id);
                            break;

                            case 'list':
                                Registro::RegistraListado($ide);
                            break;

                            case 'x';
                                Registro::RegistraListado($ide);

                            break;

                            case 'guardar';
                                Registro::RegistraGuardar();
                                Registro::RegistraListado($ide);
                            break;

                            case 'agre';
                                Registro::RegistraAgrega();
                            break;

                            case 'listremi';
                                Registro::RegistraListRemitente();
                            break;

                            case 'newremi';
                                Registro::RegistraNewRemitente();
                            break;

                            case 'editremi';
                                Registro::RegistraEditRemitente($id);                                
                            break;

                            case 'Updateremi';
                                Registro::RegistraUpdateRemitente($id);
                                Registro::RegistraListRemitente();
                            break;

                            case 'guardremi';
                                Registro::RegistraGuardarRemitente();
                                Registro::RegistraAgregar();
                            break;

                            case 'filtrar';
                                Registro::RegistraFiltrar();
                            break;

                            case 'busqueda';
                                Registro::Busqueda($campo, $valor);
                            break;

                            default:
                                Registro::RegistraListado($ide);
                            break;

                            }

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
</body>
</html>