<?php

class Registro {

function RegistraCabecera(){	

    $sql_usu = "SELECT u.login_usuario,
                u.password_usuario,
                uap.id_axo_poa,
                u.nombre_usuario as nombre
                FROM
                usuarios AS u,
                usuario_axo_poa AS uap
                WHERE
                u.id_usuario = uap.id_usuario AND
                u.id_usuario = '".$_SESSION['session'][1]."'";

    $query_pa=new Consulta($sql_usu);
    $row_usu=$query_pa->ConsultaVerRegistro();
    $_POST['usu']=$row_usu['id_usuario'];

?><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="../../js/ajax/ajax.js"></script>
    <title>Documento sin t&iacute;tulo</title>
<?php
}

function RegistraListado($ide){	

if ($ide==''){

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
				(d.id_estado = '3' OR d.id_estado = '4' OR d.id_estado = '12' 
                OR d.id_estado = '6' OR d.id_estado = '13' OR d.id_estado = '14' 
				OR d.id_estado = '15')
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
				Inner Join documentos AS d ON ha.id_documento = d.id_documento
				Inner Join estados AS e ON d.id_estado = e.id_estado
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				Inner Join remitentes AS r ON d.id_remitente = r.id_remitente
				WHERE
				(d.id_estado = '3' OR d.id_estado = '4' OR d.id_estado = '12'
                OR d.id_estado = '6' OR d.id_estado = '13' OR d.id_estado = '14' 
				OR d.id_estado = '15') AND(
				(ha.id_usuario_destino = '".$_SESSION['session'][0]."' AND ha.tipo_historial_atencion=0) OR
				(ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=1) 				OR 
				(ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion=2)
				)
				ORDER BY 1 DESC";

    $query_reg=new Consulta($sql_reg);	
}
else{
	
	if($ide=="LT")
		$where="";
	else{
		$where="AND d.id_estado =$ide";
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
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				Inner Join remitentes AS r ON d.id_remitente = r.id_remitente
				WHERE
				((ha.id_usuario_destino = '".$_SESSION['session'][0]."' AND ha.tipo_historial_atencion=0) OR
				(ha.id_area_destino = '".$_SESSION['session'][5]."' AND ha.tipo_historial_atencion>0)) 
				".$where."
				ORDER BY 1 DESC";

    $query_reg=new Consulta($sql_reg);

}

	?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" id="tabla_despacho">

    <tr bgcolor="#6699CC">
		<td width="10%" height="25" style="vertical-align:middle"><div align="center" class="msgok1">Reg. Nro</div></td>
		<!---<td width="10%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
		<td width="25%" style="vertical-align:middle"><div align="center"><span class="msgok1">Remitente</span></div></td>
		<td width="32%" style="vertical-align:middle"><div align="center"><span class="msgok1">Documento</span></div></td>
		<td width="13%" style="vertical-align:middle"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
		<td width="2%" align="center" style="vertical-align:middle"><span class="msgok1">Estado</span></td>
		<td width="2%" align="center" style="vertical-align:middle"><span class="msgok1">Cat</span></td>
		<td style="vertical-align:middle"><div align="center" class="msgok1"> Ubicacion  Original</div></td>
	</tr>

    <? while($row_reg=$query_reg->ConsultaVerRegistro()){

		$ids=$row_reg["id"];		
		$estado=$row_reg["id_estado"];
		$cat = $row_reg["categoria"];       
		$loTengo = true;
		
		if($cat == 1){
		//Si es un despachado no pregunto si esta en mi area
		if($estado==4||$estado==13||$estado==12||$estado==6||$estado==14||$estado==15){
			$total = 10; //Mayor a 0 para que tambien lo usen los otros estados
			if($estado==14||$estado==15){ 
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
			
		}//Fin if	
		
		}//Fin if
		
		//Pregunto si mi area lo tiene
		if($loTengo){
		$clase = "class='Estilo7'";						
		if($estado==12){
			$clase = "class='Estilo7 fila_finalizada'";
		}else{
			$dias_faltantes = ObtenerDiasFaltantes($ids, date('d/m/Y',strtotime($row_reg['fecha'])));
			if($dias_faltantes <=0)
				$clase = "class='Estilo7 fila_peligro'";
			elseif($dias_faltantes > 0 && $dias_faltantes <= 3)
				$clase = "class='Estilo7 fila_urgente'";
			else	
				$clase = "class='Estilo7 fila_baja'";
		}	
		
		?>
		
    <tr <? echo $clase; ?>>
		<td   onmouseover="toolTips('<?=$row_reg['asunto']?>',this)" >
			<div align="center">
			  <? if($estado!=11){?>
			  <a href="areas_acceso_registro.php?opcion=despachar&ids=<?=$ids?>&cat=<?=$row_reg['categoria']?>">
		      <?=$row_reg['codigo']?>
		      </a>
		        <? }
				else{?>
			  <?=$row_reg['codigo']?>
			      <? }?>	
	        </div></td>
 		<td><input size="40" value="<?=$row_reg['remitente']?>"/></td>
		<td><input size="47" value="<?=$row_reg['numero']?>"/></td>
		<td> <div align="center"><?php echo date('d/m/Y H:i',strtotime($row_reg['fecha']))?>
	    </div></td>
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

			}elseif($row_reg['id_estado']==14||$row_reg['id_estado']==15){
				$doc_d_a = new Documento($row_reg['id']);				
				$tooltip="title ='".$doc_d_a->ObtenerDescripcionUltimoOriginal()."' class='tip'";				
			}
			
			if(!empty($row_des['descripcion'])){
				$tooltip="title ='".$row_des['descripcion']."' class='tip'";
			}
		?>
				
		<td align="center" <?=$tooltip?>>
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
					<?=$row_reg['estado'];?>
			<? }?>		</td>
		<td align="center" ><? if($row_reg['categoria']=='1'){echo 'O';} else {echo 'C';}?></td>

      <?php

		$sql_data=" SELECT a.abve_nombre_area
					FROM
					areas AS a 
					WHERE
					a.id_area =  '".$_SESSION['session'][5]."' ";
					
		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();
	?>
      <td>
	  
	<?  if ($row_reg['id_estado']=='3'||$row_reg['id_estado']=='12'||$row_reg['id_estado']=='15'||$row_reg['id_estado']=='14')
        	echo $data['abve_nombre_area'];
        elseif($row_reg['id_estado']=='13'){
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
		
			echo $row_area_derivado["abreviatura"];		
								
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
		
				echo $usu['abreviatura'].' '.$usu['login_usuario'];
				
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
		
				echo $usu['abreviatura'].' '.$usu['login_usuario'];
			}	 	 	
	?>	 </td>
    </tr>
	<?	
	     }
	 }?>
</table>

<?php }

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
				e.abrev_nombre_estado as estado,
				v.descripcion as descripcion_d,
				a.descripcion as descripcion_a
				FROM
				historial_documentos AS hd
				Inner Join documentos AS d ON d.id_documento = hd.id_documento
				Inner Join estados AS e ON e.id_estado = d.id_estado
				Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				Left Join devuelto AS v ON v.id_documento = d.id_documento
				Left Join archivo AS a ON a.id_documento = d.id_documento							
				WHERE
				d.id_estado >  '1' $where
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
				e.abrev_nombre_estado as estado,
				v.descripcion as descripcion_d,
				a.descripcion as descripcion_a				
				FROM
				historial_atencion AS ha
				Inner Join documentos AS d ON ha.id_documento = d.id_documento
				Inner Join estados AS e ON d.id_estado = e.id_estado
				Inner Join tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
				Inner Join remitentes AS r ON d.id_remitente = r.id_remitente
				Left Join devuelto AS v ON v.id_documento = d.id_documento
				Left Join archivo AS a ON a.id_documento = d.id_documento
				WHERE
				d.id_estado >  '1' $where
				ORDER BY codigo DESC ";
	
