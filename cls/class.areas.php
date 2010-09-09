<?
class Areas{

function AreasNew(){				
		
    $sql_usuarios = "SELECT * FROM usuarios WHERE estado_usuario = 1";
	 $query_usuarios= new Consulta($sql_usuarios);
		
?>
<style type="text/css">
    .Estilo6 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: xx-small;
		color: #FFFFFF;
	}
</style>
				
	<form name="form_nueva_area" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=add" method="post">
		<table align="center" width="40%" height="179" id="mantenimiento">
			<tr>
				<td height="21" colspan="6" valign="top" class="subtit"><div align="center">NUEVA AREA </div></TD>
			</tr>
			<tr>
			  <td height="24" align="right" class="Estilo21">&nbsp;</td>
			  <td align="right" class="Estilo22">&nbsp;</td>
			  <td align="right" class="Estilo22">&nbsp;</td>
			  <td colspan="3" align="left">&nbsp;</td>
		  </tr>
			<tr>
				<td width="5%" height="24" align="right" class="Estilo21"><div align="center">(*)</div></td>
				<td align="right" width="27%" class="Estilo22"><div align="left">Nombre </div></td>
				<td align="right" width="2%" class="Estilo22"><div align="center">:</div></td>
				<td colspan="3" align="left">
					<input name="txtnombre" type="text" id="txtnombre" size="40" class="caja">				</td>
			</tr>
			
			<tr>
				<td height="24" align="right" class="Estilo21"> <div align="center">(*)</div></td>
				<td align="right" class="Estilo22"><div align="left">Abreviatura</div></td>
				<td align="right" class="Estilo22"><div align="center">:</div></td>
				<td colspan="3" align="left">
					<input  name="txtabreviatura" type="text" id="txtabreviatura" size="10" class="caja">				</td>
		  </tr>
				<!--<tr>
					<td align="right"><div align="left">Responsable:</div></td>
					<td colspan="3" align="left"><label>
					  <select name="cboresponsable" id="cboresponsable">
						<option value="">--Seleccione un Responsable--</option>
						 <? while($row_usuarios=$query_usuarios->ConsultaVerRegistro()) {?>
							<option value="<? echo $row_usuarios[0]?>">
								<? echo $row_usuarios["nombre_usuario"]." " ?>
								<? echo $row_usuarios["apellidos_usuario"]?>								</option>

						  <? } ?>
			    -->
				<tr>
				  <td height="21" colspan="6" align="center">&nbsp;</td>
		  </tr>
				<tr>
					<td height="26" colspan="6" align="center">
					<input type="submit" name="enviar2" value="Guardar" class="boton"/>					<input class="boton" type="reset" name="cancelar2" value="Cancelar" onClick="javascript:window.history.go(-1)"></td>
				</tr>
	  </table>
	</form>
<?php
		
	}

function AreasAdd(){
    if(!$_POST){
        echo "<div id=error>ERROR: No se pudo Agregar el Area por falta de datos </div>";
    }else{

        $sq=new Consulta("SELECT * FROM areas WHERE nombre_area='".$_POST['txtnombre']."'");

        if($sq->NumeroRegistros()==0){

            if($_POST['cboresponsable']){
                $sql = "INSERT INTO areas
                VALUES( '',
                '".$_POST['txtnombre']."',
                '".$_POST['txtabreviatura']."',
                '".$_POST['cboresponsable']."')";
            }
            else{
                $sql = "INSERT INTO areas
                VALUES( '',
                '".$_POST['txtnombre']."',
                '".$_POST['txtabreviatura']."',
                null)";
            }

            $Query= new Consulta($sql);
            echo "<div id=error> Se Ingreso la Nuevo Area Correctamente </div>";

        }else{?>
            <script>
                alert(" El usuario ya existe, por favor ingrese otro nombre de usuario ");
                location.replace("areas.php?opcion=new")
            </script>
        <?php
        }
    }
		
}

