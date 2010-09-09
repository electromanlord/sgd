<?php class Escaneo {


function EscaneaCabecera(){	

$sql_usu="SELECT `u`.`login_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`,`u`.`nombre_usuario` as nombre
FROM
`usuarios` AS `u`,
`usuario_axo_poa` AS `uap` 
WHERE
`u`.`id_usuario` = `uap`.`id_usuario` AND
`u`.`id_usuario` = '1'
";
$query_pa=new Consulta($sql_usu);		
$row_usu=$query_pa->ConsultaVerRegistro(); 

}


function EscaneaListado($ide){	 ?>

<? 
if ($ide==''){
	$sql_reg=" SELECT * FROM
documentos
Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
Inner Join estados ON estados.id_estado = documentos.id_estado
Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento ORDER BY
documentos.id_documento DESC";

	$query_reg=new Consulta($sql_reg);		
}
else 

{
	$sql_reg=" SELECT * FROM
documentos
Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
Inner Join estados ON estados.id_estado = documentos.id_estado
Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento 
Where estados.id_estado='".$ide."'
ORDER BY documentos.id_documento DESC";

	$query_reg=new Consulta($sql_reg);		
}

	//$row_reg=$query_reg->ConsultaVerRegistro();

	

	?>

   

      <!----<div align="center"><a href="<=$_SESSION['PHP_SELF']?>?opcion=add"class=" Estilo2" >Registrar Nuevo</a></div>--->
      <style type="text/css">
<!--
.Estilo1 {color: #0000FF}
-->
      </style>
      



<table width="100%" border="4"  bordercolor="#6699CC" align="center">
    <tr bgcolor="#6699CC" class="Estilo2">
      <td width="9%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
      <!----<td width="8%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
      <td width="32%"><div align="center"><span class="msgok1">Remitente</span></div></td>
      <td width="31%"><div align="center"><span class="msgok1"> Documento</span></div></td>
      <!----<td width="31%"><div align="center"><span class="msgok1">Referencia</span></div></td>--->
      <td width="14%"><div align="center"><span class="msgok1">Fecha</span></div></td>
      <td width="4%" align="center">Estado</td>
      <td width="10%"><div align="center" class="msgok1">Ubicacion  </div></td>
  </tr>

    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$id=$row_reg[0]?>
    <tr class="Estilo2">
    <td onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)"  ><a href="escaneo_acceso_registro.php?opcion=edit&id=<?=$id?>"><?=$row_reg[1]?></a></td>

      <!---<td ><=$row_reg[nombre_tipo_documento]?></td>--->
      <td><input size="50" value="<?=$row_reg[nombre_remitente]?>"/></td>
      <td><input size="45" value="<?=$row_reg[3]?>"/></td>
      <!---<td ><?=$row_reg[4]?></td>--->
      <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
      <td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>
      <?php 
  
	  	$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
		FROM
		`historial_documentos` AS `hd`
		where hd.id_documento='".$row_reg['id_documento']."'
		GROUP BY
		`hd`.`id_documento`";
		$query_ultimo=new Consulta($sql_ultimo);		
		$ultimo=$query_ultimo->ConsultaVerRegistro();
	  
	  
	  
		$sql_data=" SELECT hd.id_documento,a.nombre_area, a.abve_nombre_area FROM historial_documentos AS hd 
		Inner Join areas AS a ON a.id_area = hd.id_area 
		where hd.id_historial_documento='".$ultimo['ultimo']."'";
		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();
		
		
		
		$sql_usu="SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`, `ha`.`id_documento`
				FROM
				`historial_atencion` AS `ha`
				WHERE
				ha.original_historial_atencion =  '1' and
				ha.id_documento='".$row_reg['id_documento']."' 
				GROUP BY
				`ha`.`id_documento`	";
		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();
		
		$susu="SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";
				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro();
		
		
		
?>
      <td >
	<?  if ($row_reg['id_estado']<4){ echo $data[2];
	
	}
	 else {
	  
	  echo $u['abve_nombre_area'].' '.$u['login_usuario'];}?></td>
    </tr><? }?>
</table>



<? }