	$query_reg = new Consulta($sql_reg);	
	
?>

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" id="tabla_despacho">
	<tr bgcolor="#6699CC" class="Estilo22">
		  <td width="10%" height="25" style="vertical-align:middle"><div align="center" class="msgok1">Reg. Nro</div></td>
		  <td width="25%" style="vertical-align:middle"><div align="center"><span class="msgok1">Remitente</span></div></td>
		  <td width="32%" style="vertical-align:middle"><div align="center"><span class="msgok1">Documento</span></div></td>
		  <td width="13%" style="vertical-align:middle"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
		  <td width="3%" align="center" style="vertical-align:middle"><span class="msgok1">Estado</span></td>
		  <td width="2%" align="center" style="vertical-align:middle"><span class="msgok1">Cat</span></td>
		  <td align="center" style="vertical-align:middle"><span class="msgok1"> Ubicacion</span></td>      
	  </tr>

		<?php while($row_reg=$query_reg->ConsultaVerRegistro()){
				$ids=$row_reg[id_documento];
				$_POST[remi]=$row_reg[t_remitentenombre];
        		$estado=$row_reg["id_estado"];
        
		$clase = "class='Estilo7'";
						
		if($estado==12){
			$clase = "class='Estilo7 fila_finalizada'";
		}else{
			$dias_faltantes = ObtenerDiasFaltantes($ids, date('d/m/Y',strtotime($row_reg['fecha'])));
			if($dias_faltantes <=0)
				$clase = "class='Estilo7 fila_peligro'";
			elseif($dias_faltantes > 0 && $dias_faltantes <= 3)
				$clase = "class='Estilo7 fila_urgente'";
			else	
				$clase = "class='Estilo7 fila_baja'";
		}	
		
		?>
		
    <tr <? echo $clase; ?>>
		<td   onmouseover="toolTips('<?=$row_reg['asunto']?>',this)" >
			<div align="center"><a href="areas_acceso_registro.php?opcion=despachar&ids=<?=$row_reg['id']?>">
		    <?=$row_reg['codigo']?>
			  </a>
	        </div></td>  
		  <td ><input name="Input" value="<?=$row_reg['remitente']?>" size="40"/></td>
		  <td ><input name="Input2" value="<?=$row_reg['numero']?>" size="47"/></td>
		  <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
		  
		<?php
			$tooltip="";
			if(($row_reg['id_estado']==5)&&!empty($row_reg['descripcion_d'])){
				$tooltip="title ='".$row_reg['descripcion_d']."'";				
			}
			elseif($row_reg['id_estado']==11&&!empty($row_reg['descripcion_a'])){
				$tooltip="title ='".$row_reg['descripcion_a']."'";
			}	
		?>
				
		<td align="center" <?=$tooltip?> class="tip">
			<? if($estado==11){?>
				<a href="javascript:QuitarArchivado(<?=$row_reg['id']?>)" id="desarchivar">
					<?=$row_reg['estado'];?>
				</a>
			<? }else{?>
					<?=$row_reg['estado'];?>
			<? }?>
		</td>
		  <td align="center" ><? if($row_reg['categoria']=='1'){echo 'O';} else {echo 'C';}?></td>

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

	<?  if ($row_reg['id_estado']='4'){echo $data['abve_nombre_area'];

				if($usu['original_historial_atencion']=='1'){
					echo ' '.$u['login_usuario'];}
	 			else{ echo ' '.' ';	}

	}

	 else { echo $data['abve_nombre_area']; }?></td>

    </tr><? }?>
</table>

