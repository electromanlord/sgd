<?
class Partida_Mensual{
	var $ejecutor="";
	var $axo="";
	var $mes="";
	var $anp=array();
	var $md=false;
	var $simbolomd=" S/. ";
	var $partidas=array();
	var $sql="";
	var $tc=0;
	var $fac=0;
	var $nro_col=0;
	var $tot_col=array();
	var $la_27=0;
		
	function Partida_Mensual(){
	}

	function Consulta($var=" * ",$fil="",$res=""){
		return "Select ".$var.
			" FROM presupuesto_ff pf, anp a, categoria ctg,presupuesto_anp pa, asignacion_ff_anp_objetivos fas, partida p,
			programacion_partidas ppa, asignacion_anp_objetivos asb, programacion_partidas_meses ppam
			WHERE pf.id_ff ='".$this->ejecutor."' AND id_mes ='".$this->mes."' AND pf.id_axo_poa = '".$this->axo."' 
				AND pf.id_presupuesto_ff = pa.id_presupuesto_ff 
				AND pa.id_presupuesto_anp = fas.id_presupuesto_anp AND p.id_partida = ppa.id_partida 
				AND fas.id_asignacion_ff_anp_objetivos = ppa.id_ff_anp_subactividad 
				AND ppa.id_programacion_partidas = ppam.id_programacion_partidas 	
				AND pf.id_axo_poa = p.id_axo_poa AND a.id_anp = asb.id_anp 
				AND asb.id_asignacion_anp_objetivos = fas.id_asignacion_anp_objetivos 
				AND a.id_categoria=ctg.id_categoria ".$fil.
				" ".$res; 
	}
	 
	function form_Partida(){
		$_SESSION['anp']="";
		?>
		<form name='f1' method="post" >
		<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
		<tr><th> Partidad Mensuales por Ejecutor </th></tr>
		<? 
		$SqlMes="Select * from mes";
		$qMes=new Consulta($SqlMes);
		?>
		<tr><td align='center'><br /><select name='mes' onchange="ver_anp_partidamensual()">
		<option value=''>----Seleccione un Mes----</option>
		<? while($m=$qMes->ConsultaVerRegistro()){
		    if($m[0]==$this->mes){ echo "<option value='$m[0]' selected='true'>$m[1]</option>"; }
			else  echo "<option value='$m[0]'>$m[1]</option>";
		}?>
		</select> <strong>A&ntilde;o-<?=axo($_SESSION[inrena_4][2])?></strong></td></tr>
		
		<? 
		$Sql="SELECT f.Id_fuentefinanciamiento, f.nombre_fuentefinanciamiento, e.Id_ff, e.siglas_ff 
		from fuente_financiamiento e,fuentefinanciamiento f, presupuesto_ff pf, presupuesto_anp pa,
		fuente_usuario fu 
		where fu.id_ff=e.id_ff AND fu.id_usuario='".$_SESSION[inrena_4][1]."' AND fu.id_submodulo='1' AND 
		 e.id_ff=pf.id_ff and id_axo_poa=".$_SESSION[inrena_4][2]." and e.id_ff=pf.id_ff 
		and f.id_fuentefinanciamiento=e.id_fuentefinanciamiento and pf.id_presupuesto_ff=pa.id_presupuesto_ff
		group by e.id_ff order by nombre_fuentefinanciamiento, siglas_ff";
		$query=new Consulta($Sql);
		?>
		<tr><td align='center'><br><strong>Seleccione Fuente Financiamiento - Ejecutor</strong></td></tr>
		<tr><td align='center'><select name='ejecutor' onchange="ver_anp_partidamensual()">
		<option value=''>----Seleccione una Opci&oacute;n----</option>
		<? 
		$ff="";
		while($opc=$query->ConsultaVerRegistro()){
			$s="";
			if($opc[2]==$this->ejecutor){ $s=" selected='true' "; echo "--".$this->ejecutor; }
			/*if($ff!=$opc[0]){ 
				echo "</optgroup><optgroup label='$opc[1]'><option value='$opc[2]' ".$s.">$opc[3]</option>"; 
				$ff=$opc[0]; 
			}
			else*/ echo "<option value='$opc[2]' ".$s.">$opc[3]</option>";
		}?>
		</select></td></tr>
		<tr><td align='center'><br/>
		<strong>Seleccione ANP</strong></td>
		</tr>
		<tr>
		  <td align='center'>
		<? $sql=$this->Consulta("nombre_categoria, nombre_anp, a.id_anp "," ","group by id_anp order by a.id_anp"); ?>
		<select name='anp[]' size="10" multiple  onchange="activar_ver_partidamensual()" >
		<? 		
		$Qanp=new Consulta($sql);
			$n=0;
			while($anp=$Qanp->ConsultaVerRegistro()){
			echo "<option value='$anp[2]'>$anp[0] $anp[1]</option>"; 
			$n=1;
			}
			/*if(!empty($this->ejecutor)&&!empty($this->mes)&&$n==0){ 
				//echo "<option value=''>--- No se encuentran ANP Registradas ---</option>";
				echo "<script>
						alert('No hay ANPs con Registros en el Mes para la Fuente Seleccionada');
						</script>";
			}*/
			?>
        </select><br />
		<? if($n==0){ 
				echo "<font color='ff0000'><strong>
					No hay ANPs con Registros en el Mes para la Fuente Seleccionada</strong>
					</font>";		
			} 
			else{
				echo "<strong>
					Para hacer m&aacute;s de una Selecci&oacute;n 
					Presione (Ctrl) + click en las ANP adicionales</strong>";
			}?>
		</td>
		</tr>
		<tr><td align='center'><br>
		<input name="mostrar" type="image" src='../../imgs/b_select.png' value="Mostrar Reporte" onclick="mostrar_x_partidamensual()"
		 alt="Ver Reporte" align="absmiddle" border="0"  /> Mostrar Reporte</td></tr>
		</table>		
		</form>
		<?
	}
	
