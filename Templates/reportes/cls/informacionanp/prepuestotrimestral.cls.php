<?
session_start();
class PresupuestoTrimestral extends SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;

	function PresupuestoTrimestral(){
		$this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
	}
	
	

	function mostrar_ff_chk($fuente=''){
		$funcjs=" mostrar_presupuestotrimestral";
		VerChkff($funcjs,$this);	 
	}


	/*
	function setsql($sql=''){
		$sqlmultiplicarxtc="/ pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto,  id_trimestre ";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses".$sqlmultiplicarxtc.") as total_monto,  id_trimestre ";
		}
		$this->sql=$this->set_sql($selmescampos,$sql,"id_trimestre","id_trimestre","metas");
		
		return 	$selmescampos;
	}
	*/
		function setsql($sql=''){
		$sqlmultiplicarxtc="/ pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto, m.id_mes  ";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses".$sqlmultiplicarxtc.") as total_monto,  m.id_mes ";
		}
		$this->sql=$this->set_sql($selmescampos,$sql,"m.id_mes","m.id_mes");
		
		return 	$selmescampos;
	}
	
	function mostarSiglaFtt($ffuente,$idff){
		$row=table_row($idff,"fuente_financiamiento","id_ff");
		return $row[siglas_ff];
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
								$sql_a=$this->set_sql("t.*,aao.*,afao.*", $gsqla, "t.id_tarea", "aao.nro_asignacion");
								$query_a=new Consulta($sql_a);
								while($row_a=$query_a->ConsultaVerRegistro()){ 
									//$actividad=table_row($row_a[id_actividad],"actividad");
									$gsqlsa=$gsqla."  AND t.id_tarea='".$row_a[id_tarea]."'";
									$this->setsql($gsqlsa);
									
									$this->registro_actividad($row_prg,$row_sb,$row_a,$ftefto);
								
								} // fin actividad
						} //fin sub programa
			  	}//fin programa
			
			$this->setsql($sqlg);
			$this->fin_de_registros($ftefto);
	}
	
	function fin_de_registros($ftefto){
		$cls="tdtotal"; 
		$td=$this->generar_td($ftefto,$cls);
		echo 	'<tr bgcolor=#999999>
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td;
				
	}
	
	function registro_programa($prg,$ftefto){
						$cls="tdprg"; 
						$td=$this->generar_td($ftefto,$cls);
						echo '<tr bgcolor=#999999><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_objetivo_estrategico].'</td>
						'.$td;
						 
	}

	function registro_subprograma($prg,$sbprg,$ftefto){
						$cls="tdsubprg"; 
						$td=$this->generar_td($ftefto,$cls);
						echo '<tr bgcolor=#cccccc><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_objetivo_especifico].'</td>
						'.$td;
	}


	function registro_actividad($prg,$sbprg,$actividad,$ftefto){
						//$cls="tdact";
						$cls="tdsubact";  
						$td=$this->generar_td($ftefto,$cls,$actividad);
						echo '<tr bgcolor=#ffff99><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].".".$actividad[nro_asignacion].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nombre_tarea].'</td>
						'.$td;
	}

	/*function registro_subactividad($subactividad,$ftefto){
						$cls="tdsubact"; 
						$td=$this->generar_td($ftefto,$cls,$subactividad);
						echo '<tr><td class="'.$cls.'" valign="top" >'.$subactividad[codigo_completo_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" valign="top" >'.$subactividad[nombre_subactividad].'&nbsp;</td> 
						'.$td;
	}*/

	function generar_td($ftefto,$cls,$issub=''){
		$monto=sumar_trimestral_programado($this->sql,$this->md);
			if(is_array($issub)){
				$metas=suma_meta_anp_subactividad($issub,$this->SqlFts,true);
			}
		 // print_r($metas);
		  for ($i=0;$i<5;$i++){
		  	$monto[$i]=number_format($monto[$i],2,".",",");
		  	if (empty($monto[$i])){
				$monto[$i]="&nbsp;";
			}
			if (empty($metas[cantidad][$i])){
				$metas[cantidad][$i]="&nbsp;";
			}
			
			$td.='<td class="'.$cls.'"  nowrap="nowrap" valign="top" align="right">'.$metas[cantidad][$i].'</td>
         	 	 <td class="'.$cls.'"  nowrap="nowrap" valign="top" align="right">'.$monto[$i].'</td>';
		  }
		  	$td= '<td class="'.$cls.'" valign="top" >&nbsp;'.$issub[medio_verificacion_tarea].'</td>
				  '.$td.'</tr>
				  ';
			return $td;
	}
	


}
?>