    <p>
      <? }

function ConsultarDocumento($ids){

	$tai=$_POST[tai];

	$sql_resumen="SELECT *
				FROM
				documentos
				Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
				Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento
				WHERE
				documentos.id_documento = '".$ids."'";
				
				$query_resumen=new Consulta($sql_resumen);
				$row_resumen=$query_resumen->ConsultaVerRegistro(); 
				
	$estado = $row_resumen["id_estado"];

	//Esta finalizado
	if($estado==12){		
		
		$sql_tipo = "SELECT * 
					FROM tipos_documento 
					WHERE entrada_salida = 1 || entrada_salida = 2
					ORDER BY tipos_documento.nombre_tipo_documento ASC";
					
		$query_tipo = new Consulta($sql_tipo);
		
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

	//Hacemos un post al popup	
	?>	
	<form id="form_documento_fin_imprimir" method="post" action="documento_finalizado.php" target="popup">
	
	<input type="hidden" name="id" id="id" value="<?=$ids?>">	
	
	<fieldset>
		<legend>Documento Finalizado</legend>
			   
		<table width="100%" border="0" id="imprimir_documento_finalizado">
		  <tr>
		    <td class="Estilo22"><div align="left">Asunto</div></td>
		    <td class="Estilo22"><div align="center">:</div></td>
		    <td><div align="left">
		      <input name="asunto" type="text" id="asunto" size="80" value=""/>
		      </div></td>
	      </tr>
		  <tr>
		    <td class="Estilo22"><div align="left">Referencia</div></td>
		    <td class="Estilo22"><div align="center">:</div></td>
		    <td><div align="left">
		      <input name="referencia" type="text" id="referencia" size="80" value="<?=$row_resumen["referencia_documento"]?>"/>
		      </div></td>
	      </tr>
		  
		  
		  <tr>
		    <td class="Estilo22"><div align="left">Destinatario</div></td>
		    <td class="Estilo22"><div align="center">:</div></td>
		    <td><div align="left">
		      <input name="destinatario" type="text" id="destinatario" size="80" value="<?=$row_resumen["nombre_remitente"]?>"/>
		      </div></td>
	      </tr>
		  <tr>
			<td width="14%" class="Estilo22"><div align="left">Tipo de Plantilla</div></td>
			<td width="2%" class="Estilo22"><div align="center">:</div></td>
			<td width="84%">
			
			  <div align="left">
			    <select name="tipo" class="tipo_doc" id="tipo" style="width:150px">
			      <option value="">---Tipo de Documento---</option>
			      <?
        		while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
			      <option value="<?=$row_tipo[0]?>">
		          <?=$row_tipo[1]?>
		          </option>
			      <? }?>
		          </select>
	        </div></td>
		  </tr>
		  <tr>
		    <td class="Estilo22"><div align="left">Saludo</div></td>
		    <td class="Estilo22"><div align="center">:</div></td>
		    <td>
				<div align="left">
				  <select name="saludo" id="saludo" style="width:400px">
				    <option value="">---Saludo del Documento---</option>
				    <?
        			while($row_sal=$query_sal->ConsultaVerRegistro()){
					?>					
				    <option value="<?=$row_sal[0]?>">
			        <?=$row_sal[1]?>
			        </option>
		            <? }					
				?>
			      </select>
                </div></td>
	      </tr>
		  <tr>
		    <td class="Estilo22"><div align="left">Despedida</div></td>
		    <td class="Estilo22"><div align="center">:</div></td>
		    <td>
				<div align="left">
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
		    <td></td>
	      </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>
			<td>
			  <div align="left">
			    <input name="vista" type="button" id="vista" value="Vista Preliminar" class="boton"/>
		      </div>			</td>
		  </tr>
		</table>
	</fieldset>
	</form>
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
      <td width="142" class="Estilo22"><div align="left">Registro Nro</div></td>
      <td width="10" class="Estilo22"><div align="center">:</div></td>
      <td width="301" class="Estilo23"><div align="left">
        <?=$row_resumen[1]?>
      </div></td>
      <td width="110" class="Estilo22"><div align="left">Categor&iacute;a</div></td>
      <td width="17" class="Estilo22"><div align="center">:</div></td>
      <td class="Estilo23"><div align="left"><?=($_REQUEST["cat"]==1)?"Original":"Copia"?></div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Remitente</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23">          
        <div align="left"><?=$row_resumen[nombre_remitente]?></div></td>
        <td class="Estilo22"><div align="left">Nro de Folios</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23" ><div align="left">
          <?=$row_resumen[numero_folio_documento]?>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Nro. Doc</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><div align="left">
          <?=$row_resumen[numero_documento]?>
        </div></td>
      
        <td class="Estilo22"><div align="left">Fecha de Doc</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><div align="left"><?php echo date('d-m-Y',strtotime($row_resumen['fecha_documento']))?></div></td>
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
			
			while($row_reg = $qescaneo->ConsultaVerRegistro()){?>
          <a href="Escaneo/<?=$row_reg['nombre_documento_escaneado']?>" id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank">
          <?=$index?>
          </a>				
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
        <td class="Estilo23"><div align="left"><?php echo date('d-m-Y H:I:s',strtotime($row_resumen["fecha_registro_documento"]))?></div></td>
        <td align="left" class="Estilo22"><div align="left">Tipo de Documento</div></td>
          <td align="left" class="Estilo22"><div align="center">:</div></td>
          <td align="left" class="Estilo23"><div align="left">
            <?=$row_resumen["nombre_tipo_documento"]?>
          </div></td>
      </tr>
    </tbody>
</table>
<table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" width="100%">
<tbody>          
      <tr>
        <td width="142" class="Estilo22"><div align="left">Asunto</div></td>
        <td width="10" class="Estilo22"><div align="center">:</div></td>
        <td colspan="2"><div align="left">
          <textarea name="textfield2" id="textfield2" rows="3" cols="100"><?=$row_edit[0]?>
        </textarea>
        </div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Observaci&oacute;n Registro</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="2"><div align="left">
          <textarea name="textarea2" id="textarea2" rows="3" cols="100"><?=$row_edit[1]?>
        </textarea>
        </div></td>
      </tr>
      <tr>
      <td class="Estilo22"><div align="left">Observaci&oacute;n Despacho</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="2"><div align="left">
        <textarea name="textarea3" id="textarea3" rows="3" cols="100"><?=$row_edit[3]?>
        </textarea>
      </div></td>
      </tr>
      <tr>
      <td class="Estilo22"><div align="left">Prioridad</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="2"><div align="left"><span class="Estilo23">
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
        <td width="17" class="Estilo23">
		  <div align="left">
		    <?=number_format($row_prioridad["dias"],0)?>
        </div></td>
        <td width="598" class="Estilo23"><div align="left"><? echo "dias";?></div></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Fecha Estimada de Respuesta</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="2" class="Estilo23"><div id="fecha_respuesta" align="left"><?=$documento_p->setFechaRespuesta($row_prioridad["horas"])?></div></td>
      </tr>
</tbody>
</table>
</fieldset>
<table width="22%" border="0" align="center">
  <tr>
    <td width="48%" height="39"><form id="f7" name="f7" method="post" action="javascript:DevolverDocumento(<?=$row_edit['id_documento']?>)">
      <div align="center">
        <input  border="#0099FF" name="devolver" type="submit" class="boton" id="devolver" value="Devolver" />
        </div>
    </form></td>
    <td width="6%" >&nbsp;</td>
    <td width="46%" ><form id="f8" name="f8" method="post" action="javascript:ArchivarDocumento(<?=$row_edit['id_documento']?>)">
      <div align="center">
        <input  border="#0099FF" name="archivar" type="submit" class="boton" id="button" value="Archivar" />
        </div>
    </form></td>
  </tr>
</table>


<form name="form_despacho_area" id = "form_despacho_area" method="post"  action="<?php echo $_SERVER['PHP_SELF']?>?opcion=des_guard&ids=<?=$ids?>" >  

	<?
		$td="SELECT
		`td`.`id_documento`,
		`td`.`observacion_historial_atencion`
		FROM
		`historial_atencion` AS `td`
		WHERE
		`td`.`id_documento` =  '".$ids."'";
		$qtd=new Consulta($td);	
		$row_td=$qtd->ConsultaVerRegistro();
	?>

<fieldset>
  <legend class="Estilo9">ESTABLECER DESTINO Y ACCION A REALIZAR</legend>
  <table align="center" border="0" class="formularios">
    <tbody>
      <tr>
        <td height="12" class="Estilo21" ><div align="center">(*)</div></td>
        <td width="6%" class="Estilo22" ><div align="left">Pase A</div></td>
        <td><div align="center">:</div></td>
        <td width="33%" ><?
    		$sql_areas="SELECT * FROM usuarios where usuarios.id_area='".$_SESSION['session'][5]."' ";
	    	$query_areas=new Consulta($sql_areas);
		?>
          <div align="left">
            <input type="hidden" value="<?=$_SESSION['session'][5]?>" id="idArea"/>
            <select name="destino" id="destino" style="width:200px" class="usuarios">
              <option value="" selected="selected">--- Seleccione un Usuario---</option>
              <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
              <option value="<? echo $row_areas[0]?>"<? if(isset($_POST['destino']) && $_POST['destino']==$row_areas[0]){ echo "selected";} ?>><? echo $row_areas[nombre_usuario]." "?><? echo $row_areas[apellidos_usuario]?></option>
              <? } ?>
              </select>
            <a href="javascript:void(0);" id="cambiar_destino" style="margin-left:5px;">Areas</a>
          </div></td>
        <td width="38%" rowspan="3" class="Estilo22" ><div align="left">Observaci&oacute;n Area:
          <textarea name="textarea4" id="textarea4" rows="4" cols="50"></textarea>
        </div></td>
	    <td width="3%"  bgcolor="#ffffff" class="Estilo21"><div align="center">(*)</div></td>      
	    <td width="3%"  bgcolor="#ffffff" class="Estilo22"><div align="center">
        <input name="radiobutton" value="1" type="radio" id="0" />      
      	</div>
	  	</td>
      	<td width="6%" bgcolor="#ffffff" class="Estilo22"><div align="left">Original</div></td>
      	<td width="8%" rowspan="2" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
      </tr>
      <tr>
        <td height="13" class="Estilo21" ><div align="center">(*)</div></td>
        <td width="6%" class="Estilo22" ><div align="left">Acc&iacute;on</div></td>
        <td ><div align="center">:</div></td>
        <td width="34%" >
		  <div align="left">
		    <?

        $sql_accion = " SELECT
                        accion.id_accion,
                        accion.nombre_accion,
                        accion.categoria_accion
                        FROM accion
                        WHERE accion.categoria_accion='DA'
                        ORDER BY accion.nombre_accion ASC";

    	$query_accion=new Consulta($sql_accion);
		?>
		      <select name="cboaccion2" style="width:200px" >
		        <option value="">--- Accion a Realizar---</option>
		        <? while($row_accion=$query_accion->ConsultaVerRegistro()) {?>
		        <option value="<? echo $row_accion[0]?>"><? echo $row_accion[1]?></option>
		        <? } ?>
	          </select>
          </div></td>
        <td  bgcolor="#ffffff" class="Estilo21">&nbsp;</td>            
        <td width="3%"  bgcolor="#ffffff" class="Estilo22">
		<div align="center"><span class="Estilo22">
          <input name="radiobutton" value="2" type="radio" id="1"/>
        </span></div></td>
		<td width="6%" bgcolor="#ffffff" class="Estilo22"><div align="left">Copia</div></td>
	</tr>      
    <tr>    

        <td width="2%" height="26" class="Estilo21">&nbsp;</td>
        <td width="6%" height="26" class="Estilo22" >&nbsp;</td>
        <td width="1%" height="26" >&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td colspan="3"  align="center">
          
          <div align="right">
            <input type="submit" name="Cargar Lista2" value="Cargar Lista" class="boton" />
          </div></td>        
	  </tr>
    </tbody>
  </table>

  </fieldset>

</form>
<?	
	$doc=new Documento($ids);
	$tengoOriginal = $doc->DespachoAreaTieneOriginal();
	
	if(!$tengoOriginal){
	?> <script>
			javascript:deshabilitado();
			javascript:habilita_copia();		
		</script>
	<?
    }else{?>
		<script>
			javascript:habilitado();
			javascript:deshabilita_copia();
		</script>
	<?
	}

	Registro::DespacharListarDestino($ids);
}
?>
<? }

