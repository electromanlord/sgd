<?
class FichaSubactividad extends SqlSelect{

function FichaSubactividad ($anpid,$axo_poa,$id_user){
	$this->anpid=$anpid;
	$this->axo_poa=$axo_poa;
	$this->id_user=$id_user;
}

		
			
function mostrar_chk_ffs($id_fuente=''){
	$anpid=$this->anpid;
	
	$query=new Consulta($sql=$this->set_sql("ff.id_fuentefinanciamiento","","ff.id_fuentefinanciamiento"));
	
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
																	" AND ff.id_fuentefinanciamiento='".$rows[id_fuentefinanciamiento]."'","ff.id_ff",
																	"ff.id_ff")
														);
					
					
					$e=0;
					while($row=$querryject->ConsultaVerRegistro()){
						$Activochk="";
						for ($i=0;$i<count($id_fuente);$i++){
							if ($id_fuente[$i]==$row['id_ff']){
								$Activochk='checked="checked"';
								echo $Activochk;
								echo $id_fuente[$i];
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
							$gsql=GeneraSqlArray($id_fuente,"ff.id_ff"," OR ");
							
							$gsql=" AND (".$gsql.")";
						}
				
						$sqlffs=$this->set_sql($Select," ".$gsql,"ff.id_ff", "ff.siglas_ff");
						//echo ($sqlffs);
						$Qffs=new Consulta($sqlffs);
						
						?>
						<select name="id_var" >
						<option value="0">Seleccionar Todas</option>
						<?

						while($row_ffs=$Qffs->ConsultaVerRegistro()){
							?>
							<optgroup   label="<?=$row_ffs[siglas_ff]?>">
							
								<?
						$sqlsa=$this->set_sql($Select," AND ff.id_ff='".$row_ffs['id_ff']."'","t.id_tarea,id_asignacion_ff_anp_objetivos", "codigo ASC");
						//die ($sqlsa);
						$QSubactividad=new Consulta($sqlsa);

						while($row1=$QSubactividad->ConsultaVerRegistro()){
									$Aid_ff_anp[]=$row1['id_asignacion_ff_anp_objetivos'];
									echo '<option value="'.$row1['id_asignacion_ff_anp_objetivos'].'">'."\n";
									$numletras=40;
									$nombre=$row1['nombre_tarea'];
									if (strlen ($nombre)>$numletras){
										$nombre=substr($nombre,0,$numletras)."...";
									}
									echo $row1['codigo'];
									echo " - ";
									echo $nombre;
									echo '</option>'."\n";
									
						}
							
							$_SESSION['id_ff_anp']="";
							$_SESSION['id_ff_anp']=$Aid_ff_anp;
						?>
						
							</optgroup>
						<? } ?>
						</select>
						<? //echo "-->"; print_r($Aid_ff_anp);?>
						</td>
					</tr>
					<tr>
						<td colspan=4 align=center>
						<br /><br />	
						Mostrar el Reporte
							<a href="#" onclick="LlamarReporteFichaSB('<?=$anpid?>')">
							<img src="../../imgs/b_select.png" border="0"> </a>						</td>
					</tr>
				</table>
					
		<?					
					
	}



}


?>