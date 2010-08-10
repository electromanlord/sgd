<?
class ANP_x_FF extends Conexion{
	
	var $ejecutor="";
	var $axo="";
		
	function ANP_x_FF(){
		//$this->SqlSelect('',$_SESSION[inrena_4][2]);
	}
	
	
	function mostrar_ComboBox(){
	$Sql="SELECT f.Id_fuentefinanciamiento, f.nombre_fuentefinanciamiento, e.Id_ff, e.siglas_ff 
		from fuente_financiamiento e,fuentefinanciamiento f, presupuesto_ff pf, presupuesto_anp pa,
		fuente_usuario fu 
		where fu.id_ff=e.id_ff AND fu.id_usuario='".$_SESSION[inrena_4][1]."' AND fu.id_submodulo='1' AND 
		e.id_ff=pf.id_ff and id_axo_poa=".$_SESSION[inrena_4][2]." and e.id_ff=pf.id_ff 
		and f.id_fuentefinanciamiento=e.id_fuentefinanciamiento and pf.id_presupuesto_ff=pa.id_presupuesto_ff
		group by e.id_ff order by nombre_fuentefinanciamiento, siglas_ff";
	$query=new Consulta($Sql);
	
	?>
	<form name="f1" >
	<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
	<tr><th> ANP por Ejecutor</th></tr>
	<tr><td align='center'> <br><strong>Seleccione Fuente Financiamiento - Ejecutor</strong></td></tr>
	<tr><td align='center'><br>
	<select name='ejecutor'>
	<option value='0'>----Seleccione una Opci&oacute;n----</option>
	<?
	$ff="";
	while($opc=$query->ConsultaVerRegistro()){
			/*if($ff!=$opc[0]){ 
				echo "</optgroup><optgroup label='$opc[1]'><option value='$opc[2]'>$opc[3]</option>"; 
				$ff=$opc[0]; 
			}
			else*/ echo "<option value='$opc[2]'>$opc[3]</option>";
	 }?>
	</select></td></tr><tr><td align='center'><br>
	Mostrar Reporte 
	<a href="#" onclick="mostrar_x_ejecutor()">
	<img src='../../imgs/b_select.png' border='0'>
	</a></td></tr></table>		
	</form>
	<? }
	
	function Info_Ejecutor(){ 
		//echo "****".$this->ejecutor."---".$this->axo."----".axo($this->axo);
		$sql="select nombre_ff, nombre_fuentefinanciamiento, coordinador_ff, email_ff, tipo_cambio_ff,	monto_presupuesto_ff 
			from fuente_financiamiento e,fuentefinanciamiento f, presupuesto_ff pf, presupuesto_anp pa 
			where e.id_ff=".$this->ejecutor." and id_axo_poa=".$this->axo." 
			and e.id_ff=pf.id_ff and f.id_fuentefinanciamiento=e.id_fuentefinanciamiento and pf.id_presupuesto_ff=pa.id_presupuesto_ff
			group by e.id_ff";
		$query=new Consulta($sql);
		while($r=$query->ConsultaVerRegistro()){
	?>			
			<tr>
				<td width="250"><b>&nbsp;Nombre Fuente Financiamiento: </b> </td>
				<td ><?=$r[1]?></td>
			</tr>
			<tr>
				<td ><b>&nbsp;Nombre Ejecutor: </b> </td>
				<td ><?=$r[0]?></td>
			</tr>
			<tr>
				<td ><b>&nbsp;Coordinador: </b></td>
				<td ><?=$r[2]?></td>
			</tr>
			<tr>
				<td ><b>&nbsp;Email: </b></td>
				<td ><?=$r[3]?></td>
			</tr>
			<tr>
				<td ><b>&nbsp;Tipo Cambio: </b></td>
				<td width="50%">S/.&nbsp;<?=$r[4]?></td>
			</tr>
			<tr>
				<td ><b>&nbsp;Cantidad Soles: </b></td>
				<td width="50%">S/.&nbsp;<?=num_format($r[5])?></td>
			</tr>
			<tr>
				<td ><b>&nbsp;Cantidad Dolares: </b></td>
				<td width="50%" >$&nbsp;&nbsp;&nbsp;<?=num_format($r[5]/$r[4])?></td>
			</tr>
			
	<? }}
	
