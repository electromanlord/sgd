<?
class AsignacionporSubactividades extends  SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;
var $ftefto;
var $Anps;


	function AsignacionporSubactividades(){
		$this->SqlSelect('',$_SESSION[inrena_4][2],$_SESSION["inrena_4"][1]);
	}
	
	
	function mostrar_ff_chk(){
		$funcjs=" mostrar_asignacionporsubactividades";
		VerChkff($funcjs,$this);
	}


	function setsql($sql=''){
		$sqltc=" / pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto, asb.id_anp";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses".$sqltc.") as total_monto, asb.id_anp ";
		}
		$this->sql=$this->set_sql($selmescampos,$sql,"asb.id_anp","asb.id_anp");
		
		return 	$selmescampos;
	}

	function mostarSiglaFtt($idff){
		$row=table_row($idff,"fuente_financiamiento","id_ff");
		return $row[siglas_ff];
	}
	
	function mostrar_AsignacionporSubactividades(){
		
		$gsqlp=$this->SqlFtt($this->ftefto);
		$sqlg=$gsqlp;
		$this->setsql($gsqlp);

			 //PROGRAMA ///////////////////////////////////////////////////////////////////////
			 	
				$sqlprg=$this->set_sql("s.id_programa",$gsqlp,"s.id_programa","s.id_programa");
				//die($sqlprg);
				$query=new Consulta($sqlprg);
				while($row_prg=$query->ConsultaVerRegistro()){
					$prg=table_row($row_prg[id_programa],"programa");
					$prg[total_monto]=$row_prg[total_monto];
						$gsqlsp=$gsqlp." AND s.id_programa='".$row_prg[id_programa]."'";
						$this->setsql($gsqlsp);
						//die($this->sql);
						$this->registro_programa($prg);
					
						//SUB PROGRAMA///////////////////////////////////////////////////////////////////////
						$sql_sb=$this->set_sql("s.id_subprograma", $gsqlsp,"s.id_subprograma");
						$query_sb=new Consulta($sql_sb);
						while($row_sb=$query_sb->ConsultaVerRegistro()){ 
							$sbprg=table_row($row_sb[id_subprograma],"subprograma");
							
							$gsqla=$gsqlsp." AND  s.id_subprograma='".$row_sb[id_subprograma]."'";
							$this->setsql($gsqla);
							
							//regitro sub programa
							$this->registro_subprograma($prg,$sbprg);
							
							//ACTIVIDAD///////////////////////////////////////////////////////////////////////
								$sql_a=$this->set_sql("sa.id_actividad", $gsqla, "sa.id_actividad");
								$query_a=new Consulta($sql_a);
								while($row_a=$query_a->ConsultaVerRegistro()){ 
									$actividad=table_row($row_a[id_actividad],"actividad");
									$gsqlsa=$gsqla."  AND sa.id_actividad='".$row_a[id_actividad]."'";
									$this->setsql($gsqlsa);
									
									$this->registro_actividad($prg,$sbprg,$actividad);
										
											//SUB ACTIVIDAD ///////////////////////////////////////////////////////////////////////
											$sql_sa=$this->set_sql("sa.id_subactividad, sa.nombre_subactividad,
													 sa.codigo_completo_subactividad, asb.id_anp_subactividad, asb.id_anp,asb.id_axo_poa ",
													 $gsqlsa,	"sa.id_subactividad","sa.id_subactividad");
													
													$query_sa=new Consulta($sql_sa);
													while($row_sa=$query_sa->ConsultaVerRegistro()){ 
														$gsqlsaa= $gsqlsa." AND sa.id_subactividad='".$row_sa[id_subactividad]."'";
														$this->setsql($gsqlsaa);
														$this->registro_subactividad($row_sa);
													}//fin SubActividad
								} // fin actividad
						} //fin sub programa
			  	}//fin programa
			
			$this->setsql($sqlg);
			$this->fin_de_registros();
	}
	
	function fin_de_registros(){
		$cls="tdtotal"; 
		$td=$this->generar_td($cls);
		echo 	'<tr bgcolor="#7B869C">
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td;
				
	}
	
	function registro_programa($prg){
						$cls="tdprg"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#999999><td class="'.$cls.'" valign="top" >'.$prg[codigo_programa].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_programa].'</td>
						'.$td;
						 
	}

	function registro_subprograma($prg,$sbprg){
						$cls="tdsubprg"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor="#cccccc"><td class="'.$cls.'" valign="top" >'.$prg[codigo_programa].".".$sbprg[codigo_subprograma].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_subprograma].'</td>
						'.$td;
	}


	function registro_actividad($prg,$sbprg,$actividad){
						$cls="tdact"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor="#FFFF99"><td class="'.$cls.'" valign="top" >'.$prg[codigo_programa].".".$sbprg[codigo_subprograma].".".$actividad[codigo_actividad].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nombre_actividad].'</td>
						'.$td;
	}

	function registro_subactividad($subactividad){
						$cls="tdsubact"; 
						$td=$this->generar_td($cls,$subactividad);
						echo '<tr bgcolor=#ffffff><td class="'.$cls.'" valign="top" >'.
						$subactividad[codigo_completo_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" valign="top" >'.$subactividad[nombre_subactividad].'&nbsp;</td> 
						'.$td;
	}


	function generar_td($cls){
			$monto=sumar_anp_programado($this->sql);
			$td='';
			$Anps=$this->Anps;
			for ($i=0;$i<count($Anps);$i++){
				$id=$Anps[$i][id_anp];
					if ($monto[$id]==0){
						$monto[$id]="&nbsp;";
					}
					$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[$id].'</td>';
			}
				
			$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[0].'</td>
					</tr>';
			return $td;
			
	}
	
	function ListarAnps(){
			$sqlfft=$this->SqlFtt($this->ftefto);
			$sql=$this->set_sql("aao.id_anp",$sqlfft,"aao.id_anp","aao.id_anp");
			$query=new Consulta($sql);
			while($row_anpid=$query->ConsultaVerRegistro()){
				$row=table_row($row_anpid['id_anp'],"anp");
				$Anp[]=array(
							'id_anp'=>$row['id_anp'],
							'nombre_an'=>$row['nombre_anp'],
							'siglas_anp'=>$row['siglas_anp'],
							);
			}
			$this->Anps=$Anp;
			return $Anp;
	}
	

}
?>