function EscaneaAgregar(){ ?>









<link href="style.css" type="text/css" rel="stylesheet">

<link href="style.css" type="text/css" rel="stylesheet">

<link rel="stylesheet" type="text/css" media="all" href="../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 

<span class="Estilo12 Estilo8 Estilo8 Estilo12">

<script type="text/javascript" src="../libs/calendar/calendar.js"></script> 

<script type="text/javascript" src="../libs/calendar/calendar-es.js"></script>   

<script type="text/javascript" src="../libs/calendar/calendar-setup.js"></script> 

<script language="javascript" src="js/js.js"> </script>

<script language="javascript" src="../js/js.js"> </script>	



<form id="f3" name="f3" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=guardar">

  

  <div align="right" class="Estilo2"></div>

  <table width="93%" border="0" align="center" >

    <tr class="Estilo2">
      <td width="204" class="Estilo22"><div align="left">Instituci&oacute;n</div></td>

      <td width="8" class="Estilo2">:</td>

      <td width="292" ><span class="Estilo2">

      <?

      

		$sql_remit="select * FROM remitentes ORDER BY remitentes.nombre_remitente ASC";

    	$query_remit=new Consulta($sql_remit);		

		//$row_remit=$query_remit->ConsultaVerRegistro(); 

	

?>
      <select name="remit">
        <option value="">--- Seleccione Remitente ---</option>
        <? while($row_remit=$query_remit->ConsultaVerRegistro()){?>
        <option value="<? echo $row_remit[0]?>"<? if(isset($_POST['remit']) && $_POST['remit']==$row_remit[0]){ echo "selected";} ?>><? echo $row_remit[2]?></option>
        <?  } ?>
      </select>
      <a  href="<?=$_SESSION['PHP_SELF']?>?opcion=listremi" class="Estilo2">Agregar</a>

      </span></td>

      <td width="35" class="Estilo2">&nbsp;</td>

      <td width="135"class="Estilo22" >Folios</td>
      <td width="11" class="Estilo22">:</td>

      <td ><span class="Estilo2">

        <input name="num_folio" type="text" size="10" />

      </span></td>
   	</tr>

   		<tr>
   		  <td class="Estilo22"><div align="left">Tipo de Documento</div></td>
   		  <td class="Estilo2">:</td>
   		  <td bgcolor="#FFFFFF"><span class="Estilo2">
   		    <?

      $sql_tipo="SELECT * FROM tipos_documento ORDER BY tipos_documento.nombre_tipo_documento ASC";

    	$query_tipo=new Consulta($sql_tipo);	

		

		?>
   		    <select name="tipo">
              <option value="">---Tipo de Documento---</option>
              <?

        while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
              <option value="<?=$row_tipo[0]?>"<? if(isset($_POST['tipo']) && $_POST['tipo']== $row_tipo[0]){ echo "selected";} ?>>
                <?=$row_tipo[1]?>
              </option>
              <?  } ?>
            </select>
   		  </span></td>
   		  <td class="Estilo2">&nbsp;</td>
   		  <td bgcolor="#FFFFFF" class="Estilo2">&nbsp;</td>
   		  <td bgcolor="#FFFFFF" class="Estilo2">&nbsp;</td>
   		  <td>&nbsp;</td>
    </tr>
   		<tr>
   		  <td width="204" class="Estilo22"><div align="left">Nro. Doc</div></td>

      <td width="8" class="Estilo2">:</td>

      <td bgcolor="#FFFFFF"><span class="Estilo2">
        <input name="num_doc" type="text" id="num_doc" value="" size="48" />
      </span></td>

      <td class="Estilo2">&nbsp;</td>

      <td width="135"  class="Estilo22"><div align="left" class="Estilo2">Fecha </div></td>
      <td width="11"  class="Estilo22"><div align="center">:</div></td>

      <td width="159"> 

      	<input name="FechaSol" id="FechaSol" type="text" value="" readonly="true" size="12" style="background-color:#EEEEEE"/>

       	<input name="button" type="button" id="lanzador" value="..." />

        

    <script type="text/javascript"> 

					   Calendar.setup({ 

						 inputField: "FechaSol",     

						 ifFormat  : "%Y-%m-%d",   

						 button    : "lanzador" 

						});			

					</script>  </td>
    </tr> 

    
    <tr>
      <td class="Estilo22"><div align="left" class="Estilo2">Observacion:</div></td>

      <td>:</td>

      <td colspan="6"><textarea name="observ" cols="100" rows="4" value="" ></textarea></td>
    </tr>
  </table>
