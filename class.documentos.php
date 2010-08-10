<?php
require_once('cls/class.acciones.php');

class Documentos{

	function Documentos(){	}

	function DocumentosPorUsuario($id_usuario){

		$return;
		$sql = "SELECT * FROM documentos WHERE id_usuario = '".$id_usuario."' ";
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' 		=> $row['id_usuario'],
				'codigo' 	=> $row['codigo_usuario'],
				'tipo' 		=> $row['id_tipo_documento'],
				'numero' 	=> $row['numero_documento'],
				'referencia'=> $row['referencia_documento'],
				'anexo' 	=> $row['anexo_documento'],
				'numero_folio' => $row['numero_folio_documento'],
				'fecha' 	=> $row['fecha_documento'],
				'asunto' 	=> $row['asunto_documento'],
				'fecha_registro' => $row['fecha_registro_documento'],
				'observacion' => $row['observacion_documento'],
				'prioridad' => $row['prioridad_documento'],
				'destino' 	=> $row['destino_documento'],
				'remitente' => $row['id_remitente'],
				'estado' 	=> $row['id_estado']
			);
		}
		return $return;
	}

	function HistorialDocumentosPorUsuario($id_usuario){
	
		$return;
		$sql = "SELECT * FROM historial_documentos WHERE id_usuario = '".$id_usuario."' ";
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' 		=>	$row['id_historial_documento'],
				'documento'	=>	new Documento($row['id_documento']),
				'remitente' =>	new Remitente($row['id_remitente']),
				'destino' 	=>	new Usuario($row['id_usuario_destino']),
				'fecha' 	=>	$row['fecha_historial_documento'] ,
				'original'	=>	$row['original_historial_documento'] ,
				'accion' 	=>	new Accion($row['id_accion']) ,
				'estado' 	=>	new Estado($row['id_estado']),
				'usuario' 		=>	new Usuario($row['id_usuario'])
			);
		}
		return $return;
	}

	function listarDocumentosPorUsuario( $usuario ){
		if(isset($_POST['campo']) && isset($_POST['valor']) && !empty($_POST['campo']) && !empty($_POST['valor'])){
		 	$docs = $usuario->getIdAtencionPorFiltro($_POST['campo'], $_POST['valor']);
		}else{
			$docs = $usuario->getIdAtencion();
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
					<th width="5%" class="ui-widget-header ui-th-column grid_resize">Cat</th>
				</tr>			
			</table>
	</tr>
	<tr class="ui-jqgrid-bdiv">
		<td>
			<table id="frmgrid" width="100%" class="ui-jqgrid-btable" cellpadding="0" cellspacing="0">
		<?php			
			
			$cod_documento = "";
			$muestra_copia=true;
			
			for($d=0; $d < count($docs); $d++ ){
			
			$doc[$d] = new Documento($docs[$d]['id']);
						
			$anterior = $cod_documento;
			$cod_documento = $doc[$d]->getCodigo();
            $tem = $doc[$d]->getEstado();
            $estado = $tem-> getId();
			
			if($cod_documento != $anterior||$muestra_copia){			
										
			//Vemos si se muestra en la lista o no			
			$tam_borr_orig = $doc[$d]->ObtenerTamanioHistorialOriginales();

			if($tam_borr_orig>0&&!$doc[$d]->TengoElBorradorOriginal($_SESSION['session'][0])&&$docs[$d]['original']==1&&$estado==6){
				//hay un historial de borradores donde se ha enviado el original y yo no tengo el original
				//No se debe mostrar asi que no pasa nada
				$muestra_copia = true;
				//Como no se mostro original se muestra la copia
			}elseif($docs[$d]['original']==1&&($estado==4||$estado==14||$estado==15)&&!$doc[$d]->TengoElDocDAOriginal($_SESSION['session'][0])){
                //Viene de despacho de area y no lo tengo
                $muestra_copia = true;
            }
			elseif($docs[$d]['original']==2&&$doc[$d]->copiaArchivadaUsuario()){			
				//Esta archiovada no se muestra la copia	
							
			}			
            else{
				// Se mostrara el original, ya no se muestra copia
				$muestra_copia = false;               		
				
				$clase = "Estilo7";
						
				if($estado==12){
					$clase = "Estilo7 fila_finalizada";
				}else{
					$dias_faltantes = ObtenerDiasFaltantes($docs[$d]['id'], date('d/m/Y',strtotime($doc[$d]->getFechaCompletaRegistro())));
						if($dias_faltantes <=0)
							$clase = "Estilo7 fila_peligro";
						elseif($dias_faltantes > 0 && $dias_faltantes <= 3)
							$clase = "Estilo7 fila_urgente";
						else	
							$clase = "Estilo7 fila_baja";
					
					}

					$tooltip_asunto="";
					$asunto = trim($doc[$d]->getAsunto());                    
					if(!empty($asunto))
						$tooltip_asunto="title ='".$asunto."' class='tip'";

                    $tooltip_estado="";
                    if($estado==14||$estado==15){
        				$tooltip_estado="title ='".$doc[$d]->ObtenerDescripcionUltimoOriginal($estado)."' class='tip'";
                    }
		
		?>			
			<tr class="ui-widget-content1 jqgrow <?=$clase?>">
				<td <?=$tooltip_asunto?> width="17%">
					<div align="center">
					  <?php if(($estado != 12&&$estado != 11)||$docs[$d]['original']==2){ ?>
					  <a href="atencion_acceso_registro.php?opcion=detalle&cat=<?=$docs[$d]['original']?>&id=<?php echo $doc[$d]->getId()?>"><?php echo $doc[$d]->getCodigo()?></a>
					  <? }
                    else{
                        echo $doc[$d]->getCodigo();
                    }
                    ?>
			        </div></td>
				<td align="left" width="27%">
					<?php $dtd = $doc[$d]->getRemitente();?>
					<input type="text" value="<?=$dtd->getNombre()?>" size="40" style="border:none"/></td>
				<td align="left">
					<input type="text" value="<?=$doc[$d]->getNumero()?>" size="50" style="border:none"/>
				</td>
				<td width="14%">
					<div align="center">
						<input type="text" value="<?php echo $doc[$d]->getFechaRegistro()." ".$doc[$d]->getHoraRegistro();?>" style="text-align:center"/>
					</div>
				</td>
				<td <?=$tooltip_estado?> width="6%">
					<? 
					$cat = $docs[$d]['original'];
					if($cat == 1){?>
                    <div align="center">
						<input type="text" value="<?php $est = $doc[$d]->getEstado(); echo $est->getAbreviatura(); ?>" size="3"
						style="text-align:center"/>
					</div>
					<? }else{
						$ids = $doc[$d]->getId();						
						$estado = $doc[$d]->ObtenerEstadoCopia($ids,2); 
					?>				
						<input type="text" value="<?=$estado?>" size="3" style="text-align:center; width:100%"/>
					<? }?>
				</td>
				<td width="5%">
				  <div align="center">
					  <input type="text" value="<?php $cat = $docs[$d]['original']; echo ($cat == 1)?"O":"C"; ?>" size="2"
					  style="text-align:center"/>
				  </div>
				</td>
			</tr>
			<?php
				}//Fin del elseif
				}//Fin de if anterior
			}//Fin del for			
			?>
		 </table>
		</td>
	</tr>
</table>
</div>
	<?
	}

	function detalleDocumentosPorUsuario( $usuario,  $documento ){
	  $doc = $documento;
	  $esOriginal=($_REQUEST[cat]==1)?true:false;
      ?>
		  <fieldset>
		  <legend>DATOS DEL DOCUMENTO</legend>
		  <input id ="id_documento" type="hidden" value="<?php echo $doc->getId;?>">
		  <input name="hidden" type="hidden" id ="id_area" value="<?php echo $_SESSION['session'][5]?>" />
		  <table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" width="100%">
			<tbody>
			<tr>
			  <td width="20%" class="Estilo22"><div align="left">Registro Nro </div></td>
			  <td width="2%" class="Estilo22"><div align="center">:</div></td>
			  <td><div align="left"><?php echo $doc->getCodigo();?></div></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td width="12%" class="Estilo22"><div align="left">Categor&iacute;a</div></td>
			  <td width="3%" class="Estilo22"><div align="center">:</div></td>
			  <td><div align="left"><? echo ($esOriginal)?"Original":"Copia";?></div></td>
			</tr>
			<tr>
			  <td class="Estilo22" ><div align="left">Remitente </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td ><div align="left"><?php $remit = $doc->getRemitente();echo $remit->getNombre();  ?></div></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td class="Estilo22" ><div align="left">Nro de Folios </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td><div align="left"><?php echo $doc->getNumeroFolio() ?></div></td>
			</tr>
			<tr>
			  <td class="Estilo22"><div align="left">Tipo de Documento </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td width="45%" colspan="3"><div align="left">
			    <?php $dtd = $doc->getTipoDocumento(); echo $dtd->getNombre(); ?>
			  </div>		      </td>
			  <td class="Estilo22"><div align="left">Fecha de Doc</div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td><div align="left"><?php  echo $doc->getFecha() ?></div></td>
		    </tr>
			<tr>
			  <td class="Estilo22"><div align="left">Nro. Doc </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="3"><div align="left"><?php echo $doc->getNumero() ?></div></td>
			  <td colspan="2"><span class="Estilo32"></span></td>
			  <td >&nbsp;</td>
			</tr>
			<tr>
			  <td class="Estilo22"><div align="left">Referencia </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="6"><div align="left"><?php  echo $doc->getReferencia()?></div></td>
			</tr>
			<tr>
			  <td class="Estilo22"><div align="left">Anexos </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="6" ><div align="left"><?php echo $doc->getAnexo() ?> </div></td>
			</tr>

			<tr>
			  <td class="Estilo22"><div align="left">Fecha y Hora de Registro</div></td>
			  <td height="21" class="Estilo22"><div align="center">:</div></td>
			  <td colspan="6"><div align="left"><?=$doc->getFechaRegistro()." ".$doc->getHoraRegistro()?></div></td>
		    </tr>
			<tr>
			  <td class="Estilo22"><div align="left">Documento Digitalizado</div></td>
			  <td height="21" class="Estilo22"> <div align="center">: </div></td>
			  <td colspan="6" ><div align="left">			  
	      		<?
					$escaneo = "SELECT *
								from documentos_escaneados de
								where de.id_documento = ".$doc->getId();

					$qescaneo = new Consulta($escaneo);

			  		$index = 1;

					while($row_reg = $qescaneo->ConsultaVerRegistro()){
						if(is_null($row_reg['fecha_escaneo']))
							$ref = "Escaneo/".$row_reg['nombre_documento_escaneado'];
						else
							$ref = "../archivo/Escaneado_completo/".$doc->getCodigo()."/".$row_reg['nombre_documento_escaneado'];
					?>
						<a href="<?=$ref?>"	id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank"><?=$index?></a>
					<?
						$index++;
            		}
				  	?>
			  </div>
			  </td>
			</tr>
			</tbody>
		  </table>
		 <p align="left"><a href="javascript:verDetalleDoc()" id = "control" class="v" >Ver Detalles </a></p>
		 <div id="detalle_documento" style="display:none">
		  <table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" width="100%">
		  	<tbody>
            <tr>
              <td width="20%" class="Estilo22"><div align="left">Asunto </div></td>
              <td width="2%"  class="Estilo22"><div align="center">:</div></td>
              <td colspan="5">
			  	<div align="left">
					<textarea name="textfield2" id="textfield2" rows="2" cols="100" class="disabled" disabled="disabled"><?=$doc->getAsunto()?></textarea>
              </div>
			  </td>
            </tr>
            <tr>
              <td class="Estilo22"><div align="left">Observaci&oacute;n de Registro </div></td>
              <td class="Estilo22"><div align="center">:</div></td>
              <td colspan="5">
			  	<div align="left">
			  		<textarea name="textfield2" id="textfield2" rows="2" cols="100" class="disabled" disabled="disabled"><?=$doc->getObservacion()?></textarea>
				</div>
			</td>
            </tr>
            <tr>
              <td  class="Estilo22"><div align="left">Observaci&oacute;n de Despacho</div></td>
              <td  class="Estilo22"><div  align="center">:</div></td>
              <td colspan="5"><div align="left">
                <?php
                     $historial=$doc->getHistorial();
                     foreach($historial as $reg){
                        $area = $reg["area"];
                        if($area->getId()==$_SESSION['session'][5]&&$reg["original"]==1){?>
                            <textarea name="textfield2" id="textfield2" rows="2" cols="100" class="disabled" disabled="disabled"><?=$reg["observacion"]?></textarea>							
                     <? }
					 }
                ?>
              </div>
			  </td>
            </tr>
            <tr>
              <td class="Estilo22" ><div align="left">Prioridad </div></td>
              <td height="21" class="Estilo22"><div align="center">:</div></td>
              <td colspan="4"><div align="left"><? $pri = $doc->getPrioridad(); echo $pri->getNombre() ?></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="Estilo22" ><div align="left">Tiempo de Respuesta </div></td>
              <td height="21" class="Estilo22"><div align="center">:</div></td>
              <td width="5%"><div align="left"><?php echo $pri->getTiempoHorasRespuesta() ?></div></td>
              <td width="40%"><div align="left">horas</div>                </td>
              <td width="15%" class="Estilo22"><div align="left">Fecha Estimada de Respuesta </div></td>
              <td width="3%" class="Estilo22"><div align="center">:</div></td>
              <td width="106" ><div align="left"><?php echo $doc->getFechaRespuesta() ?></div></td>
            </tr>
			</tbody>
          </table>
		</div>		
		</fieldset>
		<?php
			$tipo = 0;
			$estado = $doc->getEstado();

			if($_SESSION['session'][6]&&$estado->getId()!=14&&$estado->getId()!=15)
				$tipo = 1;

		?>	  	
		<form id="form_borrador_respuesta" name="f1" method="post" action="javascript:mostrar_confirmacion()" >
		<input type="hidden" id="id_doc" value="<?=$doc->getId()?>">
		<input type="hidden" id="tipo" value="<?=$tipo?>">
		<fieldset>
			<legend >ELABORAR BORRADOR DE RESPUESTA</legend>
				<table width="100%" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF" id="mantenimientod">
					<tr>
						<td width="3%" class="Estilo21" height="25"><div align="center">(*)</div></td>
						<td width="6%" class="Estilo22"><div align="left">Acci&oacute;n</div></td>
						<td width="3%" class="Estilo22"><div align="center">:</div></td>
						<td width="30%" ><div align="left">
                        <?php
							$acciones = new Acciones();
							if($_REQUEST['cat']==1){
								$accions = $acciones->getAcciones(2,$_SESSION['session'][0]);
							}else{
								$accions = $acciones->getAcciones(6,$_SESSION['session'][0]);
							}

							$tacciones = sizeof($accions);
                            
						?>
                        <select name="accion" style="width:200px" id="accion_borrador">
                          <option value="">--Seleccione Accion--</option>
                          <?php
								for($u = 0; $u < $tacciones; $u++){ ?>
                          <option value="<?php echo $accions[$u]['id']?>" <?=$visible?>>
                            <?php echo $accions[$u]['nombre']?>
                          </option>
                          <?php	}?>
                        </select>
                      	</div></td>
						<td width="2%" align="left" class="Estilo21"><div align="center">(*)</div></td>
						<td width="3%" align="left" class="22">
                            <div align="center">
							<input name="categoria" type="radio" value="1" id="original"/>
                                <?
                                    if(!$esOriginal){
									?>
                                        <script>javascript:deshabilitado();</script>
                  				<? }?>
                            </div>
                        </td>
						<td width="26%" align="left" class="Estilo22"><div align="left">Original</div></td>
						<td width="27%">&nbsp;</td>
					</tr>
					<tr>
						<td height="26" class="Estilo21" ><div align="center">(*)</div></td>
						<td class="Estilo22" ><div align="left">Pase a</div></td>
						<td class="Estilo22"><div align="center">:</div></td>
						<td ><div align="left">
                          <?php
							$area = new Area($_SESSION['session'][5]);
							$usuarios = $area->getUsuarios();
							$tusuarios = sizeof($usuarios);
							//Vemos si se activaran o no los combos
							$visible = "";
							if($_REQUEST["cat"]==2)
								$visible="class='disabled' disabled='disabled'";													
							?>
                          <select name="usuario" style="width:200px" id="usuario" <?=$visible?>>
                            <option value="">--Seleccione un Usuario--</option>
                            <?php
	  							for($u = 0; $u < $tusuarios; $u++){ ?>
                            <option value="<?php echo $usuarios[$u]['id']?>"> <?php echo $usuarios[$u]['nombre'].' '.$usuarios[$u]['apellidos'] ?> </option>
                            <?php
  								}
								?>
                          </select>
                          <input type="hidden" name="area" value="<?php echo $_SESSION['session'][5] ?>" />
                          <input type="hidden" name="user" value="<?php echo $_SESSION['session'][0] ?>" id="user"/>
                          <input type="hidden" name="cat" value="<?=$_REQUEST['cat']?>" id="cat"/>
                        </div>
						</td>
						<td align="left">&nbsp;</td>
						<td align="left">
							<div align="center">
								<input name="categoria" type="radio" id="copia" value="2" <?=($_REQUEST["cat"]==2)?"checked='checked'":""?>/>
							</div>						
						</td>
						<td align="left" class="Estilo22"><div align="left">Copia</div></td>
						<td>
							<div align="right">
								<input type="submit" name="guarda_historial" value="Agregar" class="boton" <?=$deshabilitado?>/>
							</div>
						</td>
					</tr>
			  </table>			
		</fieldset>
		</form>
		<br/>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="formularios"  id="lista_borradores">
		<tr bgcolor="#6699CC" class="Estilo7">
		  <td width="4%" height="25"><div align="center" class="msgok1"><strong>N&ordm;</strong></div></td>
			<td width="21%" ><div align="center" class="msgok1"><strong>ORIGEN</strong></div></td>
			<td width="21%"><div align="center" class="msgok1"><strong>DESTINO</strong></div></td>
			<td width="16%" ><div align="center" class="msgok1"><strong>Fecha y Hora</strong></div></td>
			<td width="16%"><div align="center" class="msgok1"><strong>Acci&oacute;n</strong></div></td>
			<td width="8%" ><div align="center" class="msgok1"><strong>Categor&iacute;a</strong></div></td>
			<td width="14%"><div align="center" class="msgok1"><strong>Opciones</strong></div></td>
		</tr>
		<?php
            $his_base = $doc->getHistorialAtencionDocumentos();
			$this_base = count($his_base);
			$ultimo_original = 0;
			
			for($i = 0 ; $i < $this_base ;$i++){
				if($his_base[$i]["original"] == 1 && $his_base[$i]["tipo"] != 6)
					$ultimo_original = $i;
			}
			
        	$cont = 0;
        

        for( $h = 0; $h < $this_base; $h++ ){
            $clase = "class='historial'";
            $archivo=array();
            $observacion = trim($his_base[$h]['comentario']);
            
			if($his_base[$h]['tipo']==1){//Area a Area (Derivacion de documento)
				$origen=$his_base[$h]['area']->GetNombre();
				$destino=$his_base[$h]['area_destino']->GetNombre();
			}
			elseif($his_base[$h]['tipo']==0){//Area a Usuario
					$origen=$his_base[$h]['area']->GetNombre();				
					$destino=$his_base[$h]['destino']->GetNombreCompleto();
				}
				elseif($his_base[$h]['tipo']==2){//Usuario a su Area
					$origen=$his_base[$h]['usuario']->GetNombreCompleto();
					$destino=$his_base[$h]['area_destino']->GetNombre();
					$archivo = $doc->obtenerJustificacionesEscaneadas($his_base[$h]['id']);
				}
				elseif($his_base[$h]['tipo']==3){//Usuario a Usuario en borradores
                    $origen=$his_base[$h]['usuario']->GetNombreCompleto();
					$destino=$his_base[$h]['destino']->GetNombreCompleto();
                    $archivo = $doc->obtenerBorradoresEscaneados($his_base[$h]['id']);
                    $clase = "class='filas'";
                }
				elseif($his_base[$h]['tipo']==4 ||$his_base[$h]['tipo']==5){//Usuario a Usuario en historial de atencion
                    $origen=$his_base[$h]['usuario']->GetNombreCompleto();
					$destino=$his_base[$h]['destino']->GetNombreCompleto();	
					$archivo = $doc->obtenerJustificacionesEscaneadas($his_base[$h]['id']);				
                }	
				elseif($his_base[$h]['tipo']==6){//Es de MESA a AREA
                    $origen="DESPACHO GENERAL";
					$destino=$his_base[$h]['area_destino']->GetNombre();
                }
				elseif($his_base[$h]['tipo']==7){//Es de AREA a MESA
                    $origen=$his_base[$h]['area']->GetNombre();
					$destino="DESPACHO GENERAL";
                }						
		?>
		<tr <?=$clase?>>
			<td><?php echo ++$cont ?></td>
			<td><?php echo $origen?></td>
			<td><?php echo $destino ?></td>
			<td><?php echo $his_base[$h]['fecha'] ?></td>
			<td><?php echo ($his_base[$h]['tipo']!=7)?$his_base[$h]['accion']->GetNombre():"DEVOLVER A DESPACHO" ?></td>
			<td><?php if($his_base[$h]['original']==1){echo "Original";}else{echo "Copia";}?></td>
			<td>
                <div align="center">
					<?                                        
                    //Observacion - comentario
                    if($his_base[$h]['tipo']==3&&!empty($observacion)){?>                  
                    <a href="javascript:VerComentario(<?php echo $h + 1 ?>)">
                        <img src="public_root/imgs/b_search.png" border="0" alt="Ver Detalle" title="Ver Comentario"/>
					</a>
                    <? }elseif($his_base[$h]['tipo']==3&&empty($observacion)){
                    ?>                    
                        <img src="public_root/imgs/b_search_d.png" border="0" alt="Ver Detalle" title="Ver Comentario"/>                    <? }
                    elseif(!empty($observacion)){?>                    
                    <a href="javascript:VerDetalleObservacion(<?php echo $h + 1 ?>)">
                    	<img src="public_root/imgs/b_search.png" border="0" alt="Ver Detalle" title="Ver Comentario"/>
					</a>
                    <? }else{?>
                        <img src="public_root/imgs/b_search_d.png" border="0" alt="Ver Detalle"/>
                    <? } ?>
					<?
                    //Detalle Borrador
                    if($his_base[$h]['tipo']==3){?>
                    <a href="javascript:VerDetalleBorrador(<?=$his_base[$h]['id']?>)">
                        <img src="public_root/imgs/file.gif" border="0" alt="Ver Detalle" title="Ver Borrador de Respuesta"/>
					</a>
                    <? } else{?>
						<img src="public_root/imgs/file_d.png" border="0" alt="Ver Detalle" title="Ver Borrador de Respuesta"/>
		            <? }
                    //Archivo Escaneado					
                    if(count($archivo)>0){
						if($his_base[$h]['tipo']==2||$his_base[$h]['tipo']==5)
							$ruta = 'Justificados/';
						else
							$ruta = 'Archivados/';					
					?>					
                    <a href="javascript:void(0)" onclick="ver_mas_adjuntos($(this))">
                        <img src="public_root/imgs/attach.png" alt="Documento" border="0" title="Ver Documento Adjunto">                    </a>
					<div id="doc_adjuntos<?php echo ($cont) ?>" class="doc_adjuntos">
						<p>Documentos Adjuntos : </p>
						<? 						
							for($i = 0; $i < count($archivo); $i++){								
							?>
								<p><a href="<?=$ruta.rawurlencode($archivo[$i])?>" target="_blank"><?=$archivo[$i]?></a></p>
						<? }?>
					</div>	
                    <? }else{?>
                        <img src="public_root/imgs/attach_d.png" alt="Documento" border="0" title="Ver Documento Adjunto">
                    <? }					
					//Editar
					if($his_base[$h]['tipo']==3){
					if($_SESSION['session'][6]||$his_base[$h]['usuario']->getId()==$_SESSION['session'][0]){?>
                    <a href="javascript:EditarBorrador(<?=$his_base[$h]['id']?>);">
					<img src="public_root/imgs/b_edit.png" alt="Ver Documento" border="0" title="Editar Documento">                    </a>
                    <? 
					}else{?>
					<img src="public_root/imgs/b_edit_d.png" alt="Ver Documento" border="0" title="Editar Documento">	
						<? }
					}else{?>
					<img src="public_root/imgs/b_edit_d.png" alt="Ver Documento" border="0" title="Editar Documento">	
					<? }
					//Eliminar
					if(($his_base[$h]['usuario']->getId()==$_SESSION['session'][0]||
						$his_base[$h]['destino']->getId()==$_SESSION['session'][0])&&$his_base[$h]['original'] != 1){?>
                    <a href="atencion_acceso_registro.php?opcion=deleteha&id=<?=$doc->getId()?>&idb=<?=$his_base[$h]['id']?>&cat=<?=$_REQUEST["cat"]?>&tipo=<?=$his_base[$h]['tipo']?>">
                        <img src="public_root/imgs/b_drop.png" alt="Eliminar" border="0" title="Eliminar">
					</a>
                    <? }elseif(($his_base[$h]['usuario']->getId()==$_SESSION['session'][0]||
						$his_base[$h]['destino']->getId()==$_SESSION['session'][0])&& $ultimo_original == $h ){?>
                    <a href="atencion_acceso_registro.php?opcion=deleteha&id=<?=$doc->getId()?>&idb=<?=$his_base[$h]['id']?>&cat=<?=$_REQUEST["cat"]?>&tipo=<?=$his_base[$h]['tipo']?>">
                        <img src="public_root/imgs/b_drop.png" alt="Eliminar" border="0" title="Eliminar">
					</a>
                    <? }else{?>
						<img src="public_root/imgs/b_drop_d.png" alt="Eliminar" border="0" title="Eliminar">
                    <? } 
					?>       
				</div>			</td>
		</tr>
        <? if($his_base[$h]['tipo']==3){?>
        <tr>
			<td colspan="7" align="justify">
				<div style="display:none; margin-left:35px;" id="detalle_borrador<?php echo $h + 1; ?>">
					<?=$his_base[$h]['comentario']?>				
			  </div>			</td>
		</tr>
        <? }else{?>
		<tr>
			<td colspan="7" align="justify">
				<div style="display:none; margin-left:35px;" id="detalle_observacion<?php echo $h + 1; ?>">
					<?=$his_base[$h]['comentario']?>
			  </div>
			</td>
		</tr>
        <? }
       }
       if($esOriginal){
           $estado =  $doc->getEstado();
           if($estado->getId()==4&&!$doc->TengoElDocDAOriginal($_SESSION['session'][0])){
            ?> <script>javascript:deshabilitado();</script>
            <?
            }elseif($estado->getId()==6&&!$doc->TengoElBorradorOriginal($_SESSION['session'][0])){
            ?> <script>javascript:deshabilitado();</script>
            <?}
            else{?> <script>
                javascript:habilitado();
                javascript:deshabilita_copia();
           </script>
            <? }?>
            <script>
                javascript:accion_por_defecto(<?=$estado->getId()?>);
            </script>
       <?
       }
    ?>
    </table>
	<div id="question" style="display:none; cursor: default"> 
		<p class="Estilo22">
				&iquest;Est&aacute; seguro que desea enviar un 
				<span id="conf_categoria" style="font-weight:bold; color: #D3455A">a</span> 
				del documento a <span id="conf_usuario" style="font-weight:bold; color:#D3455A">b</span>?
		</p>
		<p class="Estilo22">
			<input type="button" id="yes_a_d" value="Si" class="boton"/> 
			<input type="button" id="no_a_d" value="No" class="boton"/> 
		</p>
	</div>
	<?php
    }

    function getDocumentosConFiltro(){

		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;

		$sql = " SELECT * FROM documentos  ";
		$query = new Consulta($sql);
	}
		
	function GuardarArchivo($borrador){
	
	if($_FILES['doc']){
	$keys = array_keys($_FILES['doc']);
	$destino = "Archivados/";
	
	echo  "<div id='error'>";

    for($u=0; $u < count($keys); $u++){
		if(!empty($_FILES['doc']['name'][$u])){				
			if( $_FILES['doc']['size'][$u] > ( 2*1024*1024 ) ){
				echo "El tama�o del archivo supera al permitido";
			}
			elseif(!move_uploaded_file($_FILES['doc']['tmp_name'][$u], $destino.$_FILES['doc']['name'][$u])){
				echo "ocurrio error al subir archivo " . $_FILES['doc']['name'][$u] ;			 				
			}else{
				$sql = " INSERT INTO borrador_escaneado VALUES( '', ".$borrador.",'".$_FILES['doc']['name'][$u]."') ";
				$query = new Consulta($sql);
				echo "se subio el archivo <b>" . $_FILES['doc']['name'][$u] . "</b> satisfactoriamente <br>" ;	
			}	
		}
	}
	}
	else{
		echo  "<div id='error'>";
	}	 	
    }

	function GuardarArchivoJustificacion($atencion){
	
	if($_FILES['doc']){
	$keys = array_keys($_FILES['doc']);
	$destino = "Justificados/";
	
	echo  "<div id='error'>";

    for($u=0; $u < count($keys); $u++){
		if(!empty($_FILES['doc']['name'][$u])){
			if( $_FILES['doc']['size'][$u] > ( 2*1024*1024 ) ){
				echo "El tama�o del archivo supera al permitido";
			}
			elseif(!move_uploaded_file($_FILES['doc']['tmp_name'][$u], $destino.$_FILES['doc']['name'][$u])){
				echo "ocurrio error al subir archivo " . $_FILES['doc']['name'][$u] ;			 				
			}else{
				$sql = " INSERT INTO justificado_escaneado VALUES( '', ".$atencion.",'".$_FILES['doc']['name'][$u]."') ";
				$query = new Consulta($sql);
				echo "se subio el archivo <b>" . $_FILES['doc']['name'][$u] . "</b> satisfactoriamente <br>" ;	
			}	
		}
	}
	}
	else{
		echo  "<div id='error'>";
	}	 	
    }

}
?>
