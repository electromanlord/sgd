<?
class ObjetivosEstrategicos extends SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;
var $ftefto;
var $sqlobj;

		
	function ObjetivosEstrategicos(){
		$this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
	}



	
	function mostrar_ff_chk($fuente=''){
		$funcjs=" mostrar_objetivosestrategicos";
		VerChkff($funcjs,$this);	 
	}

	
	function setsql($sql=''){
		$sqltc=" / pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto, pf.id_ff";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses".$sqltc.") as total_monto, pf.id_ff ";
		}
		$this->sql=$this->set_sql($selmescampos,$sql,"pf.id_ff","pf.id_ff");
		
		return 	$selmescampos;
	}



	function mostarSiglaFtt($idff){
		$row=table_row($idff,"fuente_financiamiento","id_ff");
		return $row[siglas_ff];
	}
	

function mostrar_ObjetivosEstrategicos(){
		$gsqlp=$this->SqlFts;
		$sqlg=$gsqlp;
		$this->setsql($gsqlp);

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
	
	function fin_de_registros(){
		$cls="tdtotal"; 
		$this->sqlobj="";
		$td=$this->generar_td($cls);
		echo 	'<tr bgcolor=#999999>
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td;
				
	}
	
	function registro_programa($prg,$ftefto){
						$cls="tdprg"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#999999><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_objetivo_estrategico].'</td>
						'.$td;
						 
	}

	function registro_subprograma($prg,$sbprg,$ftefto){
						$cls="tdsubprg"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#cccccc><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_objetivo_especifico].'</td>
						'.$td;
	}


	function registro_actividad($prg,$sbprg,$actividad,$ftefto){
						//$cls="tdact";
						$cls="tdsubact";  
						$td=$this->generar_td($cls,$actividad);
						echo '<tr bgcolor=#ffff99><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].".".$actividad[nro_asignacion].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nombre_tarea].'</td>
						'.$td;
	}

	function generar_td($cls,$issb=''){
			$monto=sumar_ff_programado($this->sql);
			$td='';
			$ftefto=$this->ftefto;
			for ($i=0;$i<count($ftefto);$i++){
				$id=$ftefto[$i];
					if ($monto[$id]==0){
						$monto[$id]="&nbsp;";
					}
				$td.='<td class="'.$cls.'" valign="top" nowrap align="right">'.$monto[$id].'</td>';	
			}
			
			if (!empty($issb)){
				$meta=suma_meta_anp_subactividad($issb,$this->SqlFts,true);
			}
			/*if (!empty($this->sqlobj)){
				$txtobj=ObjetivoEstrategico($this->sqlobj);
			}*/
			$td=' <td class="'.$cls.'" valign="top"  >&nbsp;'.$issb[resultado_esperado_asignacion].'</td>
				  <td class="'.$cls.'" valign="top" >&nbsp;'.$issb[medio_verificacion_tarea].'</td>
				  <td class="'.$cls.'" valign="top" nowrap align="right">'.num_format($meta[cantidad][0]).'</td>
				  <td class="'.$cls.'" valign="top" nowrap align="right">'.$monto[0].'</td>'.$td.'
				  </tr>';
			return $td;
			
		}
			
	

	
	
	function ListarFts(){
			$sqlfft=$this->SqlFtt($this->ftefto);
			$sql=$this->set_sql("pf.id_ff",$sqlfft,"pf.id_ff","pf.id_ff");
			$query=new Consulta($sql);
			while($row_Fts=$query->ConsultaVerRegistro()){
				$row=table_row($row_Fts['id_ff'],"fuente_financiamiento","id_ff");
				$Fts[]=array(
							'id_ff'=>$row['id_ff'],
							'nombre_ff'=>$row['nombre_ff'],
							'siglas_ff'=>$row['siglas_ff'],
							);
			}
			return $Fts;
	}


}
?>


	