<?php

class Atencion {
    
    function listado($ide ='',$dias = false){	
        $vencidos = false;
        $page = (isset($_GET['pag']) && is_numeric($_GET['pag']) && $_GET['pag']>0 )? $_GET['pag']-1 : 0;
        $rows_per_page = 20;
        $area_session = $_SESSION['session'][5];
        
            $field_dias_faltantes = "
                DATEDIFF( 
                    ADDDATE(d.fecha_registro_documento, 
                      p.tiempo_horas_respuesta_prioridad/24 ),
                    CURDATE() 
                      )
            ";    
        
            $fields_hd = "
                        hd.id_documento as id,
                        dr.id_documento_reporte as detalle_id,
                        dr.ubicacion,
                        d.fecha_registro_documento as fecha,
                        d.asunto_documento as asunto,
                        d.codigo_documento as codigo,
                        td.nombre_tipo_documento as tipo,
                        r.nombre_remitente as remitente,
                        hd.original_historial_documento as categoria,
                        d.numero_documento as numero,
                        d.id_estado as id_estado,
                        e.abrev_nombre_estado as estado,
                        $field_dias_faltantes AS dias_faltantes
            ";
            
            $fields_ha = "
                        ha.id_documento as id,			
                        dr.id_documento as detalle_id,	
                        dr.ubicacion,
                        d.fecha_registro_documento as fecha,
                        d.asunto_documento as asunto,
                        d.codigo_documento as codigo,
                        td.nombre_tipo_documento as tipo,
                        r.nombre_remitente as remitente,
                        ha.original_historial_atencion as categoria,
                        d.numero_documento as numero,
                        d.id_estado as id_estado,
                        e.abrev_nombre_estado as estado,
                        $field_dias_faltantes  AS dias_faltantes
            ";
            
        if ($ide==''){
            $where 	= "WHERE
                        (((d.id_estado = '4' OR d.id_estado = '12' OR d.id_estado = '11' 
                        OR d.id_estado = '6' OR d.id_estado = '16' OR d.id_estado = '17' 
                        OR d.id_estado = '18' OR d.id_estado = '3' OR d.id_estado = '13' 
                        OR d.id_estado = '14' OR d.id_estado = '15')";                 	
        }
        else{

            if($ide=="LT")
                $where="WHERE ";
            else if($ide=="atencion"){
                $req = (object)$_REQUEST;
                
                
                $where ="WHERE d.id_estado NOT IN(11)  ";
                
                $areas = new Areas();
                $area_session=$areas->getIDs();
                if( isset($req->remitente) ){
                    $where .="AND ( r.abreviatura_remitente like '%$req->remitente%' OR r.nombre_remitente like '%$req->remitente%' ) ";
                }
                
                if( isset($req->area) && $req->area){
                    $area_session=$req->area;
                }
                
                if( isset($req->pendientes) ){
                    if(isset($req->area) ) {
                        $area_session=$req->area;
                        #$where .= " AND $req->area LIKE CONCAT(dr.ubicacion,'%')";
                    }
                    $where.="AND d.id_estado IN (3,4,6,13,14,15,16,17,18) 
                        AND $field_dias_faltantes  >=0
                        ";
                }
                
                if( isset($req->atendidos) ){
                    $where.="AND d.id_estado IN (12) ";
                }else{    
                    $where.="AND d.id_estado NOT IN (12) ";
                }
                
                if( isset($req->vencidos)  ){
                    $where.="
                    AND d.id_estado NOT IN (12) 
                    AND $field_dias_faltantes <0
                    ";
                    $vencidos = true;
                }

            }else if( is_numeric($ide) ){
                    $where="AND d.id_estado = $ide ";
            }
            /*
            Tasks.
                Revisar Busaqueda de documento para mostrar detalle;
                Paginación.
                Ordenación por Encabezados
            */                        
            

        }//Fin de if ide
            $select_historial = "
                            SELECT
                                $fields_hd
                            FROM
                                historial_documentos AS hd
                            INNER JOIN 
                                documentos AS d ON d.id_documento = hd.id_documento
                            INNER JOIN 
                                estados AS e ON e.id_estado = d.id_estado
                  			INNER JOIN
								prioridades AS p ON p.id_prioridad = d.id_prioridad
                            LEFT JOIN 
                                remitentes AS r ON r.id_remitente = d.id_remitente
                            LEFT JOIN 
                                tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
                          	 INNER JOIN
								documentos_reporte as dr ON hd.id_documento = dr.id_documento 	
                            $where
                            ".
                            ($where != 'WHERE '?"AND" :"") 
                            ."
                               (( hd.original_historial_documento = 1) OR hd.original_historial_documento = 2 )
                                AND hd.id_area IN ($area_session)
                                
                            GROUP BY id
            ";            
            
            $select_atencion = "
                            SELECT
                                $fields_ha
                            FROM
                                historial_atencion AS ha
                            INNER JOIN 
                                documentos AS d ON ha.id_documento = d.id_documento
                            INNER JOIN 
                                estados AS e ON d.id_estado = e.id_estado
                  			INNER JOIN
                                prioridades AS p ON p.id_prioridad = d.id_prioridad
                            LEFT JOIN 
                                tipos_documento AS td ON d.id_tipo_documento = td.id_tipo_documento
                            LEFT JOIN 
                                remitentes AS r ON d.id_remitente = r.id_remitente
                          	INNER JOIN
								documentos_reporte as dr ON ha.id_documento = dr.id_documento 	
                            $where
                            ".
                            ($where != 'WHERE '?"AND" :"") 
                            ."
                             
                              ((  ha.original_historial_atencion = 1) OR ha.original_historial_atencion = 2 )
                            AND(
                                (ha.id_area IN ($area_session) AND ha.tipo_historial_atencion=0) OR
                                (ha.id_area_destino IN ($area_session) AND ha.tipo_historial_atencion=1) OR
                                (ha.id_area_destino IN ($area_session) AND ha.tipo_historial_atencion=2)
                            )
                            
                            GROUP BY id
            ";
        
            $order_limit_sql = "
                            ORDER BY 
                                dias_faltantes DESC, categoria ASC
                            LIMIT ".( $page * $rows_per_page ).",$rows_per_page
                        ";
            
            
            $sql_reg = "
                        ( $select_historial )
                        UNION
                        ( $select_atencion )    
                        
                        ";

        $query_reg=new Consulta($sql_reg.$order_limit_sql);
        $total_rows_query = new Consulta(" SELECT COUNT(*) FROM ( $sql_reg ) as total");
        #echo $query_reg->SQL;
        $total_rows = $total_rows_query->getRow();
        ?>
        
    <?if($total_rows>0){?>
    
    
    <?
        ob_start();
        $total_pages = ceil( $total_rows/$rows_per_page );
        
        $page++;
        if( $total_pages > 1){?>
        <div class="pagination">
            <span>Total de p&aacute;ginas: </span><strong><?=$total_pages?></strong> | 
            
            <span for="toPage">Ir a P&aacute;gina:</span>
            <select id="toPage">
                <?for($p = 1; $p<=$total_pages;$p++){?>
                <option <?=($p==$page?'selected="selected"':'')?> value="<?=$p?>">&nbsp;&nbsp;<?=$p?> </option>
                <?}?>
            </select>
             |  
            <?if($page > 1){?>
            <a href="" class="1" >&laquo; Primera</a> 
            <a href="" class="<?=$page-1?>">&laquo; Anterior</a> 
            <?}?>
            <strong class="active">[P&aacute;gina <?=$page?>]</strong>
            <?if($page < $total_pages){?>
            <a href="" class="<?=$page+1?>">Siguiente &gt</a> 
            <a href="" class="<?=$total_pages?>">Ultima &raquo;</a> 
            <?}?>
            
        </div>
    <?}
        $pagination = ob_get_contents();
        ob_clean();
    ?>
    
    <?=$pagination?>
    
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
            $count = 0;
            while($row_reg=$query_reg->ConsultaVerRegistro()){
                    $count++;
                    $ids=$row_reg["id"];		
                    $detalle_id=$row_reg["detalle_id"];		
                    $estado=$row_reg["id_estado"];
                    $anterior = $codigo;
                    $codigo=$row_reg["codigo"];
                    $cat = $row_reg["categoria"];       
                    $loTengo = true;
                    
                    if($codigo!=$anterior){
                    
                    $clase = "Estilo7";						
                    if($estado==12){
                        $clase = "Estilo7 fila_finalizada";
                    }else{
                        $dias_faltantes = $row_reg['dias_faltantes'];
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
                    
                <tr class="ui-widget-content1 jqgrow <?=$clase?> ">		
                    <td width="16%" <?=$tooltip_asunto?>>
                        <div align="center"> 		  
                            <a target="_blank" href="detalle_documento.php?id=<?=$detalle_id?>">
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

                    $sql_data=" SELECT a.nombre_area, a.abve_nombre_area
                                FROM
                                areas AS a 
                                WHERE
                                a.id_area IN ($area_session) ";
                                
                    $query_data=new Consulta($sql_data);		
                    $data=$query_data->ConsultaVerRegistro();
                ?>
                  <td title="DR[<?=$row_reg["ubicacion"]?>] - HD <?=$data['nombre_area'];?>">
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
                    <input name="text" type="text" value="<?=$row_area_derivado["abreviatura"]?>"  title="<?=isset($usu['abve_nombre_area'])? $usu['abve_nombre_area'] :''?>" />
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
                <?/*
                    <tr class="ui-widget-content1 jqgrow <?=$clase?>">
                        <td colspan="6"><?dump($row_reg)?></td>
                    </tr>
                */?>
                <?
        
            }//Fin de if anterior = codigo
         } //Fin de While
         ?>
             </table>
            </td>
        </tr>
    </table>
    
    </div>
    <?}else{?>
        <div class="no_results">
            No se han encontrado documentos...
        </div>
    <?}?>
<?
    }
}
?>