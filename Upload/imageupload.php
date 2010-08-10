<?php

@session_start();
$dirName="../Archivados";

if (isset($_POST['id'])) {
	//$uploadFile=$_GET['dirname']."/".$_FILES[$_POST['id']]['name']; for security reasons,  hardcode the name of the directrory.
	@mkdir($dirName,0777);

	$uploadFile="$dirName/".$_FILES[$_POST['id']]['name'];
	
	if(!is_dir($_GET['dirname'])) {
		echo '<script> alert("Failed to find the final upload directory: $dirName);</script>';
	}
	if (!copy($_FILES[$_POST['id']]['tmp_name'], $dirName.'/'.$_FILES[$_POST['id']]['name'])) {	
		echo '<script> alert("Failed to upload file");</script>';
	}
}
else {
	// for secority reason either remove the extentions or rectrict uploaded not to upload / run scripts like file.php else they can misuse the disk space 
	//$uploadFile=$_GET['dirname']."/".$_GET['filename']; // removed for security reasons (happend with my demo )
	$uploadFile="$dirName/".$_GET['filename'];
	if (file_exists($uploadFile)) {
		//echo "<img src='../public_root/imgs/attach.png'/>. <a href='$uploadFile'>Abrir Archivo</a> &nbsp;&nbsp;&nbsp; <a href='deletefile.php?filename=".$uploadFile."'>Eliminar Archivo</a>";
        echo "<img src='../public_root/imgs/attach.png'> <a href='$uploadFile'>Open File</a> &nbsp;&nbsp;&nbsp; <a href='deletefile.php?filename=".$uploadFile."'>Delete File</a>";
	}
	else {
		echo "<img src='loading.gif' alt='loading...' />";
	}
}
?>