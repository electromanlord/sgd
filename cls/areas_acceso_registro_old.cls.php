<?php

class Registro {

function RegistraListado($ide ='',$dias = false){	

if ($ide==''){
	
	//if($_SESSION['session'][6]){
		//$where = "WHERE	(d.id_estado = '3' OR d.id_estado = '13' OR d.id_estado = '12' OR d.id_estado = '11')";
	//}else{
	$where 	= "WHERE
				(((d.id_estado = '4' OR d.id_estado = '12' OR d.id_estado = '11' 
				OR d.id_estado = '6' OR d.id_estado = '16' OR d.id_estado = '17' 
				OR d.id_estado = '18' OR d.id_estado = '3' OR d.id_estado = '13' 
				OR d.id_estado = '14' OR d.id_estado = '15')";
	//}
	
	$sql_reg = "SELECT
                    hd.id_documento as id,
                    d.fecha_registro_documento as fecha,
                    d.asunto_documento as asunto,
                    d.codigo_documento as codigo,
                    td.nombre_tipo_documento as tipo,
                    r.nombre_remitente as remitente,
                    hd.original_historial_documento as categoria,
                    d.numero_documento as numero,
                    d.id_estado as id_estado,
                    e.abrev_nombre_estado as estado
				FROM
                    historial_documentos AS hd
				INNER JOIN 
                    documentos AS d ON d.id_documento = hd.id_documento
				INNER JOIN 
                    estados AS e ON e.id_estado = d.id_estado
				LEFT JOIN 
                    remitentes AS r ON r.id_remitente = d.id_remitente
				LEFT JOIN 
                    tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				$where
                    AND hd.original_historial_documento = 1) OR hd.original_historial_documento = 2 )
                    AND hd.id_area = '".$_SESSION['session'][5]."'
				
                UNION
				
                SELECT
                    ha.id_documento as id,
                    d.fecha_registro_documento as fecha,
                    d.asunto_documento as asunto,
                    d.codigo_documento as codigo,
                    td.nombre_tipo_documento as tipo,
                    r.nombre_remitente as remitente,
                    ha.original_historial_atencion as categoria,
                    d.numero_documento as numero,
                    d.id_estado as id_estado,
                    e.abrev_nombre_estado as estado	
				FROM
                    historial_atencion AS ha
				INNER JOIN 
                    documentos AS d ON ha.id_documento = d.id_documento
				INNER JOIN 
                    estados AS e ON d.id_estado = e.id_estado
				LEFT JOIN 
                    tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				LEFT JOIN 
                    remitentes AS r ON d.id_remitente = r.id_remitente
				$where
				AND 
                    ha.original_historial_atencion = 1) OR ha.original_historial_atencion = 2 )
                AND(
                    (ha.id_area = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=0) OR
                    (ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=1) OR
                    (ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=2)
				)
				ORDER BY 1 DESC, 7 ASC";
						
   $query_reg=new Consulta($sql_reg);	
   #echo $query_reg->SQL;
}
else{
	
	if($ide=="LT")
		$where="";
	else{
		$where="AND d.id_estado = $ide ";
	}
	
    $sql_reg = "SELECT
				hd.id_documento as id,
				d.fecha_registro_documento as fecha,
				d.asunto_documento as asunto,
				d.codigo_documento as codigo,
				td.nombre_tipo_documento as tipo,
				r.nombre_remitente as remitente,
				hd.original_historial_documento as categoria,
				d.numero_documento as numero,
				d.id_estado as id_estado,
				e.abrev_nombre_estado as estado
				FROM
				historial_documentos AS hd
				Inner Join documentos AS d ON d.id_documento = hd.id_documento
				Inner Join estados AS e ON e.id_estado = d.id_estado
				LEFT Join remitentes AS r ON r.id_remitente = d.id_remitente
				LEFT Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				WHERE 
				hd.id_area = '".$_SESSION['session'][5]."' 
				".$where."
				UNION
				SELECT
				ha.id_documento as id,				
				d.fecha_registro_documento as fecha,
				d.asunto_documento as asunto,
				d.codigo_documento as codigo,
				td.nombre_tipo_documento as tipo,
				r.nombre_remitente as remitente,
				ha.original_historial_atencion as categoria,
				d.numero_documento as numero,
				d.id_estado as id_estado,
				e.abrev_nombre_estado as estado
				FROM
				historial_atencion AS ha
				Inner Join documentos AS d ON ha.id_documento = d.id_documento
				Inner Join estados AS e ON d.id_estado = e.id_estado
				LEFT Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				LEFT Join remitentes AS r ON d.id_remitente = r.id_remitente
				WHERE
				(
				(ha.id_area = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=0) OR
				(ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=1) OR
                (ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=2)
				) ".$where."
				ORDER BY id DESC,categoria";
	
    $query_reg=new Consulta($sql_reg);

}//Fin de if ide

	?>
