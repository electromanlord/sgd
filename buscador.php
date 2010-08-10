	<form id="form_busqueda_simple" name="form_busqueda_simple" method="post" action="" style="background-color: #eee;">
		<?php
			$anp = new Anp($_SESSION['session'][7]);
			$n_anp = $anp->getSiglas();
		?>		
		<div style="border-bottom:#5C96BB solid 1px;">
		<table width="97%" border="0" align="center" cellpadding="1" cellspacing="1" style="margin-top:5px;">			
			<tr>
			  <td width="14%" height="31" class="Estilo22"><div align="left">N&ordm; de Registro</div></td>
			  <td class="Estilo22" width="2%"><div align="center">:</div></td>
				<td width="20%">
					<div align="left">
					  <input type="text" name="anp" size="6" id="anp" value="<?=$n_anp?>"/> - 
					  <input name="registro" type="text" size="5" maxlength="6" id="registro" class="caja"/> 
						-
<!-- 	  <input name="anio" type="text" value="<?=date('Y')?>" size="2" maxlength="5" id="anio" />	
					  -->
					   <select name="anio" id="anio">
					  <option value="<?=date('Y')?>"><?=date('Y')?></option>
					  <option value="<?=(date('Y')-1)?>"><?=(date('Y')-1)?></option>
					  </select>					 

				
				  </div>
			  </td>
				<td width="10%">
					<div align="right">
						<input name="consulta_simple" type="button" class="boton" id="consulta_simple" value="Consultar" />
					</div>
			  </td>
				<td class="Estilo21" width="3%">&nbsp;</td>
			  <td class="Estilo21">
					<div align="left">
						<a href="javascript:ver_busqueda_avanzada();"><strong>Desplegar B&uacute;squeda Avanzada </strong>
						</a>				
					</div>
			  </td>
		    </tr>
		</table>
		</div>
		</form>
		
		<div id="busqueda_avanzada" style="display:none;">
		<form name="form_busqueda_avanzada" id="form_busqueda_avanzada" action="" method="post">
			<table width="97%" border="0" align="center" cellpadding="1" cellspacing="1" class="formularios">				
				<tr>
				  <td class="Estilo22">&nbsp;</td>
				  <td class="Estilo22">&nbsp;</td>
				  <td bgcolor="#FFFFFF">&nbsp;</td>
				  <td bgcolor="#FFFFFF">&nbsp;</td>
				  <td bgcolor="#FFFFFF" class="Estilo22">&nbsp;</td>
				  <td bgcolor="#FFFFFF" class="Estilo22">&nbsp;</td>
				  <td bgcolor="#FFFFFF">&nbsp;</td>
				  <td bgcolor="#FFFFFF" class="Estilo22">&nbsp;</td>
				  <td bgcolor="#FFFFFF">&nbsp;</td>
				  <td bgcolor="#FFFFFF">&nbsp;</td>
			  </tr>
				<tr>
				  <td class="Estilo22" width="14%"><div align="left">Documento</div></td>
					<td class="Estilo22" width="2%"><div align="center">:</div></td>
					<td bgcolor="#FFFFFF" width="30%">
					  <div align="left">
							<input name="documento" type="text" id="documento" value="" size="44" class="caja"/>
					  </div>					</td>
					<td bgcolor="#FFFFFF" width="3%">&nbsp;</td>
					<td bgcolor="#FFFFFF" class="Estilo22" width="14%"><div align="left">Fecha de registro </div></td>
					<td bgcolor="#FFFFFF" class="Estilo22" width="2%"><div align="center">:</div></td>
					<td bgcolor="#FFFFFF">
						<div align="left">
							<input name="date_registrar1" type="text" id="datepicker1" autocomplete="off" style="width:92px;" class="caja"/>
						</div>					</td>
				  <td bgcolor="#FFFFFF" class="Estilo22"><div align="left">hasta</div></td>
					<td bgcolor="#FFFFFF">
						<div align="left">
						    <input name="date_registrar2" type="text" id="datepicker2" size="14" autocomplete="off" style="width:92px;" class="caja"/>
				      </div></td>
			        <td bgcolor="#FFFFFF">&nbsp;</td>
			  </tr>
				<tr>
				  <td class="Estilo22"><div align="left">Remitente</div></td>
					<td class="Estilo22"><div align="center">:</div></td>
					<td bgcolor="#FFFFFF">
						<div align="left">
							<input name="remitente" type="text" id="text_remitente" value="" size="44" class="caja"/>
							<input name="remit" type="hidden" id="id_remitente" value="">					
					  </div>					</td>
					<td bgcolor="#FFFFFF">&nbsp;</td>
					<td bgcolor="#FFFFFF"><div align="left" class="Estilo22">Asunto</div></td>
					<td bgcolor="#FFFFFF" class="Estilo22"><div align="center">:</div></td>
					<td colspan="3" bgcolor="#FFFFFF" width="30%">
					  <div align="left">
							<input name="asunto" type="text" id="asunto" value="" style="width:230px;" class="caja"/>
					  </div>					</td>
				    <td bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td class="Estilo22"><div align="left" class="Estilo22">Estado</div></td>
					<td class="Estilo22"><div align="center">:</div></td>
					<td bgcolor="#FFFFFF">
					  <div align="left">
						<?php
							$sql_estado="SELECT *
                            	         FROM `estados` AS `e`
										 WHERE e.display = 1
      									 ORDER BY
        								 `e`.`nombre_estado` ASC";
                            $q_estado=new Consulta($sql_estado);
						?>
						<select id="select_estado" name="estado" style="width:240px" class="caja">
						  <option value="">--Seleccione un Estado--</option>
							<?
								while($row_estado=$q_estado->ConsultaVerRegistro()){
								   $ide=$row_estado[0];
							?>
							<option value="<?=$row_estado[2]?>"><?=$row_estado[1]?></option>
						  <?  }?>
						</select>
               		  </div>				  	</td>
				    <td bgcolor="#FFFFFF" class="Estilo21">
						<div align="center" style="font-weight:bolder"><a href="javascript:verDetalleEstado()" title="Ver m&aacute;s Opciones"><img src="public_root/imgs/edit_add.png" border="0"></a></div>
					</td>
				    <td bgcolor="#FFFFFF" class="Estilo22"><div align="left" class="Estilo22">Ubicaci&oacute;n</div></td>
				    <td bgcolor="#FFFFFF" class="Estilo22"><div align="center">:</div></td>
			        <td colspan="3" bgcolor="#FFFFFF">
					  <div align="left">
							<input name="ubicacion" type="text" id="ubicacion" value=""  style="width:230px;" class="caja"/>
					  </div>
					</td>					
				    <td bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
		</table>
		<div id="detalleEstado" style="display:none">
		<table width="97%" border="0" align="center" cellpadding="1" cellspacing="1">
			<tr>
				<td width="14%"><div align="left" class="Estilo22">Fecha de cambio </div></td>
				<td width="2%"><div align="center" class="Estilo22">:</div></td>
				<td width="12%">
					<div align="left">
						<input name="date_cambio1" type="text" disabled="disabled" id="date_cambio1" size="13" class="disabled"/>
					</div>				</td>
				<td width="4%"><div align="left" class="Estilo22">hasta</div></td>
				<td width="2%"><div align="left"></div></td>
				<td width="12%">
					<div align="left">
						<input name="date_cambio2" type="text" disabled="disabled" id="date_cambio2" size="13" class="disabled"/>
					</div>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><div align="left" class="Estilo22">Origen</div></td>
				<td><div align="center" class="Estilo22">:</div></td>
				<td>
					<div align="left">
					<input name="origen" type="text" disabled="disabled" id="origen" size="13" class="disabled"/>
					</div>
				</td>
				<td><div align="left" class="Estilo22">Destino</div></td>
				<td width="2%"><div align="center" class="Estilo22">:</div></td>
				<td>
					<div align="left">
					<input name="destino" type="text" disabled="disabled" id="destino" size="13" class="disabled"/>
					</div>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</div>
			<table width="98%" border="0" align="center">
				<tr>
					<td width="14%" height="48">&nbsp;</td>
					<td width="70%" style="vertical-align:middle">
						<div align="right">						
						<input name="consulta_avanzada" type="button" class="boton" id="consulta_avanzada" value="Consultar" />
						</div>				  </td>
					<td width="12%" style="vertical-align:middle">
						<div align="right">
							<input name="cancelar" type="reset" class="boton" id="cancelar" value="Cancelar"/>
						</div>				  </td>
					<td width="4%">&nbsp;</td>
				</tr>
		  </table>        
	</form>
</div>
<div align="right">
	<a href='javascript:exportar_datos(1)'>
		<img src="public_root/imgs/icon-pdf.gif" alt="pdf" width="18" height="20" border="0"/>
	</a>
	<a href='javascript:exportar_datos(2)'>
		<img src="public_root/imgs/icon-xls.gif" alt="Excel" width="20" height="20" title="Exportar Excel" border="0"/>
	</a>
</div>
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

