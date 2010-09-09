<?php
require_once("libs/lib.php");
require_once("cls/conexion.cls.php");
require_once("cls/conexion_selpo.cls.php");
require_once("cls/consulta.cls.php");
require_once("cls/class.sesion.php");
require_once("cls/class.acceso.php");
require_once("cls/class.usuarios.php");
require_once("cls/class.plantilla.php");
require_once("cls/class.menu.php");
require_once('cls/class.usuario.php');
require_once('cls/class.area.php');
require_once('cls/class.rol.php');
require_once('cls/class.accion.php');
require_once('cls/class.acciones.php');
require_once('cls/class.anp.php');
require_once('cls/class.documento.php');
require_once('cls/class.estado.php');
require_once('cls/class.prioridad.php');
require_once('cls/class.remitente.php');
require_once('cls/class.tipo_documento.php');

session_start();

$link_selpo=new Conexion("areaspro_dbsiganp1");
$link=new Conexion("sernanp");


?>