	function info_ejecutor(){ 
	$sql="SELECT nombre_fuentefinanciamiento, nombre_ff, nombre_mes, tipo_cambio_ff 
			FROM fuente_financiamiento e, fuentefinanciamiento f, presupuesto_ff pf, mes
			WHERE f.id_fuentefinanciamiento = e.id_fuentefinanciamiento AND id_mes =".$this->mes." and e.id_ff=pf.id_ff 
			AND id_axo_poa=".$this->axo." and e.id_ff=".$this->ejecutor;
		$query=new Consulta($sql);
		if($r=$query->ConsultaVerRegistro()){
	
	$sql_="SELECT * FROM axo_poa WHERE id_axo_poa='".$_SESSION[inrena_4][2]."'";
	$query_=new Consulta($sql_);
	$raxo=$query_->ConsultaVerRegistro();	
	$tipo_cambio=$raxo[tipo_cambio];
	?>
	<tr><td width="180" >&nbsp;&nbsp;<b>Fuente Financiamiento :</b></td>
	<td><?=$r[0]?></td></tr>
	<tr><td >&nbsp;&nbsp;<b>Ejecutor :</b></td><td><?=$r[1]?></td></tr>
	<tr><td >&nbsp;&nbsp;<b>Tipo de Cambio :</b></td><td ><?=$tipo_cambio?></td></tr>
		<? $this->tc=$tipo_cambio;?>
	<tr><td >&nbsp;&nbsp;<b>Mes :</b></td><td><?=$r[2]?></td></tr>
	<tr><td >&nbsp;&nbsp;<b>A&ntilde;o :</b></td><td ><?=axo($this->axo)?></td></tr>
	
	<? 
		}
	}
	
	function resultado(){
		$anp=$this->anp;
		for ($i=0;$i<count($anp);$i++){
			$Q=new Consulta("Select nombre_anp, id_anp from anp where id_anp=".$anp[$i]);
			while($row=$Q->ConsultaVerRegistro()){ echo "<tr><th class='th2' align='left'>$row[0]</th></tr>";}
		}
	
	}
	
	function partidas(){
		$anp=$this->anp;
		$partidas;
				
		if(!empty($_SESSION['anp'])){
			echo "<tr bgcolor='#7B869C'><th class='th2' width='15%' nowrap='nowrap' align='center'>ANP\PARTIDAS</th>";
			for ($i=0;$i<count($anp);$i++){ 
				$Cons=$this->Consulta("p.codigo_partida,p.id_partida "," and a.id_anp=".$anp[$i] ,
													" group by p.id_partida order by p.codigo_partida");
				$query=new Consulta($Cons);
				while($r=$query->ConsultaVerRegistro()){
					$part[]=$r[0]."-".$r[1];
				}
			}	
			asort($part);
			$part=array_unique($part);
			foreach ($part as $v) {
				$cad=split("-",$v);
				echo "<th class='th2' width='5%'>".$cad[0]."</th>";
				$this->partidas[]=$cad[1];
				$this->tot_col[$cad[1]]=0;
			}
			$this->nro_col=count($this->partidas);
						
			echo "<th class='th2' width='5%' align='center'>TOTAL ".$this->simbolomd."</th></tr>";
			$this->info_anp();
		}	
		else echo "<div align='center'><font size='+1' color='ff0000'>Ud. no ha elegido ningun ANP 
		de la lista</font></div>";
	}
	
	function info_anp(){
		$anp=$this->anp;
		//$part=$this->partidas;
		$tot=0;
		
		for ($i=0;$i<count($anp);$i++){
			//echo $anp[$i]."****";
			$C=$this->Consulta("siglas_anp, a.id_anp, p.id_partida"," and a.id_anp=".$anp[$i]." "," group by nombre_anp");
			$Q=new Consulta($C);
			
			while($row=$Q->ConsultaVerRegistro()){ 
				echo "<tr><th class='th2' align='left' bgcolor='#7B869C'>$row[0]</th>";
				$totH=0;
				
				foreach ($this->partidas as $part) { 
					$Sql=$this->Consulta(" sum(monto_programacion_partidas_meses) ",
								" and a.id_anp=".$anp[$i]." and p.id_partida=".$part," ");
					$query=new Consulta($Sql);
					if($col=$query->ConsultaVerRegistro()){ 
						if($this->md) $val=$col[0]/$this->tc;
						else $val=$col[0];
						$totH+=$val;
						$this->tot_col[$part]+=$val;
						if($part==27) $this->la_27+=$col[0];
						echo "<td align='right'>".num_format($val)."</td>";
					}
					else echo "<td>&nbsp;</td>";
						
				} 
				echo "<td align='right'>".num_format($totH)."</td></tr>";
				$tot+=$totH;
			}
					
		}
		
		echo "<tr bgcolor='#7B869C'><th class='th2' width='5%' align='center' >TOTALES ".$this->simbolomd."</th>";
		foreach ($this->partidas as $part) { echo "<th class='th2' align='right'>".num_format($this->tot_col[$part])."</th>";}			
		echo "<th class='th2' width='5%' align='right'>".num_format($tot)."</th></tr>";
		/*echo "<tr><th class='th2' width='5%' align='center'>TOTAL ".$this->simbolomd." sin la 27</th>
				<td colspan='".$this->nro_col."'>&nbsp;</td>
				<th class='th2' width='5%' align='right'>".num_format($tot-$this->la_27)."</th></tr>";*/
	}
}

?>