<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
		<td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize">
					<th width="16%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="26%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th width="26%" class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="13%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="5%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
                    <?if($dias){?>
                    <th width="4%" class="ui-widget-header ui-th-column grid_resize">Dias</th>
                    <?}else{?>
                    <th width="4%" class="ui-widget-header ui-th-column grid_resize">Cat</th>
                    <?}?>
					<th class="ui-widget-header ui-th-column grid_resize">Ubicacion</th>
				</tr>			
			</table>
		</td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">
    <? 			
		$codigo="";
		while($row_reg=$query_reg->ConsultaVerRegistro()){

		$ids=$row_reg["id"];		
		$estado=$row_reg["id_estado"];
		$anterior = $codigo;
		$codigo=$row_reg["codigo"];
		$cat = $row_reg["categoria"];       
		$loTengo = true;
		
		if($codigo!=$anterior){		
		if($cat == 1){
			if(($estado == 11||$estado == 14||$estado == 15) && $ide == ""){ //No es un filtro y esta archivado			
				$loTengo = false; // Para no mostrarlo
			}else{
				if($_SESSION['session'][6]&&$estado!=3&&$estado!=13&&$ide == ""){
					$loTengo = false;
				}elseif(!$_SESSION['session'][6]&&($estado==3||$estado==13)&&$ide == ""){
					$loTengo = false;
				}elseif($estado==3){
					//Si es un despachado no pregunto si esta en mi area
					$doc  = new Documento($ids);
					if($doc->DespachoAreaTieneOriginal())
						$loTengo = true;
					else
						$loTengo = false;
				}
				elseif($estado==4||$estado==13||$estado==12||$estado==6||$estado==16||$estado==17){
					
					$total = 10; //Un numero Mayor a 0 para que tambien lo usen los otros estados
					if($estado==16||$estado==17){ 
						$total = 0;
						$sql_hist ="SELECT Count(ha.id_historial_atencion) AS total						
									FROM
									historial_atencion AS ha
									WHERE
									ha.id_documento =  $ids";
									
						$query_hist = new Consulta($sql_hist);		
						$row_hist = $query_hist->ConsultaVerRegistro();
						$total = $row_hist["total"];			
					}	
							
					//Si tiene historial se muestra en el area donde se quedo el ultimo original
					if($total>0){
						$loTengo = false;
						$sql_destino="SELECT ha.id_historial_atencion AS ultimo, 
										ha.tipo_historial_atencion,
										ha.id_area,
										ha.id_area_destino
										FROM
										historial_atencion AS ha
										WHERE
										ha.id_documento=".$ids." AND
										ha.original_historial_atencion=1
										ORDER BY
										`ha`.`id_historial_atencion` DESC
										LIMIT 1";
								
						$query_destino = new Consulta($sql_destino);		
						$row_destino = $query_destino->ConsultaVerRegistro();
					
						if($row_destino["tipo_historial_atencion"]>0&&$row_destino["id_area_destino"]==$_SESSION['session'][5])
							$loTengo = true;
						elseif($row_destino["tipo_historial_atencion"]==0){
							if($row_destino["id_area"]==$_SESSION['session'][5])
								$loTengo = true;
						}//Fin elseif			
						
					}//Fin if			
					
					//Si no tiene historial anteriormente fue despacho asi que se muestra siempre ($loTengo estaba en true)
					
				}//Fin if Verificacion de estados
			} //Fin if estado = 11
		}//Fin if cat
		else{
			
			$sql_arch = "SELECT
						a.id_documento
						FROM
						archivo_copia AS a
						WHERE
						a.id_documento =  $ids AND
						a.id_area_duenia = ".$_SESSION['session'][5]." 
						AND
						a.id_usuario_duenio = 0";
	
			$query_arch = new Consulta($sql_arch);
				
			if($query_arch->NumeroRegistros()>0){				
				if($ide == "LT" || $ide == 11)
					$loTengo=true;
				else
					$loTengo=false;
			}
			
        }
		//Pregunto si mi area lo tiene
		if($loTengo){
		
		$clase = "Estilo7";						
		if($estado==12){
			$clase = "Estilo7 fila_finalizada";
		}else{
			$dias_faltantes = ObtenerDiasFaltantes($ids, date('d/m/Y',strtotime($row_reg['fecha'])));
			if($dias_faltantes <=0)
				$clase = "Estilo7 fila_peligro";
			elseif($dias_faltantes > 0 && $dias_faltantes <= 3)
				$clase = "Estilo7 fila_urgente";
			else	
				$clase = "Estilo7 fila_baja";
		}	
		
		$tooltip_asunto="";
		
		if(!empty($row_reg['asunto'])){
			$tooltip_asunto="title ='".$row_reg['asunto']."' class='tip'";
		}		
		?>
		
    <tr class="ui-widget-content1 jqgrow <?=$clase?>">		
		<td width="16%" <?=$tooltip_asunto?>>
			<div align="center">			  
				<a href="areas_acceso_registro.php?opcion=despachar&amp;ids=<?=$ids?>&amp;cat=<?=$row_reg['categoria']?>">
			  		<?=$row_reg['codigo']?>
			  	</a>		  
	        </div>
		</td>
 		<td width="26%"><input name="Input3" value="<?=$row_reg['remitente']?>" style="width:100%"/></td>
 		<td width="26%"><input value="<?=$row_reg['numero']?>" style="width:100%"/></td>
		<td width="13%"> <div align="center">
	        <input type="text" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha']))?>" style="text-align:center;width:100%;"/>
		</div></td>
		<?php
			$tooltip="";
			if($estado==5){
				$sql_des = "SELECT
							d.id_devuelto AS ultimo,
							d.descripcion AS descripcion
							FROM
							devuelto AS d
							WHERE
							d.id_documento =  '".$ids."'
							ORDER BY
							d.id_devuelto DESC
							LIMIT 1";
				
				$query_des = new Consulta($sql_des);		
				$row_des = $query_des->ConsultaVerRegistro();		
				
				if(!empty($row_des['descripcion'])){
					$tooltip="title ='".$row_des['descripcion']."' class='tip'";
				}						
			}
			elseif($estado==11){

				$sql_des = "SELECT
							a.id_archivo AS ultimo,
							a.descripcion AS descripcion
							FROM
							archivo AS a
							WHERE
							a.id_documento =  '".$ids."'
							ORDER BY
							a.id_archivo DESC
							LIMIT 1";
				
				$query_des = new Consulta($sql_des);		
				$row_des = $query_des->ConsultaVerRegistro();
				
				if(!empty($row_des['descripcion'])){
					$tooltip="title ='".$row_des['descripcion']."' class='tip'";
				}
				
			}elseif($estado==16||$estado==17){
				$doc_d_a = new Documento($row_reg['id']);				
				$tooltip="title ='".$doc_d_a->ObtenerDescripcionUltimoOriginal($estado)."' class='tip'";
			}
			
			
		?>
				
		<td align="center" <? if($cat == 1) echo $tooltip;?> width="5%">
			<div align="center">
			<? if($cat == 1){?>
			  <? if($estado==11){?>
			  <a href="javascript:QuitarArchivado(<?=$row_reg['id']?>)" id="desarchivar">
			    <?=$row_reg['estado'];?>
			  </a>
		        <? }elseif($estado==12){?>
			  <a href="javascript:QuitarFinalizar(<?=$row_reg['id']?>)" id="nofinalizar">
			  	<?=$row_reg['estado'];?>
			  </a>
		        <? }
				else{?>				
			     <input type="text" value="<?=$row_reg['estado'];?>" size="3" style="text-align:center; width:100%"/>
		        <? }?>				    
			<? }else{
				$doc = new Documento();
				$estado = $doc->ObtenerEstadoCopia($ids,1); 
				?>				
				<input type="text" value="<?=$estado?>" size="3" style="text-align:center; width:100%"/>
			<? }?>
			</div>
			</td>
		<?if ($dias){?>
            <td align="center" width="4%">
                <input type="text" value="<?=$dias_faltantes?>" style="text-align:center;width:30px;" />		
            </td>
        <?}else{?>
            <td align="center" width="4%">
                <div align="center">
                <input type="text" value="<? echo ($row_reg['categoria']=='1')?'O':'C' ?>" style=" width:20PX; text-align:center"/>
                </div>		
            </td>
        <?}?>    
      <?php

		$sql_data=" SELECT a.abve_nombre_area
					FROM
					areas AS a 
					WHERE
					a.id_area = '".$_SESSION['session'][5]."' ";
					
		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();
	?>
      <td>
	 <?  
		if($row_reg['categoria']!=1){
			$doc = new Documento();
			$ubic = $doc->ObtenerUbicacionCopia($ids,1);
			$area = $data['abve_nombre_area'];
			$tooltip_ubic = "";
			
			if(count($ubic)>0){
				$cont = 0;
				foreach($ubic as $u){
					if($cont==0)
						$tooltip_ubic = $tooltip_ubic."$area - ".$u["destino"];
					else
						$tooltip_ubic = $tooltip_ubic."<br/>$area - ".$u["destino"];
					$cont++;
				} 
				if(count($ubic)==1){
				?>
				<input type="text" value="<?=$tooltip_ubic?>" style="width:95%"/>	
				<? }else{?>
				<input type="text" value="<?=$area."- Varios"?>" style="width:95%" title ='<?=$tooltip_ubic?>' class='tip'/>
		<?		}
			}else{
		?>
			<input type="text" value="<?=$area?>" style="width:95%"/>	
		<?	} 
		} 
		elseif($row_reg['id_estado']=='3'||$row_reg['id_estado']=='12'||$row_reg['id_estado']=='16'||$row_reg['id_estado']=='17'){			
	?>
			<input type="text" value="<?=$data['abve_nombre_area']?>" />        	
        <? }elseif($row_reg['id_estado']=='13'){
			$sql_area_derivado= "SELECT ha.id_historial_atencion AS ultimo, 
								a.id_area AS area,
								a.abve_nombre_area AS abreviatura	
								FROM
								historial_atencion AS ha
								Inner Join areas AS a ON a.id_area = ha.id_area_destino
								WHERE
								ha.id_documento=".$ids." and
								ha.tipo_historial_atencion = 1 and
								ha.original_historial_atencion = 1
								ORDER BY
								ultimo DESC
								LIMIT 1";
						
			$query_area_derivado = new Consulta($sql_area_derivado);		
			$row_area_derivado = $query_area_derivado->ConsultaVerRegistro();
			?>
        <input name="text" type="text" value="<?=$row_area_derivado["abreviatura"]?>" />
        <? }elseif($row_reg['id_estado']=='4'||$row_reg['id_estado']=='18'){		
				
				$sql_usu = "SELECT
							ha.id_historial_atencion AS ultimo,
							a.abve_nombre_area AS abreviatura,
							u.login_usuario
							FROM
							historial_atencion AS ha
							Inner Join areas AS a ON a.id_area = ha.id_area
							LEFT Join usuarios AS u ON u.id_usuario = ha.id_usuario_destino
							WHERE
							ha.id_documento=$ids and
							(ha.tipo_historial_atencion = 0 
							OR ha.tipo_historial_atencion = 5 
							)and
							ha.original_historial_atencion = 1
							ORDER BY
							ultimo DESC
							LIMIT 1";
		
				$query_usu=new Consulta($sql_usu);		
				$usu=$query_usu->ConsultaVerRegistro();
				?>
				<input type="text" value="<?=$usu['abreviatura'].' - '.$usu['login_usuario']?>" />
			<?	
			}elseif($row_reg['id_estado']=='6'){
			
				$sql_usu = "SELECT
							a.abve_nombre_area AS abreviatura,
							u.login_usuario AS login_usuario
							FROM
							borradores_respuesta AS b
							Inner Join usuarios AS u ON u.id_usuario = b.id_destino
							Inner Join areas AS a ON a.id_area = u.id_area 							
							WHERE
							b.id_documento =  '".$ids."' AND
							b.categoria =  '1'
							ORDER BY
							b.fecha_borrador_respuesta DESC
							LIMIT 1";
							
				$query_usu=new Consulta($sql_usu);		
				$usu=$query_usu->ConsultaVerRegistro();
			?>
				<input type="text" value="<?=$usu['abreviatura'].' - '.$usu['login_usuario']?>" />
			<? } elseif($row_reg['id_estado']=='11'){
			
				$sql_usu = "SELECT
							ar.abve_nombre_area
							FROM
							archivo AS a
							Inner Join areas AS ar ON a.id_area = ar.id_area
							WHERE
							a.id_documento =  '".$ids."'
							ORDER BY a.id_archivo DESC
							LIMIT 1";
							
				$query_usu=new Consulta($sql_usu);		
				$usu=$query_usu->ConsultaVerRegistro();
			?>
				<input type="text" value="<?=$usu['abve_nombre_area']?>" />
			<? }	 	 	
	?>	 </td>
    </tr>
	<?	
	     } //Fin de if categoria = 1
	 	}//Fin de if anterior = codigo
	 } //Fin de While
	 ?>
		 </table>
		</td>
	</tr>
</table>
</div>

<?php }//Fin de Funcion