</form>

  <? }



function EscaneaEditar($id){

//echo 'Pagina en Desarrollo';

$Query= new Consulta($sql = " SELECT * FROM `documentos` AS `d` WHERE d.id_documento='".$id."'");

			$Row= $Query->VerRegistro();

			$remit=$Row['id_remitente'];

			$tipo=$Row['id_tipo_documento'];

?>

<link href="style.css" type="text/css" rel="stylesheet">

<link href="style.css" type="text/css" rel="stylesheet">

<link rel="stylesheet" type="text/css" media="all" href="../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 

<span class="Estilo2">

<script type="text/javascript" src="../libs/calendar/calendar.js"></script> 

<script type="text/javascript" src="../libs/calendar/calendar-es.js"></script>   

<script type="text/javascript" src="../libs/calendar/calendar-setup.js"></script> 

<script language="javascript" src="js/js.js"> </script>

<script language="javascript" src="../js/js.js"> </script>	



<form id="f3" name="f3" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>">

  

  <div align="right" class="Estilo2"></div>

  <table width="93%" border="1" align="center" >
    <tr class="Estilo2">
      <?     $sql_1="SELECT * FROM documentos AS td WHERE td.id_documento =  '".$id."'"; 

		$query_1=new Consulta($sql_1);

		$row_1=$query_1->ConsultaVerRegistro();

		//$Fech=$row_1['fecha_documento'];

?>
    </tr>
    <tr>
      <td width="80" class="Estilo22"><div align="left" class="Estilo2">Nro. Doc:</div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo2">
        <input name="num_doc2" type="text" id="num_doc2" value="<?=$row_1[3]?>" size="48" />
      </span></td>
      <td class="Estilo22" align="right">Folios</td>
      <td class="Estilo22"><input name="num_folio2" type="text" value="<?=$row_1[6]?>" size="10" /></td>
      <td width="86" bgcolor="#FFFFFF" class="Estilo2"><div align="left" class="Estilo2">Fecha</div></td>
      <td width="190"><?=$row_1['fecha_documento']?>      </td>
    </tr>
   
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">Item</span></td>
      <td  colspan="3" align="center"><span class="Estilo1">Buscar el Archivo</span></td>
      <td  colspan="2" align="center"><span class="Estilo1">Subir</span></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">1.-</span></td>
      <td  colspan="3" align="left"><input name="archivo1" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">2.-</span></td>
       <td  colspan="3" align="left"><input name="archivo2" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">3.-</span></td>
       <td  colspan="3" align="left"><input name="archivo3" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">4.-</span></td>
     <td  colspan="3" align="left"><input name="archivo4" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">5.-</span></td>
     <td  colspan="3" align="left"><input name="archivo5" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
      </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">6.-</span></td>
       <td  colspan="3" align="left"><input name="archivo6" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
     </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">7.-</span></td>
      <td  colspan="3" align="left"><input name="archivo7" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">8.-</span></td>
 		<td  colspan="3" align="left"><input name="archivo8" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
    </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">9.-</span></td>
       <td  colspan="3" align="left"><input name="archivo9" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
      </tr>
    <tr>
      <td colspan="1" align="center"><span class="Estilo1">10.-</span></td>
       <td  colspan="3" align="left"><input name="archivo10" type="file" id="examinar"  size="50" /></td>
      <td colspan="2" align="center"><input name="Subir" type="submit" class="Estilo1" value="Subir"/></td>
     </tr>
    <tr>
     <!---- <td  height="60" colspan="6" align="center"><input name="Guardar2" type="submit" value="Guardar" /></td>--->
    </tr>
  </table>
</form>

  <? }







function EscaneaAgrega(){

echo 'Pagina en Desarrollo';



 }

