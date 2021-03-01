<?php
header('Content-Type: text/html; charset=utf-8');
ini_set("display_errors", "1");
error_reporting(E_ALL);
require_once('modelo/modelo.php');
$usuario=new Modelo();
$_dni=$_POST['dni'];
$_pass=$_POST['pass'];
$result = $usuario->traerUsuario($_dni,$_pass);
if(isset($result)){
	$result=$result[0];
	session_start();
	$_SESSION['codigoUsuario'] = $result['codigoUsuario'];
	$_SESSION['usuario'] = $result['usuario'];
	$_SESSION['nombre'] = $result['nombre'];
	header("Location: ../");
}else{
	header("Location: ../login.php");
}
?>

