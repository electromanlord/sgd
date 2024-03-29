<?php 

class Escaneos {


function EscaneaEditar($id){

    $doc = new Documento($id);
    $escaneos = $doc->getEscaneos();  ?>

    <form id="fe" name="fe" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=add&id=<?php echo $id?>" enctype="multipart/form-data">
    <br/>
        <div style="float:left; width:33%; text-align:left">
            <fieldset style="width:100%; margin:0px 0px 15px 10px; padding:8px;">
                <legend>DATOS DOCUMENTO</legend>				
                <p><label class="primera_columna Estilo22" >N&ordm; Registro</label>
				<span style="float:left" class="Estilo22">:</span>
				<span style="margin-left:10px;"><?php echo $doc->getCodigo()?></span>                
                </p>
                <p><label class="primera_columna Estilo22">Remitente</label>
				<span style="float:left" class="Estilo22">:</span>
                <?php $remitente = $doc->getRemitente();?>
				<input type="text" style="margin-left:10px; width:157px;border:none;color:#666666" value="<? echo $remitente->getNombre();?>">
                </p>
                <p><label class="primera_columna Estilo22">N&ordm; Documento</label>
				<span style="float:left" class="Estilo22">:</span>
				<input type="text" style="margin-left:10px; width:157px;border:none;color:#666666" value="<?php echo $doc->getNumero()?>">	
                </p>
                <p><label class="primera_columna Estilo22">Folios</label>
				<span style="float:left" class="Estilo22">:</span>
				<span style="margin-left:10px;"><?php echo $doc->getNumeroFolio()?></span>
                </p>
                <p><label class="primera_columna Estilo22">Fecha</label>
				<span style="float:left" class="Estilo22">:</span>
				<span style="margin-left:10px;"><?php echo cambiar_caracter('-','/',$doc->getFecha())?></span>                
                </p>
            </fieldset>
        </div>

    <fieldset id="marco_file">
   		<legend>SUBIR ARCHIVOS ESCANEADOS</legend>
		
		<div class="Estilo21 both" style="margin-top:7px; margin-bottom:7px;">
		  <div align="left"><strong> (*) Tama&ntilde;o M&aacute;ximo 2Mb </strong></div>
		</div>
		<div class="ileft_img" style="margin-top:0.5em;">	
            <div id='cp_item_0' ><label for="imagen" class="Estilo22">Documento : </label><input id="doc[]" type="file" name="doc[]" size="40"/></div>
		</div>		
        <div class="iright_img"> <span onclick="crearCarchivo(0)"> [ + Agregar ] </span> </div>
		<div class="iright_img"> <span onclick="quitarCarchivo(0)">  [ - Quitar ] </span> </div>
		<div class="both Estilo2"> </div>
		<p onclick="javascript: return valida_archivos(0)" class="boton"> SUBIR ARCHIVO(S)</p>					
    </fieldset>

    <fieldset>
   		<legend>LISTA DE DOCUMENTOS ESCANEADOS</legend>
		<ul>
                <div align="left">
                  <?php
    			for($d = 0; $d < count($escaneos); $d++ ){ ?>
                </div>
                <li class="escaneo<?php echo  $escaneos[$d]['id'];?>">
                  <div align="left">
                    <input type="checkbox" name="qdocumento" id="qdocumento" value="<?php echo  $escaneos[$d]['id'];?>" /> 
                    <?php echo  $escaneos[$d]['nombre'];?> </div>
                </li> 
                <div align="left">
                  <?php				
            }?>
                        </div>
		</ul>
    </fieldset>

    <div id="images" style="margin-left:40px">
        <div class="bottom"><img src="public_root/imgs/arrow_ltr.png" border="0" height="13"/> Para eliminar un archivo activa su(s) respectiva(s) casilla de verificacion y haz cilck en [ <span onclick="javascript: delete_escaneo()" >ELIMINAR <img src="public_root/imgs/b_deltbl.png" width="16" height="16" /></span>].</div>
    </div>
</form>

<?php 
}

function EscaneaGuardar(){ 		 
	
	$doc = new Documento ($_GET['id']);
	$targetPath = $_SERVER['DOCUMENT_ROOT']."/archivo/Escaneado_completo/".$doc->getCodigo()."/";

	if ( !is_dir ($targetPath))
		mkdir(str_replace('//','/',$targetPath), 0755);
		
	$keys = array_keys($_FILES['doc']);
	$destino = "../archivo/Escaneado_completo/".$doc->getCodigo()."/";
	echo  "<div id='error'>";

    for($u=0; $u < count($keys); $u++){
		if(!empty($_FILES['doc']['name'][$u])){
			if(!move_uploaded_file($_FILES['doc']['tmp_name'][$u], $destino.$_FILES['doc']['name'][$u])){
				echo "ocurrio error al subir archivo " . $_FILES['doc']['name'][$u] ;			 				
			}else{
				$sql = " INSERT INTO documentos_escaneados VALUES( '', '".$_GET['id']."','".$_FILES['doc']['name'][$u]."','".date("Y-m-d H:i:s")."') ";
				$query = new Consulta($sql);
				echo "se subio el archivo <b>" . $_FILES['doc']['name'][$u] . "</b> satisfactoriamente <br>" ;	
			}	
		}
	}
	echo "</div>"; 	
    }