function Busqueda($campo, $valor){	

	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND r.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
	}

	$sql_reg = "SELECT  				
				hd.id_documento as id,
				d.fecha_registro_documento as fecha,
				d.asunto_documento as asunto,
				d.codigo_documento as codigo,
				td.nombre_tipo_documento as tipo,
				r.nombre_remitente as remitente,
				hd.original_historial_documento as categoria,
				d.numero_documento as numero,
				d.id_estado as id_estado,
				e.abrev_nombre_estado as estado
				FROM
				historial_documentos AS hd
				Inner Join documentos AS d ON d.id_documento = hd.id_documento
				Inner Join estados AS e ON e.id_estado = d.id_estado
				Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento				
				WHERE
				(d.id_estado >  '1') $where AND
				hd.id_area = ".$_SESSION['session'][5]."
				UNION
				SELECT
				ha.id_documento as id,				
				d.fecha_registro_documento as fecha,
				d.asunto_documento as asunto,
				d.codigo_documento as codigo,
				td.nombre_tipo_documento as tipo,
				r.nombre_remitente as remitente,
				ha.original_historial_atencion as categoria,
				d.numero_documento as numero,
				d.id_estado as id_estado,
				e.abrev_nombre_estado as estado
				FROM
				historial_atencion AS ha
				Inner Join documentos AS d ON ha.id_documento = d.id_documento
				Inner Join estados AS e ON d.id_estado = e.id_estado
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				Inner Join remitentes AS r ON d.id_remitente = r.id_remitente
				WHERE
				(
                (ha.id_area = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=0) OR
				(ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion>0)
                ) 
				AND (d.id_estado >  '1') $where
				ORDER BY codigo DESC, categoria ";
	
	$query_reg = new Consulta($sql_reg);	
	
?>

<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	<tr>
		<td>
			<table width="100%" class="ui-jqgrid-htable" cellpadding="0" cellspacing="0">
				<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">
					<th width="16%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
					<th width="26%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
					<th width="26%" class="ui-widget-header ui-th-column grid_resize">Documento</th>
					<th width="13%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
					<th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
					<th width="4%" class="ui-widget-header ui-th-column grid_resize">Cat</th>
					<th class="ui-widget-header ui-th-column grid_resize">Ubicacion</th>
				</tr>			
			</table>
		</td>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">
		<?php 
			$codigo = "";
			
			while($row_reg=$query_reg->ConsultaVerRegistro()){
									
				$ids=$row_reg['id'];
				$anterior = $codigo;
				$codigo=$row_reg["codigo"];
				$cat = $row_reg['categoria'];
				if($codigo!=$anterior){
				
        		$estado=$row_reg["id_estado"];        
				$clase = "Estilo7";						
				if($estado==12){
					$clase = "Estilo7 fila_finalizada";
				}else{
					$dias_faltantes = ObtenerDiasFaltantes($ids, date('d/m/Y',strtotime($row_reg['fecha'])));
					if($dias_faltantes <=0)
						$clase = "Estilo7 fila_peligro";
					elseif($dias_faltantes > 0 && $dias_faltantes <= 3)
						$clase = "Estilo7 fila_urgente";
					else	
						$clase = "Estilo7 fila_baja";
				}	
				
				$tooltip_asunto="";
				
				if(!empty($row_reg['asunto'])){
					$tooltip_asunto="title ='".$row_reg['asunto']."' class='tip'";
				}		
			?>
			
		<tr class="ui-widget-content1 jqgrow <?=$clase?>">
		<td width="16%" <?=$tooltip_asunto?>>
			<div align="center">
				<a href="areas_acceso_registro.php?opcion=despachar&ids=<?=$ids?>&cat=<?=$row_reg['categoria']?>">
			  		<?=$row_reg['codigo']?>
			  	</a>		  			    
	        </div>
		</td>  
		<td width="26%"><input name="Input" value="<?=$row_reg['remitente']?>" size="35"/></td>
		<td width="26%"><input name="Input2" value="<?=$row_reg['numero']?>" size="40"/></td>
		<td width="13%"> 
		  	<input type="text" value="<?=date('d/m/Y H:i',strtotime($row_reg['fecha']))?>" style="text-align:center;width:100%;"/>		  </td>
		  <?php
			$tooltip="";
			if($row_reg['id_estado']==5){
				$sql_des = "SELECT
							d.id_devuelto AS ultimo,
							d.descripcion AS descripcion
							FROM
							devuelto AS d
							WHERE
							d.id_documento =  '".$ids."'
							ORDER BY
							d.id_devuelto DESC
							LIMIT 1";
				
				$query_des = new Consulta($sql_des);		
				$row_des = $query_des->ConsultaVerRegistro();	
				if(!empty($row_des['descripcion'])){
					$tooltip="title ='".$row_des['descripcion']."' class='tip'";
				}							
			}
			elseif($row_reg['id_estado']==11){

				$sql_des = "SELECT
							a.id_archivo AS ultimo,
							a.descripcion AS descripcion
							FROM
							archivo AS a
							WHERE
							a.id_documento =  '".$ids."'
							ORDER BY
							a.id_archivo DESC
							LIMIT 1";
				
				$query_des = new Consulta($sql_des);		
				$row_des = $query_des->ConsultaVerRegistro();			
			
				if(!empty($row_des['descripcion'])){
					$tooltip="title ='".$row_des['descripcion']."' class='tip'";
				}
			
			}elseif($estado==16||$estado==17){
				$doc_d_a = new Documento($row_reg['id']);				
				$tooltip="title ='".$doc_d_a->ObtenerDescripcionUltimoOriginal($estado)."' class='tip'";
			}
			
			
		?>
				
		<td width="6%" align="center" <?=$tooltip?>>
			<div align="center">
			  <? if($estado==11){?>
			  <a href="javascript:QuitarArchivado(<?=$row_reg['id']?>)" id="desarchivar">
			    <?=$row_reg['estado'];?>
			    </a>
		        <? }elseif($estado==12){?>
			  <a href="javascript:QuitarFinalizar(<?=$row_reg['id']?>)" id="nofinalizar">
			    <?=$row_reg['estado'];?>
			    </a>
		        <? }
				else{?>
		        <input name="text3" type="text" style="text-align:center" value="<?=$row_reg['estado'];?>" size="3" maxlength="3"/>
		        <? }?>		
		    </div></td>
		<td align="center" width="4%"><div align="center">
		  <input name="text2" type="text" style=" width:20PX; text-align:center" value="<? echo ($row_reg['categoria']=='1')?'O':'C' ?>"/>
		  </div></td>
		  <?php
			$sql_data ="SELECT `a`.`abve_nombre_area`
						FROM `areas` AS `a` 
						WHERE
						`a`.`id_area` =  '".$_SESSION['session'][5]."' ";

			$query_data=new Consulta($sql_data);		
			$data=$query_data->ConsultaVerRegistro();
			
			$sql_usu = "SELECT 
						Max(`ha`.`id_historial_atencion`) AS `ultimo`, 			
						`ha`.`id_documento`, 
						ha.original_historial_atencion, 
						`usuarios`.`id_area`  
						FROM  
						`historial_atencion` AS `ha` 
						Inner Join `usuarios` ON `usuarios`.`id_usuario` = `ha`.`id_usuario_destino` 
						WHERE 
						ha.id_documento='".$row_reg['id']."' and 
						usuarios.id_area =  '".$_SESSION['session'][5]."'
						GROUP BY
						`ha`.`id_historial_atencion`	";

		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu = "SELECT `u`.`login_usuario`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."'  ";

				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro();
?>

      <td>
	<? 
		if($row_reg['categoria']!=1){
			$doc = new Documento();
			$ubic = $doc->ObtenerUbicacionCopia($ids,1);
			$area = $data['abve_nombre_area'];
			$tooltip_ubic = "";
			
			if(count($ubic)>0){
				$cont = 0;
				foreach($ubic as $u){
					if($cont==0)
						$tooltip_ubic = $tooltip_ubic."$area - ".$u["destino"];
					else
						$tooltip_ubic = $tooltip_ubic."<br/>$area - ".$u["destino"];
					$cont++;
				} 
				if(count($ubic)==1){
				?>
				<input type="text" value="<?=$tooltip_ubic?>" style="width:95%"/>	
				<? }else{?>
				<input type="text" value="<?=$area."- Varios"?>" style="width:95%" title ='<?=$tooltip_ubic?>' class='tip'/>
		<?		}
			}else{
		?>
			<input type="text" value="<?=$area?>" style="width:95%"/>	
		<?	} 
		} 
		elseif($row_reg['id_estado']=='3'||$row_reg['id_estado']=='12'||$row_reg['id_estado']=='16'||$row_reg['id_estado']=='17'){			
	?>
			<input type="text" value="<?=$data['abve_nombre_area']?>" />        	
    <? }elseif($row_reg['id_estado']=='13'){
			$sql_area_derivado= "SELECT ha.id_historial_atencion AS ultimo, 
								a.id_area AS area,
								a.abve_nombre_area AS abreviatura	
								FROM
								historial_atencion AS ha
								Inner Join areas AS a ON a.id_area = ha.id_area_destino
								WHERE
								ha.id_documento=".$ids." and
								ha.tipo_historial_atencion = 1 and
								ha.original_historial_atencion = 1
								ORDER BY
								ultimo DESC
								LIMIT 1";
						
			$query_area_derivado = new Consulta($sql_area_derivado);		
			$row_area_derivado = $query_area_derivado->ConsultaVerRegistro();
			?>
			<input type="text" value="<?=$row_area_derivado["abreviatura"]?>" />					
			<?					
			}elseif($row_reg['id_estado']=='4'){		
				
				$sql_usu = "SELECT ha.id_historial_atencion AS ultimo, 
							a.abve_nombre_area AS abreviatura,
							u.login_usuario AS login_usuario	
							FROM
							historial_atencion AS ha
							Inner Join areas AS a ON a.id_area = ha.id_area 
							Inner Join usuarios AS u ON u.id_usuario = ha.id_usuario_destino
							WHERE
							ha.id_documento=".$ids." and
							ha.tipo_historial_atencion = 0 and
							ha.original_historial_atencion = 1
							ORDER BY
							ultimo DESC
							LIMIT 1";
							
				$query_usu=new Consulta($sql_usu);		
				$usu=$query_usu->ConsultaVerRegistro();
			?>
			<input type="text" value="<?=$usu['abreviatura'].' - '.$usu['login_usuario']?>" />					
			<?	
			}elseif($row_reg['id_estado']=='6'){
			
				$sql_usu = "SELECT
							a.abve_nombre_area AS abreviatura,
							u.login_usuario AS login_usuario
							FROM
							borradores_respuesta AS b
							Inner Join usuarios AS u ON u.id_usuario = b.id_destino
							Inner Join areas AS a ON a.id_area = u.id_area 							
							WHERE
							b.id_documento =  '".$ids."' AND
							b.categoria =  '1'
							ORDER BY
							b.fecha_borrador_respuesta DESC
							LIMIT 1";
							
				$query_usu=new Consulta($sql_usu);		
				$usu=$query_usu->ConsultaVerRegistro();
			?>
			<input type="text" value="<?=$usu['abreviatura'].' - '.$usu['login_usuario']?>" />					
			<? } elseif($row_reg['id_estado']=='11'){
			
				$sql_usu = "SELECT
							ar.abve_nombre_area
							FROM
							archivo AS a
							Inner Join areas AS ar ON a.id_area = ar.id_area
							WHERE
							a.id_documento =  '".$ids."'
							ORDER BY a.id_archivo DESC
							LIMIT 1";
							
				$query_usu=new Consulta($sql_usu);		
				$usu=$query_usu->ConsultaVerRegistro();
			?>
				<input type="text" value="<?=$usu['abve_nombre_area']?>" />
			<? }	 	 	
		?></td>
		</tr><? 
		}
		}?>
		 </table>
		</td>
	</tr>
