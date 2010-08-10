<?
require("../includes.php");
require("libs/verificar.inc.php");
$link=new Conexion();
?>
<link href="../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/js.js"></script> 
<?
echo"<table width=100% border=0 height=100% class=table bgcolor='white'>";
echo"<tr><td ALIGN=CENTER valign=middle style='color:#14506E;'><h3>";
echo"BIENVENIDO AL MÓDULO DE REPORTES";
echo"</h3>";
echo "<h3>POA - ".axo($_SESSION[inrena_4][2])."</h3>";
echo"<br><br><span style='font-family:verdana;font-size:10px'>";
echo"Seleccione a la izquierda el subm&oacute;dulo que desea utilizar";
echo"</span>";
echo"</table>";
?>