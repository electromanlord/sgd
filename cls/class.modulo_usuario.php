<?php 
class SeccionAdmin{

	function SeccionAdminCabezera(){ ?>
		<table width="60%" style="margin:10px 0px 4px 0px">
			<tr>
				<td><div id="opciones"><a href="index.php"> INICIO </a></div></td>				 
				<td><div id="opciones"><a href="usuarios.php?opcion=list"> IR A USUARIOS</a></div></td>
			</tr>
		</table><?php 		
	}

	function SeccionAdminAdd($id, $_POST){
		if(!$_POST){
			echo "<div id=error>ERROR: No se pudo Agregar Usuario por falta de datos </div>";		
		}else{
			$DelQuery=new Consulta($sql="DELETE FROM usuarios_paginas WHERE id_usuario=".$id."");		
			for($j=0; $j<sizeof($_POST['seccion']);$j++){
				if($_POST['seccion'][$j]){
					$Query= new Consulta($sql = "INSERT INTO usuarios_paginas VALUES('".$id."' ,'".$_POST['seccion'][$j]."') "		);
				}		
			}		
				echo "<div id=error> Se Activaron las Paginas al Usuario Correctamente </div>";			
				Usuarios::UsuariosList();
		}
		
	}

	function SeccionAdminAddDetalle($_POST){
		if(!$_POST){
			echo "<div id=error>ERROR: No se pudo Agregar por falta de datos </div>";		
		}else{
			$DelQuery=new Consulta($sql="DELETE FROM acciones_deshabilitadas_usuario WHERE id_usuario=".$_POST['idu']." AND id_pagina = ".$_POST['idp']);	
						
			for($j=0; $j<sizeof($_POST['seccion']);$j++){
				if($_POST['seccion'][$j]!=""){
					$Query= new Consulta($sql = "INSERT INTO acciones_deshabilitadas_usuario VALUES('','".$_POST['idp']."','".$_POST['seccion'][$j]."' ,'".$_POST['idu']."') ");
				}		
			}		
				echo "<div id=error> Se Activaron las Paginas al Usuario Correctamente </div>";			
				Usuarios::UsuariosList();
		}
		
	}