</table>
</div>

          <? }

function ConsultarDocumento($ids){

	$sql_resumen="SELECT *
				FROM
				documentos
                LEFT Join remitentes ON remitentes.id_remitente = documentos.id_remitente
				LEFT Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento
				WHERE
				documentos.id_documento = '".$ids."'";
				
				$query_resumen=new Consulta($sql_resumen);
				$row_resumen=$query_resumen->ConsultaVerRegistro(); 
				
	$estado = $row_resumen["id_estado"];

	//Esta finalizado
	if($estado==12){		
		
		$doc = new Documento ($ids);
		$escaneados = $doc->ObtenerTodosEscaneados();
        $usu_actual = new Usuario($_SESSION['session'][0]);
        $tipos = $usu_actual->ObtenerTiposDocumento();

		$sql_sal = "SELECT * 
					FROM saludo_despedida 
					WHERE tipo = 0
					ORDER BY descripcion";
					
		$query_sal = new Consulta($sql_sal);	
		
		$sql_des = "SELECT * 
					FROM saludo_despedida
					WHERE tipo = 1 
					ORDER BY descripcion ";
					
		$query_des = new Consulta($sql_des);	

        $sql = "SELECT id_documento_finalizado
                FROM documento_finalizado
                WHERE id_documento = ".$ids;

        $query_f = new Consulta($sql);
        $row_f = $query_f->VerRegistro();

        $finalizado = new DocumentoFinalizado($row_f["id_documento_finalizado"]);
		$referencia = $finalizado->getReferencia();
		$destinatario = $finalizado->getDestinatario();
	//Hacemos un post al popup	
	?>	
	
				
	<div class="contenedor">	
	<fieldset id="primer_fin" class="item_fin">
		<legend>Documento Finalizado</legend>
		<form id="form_documento_fin_imprimir" method="post" action="documento_finalizado.php" target="popup">
		<input type="hidden" name="id" id="id" value="<?=$ids?>">		
		<div id="opciones_doc_fin" style="float:right; margin:-28px -12px 0px 0px; background-color:#FFFFFF">
			<span style="margin-left:2px;margin-right:2px;"><img src="public_root/imgs/file_preview.png" id="vista"/></span>
			<span style="margin-left:2px;margin-right:2px;"><img src="public_root/imgs/add_file.png" id="agregar_doc_fin"/></span>
			<span style="margin-left:2px;margin-right:2px;"><img src="public_root/imgs/b_drop.png" id="elimina_doc_fin"/></span>
		</div>			   
	    <table id="imprimir_documento_finalizado" border="0" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="13%" height="24" class="Estilo22"><div align="left">Asunto</div></td>
            <td class="Estilo22" width="3%"><div align="center">:</div></td>
            <td>
				<div align="left">
					<input name="asunto" type="text" id="asunto" size="76" value="<?=$finalizado->getAsunto()?>"/>
				</div>			</td>
            <td>&nbsp;</td>
          </tr>
          <? if(count($referencia)>0){
				for($i = 0; $i < count($referencia); $i++){
			?>
          <tr>
            <td class="Estilo22" height="24"><? if($i==0){?>
                <div align="left">Referencia</div>
              <? }?></td>
            <td class="Estilo22"><div align="center">:</div></td>
            <td colspan="2"><div align="left">
                <input name="referencia[]" type="text" id="referencia" size="76" value="<?=$referencia[$i]["descripcion"]?>"/>
            </div></td>
          </tr>
          <?  }
		   }
		  ?>          
          <tr>
		  	<td width="13%" height="24" class="Estilo22"><div align="left">Destinatario</div></td>
            <td class="Estilo22" width="3%"><div align="center">:</div></td>
            <td width="88%">
				<div class="contenedor">
				<? if(count($destinatario)>0){
					$primero = false;
					for($i = 0; $i < count($destinatario); $i++){						
						$primero = ($i == 0)?true:false;
		 		?>
				<table cellpadding="0" cellspacing="0" width="100%" class="item"  <? echo ($primero)?'id="primero"':''?>>
                <tr>                                    
                  <td width="63%" height="24"><div align="left">
                      <input name="destinatario[]" type="text" id="destinatario" size="76" value="<?=$destinatario[$i]["descripcion"]?>"/>
                  </div></td>
                  <td width="6%" class="Estilo22"><? if($i==0){?>
                      <div align="left" class="no_se_copia">Cargo</div>
                  <? }?></td>
                  <td width="2%" class="Estilo22"><div align="center">:</div></td>
                  <td width="29%">
				  	<input name="cargo[]" type="text" id="cargo" size="26" value="<?=$destinatario[$i]["cargo"]?>"/>
                  	<img src="public_root/imgs/edit_remove.png" width="16" height="16" onclick="quita_item_borrador(this)"/>				</td>
                  </tr>
            </table>			
			 <?  }
		  	}
		 	?>
			</div>			</td>
            <td width="3%">
				<div align="center">
					<img src="public_root/imgs/edit_add.png" width="16" height="16" onclick="agrega_item_borrador(this)"/>				</div>			</td>
          </tr>         
          <tr>
            <td class="Estilo22" height="24"><div align="left">Tipo de Plantilla</div></td>
            <td class="Estilo22"><div align="center">:</div></td>
            <td colspan="2"><div align="left">
                <select name="tipo" class="tipo_doc" id="tipo" style="width:150px">
                  <option value="">---Tipo de Documento---</option>
                  <?
                    $ttip = count($tipos);
                    for($i=0;$i<$ttip;$i++){?>
                  <option value="<?=$tipos[$i]['id']?>">
                  <?=$tipos[$i]['nombre']?>
                  </option>
                  <? }?>
                </select>
            </div></td>
          </tr>
          <tr>
            <td class="Estilo22" height="24"><div align="left">Despedida</div></td>
            <td class="Estilo22"><div align="center">:</div></td>
            <td colspan="2"><div align="left">
                <select name="despedida" id="despedida" style="width:400px">
                  <option value="">---Despedida del Documento---</option>
                  <?
        			while($row_des=$query_des->ConsultaVerRegistro()){
				?>
                  <option value="<?=$row_des[0]?>">
                  <?=$row_des[1]?>
                  </option>
                  <? }?>
                </select>
            </div></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
    </table>
		</form>		
	</fieldset>	
	</div>
	
	<fieldset>
			<legend>Documentos Adjuntos</legend>	    	
	        <table width="100%" align="center" id="lista_escaneados">
              <tr>
			  	<th width="5%" style="border-left-color:#6699cc">N&ordm;</th>
                <th width="23%">Origen</th>
                <th width="22%">Destino</th>
				<th width="23%">Accion</th>
                <th width="22%">Documento</th>
				<th width="5%" style="border-right-color:#6699cc"><div align="center">
				  <input type="checkbox" name="checkbox" value="checkbox" />
			    </div></th>
              </tr>
			  <?
			  $tam = count($escaneados);

			  for($i = 0 ; $i < $tam ; $i++){
			  
			  	$escaneado = $escaneados[$i];
				
				$accion = $escaneado["accion"];
				$nombre = $escaneado["nombre"];
				
				if($escaneado["tipo"]==2){
					$usuario = $escaneado["usuario"];
					$a_destino = $escaneado["area_destino"];
					$origen = $usuario->getNombreCompleto();
					$destino = $a_destino->getNombre();					
				}elseif($escaneado["tipo"]==1){					
					$origen = $escaneado["usuario"];
					$destino = $escaneado["usuario_destino"];
				}else{
					$usuario = $escaneado["usuario"];
					$u_destino = $escaneado["usuario_destino"];
					$origen = $usuario->getNombreCompleto();
					$destino = $u_destino->getNombreCompleto();
				}
				
				if($escaneado["tipo"]==2||$escaneado["tipo"]==4)//Justidicacion por propuestas 
					$ref = "Justificados/".rawurlencode($nombre);
				elseif($escaneado["tipo"]==0) //De Borradores
					$ref = "Archivados/".rawurlencode($nombre);
				else{
					if(is_null($escaneado['fecha']))//El propio documento
					$ref = "Escaneo/".rawurlencode($nombre);
				else
					$ref = "../sad/Escaneado_completo/".$row_resumen[1]."/".rawurlencode($nombre);
				}
			  
			  ?>
              <tr>
                <td width="5%" style="padding:0px;"><div align="center">
                  <?=($i+1)?>
                </div></td>
                <td width="23%"><div align="left">
                  <?=$origen?>
                </div></td>
                <td width="22%"><div align="left">
                  <?=$destino?>
                </div></td>
                <td width="23%"><div align="left">
                  <?=$accion?>
                </div></td>
                <td><div align="left"><a href="<?=$ref?>" target="_blank">
                <?=$nombre?>
                </a></div></td>
                <td width="5%"><div align="center"><input type="checkbox" name="checkbox2" value="checkbox" /></div></td>
              </tr>
			  <? }?>
            </table>
	        <p>&nbsp;</p>
		</fieldset>
	
    <?
	}else{
		
		if($row_resumen['id_estado']==3){//Viene de despacho
			$edi="SELECT
				`td`.`asunto_documento`,
				`td`.`observacion_documento`,
				`td`.`id_prioridad`,
				`hd`.`observacion_historial_documento`,
				`td`.`id_documento`,
				`hd`.`original_historial_documento`
				FROM
				`documentos` AS `td`
				Inner Join `historial_documentos` AS `hd` ON `hd`.`id_documento` = `td`.`id_documento`
				WHERE
				`hd`.`id_documento` =  '".$ids."' AND 
				`hd`.id_area=".$_SESSION['session'][5];
				
		}else{//Viene de una derivacion o despacho de area (es original o copia del original)
				
			$edi="SELECT
				`td`.`asunto_documento`,
				`td`.`observacion_documento`,
				`td`.`id_prioridad`,
				`hd`.`observacion_historial_documento`,
				`td`.`id_documento`,
				`hd`.`original_historial_documento`
				FROM
				`documentos` AS `td`
				Inner Join `historial_documentos` AS `hd` ON `hd`.`id_documento` = `td`.`id_documento`
				WHERE
				`hd`.`id_documento` =  '".$ids."' AND 
				`hd`.original_historial_documento=1";
		}

			$qedit=new Consulta($edi);	
			$row_edit=$qedit->ConsultaVerRegistro();

			$_POST['idhd']=$row_edit['id_historial_documento']; 

			$escaneo = "SELECT * 
						from documentos_escaneados de
						where de.id_documento = ".$ids;
						
			$qescaneo = new Consulta($escaneo);					
		?>
     <fieldset>
  <legend class="Estilo9">DATOS DEL DOCUMENTO</legend>

  <table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" width="100%">
    <tbody>    
      <tr>
      <td width="20%" class="Estilo22"><div align="left">Nro. Registro</div></td>
      <td width="2%" class="Estilo22"><div align="center">:</div></td>
      <td width="38%" class="Estilo23"><div align="left">
        <?=$row_resumen[1]?>
      </div></td>
      <td width="15%" class="Estilo22"><div align="left">Categor&iacute;a</div></td>
      <td width="2%" class="Estilo22"><div align="center">:</div></td>
      <td class="Estilo23">
	  	<div align="left"><?=($_REQUEST["cat"]==1)?"Original":"Copia"?>
		</div>	  </td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Remitente</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23">          
        <div align="left"><?=$row_resumen['nombre_remitente']?></div></td>
        <td class="Estilo22"><div align="left">Nro de Folios</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23" ><div align="left">
          <?=$row_resumen['numero_folio_documento']?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Nro. Documento</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><div align="left">
          <?=$row_resumen['numero_documento']?>
        </div></td>
      
        <td class="Estilo22"><div align="left">Fecha de Doc</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><div align="left"><?php echo date('d/m/Y',strtotime($row_resumen['fecha_documento']))?></div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Tipo de Documento</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4" class="Estilo23"><div align="left">
          <?=$row_resumen['nombre_tipo_documento']?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Referencia</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4" class="Estilo23"><div align="left"><?=$row_resumen['referencia_documento']?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Anexos</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4" class="Estilo23"><div align="left">
          <?=$row_resumen['anexo_documento']?>
        </div></td>
      </tr>
      <tr>
          <td bgcolor="#ffffff" class="Estilo22"><div align="left">Documento Digitalizado</div></td>
          <td bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
        <td colspan="4"><div align="left"><span class="Estilo23">
          <?
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
          <?=$id?>
          <? if($row_edit['original_historial_documento']=='1'){ ?>
          <? } else { "null" ;}?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Fecha y Hora de Registro</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4" class="Estilo23"><div align="left"><?php echo date('d/m/Y H:I:s',strtotime($row_resumen["fecha_registro_documento"]))?></div>   
       </td>
      </tr>
    </tbody>
</table>
<p align="left"><a href="javascript:verDetalleDoc()" id = "control" class="v" >Ver Detalles </a></p>
<div id="detalle_documento" style="display:none">
<table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" width="100%">
<tbody>          
      <tr>
        <td width="20%" class="Estilo22"><div align="left">Asunto</div></td>
        <td width="2%" class="Estilo22"><div align="center">:</div></td>
        <td colspan="38%"><div align="left">
          <textarea name="textfield2" id="textfield2" rows="2" cols="100" class="disabled" disabled="disabled"><?=$row_edit[0]?>
        </textarea>
        </div></td>
      </tr>
      <tr>
        <td width="20%" class="Estilo22"><div align="left">Observaci&oacute;n Registro</div></td>
        <td width="2%" class="Estilo22"><div align="center">:</div></td>
        <td colspan="5"><div align="left">
          <textarea name="textarea2" id="textarea2" rows="2" cols="100" class="disabled" disabled="disabled"><?=$row_edit[1]?>
        </textarea>
        </div></td>
      </tr>
      <tr>
      <td class="Estilo22"><div align="left">Observaci&oacute;n Despacho</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="5"><div align="left">
        <textarea name="textarea3" id="textarea3" rows="2" cols="100" class="disabled" disabled="disabled"><?=$row_edit[3]?>
        </textarea>
      </div></td>
      </tr>
      <tr>
      <td class="Estilo22"><div align="left">Prioridad</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="5"><div align="left"><span class="Estilo23">
        <?
	  
	  $sql_prioridad = "SELECT prioridades.id_prioridad, 
	  					prioridades.nombre_prioridad, 
						prioridades.tiempo_horas_respuesta_prioridad/24 AS dias,
						prioridades.tiempo_horas_respuesta_prioridad AS horas
						FROM prioridades 
						where 
						prioridades.id_prioridad='".$row_resumen["id_prioridad"]."' 
						ORDER BY prioridades.id_prioridad ASC";
    	
		$query_prioridad=new Consulta($sql_prioridad);
		$row_prioridad=$query_prioridad->ConsultaVerRegistro();
		
		$documento_p = new Documento($ids);		
		?>		
        <?=$row_prioridad["nombre_prioridad"]?>        
        </span>		
      </div></td>
	  </tr>
      <tr>
        <td class="Estilo22"><div align="left">Tiempo de Respuesta</div></td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
        <td width="19" class="Estilo23">
		  <div align="left">
		    <?=number_format($row_prioridad["dias"],0)?>
        </div></td>
        <td width="296" class="Estilo23"><div align="left"><? echo "dias";?></div></td>
        <td width="131" class="Estilo23"><div align="left">Fecha Estimada de Respuesta</div></td>
        <td width="11" class="Estilo23"><div align="center">:</div></td>
        <td width="148" class="Estilo23"><div id="fecha_respuesta" align="left">
          <?=$documento_p->setFechaRespuesta($row_prioridad["horas"])?>
        </div></td>
      </tr>
</tbody>
</table>
</div>
</fieldset>

<form name="form_despacho_area" id = "form_despacho_area" method="post"  action="" >  

	<?
		$td="SELECT
			td.id_documento,
			td.observacion_historial_atencion
			FROM
			historial_atencion AS td
			WHERE
			td.id_documento =  '".$ids."'";
		
		$qtd=new Consulta($td);	
		$row_td=$qtd->ConsultaVerRegistro();
	?>

<fieldset>
  <legend class="Estilo9">ESTABLECER DESTINO Y ACCION A REALIZAR</legend>
  <table align="center" border="0" class="formularios">
  	<tbody>
    	<tr>
			<td height="12" class="Estilo21" >&nbsp;</td>
			<td class="Estilo22" >&nbsp;</td>
        	<td>&nbsp;</td>
          	<td><input type="hidden" value="<?=$ids?>" name="id_documento" id="id_documento"/></td>
          	<td width="41%" class="Estilo22" ><div align="left">Observaci&oacute;n Area:</div></td>
			<td  bgcolor="#ffffff" class="Estilo21">&nbsp;</td>
			<td  bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
			<td bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
			<td width="5%" rowspan="3" bgcolor="#ffffff" class="Estilo22">
				<input type="hidden" value="<?=$_REQUEST['cat']?>" name="cat" id="cat"/>
			</td>
        </tr>
		<tr>
        	<td height="12" class="Estilo21" ><div align="center">(*)</div></td>
        	<td width="6%" class="Estilo22" ><div align="left">Acc&iacute;on</div></td>
        	<td><div align="center">:</div></td>
        	<td width="33%" ><div align="left">
        	  <?php
				$acciones = new Acciones();
				if($_REQUEST['cat']==1){
					if($_SESSION['session'][6])
						$accions = $acciones->getAcciones(4,$_SESSION['session'][0]);
					else
						$accions = $acciones->getAcciones(1,$_SESSION['session'][0]);
				}else{
					$accions = $acciones->getAcciones(5,$_SESSION['session'][0]);
				}
				$tacciones = sizeof($accions);				
		?>
          <select name="cboaccion2" style="width:200px" id="accion_despacho">
            <option value="">--Seleccione Accion--</option>
            <?php
				for($u = 0; $u < $tacciones; $u++){ 
				?>
           		<option value="<?php echo $accions[$u]['id']?>"><?php echo $accions[$u]['nombre']?> </option>
            <?php
			}?>
          </select>
        </div>
		</td>
        <td width="41%" rowspan="2" class="Estilo22" >
			<textarea name="textarea4" id="comentario" rows="3" cols="55"></textarea>
		</td>
        <td width="3%"  bgcolor="#ffffff" class="Estilo21"><div align="center">(*)</div></td>      
	    <td width="3%"  bgcolor="#ffffff" class="Estilo22"><div align="center">
        <input name="radiobutton" value="1" type="radio" id="original" />      
      	</div>	  	</td>
      	<td width="6%" bgcolor="#ffffff" class="Estilo22"><div align="left">Original</div></td>
   	  </tr>
      <tr>
        <td height="13" class="Estilo21" ><div align="center">(*)</div></td>
        <td width="6%" class="Estilo22" ><div align="left">Pase A</div></td>
        <td ><div align="center">:</div></td>
        <td><div align="left">
          <?
		
    		$sql_areas="SELECT * 
							FROM usuarios 
							where usuarios.id_area='".$_SESSION['session'][5]."'
							AND estado_usuario = 1";
						
	    	$query_areas=new Consulta($sql_areas);
		?>
          <input name="hidden" type="hidden" id="idArea" value="<?=$_SESSION['session'][5]?>"/>
          <select name="destino" id="destino" style="width:200px" class="usuarios">
			<option value="" selected="selected">--- Seleccione un Usuario---</option>
            <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
            <option value="<? echo $row_areas[0]?>">
				<? echo $row_areas[nombre_usuario]." "?><? echo $row_areas[apellidos_usuario]?>
			</option>
            <? } ?>
          </select>
          <? if($_REQUEST["cat"]!=2){?>
          <a href="javascript:void(0);" id="cambiar_destino" style="margin-left:5px;">Areas</a>
          <? }?>
        </div>
		</td>
        <td  bgcolor="#ffffff" class="Estilo21">&nbsp;</td>            
        <td width="5%"  bgcolor="#ffffff" class="Estilo22">
			<div align="center"><input name="radiobutton" value="2" type="radio" id="copia"/></div>
		</td>
		<td width="6%" bgcolor="#ffffff" class="Estilo22"><div align="left">Copia</div></td>
	</tr>      
    <tr>    
        <td width="2%" height="26" class="Estilo21">&nbsp;</td>
        <td width="6%" height="26" class="Estilo22" >&nbsp;</td>
        <td width="1%" height="26" >&nbsp;</td>
        <td>&nbsp;</td>
        <td width="41%" class="Estilo22" >&nbsp;</td>
        <td colspan="4" align="center">          
          	<div align="right">
            	<input type="button" name="CargarLista" id="cargar_accion_areas" value="Cargar Lista" class="boton"/>
        	</div>
		</td>
      </tr>
    </tbody>
  </table>
  </fieldset>
</form>
<div id="question" style="display:none; cursor: default"> 
	<p class="Estilo22">&iquest;Est&aacute; seguro que desea enviar un <span id="conf_categoria" style="font-weight:bold; color: #D3455A">a</span> del documento a <span id="conf_usuario" style="font-weight:bold; color:#D3455A">b</span>?</p>
	<p class="Estilo22">
		<input type="button" id="yes_d_a" value="Si" class="boton"/> 
		<input type="button" id="no_d_a" value="No" class="boton"/> 
	</p>
</div>
<?	
	$doc=new Documento($ids);
	$tengoOriginal = $doc->DespachoAreaTieneOriginal();
    $estado = $doc->getEstado();
	
	if($deshabilita_todo){?>
		<script>
			javascript:deshabilita_todo_da();
		</script>
	<? }
	elseif($_REQUEST["cat"]==2){
	?> <script>
			javascript:deshabilitado();
			javascript:habilita_copia();
		</script>	
	<?
	}elseif(!$tengoOriginal){ 
	?> 
		<script>
		javascript:deshabilitado();
		javascript:habilita_copia();
		javascript:quita_archivar();				
		</script>
	<? }else{?>
		<script>
		javascript:habilitado();
		javascript:deshabilita_copia();
		</script>
	<?
	}
    ?>
        <script>javascript:accion_por_defecto_area(<?=$estado->getId()?>);</script>
    <?
	Registro::DespacharListarDestino($ids);
}
?>
<? }