function DespacharListarDestino($ids)  {  ?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" id="tabla_despacho" >

	<tr bgcolor="#6699CC" class="Estilo7">
	<td width="5%" height="25" ><div align="center" class="msgok1">Nro</div></td>
	<td width="21%"><div align="center">ORIGEN</div></td>
	<td width="24%"><div align="center">DESTINO</div></td>
	<td width="13%"><div align="center">Fecha y Hora </div></td>
	<td width="13%"><div align="center">Acci&oacute;n</div></td>
	<td width="11%"><div align="center">Categor&iacute;a</div></td>
	<td width="13%"><div align="center">Opciones </div></td>
  </tr>

	<?

	$sql_origen="Select th.id_historial_atencion,
                th.tipo_historial_atencion,
				th.id_documento,
				th.id_usuario_destino,
                th.id_area_destino,
                th.id_usuario,
				th.id_area,
				th.fecha_historial_atencion,
				th.original_historial_atencion,
				th.id_accion,				
				th.id_estado,
				th.observacion_historial_atencion,
				tac.nombre_accion
				FROM
				historial_atencion AS th
				Inner Join accion AS tac ON tac.id_accion = th.id_accion
				WHERE
				th.id_documento =  '".$ids."' AND
                ((th.id_usuario_destino=".$_SESSION['session'][0]." AND th.tipo_historial_atencion=0) OR
				 (th.id_area_destino=".$_SESSION['session'][5]." AND th.tipo_historial_atencion>0)
				OR th.id_area=".$_SESSION['session'][5].")
				ORDER BY
				th.fecha_historial_atencion,th.original_historial_atencion";
		   	
                $query_origen=new Consulta($sql_origen);
				$hayOriginal = 0;
				$cont=0;
								
				while($row_org=$query_origen->ConsultaVerRegistro()){
                    $noEsMio = '';
					$idp=$row_org[0];

                 if($row_org["tipo_historial_atencion"]==0){ //Es de AREA a usuarios del area
					$id_ori = new Area($row_org['id_area']);
                    $origen = $id_ori->getNombre();
					$id_dest= new Usuario($row_org['id_usuario_destino']);
                    $destino = $id_dest->getNombreCompleto();
                 }elseif($row_org["tipo_historial_atencion"]==1){//Es de AREA a AREA									 
                    $id_ori = new Area($row_org['id_area']);
                    $id_des = new Area($row_org['id_area_destino']);
                    $origen = $id_ori->getNombre();
                    $destino = $id_des->getNombre();
                 }elseif($row_org["tipo_historial_atencion"]==2){//Es de USUARIO a AREA									 
                    $id_ori = new Usuario($row_org['id_usuario']);
                    $id_des = new Area($row_org['id_area_destino']);
                    $origen = $id_ori->getNombreCompleto();
                    $destino = $id_des->getNombre();
                 }
				 
				 //Solo se muestra como historial(no lo hizo el area actual)
				 if($row_org["id_area"]!=$_SESSION['session'][5]||$row_org["tipo_historial_atencion"]==2)				 	
				 	$noEsMio = "class = 'historial'";
				
	  ?>	
		
      <tr <?=$noEsMio?>>
        <td><input type="hidden" value="<?=$idp?>"><div align="center"><?=++$cont?></div></td>
        <td><?=$origen?></td>
        <td><?=$destino?></td>
        <td><div align="center"><?=date('d/m/Y H:i:s',strtotime($row_org['fecha_historial_atencion']))?></div></td>
        <td><div align="center"><?=$row_org['nombre_accion']?></div></td>
        <td><div align="center">
            <? if($row_org['original_historial_atencion']=='1'){
                   echo 'ORIGINAL';
                } else {
					echo 'COPIA';
				}
			?>
            </div>
        </td>
        <td>
            <div align="center">				
                <? 
					if($row_org['id_area']==$_SESSION['session'][5]&&$row_org["tipo_historial_atencion"]!=2){//Yo lo envie lo puedo eliminar
                ?>
                    <a href="areas_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&idp=<?=$idp?>"><img src="imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0"></a>
                <? }else{?>
                    <img src="imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0">
                <? }//Fin del if de eliminar
				?>            	
            	<?
				 if($row_org['tipo_historial_atencion']!=2){
                $observacion = trim($row_org['observacion_historial_atencion']);
                if(!empty($observacion)){?>
                   <a href="javascript:VerDetalleObservacion(<?php echo $cont ?>)">
                     <img src="public_root/imgs/b_search.png" width="16" height="16" border="0" alt="Ver Detalle" />
                   </a>
                <?
                }
                   else{
                ?>
                   <img src="public_root/imgs/b_search.png" width="16" height="16" border="0" alt="Ver Detalle" />
                <? }
				}//Fin del if para search.png
				?>				
            	<? 
				if($row_org['tipo_historial_atencion']==2){
					$doc_archivo=new Documento($ids);
	                $archivo = $doc_archivo->obtenerJustificacionesEscaneadas($idp);
    	            if(!empty($archivo)){?>
                   		<a href="Justificados/<?=$archivo?>">
                     		<img src="public_root/imgs/file.gif" width="16" height="16" border="0" alt="Ver Archivo" />
	                    </a>
                <?
                	}
                   else{
                ?>
                   <img src="public_root/imgs/file.gif" width="16" height="16" border="0" alt="Ver Archivo" />
                <? }
				}//Fin del if para file.gif
				?>
			</div>			
        </td>
      </tr>
	  <tr>
		<td colspan="7" align="center">
			<div style="display:none" id="detalle_observacion<?php echo $cont; ?>">
					<?=$observacion?>
			</div>
		</td>
	</tr>
     <? } //Fin del While ?>
  </tr>    

</table> 

 <?
	
}

