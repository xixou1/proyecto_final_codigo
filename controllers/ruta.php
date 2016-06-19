<?php
session_start();

$idRuta = $_GET['id'];

$_SESSION['id'] = $idRuta;

echo"<script language='javascript'>window.location='rutas.php'</script>;";
?>