/**********************************************************/
////REEMPLAZAR
/**********************************************************/
function DespacharListarDestino($ids)  {  

	$doc = new Documento($ids);
	$estado = $doc->getestado();
	$deshabilita_todo = false;
	
	if($estado->getId()==11&&$_REQUEST["cat"]==1)
		$deshabilita_todo = true;
	elseif($_REQUEST["cat"]==2){	
		$sql_arch  =   "SELECT
						a.id_documento
						FROM
						archivo_copia AS a
						WHERE
						a.id_documento =  $ids AND
						a.id_area_duenia = ".$_SESSION['session'][5]." 
						AND
						a.id_usuario_duenio = 0";
	
			$query_arch = new Consulta($sql_arch);
			
			if($query_arch->NumeroRegistros()>0){
				$deshabilita_todo = true;								
			}else{
				$deshabilita_todo = false;
			}
			
	}
		
	
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" id="tabla_despacho" >
	<tr bgcolor="#6699CC" class="Estilo7">
		<td width="5%" height="25" ><div align="center" class="msgok1"><strong>Nro</strong></div></td>
		<td width="21%"><div align="center" class="msgok1"><strong>ORIGEN</strong></div></td>
		<td width="24%"><div align="center" class="msgok1"><strong>DESTINO</strong></div></td>
		<td width="13%"><div align="center" class="msgok1"><strong>Fecha y Hora </strong></div></td>
		<td width="13%"><div align="center" class="msgok1"><strong>Acci&oacute;n</strong></div></td>
	  <td width="10%"><div align="center" class="msgok1"><strong>Categor&iacute;a</strong></div></td>
	  <td width="14%"><div align="center" class="msgok1"><strong>Opciones </strong></div></td>
	</tr>

	<?

	echo $sql_origen = "SELECT
						hd.id_historial_documento AS id,
						'6' AS tipo_historial,
						null AS id_usuario_destino,
						hd.id_area AS id_area_destino,
						null AS id_usuario,
						null AS id_area,
						DATE_FORMAT(hd.fecha_historial_documento, '%Y-%m-%d %H:%i') AS fecha,				 
						hd.original_historial_documento AS categoria,
						hd.observacion_historial_documento AS observacion,
						a.nombre_accion AS nombre_accion
						FROM
						historial_documentos AS hd
						Inner Join accion AS a ON a.id_accion = hd.id_accion					
						WHERE
						hd.id_documento =  '".$ids."'
						UNION
						SELECT
						th.id_historial_atencion AS id,
						th.tipo_historial_atencion AS tipo_historial,
						th.id_usuario_destino AS id_usuario_destino,
						th.id_area_destino AS id_area_destino,
						th.id_usuario AS id_usuario,
						th.id_area AS id_area,
						DATE_FORMAT(th.fecha_historial_atencion, '%Y-%m-%d %H:%i') AS fecha,
						th.original_historial_atencion AS categoria,
						th.observacion_historial_atencion AS observacion,
						tac.nombre_accion AS nombre_accion
						FROM
						historial_atencion AS th
						LEFT Join accion AS tac ON tac.id_accion = th.id_accion
						WHERE
						th.id_documento ='".$ids."'
						AND (th.tipo_historial_atencion = 0 OR th.tipo_historial_atencion = 1
						OR th.tipo_historial_atencion = 2 OR th.tipo_historial_atencion = 4)
						UNION
						SELECT
						b.id_borrador_respuesta AS id,
						'3' AS tipo_historial,
						b.id_destino AS id_usuario_destino,
						null AS id_area_destino,
						b.id_usuario AS id_usuario,
						b.id_area  AS id_area,
						DATE_FORMAT(b.fecha_borrador_respuesta, '%Y-%m-%d %H:%i') AS fecha,
						b.categoria AS categoria,
						b.descripcion_borrador_respuesta AS observacion,
						accion.nombre_accion AS nombre_accion
						FROM
						borradores_respuesta AS b
						LEFT Join accion ON accion.id_accion = b.id_accion
						WHERE
						b.id_documento ='".$ids."'
						UNION
						SELECT
						d.id_devuelto,
						'7' AS tipo_historial,
						null AS id_usuario_destino,
						null AS id_area_destino,
						d.id_usuario AS usuario,
						d.id_area AS area,
						DATE_FORMAT(d.fecha_devolucion, '%Y-%m-%d %H:%i') AS fecha,
						'1' AS categoria,
						d.descripcion,
						'DEVOLVER A DESPACHO' AS nombre_accion
						FROM
						devuelto AS d
						WHERE
						d.id_documento ='".$ids."'
						UNION
						SELECT
						a.id_archivo,
						'8' AS tipo_historial,
						null AS id_usuario_destino,
						a.id_area AS id_area_destino,
						a.id_usuario AS usuario,
						a.id_area AS area,
						DATE_FORMAT(a.fecha_archivo, '%Y-%m-%d %H:%i') AS fecha,
						'1' AS categoria,
						a.descripcion,
						'ARCHIVAR' AS nombre_accion
						FROM
						archivo AS a
						WHERE
						a.id_documento ='".$ids."'
						ORDER BY
						fecha ASC,
						categoria ASC";
		   			
                $query_origen = new Consulta($sql_origen);
				
				$query = new Consulta($sql_origen);
				$ultimo_original=0;				
				$contador = 1;
								
				while($row=$query->ConsultaVerRegistro()){//Recorremos para saber cual es el �ltimo original
									
					if($row["categoria"]==1&&$contador!=1){
						$ultimo_original=$contador; 								
					}	
					$contador++;	
				}	
					
				$hayOriginal = 0;
				$cont=0;
											
				while($row_org=$query_origen->ConsultaVerRegistro()){
                    $noEsMio = '';
					$idp=$row_org[0];

                 if($row_org["tipo_historial"]==0){ //Es de AREA a usuarios del area
					$id_ori = new Area($row_org['id_area']);
                    $origen = $id_ori->getNombre();
					$id_dest= new Usuario($row_org['id_usuario_destino']);
                    $destino = $id_dest->getNombreCompleto();
                 }elseif($row_org["tipo_historial"]==1){//Es de AREA a AREA									 
                    $id_ori = new Area($row_org['id_area']);
                    $id_des = new Area($row_org['id_area_destino']);
                    $origen = $id_ori->getNombre();
                    $destino = $id_des->getNombre();
                 }elseif($row_org["tipo_historial"]==2){//Es de USUARIO a AREA
                    $id_ori = new Usuario($row_org['id_usuario']);
                    $id_des = new Area($row_org['id_area_destino']);
                    $origen = $id_ori->getNombreCompleto();
                    $destino = $id_des->getNombre();
                 }elseif($row_org["tipo_historial"]==3||$row_org["tipo_historial"]==4||$row_org["tipo_historial"]==5){//Es de USUARIO a USUARIO
                    $id_ori = new Usuario($row_org['id_usuario']);
                    $id_des = new Usuario($row_org['id_usuario_destino']);
                    $origen = $id_ori->getNombreCompleto();
                    $destino = $id_des->getNombreCompleto();
                 }elseif($row_org["tipo_historial"]==6){//Es de MESA a AREA                    
                    $id_des = new Area($row_org['id_area_destino']);
                    $origen = "DESPACHO GENERAL";
                    $destino = $id_des->getNombre();
                 }elseif($row_org["tipo_historial"]==7){//Es de AREA a MESA                    
                    $id_ori = new Area($row_org['id_area']);
                    $origen = $id_ori->getNombre();
                    $destino = "DESPACHO GENERAL";
                 }elseif($row_org["tipo_historial"]==8){//Es de AREA a ARCHIVO                    
                    $id_ori = new Area($row_org['id_area']);
                    $origen = $id_ori->getNombre();
                    $destino = $origen;
                 }
				 					 
				 //Solo se muestra como historial(no lo hizo el area actual)
				 if($row_org["id_area"]!=$_SESSION['session'][5])
				 	$noEsMio = "class = 'historial'";
	  ?>	
		
      <tr <?=$noEsMio?>>
        <td><input type="hidden" value="<?=$idp?>"><div align="center"><?=++$cont?></div></td>
        <td><?=$origen?></td>
        <td><?=$destino?></td>
        <td><div align="center"><?=date('d/m/Y H:i',strtotime($row_org['fecha']))?></div></td>
        <td><div align="center"><?=$row_org['nombre_accion']?></div></td>
        <td>
			<div align="center"><? echo ($row_org['categoria']=='1')?'ORIGINAL':'COPIA';?></div>        </td>
        <td>
            <div align="center">				
			<?
			//Eliminar
			if($deshabilita_todo){?>
			 	<img src="public_root/imgs/b_drop_d.png" alt="Eliminar" width="16" height="16" border="0">
			<? }elseif(($row_org['id_area']==$_SESSION['session'][5]||$row_org['id_usuario']==$_SESSION['session'][0]||$row_org['id_area_destino']==$_SESSION['session'][5])&&$row_org["categoria"]==2){?>
				<a href="areas_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&idp=<?=$idp?>&cat=<?=$_REQUEST["cat"]?>&th=<?=$row_org["tipo_historial"]?>"><img src="public_root/imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0"></a>
		<? }
			elseif(($row_org['id_area']==$_SESSION['session'][5]||$row_org['id_usuario']==$_SESSION['session'][0]||$row_org['id_area_destino']==$_SESSION['session'][5])&&$ultimo_original==$cont){//Yo lo envie lo puedo eliminar
		?>
				<a href="areas_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&idp=<?=$idp?>&cat=<?=$_REQUEST["cat"]?>&th=<?=$row_org["tipo_historial"]?>"><img src="public_root/imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0"></a>
		<? }
			elseif($row_org['id_usuario']==$_SESSION['session'][0]&&$row_org["tipo_historial"]==3&&$ultimo_original==$cont){?>
				<a href="areas_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&idp=<?=$idp?>&cat=<?=$_REQUEST["cat"]?>&th=<?=$row_org["tipo_historial"]?>"><img src="public_root/imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0"></a>
		<? }
			else{ ?>
				<img src="public_root/imgs/b_drop_d.png" alt="Eliminar" width="16" height="16" border="0">
		<? }//Fin del if de eliminar
		?>            	
			<?
				$observacion = trim($row_org['observacion']);
                if(!empty($observacion)){?>
                   <a href="javascript:VerDetalleObservacion(<?php echo $cont ?>)">
                     <img src="public_root/imgs/b_search.png" width="16" height="16" border="0" alt="Ver Detalle" />                   </a>
                <?
                }else{
                ?>
                   <img src="public_root/imgs/b_search_d.png" width="16" height="16" border="0" alt="Ver Detalle" />
                <? }				
				?>				
            	<?
                $tipo=$row_org['tipo_historial'];
				if($tipo==2||$tipo==3||$tipo==4||$tipo==8){					
					$doc_archivo=new Documento($ids);
					$archivo = array();
                    if($tipo==4)
                        $archivo = $doc_archivo->obtenerJustificacionesEscaneadas($idp);					
					elseif($tipo==2)
						$archivo = $doc_archivo->obtenerAprobacionesEscaneadas($idp);
					elseif($tipo==8)
						$archivo = $doc_archivo->obtenerArchivadosEscaneados($idp);		
                    else
                        $archivo = $doc_archivo->obtenerBorradoresEscaneados($idp);
														
    	            if(count($archivo)>0){						
					?>
                   	<a href="javascript:void(0)" onclick="ver_mas_adjuntos($(this))">
                     		<img src="public_root/imgs/attach.png" width="16" height="16" border="0" alt="Ver Archivo" />	                    </a>
					<div id="doc_adjuntos<?php echo ($cont) ?>" class="doc_adjuntos">
						<p>Documentos Adjuntos : </p>
						<? 													
							for($i = 0; $i < count($archivo); $i++){								
								$ruta = "";
								if($tipo==2){
									$ruta = "Aprobacion/".rawurlencode($archivo[$i]);
									$nombre = $archivo[$i];
								}
								elseif($tipo==4){
									$ruta = "Justificados/".rawurlencode($archivo[$i]);
									$nombre = $archivo[$i];
								}
								elseif($tipo==8){													
									if($archivo[$i]["tipo"]==1)
										$ruta = "Archivados_Respuesta/".rawurlencode($archivo[$i]["nombre"]);
									else
										$ruta = "Adjuntos_Archivo/".rawurlencode($archivo[$i]["nombre"]);
										
									$nombre = $archivo[$i]["nombre"];									
								}	
								else{
									$ruta = "Borradores/".rawurlencode($archivo[$i]);
									$nombre = $archivo[$i];
								}
							?>
								<p><a href="<?=$ruta?>"  target="_blank"><?=$nombre?></a></p>
						<? }?>
					</div>		
                <?
                	}
                   else{
                ?>
                   <img src="public_root/imgs/attach_d.png" width="16" height="16" border="0" alt="Ver Archivo"/>
                <? }
				}else{?>
                    <img src="public_root/imgs/attach_d.png" width="16" height="16" border="0" alt="Ver Archivo"/>
                <? }
                ////Fin del if para file.gif
				?>
			</div>        </td>
      </tr>
	  <tr>
		<td colspan="7" align="center">
			<div style="display:none; text-align:left;" id="detalle_observacion<?=$cont?>">
					<?=$observacion?>
			</div>
		</td>
	</tr>
     <? } //Fin del While ?>
  </tr>    
</table> 

 <?	
}
/**********************************************************/
////FIN REEMPLAZAR
/**********************************************************/