function AreasUpdate($id, $_POST){
    if(empty($id)){
        echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";
    }else if(!$_POST){
        echo "<div id=error>La actualizacion no se puede efectuar por que no pasaron los datos </div>";
    }else{

        $Query = new Consulta( 	 " UPDATE areas
                                    SET nombre_area='".$_POST['txtnombre']."' ,
                                        abve_nombre_area='".$_POST['txtabreviatura']."',
                                        id_responsable_area='".$_POST['cboresponsable']."'
                                    WHERE id_area='".$id."'");

/*			echo  " UPDATE areas SET nombre_area='".$_POST['txtnombre']."' ,
                            abve_nombre_area='".$_POST['txtabreviatura']."',
                            id_responsable_area='".$_POST['cboresponsable']."'
                            WHERE id_area='".$id."'";*/

        echo "<div id=error>La actualizacion se realizo Correctamente </div>";
    }
}

function AreasEdit($id){ 
    if(!$id){
        echo "<div id=error>ERROR: no se encontro ningun area con ese Id � le falta Id  </div>";
    }else{
        $Query	= new Consulta(" SELECT * FROM areas WHERE id_area='".$id."'");
        $Row	= $Query->VerRegistro();
        $sql_usuarios = "SELECT * FROM usuarios where id_area='".$id."' AND estado_usuario = 1";
        $query_usuarios= new Consulta($sql_usuarios);

        ?>
        <form name="form_editar_area" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>" method="post">
            <table width="382" align="center" id="mantenimiento">
                <TR>
                    <TD height="38" colspan="6" valign="top" class='subtit'><div align="center">EDITAR DATOS DE AREA </div></TD>
                </TR>
                <tr>
                  <td colspan="3" align="right" class="Estilo21">&nbsp;</td>
                  <td colspan="3" align="left">&nbsp;</td>
              </tr>
                <tr>
                  <td width="18" align="right" class="Estilo21">(*)</td>
                  <td width="106" align="right" class="Estilo22"><div align="left">Nombre</div></td>
                  <td width="6" align="right"><div align="left">  :</div></td>
                  <td width="250" colspan="3" align="left"><input name="txtnombre" type="text" id="txtnombre" value="<?php echo $Row['nombre_area']?>" size="40"></td>
                </tr>
                <tr>
                  <td align="right" class="Estilo21">(*)</td>
                    <td align="right" class="Estilo22"><div align="left">Abreviatura</div></td>
                    <td align="right"> <div align="left">  :</div>					    </td>
                    <td colspan="3" align="left"><input  name="txtabreviatura" type="text" id="txtabreviatura" value="<?php echo $Row['abve_nombre_area']?>" size="10"></td></tr>
                <tr>
                  <td align="right">&nbsp;</td>
                    <td align="right" class="Estilo22"><div align="left">Responsable</div></td>
                    <td align="right"><div align="left">:</div></td>
                <td colspan="3" align="left"><label>
                  <select name="cboresponsable" id="cboresponsable"  style="width:220px;">
                    <option value="">--Seleccione un Responsable--</option>
                     <? while($row_usuarios=$query_usuarios->ConsultaVerRegistro()) {?>
                        <option value="<? echo $row_usuarios[0]?>" <? if($row_usuarios["0"]==$Row["id_responsable_area"]) echo 'selected = "selected"'?> />
                            <? echo $row_usuarios["nombre_usuario"]." " ?>
                            <? echo $row_usuarios["apellidos_usuario"]?>
                        </option>
                      <? } ?>
                  </select>
                </label>					</td>
                </tr>
                <tr><td colspan="6">&nbsp;&nbsp;&nbsp;</tr>
                <tr>
                    <td height="27" colspan="6" align="center"><input type="submit" name="enviar" value="Guardar" class="boton"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="boton" type="reset" name="cancelar" value="Cancelar" onClick="javascript:window.history.go(-1)"></td></tr>
            </table>
        </form>	<?php
    }
}

function AreasDelete($id){
    if(empty($id)){
        echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";
    }else{

        $Query= new Consulta($sql = "DELETE FROM areas WHERE id_area='$id'");
        echo "<div id=error>Se elimino el registro Correctamente </div>";
    }
}

function AreasList(){

    $sql = "SELECT
            a.id_area,
            a.nombre_area AS Nombre,
            a.abve_nombre_area AS Abreviatura,
            CONCAT(usuarios.apellidos_usuario,' ', usuarios.nombre_usuario) AS Responsable,
            usuarios.email_usuario AS Email
            FROM
            areas AS a
            Left Join usuarios ON a.id_responsable_area = usuarios.id_usuario";

    $query = new Consulta($sql);
    echo $query->VerListado("areas.php","areas.php");

}

function AreasDetalleArea($ida){

    $sql_areas = "Select * from areas where id_area <> $ida";
    $query_areas = new Consulta($sql_areas);

?>
<form id="form_detalle_area" name="form_detalle_area" method="post" action="<? echo $_SERVER['PHP_SELF']?>?opcion=addArea&id=<?=$ida?>">
          <table width="491" height="80" border="1" align="center">
            <tr bgcolor="#6699CC">
              <td width="240"><div align="center">Nombre</div></td>
              <td width="136"><div align="center">Abreviatura</div></td>
              <td width="93"><div align="center">Activar</div></td>
            </tr>
            <?
                while($row_areas=$query_areas->ConsultaVerRegistro()) {
                $id = $row_areas["id_area"];
          ?>
            <tr>
              <td><div align="left">
                  <?=$row_areas["nombre_area"]?>
              </div></td>
              <td><div align="center">
                  <?=$row_areas["abve_nombre_area"]?>
              </div></td>
              <td width="93"><div align="center">
                <?
                    $sql_a_a = "select *
                                from areas_areas
                                where id_area_primaria = $ida
                                and id_area_secundaria = $id";
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
                  <input class="boton" type="reset" name="cancelar" value="Cancelar" onclick="javascript:window.history.go(-1)"/>
              </div></td>
            </tr>
          </table>
</form>
        <?
}

function GuardarDetalleArea($ida, $_POST){

    if(!$_POST){
        echo "<div id=error>ERROR: No se pudo Agregar las Areas por fala de datos </div>";
    }else{
        $DelQuery=new Consulta($sql="DELETE FROM areas_areas WHERE id_area_primaria=".$ida."");

        for($i=0; $i<sizeof($_POST['opcion']);$i++){
            if($_POST['opcion'][$i]){
                $Query= new Consulta($sql = "INSERT INTO areas_areas VALUES('','".$ida."' ,'".$_POST['opcion'][$i]."') ");
            }
        }
            echo "<div id=error> Se Activaron las Areas Correctamente </div>";
            Areas::AreasList();
    }

}



    function lista(){
        $sql = "SELECT
                    a.id_area,
                    a.nombre_area AS Nombre,
                    a.abve_nombre_area AS Abreviatura
                FROM
                    areas AS a";
        $query = new Consulta($sql);
        return $query->getRows();
    }
    
	
    function getIDs(){
        $sql = "
            SELECT 
                GROUP_CONCAT(id_area) 
            FROM 
                areas a ";
        $query = new Consulta($sql);
        return $query->getRow();
    }
    
}
?>
		
