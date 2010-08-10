<?php
require("../../includes.php");
require("../funciones/reportes.php");
require("../cls/informacionsinampe/asignacionftporsubactividades.cls.php");
require("../cls/informacionsinampe/asignacionporsubactividades.cls.php");
require_once("../cls/informacionsinampe/asignacionftporpartidas.cls.php");
require("../cls/informacionsinampe/partida_mensual.cls.php");
require("../cls/informacionsinampe/anp_x_fuente_finan.cls.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
//$session_anp=$_SESSION[anp];
$axo=$_SESSION[inrena_4][2];

?>
<? //=print_r($_SESSION);?>
<title>Reporte</title>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script> 
<body topmargin="0">
<form name="f1" method="post" action="">
<table width="85%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><img src="../../imgs/logo.jpg" border="0" width="100%" height="100"></td>
  </tr>
</table>
<?
	

	switch($ID){
	case '1':
		$AAnpS=new AsignacionporSubactividades();
		$AAnpS->mostrar_ff_chk();
	break;
	case '2':
			$AFtS=new AsignacionporFtSubactividades();
			$AFtS->mostrar_ff_chk();
	break;
	case '3':
			$AFtsP=new AsignacionFtsporPartidas();
			$AFtsP->mostrar_ff_chk();

	break;
	case '4':
			$AParMes=new Partida_Mensual();
			$AParMes->ejecutor=$eje;
			$AParMes->mes=$month;
			$AParMes->axo=$axo;
			$AParMes->form_Partida();
	break;
	
	case '5':
			$AFntF=new ANP_x_FF();
			$AFntF->mostrar_ComboBox();
	break;
	case '6':
		$obj=new SqlSelect('',$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
		$sql=$obj->set_sql(" nombre_categoria, nombre_anp, a.id_anp "," "," pa.id_anp"," pa.id_anp","anp");
		$Qanp=new Consulta($sql);	
		?>
		<form name='f1' method="post" >
		<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><br/>
		<strong>Seleccione ANP</strong></td>
		</tr>
		<tr>
		  <td align='center'>
		<select name='lista_anp[]' size="10" multiple >
		<? 		
			$n=0;
			while($idanp=$Qanp->ConsultaVerRegistro()){
			echo "<option value='$idanp[2]'>$idanp[0] $idanp[1]</option>"; 
			$n=1;
			}
			?>
        </select><br />
		<? if($n==0){ 
				echo "<font color='ff0000'><strong>
					No hay ANPs con Asiganciones este Año</strong>
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
		<input name="mostrar" type="image" src='../../imgs/b_select.png' value="Mostrar Reporte" onClick="ver_tareas_x_anp()"
		 alt="Ver Reporte" align="absmiddle" border="0"  /> Mostrar Reporte</td></tr>
		</table></form><?		
	break;
	case '7':
		$obj=new SqlSelect('',$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
		$sql=$obj->set_sql(" nombre_categoria, nombre_anp, a.id_anp "," "," pa.id_anp"," pa.id_anp","anp");
		$Qanp=new Consulta($sql);			
		$Qff=new Consulta($sqlff=$obj->set_sql("ff.id_fuentefinanciamiento,ff.id_ff,ff.siglas_ff"," ","ff.id_ff","ff.id_ff"));
		?>
		<form name='f1' method="post" action="" >
		<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
		<tr><td align='center'><br/>
		<strong>Seleccione Fuente de Financiamiento</strong></td></tr>
		<tr><td align='center'>
		<select name='lista_ff[]' size="10" multiple >
		<? 	$m=0;	
			while($f_f=$Qff->ConsultaVerRegistro()){
				//$row_ff=table_row($f_f['id_fuentefinanciamiento'],"fuentefinanciamiento");
				echo "<option value='".$f_f[id_ff]."'>".$f_f[siglas_ff]."</option>"; 
				$m=1;
			}
			?>
        </select><br />
		<? if($m==0){ 
				echo "<font color='ff0000'><strong>
					No hay FFs con Asiganciones este Año</strong>
					</font>";		
			} 
			else{
				echo "<strong>
					Para hacer m&aacute;s de una Selecci&oacute;n 
					Presione (Ctrl) + click en las Fuentes adicionales</strong>";
			}?>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><br/>
		<strong>Seleccione ANP</strong></td>
		</tr>
		<tr>
		  <td align='center'>
		
		<select name='lista_anp[]' size="10" multiple >
		<?php 		
			$n=0;
			while($idanp=$Qanp->ConsultaVerRegistro()){
			echo "<option value='$idanp[2]'>$idanp[0] $idanp[1]</option>"; 
			$n=1;
			}
			?>
        </select><br />
		<? if($n==0){ 
				echo "<font color='ff0000'><strong>
					No hay ANPs con Asiganciones este Año</strong>
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
		<input name="mostrar" type="image" src='../../imgs/b_select.png' value="Mostrar Reporte" onClick="ver_metas_tareas_x_anp()"
		 alt="Ver Reporte" align="absmiddle" border="0"  /> Mostrar Reporte</td></tr>
		</table></form><?		
	break;
	case '8':
		$obj=new SqlSelect('',$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
		$sql=$obj->set_sql(" nombre_categoria, nombre_anp, a.id_anp "," "," pa.id_anp"," pa.id_anp","anp");
		$Qanp=new Consulta($sql);			
		$Qff=new Consulta($sqlff=$obj->set_sql("ff.id_fuentefinanciamiento,ff.id_ff,ff.siglas_ff"," ","ff.id_ff","ff.id_ff"));
		?>
		<form name='f1' method="post" >
		<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
		<tr><td align='center'><br/>
		<strong>Seleccione Fuente de Financiamiento</strong></td></tr>
		<tr><td align='center'>
		<select name='lista_ff[]' size="10" multiple >
		<? 	$m=0;	
			while($f_f=$Qff->ConsultaVerRegistro()){
				//$row_ff=table_row($f_f['id_fuentefinanciamiento'],"fuentefinanciamiento");
				echo "<option value='".$f_f[id_ff]."'>".$f_f[siglas_ff]."</option>"; 
				$m=1;
			}
			?>
        </select><br />
		<?php if($m==0){ 
				echo "<font color='ff0000'><strong>
					No hay FFs con Asiganciones este Año</strong>
					</font>";		
			} 
			else{
				echo "<strong>
					Para hacer m&aacute;s de una Selecci&oacute;n 
					Presione (Ctrl) + click en las Fuentes adicionales</strong>";
			} ?>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		
		
		<tr><td align='center'><br>
		<input name="mostrar" type="image" src='../../imgs/b_select.png' value="Mostrar Reporte" onClick="ver_articulacion_objetivos()" alt="Ver Reporte" align="absmiddle" border="0"  /> Mostrar Reporte</td></tr>
		</table></form><?php
	break;
	
	case '9':
		$obj=new SqlSelect('',$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
		$sql=$obj->set_sql(" nombre_categoria, nombre_anp, a.id_anp "," "," pa.id_anp"," pa.id_anp","anp");
		$Qanp=new Consulta($sql);	
		//print_r($_POST);
		?>
		<form name='f1' method="post" >
		<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><br/>
		<strong>Seleccione ANP</strong></td>
		</tr>
		<tr>
		  <td align='center'>
		<select name='idanp' size="1">
		<? 		
			$n=0;
			while($idanp=$Qanp->ConsultaVerRegistro()){
			echo "<option value='$idanp[2]'>$idanp[0] $idanp[1]</option>"; 
			$n=1;
			}
			?>
        </select><br />
		<? if($n==0){ 
				echo "<font color='ff0000'><strong>
					No hay ANPs con Asiganaciones este Año</strong>
					</font>";		
			} 
			?>
		</td>
		</tr>
		<tr><td align='center'><br>
		<input name="mostrar" type="image" src='../../imgs/b_select.png' value="Mostrar Reporte" 
		 alt="Ver Reporte" onClick="reporte_formato4()" align="absmiddle" border="0" /> Mostrar Reporte</td></tr>
		</table></form><?		
	break;
	
	case '10':
		$obj=new SqlSelect('',$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
		$sql=$obj->set_sql(" nombre_categoria, nombre_anp, a.id_anp "," "," pa.id_anp"," pa.id_anp","anp");
		$Qanp=new Consulta($sql);	
		?>
		<form name='f1' method="post" >
		<table width='85%'  border='0'cellspacing='0' cellpadding='0' align='center'>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><br/>
		<strong>Seleccione ANP</strong></td>
		</tr>
		<tr>
		  <td align='center'>
		<select name='anp' size="1" onChange="submit()">
		<option value="0">--- Seleccione ANP ---</option>
		<? 		
			$n=0;
			while($idanp=$Qanp->ConsultaVerRegistro()){
				if($_POST[anp]==$idanp[2]) $estado="selected"; else $estado="";
			echo "<option value='$idanp[2]' $estado >$idanp[0] $idanp[1]</option>"; 
			$n=1;
			}
			?>
        </select><br />
		<? if($n==0){ 
				echo "<font color='ff0000'><strong>
					No hay ANPs con Asiganaciones este Año</strong>
					</font>";		
			} 
			?>
		</td>
		</tr>
		<tr><td align='center'>
		<?
		if($_POST[anp]){
			$obj=new SqlSelect($_POST[anp],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
			$sqlff=$obj->set_sql("ff.id_fuentefinanciamiento,ff.id_ff,ff.siglas_ff"," ","ff.id_ff","ff.id_ff");
			$Qff=new Consulta($sqlff);		
		?>
		<br><br><strong>Seleccione Fuente de Financiamiento</strong><br>
		<select name='lista_ff[]' size="10" multiple >
		<? 	$m=0;	
			while($f_f=$Qff->ConsultaVerRegistro()){
				//$row_ff=table_row($f_f['id_fuentefinanciamiento'],"fuentefinanciamiento");
				echo "<option value='".$f_f[id_ff]."'>".$f_f[siglas_ff]."</option>"; 
				$m=1;
			}
			?>
        </select><br />
		<? if($m==0){ 
				echo "<font color='ff0000'><strong>
					No hay FFs con Asiganciones este Año</strong>
					</font>";		
			} 
			else{
				echo "<strong>
					Para hacer m&aacute;s de una Selecci&oacute;n 
					Presione (Ctrl) + click en las Fuentes adicionales</strong>";
			} 
		}//ff?>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><br>
		<input name="mostrar" type="image" src='../../imgs/b_select.png' value="Mostrar Reporte" 
			onClick="reporte_formato5()"
		 alt="Ver Reporte" align="absmiddle" border="0"  /> Mostrar Reporte</td></tr>
		</table></form><?		
	break;
}	
//print_r($_SESSION);
//$_SESSION[anp]=$session_anp;
echo'
</form>
<script>
	window.focus()
</script>
</body>
</html>';
?>