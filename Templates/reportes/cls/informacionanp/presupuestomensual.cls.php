<?
class PresupuestoMensual extends SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;


	function PresupuestoMensual(){
	    $this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
	}
	
	

	function mostrar_ff_chk($fuente=''){
		$funcjs=" mostrar_presupuestomensual";
		VerChkff($funcjs,$this);	 
	}
	
	function setsql($sql=''){
		$sqlmultiplicarxtc="/ pf.tipo_cambio_ff";
			$sqlA=" SELECT  sum(monto_programacion_partidas_meses ) as total_monto, id_mes
					FROM
					`programacion_partidas_meses` AS `ppm`,
					`programacion_partidas` AS `pp` ,
					`asignacion_ff_anp_objetivos` AS `afao`,
					`asignacion_anp_objetivos` AS `aao` ,
					`presupuesto_anp` AS `pa`,
					`presupuesto_ff` AS `pf` ,
					`fuente_financiamiento` AS `ff` ,
					`anp_objetivo_especifico` AS `aoesp`,
					`tarea` AS `t` ,
					`anp_objetivo_estrategico` AS `aoest` ,
					`objetivo_estrategico` AS `oe` 
					WHERE 
					`ppm`.`id_programacion_partidas` = `pp`.`id_programacion_partidas` and
					`afao`.`id_asignacion_ff_anp_objetivos` = `pp`.`id_ff_anp_subactividad` and
					`aao`.`id_asignacion_anp_objetivos` = `afao`.`id_asignacion_anp_objetivos` and
					`pa`.`id_presupuesto_anp` = `afao`.`id_presupuesto_anp` and
					`pf`.`id_presupuesto_ff` = `pa`.`id_presupuesto_ff` and
					`ff`.`id_ff` = `pf`.`id_ff` and
					aoesp.`id_anp_objetivo_especifico` = `aao`.`id_anp_objetivo_especifico` and
					`t`.`id_tarea` = `aao`.`id_tarea` and
					`aoest`.`id_anp_objetivo_estrategico` = `aoesp`.`id_anp_objetivo_estrategico` and
					`oe`.`id_objetivo_estrategico` = `aoest`.`id_objetivo_estrategico` ".$sql."

					group by id_mes
					ORDER BY id_mes";

		if ($this->md){
		
			$sqlB=" SELECT  sum(monto_programacion_partidas_meses".$sqlmultiplicarxtc." ) as total_monto, id_mes
					FROM
					`programacion_partidas_meses` AS `ppm`,
					`programacion_partidas` AS `pp` ,
					`asignacion_ff_anp_objetivos` AS `afao`,
					`asignacion_anp_objetivos` AS `aao` ,
					`presupuesto_anp` AS `pa`,
					`presupuesto_ff` AS `pf` ,
					`fuente_financiamiento` AS `ff` ,
					`anp_objetivo_especifico` AS `aoesp`,
					`tarea` AS `t` ,
					`anp_objetivo_estrategico` AS `aoest` ,
					`objetivo_estrategico` AS `oe` 
					WHERE 
					`ppm`.`id_programacion_partidas` = `pp`.`id_programacion_partidas` and
					`afao`.`id_asignacion_ff_anp_objetivos` = `pp`.`id_ff_anp_subactividad` and
					`aao`.`id_asignacion_anp_objetivos` = `afao`.`id_asignacion_anp_objetivos` and
					`pa`.`id_presupuesto_anp` = `afao`.`id_presupuesto_anp` and
					`pf`.`id_presupuesto_ff` = `pa`.`id_presupuesto_ff` and
					`ff`.`id_ff` = `pf`.`id_ff` and
					aoesp.`id_anp_objetivo_especifico` = `aao`.`id_anp_objetivo_especifico` and
					`t`.`id_tarea` = `aao`.`id_tarea` and
					`aoest`.`id_anp_objetivo_estrategico` = `aoesp`.`id_anp_objetivo_estrategico` and
					`oe`.`id_objetivo_estrategico` = `aoest`.`id_objetivo_estrategico` ".$sql."

					group by id_mes
					ORDER BY id_mes";
		
		}
		
		
			//$selmescampos="sum(monto_programacion_partidas_meses".$sqlmultiplicarxtc.") as total_monto, id_mes ";
		//}
		
//$this->sql=$this->set_sql($selmescampos,$sql,"id_mes","id_mes");		
//$this->sql=$this->set_sql($selmescampos,$sql,"id_mes","id_mes");
/*function setsql($sql=''){
	//$tipo_cambio=
	$sqlmultiplicarxtc="/".$this->tipo_de_cambio;
		$selmescampos="sum(monto_programacion_partidas_meses) as total_monto";
	if ($this->md){
		$selmescampos="sum(monto_programacion_partidas_meses".$sqlmultiplicarxtc.") as total_monto,  id_mes ";
	}
	
	$this->sql=$this->set_sql($selmescampos,$sql,"id_mes","id_mes");*/
	
	return 	$sql;
}

