<?
session_start();
require("includes.php");
if (isset($_GET['filename']) && $AuthVar['Auth'] ==true || isset($AuthVar[modulo]) ){
	$_SESSION["inrena_".$AuthVar[modulo]][2]=$_GET[axo];
	$dirn=dirname($_GET['filename'])."/";
	header("Location: $dirn"); 
}else{
	$dirn=dirname($PHP_SELF)."./";
	header("Location: $dirn"); 
}
?>