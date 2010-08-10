<?php 
require_once("includes.php");
$sql_listado = " SELECT * FROM  documentos ";
$query_listado = new Consulta($sql_listado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DOCUMENTOS PENDIENTES</title>
</head>
<body>
<p align="center" class="Estilo9"><img src="CABEZERA.JPG" alt="." width="921" height="78" /></p>
<table width="100%" border="0">
  <tr>
    <td width="71%" class="Estilo9"><a href="http://www.minam.gob.pe/" class="pathway">SERNANP</a> &gt;<a href="http://www.minam.gob.pe/" class="pathway">Sistema de Tr&aacute;mite Documentario</a>&gt;<span class="breadcrumbs pathway">Direcci&oacute;n de Desarrollo Estrat&eacute;gico</span></td>
    <td width="29%"><div align="right" class="Estilo9">Usuario del Sistema: <?php echo  $_SESSION['usuario']['nombres'] ?></div></td>
  </tr>
</table>
<fieldset>
<legend class="Estilo9">DOCUMENTOS PENDIENTES </legend>
<table width="100%" border="1" align="center">
  <tr>
    <td width="4%"><div align="center"><span class="Estilo9">Reg. N&ordm;</span></div></td>
    <td width="7%"><div align="center"><span class="Estilo9">Tipo de Doc.</span></div></td>
    <td width="9%"><div align="center"><span class="Estilo9">Nro Documento</span></div></td>
    <td width="11%"><div align="center"><span class="Estilo9">Acci&oacute;n</span></div></td>
    <td width="28%"><div align="center"><span class="Estilo9">Asunto</span></div></td>
    <td width="8%"><div align="center"><span class="Estilo9">Estado</span></div></td>
    <td width="9%" class="Estilo9"><div align="center">Documento Digitalizado (PDF) </div></td>
    <td width="9%"><div align="center"><span class="Estilo9">Fecha programada de Respuesta </span></div></td>
    <td width="8%"><div align="center"><span class="Estilo9">Prioridad</span></div></td>
    <td width="7%" class="Estilo9"><div align="center">Atenci&oacute;n</div></td>
  </tr><?php
  while($row = $query_listado->ConsultaVerRegistro()){?>
  
  <tr>
    <td><span class="Estilo7"><a href="detalle_documento.php?<?php echo $row['id_tramite'] ?>"> <?php echo $row[''] ?>0006</a></span></td>
    <td><span class="Estilo14">INFORME</span></td>
    <td><span class="Estilo7">015-11-2008-JD</span></td>
    <td class="Estilo7">Acci&oacute;n Necesaria </td>
    <td class="Estilo7">REMITE INFORME DE TRABAJOS REALIZADOS SEGUN CONTRATO DE  CONSULTORIA ADDENMUN N&ordm; 1 PRRNP-C-CON-010-2008-PAN</td>
    <td class="Estilo7"><div align="center">Registrado<br />
      Derivado<a href="DirectorElaborarBorradorRespuesta.html"><br />
      Borrador 1</a> </div></td>
    <td class="Estilo7"><span class="Estilo7"><a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">8</a> <a href="#">9 </a></span></td>
    <td><span class="Estilo7">12/10/2006</span></td>
    <td bgcolor="#FF0000" class="Estilo9"><div align="center" class="Estilo15"><span class="Estilo7">ALTA</span></div></td>
    <td bgcolor="#FFFFFF" class="Estilo9"><div align="center">
        <input type="checkbox" name="checkbox" value="checkbox" />
    </div></td>
  </tr><?php
  }
  ?>
</table>
</fieldset> </p>
</body>
</html>
