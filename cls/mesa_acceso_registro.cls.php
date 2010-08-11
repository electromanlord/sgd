<?

class Registro {

function Busqueda($campo, $valor){	

	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND r.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
	}

	$sql_reg = "SELECT *
				FROM
				documentos AS d
				Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
				Inner Join estados AS e ON e.id_estado = d.id_estado
				".$where."
				ORDER BY d.id_documento DESC";
			
	$query_reg=new Consulta($sql_reg);		
	?>
<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
	  <td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">
					<th width="16%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="27%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th width="28%" class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="13%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th class="ui-widget-header ui-th-column grid_resize">Ubicacion</th>
				</tr>			
			</table>
		    </td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">		
			<?	
			while($row_reg=$query_reg->ConsultaVerRegistro()){
				$ids=$row_reg[0];
				$estado = $row_reg["id_estado"];
				$tooltip_asunto = "";
				if(!empty($row_reg['asunto_documento']))
					$tooltip_asunto="title ='".$row_reg['asunto_documento']."' class='tip'";
			?>
	
    <tr class="ui-widget-content1 jqgrow <? echo ($estado==12)?"Estilo7 fila_finalizada":"Estilo7";?>">
      <td width="16%" <?=$tooltip_asunto?>>
			<div align="center">
      		<?php
				$cod = $row_reg["codigo_documento"];
           
				if($estado != 12&&$estado != 11){ ?>
				<a href="mesa_acceso_registro.php?opcion=despachar&ids=<?=$ids?>">
                <?=$cod?></a>				
              <? }
				else{
					echo $cod;
           		}
				?>
          </div>	  </td>
		<td width="27%"><input size="48" value="<?=$row_reg[nombre_remitente]?>"/></td>
		<td width="28%"><input size="43" value="<?=$row_reg[numero_documento]?>"/></td>
		<td width="13%">
			<div align="center">
			  <input name="text2" type="text" style="text-align:center;width:100%;" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?>"/>
			</div>		</td>
		<td align="center" width="6%">
		<div align="center">
		  <input name="text3" type="text" style="text-align:center; width:100%" value="<?=$row_reg['abrev_nombre_estado']?>"/>
		</div>		</td>

		<?php
			$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
						FROM
						`historial_documentos` AS `hd`
						where hd.id_documento='".$row_reg['id_documento']."'
						GROUP BY
						`hd`.`id_historial_documento`";
						
			$query_ultimo=new Consulta($sql_ultimo);		
			$ultimo=$query_ultimo->ConsultaVerRegistro();

			$sql_data = "SELECT hd.id_documento,
						a.nombre_area, 
						a.abve_nombre_area 
						FROM 
						historial_documentos AS hd 
						Inner Join areas AS a ON a.id_area = hd.id_area 
						where hd.id_historial_documento='".$ultimo['ultimo']."'";
						
			$query_data=new Consulta($sql_data);		
			$data=$query_data->ConsultaVerRegistro();
		
			$sql_usu = "SELECT 
						Max(`ha`.`id_historial_atencion`) AS `ultimo`, 
						`ha`.`id_documento` 
						FROM
						`historial_atencion` AS `ha`
						WHERE
						ha.original_historial_atencion =  '1' and 
						ha.id_documento='".$row_reg['id_documento']."' 
						GROUP BY 
						`ha`.`id_historial_atencion`";
						
			$query_usu=new Consulta($sql_usu);		
			$usu=$query_usu->ConsultaVerRegistro();

			$susu = "SELECT `u`.`login_usuario`, 
					`a`.`abve_nombre_area` 
					FROM 
					`historial_atencion` AS `ha`
					Inner Join `usuarios` AS `u` 
					ON `u`.`id_usuario` = `ha`.`id_usuario_destino` 
					Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
					WHERE
					`ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";

			$qusu=new Consulta($susu);		
			$u=$qusu->ConsultaVerRegistro();
	?>
		<td>
		  <div align="center">
		    <?
            	$documento = new Documento($row_reg['id_documento']);
        	?>
            <input name="text4" type="text" value="<?=$documento->UltimaUbicacionReporte()?>" />
		  </div>
		</td>
	</tr>
	<? }?>
	</table>
	</td>
	</tr>
</table>
</div>
<? }

function RegistraListado($ide){	 
	
	if ($ide==''){
	
		$sql_reg = "SELECT
					d.id_documento,
					d.codigo_documento,
					r.nombre_remitente,
					d.numero_documento,
					e.nombre_estado,
					e.abrev_nombre_estado,
					d.fecha_registro_documento,
					d.id_estado,
					d.asunto_documento
					FROM
					documentos AS d
					LEFT Join remitentes AS r ON r.id_remitente = d.id_remitente
					LEFT Join estados AS e ON e.id_estado = d.id_estado
					LEFT Join usuarios u ON d.id_usuario = u.id_usuario
					WHERE
					(d.id_estado =  1 OR
					d.id_estado =  5)
					AND u.id_anp = ".$_SESSION['session'][7]."
					ORDER BY
					d.id_documento DESC";
	
		$query_reg=new Consulta($sql_reg);			
		
	}
	else { 
		
		$where = ($ide=="LT")?"":"d.id_estado =$ide AND";
		
		$sql_reg = "SELECT
					d.id_documento,	
					d.codigo_documento,
					r.nombre_remitente,
					d.numero_documento,
					e.nombre_estado,
					e.abrev_nombre_estado,
					d.fecha_registro_documento,
					d.id_estado,
					d.asunto_documento
					FROM
					documentos AS d
					LEFT Join remitentes AS r ON r.id_remitente = d.id_remitente
					LEFT Join usuarios u ON d.id_usuario = u.id_usuario
					Inner Join estados AS e ON e.id_estado = d.id_estado 
					WHERE
					$where
					u.id_anp = ".$_SESSION['session'][7]."
					ORDER BY
					d.id_documento DESC";
		
		$query_reg=new Consulta($sql_reg);		
		
		}
	?>
	
<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
	  <td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">
					<th width="16%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="27%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th width="28%" class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="13%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th class="ui-widget-header ui-th-column grid_resize">Ubicacion</th>
				</tr>			
			</table>
		    </td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">		
		<? 
		while($row_reg=$query_reg->ConsultaVerRegistro()){
			$ids=$row_reg['id_documento'];
			$_POST[remi]=$row_reg['nombre_remitente'];
			$estado = $row_reg['id_estado'];
            $descripcion_dev="";
			$clase = "Estilo7";
						
			if($estado==12){
				$clase = "Estilo7 fila_finalizada";
			}else{
				$dias = resta_fechas(date("d/m/Y"),date('d/m/Y',strtotime($row_reg['fecha_registro_documento'])));
				if($dias > 0)
					$clase = "Estilo7 fila_peligro";
				else	
					$clase = "Estilo7 fila_baja";
			}

            if($estado==5){
                $sql_dev = "SELECT
                            v.descripcion,
                            v.id_devuelto
                            FROM
                            devuelto AS v
                            Inner Join documentos AS d ON v.id_documento = d.id_documento
                            WHERE
                            d.id_documento =  '$ids'
                            ORDER BY
                            v.id_devuelto DESC
                            LIMIT 0, 1";

                $query_dev = new Consulta($sql_dev);
                $row_dev = $query_dev->VerRegistro();
                $descripcion_dev=$row_dev['descripcion'];
            }
			
			$tooltip_asunto = "";
			if(!empty($row_reg['asunto_documento']))
				$tooltip_asunto="title ='".$row_reg['asunto_documento']."' class='tip'";
		
		?>
	<tr class="ui-widget-content1 jqgrow <?=$clase?>">
    	<td <?=$tooltip_asunto?> width="16%">
		<div align="center">
      <?php

           $cod = $row_reg["codigo_documento"];
           if($estado != 12&&$estado != 11){ ?>
              <a href="mesa_acceso_registro.php?opcion=despachar&ids=<?=$ids?>">
				<?=$cod?>
              </a>
              <? }
			else{
              echo $cod;
			}
            ?>
			</div>    	</td>
		<td width="27%"><input size="40" value="<?=$row_reg[nombre_remitente]?>"/></td>
    	<td width="28%"><input size="47" value="<?=$row_reg[numero_documento]?>"/></td>
    	<td width="13%">		
			<div align="center">
				<input type="text" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?>" style="text-align:center;width:100%;"/>				
			</div>		</td>
    	<td align="center" <? if(!empty($descripcion_dev)){echo "title ='".$descripcion_dev."' class='tip'";}?> width="6%"><input name="text" type="text" style="text-align:center; width:100%" value="<?=$row_reg['abrev_nombre_estado']?>"/></td>
      	<td>	  
        <?
            $documento = new Documento($row_reg['id_documento']);
        ?>
		<input type="text" value="<?=$documento->UltimaUbicacionReporte()?>" />     </td>
    </tr>
	<? }?>
	</table>
	</td>
	</tr>
</table>
</div>

<? }

function ConsultarDocumento($ids){

	$sql_resumen="SELECT
				documentos.id_documento,
				documentos.codigo_documento,
				remitentes.nombre_remitente,
				tipos_documento.nombre_tipo_documento,
				documentos.numero_documento,
				documentos.referencia_documento,
				documentos.anexo_documento,
				documentos.numero_folio_documento,
				documentos.fecha_documento,
				documentos.fecha_registro_documento,
                dc.categoria
				FROM
				documentos
				LEFT Join remitentes ON remitentes.id_remitente = documentos.id_remitente
				LEFT JOIN documentos_categorias AS dc ON dc.id_documento = documentos.id_documento
				Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento
				WHERE
				documentos.id_documento = '".$ids."'";

	$query_resumen=new Consulta($sql_resumen);
	$row_resumen=$query_resumen->ConsultaVerRegistro(); 

	$_POST['nombre']=$row_resumen[2];
	$_POST['ids']=$row_resumen[0];

	$documento = new Documento($ids);
    
    $remitente_etiquetas = array(
        'TUPA'=>"TUPA",
        'TRANS'=>"Transparencia",
        'GUIA'=>"Gu&iacute;a de Servicio",
        'OTRO'=>"Otros.."
    );
    
		?>


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
			    <?
					$escaneo = "SELECT * 
								from documentos_escaneados de
								where de.id_documento = ".$ids;
							
					$qescaneo = new Consulta($escaneo);
				
			  		$index = 1;
			
					while($row_reg = $qescaneo->ConsultaVerRegistro()){
						if(is_null($row_reg['fecha_escaneo']))
							$ref = "Escaneo/".$row_reg['nombre_documento_escaneado'];
						else
							$ref = "../sad/Escaneado_completo/".$row_resumen[1]."/".$row_reg['nombre_documento_escaneado'];
					?>
			    		<a href="<?=$ref?>" id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank"><?=$index?></a>		
			        <?
						$index++;
            		}
				  	?>               
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
  	<? $edi="SELECT
			`td`.`asunto_documento`,
			`td`.`observacion_documento`,
			`td`.`id_prioridad`
			FROM
			`documentos` AS `td`
			WHERE
			`td`.`id_documento` =  '".$ids."'";
			$qedit=new Consulta($edi);	
			$row_edit=$qedit->ConsultaVerRegistro();
			$cboprioridad=$row_edit['id_prioridad'];
			?>    

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
      <td width="210" ><?
		$sql_prioridad="SELECT prioridades.id_prioridad, prioridades.nombre_prioridad, prioridades.tiempo_horas_respuesta_prioridad
						FROM prioridades
						ORDER BY prioridades.id_prioridad ASC";
		$query_prioridad=new Consulta($sql_prioridad);
		?>
          <div align="left">
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
		<?php
			$acciones = new Acciones();
			$accions = $acciones->getAcciones(3,$_SESSION['session'][0]);	
			$tacciones = sizeof($accions);
		?>
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
			<?
	      	$sql_areas="SELECT areas.id_area, areas.abve_nombre_area FROM areas";
    		$query_areas=new Consulta($sql_areas);
			?>
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
  <? }

/**********************************************************/
////REEMPLAZAR
/**********************************************************/

function DespacharListarDestino($ids)  {
    $documento = new Documento ($ids);
    $cls_estado = $documento->getEstado();
    $estado = $cls_estado->getId();
?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" class="formularios" id="tabla_despacho">
    <tr bgcolor="#6699CC" class="Estilo7">
        <td width="3%" height="25" ><div align="center" class="msgok1">Nro</div></td>
        <td width="23%"><div align="center" class="msgok1">ORIGEN</div></td>
        <td width="24%"><div align="center" class="msgok1">DESTINO</div></td>
        <td width="13%"><div align="center" class="msgok1">Fecha y Hora </div></td>
        <td width="13%"><div align="center" class="msgok1">Accion</div></td>
        <td width="11%"><div align="center" class="msgok1">Categor&iacute;a</div></td>
        <td width="13%"><div align="center" class="msgok1">Opciones </div></td>
  </tr>

	<?
	$sql_origen="SELECT * FROM
                `historial_documentos` AS `th`
                Inner Join `estados` AS `te` ON `te`.`id_estado` = `th`.`id_estado`
                LEFT Join `accion` AS `tac` ON `tac`.`id_accion` = `th`.`id_accion`
                LEFT Join `areas` AS `ta` ON `ta`.`id_area` = `th`.`id_area`
                WHERE
                `th`.`id_documento` =  '".$ids."'
                ORDER BY
                th.original_historial_documento ASC,
                th.fecha_historial_documento ASC";

   		$query_origen=new Consulta($sql_origen);
		$hayOriginal=0;
		$cont = 0;

		while($row_org=$query_origen->ConsultaVerRegistro()){
		$cont++;
		$id=$row_org[0];
	  ?>	
      <tr>
        <td bgcolor="#ffffff"><input type="hidden" value="<?=$id?>"><div align="center"><?=$row_org[0]?></div></td>
        <td bgcolor="#ffffff"><?=$_POST[nombre]?></td>
        <td bgcolor="#ffffff"><?=$row_org['nombre_area']?></td>
        <td bgcolor="#ffffff">
		<div align="center">
			<?=date('d/m/Y H:i',strtotime($row_org['fecha_historial_documento']))?>
		</div>
		</td>
        <td bgcolor="#ffffff"><div align="center"><?=$row_org['nombre_accion']?></div></td>
        <td bgcolor="#ffffff"><div align="center">
			<? if($row_org['original_historial_documento']=='1'){
					echo 'ORIGINAL'; 
					$hayOriginal++;
				} else {
					echo 'COPIA';
				}?></div>
		  </td>
        <td bgcolor="#ffffff"><div align="center">
			<a href="mesa_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&id=<?=$id?>">
				<img src="public_root/imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0">
			</a>
		
		<? 
			$observacion = trim($row_org['observacion_historial_documento']);
			
                if(!empty($observacion)){?>
                   <a href="javascript:VerDetalleObservacion(<?php echo $cont ?>)">
                     <img src="public_root/imgs/b_search.png" width="16" height="16" border="0" alt="Ver Detalle" />
                   </a>
                <?
                }
                   else{
                ?>
                   <img src="public_root/imgs/b_search.png" width="16" height="16" border="0" alt="Ver Detalle" />
                <? }?>
		
		</div></td>
      </tr>
	  <tr>
		<td colspan="7" align="justify">
			<div style="display:none" id="detalle_observacion<?php echo $cont; ?>">
					<?=$observacion?>
			</div>
		</td>
	</tr>
     <? } ?>
</table> 
<?
    
	if($hayOriginal > 0&&$estado!=5){
            $sql_prioridad = "SELECT id_prioridad
                        FROM documentos
                        WHERE id_documento = $ids";
            $query_prioridad=new Consulta($sql_prioridad);
            $row_prioridad=$query_prioridad->VerRegistro();
	?>
		<script>
            deshabilitado();
            deshabilita_prioridad(<?=$row_prioridad["id_prioridad"]?>);//Coge la prioridad del original
            deshabilita_asunto(<?=$ids?>);
            habilita_copia();
        </script>
	<?
    }else{
         ?>
		<script>
            javascript:deshabilita_copia(); 
        </script>
	<? }
}

/**********************************************************/
////FIN REEMPLAZAR
/**********************************************************/

function DespacharGuardarDestino($ids) {

	$nombre=$_POST['nombre'];
	$fecha_actual = time();
	$fecha=date("Y-m-d H:i:s",$fecha_actual);
	$cboareas=$_POST['cboareas'];
	$radiobutton=$_POST['radiobutton'];
	$cboaccion=$_POST['cboaccion'];
	$cboprioridad=$_POST['cboprioridad'];
	$textfield2=$_POST['textfield2'];
	$textarea=$_POST['textfield4'];
	$estado=3;
	
	$guades =  "Insert INTO
				historial_documentos values('',
				'".$ids."',
				'',
				'".$cboareas."',
				'".$fecha."',
				'".$radiobutton."',
				'".$cboaccion."',
				'".$_SESSION['session'][0]."',
				'".$estado."',
				'".$textarea."')";
	
	$qdest=new Consulta($guades);
    $id_hist=$qdest->NuevoId();

	$sqlrep =  "SELECT id_documento_reporte as id
				FROM documentos_reporte
				WHERE id_documento=$ids";
	
	$qrep=new Consulta($sqlrep);
	$rowrep=$qrep->VerRegistro();
	$documento = new Documento($ids);
	$remitente = $documento->getRemitente();
	$area = new Area($cboareas);
	$accion = new Accion($cboaccion);
	$usuario = new Usuario($_SESSION['session'][0]);
	$ubicacion = "";
	
	
	$est='D';
    $esta='DESPACHADO';
	$ubicacion = $area->getAbreviatura();
	/*}else{
		$cl_est=$documento->getEstado();
		$est=$cl_est->getAbreviatura();
        $esta=$cl_est->getNombre();
	}*/
	
	//Para el reporte
	$sql_mov = "Insert INTO
				movimientos values('',
				'".$rowrep['id']."',
                '".$id_hist."',
				'DESPACHO GENERAL',
				'".$area->getNombre()."',            
				'".$accion->getNombre()."',
				'".$radiobutton."',
				'".$usuario->getLogin()."',
				'".$textarea."',
				'".$fecha."',
				'".$esta."',
				'".$ubicacion."',				
				'1')";
	
	$q_mov=new Consulta($sql_mov);
	
	if($radiobutton==1){
	
		$prioridad = new Prioridad($cboprioridad);
	
		$s_act="Update documentos 
				SET id_prioridad='".$cboprioridad."', 
				asunto_documento='".$textfield2."',
				id_estado='".$estado."'
				WHERE id_documento='".$ids."'";
				$qact=new Consulta($s_act);
	
		 $s_mov="Update documentos_reporte
				SET prioridad='".$prioridad->getNombre()."',
				asunto='".$textfield2."',
				estado='".$est."',                
				ubicacion='".$ubicacion."'
				WHERE id_documento='".$ids."'";
				$qact_mov=new Consulta($s_mov);
	}
}

/**********************************************************/
////REEMPLAZAR
/**********************************************************/
function DespacharEliminarDestino($id,$ids){

    $sql   = " SELECT 
               original_historial_documento AS categoria
               FROM historial_documentos 
			  		WHERE id_historial_documento='".$id."'";

	$q     = new Consulta($sql);
    $row   = $q->ConsultaVerRegistro();

	$sst_r = "DELETE FROM historial_documentos 
			  where id_historial_documento='".$id."'";
			 
	$qt_r  = new Consulta($sst_r);

    $sst_r = "DELETE FROM movimientos 
			  WHERE id_historial='".$id."' AND tipo=1";
	$qt_r=new Consulta($sst_r);

    if($row['categoria']==1){		
        /*$actua="Update documentos SET 
                id_prioridad='',
                asunto_documento=''
            	WHERE id_documento='".$ids."'";

        $q_actua=new Consulta($actua);

        $actua_r = "Update documentos_reporte SET
                    prioridad='',
                    asunto='',
                    ubicacion=''
                    WHERE id_documento='".$ids."'";

        $q_actua_r=new Consulta($actua_r);*/
	}

    //Vemos si no tiene historial de originales
    $sql_t="SELECT  id_historial_documento
            from historial_documentos
            WHERE id_documento='".$ids."'
            AND original_historial_documento=1";

     $query_t=new Consulta($sql_t);

    if($query_t->NumeroRegistros()==0){
	
        $actua = "UPDATE documentos 
				  SET id_estado=1
				  WHERE id_documento='".$ids."'";

        $q_actua=new Consulta($actua);

        $actua_r = "UPDATE documentos_reporte 
					SET estado='R'
                    WHERE id_documento='".$ids."'";

        $q_actua_r=new Consulta($actua_r);
    }

}
    /**********************************************************/
    ////FIN REEMPLAZAR
    /**********************************************************/
    function RegistraFiltrar(){

        $sql_estado =  "SELECT *
                        FROM estados AS e
                        WHERE e.display = 1
                        ORDER BY e.nombre_estado ASC";
                        
        $q_estado=new Consulta($sql_estado);
        ?>

    <form name="f5" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=list&ide=<?=$ide?>">

        <table width="100%" height="50" border="0" >
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                <select name="ide">
                <option value="">---Estado---</option>
                  <?
                            while($row_estado=$q_estado->ConsultaVerRegistro()){
                                $ide=$row_estado[0];?>
                <option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){ echo "selected";} ?>>
                  <?=$row_estado[1]?>
                </option>
                <option value="LT">LISTAR TODOS</option>
                  <?}?>
                </select></td>
            </tr>
            <tr>
                  <td align="center" ><input name="Filtrar" type="submit"  value="Filtrar"/></td>
            </tr>
    </table>
    </form>
    <?
    }
    
    
    function RegistraAgregar($ids){ 

        $sql_resumen="
            SELECT
                documentos.id_documento,
                documentos.codigo_documento,
                remitentes.nombre_remitente,
                tipos_documento.nombre_tipo_documento,
                documentos.numero_documento,
                documentos.referencia_documento,
                documentos.anexo_documento,
                documentos.numero_folio_documento,
                documentos.fecha_documento,
                documentos.fecha_registro_documento,
                dc.categoria
            FROM
                documentos
            LEFT Join remitentes ON remitentes.id_remitente = documentos.id_remitente
            LEFT JOIN documentos_categorias AS dc ON dc.id_documento = documentos.id_documento
                Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento
            WHERE
                documentos.id_documento = '".$ids."'
            ";

        $query_resumen=new Consulta($sql_resumen);
        $row_resumen=$query_resumen->ConsultaVerRegistro(); 

        $_POST['nombre']=$row_resumen[2];
        $_POST['ids']=$row_resumen[0];

        $documento = new Documento($ids);
        
        $remitente_etiquetas = array(
            'TUPA'=>"TUPA",
            'TRANS'=>"Transparencia",
            'GUIA'=>"Gu&iacute;a de Servicio",
            'OTRO'=>"Otros.."
        );
        
        #Conseguir documentos escaneados
        $escaneo = "SELECT * 
                    from documentos_escaneados de
                    where de.id_documento = ".$ids;
                
        $qescaneo = new Consulta($escaneo);
        $escaneos = $qescaneo->getRows();
        
        # Conseguir la Prioridad guardada en el Documento
        $edi="
            SELECT
			`td`.`asunto_documento`,
			`td`.`observacion_documento`,
			`td`.`id_prioridad`
			FROM
			`documentos` AS `td`
			WHERE
			`td`.`id_documento` =  '".$ids."'
            ";
        $qedit=new Consulta($edi);	
        $row_edit=$qedit->ConsultaVerRegistro();
        $cboprioridad=$row_edit['id_prioridad'];
        # Listar Prioridades
		$sql_prioridad="
            SELECT 
                prioridades.id_prioridad, 
                prioridades.nombre_prioridad, 
                prioridades.tiempo_horas_respuesta_prioridad
            FROM 
                prioridades
            ORDER BY 
                prioridades.id_prioridad ASC
            ";
		$query_prioridad=new Consulta($sql_prioridad);    
        
        #listar acciones
        $acciones = new Acciones();
        $accions = $acciones->getAcciones(3,$_SESSION['session'][0]);	
        $tacciones = sizeof($accions);   
        
        #listar areas
        $sql_areas="SELECT areas.id_area, areas.abve_nombre_area FROM areas";
        $query_areas=new Consulta($sql_areas);
        
        require "Templates/registro.php";
    }


    
}
?>
