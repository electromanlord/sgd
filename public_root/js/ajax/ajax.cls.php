<?
class Ajax{

function carga_combo($sql,$nom,$next='',$msg_d='-- Seleccione --',$msg_v='-- Sin Opciones --'){
	$q=new Consulta($sql);
	if($q->numregistros()==0){?>
			<select name="<?=$nom?>"><option value=''><?=$msg_v?></option></select>
<? }else{?>
	<select name="<?=$nom?>" onchange="carga_combo(this,'<?=$next?>')" > 
		<option value='' selected ><?=$msg_d?></option>
		<? while($r=$q->ConsultaVerRegistro()){?>
			<option value='<?=$r[0]?>'><?=urlencode($r[1])?></option>
		<? }
	?></select><?
	} //if hay registros	
}

}
?>