function DespacharGuardarDestino($ids) {

    $nombre=$_POST['nombre'];
    $fecha=date("Y-m-d H:i:s");
    $destino=$_POST['destino'];
    $radiobutton=$_POST['radiobutton'];
    $cboaccion2=$_POST['cboaccion2'];
    $cboprioridad=$_POST['cboprioridad'];
    $textarea4=$_POST['textarea4'];
    $textarea=$_POST['textarea'];
    $idhd=$_POST['idhd'];
    $usu=$_SESSION['session'][0];
    $idarea= $_SESSION['session'][5];
    $usuario = new Usuario($usu);
    $id_area_destino = "'null'";

    if($usuario->esMiArea($destino)){ //Es un Despacho de Area
        $tipo = 0;
        $estado='4';
    }
    else{    //Es una Derivacion de Documento
        $usuario_destino = new Usuario($destino);
        $area_destino = $usuario_destino->getArea();
        $id_area_destino = $area_destino->getId();
        $tipo = 1;
        $estado='13';
    }
    $guades="Insert INTO
             historial_atencion values('','".$idhd."','".$ids."','".$destino."',".$id_area_destino.",'".$idarea."','".$fecha."','".$radiobutton."','".$cboaccion2."','".$usu."','".$estado."','".$textarea4."',$tipo)";

    $qdest=new Consulta($guades);

	if(	$radiobutton=='1'){//Si es el original el que esta moviendose
        
        $s_act = "Update documentos SET id_estado='".$estado."'
                  WHERE id_documento='".$ids."'";

        $qact=new Consulta($s_act);

		$s_ma = "Update historial_documentos SET id_estado='".$estado."'
                 WHERE id_documento='".$ids."'";
		$sma=new Consulta($s_ma);
    }

}

