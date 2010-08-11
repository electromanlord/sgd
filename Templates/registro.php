
<fieldset>
  <legend class="Estilo9">DATOS DEL DOCUMENTO</legend>
  <table width="98%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
    <tbody>
      <tr>
        <td width="223" class="Estilo22"><div align="left">N&ordm; Registro</div></td>
        <td width="10" class="Estilo22"><div align="center">:</div></td>
        <td width="98" bgcolor="#ffffff"><div align="left">
          <?=$row_resumen[1]?>
        </div></td>
        <td width="139" bordercolor="#D6D3CE" bgcolor="#ffffff">&nbsp;</td>
        <td width="113" bgcolor="#ffffff">&nbsp;</td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left"></div></td>
        <td class="Estilo22" bgcolor="#ffffff"><div align="left"></div></td>
        <td width="211" >&nbsp;</td>
      </tr>
      <tr>
        <td width="223"class="Estilo22"><div align="left">Remitente</div></td>
        <td width="10" bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
        <td colspan="3" bgcolor="#ffffff"><div align="left">
          <?=$row_resumen[2]?>
        </div></td>
        <td width="98" class="Estilo22"><div align="left"><span>Nro de Folios</span></div></td>
        <td width="11" class="Estilo22"><div align="center">:</div></td>
        <td><div align="left">
          <?=$row_resumen[numero_folio_documento]?>
        </div></td>
      </tr>
      <tr>
        <td width="223" bgcolor="#ffffff"><div align="right">
            <div align="left" class="Estilo22">Nro. Documento</div>
        </div></td>
        <td width="10" class="Estilo22" ><div align="center">:</div></td>
        <td colspan="3" bgcolor="#ffffff"><div align="left">
          <?=$row_resumen[numero_documento]?>
        </div></td>
        <td class="Estilo22"><div align="left">Fecha de Doc </div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td><div align="left"><?php echo date('d/m/Y',strtotime($row_resumen[fecha_documento]))?></div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Tipo de Documento</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="6"><div align="left">
          <?=$row_resumen[nombre_tipo_documento]?>
        </div>
        <div align="left"></div></td>
      </tr>
      <tr>
        <td  width="223" class="Estilo22"><div align="right">
            <div align="left">Referencia</div>
        </div></td>
        <td  width="10" class="Estilo22"><div align="center">:</div></td>
        <td colspan="6"><div align="left">
          <?=$row_resumen[referencia_documento]?>
        </div></td>
      </tr>
      <tr>
        <td  width="223" class="Estilo22"><div align="right">
            <div align="left">Anexos</div>
        </div></td>
        <td  width="10" class="Estilo22"><div align="center">:</div></td>
        <td colspan="6"><div align="left">
          <?=$row_resumen[anexo_documento]?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Documento Digitalizado </div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="6">
			  <div align="left"><span class="Estilo7">
                  <?foreach( $escaneos as $index => $escaneo ){?>
                        <a href="<?=(!$escaneo->fecha_escaneo? "Escaneo/".$escaneo->nombre_documento_escaneado :  "../sad/Escaneado_completo/".$row_resumen[1]."/".$escaneo->nombre_documento_escaneado )?>" 
                                id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank"><?=$index+1?></a>		
                  <?}?>
		      </span>
			  </div>
		</td>
      </tr>
      <tr>
        <td height="28" ><div align="right" class="Estilo22">
          <div align="left">Fecha y Hora de Registro</div>
        </div></td>
        <td height="28"  class="Estilo22"><div align="center">:</div></td>
        <td height="28" ><div align="left"><?php echo date('d/m/Y H:i',strtotime($row_resumen[fecha_registro_documento]))?></div></td>
        <td height="28" ><div align="left"></div></td>
        <td><div align="left"></div></td>
        <td colspan="2" bordercolor="#D6D3CE" bgcolor="#ffffff"><div align="left"></div></td>
		<td><div align="left"></div></td>
      </tr>
      <tr>

      <td height="28" bgcolor="#ffffff" class="Estilo22"><div align="left">Observaci&oacute;n de Registro</div></td>
      <td height="28" bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><div align="left">
        <textarea name="textarea2" id="textarea2" rows="3" cols="100" disabled="disabled" class="disabled"><?=$row_edit[1]?>
      </textarea>
      </div></td>
      </tr>
    </tbody>
