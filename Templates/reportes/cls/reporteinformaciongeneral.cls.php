<?
class reporteinformaciongeneral{
var $nombre_reporte;
/***************************************************************************/	
function reporte_informacion_general($query,$reg1){
		$filas=$query->numcampos();
		$registros=$query->numregistros();
		if($_GET[pdf]=='ok') $fondo="";
		else $fondo="bgcolor='#EEEEEE'";
		$this->sql = "<table border=0  width='85%' $fondo align=center cellspacing=1 cellpadding=2>";
			$this->sql .="<tr>";
			for($i=0;$i<$filas;$i++){
				$align="";
				if($i==1){$align="left";}
				$this->sql .= "
				<th  align=$align bgcolor='#cccccc'>".$query->nombrecampo($i).""."</th>";
			}
			$this->sql .="</tr>";
		$w=1;
		$rows=0;
		$j=0;
		$n=0;
		while($rows=$query->ConsultaVerRegistro()){			
			$this->sql .= "<tr>";
				if($id==5 || $id==6){				
						for($i=0;$i<$filas;$i++){						
							$align="";
								if($i==0 || $i==4){$align="center";}
								//if($i==1){$align="center";}
								$this->sql .= "<td align=$align>". $rows[$i]."</td>";
						}
				}else{
				$T=$reg1+$w;
				
				//$this->sql .= "<td align=center> ".$T."</td>";
				$n++;
				//$this->sql .= "<td align=center> ".$n."</td>";
				for($i=0;$i<$filas;$i++){						
					$align="";
					if($i==0 || $i==4){$align="center";}
					$this->sql .= "<td align=$align>".$rows[$i]."</td>";
				}
			}
			$w++;
			$this->sql .= "</tr>";
		}
		$cdata=$this->sql."</table>";
		$this->sql="";
		return $cdata;				
	}
//**********************************************************************
function reporte_partidas($query,$reg1){
		$filas=$query->numcampos();
		$registros=$query->numregistros();
		if($_GET[pdf]=='ok') $fondo="";
		else $fondo="bgcolor='#EEEEEE'";
		$this->sql = "<table border=0 width='85%' align=center $fondo cellspacing=1 cellpadding=2>";
		$this->sql .="<tr>";
		for($i=0;$i<$filas;$i++){
			$align="";
			if($i==1){$align="'left' ";}
			//if($i==0){$ss=" width='15'";}
	   	$this->sql .= "<th align=$align bgcolor='#cccccc' nowrap='nowrap' >".$query->nombrecampo($i)."</th>";
		}
		$this->sql .="</tr>";
		$w=1;
		$rows=0;
		$j=0;
		while($rows=$query->ConsultaVerRegistro()){			
			$this->sql .= "<tr >";
			if($id==5 || $id==6){				
				for($i=0;$i<$filas;$i++){						
					$align="center";
					if($i==0 || $i==4){$align="center";}
					$this->sql .= "<td align=$align >".$rows[$i]."</td>";
				}
			}else{
			$T=$reg1+$w;
				for($i=1;$i<$filas+1;$i++){						
					$align="";
					if($i==1 || $i==4){$align="center";}
					//if($i==1){ $align.=" nowrap='nowrap'"; }
					$this->sql .= "<td align=$align >".$rows[$i-1]."</td>";
				}
			}
			$w++;
			$this->sql .= "</tr>";
		}
		$cdata=$this->sql."</table>";
		$this->sql="";
		return $cdata;				
	}	
/***************************************************************************/
function reporte_fuente($query,$reg1){
		$filas=$query->numcampos();
		$registros=$query->numregistros();
		if($_GET[pdf]=='ok') $fondo="";
		else $fondo="bgcolor='#EEEEEE'";
		$this->sql = "<table border=0  width='85%' $fondo align=center cellspacing=1 cellpadding=2>";
		$this->sql .="<tr>";
		for($i=0;$i<$filas;$i++){
			$align="";
			//if($i==1){$align="left";}
	   	$this->sql .= "<th align=$align bgcolor='#cccccc' nowrap='nowrap'>".$query->nombrecampo($i)."</th>";
		}
		$this->sql .="</tr>";
		$w=1;
		$rows=0;
		$j=0;
		while($rows=$query->ConsultaVerRegistro()){			
			$this->sql .= "<tr >";
			if($id==5 || $id==6){				
				for($i=0;$i<$filas;$i++){						
					$align="";
					if($i==0 || $i==4){$align="center";}
					$this->sql .= "<td align=$align>".$rows[$i]."</td>";
				}
			}else{
			$T=$reg1+$w;
			$band=0;
				for($i=1;$i<$filas+1;$i++){						
					$align="right";
					if($i==0 || $i==4 ){$align="center";}
					$miVar=$rows[$i-1];
					if($i==1||$i==2){$align="left";}
					///////
					if($i==1&&!strstr($miVar,'-')) $band=1;
					if($i==2&&$band==1){					
						$ej=explode('-',$miVar);
						$miVar=$ej[0];
					}
					/////
					if (is_numeric($miVar)){
						$miVar=num_format($miVar);
					}
					$this->sql .= "<td align=$align>".$miVar."</td>";
				}
			}
			$w++;
			$this->sql .= "</tr>";
		}
		$cdata=$this->sql."</table>";
		$this->sql="";
		return $cdata;				
	}	

//**********************************************************************
	function reporte_estructura_programatica($query1,$reg1){	
		if($_GET[pdf]=='ok') $fondo="";
		else $fondo="bgcolor='EEEEEE'";
		$filas=$query1->numregistros()+1;
		?>
		<table border=0 <?=$fondo?> width='85%' align='center' cellspacing=1 cellpadding=2>
		<tr><th colspan="4">Programa / SubPrograma / Actividad / SubActividad</th></tr>
		<?
		while($rows=$query1->ConsultaVerRegistro()){
		$cod_prog=$rows[id_programa];
		$indice=$rows[codigo_programa];
			?><tr bgcolor="#CCCCCC"><td width='5%' align='center'><B><?=$indice?></B></td>
					<td colspan="3"><b><?=$rows[nombre_programa]?></b></td></tr><?		
			$sql1="select codigo_subprograma,nombre_subprograma,id_subprograma from subprograma where id_programa=".$cod_prog;
			$query2=new Consulta($sql1);
			//aqui se hace la tabulacion para agregar el subprograma...........
				while($rows2=$query2->ConsultaVerRegistro()){
					$cod_subprog=$rows2[id_subprograma];
					$sub_indice=$indice.".".$rows2[codigo_subprograma];
					?><tr><td width='5%' align='center'><?=$sub_indice?></td>
						<td colspan="3"><?=$rows2[nombre_subprograma]?></td></tr><?
					$sql2="select codigo_actividad,nombre_actividad,id_actividad 
							from actividad where id_subprograma=".$cod_subprog;
					$query3=new Consulta($sql2);
					//aqui se muestran las actividades
					while($rows3=$query3->ConsultaVerRegistro()){
						$cod_acti=$rows3[id_actividad];
						$indice_activi=$sub_indice.".".$rows3[codigo_actividad];
						?><tr><td width='5%' align='center'>&nbsp;</td>
						<td width='5%' align='center'><?=$indice_activi?></td>
							<td colspan="2"><?=$rows3[nombre_actividad]?></td></tr>
							<? $sql3="select codigo_subactividad,nombre_subactividad,id_subactividad 
										from subactividad where id_actividad=".$cod_acti;
								$query4=new Consulta($sql3);
											//aqui se muestra las subactividades
								while($rows4=$query4->ConsultaVerRegistro()){
												$cod_subacti=$rows4[id_actividad];
									$indice_subactivi=$indice_activi.".".$rows4[codigo_subactividad];
									?><tr>
									<td width='5%' align='center'>&nbsp;</td>
									<td width=5% align=center>&nbsp;</td>
									<td width='5%' align='center'><?=$indice_subactivi?></td>
										<td><?=$rows4[nombre_subactividad]?></td></tr>
										<? }?>								
								<? }?>								
						<? }
		}	
		?></table><?			
	} 
/************************************************************************************/	
}
?>

