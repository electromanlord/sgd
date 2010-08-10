<?
require_once("../../includes.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
?>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script>
<script language="javascript" src="../js/reporte.js"></script> 

<form name=f1 action='reportes_general.php' method='POST'>
<table width=100% border=0 height=100% bgcolor=white class=table>

	<tr BGCOLOR=Lavender height=30>
	  <td style='font-size:12px;'><B>M&Oacute;DULO DE REPORTES / INFORMACI&Oacute;N ANP - POA  <?=axo($_SESSION[inrena_4][2])?></B>	    <? //<a href=#  onclick=menu('2')>Listar &nbsp;<img src='../../imgs/b_browse.png' border=0></a> ?></td>
	</tr>

	<tr>
		<td ALIGN=CENTER valign=middle style='color:red;'>
			<br><br><B><span style='font-size:12px;'>LISTADO DE REPORTES A MOSTRAR </span><BR><BR>
				<?
				$get="";
				if($anpid && $anpnom && $anpcate){ 
					$get=$anpid;
					///$_SESSION['anp']['idanp']=$anpid;
					//echo "si paso...!";
					?>
					<table> 
						<tr>
							<td align="center"><h5><?=$anpcate.' - '.$anpnom?></h5></td>
						</tr>
					</table>
				
				
					<table>
						<th>No.</th>
						<th>T&iacute;tulo</th>
					
						<tr bgcolor=whitesmoke>
						  <td align='center'>*</td>
						  <td><a href="#" onclick=reporte_poa('1','<?=$get?>') >Caratula POA </a></td>
					  </tr>
						<tr bgcolor=whitesmoke>
						  <td align='center'>&nbsp;</td>
						  <td></td>
					  </tr>
						<tr bgcolor=whitesmoke>
						  <td align='center'>1</td>
						  <td><a href="#" onclick=reporte_poa('2','<?=$get?>') >Informaci&oacute;n General del POA</a></td>
					  </tr>
					  <tr bgcolor=whitesmoke>
						  <td align='center'>2</td>
						  <!------<td><a href="#" onclick="reporte_objetivos_estrategicos('9','=/*$get*/?>')" >---->
                          <td><a href=# onclick=reporte_objetivos_estrategicos('9','<?=$get?>')>Objetivos Estrat&eacute;gicos </a></td>
					  </tr>
					<!----<tr bgcolor=whitesmoke>
						  <td align='center'>3</td>
						  <td><a href="#" onclick=reporte_poa('3','<=$get?>') >Desarrollo Estrat&eacute;gico </a></td>
					  </tr>---->
						<tr bgcolor=whitesmoke>
								<td align='center'>3</td>
								<td><a href=# onclick=ver_reporte_x_filtro_infanp('1','<?=$get?>') title='Mostrar Reporte' >Fuente de Financiamiento</a></td>
						</tr>
						<tr bgcolor=whitesmoke>
							<td align='center'>4</td>
							<td><a href=# onclick=ver_reporte_x_filtro_infanp('2','<?=$get?>') title='Mostrar Reporte'>Personal</a></td>
						</tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>5</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('3','<?=$get?>') title='Mostrar Reporte' >Fichas de Tarea </a></td>
						</tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>6</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('4','<?=$get?>') title='Mostrar Reporte' >Fisico Financiero</a></td></tr>
				 		<tr bgcolor=whitesmoke>
							 <!-----<td align='center'>8</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('5','<=$get?>') title='MostrarReporte' >Presupuesto Mensual</a></td></tr>---->
						<tr bgcolor=whitesmoke>
							  <td align='center'>7</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('6','<?=$get?>') title='Mostrar Reporte' >Presupuesto Trimestral</a></td></tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>8</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('7','<?=$get?>') title='Mostrar Reporte' >Partidas por Tareas</a></td>
						</tr>
					 	<!----<tr bgcolor=whitesmoke>
							 <td align='center'>11</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('10','<=$get?>') title='Mostrar Reporte' >Partidas Mensualizado por Tareas</a></td>	</tr>--->
						<tr bgcolor=whitesmoke>
							  <td align='center'>9</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('8','<?=$get?>') title='Mostrar Reporte' >Partidas Mensualizado</a></td></tr>
						<tr bgcolor=whitesmoke>
							  <td align='center'>10</td>
											<td><a href=# onclick=ver_reporte_x_filtro_infanp('12','<?=$get?>') title='Mostrar Reporte' >Plan Operativo Institucional (Formato 8)</a></td></tr>					
						<!---<tr bgcolor=whitesmoke>
							<td align='center'>11</td>
							<td><a href=# onclick=ver_reporte_x_filtro_infanp('9','<=$get?>') title='Mostrar Reporte' >Objetivos Estratégicos</a></td>
						</tr>	--->																		
					</table>	
<?  } 
				//if($lectura=='S'){
				?>


		</td>
	</tr>
</table>
</form>
