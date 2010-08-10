<?
class Remitentes{


function RemitentesAdd($nom_remi,$abrev,$tipo_remi){

	$sql_re="Insert Into remitentes Values('','".$tipo_remi."','".$nom_remi."','".$abrev."','','1')";
	$q_remite=new Consulta($sql_re);

	return 	$q_remite->NuevoId();

}

function RemitentesEdit($id){

	$sql_editremi = "SELECT
					remitentes.`id_remitente`,
					remitentes.`nombre_remitente`,
					remitentes.`abreviatura_remitente`,
					remitentes.`id_tipo_remitente`
					FROM
					remitentes
					WHERE remitentes.id_remitente='".$id."'";

	$editremi = new Consulta($sql_editremi);
	$rowe = $editremi->ConsultaVerRegistro();
	$tipo_remi=$rowe['id_tipo_remitente'];

?>

<form id="f42" name="f42" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=update&id=<?=$id?>">

  <table width="348" border="0" align="center" id="mantenimiento">
    <tr>
      <td colspan="3" class="Estilo22"><div align="center" class='subtit'>EDITAR DATOS DE REMITENTE </div></td>
    </tr>
    <tr>
      <td colspan="3" class="Estilo22">&nbsp;</td>
    </tr>
    <tr>
      <td width="153" class="Estilo22"><div align="left">Codigo</div></td>
      <td width="14" class="Estilo22"><div align="left">:</div></td>
      <td width="207"><div align="left">
        <input name="codigo" type="text" value="<?=$rowe[0]?>" size="29" readonly="readonly"/>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Nombre de Remitente</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <td><div align="left">
        <input name="nom_remi" type="text" value="<?=$rowe[1]?>" size="29"/>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Abreviatura</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <td><div align="left">
        <input name="abrev" type="text" value="<?=$rowe[2]?>" size="15"/>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Tipo de Remitente</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <?php
	  $remitente="SELECT tr.id_tipo_remitente, tr.tipo_remitente_nombre FROM tipo_remitente AS tr ";
	  $Newremi=new Consulta($remitente);
	  ?>
      <td> <div align="left">
        <select name="tipo_remi">
           <option value="">---Tipo de Remitente---</option>
          
          <?
        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>
          <option value="<?=$row_tremi[id_tipo_remitente]?>"<? if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>>
            <?=$row_tremi[tipo_remitente_nombre]?>
                </option> 
          <?  } ?>
        </select>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">
        <input name="Actualizar2" type="submit" value="Actualizar" class="boton"/>
      </div></td>
    </tr>
  </table>
</form>

<?
}

function RemitentesUpdate($id){

	$nom_remi=$_POST["nom_remi"];
	$abrev=$_POST["abrev"];
	$tipo_remi=$_POST["tipo_remi"];
	$act_remi=" UPDATE remitentes set
				remitentes.`nombre_remitente`='".$nom_remi."',
				remitentes.`id_tipo_remitente`='".$tipo_remi."',
				remitentes.`abreviatura_remitente`='".$abrev."'
				where remitentes.`id_remitente`='".$id."'";
	
	$Uremi=new Consulta($act_remi);
}

function RemitentesNew(){?>

<form id="f41" name="f41" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=add">
  <table width="348" border="0" align="center" id="mantenimiento">
    <tr>
      <td colspan="3"><div align="center" class='subtit'> NUEVO REMITENTE </div></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="155" class="Estilo22"><div align="left">Nombre de Remitente</div></td>
      <td width="14" class="Estilo22"><div align="left">:</div></td>
      <td width="189"><div align="left">
        <input name="nom_remi" type="text" size="29"/>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Abreviatura</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <td><div align="left">
        <input name="abrev" type="text" size="29"/>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Tipo de Remitente</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <?php
		  $remitente = "SELECT
						tr.id_tipo_remitente,
						tr.tipo_remitente_nombre
						FROM
						tipo_remitente AS tr ";

		  $Newremi=new Consulta($remitente);
	  ?>
      <td> <div align="left">
        <select name="tipo_remi">
           <option value="">---Tipo de Remitente---</option>
          <?
        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>
          <option value="<?=$row_tremi[id_tipo_remitente]?>"<? if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>>
            <?=$row_tremi[tipo_remitente_nombre]?>
            </option> 
          <?  } ?>
        </select>
      </div></td>
    </tr>
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">
        <input name="Guardar3" type="submit" value="Guardar" class="boton" />
      </div></td>
    </tr>
  </table>
</form>

<?
}

function RemitentesList(){

	$sql_r = 	"Select
            	r.id_remitente,
            	r.nombre_remitente AS Remitente,
            	r.abreviatura_remitente AS Abreviatura,
            	tr.tipo_remitente_nombre AS Tipo
				FROM remitentes AS r
				Inner Join tipo_remitente AS tr
				ON tr.id_tipo_remitente = r.id_tipo_remitente
				WHERE estado_remitente = 1
				ORDER BY Remitente";

   	$query_r=new Consulta($sql_r);
	echo $query_r->VerListado("remitentes.php","");
}

function RemitentesDelete($id){

	$sql_r	=	"UPDATE remitentes SET
			  		estado_remitente = 0
			  		WHERE id_remitente=$id";

   $query_r=new Consulta($sql_r);

}


function urgentes(){
    $sql = "
        SELECT 
            r.abreviatura_remitente , r.nombre_remitente 
        FROM 
            remitentes r  
        WHERE 
            r.abreviatura_remitente in('MEF','CONG','CONT','MINAM')
        GROUP BY 
            r.abreviatura_remitente;
    ";
    $query = new Consulta($sql);
    return $query->getRows();
}

}
?>