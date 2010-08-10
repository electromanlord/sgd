<?
class PresupuestoMensualPorPartidas extends SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;
var $ftefto;
var $APartidas;



	function PresupuestoMensualPorPartidas(){
	
	
$this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);

			
function mostrar_ff_k($id_fuente=''){
	$anpid=$this->anpid;
	
	$query=new Consulta($sql=$this->set_sql("ff.id_fuentefinanciamiento","and m.id_mes='".$_POST[idmes]."'","ff.id_fuentefinanciamiento"));
	
	if ($query->numregistros()<1){
	 echo '<center> <strong style="font:Verdana, Arial, Helvetica, sans-serif; color:#FF0000"> Anp no tiene datos programados En este AÑO</strong></center>';
	 exit;
	}
	
	?>
		<br>
		<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td width="24%" align="right">&nbsp;</td>
				<td width="76%"><b><u>Fuentes Asociados</u></td>
			</tr>
		</table>
		
		<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center"> 

					<tr>
					  <td colspan="2" align="right">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
		  			</tr>
					<?
			 	while($rows=$query->ConsultaVerRegistro()){
						$row_ff=table_row($rows['id_fuentefinanciamiento'],"fuentefinanciamiento");
						?>
							<tr>
							  <td width="24%" align="right">&nbsp;</td>
							  <td colspan="4" align="left">
					          <em><strong><?=$row_ff[nombre_fuentefinanciamiento]?></strong></em></td>
						     </tr>
					 <?
					/*$Select="
					sa.id_subactividad, sa.nombre_subactividad,sa.codigo_subactividad,
					sa.codigo_completo_subactividad, fas.id_presupuesto_anp, pf.id_axo_poa,
						asb.id_anp_subactividad, fas.id_ff_anp_subactividad, pa.id_anp,ff.id_ff,
						ff.siglas_ff, ff.nombre_ff";*/
					$Select="
					t.id_tarea, t.nombre_tarea, 
						concat(codigo_objetivo_estrategico,'.',codigo_objetivo_especifico,'.',nro_asignacion) as codigo,
					 	afao.id_presupuesto_anp, pf.id_axo_poa,
						aao.id_asignacion_anp_objetivos, afao.id_asignacion_ff_anp_objetivos, pa.id_anp,ff.id_ff,
						ff.siglas_ff, ff.nombre_ff";	
					$querryject=new Consulta (
												$sqlejct= 
												$this->set_sql($Select,
																	" AND ff.id_fuentefinanciamiento='".$rows[id_fuentefinanciamiento]."' and m.id_mes='".$_POST[idmes]."'","ff.id_ff",
																	"ff.id_ff")
														);
					
					
					$e=0;
					while($row=$querryject->ConsultaVerRegistro()){
						$Activochk="";
						for ($i=0;$i<count($id_fuente);$i++){
							if ($id_fuente[$i]==$row['id_ff']){
								$Activochk='checked="checked"';
							}
					
						}

						?>	
						
						<tr>
							<td colspan="2" align="right">
								<input type="checkbox" name="S2[]" value="<?=$row['id_ff']?>" onclick="CargarSubActvXFf()" <?=$Activochk?> />						</td>
							<td width="2%">&nbsp;</td>
							<td width="68%"><?=$row['nombre_ff']?> </td>
						</tr>
					
							
					<? }
					}
				 ?>
				
				
				
				
					<tr>
						<td colspan="4" align="center"><br />
							Seleccione una Tarea </td>
					</tr>
					<tr>
						<td align="center" colspan="4">
				
						<?
						$gsql="";
						if (is_array($id_fuente)){
							$gsql=GeneraSqlArray($id_fuente,"m.id_mes"," OR ");
							
							$gsql=" AND (".$gsql.")";
						}
				
						$sqlffs=$this->set_sql($Select," ".$gsql,"m.id_mes", "m.nombre_mes");
						//echo ($sqlffs);
						$Qffs=new Consulta($sqlffs);
						
						?>
						<select name="id_var">
						<option value="0">Seleccionar Todas</option>
						<?

						while($row_ffs=$Qffs->ConsultaVerRegistro()){
							?>
							
								<?
						$sqlsa=$this->set_sql($Select," AND ff.id_ff='".$row_ffs[id_ff]."' and m.id_mes='".$_POST[idmes]."'","t.id_tarea,id_asignacion_ff_anp_objetivos", "id_mes ASC");
						//die ($sqlsa);
						$QSubactividad=new Consulta($sqlsa);

						while($row1=$QSubactividad->ConsultaVerRegistro()){
									$Aid_ff_anp[]=$row1['id_asignacion_ff_anp_objetivos'];
									echo '<option value="'.$row1['id_asignacion_ff_anp_objetivos'].'">'."\n";
									$numletras=40;
									$nombre=$row1['nombre_mes'];
									if (strlen ($nombre)>$numletras){
										$nombre=substr($nombre,0,$numletras)."...";
									}
									echo $nombre;
									echo '</option>'."\n";
									
						}
							
							$_SESSION["inrena_4"][ffuente]="";
							$_SESSION["inrena_4"][ffuente]=$Aid_ff_anp;
						?>
						
							</optgroup>
						<? } ?>
						</select>
						<? echo "-->"; print_r($Aid_ff_anp);?>
						</td>
					</tr>
					<tr>
						<td colspan=4 align=center>
						<br /><br />	
						Mostrar el Reporte
							<a href="../informacionanp/presupuestomensualporpartidas.php" onclick="<?=anpid?>">
							<img src="../../imgs/b_select.png" border="0"> </a>						</td>
					</tr>
				</table>
					
		<?					
					
	}

