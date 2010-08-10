<?
require("../../includes.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
</head>
<BODY>
<table width=100% border=0 height=100% class=table bgcolor=white>
<tr><td ALIGN=CENTER valign=middle style='color:#14506E;'><h3>
BIENVENIDO AL M&Oacute;DULO DE REPORTES
</h3>
    <h3>POA - <?=axo($_SESSION[inrena_4][2])?></h3>
<span style='font-family:verdana;font-size:10px'>
Seleccione la ANP 
</span>
</table>
<?
$query ="SELECT distinct(anp.siglas_anp),anp.id_categoria,anp.nombre_anp as nom,anp.id_anp,categoria.nombre_categoria as cat
		FROM `anp`,`categoria`,anp_usuario
		where anp.id_categoria=categoria.id_categoria  and anp_usuario.id_usuario='".$_SESSION[inrena_4][1]."' and anp.id_anp=anp_usuario.id_anp 
ORDER BY anp.codigo_anp";
//ORDER BY `categoria`.`id_categoria` ASC, `anp`.`siglas_anp` ASC";
//echo $query;
$query=mysql_query($query) or die(mysql_error());
$fla = mysql_fetch_array($query);
$num = mysql_num_rows($query);

if($num=='0'){
?>
	<table border = '0' width='200'  align='center' bgcolor=white  class=table > 
	<tr> 
	<td align="left">Aun sin ANP Ingresadas
	  o ud no tiene permiso para este seccion </td>
	</tr> 
	</table> 
<?
}elseif($num>='0'){
	echo "<table border = '0' align='center' bgcolor=white  class=table > \n";
	echo "<tr> \n";
	echo"<th>Siglas</th>\n";
	echo"<th>Categoria</th>\n";
	echo"<th>Nombre</th>\n";
	echo"<th>Opc.</th>\n";
	echo"</tr>\n";
	
	do{	
	  	echo'<TR onmouseover="entrar(this,\''.FFE7B0.'\');" onmouseout="salir(this,\''.f7f7f7.'\');" bgColor=#f7f7f7>';
		echo "<td>".$fla["siglas_anp"]."</td>\n";
		echo "<td>".$fla["cat"]." </td>\n";
		echo "<td>".$fla["nom"]."</td>\n";
		echo "<td><A href='menuanp.php?tr=2&anpid=".$fla["id_anp"]."&anpnom=".$fla["nom"]."&anpcate=".$fla["cat"]."'><img src='../../imgs/b_props.png' title='Seleccionar ANP' border=0></A></td>\n";
	}while ($fla = mysql_fetch_array($query));

	echo "</tr> \n";
	echo "</table> \n";
	 }
 ?>

</body>
</html>