function DespacharGuardarDestino($ids) {

    $nombre=$_POST['nombre'];
	 $fecha_actual = time();
	 $fecha=date("Y-m-d H:i:s",$fecha_actual);
    $destino=$_POST['destino'];
    $radiobutton=$_POST['radiobutton'];
    $cboaccion2=$_POST['cboaccion2'];
    $cboprioridad=$_POST['cboprioridad'];
    $textarea4=$_POST['textarea4'];    
    $idhd=$_POST['idhd'];
    $usu=$_SESSION['session'][0];
    $idarea= $_SESSION['session'][5];
    $usuario = new Usuario($usu);
    $id_area_destino = "'null'"; //Para una DA (area-usuario) como es de mi area
                                 // No se coloca area destino
	$ubicacion = "";
	
    $sqlrep =  "SELECT id_documento_reporte as id
                FROM documentos_reporte
                WHERE id_documento=$ids";

    $qrep=new Consulta($sqlrep);
    $rowrep=$qrep->VerRegistro();
	
	$documento = new Documento($ids);      
    $accion = new Accion($cboaccion2);
	
	//Obtenermos el ultimo estado
	//$documento = new Documento($ids);
	//$c_estado = $documento->getEstado();
	
    if($usuario->esMiArea($destino)){ //Es un Despacho de Area (Area a Usuario)
        $tipo = 0;
        $estado='4';
        $a_origen = new Area($_SESSION['session'][5]);
        $origen = $a_origen->getNombre();
        $u_destino = new Usuario($destino);
        $n_destino = $u_destino->getNombreCompleto();
		//if($radiobutton==1){
            $ubicacion = $a_origen->getAbreviatura()."-".$u_destino->getLogin();
			$est='DA';
            $esta = 'DESPACHADO DE AREA';
		//}else{	
			//$est = $c_estado->getId();
			//$esta = $c_estado->getNombre();
		//}

    }
    else{    //Es una Derivacion de Documento (Area a Area)
        $usuario_destino = new Usuario($destino);
        $area_destino = $usuario_destino->getArea();
        $id_area_destino = $area_destino->getId();
        $a_origen = new Area($_SESSION['session'][5]);
		$origen = $a_origen->getNombre();
		$n_destino = $area_destino->getNombre();
		$destino = '';//Para que no guarde en historial de atencion
        $tipo = 1;
        $estado='13';
        			
		//if($radiobutton==1){
			$ubicacion = $area_destino->getAbreviatura();
			$est='DR';
            $esta = 'DOCUMENTO DERIVADO';
		//}else{
			//$est = $c_estado->getId();
			//$esta = $c_estado->getNombre();
		//}
    }  

    $guades="Insert INTO
             historial_atencion values('',
			 '".$idhd."',
			 '".$ids."',
			 '".$destino."',
			 ".$id_area_destino.",
			 '".$idarea."',
			 '".$fecha."',
			 '".$radiobutton."',
			 '".$cboaccion2."',
			 '".$usu."',
			 '".$estado."',
			 '".$textarea4."',
			 $tipo)";
			 
    $qdest=new Consulta($guades);

    //Para el reporte
    $sha_r  =  "Insert INTO
                movimientos values('',
                '".$rowrep['id']."',
                '".$qdest->NuevoId()."',
                '".$origen."',
                '".$n_destino."',
                '".$accion->getNombre()."',
                '".$radiobutton."',
                '".$usuario->getLogin()."',
                '".$textarea4."',
                '".$fecha."',								
                '".$esta."',
				'".$ubicacion."',
                '2')";
	
    $qha_r =new Consulta($sha_r);


	if(	$radiobutton=='1'){//Si es el original el que esta moviendose
        
        $s_act = "Update documentos SET id_estado='".$estado."'
                  WHERE id_documento='".$ids."'";

        $qact=new Consulta($s_act);

		$s_ma = "Update documentos_reporte SET estado='".$est."',
                 ubicacion='".$ubicacion."'
                 WHERE id_documento='".$ids."'";
		$sma=new Consulta($s_ma);
    }

}