function EscaneaGuardar(){?>

<!---<p align="center" class="Estilo25">Este documento ya existe con el siguiente Escaneo <a href="#">XXX </a></p>

  <p align="center" class="Estilo25">

    <input type="button" name="Submit2" value="Limpiar" />

    <input type="button" name="Submit3" value="Salir" />

  </p>---><?PHP 



	//echo "Prueba";

	//echo die();

	

	$num_folio=$_POST["num_folio"];

	$remit=$_POST["remit"]; 

	$tipo=$_POST["tipo"]; 

	$num_doc=$_POST["num_doc"]; 

	$FechaSol=$_POST["FechaSol"]; 

	$refe=$_POST["refe"]; 

	$anexo=$_POST["anexo"]; 

	$destino=$_POST["destino"]; 

	$observ=$_POST["observ"]; 

	

	$query="SELECT `ttd`.`abreviatura_tipo_documento` as codigo1 FROM `tipos_documento` AS `ttd` WHERE `ttd`.`id_tipo_documento` =  '".$tipo."'

";

	$query_codigo=new Consulta($query);		

	$row_codigo=$query_codigo->ConsultaVerRegistro();

	$codigo1=$row_codigo['codigo1'];

	

	//echo $codigo1;

	$sql_cod1="SELECT `tr`.`abreviatura_remitente` as codigo2 FROM remitentes AS `tr` WHERE `tr`.`id_remitente` =  '".$remit."'";

	$query_codigo1=new Consulta($sql_cod1);		

	$row_codigo1=$query_codigo1->ConsultaVerRegistro();

	$codigo2=$row_codigo1['codigo2'];

	//echo $codigo2;

	$sql_cod2="SELECT Max(`td`.`id_documento`) AS `codigo3` FROM `documentos` AS `td`";

	$query_codigo2=new Consulta($sql_cod2);		

	$row_codigo2=$query_codigo2->ConsultaVerRegistro();

	$codigo21=$row_codigo2['codigo3'];

	$codigo3=$codigo21+1;

	//echo $codigo3;

	//$codigo=$codigo1.$codigo2.$codigo3;

	$codigo='00'.$codigo3.'-2009';

	/*if ($codigo3<9){$codigo='S-0000'.$codigo3.'-'.'2009';

		if ($codigo3>9&&$codigo3<=99){$codigo='S-000'.$codigo3.'-'.'2009';

			if ($codigo3>99&&$codigo3<=999){$codigo='S-00'.$codigo3.'-'.'2009';

				if ($codigo3>999&&$codigo3<=9999){$codigo='S-0'.$codigo3.'-'.'2009';

					}

			}

		}

	}*/

	//echo $codigo;

	//$codigo=$row_codigo["codigo"];

	//Con esto se indica de que esta registrado

	$var_estado=1;

	$guarda="INSERT INTO documentos VALUES ('',

	'".$codigo."',

	'".$tipo."',

	'".$num_doc."',

	'".$refe."',

	'".$anexo."',

	'".$num_folio."',

	'".formato_date('/',$FechaSol)."',

	'',

	'".date("Y-m-d H:i:s")."',

	'".$observ."',

	'',

	'',

	'".$remit."',

	'".$var_estado."')";

	$q_guarda=new Consulta($guarda);		

	///$row_guarda=$q_guarda->ConsultaVerRegistro();

	//echo $q_guarda;

	///header("location: acceso_Escaneo.cls.php");	



?>

<script type="text/javascript"> 

javascript:window.open('Ventanillas/ficha_Escaneo.php?id=<?php echo $codigo3?>','popup','width=600,height=500');

<!---javascript:window.print('Ventanillas/ficha_Escaneo.php?id=<php echo $codigo21?>','popup','width=600,height=500');--->

</script>

