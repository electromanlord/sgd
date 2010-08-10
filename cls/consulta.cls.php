<?
class Consulta {
	
		
	var $Consulta_ID = 0;
	var $Errno = 0;
	var $Error = "";
	var $SQL = "";
 
	function Consulta($sql = "" ){
		if ($sql == "") {
			$this->Error = "No ha especificado una consulta SQL";
			$this->Errno =  mysql_errno();
			return false;
		}
		$this->Consulta_ID = mysql_query($sql) or die("<div id='error'>".mysql_error()."<br><br> ".$sql."<div>");
		$this->SQL = $sql;
        if(!$this->Consulta_ID){
			$this->Errno = mysql_errno();
			$this->Error = mysql_error();					
		}
        
        return $this->Consulta_ID;
        
	} 
	function NumeroCampos(){
		return mysql_num_fields($this->Consulta_ID);
	}
	
	function NuevoId() {
        return mysql_insert_id();
	}
	
	function Nombretabla(){
		return mysql_field_table($this->Consulta_ID, 'name');
	}
	
	function flagscampo($numcampo){
		return mysql_field_flags($this->Consulta_ID, $numcampo);
	}
	
	function NumeroRegistros(){
		return mysql_num_rows($this->Consulta_ID);
	}
	
	
	function nombrecampo($numcampo){
		return mysql_field_name($this->Consulta_ID, $numcampo);
	}
	
	function tipocampo($numcampo){
		return mysql_field_type($this->Consulta_ID, $numcampo);
	}
	
	function tamaniocampo($numcampo){
		return mysql_field_len($this->Consulta_ID, $numcampo);
	}
	
	function VerRegistro(){
		return mysql_fetch_array($this->Consulta_ID);
	}
	function ConsultaVerRegistro(){
		return mysql_fetch_array($this->Consulta_ID);
	}
	
