<?php 
	//Pagina encargada de borrar la sesion y nos redirige a la pagina principal
	
session_start();
	//Variables de sesion, para saber tipo y login de la persona coenctada
$_SESSION['nombreUsuario']= "";
$_SESSION['tipo'];

session_destroy();

echo"<script language='javascript'>window.location='index.php'</script>;";

?>