/**********************************************************/
////REEMPLAZAR
/**********************************************************/

function DespacharEliminarDestino($idp,$ids){
	
	//Aca opdra borrar los de historial_atencion, historial_documentos y borrador (cuando desaparece de su bandeja de AteDoc)
	
    if($_REQUEST["th"]!=3&&$_REQUEST["th"]!=6&&$_REQUEST["th"]!=5&&$_REQUEST["th"]!=7){ //De que tipo de historial viene
        $sst="Delete from historial_atencion where id_historial_atencion='".$idp."'"; 
    }
    elseif($_REQUEST["th"]==7){
		$sst="Delete from devuelto where id_devuelto='".$idp."'";
	}elseif($_REQUEST["th"]==3){
        $sst="Delete from borradores_respuesta where id_borrador_respuesta='".$idp."'";
    }elseif($_REQUEST["th"]==6){
        $sst="Delete from historial_documentos where id_historial_documento='".$idp."'";      
    }
	
    $qt=new Consulta($sst);
	
	if($_REQUEST["th"]==0||$_REQUEST["th"]==1||$_REQUEST["th"]==4)
		$tipo = 2;
	elseif($_REQUEST["th"]==2)
		$tipo = 4;	
	elseif($_REQUEST["th"]==3)
		$tipo = 3;
	elseif($_REQUEST["th"]==5)
		$tipo = 7;
	elseif($_REQUEST["th"]==6)
		$tipo = 1;
	elseif($_REQUEST["th"]==7)
		$tipo = 6;	
	
		
	//Borramos de movimientos
    $sst_r="DELETE FROM movimientos where id_historial='".$idp."' AND tipo = $tipo";
	$qt_r=new Consulta($sst_r);
	
	//Vemos si cambia de estado
	$doc = new Documento($ids);
	$ultimo_estado=$doc->UltimoEstadoMovimientos();
	$doc->actualizarEstado($ultimo_estado);
   $doc->ActualizaUbicacion();
	
 }