function DespacharEliminarDestino($idp){
	
	$fecha=date("d-m-Y H:i:s");
	$sst="Delete from historial_atencion where id_historial_atencion='".$idp."'";

	$qt=new Consulta($sst);



}

function DespacharDevolverDestino($ids, $com){
	
	$dev_com="Insert into devuelto values('',$ids,'".date("Y-m-d H:i")."',".$_SESSION['session'][0].",'$com')";
            $q_dev_com=new Consulta($dev_com);
	
	$fecha=date("Y-m-d H:i:s");

    $dev = "Update documentos SET id_estado='5'
            WHERE id_documento='".$ids."'";
            $q_dev=new Consulta($dev);

    $dev_1="Update historial_documentos SET id_estado='5'
            WHERE id_documento='".$ids."'";
            $q_dev_1=new Consulta($dev_1);

    $dev_2="Update historial_atencion SET id_estado='5'
            WHERE id_documento='".$ids."'";
            $q_dev_2=new Consulta($dev_2);	
}

function DespacharArchivarDestino($ids, $com){
    
	$arch="Insert into archivo values('',$ids,'".date("Y-m-d H:i")."',".$_SESSION['session'][0].",'$com')";
            $q_arch=new Consulta($arch);

    $dev="Update documentos SET id_estado='11' WHERE id_documento='".$ids."'";
        	$q_dev=new Consulta($dev);
	$dev_1="Update historial_documentos SET id_estado='11' WHERE id_documento='".$ids."'";
			$q_dev_1=new Consulta($dev_1);	
	$dev_2="Update historial_atencion SET id_estado='11' WHERE id_documento='".$ids."'";
			$q_dev_2=new Consulta($dev_2);

}

