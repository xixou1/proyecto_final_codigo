<?php

    include_once("../models/usuario.php");
    include_once("../models/imagen.php");
    include_once("../models/ruta.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");
    include_once("funciones.php");
    session_start();

	$idRuta = $_GET['id'];

	$_SESSION['id'] = $idRuta;




//Creación del objeto MySQLDataSource
	$con = new MySQLDataSource();

	$con -> conectar();

	//Creamos la consulta

	$consulta = "UPDATE `usuarios` SET Tipo ='2' WHERE ID ='".$idRuta."'";

	$con -> ejecutar_consulta($consulta);

	$con -> desconectar();

 
	echo "<script language='javascript'>alert('Usuario upgradeado con exito');</script>;";

	echo "<script language='javascript'>window.location='index.php'</script>;";

?>