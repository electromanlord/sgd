<?
require("includes.php");
require("cls/index.cls.php");
///////////
if(empty($_SESSION[acc])&&empty($_POST)) require("error_s.php");
/////////
$link= new Conexion();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Env�o de mails con PHP</title>
</head>

<body>

<?
$destinatario = "ecrsoluciones@gmail.com";
$asunto = "Este mensaje es de prueba";
$cuerpo = '
<html>
<head>
 <title>Prueba de correo</title>
</head>
<body>
<h1>Hola amigos!</h1>
<p>
<b>Bienvenidos a mi correo electr�nico de prueba</b>. Estoy encantado de tener tantos lectores.
</p>
</body>
</html>
';

//para el env�o en formato HTML
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

//direcci�n del remitente
$headers .= "From: Miguel Angel Alvarez <danicks1020@hotmail.com>\r\n";

//direcci�n de respuesta, si queremos que sea distinta que la del remitente
$headers .= "Reply-To: maria@desarrolloweb.com\r\n";

//direcciones que recibi�n copia
$headers .= "Cc: danicks1020@hotmail.com\r\n";

//direcciones que recibir�n copia oculta
$headers .= "Bcc: ecrsoluciones@gmail.com\r\n";

mail($destinatario,$asunto,$cuerpo,$headers)
?>

</body>
</html>