function setsql($sql=''){
		//$sqlmultiplicarxtc="/ pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto, id_partida";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses / tipo_cambio_ff) as total_monto, id_partida ";
		}
		
		$this->sql=$this->set_sql($selmescampos,$sql,"id_partida","id_partida");
		
		//die ($this->sql);
		//$selmescampos="sum(monto_programacion_partidas_meses) as total_monto,  id_mes, pf.tipo_cambio_ff ";
		//$this->sql=$this->set_sql($selmescampos,$sql,"id_mes,pf.id_ff","pf.id_ff,id_mes");
	
	
		
		
		return 	$selmescampos;
	}

	function ListarPartidas(){
		$sqlFfts=$this->SqlFtt($this->ftefto);
		$sqlPartidas=$this->set_sql("pp.id_partida",$sqlFfts,"pp.id_partida","partida.codigo_partida","partida");
		//die ($sqlPartidas);
		$query=new Consulta($sqlPartidas);
		while($row=$query->ConsultaVerRegistro()){
			$row_p=table_row($row[id_partida],"partida");
			$APartidas[]=array(id_partida=>$row_p[id_partida],codigo_partida=>$row_p[codigo_partida]);
		}
		$this->APartidas=$APartidas;
		return $APartidas;
	}

	function mostarSiglaFtt($idff){
		$row=table_row($idff,"fuente_financiamiento","id_ff");
		return $row[siglas_ff];
	}
	
	function mostrar_Presupuesto(){
		$gsqlp=$this->SqlFts;
		$sqlg=$gsqlp;
		$this->setsql($gsqlp);

			  //OBJ Estrat ///////////////////////////////////////////////////////////////////////
				//die ()
				$sqlprg=$this->set_sql("oe.*,m.*",$gsqlp,"oe.id_objetivo_estrategico","codigo_objetivo_estrategico");
				$query=new Consulta($sqlprg);
				while($row_prg=$query->ConsultaVerRegistro()){
					//$prg=table_row($row_prg[id_programa],"objetivo_estrategico");
					$prg[total_monto]=$row_prg[total_monto];
						$gsqlsp=$gsqlp." AND m.id_mes='".$_POST[idmes]."' and oe.id_objetivo_estrategico='".$row_prg[id_objetivo_estrategico]."'";
						$this->setsql($gsqlsp);
						
						$this->registro_programa($row_prg,$ftefto);
					
						//OBJETIVO ESPECIFICO///////////////////////////////////////////////////////////////////////
					$sql_sb=$this->set_sql("aoesp.*,m.*",$gsqlsp,"aoesp.id_anp_objetivo_especifico ","codigo_objetivo_especifico");
						$query_sb=new Consulta($sql_sb);
						while($row_sb=$query_sb->ConsultaVerRegistro()){ 
							//$sbprg=table_row($row_sb[id_subprograma],"subprograma");
							
							$gsqla=$gsqlsp." AND aoesp.id_anp_objetivo_especifico= '".$row_sb[id_anp_objetivo_especifico]."' AND m.id_mes='".$_POST[idmes]."'";
							$this->setsql($gsqla);
							
							//regitro sub programa
							$this->registro_subprograma($row_prg,$row_sb,$ftefto);
							
							//TAREA///////////////////////////////////////////////////////////////////////
								$sql_a=$this->set_sql("t.*,aao.*,afao.*,m.*", $gsqla, "t.id_tarea", "aao.nro_asignacion");
								$query_a=new Consulta($sql_a);
								while($row_a=$query_a->ConsultaVerRegistro()){ 
									//$actividad=table_row($row_a[id_actividad],"actividad");
									$gsqlsa=$gsqla."  AND t.id_tarea='".$row_a[id_tarea]."'  AND m.id_mes='".$_POST[idmes]."'";
									$this->setsql($gsqlsa);
									
									$this->registro_actividad($row_prg,$row_sb,$row_a,$ftefto);
								
								} // fin actividad
						} //fin sub programa
			  	}//fin programa
			
			$this->setsql($sqlg);
			$this->fin_de_registros($ftefto);
	}
	
	function fin_de_registros(){
		$cls="Estilo3"; 
		$td=$this->generar_td($cls);
		echo 	'<tr bgcolor=#999999>
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td;
				
	}
	
	function registro_programa($prg,$ftefto){
						$cls="Estilo3"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#999999><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_objetivo_estrategico].'</td>
						'.$td;
						 
	}

	function registro_subprograma($prg,$sbprg,$ftefto){
						$cls="Estilo3"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#cccccc><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_objetivo_especifico].'</td>
						'.$td;
	}


	function registro_actividad($prg,$sbprg,$actividad,$ftefto){
						//$cls="tdact";
						$cls="Estilo3";  
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#FFFFFF><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].".".$actividad[nro_asignacion].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nombre_tarea].'</td>
						'.$td;
	}

	/*function registro_subactividad($subactividad){
						$cls="tdsubact"; 
						$td=$this->generar_td($cls,$subactividad);
						echo '<tr><td class="'.$cls.'" valign="top" >'.$subactividad[codigo_completo_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" valign="top" >'.$subactividad[nombre_subactividad].'&nbsp;</td> 
						'.$td;
	}*/


	function generar_td($cls){
			$monto=sumar_partidas_programado_tareas($this->sql);
			$td='';
			$Partidas=$this->APartidas;
			for ($i=0;$i<count($Partidas);$i++){
				$id=$Partidas[$i][id_partida];
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