<?
class FisicoFinanciero extends SqlSelect {

var $md=false;
var $simbolomd=" S/. ";
var $estado=false;
		
	function FisicoFinanciero(){
	  $this->SqlSelect($anpid,$_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
	}

//$_SESSION['anp']['idanp']
	function mostrar_ff_chk($fuente=''){
		$funcjs=" mostrar_fisico_financiero";
		VerChkff($funcjs,$this);	 
	}

	



function mostrar_fisico_financiero($ftefto){
		$gsql=$this->SqlFtt($ftefto);

		$th_fuent="";
		for($i=0;$i<count($ftefto);$i++){
			$th_fuente.='<th class="th2" width="3%" align="center" nowrap="nowrap">'.fuente_siglas($ftefto[$i]).'</th>';
			$td_fuente.='<td class="td2" > &nbsp;</td>';
		}
			echo '<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="tab">
			  <tr>
					<th class="th2" width="5%" rowspan="2" align="center">Codigo</th>
					<th class="th2" width="15%" rowspan="2" align="center">Obj. Estratégicos / Obj. Especificos/ Tarea</th>
  	 				<th class="th2" colspan="2" align="center">Meta</th>
					<th class="th2" colspan="'.(count($ftefto)).'" align="center">Total (S/.)</th>
					<th class="th2" colspan="12" align="center">Cronograma</th>
			  </tr>
				<tr>
					<th class="th2" width="6%">Unidad</th>
					<th class="th2" width="6%">Cantidad</th>					
					'.$th_fuente.'									
					<th class="th2" width="2%" align="center">E</th>
					<th class="th2" width="2%" align="center">F</th>
					<th class="th2" width="2%" align="center">M</th>
					<th class="th2" width="2%" align="center">A</th>
					<th class="th2" width="2%" align="center">M</th>
					<th class="th2" width="2%" align="center">J</th>
					<th class="th2" width="2%" align="center">J</th>
					<th class="th2" width="2%" align="center">A</th>
					<th class="th2" width="2%" align="center">S</th>
					<th class="th2" width="2%" align="center">O</th>
					<th class="th2" width="2%" align="center">N</th>
					<th class="th2" width="2%" align="center">D</th>
			  </tr>
			  <tr>';

			 //PROGRAMA ///////////////////////////////////////////////////////////////////////
				
				$sqlprg=$this->set_sql("oe.*",$gsqlp,"oe.id_objetivo_estrategico","codigo_objetivo_estrategico");
				$query=new Consulta($sqlprg);
				while($row_prg=$query->ConsultaVerRegistro()){ 
					//$prg=table_row($row_prg[id_programa],"programa");
					
					$this->registro_programa($row_prg,$ftefto);
					
						//SUB PROGRAMA///////////////////////////////////////////////////////////////////////
						$gsqlsp=$gsqlp." AND oe.id_objetivo_estrategico='".$row_prg[id_objetivo_estrategico]."'";
						$sql_sb=$this->set_sql("aoesp.*",$gsqlsp,"aoesp.id_anp_objetivo_especifico ","codigo_objetivo_especifico");
						$query_sb=new Consulta($sql_sb);
						while($row_sb=$query_sb->ConsultaVerRegistro()){ 
							//$sbprg=table_row($row_sb[id_subprograma],"subprograma");
							$gsqla=$gsqlsp." AND aoesp.id_anp_objetivo_especifico='".$row_sb[id_anp_objetivo_especifico]."'";
							$this->registro_subprograma($row_prg,$row_sb,$ftefto);
							
							//ACTIVIDAD///////////////////////////////////////////////////////////////////////
								$sql_a=$this->set_sql("t.*,afao.*,aao.*", $gsqla, " nro_asignacion", "nro_asignacion");
								$query_a=new Consulta($sql_a);
								while($row_a=$query_a->ConsultaVerRegistro()){ 
									//$actividad=table_row($row_a[id_actividad],"actividad");
									
									$this->registro_actividad($row_prg,$row_sb,$row_a,$ftefto);
										
											/*//SUB ACTIVIDAD ///////////////////////////////////////////////////////////////////////
											$sql_sa=$this->set_sql(
													"sa.id_subactividad, sa.nombre_subactividad, sa.codigo_completo_subactividad, asb.id_anp_subactividad, asb.id_anp,asb.id_axo_poa ", 
													$gsql." AND (s.id_subprograma='".$sbprg[id_subprograma]."' AND  s.id_programa='".$row_prg[id_programa]."' AND sa.id_actividad='".$row_a[id_actividad]."')",
													"fas.id_anp_subactividad","sa.id_subactividad");
													//msql($sql_sa);
													$query_sa=new Consulta($sql_sa);
													while($row_sa=$query_sa->ConsultaVerRegistro()){ 
														$this->registro_subactividad($row_sa,$ftefto);
													}//fin SubActividad*/
								} // fin actividad
						} //fin sub programa
			  	}//fin programa
			
					 echo ' <tr>
							<td class="tdtotal" valign="top">&nbsp;</td>
							<td class="tdtotal" valign="top" align=right><font size=2>TOTAL '.$this->simbolomd .'
							&nbsp;</font></td>
							<td class="tdtotal" valign="top">&nbsp;</td>
							<td class="tdtotal" valign="top"  align="right">&nbsp;</td>';
						$cls="tdtotal"; 
						$campo=" pf.id_ff";
						$campogroup=$campo;
						$campoorder=$campo;
						$td_fuente=$this->generar_td_fuente($ftefto,$cls,$cwhere,$campogroup,$campoorder);
						echo $td_fuente;
						echo '<td class="tdtotal" colspan="12" align="center">&nbsp;</td>
					       </tr> </table>';
	}

	function registro_programa($prg,$ftefto){
						$cls="tdprg"; 
						$campo=" oe.id_objetivo_estrategico";
						$cwhere=" AND ".$campo."='".$prg[id_objetivo_estrategico]."'";
						$campogroup=$campo;
						$campoorder=$campo;
						$td_fuente=$this->generar_td_fuente($ftefto,$cls,$cwhere,$campogroup,$campoorder);
			if($this->estado){	
						echo '<tr><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_objetivo_estrategico].'</td>
						<td class="'.$cls.'" width="6%"> &nbsp;</td>
						<td class="'.$cls.'" width="6%"> &nbsp;</td>					
						'.$td_fuente.'										
						<td class="'.$cls.'" width="2%" nowrap="nowrap" nowrap="nowrap" colspan="12" align="center">&nbsp;</td>
					</tr>';
			}		
	}

	function registro_subprograma($prg,$sbprg,$ftefto){
						$cls="tdsubprg"; 
						$campo=" aoesp.id_anp_objetivo_especifico";
						$cwhere=" AND ".$campo."='".$sbprg[id_anp_objetivo_especifico]."'";
						$campogroup=$campo;
						$campoorder=$campo;
						$td_fuente=$this->generar_td_fuente($ftefto,$cls,$cwhere,$campogroup,$campoorder);
			if($this->estado){	
						echo '<tr><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].".".$sbprg[codigo_objetivo_especifico].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_objetivo_especifico].'</td>
						<td class="'.$cls.'" width="6%"> &nbsp;</td>
						<td class="'.$cls.'" width="6%"> &nbsp;</td>					
						'.$td_fuente.'										
						<td class="'.$cls.'" width="2%" nowrap="nowrap" colspan="12" align="center">&nbsp;</td>
					</tr>';
			}
	}


	function registro_actividad($prg,$sbprg,$actividad,$ftefto){
						//$cls="tdact"; 
						$chkmeses=chekar_cronogramas_anp_suba($actividad,$this->SqlFts);
						$meta=suma_meta_anp_subactividad($actividad,$this->SqlFts,true);
				
				//if($meta[cantidad][0]){				
						//print_r($sbprg);
						$filtro=" AND aoesp.id_anp_objetivo_especifico='".$sbprg[id_anp_objetivo_especifico]."'";
						$campo=" t.id_tarea";
						$cwhere=$filtro." AND ".$campo."='".$actividad[id_tarea]."'";
						$campogroup=$campo;
						$campoorder=$campo;
						$td_fuente=$this->generar_td_fuente($ftefto,$cls,$cwhere,$campogroup,$campoorder);
			if($this->estado){	
						echo '<tr><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].".".$sbprg[codigo_objetivo_especifico].".".$actividad[nro_asignacion].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nom_tarea].'</td>
						<td class="'.$cls.'" width="6%"  > &nbsp;'.$actividad[medio_verificacion_tarea].'</td>
						<td class="'.$cls.'" width="6%" align="center" > '.number_format($meta[cantidad][0],2,".",",").'</td>				
						'.$td_fuente;										
						
						
						echo '<td class="'.$cls.'" width="2%" valign="top" align="center"
						nowrap="nowrap" >&nbsp;'.$chkmeses[1].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[2].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[3].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[4].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[5].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[6].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[7].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[8].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[9].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[10].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[11].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[12].'&nbsp;</td>
					</tr>';
			}	
	}

	function registro_subactividad($subactividad,$ftefto){
				/*		$cls="tdsubact"; 
						$cwhere=" AND asb.id_anp_subactividad='".$subactividad[id_anp_subactividad]."'";
						$campogroup="sa.id_subactividad";
						$campoorder="sa.id_subactividad";
						$td_fuente=$this->generar_td_fuente($ftefto,$cls,$cwhere,$campogroup,$campoorder);
						
						$chkmeses=chekar_cronogramas_anp_suba($subactividad,$this->SqlFts);
						$meta=suma_meta_anp_subactividad($subactividad,$this->SqlFts,true);
						
						echo '<tr><td class="'.$cls.'" valign="top" >'.$subactividad[codigo_completo_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" valign="top" >'.$subactividad[nombre_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" width="6%"  > &nbsp;'.$meta[nombre][0].'</td>
						<td class="'.$cls.'" width="6%" align="center" > '.num_format($meta[cantidad][0]).'</td>					
						'.$td_fuente;
						echo '<td class="'.$cls.'" width="2%" valign="top" align="center"
						nowrap="nowrap" >&nbsp;'.$chkmeses[1].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[2].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[3].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[4].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[5].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[6].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[7].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[8].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[9].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[10].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[11].'&nbsp;</td>
							<td class="'.$cls.'" width="2%" valign="top" align="center" nowrap="nowrap">&nbsp;'.$chkmeses[12].'&nbsp;</td>
					</tr>';*/
	}

	function generar_td_fuente($ftefto,$cls,$cwhere='',$campogroup='',$campoorder=''){
		$this->estado=false;
		for($i=0;$i<count($ftefto);$i++){
			$cSuma=$this->sumar_programado_fuente($ftefto[$i],$cwhere,$campogroup,$campoorder);
			if($cSuma[monto_total]){
				if ($this->md){
					$numero=$cSuma[monto_total]/$this->tipo_de_cambio;
				}else{
					$numero=$cSuma[monto_total];
				}
				
				$numero=number_format(($numero),2,".",",");
				$this->estado=true;
			}else{
				$numero="";
			}
			
			if (empty($numero)){
				$numero="&nbsp;";
			}
			$td_fuente.='<td  align="right" class="'.$cls.'" >'.$numero.'</td>';
		}		
		return $td_fuente;		
	}
}
?>


	