function DespacharDesArchivarDestino($ids){    

    $dev = "Update documentos SET id_estado='14' WHERE id_documento='".$ids."'";
        	$q_dev=new Consulta($dev);
	$dev_1="Update historial_documentos SET id_estado='14' WHERE id_documento='".$ids."'";
			$q_dev_1=new Consulta($dev_1);	
	$dev_2="Update historial_atencion SET id_estado='14' WHERE id_documento='".$ids."'";
			$q_dev_2=new Consulta($dev_2);

}

function DespacharDesFinalizarDestino($ids){    

    $dev = "Update documentos SET id_estado='6' WHERE id_documento='".$ids."'";
        	$q_dev=new Consulta($dev);
	$dev_1="Update historial_documentos SET id_estado='6' WHERE id_documento='".$ids."'";
			$q_dev_1=new Consulta($dev_1);	
	$dev_2="Update historial_atencion SET id_estado='6' WHERE id_documento='".$ids."'";
			$q_dev_2=new Consulta($dev_2);

}

function DespacharEditarDestino($ids) {

    $edi = " SELECT
            `td`.`asunto_documento`,
            `td`.`observacion_documento`,
            `td`.`id_prioridad`
            FROM
            `documentos` AS `td`
            WHERE
            `td`.`id_documento` =  '".$ids."'";

    $qedit=new Consulta($edi);
    $row_edit=$qedit->ConsultaVerRegistro();

?>

<form name="form10"  method="post"  action="<?php echo $_SERVER['PHP_SELF']?>?opcion=des_editar&ids=<?=$_POST['ids']?>" >  

  <fieldset>
  <legend class="Estilo9">ESTABLECER ASUNTO Y PRIORIDAD</legend>
  <table width="100%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
    <tr>
      <td width="85" height="56" bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Asunto:</strong></div></td>
      <td colspan="3"><textarea name="textfield"  id="textfield" rows="3" cols="140"><?=$row_edit[0]?>
      </textarea></td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Observaci&oacute;n:</strong></div></td>
      <td colspan="3"><textarea name="textarea"  id="textarea" rows="3" cols="140"><?=$row_edit[1]?></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Prioridad:</strong></div></td>
      <td width="542">
      <?
        $sql_prioridad="SELECT
                        prioridades.id_prioridad,
                        prioridades.nombre_prioridad,
                        prioridades.tiempo_horas_respuesta_prioridad
                        FROM prioridades
                        where
                        prioridades.id_prioridad='".$row_edit[2]."'
                        ORDER BY prioridades.id_prioridad ASC";

            $query_prioridad=new Consulta($sql_prioridad);
        ?>

    <select name="cboprioridad"  id="cboprioridad" onChange="cambia_saldo(this.value)">
        <option value="1"></option>
         <? 
			while($row_prioridad=$query_prioridad->ConsultaVerRegistro())
			{?>
        <option value="<?=$row_prioridad[0]?>"<? if($id_total==$row_prioridad[0]){ echo "selected"; } ?>>
        <?=$row_prioridad[1].'-'.$row_prioridad[2]?>
        </option>
        <? } ?>
    </select>

    </td>
      <td width="309" bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Tiempo de Respuesta:</strong></div></td>
      <td width="0"> <div align="right" id="capa_saldo"></div></td>
    </tr>

    <tr>
      <td colspan="4" bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Fecha Estimada de Respuesta:</strong></div></td>
    </tr>
  </table>
  </fieldset>

  <fieldset>
      <legend class="Estilo9">ESTABLECER DESTINO Y ACCION A REALIZAR</legend>
      <table width="100%" align="center" border="1">
        <tbody>
        <tr>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left">Pase A:
            <?
                $sql_areas="SELECT areas.id_area, areas.nombre_area FROM areas";
                $query_areas=new Consulta($sql_areas);
            ?>
                <select name="cboareas"  id="cboareas">
                  <option value="">--- Seleccione Destino---</option>
                  <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
                  <option value="<? echo $row_areas[0]?>"><? echo $row_areas[1]?></option>
                  <? } ?>
                </select>
                <?

        $sql_accion="SELECT accion.id_accion, accion.nombre_accion, accion.categoria_accion FROM accion";

    	$query_accion=new Consulta($sql_accion);

		?>
        </div>
        </td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left">Acc&iacute;on
          <select name="cboaccion" id="cboaccion">
                  <option value="">--- Accion a Realizar---</option>
                  <? while($row_accion=$query_accion->ConsultaVerRegistro()) {?>
                  <option value="<? echo $row_accion[0]?>"><? echo $row_accion[1]?></option>
                  <? } ?>
            </select>
        </div>
        </td>
        <td bgcolor="#ffffff" class="Estilo22">
          <div align="center">
            <input name="radiobutton" value="1" type="radio" id="0" />
          </div>
        </td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left">Original </div></td>
        <td align="center"></td>        
        </tr>
        <tr>
        <td width="35%" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>

        <td width="30%" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>

        <td width="4%" bgcolor="#ffffff" class="Estilo22"><div align="center">
          <input name="radiobutton" value="2" type="radio" id="1" />
          
        </div>
        <td width="16%" bgcolor="#ffffff" class="Estilo22"><div align="left">Copia
        </div>
        <td width="15%" align="center"><div align="center">
          <input name="Cargar Lista" type="submit" class="boton" value="Cargar Lista" />
        </div>
        </td>
      </tr>
    </tbody>
  </table>
  </fieldset>
</form>
<?
}

function RegistraFiltrar(){

    $sql_estado="SELECT *
                FROM
                `estados` AS `e`
                ORDER BY
                `e`.`nombre_estado` ASC";
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
				<option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){ echo "selected";} ?>>
					<?=$row_estado[1]?>
				</option> 
				<?  } ?>
				<option value="LT">LISTAR TODOS</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center" ><input name="Filtrar" type="submit" class="boton"  value="Filtrar"/></td>
	</tr>
  </table>
</form>
<?
}

 }

?>

