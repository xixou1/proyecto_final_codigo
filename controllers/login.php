<?php 
	//Pagina encargada de borrar la sesion y nos redirige a la pagina principal
	
session_start();
echo "<script>alert('Bienvenido, ".$_SESSION['nombreUsuario']."');</script>";

echo"<script language='javascript'>window.location='index.php'</script>;";

?>