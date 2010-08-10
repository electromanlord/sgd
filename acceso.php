<div id="acceso" style="width:100%">
	<form name="f1" method="post" action="validacion.php" onsubmit="valida();" >  			 
		<label></label>
		<br />
		<table width="232" border="0" align="center" cellpadding="0" cellspacing="0">
            <!--  Login Form-->
          <tr>
            <td width="63" height="28" class="Estilo22" style="vertical-align:middle"><div align="left">Usuario</div></td>
            <td width="9" class="Estilo22" style="vertical-align:middle"><div align="center">:</div></td>
            <td width="160"><input type="text" name="usuario" id="usuario" class="caja"/></td>
          </tr>
          <tr>
            <td height="28" class="Estilo22" style="vertical-align:middle"><div align="left">Password</div></td>
            <td class="Estilo22" style="vertical-align:middle"><div align="center">:</div></td>
            <td><input type="password" name="password" onkeypress="checkTheKey(event.keyCode)" id="password" class="caja"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><div align="center">
              <input type="submit" name="enviar" value="Ingresar" class="boton" />
            </div></td>
          </tr>
      </table>
		<br /> 
		<?php
if($error){ ?>
	<div class="error"><?php echo " ERROR: Usuario o Password Incorrecto, Por favor ingrese de nuevo! ";?></div><?php
 }?>
	</form>
</div>
