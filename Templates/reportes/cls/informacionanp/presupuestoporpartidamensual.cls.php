<?
class PresupuestoPorPartidasMensual extends  SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;
var $ftefto;
var $Partidas;


	function PresupuestoPorPartidasMensual(){
		$this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION[inrena_4][2],$_SESSION["inrena_4"][1]);
	}
	
	
	function mostrar_ff_chk(){
		$funcjs=" mostrar_presupuestoporpartidamensual";
		VerChkff($funcjs,$this);
	}


	function setsql($sql=''){
		$sqlmultiplicarxtc="/ pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto,  ppm.id_mes ";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses".$sqlmultiplicarxtc.") as total_monto,  ppm.id_mes ";
		}
		
		$this->sql=$this->set_sql($selmescampos,$sql,"ppm.id_mes","ppm.id_mes");
		return 	$selmescampos;
	}

	
	function mostarSiglaFtt($idff){
		$row=table_row($idff,"fuente_financiamiento","id_ff");
		return $row[siglas_ff];
	}
	
	function mostrar_Presupuesto(){
		
		$gsqlp=$this->SqlFtt($this->ftefto);
		$sqlg=$gsqlp;
		$this->setsql($gsqlp);

			 //Partida ///////////////////////////////////////////////////////////////////////
			 	
				$sqlprtd=$this->set_sql("pp.id_partida, codigo_partida,nombre_partida",$gsqlp,"pp.id_partida","partida.codigo_partida","partida");
				
				
				//die ($sqlprtd);
				$query=new Consulta($sqlprtd);
				while($row_prtd=$query->ConsultaVerRegistro()){
						$gsqlsp=$gsqlp." AND pp.id_partida='".$row_prtd[id_partida]."'";
						$this->setsql($gsqlsp);
						//die ($this->sql);
						$this->registro_partida($row_prtd);
			  	}//fin Partida
			
			$this->setsql($sqlg);
			$this->fin_de_registros();
	}
	
	function fin_de_registros(){
		$cls="tdtotal"; 
		$td=$this->generar_td($cls);
		echo 	'<tr bgcolor=#999999>
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td;
				
	}
	
	function registro_partida($prtd){
						$cls=""; 
						$td=$this->generar_td($cls);
						echo '<tr><td class="'.$cls.'" valign="top" >'.$prtd[codigo_partida].'</td>
						<td class="'.$cls.'" valign="top" >'.$prtd[nombre_partida].'</td>
						'.$td;
	}


		function generar_td($cls){
			$monto=sumar_partida_mes_programado($this->sql);
			$td='';
			for ($i=1;$i<13;$i++){
				$id=$i;
					if ($monto[$id]==0){
						$monto[$id]="&nbsp;";
					}
						$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[$id].'</td>';	
			}
				
			$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[0].'</td>
					</tr>';
			return $td;
			
		}
		
	

		

}
?>
