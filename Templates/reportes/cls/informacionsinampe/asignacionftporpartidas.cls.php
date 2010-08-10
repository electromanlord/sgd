<?
class AsignacionFtsporPartidas extends  SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;
var $ftefto;
var $Partidas;


	function AsignacionFtsporPartidas(){
		$this->SqlSelect('',$_SESSION[inrena_4][2],$_SESSION["inrena_4"][1]);
	}
	
	
	function mostrar_ff_chk(){
		$funcjs=" mostrar_asignacionftporpartidas";
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
	
	function mostrar_AsignacionFtsporPartidas(){
		
		$gsqlp=$this->SqlFtt($this->ftefto);
		$sqlg=$gsqlp;
		$this->setsql($gsqlp);

			 //Partida ///////////////////////////////////////////////////////////////////////
			 	
				$sqlprtd=$this->set_sql("pp.id_partida, codigo_partida,nombre_partida",$gsqlp,"pp.id_partida","partida.codigo_partida","partida");
				
				
				//die ($sqlprtd);
				$query=new Consulta($sqlprtd);
				while($row_prtd=$query->ConsultaVerRegistro()){
						$gsqlsp=$gsqlp." AND pp.id_partida='".$row_prtd[id_partida]."'";
						//die ($gsqlsp);
						$this->setsql($gsqlsp);
						$this->registro_partida($row_prtd);
			  	}//fin Partida
			
			$this->setsql($sqlg);
			$this->fin_de_registros();
	}
	
	function fin_de_registros(){
		$cls="tdtotal"; 
		$td=$this->generar_td($cls);
		echo 	'<tr bgcolor="#999999">
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>'.$td;
				
	}
	
	function registro_partida($prtd){
						$cls=""; 
						$td=$this->generar_td($cls);
						echo '<tr><td class="'.$cls.'" valign="top" >'.$prtd[codigo_partida].'</td>
						<td class="'.$cls.'" valign="top" >'.$prtd[nombre_partida].'</td>
						'.$td;
	}


		function generar_td($cls){
			$monto=sumar_ff_programado($this->sql);
			
			$td='';
			$ftefto=$this->ftefto;
			for ($i=0;$i<count($ftefto);$i++){
				$id=$ftefto[$i];
					
					if ($monto[$id]==0){
						$monto[$id]="&nbsp;";
					}
						$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[$id].'</td>';	
			}
				
			$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[0].'</td>
					</tr>';
			return $td;
			
		}
		
	

		
	function ListarFts(){
			$sqlfft=$this->SqlFtt($this->ftefto);
			$sql=$this->set_sql("pf.id_ff",$sqlfft,"pf.id_ff","pf.id_ff");
			//echo ($sql);
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
