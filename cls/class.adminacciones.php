<?
class AdminAcciones{

function AccionesNew(){				 	
?>
	<form name="form_nueva_accion" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=add" method="post">
		<table align="center" width="50%" height="205" id="mantenimiento">
			<tr>
				<td height="21" colspan="5" valign="top" class="subtit"><div align="center">NUEVA ACCION </div></TD>
			</tr>
			<tr>
			  <td height="24" align="right" class="Estilo21">&nbsp;</td>
			  <td align="right" class="Estilo22">&nbsp;</td>
			  <td align="right" class="Estilo22">&nbsp;</td>
			  <td colspan="2" align="left">&nbsp;</td>
		  </tr>
			<tr>
				<td width="6%" height="24" align="right" class="Estilo21"><div align="center">(*)</div></td>
				<td width="26%" class="Estilo22"><div align="left">Nombre </div></td>
				<td width="2%" class="Estilo22"><div align="center">:</div></td>
				<td colspan="2">
					<div align="left">
					  <input name="txtnombre" type="text" id="txtnombre" size="40" class="caja"/>				
				  </div></td>
			</tr>
			
		    <tr>
		      <td height="24" align="right" class="Estilo21">&nbsp;</td>
		      <td class="Estilo22"><div align="left">Abreviatura</div></td>
		      <td class="Estilo22"><div align="center">:</div></td>
		      <td colspan="2"><div align="left">
		        <input name="abreviatura" type="text" id="abreviatura" class="caja"/>
	          </div></td>
	      </tr>
	      <tr>
			<td height="24" align="right" class="Estilo21">&nbsp;</td>
			<td class="Estilo22"><div align="left">Descripcion</div></td>
			<td class="Estilo22"><div align="center">:</div></td>
			<td colspan="2" align="left">
			  <div align="left">
			    <input name="descripcion" type="text" id="descripcion" size="40" class="caja"/>
	          </div></td>
		</tr>
		  <tr>
		    <td height="21" align="center">&nbsp;</td>
	        <td height="21" class="Estilo22"><div align="left">Activo</div></td>
	        <td height="21" class="Estilo22"><div align="center">:</div></td>
	        <td height="21" colspan="2" align="center">
	          <div align="left">
	            <input name="activo" type="checkbox" id="activo" value="1" checked="checked" />
              </div>	        </td>
          </tr>
		  <tr>
			<td height="21" colspan="5" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td height="26" align="center">&nbsp;</td>
		    <td height="26" align="center">&nbsp;</td>
		    <td height="26" align="center">&nbsp;</td>
		    <td width="22%" height="26" align="center"><input type="submit" name="enviar2" value="Guardar" class="boton"/></td>
		    <td width="44%" align="center"><input class="boton" type="reset" name="cancelar2" value="Cancelar" onclick="javascript:window.history.go(-1)" /></td>
		</tr>
	  </table>
	</form>
<?php
		
	}

function AccionesAdd(){
    if(!$_POST){
        echo "<div id=error>ERROR: No se pudo Agregar la Accion por falta de datos </div>";
    }else{

        $sq=new Consulta("SELECT * FROM accion WHERE nombre_accion='".$_POST['txtnombre']."'");

        if($_POST['activo']==1){
            $act = 1;
        }else{
            $act = 0;
        }

        if($sq->NumeroRegistros()==0){
            
                $sql = "INSERT INTO accion
                VALUES( '',
                '".$_POST['txtnombre']."',
                '".$_POST['abreviatura']."',
                '".$_POST['descripcion']."',
                '".$act."')";

            $Query= new Consulta($sql);
            echo "<div id=error> Se Ingreso la Nuevo Accion Correctamente </div>";

        }else{?>
            <script>
                alert(" La accion ya existe, por favor ingrese otro accion ");
                location.replace("acciones.php?opcion=new")
            </script>
        <?php
        }
    }
		
}

function AccionesUpdate($id, $_POST){
    if(empty($id)){
        echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";
    }else if(!$_POST){
        echo "<div id=error>La actualizacion no se puede efectuar por que no pasaron los datos </div>";
    }else{

        if($_POST['activo']==1){
            $act = 1;
        }else{
            $act = 0;
        }

        $Query = new Consulta( 	 " UPDATE accion
                                   SET nombre_accion='".$_POST['txtnombre']."' ,
                                       abreviatura_accion='".$_POST['abreviatura']."',
                                       descripcion_accion='".$_POST['descripcion']."',
                                       estado_accion = $act
                                   WHERE id_accion='".$id."'");

        echo "<div id=error>La actualizacion se realizo Correctamente </div>";
    }
}

function AccionesEdit($id){ 
    if(!$id){
        echo "<div id=error>ERROR: no se encontro ningun area con ese Id ? le falta Id  </div>";
    }else{
        $acc = new Accion($id);
        $activ = ($acc->getEstado()==1)?"checked='checked'":"";        
    ?>
        <form name="form_nueva_accion" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>" method="post">
            <table width="382" align="center" id="mantenimiento">
                <TR>
                    <TD colspan="5" valign="top" class='subtit'><div align="center">EDITAR DATOS DE ACCION </div></TD>
                </TR>
                <TR>
                  <TD colspan="5" valign="top">&nbsp;</TD>
                </TR>
                
                <tr>
                  <td width="18" align="right" class="Estilo21">(*)</td>
                  <td width="94" align="right" class="Estilo22"><div align="left">Nombre</div></td>
                  <td width="4" align="right"><div align="left">  :</div></td>
                  <td colspan="2" align="left"><div align="left">
                    <input name="txtnombre" type="text" id="txtnombre" value="<?=$acc->getNombre()?>" size="40" class="caja">
                  </div></td>
                </tr>
                
                <tr>
                  <td align="right">&nbsp;</td>
                    <td class="Estilo22"><div align="left">Abreviatura</div></td>
                    <td class="Estilo22"><div align="left">:</div></td>
                <td colspan="2" align="left"><div align="left">
                  <input name="abreviatura" type="text" id="abreviatura" value="<?=$acc->getAbreviatura()?>" class="caja"/>
                </div></td>
                </tr>
                <tr>
                  <td>                
                  <td class="Estilo22"><div align="left">Descripcion                  </div>
                  <td class="Estilo22"><div align="left">:</div>                  
                  <td colspan="2"><div align="left">
                    <input name="descripcion" type="text" id="descripcion" size="40" value="<?=$acc->getDescripcion()?>" class="caja"/>
                  </div>                                    </tr>
                <tr>
                  <td>                                                
                  <td class="Estilo22"><div align="left">Activo                  </div>
                  <td class="Estilo22"><div align="left">:</div>                  
                  <td colspan="2"><div align="left">
                    <input name="activo" type="checkbox" id="activo" value="1" <?=$activ?>/>
                  </div>                                    </tr>
                
                <tr><td>&nbsp;&nbsp;&nbsp;                
                  <td>                  
                  <td>                  
                  <td colspan="2">                                                                        </tr>
                <tr>
                    <td height="27" align="center">&nbsp;</td>
                    <td height="27" align="center">&nbsp;</td>
                    <td height="27" align="center">&nbsp;</td>
                    <td width="79" height="27" align="center"><input type="submit" name="enviar" value="Guardar" class="boton"/></td>
                    <td width="163" align="center"><input class="boton" type="reset" name="cancelar3" value="Cancelar" onclick="javascript:window.history.go(-1)" /></td>
                </tr>
            </table>
        </form>	<?php
    }
}

function AccionesDelete($id){
    if(empty($id)){
        echo "<div id=error>La eliminacion no se puede efectuar por falta de Id </div>";
    }else{

        $Query= new Consulta($sql = "UPDATE accion SET estado_accion = 0 WHERE id_accion='$id'");
        echo "<div id=error>Se elimino el registro Correctamente </div>";
    }
}

function AccionesList(){

    $sql = "SELECT
            a.id_accion AS id,
            a.nombre_accion AS Nombre,
            a.abreviatura_accion AS Abreviatura,
            a.descripcion_accion AS Descripcion,
            CASE a.estado_accion
            WHEN 1 THEN 'Activo'
            ELSE 'No Activo'
            END AS Estado
            FROM
            accion AS a
			ORDER BY Estado,Nombre";

    $query = new Consulta($sql);
    echo $query->VerListado("acciones.php","acciones.php");

}

function AccionesDetalle($ida){

    $sql_areas = "Select * from categoria where display = 1 order by descripcion";
    $query_areas = new Consulta($sql_areas);

?>
<form id="form_detalle_accion" name="form_detalle_accion" method="post" action="<? echo $_SERVER['PHP_SELF']?>?opcion=addDetailAccion&id=<?=$ida?>">
          <table width="55%" height="80" border="1" align="center">
            <tr bgcolor="#6699CC">
              <td width="90%"><div align="center">Nombre Categoria </div></td>
              <td><div align="center">Activar</div></td>
            </tr>
            <?
                while($row_areas=$query_areas->ConsultaVerRegistro()) {
                $id = $row_areas["id_categoria"];
          ?>
            <tr>
              <td><div align="left">
                  <?=$row_areas["descripcion"]?>
              </div></td>
              <td width="93"><div align="center">
                <?
                    $sql_a_a = "select *
                                from accion_categoria
                                where id_accion = $ida
                                and id_categoria = $id";
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
              <td height="23" colspan="3"><div align="center">
                  <input type="submit" name="guardar" value="Guardar" class="boton" />
                  <input class="boton" type="reset" name="cancelar" value="Cancelar" onclick="javascript:window.history.go(-1)"/>
              </div></td>
            </tr>
          </table>
</form>
        <?
}

function GuardarDetalleAccion($ida, $_POST){

    if(!$_POST){
        echo "<div id=error>ERROR: No se pudo Agregar las Acciones por fala de datos </div>";
    }else{
        $DelQuery=new Consulta($sql="DELETE FROM accion_categoria WHERE id_accion=".$ida."");

        for($i=0; $i<sizeof($_POST['opcion']);$i++){
            if($_POST['opcion'][$i]){
                $Query= new Consulta($sql = "INSERT INTO accion_categoria VALUES('','".$ida."' ,'".$_POST['opcion'][$i]."') ");
            }
        }
            echo "<div id=error> Se Activaron las Acciones Correctamente </div>";
            AdminAcciones::AccionesList();
    }

}
	
}
?>
		
