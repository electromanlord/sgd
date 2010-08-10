<?
require_once("../../includes.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
?>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script>
<script language="javascript" src="../js/reporte.js"></script> 

<form name='f1' action='reportes_general.php' method='POST'>
<table width=100% border=0 height=100% bgcolor=white class=table>

	<tr BGCOLOR=Lavender height=30>
	  <td style='font-size:12px;'><B>M&Oacute;DULO DE REPORTES / 
	    INFORMACI&Oacute;N  SINANPE - POA
        <?=axo($_SESSION[inrena_4][2])?>
      </B></td>	
	</tr>

	<tr>
		<td ALIGN=CENTER valign=middle colspan=2 style='color:red;'>
			<br><br><B><span style='font-size:12px;'>LISTADO DE REPORTES A MOSTRAR </span><BR><BR>
				<?
				$get="";
				if($anpid && $anpnom && $anpcate){ 
					$get=$anpid;
					//echo "si paso...!";
					?>
					<table> 
						<tr>
							<td align="center"><h5><?=$anpcate.' - '.$anpnom?></h5></td>
						</tr>
					</table>
				
				<?  } 
				//if($lectura=='S'){
				?>
				<table width="300">
						<th>No.</th>
						<th>T&iacute;tulo</th>
					
						
						<tr bgcolor=whitesmoke>
								<td align='center'>1</td>
								<td><A title="Mostrar Reporte" onclick="reporte_sinampe('1')" href="#">Asignaciones ANP   por subactividades</A><a href=# onclick=ver_reporte_x_filtro_infanp('1','<?=$get?>') title='Mostrar Reporte' ></a></td>
						</tr>
						<tr bgcolor=whitesmoke>
							<td align='center'>2</td>
							<td><A title="Mostrar Reporte" onclick="reporte_sinampe('2')" href="#">Asignaciones   Fuentes por subactividades</A><a href=# onclick=ver_reporte_x_filtro_infanp('2','<?=$get?>') title='Mostrar Reporte'></a></td>
						</tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>3</td>
											<td><A title="Mostrar Reporte" onclick="reporte_sinampe('3')" href="#">Asignaciones de   Fuentes por partidas</A><a href=# onclick=ver_reporte_x_filtro_infanp('3','<?=$get?>') title='Mostrar Reporte' ></a></td></tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>4</td>
											<td><A title="Mostrar Reporte" onclick="reporte_sinampe('4')" href="#">Presupuesto por   Partida Mensual</A><a href=# onclick=ver_reporte_x_filtro_infanp('4','<?=$get?>') title='Mostrar Reporte' ></a></td></tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>5</td>
											<td><A title="Mostrar Reporte" onclick="reporte_sinampe('5')" href="#">ANP por Fuente   de Financiamiento</A><a href=# onclick=ver_reporte_x_filtro_infanp('5','<?=$get?>') title='Mostrar Reporte' ></a></td></tr>				
											<tr bgcolor=whitesmoke>
							  <td align='center'>6</td>
											<td><A title="Mostrar Reporte" onclick="reporte_sinampe('6')" href="#">Asignaciones Tareas por ANP </A></td>
											</tr>	
							<tr bgcolor=whitesmoke>
							  	<td align='center'>7</td>
								<td><A title="Mostrar Reporte" onclick="reporte_sinampe('7')" href="#">Metas Tareas por ANP </A></td>
							</tr>
							
							<tr bgcolor=whitesmoke>
							  	<td align='center'>8</td>
								<td><a title="Mostrar Reporte" onclick="reporte_sinampe('8')" href="#">Formato Nº 3 - Articulacion de objetivos e indicadores </a></td>
							</tr>	
							<tr bgcolor=whitesmoke>
							  	<td align='center'>9</td>
								<td><a title="Mostrar Reporte" onclick="reporte_sinampe('9')" href="#">Formato Nº 4 - Programacion al Nivel de Indicador</a></td>
							</tr>	
							<tr bgcolor=whitesmoke>
							  	<td align='center'>10</td>
								<td><a title="Mostrar Reporte" onclick="reporte_sinampe('10')" href="#">Formato Nº 5 - Programacion del Plan Operativo Institucional </a></td>
							</tr>																			
					</table>	
					
						<?
						
						//}else{
							//echo '<table><tr><td>	<br>Usted no tiene permiso de lectura para esta sección.<tr><td></table>';
						//} 
						?>	  </td>
	</tr>
</table>
</form>