<?



  

  }

 function EscaneaUpdate($id){

 	

	$num_folio=$_POST["num_folio"];

	$remit1=$_POST["remit1"]; 

	$tipo=$_POST["tipo"]; 

	$num_doc2=$_POST["num_doc2"]; 

	$FechaSol2=$_POST["FechaSol2"]; 

	$refe=$_POST["refe"]; 

	$anexo=$_POST["anexo"]; 

	$destino=$_POST["destino"]; 

	$observ1=$_POST["observ1"]; 

 	$var_estado=1;

	$actualiza="UPDATE documentos SET

	documentos.id_tipo_documento='".$tipo."',

	documentos.`numero_documento`='".$num_doc2."',

	documentos.`referencia_documento`='".$refe."',

	documentos.`anexo_documento`='".$anexo."',

	documentos.`numero_folio_documento`='".$num_folio."',

	documentos.`fecha_documento`='".$FechaSol2."',

	documentos.`observacion_documento`='".$observ1."',

	documentos.`id_remitente`='".$remit1."'

	

	Where documentos.id_documento='".$id."'";

	$actua=new Consulta($actualiza);	

}

function EscaneaEliminar($id){

}

function EscaneaGuardarRemitente(){



$nom_remi=$_POST[nom_remi];

$abrev=$_POST[abrev];

$tipo_remi=$_POST[tipo_remi];

$sql_re="Insert Into remitentes Values('','".$tipo_remi."','".$nom_remi."','".$abrev."','')";





	$q_remite=new Consulta($sql_re);		

}



function EscaneaEditRemitente($id){





$sql_editremi="SELECT

remitentes.`id_remitente`,

remitentes.`nombre_remitente`,

remitentes.`abreviatura_remitente`,

remitentes.`id_tipo_remitente`

FROM

remitentes

WHERE remitentes.id_remitente='".$id."'



";

$editremi=new Consulta($sql_editremi);

$rowe=$editremi->ConsultaVerRegistro();

$tipo_remi=$rowe['id_tipo_remitente'];

?>





<form id="f42" name="f42" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=Updateremi&id=<?=$id?>">

  <table width="800" border="0" align="center">

    <tr>

      <td class="Estilo22"><div align="right">Codigo: </div></td>

      <td><input name="codigo" value="<?=$rowe[0]?>" type="text"/></td>

    </tr>

    <tr>

      <td class="Estilo22"><div align="right">Nombre de Remitente: </div></td>

      <td><input name="nom_remi2" value="<?=$rowe[1]?>" type="text"/></td>

    </tr>

    <tr>

      <td class="Estilo22"><div align="right">Abreviatura:</div></td>

      <td><input name="abrev2" value="<?=$rowe[2]?>" type="text"/></td>

    </tr>

    <tr>

      <td class="Estilo22"><div align="right">Tipo de Remitente: </div></td>

      <?php 
	  $remitente="SELECT tr.id_tipo_remitente, tr.tipo_remitente_nombre FROM tipo_remitente AS tr "; 
	  $Newremi=new Consulta($remitente);
	  ?>
      <td> <select name="tipo_remi2">
     <option value="">---Tipo de Remitente---</option>

				  <?

        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>

	    <option value="<?=$row_tremi[id_tipo_remitente]?>"<? if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>><?=$row_tremi[tipo_remitente_nombre]?>
        </option> <?  } ?>	
        </select>

      </td> 
      
      
    

    </tr>

    <tr>

      <td class="Estilo2">&nbsp;</td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td colspan="2"><div align="center">

        <input class="boton" name="Actualizar2" type="submit" value="Actualizar"/>

      </div></td>

    </tr>

  </table>

</form>



<?

}

function EscaneaUpdateRemitente($id){



$nom_remi2=$_POST[nom_remi2];

$abrev2=$_POST[abrev2];

$tipo_remi2=$_POST[tipo_remi2];



$act_remi=" UPDATE remitentes set
remitentes.`nombre_remitente`='".$nom_remi2."',
remitentes.`id_tipo_remitente`='".$tipo_remi2."',
remitentes.`abreviatura_remitente`='".$abrev2."'

where remitentes.`id_remitente`='".$id."'

";

$Uremi=new Consulta($act_remi);



}

