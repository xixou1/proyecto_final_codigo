<?php
    session_start();
// Hacemos los includes necesarios
    include_once("../models/usuario.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");


	//Variables de sesion, para saber tipo y login de la persona coenctada
	@$nombre = $_SESSION['nombreUsuario'];
	@$usuario = $_SESSION['UsuarioIntroducido'];
	@$tipo = $_SESSION['tipo'];

	//Iniciamos el objeto templatePower y lo preparamo
	$template = new TemplatePower("../templates/registro.tpl");


	$template->prepare();

	// En este bloque, decidimos que menu mostrar, dependiendo de si hay un usuario conectado, y cual es su tipo
	if(!empty(@$nombre)){

		if($tipo == 1){
			echo "<script type='text/javascript'>
			alert('Ya estas registrado');
			window.location.href = 'index.php';
			</script>";
		}elseif($tipo ==2){
			echo "<script type='text/javascript'>
			alert('Ya estas registrado');
			window.location.href = 'index.php';
			</script>";
		}
	}else{

		 $template->newBlock('menu0');
		 $template->newBlock("registro");
		 $template->newBlock('jquery');

		$con = new MySQLDataSource();

		$con -> conectar();

		@$nickname = $_POST['nickname'];
		@$pass = $_POST['password'];
		@$pass2 = $_POST['password2'];
		@$nombre = $_POST['nombre'];
		@$correo = $_POST['email'];

		@$enviar = $_POST['registrar'];

		if(isset($_POST['registrar']) && !empty($nickname) && !empty($pass)
			&& !empty($pass2) && !empty($nombre) && !empty($correo)){

			$consulta = "INSERT INTO `usuarios`(`Login`, `Password`, `Nombre`, `Email`, `Tipo`) VALUES ('".$nickname."','".md5($pass)."','".$nombre."','".$correo."',1)";

			$con -> ejecutar_consulta($consulta);

			$passCifrada = md5($pass);

			$con -> desconectar();

				echo "<script type='text/javascript'>
				alert('Usuario creado con exito');
				window.location.href = 'index.php';
				</script>";
			
		}

					// CAMBIAR LOS ECHO POR MENSAJE DE ERROR EN EL TPL

					if(isset($_POST['registrar']) && empty($nickname)){
						echo "<script type='text/javascript'>
							alert('El campo de Alias no puede quedar vacio');
							window.location.href = 'registro.php';
						</script>";
					}elseif(isset($_POST['registrar']) && empty($pass)){
						echo "<script type='text/javascript'>
							alert('El campo de Contraseña no puede quedar vacio');
							window.location.href = 'registro.php';
						</script>";
					}elseif(isset($_POST['registrar']) && empty($pass2)){
						echo "<script type='text/javascript'>
							alert('El campo de Repetir contraseña no puede quedar vacio');
							window.location.href = 'registro.php';
						</script>";
					}elseif((strlen($pass) < 8) && !empty($pass)){
						echo "<script type='text/javascript'>
							alert('El campo de Contraseña debe tener al menos 8 digitos');
							window.location.href = 'registro.php';
						</script>";
					}elseif($pass != $pass2){
						echo "<script type='text/javascript'>
							alert('Las contraseñas deben coincidir');
							window.location.href = 'registro.php';
						</script>";
					}elseif((!preg_match('`[a-z]`', $pass)) && !empty($pass)){
						echo "<script type='text/javascript'>
							alert('LA contraseña debe contener al menos una letra minúscula');
							window.location.href = 'registro.php';
						</script>";
					}elseif((!preg_match('`[A-Z]`', $pass)) && !empty($pass)){
						echo "<script type='text/javascript'>
							alert('La contraseña debe tener al menos un campo en mayúsculas');
							window.location.href = 'registro.php';
						</script>";
					}elseif((!preg_match('`[0-9]`', $pass)) && !empty($pass)){
						echo "<script type='text/javascript'>
							alert('La contraseña debe tener al menos un digito');
							window.location.href = 'registro.php';
						</script>";
					}elseif(isset($_POST['registrar']) && empty($nombre)){
						echo "<script type='text/javascript'>
							alert('El campo de Nombre no puede quedar vacio');
							window.location.href = 'registro.php';
						</script>";
					}elseif(isset($_POST['registrar']) && empty($correo)){
						echo "<script type='text/javascript'>
							alert('El campo de Email no puede quedar vacio');
							window.location.href = 'registro.php';
						</script>";
					}


	//Pintamos los bloques
	$template->printToScreen();
	
	}

?>