	function Lista_ANP(){
		$sqlA="SELECT `c`.`nombre_categoria`, `a`.`nombre_anp`, `pa`.`monto_presupuesto_anp`, `pf`.`tipo_cambio_ff`, 							Sum(`affao`.`monto_asignacion_ff_anp_objetivos`) AS `asignado`, `affao`.`id_asignacion_ff_anp_objetivos`, `affao`.`id_presupuesto_anp`
			FROM
			`categoria` AS `c` ,
			`anp` AS `a` ,
			`presupuesto_ff` AS `pf` ,
			`presupuesto_anp` AS `pa` ,
			`asignacion_ff_anp_objetivos` AS `affao`
			where id_ff=".$this->ejecutor." and id_axo_poa=".$this->axo." and 
			`pa`.`id_presupuesto_anp` =  `affao`.`id_presupuesto_anp` AND
			`a`.`id_categoria` =  `c`.`id_categoria` AND
			`pf`.`id_presupuesto_ff` =  `pa`.`id_presupuesto_ff` AND
			`a`.`id_anp` =  `pa`.`id_anp`
			GROUP BY
			`affao`.`id_presupuesto_anp`
			ORDER BY
			`c`.`nombre_categoria` ASC";
			$queryA=new Consulta($sqlA); ?>
			<table width='700' align='center' border='0' bgcolor="#FFFFFF">
				<tr bgcolor="#666666" class="tit Estilo1">
				<th>NOMBRE ANP</th>
				<th>Presupuestado S/.</th>
				<th>Asignado S/.</th>
				<th>Programado S/.</th>
				</tr><?
			$tot_s=$tot_d=$sol=$dol=$n=0; 
							
			while($rw=$queryA->ConsultaVerRegistro()){	
				$n++;
				$sol=$rw[2];
				$dol=$rw[asignado];
				$tot_s+=$sol;
				$tot_d+=$dol;
				?>
				<tr><td><?=$rw[0]." ".$rw[1]?></td>
				<? /*"<td align='right'><?=num_format($sol)?></td><td align='right'><?=num_format($dol)?></td></tr>"*/?>
				<td align='right'><?=number_format($sol,2,",",".");?></td>
				<td align='right'><?=number_format($rw[asignado],2,",",".");?></td>
               <?  $prog=" SELECT Sum(`ppm`.`monto_programacion_partidas_meses`) AS `prog`, `affao`.`id_presupuesto_anp`, `affao`.`id_asignacion_ff_anp_objetivos`
			FROM
			`programacion_partidas` AS `pp`,
			`programacion_partidas_meses` AS `ppm`  ,
			`asignacion_ff_anp_objetivos` AS `affao` 
			WHERE
			`affao`.`id_presupuesto_anp` =  '".$rw[id_presupuesto_anp]."' AND
			`pp`.`id_programacion_partidas` = `ppm`.`id_programacion_partidas` and
			`affao`.`id_asignacion_ff_anp_objetivos` = `pp`.`id_ff_anp_subactividad` 
			GROUP BY
			`affao`.`id_presupuesto_anp`";
			$qprog=new Consulta($prog); 
			
			
			$tot=$sol=$n=0; 
							
			while($rprog=$qprog->ConsultaVerRegistro()){	
				$n++;
				$sol=$rprog[prog];
				$tot+=$sol;
				
			?>
				<td align='right'><?=number_format($rprog[prog],2,",",".");?></td></tr>
			<? 
			}}
			?>
				<tr align='right'><td ><strong>Totales Asignados</strong></td>
				<td align='right'><font color="#FF0000"><b><?=number_format($tot_s,2,",",".");?></font></td>
				<td align='right'><font color="#FF0000"><b> <?=number_format($tot_d,2,",",".");?></font></td>
				<td align='right'><font color="#FF0000"><b></font></td></tr>
				<tr><td><i>Número Total de ANP <?=$n?></i></td></tr>
			</table>
<?
	}
	
}
?>