	function SeccionAdminList($id=""){ 
		if(!$id){
			echo "<div id=error>ERROR: no se encontro ningun usuario con ese Id o le falta Id  </div>";	
		}else{
			
			$usuario = new Usuario($id);
			if($usuario->esResponsable())
				$where = "WHERE id_categoria = 1 OR id_categoria = 2";
			else
				$where = "WHERE id_categoria = 0 OR id_categoria = 2";

			
			$Query = new Consulta($sql =   "SELECT id_pagina, 
											nombre_pagina AS PAGINAS, 
											url_pagina AS URL 
											FROM paginas $where ORDER BY id_modulo,1");
	?>
								
		<form name="f1" action="" method="post">		
			<table id="reporte">
				<tr><?			
				for($i = 1; $i < $Query->NumeroCampos(); $i++){ ?>
				<td class="subtitulo"><b><?php echo $Query->nombrecampo($i)?></b></td><?php
				}	?>
				<td class="subtitulo">Activar</td>
				<td class="subtitulo">Detalle</td>
				</tr>
				<?php
				$x=0;
				while($row = mysql_fetch_row($Query->Consulta_ID)){ 
					
				?>
				<tr <?php if($x==0){ ?>class="reg1" <?php }else{ ?> class="reg2" <?php }?> > <?php
					for ($i = 1; $i < $Query->NumeroCampos(); $i++){?>
					<td align=left class="celda"><?php echo $row[$i]?></td>
					<?php }
					
						$SQL_SA   =  " 	SELECT * 
										FROM usuarios_paginas 
										WHERE id_usuario=".$id." 
										AND id_pagina=".$row[0]."";
										
						$Query_SA = mysql_query($SQL_SA);
													
						$NUM=mysql_num_rows($Query_SA);
						?>
					<td>
						<input type="checkbox" name="seccion[]" value="<?php echo $row[0]?>" <?php if($NUM==1){echo "checked";}?>>
					</td>
					<td>
					<?php 
						if($NUM==1&&($row[0]==3||$row[0]==4||$row[0]==5||$row[0]==6)) { ?>
						<a href="modulo_usuario.php?opcion=detail&id=<?=$_REQUEST["id1"]?>&id1=<?=$row[0]?>">
						  <img src="public_root/imgs/index.gif" alt="Detalle" width="16" height="16" border="0" />
						</a>
					<?php } 
						else{?>
							<img src="public_root/imgs/index.gif" alt="Detalle" width="16" height="16" border="0" />
						<? }?>
					</td>
				</tr>
				<?php
					if($x==0){$x++;}else{$x=0;} 
				}	?>
					
				<tr  bgcolor="#EEEEEE">
					<td colspan="5" align="center"  style="padding-top:20px; padding-bottom:20px" >
						<input type="submit" name="guardar" value="GUARDAR" class="boton" 
						onClick="void(document.f1.action='modulo_usuario.php?id=<? echo $id?>&opcion=add');void(document.f1.submit())"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="reset" name="cancelar" value="CANCELAR" class="boton">
					</td>
				</tr>
				</table>
			</form>	<?php
		}
	}


	function SeccionAdminDetalle($id,$idu){ 
		if(!$id){
			echo "<div id=error>ERROR: no se encontro ningun usuario con ese Id � le falta Id  </div>";	
		}else{
			$pagina = new Pagina($id);
			$usuario = new Usuario($idu);
			$SQL = "SELECT
					a.id_accion AS id,
					a.nombre_accion AS nombre
					FROM
					accion AS a
					Inner Join accion_categoria AS ac ON a.id_accion = ac.id_accion
					Inner Join categoria AS c ON c.id_categoria = ac.id_categoria
					WHERE
					c.display =  '1' AND
					c.id_pagina =  '$id'
					ORDER BY nombre";
					
			$Query = new Consulta($SQL);	
?>
			<form name="f1" action="" method="post">
				<input type="hidden" name="idu" value="<?=$idu?>">		
				<input type="hidden" name="idp" value="<?=$id?>">		
				
				<table id="reporte" style="width:50%;"> 
					<tr>
                        <td colspan="2" class="subtitulo"><?=$pagina->getNombre()." - ".$usuario->getNombreCompleto()?></td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr> 		
						<td class="subtitulo"><b>Acciones</b></td>
						<td class="subtitulo">Activar</td>
					</tr>
					<?php
					$x=0;
					while($row = $Query->ConsultaVerRegistro()){ ?>
					
					<tr <?php if($x==0){ ?>class="reg1" <?php }else{ ?> class="reg2" <?php }?> > 					
						<td align=left class="celda"><?php echo $row['nombre']?></td>
					<?php
					
						$SQL_SA  = "SELECT
									adu.id_acciones_deshabilitadas_usuario
									FROM
									acciones_deshabilitadas_usuario AS adu
									WHERE
									adu.id_usuario =  '$idu' AND
									adu.id_accion =  ".$row['id']." AND
									adu.id_pagina = '$id'";
									
						$Query_SA = mysql_query($SQL_SA);
						$NUM=mysql_num_rows($Query_SA);
						?>
					<td>
						<input type="checkbox" name="checks[]" value="<?=$row[0]?>" <?php if($NUM==0)echo "checked";?> onchange="actualiza_input(this,<?=$row[0]?>)">
						<input type="hidden" name="seccion[]" id="act<?=$row[0]?>" value="<?php if($NUM==1)echo $row[0];?>" />					</td>
				</tr><?php
						if($x==0){$x++;}else{$x=0;} 
					}	?>
					
				<tr  bgcolor="#EEEEEE">
					<td height="40" colspan="4" align="center"  style="padding-top:10px; padding-bottom:10px" >
						<input type="submit" name="guardar" value="GUARDAR" class="boton" onClick="void(document.f1.action='modulo_usuario.php?id=<?php echo $id?>&opcion=addDetail');void(document.f1.submit())"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="reset" name="cancelar" value="CANCELAR" class="boton"></td></tr>
				</table>
			</form>	<?php
		}
	}

}

?>