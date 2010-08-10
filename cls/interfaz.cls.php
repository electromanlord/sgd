<? 
class Interfaz{
	function InterfazMenu($id_modulo, $id_usuario){
		$submodulos=Validar::ValidarListarSubmodulos($id_modulo, $id_usuario);	
		if(is_array($submodulos)){	
			for($i=0; $i<sizeof($submodulos); $i++){ 
			if ($id_modulo==5 && $submodulos[$i]['submodulo']=="Transferencias"){
				return false;
			}
			
			?>
			<tr align=left height="25"  >
			<td bgcolor='lavender' onMouseOver="this.style.background='#CCFF33';" onMouseOut="this.style.background='lavender'">
			<a href="<?=$submodulos[$i]['url']?>?lectura=<?=$submodulos[$i]['lectura']?>&amp;escritura=<?=$submodulos[$i]['escritura']?>&pag=1" target='b'>
			<img src="../imgs/s_process.png" border=0>&nbsp;<?=$submodulos[$i]['submodulo']?></a></td>
			</tr>
			<?
								
			}
		}	
				
	}	
}

?>