<?
class SqlSelect {
var $axo_poa="";
var $anpid="";
var $SqlFts="";

var $id_user="";
var $fnts_fin="";
var $tipo_de_cambio=1;
	
	function SqlSelect($anpid='',$axo_poa='',$user=''){
		if (!empty($axo_poa)){
		$this->axo_poa=$axo_poa;	
		}
		if (!empty($anpid)){
		$this->anpid=$anpid;
		}
		
		if (!empty($user)){
		 	$this->id_user=$user; $ff="";
			if($_SESSION[Module]<5) $modulo=1; else $modulo=5;
			$q=new Consulta("select id_ff from fuente_usuario 
							WHERE
							id_usuario='".$user."' AND
							id_submodulo='".$modulo."'");
			while($row=$q->ConsultaVerRegistro()){
				$ff.=$row[id_ff].",";
			}
			//echo $this->fnts_fin=substr($ff,0,(strlen($ff)-1));
		}
		$Queryt= new Consulta("SELECT tipo_cambio FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'");
		$tp=$Queryt->ConsultaVerRegistro();	
		$this->tipo_de_cambio=$tp[tipo_cambio];
	}
	
	function set_sql($tcampos,$cwhere='',$cgroup='',$corder='',$Addtable=''){
		$sql_select="SELECT ";
		
			$sql_from=" FROM
`programacion_partidas_meses` AS `ppm`
Inner Join `programacion_partidas` AS `pp` ON `ppm`.`id_programacion_partidas` = `pp`.`id_programacion_partidas`
Inner Join `asignacion_ff_anp_objetivos` AS `afao` ON `afao`.`id_asignacion_ff_anp_objetivos` = `pp`.`id_ff_anp_subactividad`
Inner Join `asignacion_anp_objetivos` AS `aao` ON `aao`.`id_asignacion_anp_objetivos` = `afao`.`id_asignacion_anp_objetivos`
Inner Join `presupuesto_anp` AS `pa` ON `pa`.`id_presupuesto_anp` = `afao`.`id_presupuesto_anp`
Inner Join `presupuesto_ff` AS `pf` ON `pf`.`id_presupuesto_ff` = `pa`.`id_presupuesto_ff`
Inner Join `fuente_financiamiento` AS `ff` ON `ff`.`id_ff` = `pf`.`id_ff`
Inner Join `anp_objetivo_especifico` AS `aoesp` ON `aoesp`.`id_anp_objetivo_especifico` = `aao`.`id_anp_objetivo_especifico`
Inner Join `tarea` AS `t` ON `t`.`id_tarea` = `aao`.`id_tarea`
Inner Join `anp_objetivo_estrategico` AS `aoest` ON `aoest`.`id_anp_objetivo_estrategico` = `aoesp`.`id_anp_objetivo_estrategico`
Inner Join `objetivo_estrategico` AS `oe` ON `oe`.`id_objetivo_estrategico` = `aoest`.`id_objetivo_estrategico`";			
		//$sql_from.=" Inner Join fuente_usuario ON fuente_usuario.id_ff = ff.id_ff ";			
					if ($Addtable=="metas"){
						$sql_from=$sql_from." Inner Join metas 
												ON metas.id_ff_anp_subactividad = afao.id_asignacion_ff_anp_objetivos ";
						
					}
					if ($Addtable=="partida"){
						$sql_from=$sql_from." Inner Join partida ON partida.id_partida = pp.id_partida ";
					}
					if ($Addtable=="anp"){
						$sql_from=$sql_from." Inner Join anp a ON pa.id_anp = a.id_anp 
												Inner Join categoria ctg ON a.id_categoria=ctg.id_categoria ";
					}
			
			if (!empty($this->axo_poa)){
				$waxo=" pf.id_axo_poa =  '".$this->axo_poa."' ";
			}
			
			if (!empty($this->anpid)){
				$wanp= " pa.id_anp =  '".$this->anpid."' ";
			}
			
			if ($waxo && $wanp){
				$wanp=" AND ".$wanp; 
			}
			
			if (!empty($this->id_user)&&!empty($this->fnts_fin)){
			 	$wanp=" AND ff.id_ff IN (".$this->fnts_fin.")";
				/*$wanp.=" AND fuente_usuario.id_usuario=".$this->id_user;
				if($_SESSION[Module]<5) $wanp.=" AND fuente_usuario.id_submodulo='1' ";
				else  $wanp.=" AND fuente_usuario.id_submodulo='5' ";*/
			}
			$where=$waxo.$wanp;

			
		$sql_where=" WHERE ( ".$where." ) ";
		$sql_group=" GROUP BY ";
		$sql_order=" ORDER BY ";
		
			
		if ($cwhere){
			$sql_where.=$cwhere;
		}
		
		if ($cgroup){
			$sql_group.=$cgroup;
		}else{
			$sql_group="";
		}
		
		if($corder){
			if(strcmp($corder,"No")==0) $sql_order="";
			else $sql_order.=$corder;
		}else{
			$sql_order.=$tcampos. " ASC ";
		}
		//echo " AND fuente_usuario.id_usuario=".$this->id_user; 
		//die($sql_select.$tcampos.$sql_from.$sql_where.$sql_group.$sql_order);
		return $sql=$sql_select.$tcampos.$sql_from.$sql_where.$sql_group.$sql_order;
	
	}

function set_proy($tcampos,$cwhere='',$cgroup='',$corder='codigo_componente_ff',$Addtable=''){
		$sql_select="SELECT ";
		$sql_from="FROM ficha_proyecto_dt AS fpdt
Inner Join ficha_proyecto AS fp ON fpdt.id_ficha_proyecto = fp.id_ficha_proyecto
Inner Join tarea AS t ON fpdt.id_tarea = t.id_tarea
Inner Join programacion_partidas AS pp ON fpdt.id_asignacion_ff_anp_objetivos = pp.id_ff_anp_subactividad
Inner Join programacion_partidas_meses AS ppm ON pp.id_programacion_partidas = ppm.id_programacion_partidas
Inner Join componente_ff AS cff ON fp.id_actividad = cff.id_componente_ff
Inner Join asignacion_ff_anp_objetivos AS affao ON fpdt.id_asignacion_ff_anp_objetivos = affao.id_asignacion_ff_anp_objetivos AND affao.id_asignacion_ff_anp_objetivos = pp.id_ff_anp_subactividad
Inner Join presupuesto_anp AS pa ON affao.id_presupuesto_anp = pa.id_presupuesto_anp
Inner Join presupuesto_ff AS pff ON pa.id_presupuesto_ff = pff.id_presupuesto_ff";			
		//$sql_from.=" Inner Join fuente_usuario ON fuente_usuario.id_ff = ff.id_ff ";			
					if ($Addtable=="metas"){
						$sql_from=$sql_from." Inner Join metas 
												ON metas.id_ff_anp_subactividad = afao.id_asignacion_ff_anp_objetivos ";
						
					}
					if ($Addtable=="partida"){
						$sql_from=$sql_from." Inner Join partida ON partida.id_partida = pp.id_partida ";
					}
					if ($Addtable=="anp"){
						$sql_from=$sql_from." Inner Join anp a ON pa.id_anp = a.id_anp 
												Inner Join categoria ctg ON a.id_categoria=ctg.id_categoria ";
					}
			
			if (!empty($this->axo_poa)){
				$waxo=" fpdt.id_axo_poa =  '".$this->axo_poa."' ";
			}
			
			if (!empty($this->anpid)){
				$wanp= " fpdt.id_anp =  '".$this->anpid."' ";
			}
			
			if ($waxo && $wanp){
				$wanp=" AND ".$wanp; 
			}
			
			if (!empty($this->id_user)&&!empty($this->fnts_fin)){
			 	$wanp=" AND pff.id_ff IN (".$this->fnts_fin.")";
				/*$wanp.=" AND fuente_usuario.id_usuario=".$this->id_user;
				if($_SESSION[Module]<5) $wanp.=" AND fuente_usuario.id_submodulo='1' ";
				else  $wanp.=" AND fuente_usuario.id_submodulo='5' ";*/
			}
			$where=$waxo.$wanp;
			
			
		$sql_where=" WHERE ( ".$where." ) ";
		$sql_group=" GROUP BY ";
		$sql_order=" ORDER BY ";
		
			
		if ($cwhere){
			$sql_where.=$cwhere;
		}
		if ($cgroup){
			$sql_group.=$cgroup;
		}else{
			$sql_group="";
		}
		
		if($corder){
			if(strcmp($corder,"No")==0) $sql_order="";
			else $sql_order.=$corder;
		}else{
			$sql_order.=$tcampos. " ASC ";
		}
		//echo " AND fuente_usuario.id_usuario=".$this->id_user; 
		//die($sql_select.$tcampos.$sql_from.$sql_where.$sql_group.$sql_order);
		return $sql=$sql_select.$tcampos.$sql_from.$sql_where.$sql_group.$sql_order;
	
	}


	function sumar_programado_fuente($idff,$cwhere='',$campogroup='',$campoorder=''){
		$camposuma=" Sum(ppm.monto_programacion_partidas_meses) AS monto_total, pf.tipo_cambio_ff ";
		$wherefuente=" AND pf.id_ff='".$idff."'".$cwhere;
		$sql=$this->set_sql($camposuma,$wherefuente,$campogroup,$campoorder);
		$query=new Consulta($sql);
		$row=$query->ConsultaVerRegistro();
				if ($query->numregistros()>1){
					//die($sql);
					return "Es un array";
				}
			return $row;
	}

	function listar_ff_siglas($dato){
		for ($i=0;$i<count($dato)-1;$i++){
			$retval= $retval.fuente_siglas($dato[$i])."/";
		}
		$retval= $retval.fuente_siglas($dato[$i]);
		return $retval;
	}
	
	function SqlFtt($ftefto)	{
		if (is_array($ftefto)){
					$gsql=GeneraSqlArray($ftefto,"pf.id_ff"," OR ");
					$gsql=" AND (".$gsql.")";
		}
		$this->SqlFts=$gsql;
		return $gsql;
	}
	
	

	
	
////////////////////////
		function SqlFichas(){
			$sql=" SELECT s.id_subactividad, s.nombre_subactividad,s.codigo_subactividad,
					s.codigo_completo_subactividad,fs.id_presupuesto_anp,pf.id_axo_poa,asb.id_anp_subactividad,
					fs.id_ff_anp_subactividad,pa.id_anp,ff.id_ff,ff.siglas_ff,ff.nombre_ff
					FROM subactividad AS s , ff_anp_subactividad AS fs , fuente_financiamiento AS ff
					Inner Join presupuesto_ff AS pf ON pf.id_ff = ff.id_ff
					Inner Join presupuesto_anp AS pa ON fs.id_presupuesto_anp = pa.id_presupuesto_anp AND pa.id_presupuesto_ff = pf.id_presupuesto_ff
					Inner Join anp_subactividad AS asb ON s.id_subactividad = asb.id_subactividad AND asb.id_anp_subactividad = fs.id_anp_subactividad
					Inner Join programacion_partidas AS pp ON pp.id_ff_anp_subactividad = fs.id_ff_anp_subactividad
					WHERE (asb.id_anp =  '".$this->anpid."' AND pf.id_axo_poa =  '".$this->axo_poa."') ";
		return $sql;
		}
		
function set_sql_sol($tcampos,$cwhere='',$cgroup='',$corder='',$Addtable=''){
	$sql_f=" FROM `solicitud` Inner Join `anp` ON `anp`.`id_anp` = `solicitud`.`id_anp`
		Inner Join `fuente_financiamiento` ON `fuente_financiamiento`.`id_ff` = `solicitud`.`id_ff` 
		Inner Join fuente_usuario ON 'fuente_usuario'.'id_ff' = `fuente_financiamiento`.`id_ff` 
		Inner Join `solicitud_partidas` ON `solicitud`.`id_solicitud` = `solicitud_partidas`.`id_solicitud` 
		Inner Join `mes` ON `mes`.`id_mes` = `solicitud`.`id_mes`
		Inner Join `axo_poa` ON `axo_poa`.`id_axo_poa` = `solicitud`.`id_axo_poa`
		Inner Join `partida` ON `partida`.`id_partida` = `solicitud_partidas`.`id_partida`
		Inner Join `subactividad` ON `subactividad`.`id_subactividad` =
		`solicitud_partidas`.`id_subactividad` ";
	
	if (!empty($this->axo_poa)){
		$waxo=" `axo_poa`.`id_axo_poa` =  '".$this->axo_poa."' ";
	}
	if (!empty($this->anpid)){
		$wanp=" `anp`.`id_anp` =  '".$this->anpid."' ";
	}
	
	if (!empty($this->anpid)&&!empty($this->axo_poa)) $wanp=$waxo." AND ".$wanp;	
			
	if (!empty($this->id_user)){
	 	$wanp.=" AND fuente_usuario.id_usuario=".$this->id_user;
				if($_SESSION[Module]<5) $wanp.=" AND fuente_usuario.id_submodulo='1' ";
				else  $wanp.=" AND fuente_usuario.id_submodulo='5' ";
	}
	
	$sql_w=" WHERE ".$wanp.$cwhere;
	
	if(!empty($cgroup)) $sql_g=" GROUP BY ".$cgroup;
	if(!empty($corder)) $sql_o=" ORDER BY ".$corder;
	
	$sql="Select ".$tcampos.$sql_f.$sql_w.$sql_g.$sql_o;
	return $sql;
}		

}
?>