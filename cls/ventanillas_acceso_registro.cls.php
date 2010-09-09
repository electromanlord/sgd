<?php

class Registro {

function RegistraListado($ide){	
 	
	$calculo = strtotime("-1 days");
	$fecha_ayer=date("Y-m-d", $calculo);
	if ($ide == ''){
        $sql_reg =  "SELECT
					d.id_documento,
					d.id_estado,
					d.asunto_documento,
					d.fecha_registro_documento,
					e.abrev_nombre_estado,
					d.numero_documento,
					d.codigo_documento,
					r.nombre_remitente
					FROM 
					documentos AS d  
					LEFT Join remitentes AS r
					ON r.id_remitente = d.id_remitente 
					Inner Join estados AS e 
					ON e.id_estado = d.id_estado 
					LEFT Join tipos_documento td
					ON td.id_tipo_documento = d.id_tipo_documento
					LEFT Join usuarios u
					ON d.id_usuario = u.id_usuario
					WHERE d.id_estado =  1 AND
					u.id_anp = ".$_SESSION['session'][7]." AND
					d.fecha_registro_documento > '$fecha_ayer'
					ORDER BY 
					d.id_documento DESC";

		$query_reg = new Consulta($sql_reg);
		
	}
	else 
	{
		$where = ($ide=="LT")?"":"WHERE d.id_estado =$ide";
		
		$sql_reg = "SELECT
					d.id_documento,
					d.id_estado,
					d.asunto_documento,
					d.fecha_registro_documento,
					e.abrev_nombre_estado,
					d.numero_documento,
					d.codigo_documento,
					r.nombre_remitente
					FROM 
					documentos AS d 
					LEFT Join remitentes AS r
					ON r.id_remitente = d.id_remitente 
					Inner Join estados AS e 
					ON e.id_estado = d.id_estado 
					LEFT Join tipos_documento td
					ON td.id_tipo_documento = d.id_tipo_documento
					LEFT Join usuarios u
					ON d.id_usuario = u.id_usuario					
					$where  
					AND u.id_anp = ".$_SESSION['session'][7]."
					ORDER BY d.id_documento DESC";
		echo $sql;			
		$query_reg=new Consulta($sql_reg);		
	}
?>
<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
		<td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">
					<th width="17%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="27%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="14%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th width="8%" class="ui-widget-header ui-th-column grid_resize">Opciones</th>
				</tr>			
			</table>
		</td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">
		    
			<? while($row_reg=$query_reg->ConsultaVerRegistro()){
                    $id=$row_reg["id_documento"];
                    $estado = $row_reg["id_estado"];
					
					$tooltip = "";
					if(!empty($row_reg['asunto_documento']))
						$tooltip = $row_reg['asunto_documento'];
            ?>
					
	   <tr class="ui-widget-content1 jqgrow <? echo ($estado==12)?"Estilo2 fila_finalizada":"Estilo2";?>">
	   		<td <?=$tooltip?> width="17%">
				<div align="center">
                <?php 
                $cod = $row_reg["codigo_documento"];
                if($estado != 12&&$estado != 11){ ?>
                    <a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>">
                    <?=$cod?></a>
                <? }
                    else{
                        echo $cod;
                    }
                ?>
		        </div></td>
	      	<td width="27%"><input size="48"  value="<?=$row_reg["nombre_remitente"]?>"/></td>
		    <td><input size="43" value="<?=$row_reg["numero_documento"]?>"/></td>		    
		    <td width="14%">
				<div align="center">
					<input value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?>" style="width:100%; text-align:center"/>					
				</div>
			</td>
      		<td align="center"  width="6%">
				<div align="center">
					<input value="<?=$row_reg['abrev_nombre_estado']?>" style="width:100%; text-align:center"/>	
      			</div>
			</td>
      		<?php 

		  		$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo` 
							FROM `historial_documentos` AS `hd` 
							where hd.id_documento='".$row_reg['id_documento']."' 
							GROUP BY `hd`.`id_documento`";

				$query_ultimo=new Consulta($sql_ultimo);		
				$ultimo=$query_ultimo->ConsultaVerRegistro();
				
				$sql_data = "SELECT hd.id_documento,
							a.nombre_area, 
							a.abve_nombre_area 
							FROM historial_documentos AS hd 
							Inner Join areas AS a ON a.id_area = hd.id_area 
							where hd.id_historial_documento='".$ultimo['ultimo']."'";

				$query_data=new Consulta($sql_data);		
				$data=$query_data->ConsultaVerRegistro();

		$sql_usu="SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`, `ha`.`id_documento` 
				FROM 
				`historial_atencion` AS `ha` 
				WHERE 
				ha.original_historial_atencion =  '1' and 
				ha.id_documento='".$row_reg['id_documento']."' 
				GROUP BY `ha`.`id_documento`	";

		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu = "SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
                FROM `historial_atencion` AS `ha`
                Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE `ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";

        $qusu=new Consulta($susu);
    	$u=$qusu->ConsultaVerRegistro();
	?>
				<td width="8%">
					<div align="center"><a href="javascript:imprimir_documento_reg(<?=$id?>)">
				    <img src="public_root/imgs/print.gif" border="0" />
			    </a> </div></td>
			</tr>
			<? }?>
		 </table>
		</td>
	</tr>
</table>
</div>
<?php 
}

function Busqueda($campo, $valor){	 

	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND remitentes.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : "";
	}

	$sql_reg = "SELECT * FROM documentos d
                LEFT Join remitentes ON remitentes.id_remitente = d.id_remitente
                Inner Join estados ON estados.id_estado = d.id_estado
                Inner Join tipos_documento ON tipos_documento.id_tipo_documento = d.id_tipo_documento
                ".$where." ORDER BY d.id_documento DESC";
	
	$query_reg=new Consulta($sql_reg);		
?>

<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
		<td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">
					<th width="17%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="27%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="14%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th width="11%" class="ui-widget-header ui-th-column grid_resize">Opciones</th>
				</tr>			
			</table>
		</td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">
			<? while($row_reg=$query_reg->ConsultaVerRegistro()){
					$id=$row_reg[0];
					$estado = $row_reg["id_estado"];
					$tooltip = "";
					if(!empty($row_reg['asunto_documento']))
						$tooltip = $row_reg['asunto_documento'];
            ?>
					
	   <tr class="ui-widget-content1 jqgrow <? echo ($estado==12)?"Estilo2 fila_finalizada":"Estilo2";?>">
	   		<td <?=$tooltip?> width="17%">
				<div align="center">
                <?php
                $cod = $row_reg[1];
                if($estado != 12&&$estado != 11){ ?>
                    <a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>">
                    <?=$cod?></a>
                <? }
                    else{
                        echo $cod;
                    }
                ?>
	</div></td>
    <td width="27%"><input size="48"  value="<?=$row_reg[nombre_remitente]?>"/></td>
    <td><input size="43" value="<?=$row_reg[3]?>"/></td>
    <td width="14%"> <div align="center">
      <input name="Input" style="width:100%; text-align:center" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?>"/>
    </div></td>
    <td align="center" width="6%"><div align="center">
      <input name="Input2" style="width:100%; text-align:center" value="<?=$row_reg['abrev_nombre_estado']?>"/>
    </div></td>
    <?php
        $sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
                    FROM
                    `historial_documentos` AS `hd`
            		where hd.id_documento='".$row_reg['id_documento']."'
                    GROUP BY
                    `hd`.`id_documento`";

		$query_ultimo=new Consulta($sql_ultimo);		
		$ultimo=$query_ultimo->ConsultaVerRegistro();
		
        $sql_data = "SELECT hd.id_documento,
                    a.nombre_area,
                    a.abve_nombre_area
                    FROM historial_documentos AS hd
                    Inner Join areas AS a ON a.id_area = hd.id_area
                    where hd.id_historial_documento='".$ultimo['ultimo']."'";

		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();

		$sql_usu = "SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`,
                    `ha`.`id_documento`
                    FROM
                    `historial_atencion` AS `ha`
                    WHERE
                    ha.original_historial_atencion =  '1' and
                    ha.id_documento='".$row_reg['id_documento']."'
                    GROUP BY
                    `ha`.`id_documento`	";

		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu = "SELECT `u`.`login_usuario`,
                `a`.`abve_nombre_area`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";

		$qusu=new Consulta($susu);		
		$u=$qusu->ConsultaVerRegistro();
    ?>

    <td width="11%">
	  <div align="center"><a href="javascript:window.open('Ventanillas/ficha_registro.php?id=<?=$id?>','popup','width=500' , 'height=250')" target="_blank">
	      <img src="public_root/imgs/print.gif" border="0" />	</a></div></td>
    </tr>
<? }?>
		 </table>
		</td>
	</tr>
</table>
</div>

<? }

function RegistraAgregar(){ 

    $remitente_etiquetas = array(
        'TUPA'=>"TUPA",
        'TRANS'=>"Transparencia",
        'GUIA'=>"Gu&iacute;a de Servicio",
        'OTRO'=>"Otros.."
    );
    

    $sql_exp = "SELECT max(e.id_expediente) as nuevo_id FROM expedientes e ";
    $query_exp = new Consulta($sql_exp);
    $exp = mysql_fetch_object( $query_exp->Consulta_ID) ;
    $exp = str_pad( ( $exp->nuevo_id? $exp->nuevo_id+1 : 1 ) ,7, "0" , STR_PAD_LEFT );
?>

<form id="form_registrar_documento" name="form_registrar_documento" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=guardar">

  <table width="90%" border="0" align="center" class="formularios">

    <tr class="Estilo2">
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="3" class="Estilo2">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="3" class="Estilo2">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td width="18" class="Estilo22"><div align="left" class="Estilo21" >(*) </div></td>
      <td width="77" class="Estilo22"><div align="left">Remitente</div></td>
      <td width="3" class="Estilo22"><div align="center">:</div></td>
      <td width="296" class="Estilo2" colspan="6">
        <div align="left">
          <input name="remitente" type="text" class=" caja" id="text_remitente" size="110">
          <input name="remit" type="hidden" id="id_remitente" value="">
        </div>		 
        </td>
    </tr>
    
    <tr>
            <td width="18" class="Estilo22"><div align="left" class="Estilo21" >(*) </div></td>
   		  <td class="Estilo22"><div align="left" class="Estilo22">Tipo</div></td>
   		  <td class="Estilo22"><div align="center">:</div></td>
   		  <td bgcolor="#FFFFFF" colspan="6">
                <?
                        $sql_tipo ="SELECT * 
                                    FROM tipos_documento 
                                    WHERE entrada_salida = 0 || entrada_salida = 2
                                    ORDER BY tipos_documento.nombre_tipo_documento ASC";
                        $query_tipo=new Consulta($sql_tipo);	
                ?>
                <div align="left">
                <span style="display:inline-block;margin-right:10px;">
                  <select name="tipo" class="tipo_doc">
                    <option value="">-Tipo de Documento-</option>
                    <?
                    while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
                        <option value="<?=$row_tipo[0]?>"
                            <? if(isset($_POST['tipo']) && $_POST['tipo']== $row_tipo[0]){ echo "selected";} ?>>
                            <?=$row_tipo[1]?>
                        </option>
                    <?  } ?>
                    </select>
                </span>    
		<span class="">
		        <span align="left" class="Estilo21 ">(*)</span>
		        <span class="Estilo22 " >Clase</span>
		        <select name="categoria_doc" type="text" id="categoria_doc" class="">
		            <option value="">Seleccionar...</option>
		            <?foreach( $remitente_etiquetas as $k=>$cat){?>
		                <option value="<?=$k?>"><?=$cat?></option>
		            <?}?>
		        </select>
		        <!-- Expediente -->
		        <span id="span_expediente" class="hidden">
		            <span class="Estilo22">Expediente No.:</span>
		            <strong><?=$exp?></strong>
		            <input type="hidden" name="expediente" value="<?=$exp?>"  />
		        </span>
		        <!-- End Expediente -->
		</span>
 		    </div>
          </td>
    </tr>
   	<tr>
   		  <td class="Estilo22">&nbsp;</td>
   		  <td class="Estilo22"><div align="left" class="Estilo22">Documento</div></td>
   		  <td class="Estilo22"><div align="center">:</div></td>
   		  <td bgcolor="#FFFFFF"><div align="left"><span class="Estilo2">
   		    <input name="num_doc" type="text" id="num_doc" value="" style="width:290px" class="caja"/>
	      </span></div></td>
   		  <td class="Estilo2"><div align="left" class="Estilo21">(*)</div></td>
   		  <td class="Estilo2"><div align="left"><span class="Estilo22">Fecha</span></div></td>
   		  <td class="Estilo22"><div align="center">:</div></td>
   		  <td class="Estilo2"><div align="left">
   		    <input name="date_registrar" type="text" id="date_registrar" class="inputbox caja" size="15" value="" readonly="readonly"/>
 		    </div></td>
   		  <td width="75" class="Estilo2"><div align="left">
   		    <input name="image2" type="image" id="trigger_registrar" src="public_root/imgs/calendar.png" width="20" height="20" hspace="1"  border="0" style="border:none"/>
 		    </div></td>
    </tr>
   		<tr>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22"><div align="left">
        <div align="left" class="Estilo22"> Folios</div>
      </div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td bgcolor="#FFFFFF"><div align="left"><span class="Estilo2">
        <input name="num_folio" type="text" size="12" class="caja"/>
      </span></div></td>
      <td width="18" class="Estilo2">&nbsp;</td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td width="98" class="Estilo2">&nbsp;</td>
      <td class="Estilo2">
		<script type="text/javascript">
          Calendar.setup(
            {
              inputField  : "date_registrar",
              ifFormat    : "%d/%m/%Y",
              weekNumbers: false,
              button      : "trigger_registrar"
            }
          );
	    </script></td>
    </tr> 
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2"><div align="left" class="Estilo22">Referencia</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="7"><div align="left">
        <input name="refe" value="" type="text" size="110" class="caja"/>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22"><div align="left" class="Estilo22">Anexos</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="7"><div align="left"><span class="Estilo2">
        <input name="anexo" value="" type="text" size="110" class="caja"/>
      </span></div></td>
    </tr>
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2"><div align="left" class="Estilo22">Observacion</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="7"><div align="left">
        <textarea name="observ" cols="110" rows="4" value="" class="caja"></textarea>
      </div></td>
    </tr>
    <tr>
      <td  height="60" colspan="9" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="boton" name="Guardar2" type="button" value="Guardar" id="btnguardar" onclick="guardar_registro_documento()"/>        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="Limpiar" type="reset" value="Limpiar" class="boton"/></td></tr>
  </table>
</form>
  <? }