 function EscaneaUpdate($id){

    $num_folio	= $_POST["num_folio"];
	$remit1		= $_POST["remit1"]; 
	$tipo		= $_POST["tipo"]; 
	$num_doc2	= $_POST["num_doc2"]; 
	$FechaSol2	= $_POST["FechaSol2"]; 
	$refe		= $_POST["refe"]; 
	$anexo		= $_POST["anexo"]; 
	$destino	= $_POST["destino"]; 
	$observ1	= $_POST["observ1"]; 
 	$var_estado = 1;
    
    $actualiza  = " UPDATE documentos SET
    				documentos.id_tipo_documento='".$tipo."',
					documentos.`numero_documento`='".$num_doc2."',
					documentos.`referencia_documento`='".$refe."',
					documentos.`anexo_documento`='".$anexo."',
					documentos.`numero_folio_documento`='".$num_folio."',
					documentos.`fecha_documento`='".$FechaSol2."',
					documentos.`observacion_documento`='".$observ1."',
					documentos.`id_remitente`='".$remit1."'
                    Where documentos.id_documento='".$id."'";

    $actua = new Consulta($actualiza);

}

function EscaneaListado($ide){	  

    if($ide=='')
		$ide='LE';
	else{
		if($ide=='LT')
			$where="";
		else{
			if($ide!='LE') //No escogio Listar por no escaneados
				$where=" WHERE estados.id_estado='".$ide."' ";
		}	
	} 
	
	if($ide=='LE'){
		/*
		QUERY ESCANEADOS
		
		$sql = "SELECT *
				FROM
				documentos AS d
				Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
				Inner Join estados AS e ON d.id_estado = e.id_estado
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				Inner Join documentos_escaneados ON documentos_escaneados.id_documento = d.id_documento
				group by d.id_documento
				ORDER BY d.id_documento DESC";	*/
				
		$sql = "SELECT *
				FROM
				documentos AS d
				Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
				Inner Join estados AS e ON d.id_estado = e.id_estado
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				WHERE
				d.id_documento NOT IN  
				(SELECT distinct id_documento from documentos_escaneados)
				AND d.id_estado <> 12 AND d.id_estado <> 11
				group by d.id_documento
				ORDER BY d.id_documento DESC";		
	}else{			
		$sql = "SELECT * FROM documentos
				Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
				Inner Join estados ON estados.id_estado = documentos.id_estado
				Inner Join tipos_documento ON tipos_documento.id_tipo_documento = 				
				documentos.id_tipo_documento 	
				".$where."	
				ORDER BY documentos.id_documento DESC";
	}
    $query = new Consulta($sql); ?>

<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
		<td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">
					<th width="10%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="26%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th width="31%" class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="13%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th class="ui-widget-header ui-th-column grid_resize">Ubicacion  Original</th>
				</tr>			
			</table>
		</td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">			
    <?php
		while($row_reg=$query->ConsultaVerRegistro()){
    	$id = $row_reg[0];
        $estado = $row_reg["id_estado"];
		$tooltip = "";
		if(!empty($row_reg['asunto_documento']))
			$tooltip="title ='".$row_reg['asunto_documento']."' class='tip'";
    ?>
    <tr class="ui-widget-content1 jqgrow <? echo ($estado==12)?"Estilo2 fila_finalizada":"Estilo2";?>">
    <td <?=$tooltip?> width="10%">
		<div align="center">
		<?php
			$cod = $row_reg[1];
	
			if($estado != 12&&$estado != 11){?>
				<a href="escaneo_acceso_registro.php?opcion=edit&id=<?php echo $id?>">
					<?=$cod?>
				</a>
				<?
			}
			else{
			   echo $cod;
			}
		  ?>
		  </div>      </td>
      <td width="26%"><input size="50" value="<?php echo $row_reg[nombre_remitente]?>"/></td>
      <td width="31%"><input size="45" value="<?php echo $row_reg[3]?>"/></td> 
      <td  width="13%">
	  	<div align="center">
	  	  <input type="text" style="text-align:center; width:100%" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?>" size="3"/>
	  	</div>
	  </td>
      <td align="center"  width="6%">
	  	<div align="center">
			<input type="text" style="text-align:center; width:100%" value="<?=$row_reg['abrev_nombre_estado']?>" size="3"/>        
      	</div>
		</td> <?php   

        $sql_ultimo = " SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
						FROM `historial_documentos` AS `hd`
						WHERE hd.id_documento='".$row_reg['id_documento']."'
						GROUP BY `hd`.`id_documento`";

		$query_ultimo = new Consulta($sql_ultimo);		
		$ultimo = $query_ultimo->ConsultaVerRegistro();

		$sql_data=" SELECT hd.id_documento,a.nombre_area, a.abve_nombre_area FROM historial_documentos AS hd 
            		Inner Join areas AS a ON a.id_area = hd.id_area
            		where hd.id_historial_documento='".$ultimo['ultimo']."'";

        $query_data=new Consulta($sql_data);
		$data=$query_data->ConsultaVerRegistro();		

		$sql_usu = "SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`, `ha`.`id_documento`
    				FROM
    				`historial_atencion` AS `ha`
    				WHERE
                    ha.original_historial_atencion =  '1' and
    				ha.id_documento='".$row_reg['id_documento']."'
    				GROUP BY
    				`ha`.`id_documento`	";

		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu ="SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
    			FROM
    			`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";

				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro(); ?>
		<td>
			<div align="center">
			<?
			$documento = new Documento($row_reg['id_documento']);
			?>
			<input name="text4" type="text" value="<?=$documento->UltimaUbicacionReporte()?>" />
			</div>
		  </td>
    	</tr>
		<?php }?>
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
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
	}

	$sql_reg = "SELECT * FROM documentos d
                Inner Join remitentes ON remitentes.id_remitente = d.id_remitente
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
					<th width="10%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="26%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th width="31%" class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="13%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th class="ui-widget-header ui-th-column grid_resize">Ubicacion  Original</th>
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
				$tooltip="title ='".$row_reg['asunto_documento']."' class='tip'";
        ?>
        <tr class="ui-widget-content1 jqgrow <? echo ($estado==12)?"Estilo2 fila_finalizada":"Estilo2";?>">
            <td <?=$tooltip?> width="10%">
				<div align="center">
				<?php
					$cod = $row_reg[1];
					if($estado != 12){?>
						<a href="escaneo_acceso_registro.php?opcion=edit&id=<?php echo $id?>">
						<?=$cod?></a>
					 <? }
					else{
						echo $cod;
					}
				?>
				</div>
			</td>
            <td width="26%">
				<input size="48"  value="<?=$row_reg[nombre_remitente]?>"/>
			</td>
            <td width="31%">
				<input size="43" value="<?=$row_reg[3]?>"/>
			</td>
            <td width="13%">
				<input name="text" type="text" style="text-align:center; width:100%" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?>" size="3"/>
			</td>
            <td width="6%" align="center">
				<input name="text2" type="text" style="text-align:center; width:100%" value="<?=$row_reg['abrev_nombre_estado']?>" size="3"/>
			</td>
            <?php

                $sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
                            FROM
                            `historial_documentos` AS `hd`
                            where hd.id_documento='".$row_reg['id_documento']."'
                            GROUP BY
                            `hd`.`id_documento`";

                $query_ultimo=new Consulta($sql_ultimo);
                $ultimo=$query_ultimo->ConsultaVerRegistro();
                
                $sql_data=" SELECT hd.id_documento,
                            a.nombre_area,
                            a.abve_nombre_area
                            FROM historial_documentos AS hd
                            Inner Join areas AS a ON a.id_area = hd.id_area
                            where hd.id_historial_documento='".$ultimo['ultimo']."'";

                $query_data=new Consulta($sql_data);
                $data=$query_data->ConsultaVerRegistro();

                $sql_usu = "SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`,
                            `ha`.`id_documento`
                            FROM `historial_atencion` AS `ha`
                            WHERE ha.original_historial_atencion =  '1' and
                            ha.id_documento='".$row_reg['id_documento']."'
                            GROUP BY
                            `ha`.`id_documento`	";

                $query_usu=new Consulta($sql_usu);
                $usu=$query_usu->ConsultaVerRegistro();

                $susu= "SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
                        FROM `historial_atencion` AS `ha`
                        Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
                        Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
                        WHERE
                        `ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";

                $qusu=new Consulta($susu);
				$u=$qusu->ConsultaVerRegistro();
            ?>
            <td><div align="center">
              <?
			$documento = new Documento($row_reg['id_documento']);
			?>
              <input name="text42" type="text" value="<?=$documento->UltimaUbicacionReporte()?>" />
            </div></td>
        </tr>
        <? }
        ?>
		 </table>
		</td>
	</tr>
</table>
</div>
<?
}

}
?>