
<?
class FichaMeses extends SqlSelect{

function FichaMeses($anpid,$axo_poa,$id_user){ 

$sql="SELECT m.*
FROM
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
Inner Join `objetivo_estrategico` AS `oe` ON `oe`.`id_objetivo_estrategico` = `aoest`.`id_objetivo_estrategico`
Inner Join `mes` AS `m` ON `ppm`.`id_mes` = `m`.`id_mes`
WHERE
`aao`.`id_anp` =  '".$anpid."' AND
`aao`.`id_axo_poa` =  '".$axo_poa."'

GROUP BY
`ppm`.`id_mes`"; 
		$Q_m=new Consulta($sql);?>
		
			
			
	<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
body {
	background-color: #c0cccc;
}
body,td,th {
	color: #333300;
}
-->
    </style>
<form id="form1" name="form1" method="post" action="">
  <label>
  <div align="center"><span class="Estilo1">Seleccione el Mes</span><br />
    <select name="idmes" onchange="submit()">
      <option value="0">Elija el Mes</option>
	 <? 
			while($row_m=$Q_m->ConsultaVerRegistro()){
				if($_POST[idmes]==$row_m[0]) $select="selected"; else $select=""; ?>	
						<option value="<?=$row_m[0]?>" <?=$select?> ><?=$row_m[1]?></option><?				
			}	
		?> 
    </select>
  </div>
  </label>
</form>		
	<?	}}?>
	
	
