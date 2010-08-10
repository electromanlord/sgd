<div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tabla_despacho" class="gview_frmgrid">
	
	<tr bgcolor="#6699CC" class="ui-widget-header ui-th-column grid_resize" height="25">    
        <th width="17%" class="ui-widget-header ui-th-column grid_resize">Reg. Nro</th>
        <th width="27%" class="ui-widget-header ui-th-column grid_resize">Remitente</th>
        <th class="ui-widget-header ui-th-column grid_resize">Documento</th>
        <th width="14%" class="ui-widget-header ui-th-column grid_resize">Registrado</th>
        <th width="6%" class="ui-widget-header ui-th-column grid_resize">Estado</th>
        <th width="5%" class="ui-widget-header ui-th-column grid_resize">Cat</th>
	</tr>

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

			if( $tam_borr_orig>0 && 
				!$doc[$d]->TengoElBorradorOriginal($_SESSION['session'][0]) &&
				$docs[$d]['original']==1&&$estado==6 ){
				//hay un historial de borradores donde se ha enviado el original y yo no tengo el original
				//No se debe mostrar asi que no pasa nada
				$muestra_copia = true;
				//Como no se mostro original se muestra la copia
			}elseif( $docs[$d]['original']==1 &&
				($estado==4||$estado==14||$estado==15) &&
				!$doc[$d]->TengoElDocDAOriginal($_SESSION['session'][0]) ){
                //Viene de despacho de area y no lo tengo
                $muestra_copia = true;
            }
			elseif($docs[$d]['original']==2&&$doc[$d]->copiaArchivadaUsuario()){			
				//Esta archiovada no se muestra la copia	
				//echo "archivo->".$docs[$d]['id'];			
			}			
            else{
				// Se mostrara el original, ya no se muestra copia
				$muestra_copia = false;               		
				
				$clase = "Estilo7";
						
				if($estado==12){
					$clase = "Estilo7";
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
				<td <?=$tooltip_asunto?> >
					<div align="center">
					  <?php if(($estado != 12&&$estado != 11)||$docs[$d]['original']==2){ ?>
						<a href="atencion_acceso_registro.php?opcion=detalle&cat=<?=$docs[$d]['original']?>&id=<?php echo $doc[$d]->getId()?>"><?php echo $doc[$d]->getCodigo()?></a>
					  <? }
						else{
							echo $doc[$d]->getCodigo();
						}
						?>
			        </div>
				</td>
				<td align="left" >
					<?php $dtd = $doc[$d]->getRemitente();?>
					<input type="text" value="<?=$dtd->getNombre()?>" size="40" style="border:none"/></td>
				<td align="left">
					<input type="text" value="<?=$doc[$d]->getNumero()?>" size="50" style="border:none"/>
				</td>
				<td >
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
			<!--
			<tr colspan="5">
				<?#dump($doc[$d]);?>
			</tr>
			-->
			<?php
				}//Fin del elseif
				}//Fin de if anterior
			}//Fin del for			
			?>
	</tr>
</table>
</div>