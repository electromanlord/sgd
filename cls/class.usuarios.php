<?php 
class Usuarios{

	function UsuariosNew(){
		
		$rol = new Rol();
		$mi_orden = $rol->getMiOrden();
			
		$sqlRol = "SELECT * 
			 	   FROM rol r				   
				   WHERE r.orden_rol >= $mi_orden
				   ORDER BY orden_rol";
				   
		$QueryRol = new Consulta($sqlRol);
				   
		$QueryArea= new Consulta(" SELECT * FROM areas ");
		$QueryAnp = new Consulta ("SELECT id_anp,nombre_anp from areaspro_dbsiganp1.anp ORDER BY 2");
		?>
        
	<form name="f1" action="" method="post">
				<table align="center" width="50%" id="mantenimiento">
					<TR>
					  <TD colspan="6" class='subtit'><div align="center">NUEVO USUARIO</div></TD>
					</TR>
					<tr>
					  <td colspan="5" align="right" class="Estilo22">&nbsp;</td>
				  </tr>
					<tr>
					  <td width="25%" align="right" class="Estilo22"><div align="left">Nombre</div></td>
				      <td width="3%" align="right" class="Estilo22"><div align="center">:</div></td>
				      <td colspan="3" align="right" class="Estilo22"><div align="left">
				        <input type="text" size="50" name="nombre" class="caja">
			          </div></td>
			      </tr>
					
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Apellidos</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50"  name="apellidos" class="caja"></td></tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">Iniciales</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
					  <td colspan="3" align="left"><input  name="iniciales" type="text" id="iniciales" size="50" class="caja"></td>
				  </tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Email </div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50"  name="email" class="caja"></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Rol</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left">
						<select name="rol" style="width:270px;" class="caja">
							<option value="">--------- Seleccione Rol --------</option><?php
							while($RowRol= $QueryRol->VerRegistro()){ ?>
								<option value="<?php echo $RowRol[0] ?>" ><?php echo $RowRol[1] ?></option><?php			
							} ?>
							</select></td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Area</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left">
						<select name="area" style="width:270px;" class="caja">
							<option value="">--------- Seleccione Area --------</option><?php
							while($RowArea= $QueryArea->VerRegistro()){ ?>
								<option value="<?php echo $RowArea[0] ?>" <?php if($RowArea[0]==$area){ echo "Selected";}?>><?php echo $RowArea[1] ?></option><?php			
							} ?>
							</select></td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">Cargo</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
					  <td colspan="3" align="left"><input  name="cargo" type="text" id="cargo" size="50" class="caja"></td>
				  </tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">ANP</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
					  <td colspan="3" align="left">
					  	<select  name="anp" type="text" id="anp" style="width:270px;" class="caja">
							<option value="">--------- Seleccione Anp --------</option><?php
							while($RowAnp= $QueryAnp->VerRegistro()){ ?>
							<option value="<?=$RowAnp[0] ?>"><?php echo $RowAnp[1] ?></option><?php			
							} ?>
							</select>
						</td>
				  </tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Usuario</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50" id="usuario"  name="usuario" class="caja">
						&nbsp;<a href="#" onClick="checkName(usuario)" title="Ver Disponibilidad de usuario" style="text-decoration:none">Disponible</a>
						<div id="result"></div></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Password</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50"  name="password" class="caja"/></td></tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">Lectura</div></td>
					  <td align="right"><div align="center"></div></td>
						<td width="10%" align="left"><input type="checkbox" name="lectura" value="SI" ></td>
					  	<td width="28%" align="right" class="Estilo22">Escritura :</td>
					  	<td width="30%" align="left"><input type="checkbox" name="escritura" value="SI"></td>
					</tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					<tr>
						<td colspan="6" align="center"><input class="boton" type="submit" name="enviar2" value="Guardar" onclick="return  validar_usuarios('add')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input class="boton"  type="reset" name="cancelar" value="Cancelar" onClick="javascript:window.history.go(-1)"></td>
				  </tr>
				</table>
</form><?php
		
	}