function RegistraEditar($id){
	
	$doc = new Documento($id);			
    $remitente = $doc->getRemitente();
    $tipo = $doc->getTipoDocumento();

    if(!$doc->expediente){
        $sql_exp = "SELECT max(e.id_expediente) as nuevo_id FROM expedientes e ";
        $query_exp = new Consulta($sql_exp);
        $exp = mysql_fetch_object( $query_exp->Consulta_ID) ;
        $doc->expediente = str_pad( ( $exp->nuevo_id? $exp->nuevo_id+1 : 1 ) ,7, "0" , STR_PAD_LEFT );
    }
    
    #dump($doc);
    $remitente_etiquetas = array(
        'TUPA'=>"TUPA",
        'TRANS'=>"Transparencia",
        'GUIA'=>"Gu&iacute;a de Servicio",
        'OTRO'=>"Otros.."
    );
?>

<form id="form_editar_documento" name="form_editar_documento" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>">
  <table border="0" align="center" class="formularios" width="90%">
    <tr class="Estilo2">
      <td colspan="3" class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td colspan="3" class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td width="18" class="Estilo21">(*)</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo22" > Remitente</div></td>
      <td width="9" class="Estilo22"><div align="center"></div></td>
      <td width="315" >
        <div align="left">
          <input name="remitente" type="text" class="doc_remitente caja" id="text_remitente" style="width:290px" value="<?=$remitente->getNombre();?>"/>
		  <input name="remit" type="hidden" id="id_remitente" value="<?=$remitente->getNombre().",".$remitente->getId();?>">
        </div></td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
   		<tr>
   		  <td class="Estilo21">(*)</td>
   		  <td class="Estilo22"><div align="left"> Tipo de Documento </div></td>
   		  <td class="Estilo22"><div align="center">:</div></td>
   		  <td bgcolor="#FFFFFF"><div align="left"><span class="Estilo2">
   		    <?
				$sql_tipo ="SELECT * 
							FROM tipos_documento 
							WHERE entrada_salida = 0 || entrada_salida = 2
							ORDER BY tipos_documento.nombre_tipo_documento ASC";
							
				$query_tipo=new Consulta($sql_tipo);	
		?>
   		    <select name="tipo" class="tipo_doc caja" style="width:200px;">
   		      <option value="">---Tipo de Documento---</option>
   		      <? while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
   		      <option value="<?=$row_tipo[0]?>"<? if($row_tipo[0]==$tipo->getId()){ echo "selected";} ?>><?php echo $row_tipo[1]?> </option>
   		      <?  } ?>
	      </select>
	      </span></div></td>
   		  <td bgcolor="#FFFFFF">&nbsp;</td>
   		  <td bgcolor="#FFFFFF"><div align="left" class="Estilo22">Folios:</div></td>
   		  <td colspan="2" bgcolor="#FFFFFF"><div align="left"><span class="Estilo2">
   		    <input name="num_folio" type="text" value="<?=$doc->getNumeroFolio()?>" size="10" class="caja"/>
	      </span></div></td>
    </tr>
    <?if($doc->categoria){?>
        <tr class="Estilo2">
          <td width="18" class="Estilo21">(*)</td>
          <td width="196" class="Estilo22"><div align="left" class="Estilo22" >Clase</div></td>
          <td width="9" class="Estilo22"><div align="center"></div></td>
          <td width="315" >
            <div align="left">
                <select name="categoria_doc" type="text" id="categoria_doc">
                    <option value="">Seleccionar...</option>
                    <?foreach( $remitente_etiquetas as $k=>$cat){?>
                        <option 
                            <?=($doc->categoria == $k? 'selected="selected"' :'')?>
                            value="<?=$k?>" > <?=$cat?></option>
                    <?}?>
                </select> 
                
                
                <!-- Expediente -->
                <span id="span_expediente" class="<?=($doc->categoria=="TUPA"?"":"hidden")?>">
                    <span class="Estilo22">Expediente No.:</span>
                    <strong><?=$doc->expediente?></strong>
                    <input type="hidden" name="expediente" value="<?=$doc->expediente?>"  />
                    <?if ($doc->categoria!="TUPA"){?>
                        <input type="hidden" name="expediente_nuevo" value="1"  />
                    <?}?>
                </span>
                <!-- End Expediente -->
                
            </div></td>
          <td colspan="2" class="Estilo22">&nbsp;</td>
          <td colspan="2" class="Estilo2">&nbsp;</td>
        </tr>
    <?}?>    
        
        
   		<tr>
   		  <td width="18" class="Estilo22">&nbsp;</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo2">Documento</div></td>
      <td width="9" class="Estilo22"><div align="center">:</div></td>
      <td bgcolor="#FFFFFF"><div align="left"><span class="Estilo2">
        <input name="num_doc" type="text" id="num_doc" value="<?=$doc->getNumero();?>" size="48" class="caja"/>
      </span></div></td>
      <td width="21" bgcolor="#FFFFFF"><div align="left" class="Estilo21">(*)</div></td>
      <td width="58" bgcolor="#FFFFFF"><span class="Estilo22"> Fecha:</span></td>
      <td width="97" bgcolor="#FFFFFF"><div align="left">
              <input name="date" type="text" id="date" class="inputbox caja" size="12" value="<?=cambiar_caracter("-","/",$doc->getFecha())?>" readonly="readonly"/>
      </div></td> 
      <td width="114" bgcolor="#FFFFFF"><div align="left">
        <input name="image" type="image" id="trigger" src="public_root/imgs/calendar.png" width="20" height="20" hspace="1" style="border:none"/>
        <script type="text/javascript">
              Calendar.setup(
                {
                  inputField  : "date",
                  ifFormat    : "%d/%m/%Y",
                  weekNumbers: false,
                  button      : "trigger"
                }
              );
        </script>
        
        
      </div></td>      
   </tr> 
    <tr>
      <td width="18" class="Estilo22">&nbsp;</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo2">Referencia</div></td>
      <td width="9" class="Estilo22"><div align="center">:</div></td>
      <td colspan="6">        <div align="left">
        <input name="refe" value="<?=$doc->getReferencia()?>" type="text" size="103" class="caja"/>
      </div></td>
    </tr>
    <tr>
      <td width="18" class="Estilo22">&nbsp;</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo2">Anexos</div></td>
      <td width="9" class="Estilo2"><div align="center">:</div></td>
      <td colspan="6"><div align="left"><span class="Estilo23">
        <input name="anexo" value="<?=$doc->getAnexo()?>" type="text" size="103" class="caja"/>
      </span></div></td>
    </tr>
    <tr>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22"><div align="left" class="Estilo2">Observacion</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><div align="left">
        <textarea name="observ" cols="100" rows="4" class="caja"><?=$doc->getObservacion()?>
      </textarea>
      </div></td>
    </tr>
    <tr>
      <td  height="60" colspan="8" align="center"><input name="Guardar" type="button" value="Actualizar" class="boton" id="btnActualizar" onclick="actualizar_registro_documento()"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="boton" name="imprimir"  type="button" onClick="javascript:window.open('Ventanillas/ficha_registro.php?id=<?php echo $id?>','popup','width=500' , 'height=250')" value="Imprimir" />      </td>
    </tr>
  </table>
