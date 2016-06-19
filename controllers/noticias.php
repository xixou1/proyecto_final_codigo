	<?php

// Hacemos los includes necesarios
    include_once("../models/usuario.php");
    include_once("../models/noticia.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");
    include_once("funciones.php");
    session_start();

	//Variables de sesion, para saber tipo y login de la persona coenctada
	@$nombre = $_SESSION['nombreUsuario'];
	@$usuario = $_SESSION['UsuarioIntroducido'];
	@$tipo = $_SESSION['tipo'];
	@$_SESSION['contador'] = 0;
	//Iniciamos el objeto templatePower y lo preparamo
	$template =  new TemplatePower("../templates/noticias.tpl");
	$template->prepare();

	// En este bloque, decidimos que menu mostrar, dependiendo de si hay un usuario conectado, y cual es su tipo

	if(!empty(@$nombre)){

		if($tipo == 1){
			$template->newBlock('menu1');
			$template->assign('nombre',$nombre);
			$template->newBlock('banner1');
			$template->assign('nombre',$nombre);
		}else{
			echo "<script>alert('Debes de estar con una cuenta normal para entrar aqui');</script>";
		}

	}else{

		$template->newBlock('menu0');
		$template->newBlock('error');
		$template->newBlock('banner0');

		if(isset($_POST['Enviar']) && !empty($_POST['username']) && !empty($_POST['password'])){

			@$_SESSION['contador'] = 0;

			$con = new MySQLDataSource();

			$con -> conectar();

			@$loginIndex = $_POST['username'];
			@$passIndex = $_POST['password'];
			@$passCif = md5($passIndex);

			$consulta = "SELECT Login, Password, Nombre, Tipo FROM `usuarios` WHERE Login = '".$loginIndex."' AND Password = '".$passCif."'";

			$newLogin = null;
			$incr = 0;
			$inicio = false;
			$con -> ejecutar_consulta($consulta);

			$fila = $con ->siguiente();

				if($fila){

					$newLogin[$incr] =  new usuario();

					$newLogin[$incr] -> setLogin($fila->Login);
					$newLogin[$incr] -> setPassword($fila->Password);
					$newLogin[$incr] -> setNombre($fila->Nombre);
					$newLogin[$incr] -> setTipo($fila->Tipo);


					$loginBD = $newLogin[$incr] -> getLogin();
					$passBD = $newLogin[$incr] -> getPassword();
					$nameBD = $newLogin[$incr] -> getNombre();
					$tipoBD = $newLogin[$incr] -> getTipo();
				}


				if((@$loginBD == @$loginIndex) && (@$passCif == @$passBD)){

					$_SESSION['nombreUsuario'] = $nameBD;
					$_SESSION['tipo'] = $tipoBD;
					$_SESSION['contador'] = 0;
					header("Location: login.php");
				}else{

					echo "<script>alert('Datos incorrectos');</script>";

				}

			$con->desconectar();
		}
	}

			$template->newBlock('noticias');
			$noticiaNueva = Null;
			$incr = 0;
			//Creacion del objeto MySQLDataSource
			$con = new MySQLDataSource();

			$con -> conectar();

			$consulta = "SELECT * FROM noticias WHERE publicado ='si'";

			$con -> ejecutar_consulta($consulta);

			$fila = $con -> siguiente();

			while($fila){

				$noticiaNueva[$incr] = new noticia();
				$noticiaNueva[$incr] -> setId($fila->ID);
				$noticiaNueva[$incr] -> setTitulo($fila->Titulo);
				$noticiaNueva[$incr] -> setDescripcion($fila->Descripcion);
				$noticiaNueva[$incr] -> setLink($fila->Link);
				$noticiaNueva[$incr] -> setImagen($fila->Imagen);

				//Ponemos en variables de sesion los datos obteniodos, para comprobarlo mas abajo
				$id = $noticiaNueva[$incr] -> getId();
				$titulo = $noticiaNueva[$incr] -> getTitulo();
				$descripcion = $noticiaNueva[$incr] -> getDescripcion();
				$link = $noticiaNueva[$incr] -> getLink();
				$imagen = $noticiaNueva[$incr] -> getImagen();

				$template->newBlock('lista');
				//Damos la informacion a las variables
				$template->assign('rutaImagen',$imagen);
				$template->assign('titulo',$titulo);
				$template->assign('descripcion',$descripcion);
				$template->assign('link',$link);

				$incr +=1;
				$fila = $con -> siguiente();

			}

		$template->newBlock('jquery');
		$template->printToScreen();


   ?>