	function VerListado($url="", $sub_url=""){
		$return="";
		$colspan=$this->NumeroCampos();
		$return.= "<table border=0  id='reporte' align='center' cellpading='1' cellspacing='1' >\n";	
		$return.= "<tr>";
		$tab=substr($this->nombrecampo(0),3,30);
		for ($i = 1; $i < $this->NumeroCampos(); $i++){
			$name = str_replace($tab,"",$this->nombrecampo($i));
			$name = str_replace("id","",$name);
			$name = str_replace("_"," ",$name);			
			$return.= "<td class=subtitulo><b>".$name."</b></td>\n";
		}
		$return.= "<td class='subtitulo' align='center' width='80'>Opciones</td></tr>\n";
		$x=0;
		while ($row = mysql_fetch_row($this->Consulta_ID)) {
			$id=$row[0];
			$id1=$row[1];	
			$return.= "<tr "; if($x==0){ $return.= "class=reg1";}else{ $return.= "class=reg2";} $return.= "> \n";
			for ($i = 1; $i < $this->NumeroCampos(); $i++){
				$return.= "<td align=left class=celda>".substr($row[$i],0,50)."</td>\n";
			}
			$return	.= "<td align='center'>
					<a href='#' onClick=mantenimiento('".$url."',".$id.",'edit') title=Editar >
					<img src='public_root/imgs/button_edit.png' border='0' ></a> &nbsp; 
					<a href='#' onClick=mantenimiento('".$url."',".$id.",'delete') title=Eliminar>
					<img src='public_root/imgs/button_drop.png' border='0' ></a>&nbsp;";
					if(!empty($sub_url)){
						if($sub_url == "areas.php"){
						$return .=" <a href='".$sub_url."?opcion=detailArea&id=".$id."' title='Detalle de Areas'>
									<img src='public_root/imgs/index.gif' border='0' ></a>";
						}
						elseif($sub_url=="acciones.php"){
                        $return .=" <a href='".$sub_url."?opcion=detailAccion&id=".$id."' title='Detalle de Acciones'>
									<img src='public_root/imgs/index.gif' border='0' ></a>";
                        }else{
						$return .=" <a href='".$sub_url."?opcion=list&id1=".$id."' title='Detalle'>
									<img src='public_root/imgs/index.gif' border='0' ></a>";
						}
					}					
			$return .="</td>
					</tr>";			
			if($x==0){$x++;}else{$x=0;}
		}
		$return.= '</table>';
		echo $return;
	}
	
	
	function ConsultaVerListadoQ($url="",$url_1="",$url_2="",$url_3="",$url_4="") {
		$colspan=$this->numcampos();
		echo "<table border=0 align='center' bgcolor='#FFFFFF'  id=listado >\n";	
		echo "<tr>";
		for ($i = 1; $i < $this->numcampos(); $i++){
			echo "<td class=subtitulo><b>".str_replace("_"," ",$this->nombrecampo($i))."</b></td>\n";
		}
		echo "<td class=subtitulo>Opciones</td></tr>\n";
		$x=0;
		while ($row = mysql_fetch_row($this->Consulta_ID)) {
			$id=$row[0];	
			echo "<tr "; if($x==0){ echo "class=reg1";}else{ echo "class=reg2";} echo "> \n";
			for ($i = 1; $i < $this->numcampos(); $i++){
				echo "<td align=left class=celda>".$row[$i]."</td>\n";
			}
			echo "<td>"; 
			if($_SESSION['acceso']['escritura']=="S" ){  
				echo"<a href=# onClick=mantenimiento('".$url."',".$id.",'edit') title=Editar ><img src='/selpo/imgs/b_edit.png' border='0' /></a> 
				<a href='#' onClick= mantenimiento('".$url."',".$id.",'delete') title=Eliminar><img src='../imgs/b_drop.png' border='0' /></a>";
				if(!empty($url_1)){
					echo"<a href=# onClick=mantenimiento('".$url_1."',".$id.",'list') title='Dar Permiso para Modulos'><img src='/selpo/imgs/s_rights.png' border='0' /></a>";
				}
				if(!empty($url_2)){
					echo" <a href=# onClick=mantenimiento('".$url_2."',".$id.",'list') title='Dar Permiso para Quinquenios'><img src='/selpo/imgs/s_passwd.png' border='0' /></a>";
				}
				if(!empty($url_3)){
					echo" <a href=# onClick=mantenimiento('".$url_3."',".$id.",'list') title='Dar Permiso para ANP'><img src='/selpo/imgs/b_usrlist.png' border='0' /></a>";
				}
				if(!empty($url_4)){
					echo" <a href=# onClick=mantenimiento('".$url_4."',".$id.",'list') title='Dar Permiso para Fuentes'><img src='/selpo/imgs/dinero.gif' border='0'  height='16' width='16'/></a>";
				}									
			} 
			echo "</td></tr>";			
			if($x==0){$x++;}else{$x=0;}
		}
		echo '</table>';
	}
	
function VerListadoCategoria($url="", $id1) {
		$colspan=$this->numcampos();
		echo "<table border=0  id=reporte >\n";	
		echo "<tr>";
		for ($i = 1; $i < $this->numcampos(); $i++){
			echo "<td class=subtitulo><b>".$this->nombrecampo($i)."</b></td>\n";
		}
		echo "<td class=subtitulo>Opciones</td></tr>\n";
		$x=0;
		while ($row = mysql_fetch_row($this->Consulta_ID)) {
			$id=$row[0];			
			echo "<tr "; if($x==0){ echo "class=reg1";}else{ echo "class=reg2";} echo "> \n";
			for ($i = 1; $i < $this->numcampos(); $i++){
				echo "<td align=left class=celda>".$row[$i]."</td>\n";
			}
			echo "<td>"; 
			if($escritura=="S" ){
				echo"<div id=opciones>
				<a href='#' onClick=mantenimiento_categoria('".$url."',".$id.",'edit','".$id1."')   title=Editar ><img src='/selpo/imgs/b_edit.png' /></a> 
				<a href='#' onClick=mantenimiento_categoria('".$url."',".$id.",'delete','".$id1."') title=Eliminar>X</a>";
				} 
				if(!empty($url_det)){
					echo" <a href=# onClick=mantenimiento_det('".$url_det."',".$id.") title='Ver Detalle'>D</a></div>";
				}
			echo "</td></tr>";
			
			if($x==0){$x++;}else{$x=0;}
		}
		echo '</table>';
	}	
	
	function ConsultaVerLinks($url="") {
		$colspan=$this->numcampos();
		echo "<table border=0 align='center' bgcolor='#FFFFFF'  id=listado >\n";	
		echo "<tr>";
		for ($i = 1; $i < $this->numcampos(); $i++){
			echo "<td class=subtitulo><b>".str_replace("_"," ",$this->nombrecampo($i))."</b></td>\n";
		}
		echo "<td class=subtitulo>Opcion</td></tr>\n";
		$x=0;
		$class="";
		while ($row = mysql_fetch_row($this->Consulta_ID)) {
			$id=$row[0];			
			if($x==0){ $class="class=reg1"; $color="#F4F4F4";}else{ $class="class=reg2"; $color="#DADADA";}	
			echo "<tr ".$class."  onMouseOver=this.style.background='#CCFF33' onMouseOut=this.style.background='".$color."' > \n";
			for ($i = 1; $i < $this->numcampos(); $i++){
				echo "<td align=left class=celda>".$row[$i]."</td>\n";
			}
			echo "<td>"; 
			//if($_SESSION['acceso']['escritura']=="S" ){  
				echo"<a href='".$url."?ids=".$id."' title='Seleccionar'> <img src='/selpo/imgs/b_primary.png' border='0' /> </a> ";												
			//} 
			echo "</td></tr>";			
			if($x==0){$x++;}else{$x=0;}
		}
		echo '</table>';
	}

    function RespuestaConsulta(){
        return $this->Consulta_ID;
    }

    function getRows(){
        $rows = array();
        while ( $row = mysql_fetch_object($this->Consulta_ID) ) {
            $rows[] = $row;
        }
        return $rows; 
    }

    function getRow(){
        $row =  mysql_fetch_row($this->Consulta_ID) ;
        return $row[0]; 
    }
}
?>