function mostrar_PresupuestoMensual($ftefto){
		$gsqlp=$this->SqlFtt($ftefto);
		$sqlg=$gsqlp;
		$selmescampos=$this->setsql($gsqlp);

			 //OBJ Estrat ///////////////////////////////////////////////////////////////////////
				//die ()
				$sqlprg=$this->set_sql("oe.*",$gsqlp,"oe.id_objetivo_estrategico","codigo_objetivo_estrategico");
				$query=new Consulta($sqlprg);
				while($row_prg=$query->ConsultaVerRegistro()){
					//$prg=table_row($row_prg[id_programa],"objetivo_estrategico");
					$prg[total_monto]=$row_prg[total_monto];
						$gsqlsp=$gsqlp." AND oe.id_objetivo_estrategico='".$row_prg[id_objetivo_estrategico]."'";
						$this->setsql($gsqlsp);
						
						$this->registro_programa($row_prg,$ftefto);
					
						//SUB PROGRAMA///////////////////////////////////////////////////////////////////////
					$sql_sb=$this->set_sql("aoesp.*",$gsqlsp,"aoesp.id_anp_objetivo_especifico ","codigo_objetivo_especifico");
						$query_sb=new Consulta($sql_sb);
						while($row_sb=$query_sb->ConsultaVerRegistro()){ 
							//$sbprg=table_row($row_sb[id_subprograma],"subprograma");
							
							$gsqla=$gsqlsp." AND aoesp.id_anp_objetivo_especifico='".$row_sb[id_anp_objetivo_especifico]."'";
							$this->setsql($gsqla);
							
							//regitro sub programa
							$this->registro_subprograma($row_prg,$row_sb,$ftefto);
							
							//ACTIVIDAD///////////////////////////////////////////////////////////////////////
								$sql_a=$this->set_sql("t.*,aao.*,afao.*", $gsqla, "t.id_tarea", "nro_asignacion");
								$query_a=new Consulta($sql_a);
								while($row_a=$query_a->ConsultaVerRegistro()){ 
									//$actividad=table_row($row_a[id_actividad],"actividad");
									$gsqlsa=$gsqla."  AND t.id_tarea='".$row_a[id_tarea]."'";
									$this->setsql($gsqlsa);
									
									$this->registro_actividad($row_prg,$row_sb,$row_a,$ftefto);
										
									/*		//SUB ACTIVIDAD ///////////////////////////////////////////////////////////////////////
											$sql_sa=$this->set_sql("sa.id_subactividad, sa.nombre_subactividad,
													 sa.codigo_completo_subactividad, asb.id_anp_subactividad, asb.id_anp,asb.id_axo_poa ",
													 $gsqlsa,	"fas.id_anp_subactividad","sa.id_subactividad");
						//die($sql_sa);							
													$query_sa=new Consulta($sql_sa);
													while($row_sa=$query_sa->ConsultaVerRegistro()){ 
														$gsqlsaa= $gsqlsa." AND sa.id_subactividad='".$row_sa[id_subactividad]."'";
														$this->setsql($gsqlsaa);
														$this->registro_subactividad($row_sa,$ftefto);
													}//fin SubActividad*/
								} // fin actividad
						} //fin sub programa
			  	}//fin programa
			
			$this->setsql($sqlg);
			$this->fin_de_registros($ftefto);
	}
	
	function fin_de_registros($ftefto){
		$cls="tdtotal"; 
		$td_fuente=$this->generar_td_fuente($ftefto,$cls);
		echo 	'<tr bgcolor=#999999>
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td_fuente;
				
	}
	
	function registro_programa($prg,$ftefto){
		/*if($_GET[pdf]=='ok') $nombre=substr($prg[nombre_programa],0,35)."...";
		else  $nombre=$prg[nombre_programa];*/
						$cls="tdprg"; 
						$td_fuente=$this->generar_td_fuente($ftefto,$cls);
						echo '<tr bgcolor=#999999><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_objetivo_estrategico].'</td>
						'.$td_fuente;
						 
	}
	
	function registro_subprograma($prg,$sbprg,$ftefto){
		/*if($_GET[pdf]=='ok') $nombre=substr($sbprg[nombre_subprograma],0,35)."...";
		else  $nombre=$sbprg[nombre_subprograma];*/
						$cls="tdsubprg"; 
						$td_fuente=$this->generar_td_fuente($ftefto,$cls);
						echo '<tr bgcolor="#cccccc"><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_objetivo_especifico].'</td>
						'.$td_fuente;
	}


	function registro_actividad($prg,$sbprg,$actividad,$ftefto){
		/*if($_GET[pdf]=='ok') $nombre=substr($actividad[nombre_actividad],0,35)."...";
		else  $nombre=$actividad[nombre_actividad];		*/
						//$cls="tdact"; 
						$td_fuente=$this->generar_td_fuente($ftefto,$cls);
						echo '<tr bgcolor="#FFFFFF"><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].".".$sbprg[codigo_objetivo_especifico].".".$actividad[nro_asignacion].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nombre_tarea].'</td>
						'.$td_fuente;
	}

	function registro_subactividad($subactividad,$ftefto){
		/*if($_GET[pdf]=='ok') $nombre=substr($subactividad[nombre_subactividad],0,35)."...";
		else  $nombre=$subactividad[nombre_subactividad];	*/
						$cls="tdsubact"; 
						$td_fuente=$this->generar_td_fuente($ftefto,$cls);
						echo '<tr bgcolor=#ffffff><td class="'.$cls.'" valign="top" >'.$subactividad[codigo_completo_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" valign="top" >'.$subactividad[nombre_subactividad]
						.'&nbsp;</td> 
						'.$td_fuente;
	}

	function generar_td_fuente($ftefto,$cls){
		$monto=sumar_mes_programado($this->sql,$this->md);
		for ($i=1;$i<14;$i++){
			if (empty($monto[$i])){
				$monto[$i]="&nbsp;";
			}
		$td.='
				<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right"> '. $monto[$i].'</td>';
		}
			$td.='</tr>';
			return $td;
			
	}
	


}
?>