function EscaneaNewRemitente(){?>



<form id="f41" name="f41" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=guardremi">

  <table width="800" border="0" align="center">

    <tr>

      <td width="400">&nbsp;</td>

      <td width="390">&nbsp;</td>

    </tr>

    <tr>

      <td class="Estilo22"><div align="right">Nombre de Remitente: </div></td>

      <td><input name="nom_remi" type="text"/></td>

    </tr>

    <tr>

      <td class="Estilo22"><div align="right">Abreviatura:</div></td>

      <td><input name="abrev" type="text"/></td>

    </tr>

    <tr>

      <td class="Estilo22"><div align="right">Tipo de Remitente: </div></td>

      <?php 
	  $remitente="SELECT
tr.id_tipo_remitente,
tr.tipo_remitente_nombre
FROM
tipo_remitente AS tr ";
	  $Newremi=new Consulta($remitente);
	  ?>
      <td> <select name="tipo_remi">
     <option value="">---Tipo de Remitente---</option>

				  <?

        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>

	    <option value="<?=$row_tremi[id_tipo_remitente]?>"<? if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>><?=$row_tremi[tipo_remitente_nombre]?>
        </option> <?  } ?>	
        </select>

      </td> 
      

    </tr>

    <tr>

      <td class="Estilo2">&nbsp;</td>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td colspan="2"><div align="center">

        <input name="Guardar3" type="submit" value="Guardar" class="boton" />

      </div></td>

    </tr>

  </table>

</form>



<?



}

function EscaneaListRemitente(){



$sql_r="Select * FROM remitentes AS r Inner Join tipo_remitente AS tr ON tr.id_tipo_remitente = r.id_tipo_remitente  ORDER BY r.`id_remitente` DESC";

    	$query_r=new Consulta($sql_r);		

		//$row_remit=$query_remit->ConsultaVerRegistro(); ?>

		

<div align="center"><a href="<?=$_SESSION['PHP_SELF']?>?opcion=newremi"class="Estilo2" >Nuevo Remitente</a></div>					



<form id="f4" name="f4" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=newremi">

 <table width="100%" height="72" border="1" align="center">

    <tr bgcolor="#6699CC" class="Estilo2">

      <td width="57" height="31" class="Estilo2"><div align="center">Codigo</div></td>

      <td width="247" class="Estilo2"><div align="center">Remitente</div></td>

      <td width="162" class="Estilo2"><div align="center">Abreviatura</div></td>

      <td width="316" class="Estilo2"><div align="center">Tipo Remitente </div></td>

    </tr>

    <tr>

 <?  while($row_r=$query_r->ConsultaVerRegistro()){

 $id=$row_r[0];

 ?>



      <td height="22" ><div align="center" class="Estilo2"><a href="<?=$_SESSION['PHP_SELF']?>?opcion=editremi&id=<?=$id?>"><?=$id?></a></div></td>

      <td class="Estilo2"><?=$row_r['nombre_remitente']?></td>

      <td class="Estilo2"><?=$row_r['abreviatura_remitente']?></div></td>

      <td class="Estilo2"><?=$row_r['tipo_remitente_nombre']?></div></td>

    </tr><? }?>

    <tr>

      <td colspan="5">

      <!----<div align="center"><p></p>

        <input type="submit" name="Submit" value="Nuevo Remitente" />

      </div>

          <div align="center"></div></td>--->

    </tr>

  </table>

  

</form>





<?



}

function EscaneaFiltrar(){

$sql_estado="SELECT *
			FROM
			`estados` AS `e`
			ORDER BY
			`e`.`nombre_estado` ASC";
			$q_estado=new Consulta($sql_estado);		
			

?>
<form name="f5" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=list&ide=<?=$ide?>">
<table width="100%" height="50" border="0" >
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center">
 
    <select name="ide">
      
      
      <option value="">---Estado---</option>
      
       <?

        while($row_estado=$q_estado->ConsultaVerRegistro()){
		$ide=$row_estado[0];?>
      
                 <option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){ echo "selected";} ?>>
                 <?=$row_estado[1]?>
                            </option> 
      <?  } ?>	
    </select></td>
    </tr>
 <tr>
  <td align="center" ><input name="Filtrar" type="submit"  value="Filtrar"/></td>
  </tr>
</table>
    
</form>
        <?
}

}



 ?>