	function UsuariosAdd(){
		if(!$_POST){
			echo "<div id=error>ERROR: No se pudo Agregar Usuario por falta de datos </div>";		
		}else{
			if(!$_POST['lectura']){$_POST['lectura']="NO";}
			if(!$_POST['escritura']){$_POST['escritura']="NO";}
			
			$sq=new Consulta("SELECT * FROM usuarios WHERE nombre_usuario='".$_POST['nombre']."' AND apellidos_usuario='".$_POST['apellidos']."' AND email_usuario='".$_POST['email']."' AND estado_usuario = 1");
			
			$sq_bu=new Consulta("SELECT * FROM usuarios WHERE login_usuario='".$_POST['usuario']."' AND estado_usuario = 1");			
			if($sq->NumeroRegistros()==0){
				$sql = "INSERT INTO usuarios 
				VALUES( '',
				'".$_POST['rol']."',
				'".$_POST['area']."',
				'".$_POST['nombre']."' ,
				'".$_POST['apellidos']."',
            	'".$_POST['iniciales']."',
            	'".$_POST['cargo']."',
				'".$_POST['email']."',
				'".$_POST['usuario']."',
				'".$_POST['password']."',
				'".date('Y-m-d')."',
				'".$_POST['lectura']."',
				'".$_POST['escritura']."',
				'".$_POST['anp']."',
				'1') ";
				$Query = new Consulta($sql);
				$nuevo_usu = $Query->NuevoId();
				
				if($Query->RespuestaConsulta()){
					$sql = "INSERT INTO arch_usuarios
							(id_usuario,id_estado_usuario)
							VALUES ('".$nuevo_usu."','1')";
					$Query = new Consulta($sql);
				}
				
				if($_POST['rol'] == 6||$_POST['rol'] == 4){
					$sql_r = "INSERT into usuarios_paginas
							  VALUES ('".$nuevo_usu."','7')";
					$query_r = new Consulta($sql_r);
				}
							
				echo "<div id=error> Se Ingreso el Nuevo Usuario Correctamente </div>";			
			}else if($sq_bu->NumeroRegistros()){?>
				<script>
					alert(" El usuario ya existe, por favor ingrese otro nombre de usuario ");
					location.replace("usuarios.php?opcion=new")	
				</script>
				<?php					
			}else{
				echo "<div id=error> ERROR: no se puedo ingresar el usuario </div>";
							
			}			
		}
		
	}

