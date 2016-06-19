<?php
	#error_reporting(0);
	// Hacemos los includes necesarios
    include_once("../models/usuario.php");
    include_once("../models/imagen.php");
    include_once("../models/ruta.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");
    include_once("funciones.php");
    session_start();

	//Variables de sesion, para saber tipo y login de la persona coenctada
	@$nombre = $_SESSION['nombreUsuario'];
	@$usuario = $_SESSION['UsuarioIntroducido'];
	@$tipo = $_SESSION['tipo'];
	@$id = $_SESSION['id'];

	$template =  new TemplatePower("../templates/gestionusuarios.tpl");
	$template->prepare();


	if(empty($nombre)){

		echo "<script language='javascript'>alert('Debes estar registrado para entrar aqui')</script>";
		echo "<script language='javascript'>window.location='index.php'</script>";

	}else{

			if($tipo == 1){
		echo "<script language='javascript'>alert('Debes ser administrador para entrar aqui')</script>";
		echo "<script language='javascript'>window.location='index.php'</script>";
			}else{
				$template->newBlock('menu2');
				$template->assign('nombre',$nombre);
				$template->newBlock('banner1');
				$template->assign('nombre',$nombre);
			}

	}

		$template->newBlock('administrador');

		$listaUsuario = Null;
		$incr = 0;

		//Creación del objeto MySQLDataSource
		$con = new MySQLDataSource();

		$con -> conectar();

		//Creamos la consulta

		$consulta = "SELECT ID, Login, Nombre, Email, Tipo FROM usuarios";

		$con -> ejecutar_consulta($consulta);
		$fila = $con -> siguiente();

		while($fila){

			$listaUsuario[$incr] = new usuario();

			$listaUsuario[$incr] -> setId($fila->ID);
			$listaUsuario[$incr] -> setLogin($fila->Login);
			$listaUsuario[$incr] -> setNombre($fila->Nombre);
			$listaUsuario[$incr] -> setEmail($fila->Email);
			$listaUsuario[$incr] -> setTipo($fila->Tipo);


			$idBD = $listaUsuario[$incr] -> getId();
			$loginDB = $listaUsuario[$incr] -> getLogin();
			$nombreBD = $listaUsuario[$incr] -> getNombre();
			$emailBD = $listaUsuario[$incr] -> getEmail();
			$tipoBD = $listaUsuario[$incr] -> getTipo();


			$template->newBlock('datos');
			$template -> assign('Id', $idBD);
			$template -> assign('Login', $loginDB);
			$template -> assign('Nombre', $nombreBD);
			$template -> assign('Email', $emailBD);
			$template -> assign('Tipo', $tipoBD);


			$fila = $con -> siguiente();
			$incr+=1;

		}






		$template -> newBlock('jquery');

		$template -> printToScreen();
?>