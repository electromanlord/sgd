<?
class Anps{

function AnpsUpdate($id, $_POST){
    if(empty($id)){
        echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";
    }else if(!$_POST){
        echo "<div id=error>La actualizacion no se puede efectuar por que no pasaron los datos </div>";
    }else{
		$Query = new Consulta(" DELETE FROM areaspro_bdstdsernanp.anp_jefe WHERE id_anp = '$id'"); 
        $Query = new Consulta(" INSERT INTO areaspro_bdstdsernanp.anp_jefe VALUES('','".$id."','".$_POST['cbojefe']."')"); 

/*			echo  " UPDATE Anps SET nombre_Anp='".$_POST['txtnombre']."' ,
                            abve_nombre_Anp='".$_POST['txtabreviatura']."',
                            id_responsable_Anp='".$_POST['cboresponsable']."'
                            WHERE id_Anp='".$id."'";*/

        echo "<div id=error>La actualizacion se realizo Correctamente </div>";
    }
}

function AnpsEdit($id){ 
    if(!$id){
        echo "<div id=error>ERROR: no se encontro ningun Anp con ese Id ? le falta Id  </div>";
    }else{
		$sql = "SELECT 
				a.codigo_anp as codigo_anp,
				a.nombre_anp as nombre_anp,
				a.siglas_anp as siglas_anp,
				ja.id_usuario as jefe_anp,
				aa.id_usuario as admin_anp
				FROM areaspro_dbsiganp1.anp as a
				LEFT JOIN areaspro_bdstdsernanp.anp_jefe AS ja ON a.id_anp = ja.id_anp
				LEFT JOIN areaspro_bdstdsernanp.usuarios AS u ON u.id_usuario = ja.id_usuario
				LEFT JOIN areaspro_bdstdsernanp.anp_administrador AS aa ON a.id_anp = aa.id_anp
				LEFT JOIN areaspro_bdstdsernanp.usuarios AS us ON us.id_usuario = aa.id_usuario
				WHERE a.id_anp='".$id."' ";
				
        $Query	= new Consulta($sql);
        $Row	= $Query->VerRegistro();
        $sql_usuarios = "SELECT * FROM usuarios where id_anp='".$id."' ORDER BY 5";
	
        $query_usuarios= new Consulta($sql_usuarios);		
        ?>
        <form name="form_editar_Anp" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>" method="post">
            <table width="370" align="center" id="mantenimiento">
                <TR>
                  <TD height="24" colspan="6" class='subtit'><div align="center">DATOS DE ANP </div></TD>
                </TR>
                <tr>
                  <td colspan="3" align="right" class="Estilo21">&nbsp;</td>
                  <td colspan="3" align="left">&nbsp;</td>
              </tr>
                <tr>
                  <td align="right" class="Estilo21">&nbsp;</td>
                  <td align="right" class="Estilo22"><div align="left">C&oacute;digo</div></td>
                  <td align="right"><div align="left" class="Estilo22">:</div></td>
                  <td colspan="3" align="left"><input  name="txtcodigo" type="text" id="txtcodigo" value="<?php echo $Row['codigo_anp']?>" size="10" disabled="disabled" class="disabled"></td>
                </tr>
                <tr>
                  <td width="1" align="right" class="Estilo21">&nbsp;</td>
                  <td width="86" align="right"><div align="left" class="Estilo22">Nombre</div></td>
                  <td width="3" align="right"><div align="left" class="Estilo22">:</div></td>
                  <td colspan="3" align="left"><input name="txtnombre" type="text" id="txtnombre" value="<?php echo $Row['nombre_anp']?>" size="40" disabled="disabled" class="disabled"></td>
                </tr>
                <tr>
                  <td align="right" class="Estilo21">&nbsp;</td>
                  <td align="right" class="Estilo22"><div align="left">Siglas</div>                  </td>
                  <td align="right"><div align="left" class="Estilo22">:</div></td>
                  <td colspan="3" align="left"><input  name="txtsiglas" type="text" id="txtsiglas" value="<?php echo $Row['siglas_anp']?>" size="10" disabled="disabled" class="disabled"></td>
                </tr>
                <tr>
                  <td align="right" class="Estilo21">&nbsp;</td>
                    <td align="right" class="Estilo22"><div align="left">Jefe</div></td>
                    <td align="right"><div align="left" class="Estilo22">:</div></td>
                    <td colspan="3" align="left">
					<select name="cbojefe" id="cbojefe"  style="width:220px;" class="caja">
                      <option value="">--Seleccione un Jefe--</option>
                      <? while($row_usuario=$query_usuarios->ConsultaVerRegistro()) {?>
                      <option value="<? echo $row_usuario[0]?>" <? if($row_usuario[0]==$Row["jefe_anp"]) echo 'selected = "selected"'?> />
                      <? echo $row_usuario["apellidos_usuario"]." ".$row_usuario["nombre_usuario"]?>
                      </option>
                      <? } ?>
                    </select></td>
			    </tr>
                
                <tr><td colspan="6">&nbsp;&nbsp;&nbsp;</tr>
                <tr>
                    <td height="27" colspan="6" align="center"><input type="submit" name="enviar" value="Guardar" class="boton"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="boton" type="reset" name="cancelar" value="Cancelar" onClick="javascript:window.history.go(-1)"></td></tr>
            </table>
        </form>	<?php
    }
}

function AnpsDelete($id){
    if(empty($id)){
        echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";
    }else{

        $Query= new Consulta($sql = "DELETE FROM Anps WHERE id_Anp='$id'");
        echo "<div id=error>Se elimino el registro Correctamente </div>";
    }
}

function AnpsList(){

    $sql = "SELECT
			a.id_anp,
			a.nombre_anp AS Nombre,
			a.siglas_anp AS Siglas,
			concat(u.nombre_usuario,' ',u.apellidos_usuario) as Jefe,
			u.email_usuario as Correo
			FROM areaspro_dbsiganp1.anp as a
			LEFT JOIN areaspro_bdstdsernanp.anp_jefe AS ja ON a.id_anp = ja.id_anp
			LEFT JOIN areaspro_bdstdsernanp.usuarios AS u ON u.id_usuario = ja.id_usuario
			LEFT JOIN areaspro_bdstdsernanp.anp_administrador AS aa ON a.id_anp = aa.id_anp
			LEFT JOIN areaspro_bdstdsernanp.usuarios AS us ON us.id_usuario = aa.id_usuario
			ORDER BY 2";

    $query = new Consulta($sql);
    echo $query->VerListado("anp.php","anp.php");

}

function AnpsDetalleAnp($ida){

    $sql_Anps = "Select * from areaspro_dbsiganp1.anp where id_Anp <> $ida";
    $query_Anps = new Consulta($sql_Anps);

?>
<form id="form_detalle_Anp" name="form_detalle_Anp" method="post" action="<? echo $_SERVER['PHP_SELF']?>?opcion=addAnp&id=<?=$ida?>">
          <table width="491" height="80" border="1" align="center">
            <tr bgcolor="#6699CC">
              <td width="240"><div align="center">Nombre</div></td>
              <td width="136"><div align="center">Abreviatura</div></td>
              <td width="93"><div align="center">Activar</div></td>
            </tr>
            <?
                while($row_Anps=$query_Anps->ConsultaVerRegistro()) {
                $id = $row_Anps["id_Anp"];
          ?>
            <tr>
              <td><div align="left">
                  <?=$row_Anps["nombre_Anp"]?>
              </div></td>
              <td><div align="center">
                  <?=$row_Anps["abve_nombre_Anp"]?>
              </div></td>
              <td width="93"><div align="center">
                <?
                    $sql_a_a = "select *
                                from Anps_Anps
                                where id_Anp_primaria = $ida
                                and id_Anp_secundaria = $id";
                    $query_a_a = new Consulta($sql_a_a);
                    $n = $query_a_a->NumeroRegistros();
                ?>
                    <input type="checkbox" name="opcion[]" value="<?=$id?>" <? if($n == 1) echo "checked = checked";?>/>
              </div></td>
            </tr>
            <?
        }
        ?>
            <tr>
              <td height="23" colspan="4"><div align="center">
                  <input type="submit" name="guardar" value="Guardar" class="boton" />
                  <input class="boton" type="reset" name="cancelar" value="Cancelar" onClick="javascript:window.history.go(-1)"/>
              </div></td>
            </tr>
          </table>
</form>
        <?
}

function GuardarDetalleAnp($ida, $_POST){

    if(!$_POST){
        echo "<div id=error>ERROR: No se pudo Agregar las Anps por fala de datos </div>";
    }else{
        $DelQuery=new Consulta($sql="DELETE FROM Anps_Anps WHERE id_Anp_primaria=".$ida."");

        for($i=0; $i<sizeof($_POST['opcion']);$i++){
            if($_POST['opcion'][$i]){
                $Query= new Consulta($sql = "INSERT INTO Anps_Anps VALUES('','".$ida."' ,'".$_POST['opcion'][$i]."') ");
            }
        }
            echo "<div id=error> Se Activaron las Anps Correctamente </div>";
            Anps::AnpsList();
    }

}
	
}
?>
		
