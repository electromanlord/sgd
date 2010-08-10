<?
require("../includes.php");
require("../cls/login.cls.php");
require("../cls/validar.cls.php");
require("../cls/interfaz.cls.php");
require("libs/verificar.inc.php");

$link=new Conexion();
$cnLogin=new Login();
$links=$cnLogin->LoginSessionAxo($_SESSION[inrena_4][2],$PHP_SELF);
?>
<html>
<link href="../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/js.js"></script> 
<script language="javascript" src="../js/calc.js"></script> 
<body onUnload="Cerrar_Session();">
<!--<?=$AuthVar['idu']?>-->
<table border=0 class='table' width='100%' height="100%"  bgcolor=white cellpadding=1 cellspacing=2   align=center >
<tr align=center>
	<td height=120 bgcolor=white valign=top >
		<p><img src='../imgs/logo.jpg'  width=180 height=80>	    </p>
		<p><strong>SELPO</strong></p>
		<table width="100%"  border="0" cellspacing="8" cellpadding="5">
	  		<tr>
				<td nowrap>
					<div align="center">
			  		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div align="right"><a href="#" onclick='RetrocederPag()'  title="Retroceder Pagina">
							<img src="../imgs/b_firstpage.png" alt="Atras" width="16" height="13" border="0"></a></div></td>
							<td><div align="center"><a href="#" title='salir' onClick="Close();">
							<img src="../imgs/s_loggoff.png" alt="Salir" border=0></a></div></td>
							<td><a href="#" onclick='AvanzarPag()' title="Siguiente Pagina" >
							<img src="../imgs/b_lastpage.png" alt="Siguente" width="16" height="13" border="0"></a></td>
						</tr>
			  		</table>	
		  			</div>				</td>
	  		</tr>
	</table>	</td>
</tr>
<?
Interfaz::InterfazMenu(4, $_SESSION[inrena_4][1]);
?>

<td height="45"><b> </b></td> 
</tr><tr>
  <td valign="bottom"><table width="100%"  border="0" cellspacing="4" cellpadding="2">
    <tr>
      <td colspan="3" align="left"><?=$links[2]?>
        &nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" align="right"><?=$links[0]?>
      </td>
      <td width="5%" nowrap><b>POA -
            <?=axo($_SESSION[inrena_4][2]); ?>
      </b> </td>
      <td width="50%"><?=$links[1]?></td>
    </tr>
  </table></td>
</tr>
</table>
</html>