/**********************************************************/
////FIN REEMPLAZAR
/**********************************************************/

function DespacharDesArchivarDestino($ids){    

    $documento = new Documento($ids);
	$estado = $documento->UltimoEstadoAntesArchivar();
    $documento->actualizarEstado($estado);
    $documento->ActualizaUbicacion();
}

function DespacharDesFinalizarDestino($ids){    

    $documento = new Documento($ids);
    $documento->actualizarEstado(6);
    $documento->ActualizaUbicacion();
}

function RegistraFiltrar(){

    $sql_estado =  "SELECT *
					FROM
					estados AS e
					WHERE e.display = 1
					ORDER BY
					e.nombre_estado ASC";
					
                $q_estado=new Consulta($sql_estado);
    ?>
	<form name="f5" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=list&ide=<?=$ide?>&ide=<?=$ide2?>">
	  <table width="100%" height="50" border="0" >
		<tr>
			<td align="center">
				<select name="ide">
					<option value="">---Estado---</option>
					<?
						while($row_estado=$q_estado->ConsultaVerRegistro()){
							$ide=$row_estado[0];
					?>
					<option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){echo "selected";} ?>>
						<?=$row_estado[1]?>
					</option> 
					<?  } ?>
					<option value="LT">LISTAR TODOS</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="center">
				<input name="Filtrar" type="submit" class="boton"  value="Filtrar"/>
			</td>
		</tr>
	  </table>
	</form>
<?
}

 }

?>