</table>
</fieldset>

 <form name="form_despacho" id="form_despacho" method="post"  action="<?php echo $_SERVER['PHP_SELF']?>?opcion=des_guard&ids=<?=$_REQUEST['ids']?>" >  

  <fieldset>
  <legend >ESTABLECER ASUNTO Y PRIORIDAD</legend>
  <table width="98%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
    <tr>
      <td width="18" height="56" rowspan="2" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
      <td width="202" height="56" rowspan="2" bgcolor="#ffffff" class="Estilo22"><div align="left">Asunto:</div></td>
      <td width="12" rowspan="2" bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
      <td colspan="5" rowspan="2"><div align="left">
        <textarea name="textfield2" id="asunto" rows="3" style="width:536px;" class="caja"><?=$row_edit[0]?></textarea>
      </div></td>
      <td width="130">
	  	<div align="left" id="editar_guardar_asunto" style="display:none">			
		</div>
	  </td>
    </tr>
    <tr>
      <td><input type="hidden" id="asunto_anterior" value="<?=$row_edit[0]?>" /></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="Estilo21"><span class="Estilo26" style="vertical-align:middle">(*)</span></td>
      <td bgcolor="#ffffff" class="Estilo22"><div align="left">Prioridad</div></td>
      <td bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
      <td width="210" >
          <div align="left">
            <?################## Listar Prioridades #############################?>
            <select name="cboprioridad"  id="cboprioridad" onchange="cambia_saldo(this.value)" style="width:200px;">
              <option value="">--- Seleccione Prioridad ---</option>
              <? while($row_prioridad=$query_prioridad->ConsultaVerRegistro()){?>
              <option value="<?=$row_prioridad[0]?>"<? if($row_prioridad[0]==$cboprioridad){ /*echo "selected";*/ } ?>>
              <?=$row_prioridad[1]?>
              </option>
              <? } ?>
            </select>
            <input type="hidden" name="id_documento" id="id_documento" value="<?=$ids?>" />
      </div></td>
      <td width="215" class="Estilo22"><div align="left">Tiempo de Respuesta</div></td>
      <td width="5" class="Estilo22"><div align="center">:</div></td>
      <td width="24" align="left"><div align="left" id="capa_saldo" style="border:none"></div></td>
      <td width="80" align="left"><div align="left"><?php echo'- Dias.'?></div></td>
	  <td>&nbsp;</td>
    </tr>
    <tr>
        <?if ($row_resumen['categoria']){?>
            <td></td>
            <td  class="Estilo22"><div align="left">Clase</div></td>
            <td width="5" class="Estilo22"><div align="center">:</div></td>
            <td class="Estilo22" style="text-align:left"> <?= $remitente_etiquetas[ $documento->categoria ] ?></td>
      <?}else{?>
            <td colspan="4"></td>
      <?}?>
      <td class="Estilo22"><div align="left">Fecha Estimada de Respuesta</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td height="21" colspan="2" class="Estilo23"><div id="fecha_respuesta"></div></td>
	  <td>&nbsp;</td>
    </tr>
  </table>
  </fieldset>

  <fieldset>
  <legend>ESTABLECER DESTINO Y ACCION A REALIZAR</legend>
  <table width="99%" border="0" align="center">
    <tbody>
        <tr>
          <td class="Estilo21" style="vertical-align:middle">&nbsp;</td>
          <td style="vertical-align:middle">&nbsp;</td>
          <td style="vertical-align:middle">&nbsp;</td>
          <td style="vertical-align:middle">&nbsp;</td>
          <td width="39%" bgcolor="#ffffff" class="Estilo22" ><div align="left">Observaci&oacute;n de Despacho:</div>
  
          <div align="left"></div>
          <td align="center" class="Estilo21">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center" class="Estilo22">&nbsp;</td>
        </tr>
      <tr>
        <td width="3%" height="25" class="Estilo21" style="vertical-align:middle">(*)</td>
        <td width="6%" style="vertical-align:middle"><div align="left" class="Estilo22">Acc&iacute;on</div></td>
        <td width="2%" style="vertical-align:middle"><div align="center" class="Estilo22" >:</div></td>
        <td width="31%" style="vertical-align:middle"><div align="left" class="Estilo22" >
        <?################## Listar Acciones #############################?>
        	<select name="cboaccion" style="width:200px" id="accion_borrador">
              <option value="">--Seleccione Accion--</option>
              <?php                  

				for($u = 0; $u < $tacciones; $u++){ ?>
              <option value="<?php echo $accions[$u]['id']?>">
                <?php echo $accions[$u]['nombre']?>
              </option>
              <?php
			}?>
            </select>
        </div></td>
        <td width="39%" rowspan="3" bgcolor="#ffffff" class="Estilo22" ><div align="left">
          <textarea name="textfield4" id="textfield4" rows="4" cols="50" class="caja"></textarea>
        </div>
        <td height="25" align="center" class="Estilo21"><div align="center"><span >(*)</span></div></td>
        <td width="3%" align="center"><div align="center"><span class="Estilo22" style="vertical-align:middle">
            <input name="radiobutton" value="1" type="radio" id="original">
        </span></div></td>
        <td width="13%" align="center" class="Estilo22"><div align="left">Original</div></td>
      </tr>
	  <tr>
	    <td class="Estilo21" style="vertical-align:middle">(*)</td>
	    <td bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">
			<div align="left">Pase A</div>			
		</td>
	    <td class="Estilo22" style="vertical-align:middle"><div align="center">:</div></td>
	    <td class="Estilo22" style="vertical-align:middle">
			<div align="left">
			<select name="cboareas"  id="cboareas" style="width:200px;">
	        <option value="">--- Seleccione Destino---</option>
	        <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
	        <option value="<? echo $row_areas[0]?>"><? echo $row_areas[1]?></option>
	        <? } ?>
	        </select>
        </div>		</td>
	    <td width="3%" height="24" align="center" class="Estilo21">&nbsp;</td>
        <td height="24" align="center"><div align="center"><span class="Estilo22" style="vertical-align:middle">
            <input name="radiobutton" value="2" type="radio" id="copia">
        </span></div></td>
        <td height="24" align="center" class="Estilo22"><div align="left">Copia</div></td>
	  </tr>
	  <tr>
	    <td class="Estilo21">&nbsp;</td>
	    <td colspan="2" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
	    <td bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
	    <td height="21" align="center">&nbsp;</td>
        <td height="21" colspan="2" align="center"><div align="center">

            <div align="left">
              <input type="submit" name="Cargar Lista2" value="Cargar Lista" class="boton"/>
              </div>
        </div></td>
      </tr>
	  <tr>
	   <td width="3%" class="Estilo21">&nbsp;</td> 
         <td colspan="2" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
        <td width="31%" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
         <td width="39%" bgcolor="#ffffff" class="Estilo22" >
        <td height="21" colspan="3" align="center">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  </fieldset>
</form>

<script>
    javascript:deshabilita_copia(); 
</script>