	function UsuariosUpdate($id, $_POST){
		if(empty($id)){
			echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";	
		}else if(!$_POST){
			echo "<div id=error>La actualizacion no se puede efectuar por que no pasaron los datos </div>";	
		}else{
			
			if(!$_POST['lectura']){$_POST['lectura']="NO";}
			if(!$_POST['escritura']){$_POST['escritura']="NO";}
			
			$Query = new Consulta( 	 " UPDATE usuarios
										SET nombre_usuario='".$_POST['nombre']."' ,
											apellidos_usuario='".$_POST['apellidos']."',
                                            iniciales_usuario='".$_POST['iniciales']."',
                                            cargo_usuario='".$_POST['cargo']."',
											email_usuario='".$_POST['email']."',
											id_rol='".$_POST['rol']."',
											id_area='".$_POST['area']."',
											id_anp='".$_POST['anp']."',
											login_usuario='".$_POST['usuario']."',
											password_usuario='".$_POST['password']."',
											lectura_usuario='".$_POST['lectura']."',
											escritura_usuario='".$_POST['escritura']."'
									    WHERE id_usuario='".$id."'");
			echo  " UPDATE usuarios
										SET nombre_usuario='".$_POST['nombre']."' ,
											apellidos_usuario='".$_POST['apellidos']."',
                                            iniciales_usuario='".$_POST['iniciales']."',
                                            cargo_usuario='".$_POST['cargo']."',
											email_usuario='".$_POST['email']."',
											id_rol='".$_POST['rol']."',
											id_area='".$_POST['area']."',
											login_usuario='".$_POST['usuario']."',
											password_usuario='".$_POST['password']."',
											lectura_usuario='".$_POST['lectura']."',
											escritura_usuario='".$_POST['escritura']."'
									    WHERE id_usuario='".$id."'";
			
			if($_POST['rol'] == 6||$_POST['rol'] == 4){
				$sql_r = "INSERT into usuarios_paginas
						  VALUES ('".$nuevo_usu."','7')";
				$query_r = new Consulta($sql_r);
			}							
																	
			echo "<div id=error>La actualizacion se realizo Correctamente </div>";	
		}
	}

	function UsuariosEdit($id){ 
		if(!$id){
			echo "<div id=error>ERROR: no se encontro ningun usuario con ese Id � le falta Id  </div>";	
		}else{
			$rol = new Rol();
			$mi_orden = $rol->getMiOrden();
			
			$queryRol = "SELECT * 
						 FROM rol r
						 ORDER BY orden_rol
						 WHERE r.orden_rol >= $mi_orden";		
					
			$Query	= new Consulta(" SELECT * FROM usuarios WHERE id_usuario='".$id."'");
			$Row	= $Query->VerRegistro();
			$QueryRol= new Consulta(" SELECT * FROM rol ORDER BY orden_rol");
			$QueryArea= new Consulta(" SELECT * FROM areas ");
			$QueryAnp = new Consulta ("SELECT id_anp,nombre_anp from areaspro_dbsiganp1.anp ORDER BY 2");				
			$rol	=	$Row['id_rol'];			
			$area	=	$Row['id_area']; 
			$anp	=	$Row['id_anp'];
			?>
			<form name="f1" action="" method="post">
				<table width="50%" align="center" id="mantenimiento">
					<TR>
						<TD colspan="6" class='subtit'><div align="center">EDITAR DATOS DE USUARIO</div></TD></TR>
					<tr>
					  <td colspan="5" align="right">&nbsp;</td>
				  </tr>
					<tr>
					  <td width="25%" align="right" class="Estilo22"><div align="left">Nombre</div></td>
					  <td width="3%" align="right" class="Estilo22"><div align="center">:</div></td>
					  <td colspan="3" align="left"><input type="text" size="50" name="nombre" value="<?php echo $Row['nombre_usuario']?>" class="caja"/></td>
				  </tr>
					
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Apellidos</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50"  name="apellidos" value="<?php echo $Row['apellidos_usuario']?>" class="caja"/></td></tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">Iniciales</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
					  <td colspan="3" align="left"><input  name="iniciales" type="text" id="iniciales" value="<?php echo $Row['iniciales_usuario']?>" size="50" class="caja"/></td>
				  </tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Email</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left">
							<input type="text" size="50"  name="email" value="<?php echo $Row['email_usuario']?>" class="caja"/>
						</td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Rol</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left">
						<select name="rol" style="width:270px;" class="caja">
							<option value="">--------- Seleccione Rol --------</option><?php
							while($RowRol = $QueryRol->VerRegistro()){ ?>
								<option value="<?php echo $RowRol[0] ?>" <?php if($RowRol[0] == $rol){ echo "Selected";}?>><?php echo $RowRol[1];?></option><?php			
							}	?>		
							</select></td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Area</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left">
							<select name="area"style="width:270px;" class="caja">
							<option value="">--------- Seleccione Area --------</option><?php
							while($RowArea = $QueryArea->VerRegistro()){ ?>
								<option value="<?php echo $RowArea[0] ?>" <?php if($RowArea[0] == $area){ echo "Selected";}?>><?php echo $RowArea[1];?></option><?php			
							}	?>		
							</select>
						</td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">Cargo</div></td>
					  <td align="right" class="Estilo22" ><div align="center">:</div></td>
					  <td colspan="3" align="left">
					  	<input  name="cargo" type="text" id="cargo" value="<?php echo $Row['cargo_usuario']?>" size="50" />
					  </td>
				  </tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">ANP</div></td>
					  <td align="right" class="Estilo22" ><div align="center">:</div></td>
					  <td colspan="3" align="left">
					  <select  name="anp" type="text" id="anp" style="width:270px;" class="caja">
							<option value="">--------- Seleccione Anp --------</option><?php
							$sel = "";
							while($RowAnp= $QueryAnp->VerRegistro()){ 
								if($RowAnp[0] == $anp)
									$sel = "selected='selected'";
								else
									$sel = "";
							?>
							<option value="<?=$RowAnp[0] ?>" <?=$sel?>><?php echo $RowAnp[1] ?></option><?php			
							} ?>
					  </select>
					  </td>
				  </tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Usuario</div></td>
					  <td align="right" class="Estilo22" ><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50"  name="usuario" value="<?php echo $Row['login_usuario']?>" class="caja"></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Password</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="50"  name="password" value="<?php echo $Row['password_usuario']?>" class="caja"></td></tr>
					<tr>
					  <td  align="right" class="Estilo22"><div align="left">Lectura</div></td>
					  <td  align="right">&nbsp;</td>
						<td width="8%" align="left"><input type="checkbox" name="lectura" value="SI" <?php if($Row['lectura_usuario']=="SI"){  echo "checked";} ?> />                    
					  <td width="20%" align="right" class="Estilo22">Escritura </td>                      
					  <td width="37%" align="left"><input type="checkbox" name="escritura" value="SI"  <?php if($Row['escritura_usuario']=="SI"){  echo "checked";} ?>/></td>                      
					</tr>
					<tr><td colspan="5">&nbsp;&nbsp;&nbsp;</tr>
					<tr>
						<td colspan="6" align="center"><input class="boton" type="submit" name="enviar2" value="GUARDAR" onclick="return  validar_usuarios('update', <?php echo $id?>)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input class="boton" type="reset" name="cancelar" value="CANCELAR" onClick="javascript:window.history.go(-1)"></td></tr>
				</table>
			</form>	<?php
		}
	}

	function UsuariosDelete($id){
		if(empty($id)){
			echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";	
		}else{		
			
			$Query= new Consulta($sql = "UPDATE arch_usuarios SET id_estado_usuario = 0 WHERE id_usuario='$id'");
			$Query= new Consulta($sql = "UPDATE usuarios SET estado_usuario = 0 WHERE id_usuario='$id'");
			echo "<div id=error>Se elimino el registro Correctamente </div>";
		}
	}

	function UsuariosList(){
		$rol = new Rol();
		$mi_rol = $rol->getMiRol();
		if($mi_rol == 4)
			$where = "";
		elseif($mi_rol == 6)
			$where = "AND id_anp = '".$_SESSION['session'][7]."'";
			
		$sql = "SELECT
                u.id_usuario,
                CONCAT(u.apellidos_usuario,' ',u.nombre_usuario) AS Usuario,
                u.email_usuario AS Email,
                r.nombre_rol AS Rol,
                a.abve_nombre_area AS Area,
                u.lectura_usuario AS Lectura,
                u.escritura_usuario AS Escritura
                FROM
                usuarios AS u
                LEFT Join areas AS a ON a.id_area = u.id_area
                LEFT Join rol AS r ON u.id_rol = r.id_rol
					 WHERE 
					 estado_usuario = 1
					$where
                ORDER BY
                a.abve_nombre_area ASC,
                r.nombre_rol ASC,
                u.apellidos_usuario ASC";
        
		$query = new Consulta($sql);			
		echo $query->VerListado("usuarios.php","modulo_usuario.php"); 
	}	
    
	function Lista(){
		$rol = new Rol();
		$mi_rol = $rol->getMiRol();
		if($mi_rol == 4)
			$where = "";
		elseif($mi_rol == 6)
			$where = "AND id_anp = '".$_SESSION['session'][7]."'";
			
		$sql = "SELECT
                u.id_usuario,
                CONCAT(u.apellidos_usuario,' ',u.nombre_usuario) AS Usuario,
                u.email_usuario AS Email,
                r.nombre_rol AS Rol,
                a.abve_nombre_area AS Area,
                u.lectura_usuario AS Lectura,
                u.escritura_usuario AS Escritura
                FROM
                usuarios AS u
                LEFT Join areas AS a ON a.id_area = u.id_area
                LEFT Join rol AS r ON u.id_rol = r.id_rol
                ORDER BY
                a.abve_nombre_area ASC,
                r.nombre_rol ASC,
                u.apellidos_usuario ASC";
        
		$query = new Consulta($sql);			
	}	
}


?>