<?php 

class Pagina{
	
	var $_id;
    var $_nombre;
	var $_url;
	
	function Pagina($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM paginas WHERE id_pagina = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){                
				$row = $query->VerRegistro();		
				$this->_nombre 	= $row['nombre_pagina'];
                $this->_url 	= $row['url_pagina'];
			}            
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}

    function getUrl(){
		return $this->_url;
	}
}
?>