</form>

  <? }

function RegistraGuardar(){

	$num_folio=$_POST["num_folio"];
	$tipo=$_POST["tipo"]; 
	$categoria=$_POST["categoria_doc"]; 
	$expediente=$_POST["expediente"]; 
	$num_doc=$_POST["num_doc"]; 
	$FechaSol=$_POST["date_registrar"]; 
	$refe=$_POST["refe"]; 
	$anexo=$_POST["anexo"]; 
	$destino=$_POST["destino"]; 
	$observ=$_POST["observ"]; 
	
	if($_POST["remit"]!=""){
		$remits=explode(",",$_POST["remit"]); 
		$remit=$remits[1];
	}else{		
		$remit=Registro::RegistraGuardarRemitente($_POST["remitente"],substr($_POST["remitente"],0,4),2);
	}

	//Calculamos el año actual
	$anio_actual = date("Y");
	
	$sql_anio = "SELECT * FROM anio WHERE anio = ".$anio_actual;
	$query_anio = new Consulta($sql_anio);
	$row_anio = $query_anio->ConsultaVerRegistro();
	
	$sql_cod = "SELECT 
				 Max(td.numeracion_documento) AS codigo
				 FROM documentos AS td
				 WHERE id_anio=".$row_anio["id_anio"];
				
	$query_codigo = new Consulta($sql_cod);		
	$row_codigo = $query_codigo->ConsultaVerRegistro();
	$codigo_n = $row_codigo['codigo']+1;
	
	$codigo = sprintf("%05d",$codigo_n).'-'.$row_anio["anio"];
	
	$anp = new Anp($_SESSION['session'][7]);
	
	$codigo = $anp->getSiglas()."-".$codigo;
	$var_estado=1;
	$fecha_actual = time();
	
	if(isset($_SESSION['session'][7])){
		$guarda="INSERT INTO documentos VALUES ('',
				'".$codigo."',
				'".$codigo_n."',
				'".$tipo."',
				'".$num_doc."',
				'".$refe."',
				'".$anexo."',
				'".$num_folio."',
				'".formato_date('/',$FechaSol)."',
				'',
				'".date("Y-m-d H:i:s",$fecha_actual)."',
				'".$observ."',
				'',
				'".$_SESSION['session'][0]."',
				'".$remit."',
				'".$var_estado."',
				'".$row_anio["id_anio"]."')";
	
		$q_guarda=new Consulta($guarda);
		$nuevo_id = $q_guarda->NuevoId();
		 //Insertar en las tablas de busqueda
		 $remitente = new Remitente($remit);
		 $tipo_doc = new TipoDocumento($tipo);
		 $estado = new Estado($var_estado);
		$usuario= new Usuario($_SESSION['session'][0]);
	
		 $reporte="INSERT INTO documentos_reporte VALUES ('',
					'".$q_guarda->NuevoId()."',
				'".$codigo."',
				'".$num_doc."',
				'".$remitente->getNombre()."',
				'',
				'".$tipo_doc->getNombre()."',			
				'".$num_folio."',
				'".$refe."',
				'".$anexo."',
				'".$observ."',
				'',
				'".formato_date('/',$FechaSol)."',
				'".date("Y-m-d H:i:s",$fecha_actual)."',
				'',
				'".$estado->getAbreviatura()."',
				'".$row_anio["anio"]."',							
				'".$usuario->getLogin()."',
				'')";
	
		$q_reporte=new Consulta($reporte);	
        
        $sql_doc_cat = "
            INSERT INTO documentos_categorias
                (id_documento,categoria) 
                VALUES( '$nuevo_id','$categoria' )
        ";
		$q_doc_cat=new Consulta($sql_doc_cat);	
        
        if( $categoria =="TUPA" ){
            $sql_doc_cat = "
                INSERT INTO expedientes
                    (codigo_expediente,id_documento) 
                    VALUES( '$expediente', '$nuevo_id' )
            ";
            $q_doc_cat=new Consulta($sql_doc_cat);	
        }
        
