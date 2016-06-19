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
	$template = new TemplatePower("../templates/modificarperfil.tpl");


	$template->prepare();

	// En este bloque, decidimos que menu mostrar, dependiendo de si hay un usuario conectado, y cual es su tipo
	if(empty(@$nombre)){

		echo "<script type='text/javascript'>
		alert('Debes de estar registrado para entrar aqui');
		window.location.href = 'index.php';
		</script>";

	}else{
		if($tipo ==2){
			echo "<script type='text/javascript'>
			alert('Ya estas registrado');
			window.location.href = 'index.php';
			</script>";
		}

		 $template->newBlock('menu1');
		 $template->newBlock("registro");

	}
		$con = new MySQLDataSource();

		$con -> conectar();

		@$pass = $_POST['password'];
		@$pass2 = $_POST['password2'];

		@$enviar = $_POST['cambiar'];


		if(isset($_POST['cambiar']) && empty($pass)){
						echo "<script type='text/javascript'>
							alert('El campo de Contraseña no puede quedar vacio');
							window.location.href = 'modificarperfil.php';
						</script>";
		}elseif(isset($_POST['cambiar']) && empty($pass2)){
						echo "<script type='text/javascript'>
							alert('El campo de Repetir contraseña no puede quedar vacio');
							window.location.href = 'modificarperfil.php';
						</script>";
		}



		if(isset($_POST['cambiar']) && !empty($pass) && !empty($pass2)){
 

				if((strlen($pass) < 8) && !empty($pass)){
										echo "<script type='text/javascript'>
											alert('El campo de Contraseña debe tener al menos 8 digitos');
											window.location.href = 'modificarperfil.php';
										</script>";
						}elseif($pass != $pass2){
										echo "<script type='text/javascript'>
											alert('Las contraseñas deben coincidir');
											window.location.href = 'modificarperfil.php';
										</script>";
						}elseif((!preg_match('`[a-z]`', $pass)) && !empty($pass)){
										echo "<script type='text/javascript'>
											alert('LA contraseña debe contener al menos una letra minúscula');
											window.location.href = 'modificarperfil.php';
										</script>";
						}elseif((!preg_match('`[A-Z]`', $pass)) && !empty($pass)){
										echo "<script type='text/javascript'>
											alert('La contraseña debe tener al menos un campo en mayúsculas');
											window.location.href = 'modificarperfil.php';
										</script>";
						}elseif((!preg_match('`[0-9]`', $pass)) && !empty($pass)){
										echo "<script type='text/javascript'>
											alert('La contraseña debe tener al menos un digito');
											window.location.href = 'modificarperfil.php';
										</script>";
						}else{

							$nuevaPass = md5($pass);

							$consulta = "UPDATE usuarios SET Password ='".$nuevaPass."' WHERE Nombre='".$nombre."'";

							$con -> ejecutar_consulta($consulta);


							$con -> desconectar();

								echo "<script type='text/javascript'>
								alert('Contraseña cambiada con éxito');
								window.location.href = 'index.php';
								</script>";
						}	
			}


		$template->newBlock('jquery');
		//Pintamos los bloques
		$template->printToScreen();
		
	

?>