?>

<script type="text/javascript"> 
	javascript:imprimir("Ventanillas/ficha_registro.php?id=<?php echo $nuevo_id?>");
	location.href="Ventanillas_acceso_registro.php";
</script>

<?
	}else{
?>
	<div id="error">Ocurrio un error, Cierre su Sesión Actual y vuelva a iniciar Sesion</div>	
<?	}
  }

function RegistraUpdate($id){
 
    $num_folio=$_POST["num_folio"];
	$tipo=$_POST["tipo"]; 
	$num_doc=$_POST["num_doc"]; 
	$FechaSol2=$_POST["date"];
	$refe=$_POST["refe"]; 
	$anexo=$_POST["anexo"]; 
	$destino=$_POST["destino"]; 
	$observ=$_POST["observ"]; 
	$categoria=$_POST["categoria_doc"]; 
	$expediente=$_POST["expediente"]; 
	$expediente_nuevo=$_POST["expediente_nuevo"]; 
 	$var_estado=1;
	if($_POST["remit"]!=""){
		$remits=explode(",",$_POST["remit"]); 
		$remit=$remits[1];
		//echo "Remitente=".$remits[1];
	
	}else{		
		$remit=Registro::RegistraGuardarRemitente($_POST["remitente"],substr($_POST["remitente"],0,4),2);
	}
	
	$actualiza="UPDATE documentos SET 
				documentos.id_tipo_documento='".$tipo."', 
				documentos.`numero_documento`='".$num_doc."',
				documentos.`referencia_documento`='".$refe."',
				documentos.`anexo_documento`='".$anexo."',
				documentos.`numero_folio_documento`='".$num_folio."',
				documentos.`fecha_documento`='".formato_date('/',$FechaSol2)."',
				documentos.`observacion_documento`='".$observ."',
				documentos.`id_remitente`='".$remit."' 
				Where documentos.id_documento='".$id."'";
				
	$actua=new Consulta($actualiza);

    //Tabla de Busqueda
    $remitente = new Remitente($remit);
    $tipo_doc = new TipoDocumento($tipo);

    $actualiza="UPDATE documentos_reporte SET
				numero_documento='".$num_doc."',
				tipo='".$tipo_doc->getNombre()."',
                folio='".$num_folio."',                
				referencia='".$refe."',
				anexo='".$anexo."',
				observacion='".$observ."',
				fecha_documento='".formato_date('/',$FechaSol2)."',
                remitente='".$remitente->getNombre()."'				                
				Where id_documento='".$id."'";
                

	$actua=new Consulta($actualiza);
    
    // Tabla documentos_categorias
	$actualiza ="
        UPDATE documentos_categorias
        set categoria = '".mysql_real_escape_string($categoria)."'
        WHERE id_documento = '$id';
    ";
	$actua=new Consulta($actualiza);
    
    //Borra el expediente si el documento actualizado no es TUPA
    if($categoria != "TUPA"){
        $actualiza ="
            DELETE FROM expedientes
            WHERE id_documento = '$id';
        ";
        $actua=new Consulta($actualiza);
    }else if($categoria == "TUPA" && $expediente_nuevo ){
        //Y se actualizó a TUPA crea un nuevo expediente
        $actualiza = "
            INSERT INTO expedientes
                (codigo_expediente,id_documento) 
                VALUES( '$expediente', '$id' )
        ";
        $actua=new Consulta($actualiza);	
    }
    
}

function RegistraGuardarRemitente($nom_remi,$abrev,$tipo_remi){

	$sql_re="Insert Into remitentes Values('','".$tipo_remi."','".$nom_remi."','".$abrev."','','1')";
	$q_remite=new Consulta($sql_re);

	return 	$q_remite->NuevoId();

}

function RegistraFiltrar(){

	$sql_estado =  "SELECT * 
					FROM estados AS e
					WHERE e.display = 1 
					ORDER BY 
					e.nombre_estado ASC";

	$q_estado=new Consulta($sql_estado);		
	?>

	<form name="f5" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=list&ide=<?=$ide?>">
		<table width="100" height="50" border="0" >
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
		      <?  } ?>	
			      </select>
				</td>
    </tr>
 <tr>
  <td align="center" ><input name="Filtrar" type="submit"  value="Filtrar" class="boton" /></td>
  </tr>
</table>
</form>

<?
}
}

?>
