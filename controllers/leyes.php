	<?php

// Hacemos los includes necesarios
    include_once("../models/usuario.php");
    include_once("../models/leyes.php");
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
	$template =  new TemplatePower("../templates/leyes.tpl");
	$template->prepare();

	// En este bloque, decidimos que menu mostrar, dependiendo de si hay un usuario conectado, y cual es su tipo
		if(!empty(@$nombre)){

			if($tipo == 1){
				$template->newBlock('menu1');
				$template->assign('nombre',$nombre);
				$template->newBlock('banner1');
				$template->assign('nombre',$nombre);
			}else{
				$template->newBlock('menu2');
				$template->newBlock('banner1');
				$template->assign('nombre',$nombre);
			}

		}else{
			$template->newBlock('menu0');
			$template->newBlock('banner0');
		}

			$template->newBlock('leyes');
			$leyes = Null;
			$incr = 0;
			//Creacion del objeto MySQLDataSource
			$con = new MySQLDataSource();

			$con -> conectar();

			$consulta = "SELECT * FROM Leyes";

			$con -> ejecutar_consulta($consulta);

			$fila = $con -> siguiente();

			while($fila){

				$leyes[$incr] = new leyes();
				$leyes[$incr] -> setId($fila->ID);
				$leyes[$incr] -> setTitulo($fila->Titulo);
				$leyes[$incr] -> setDescripcion($fila->Descripcion);
				$leyes[$incr] -> setLink($fila->Link);

				//Ponemos en variables de sesion los datos obteniodos, para comprobarlo mas abajo
				$id = $leyes[$incr] -> getId();
				$titulo = $leyes[$incr] -> getTitulo();
				$descripcion = $leyes[$incr] -> getDescripcion();
				$link = $leyes[$incr] -> getLink();

				$template->newBlock('lista');
				//Damos la informacion a las variables
				$template->assign('titulo',$titulo);
				$template->assign('descripcion',$descripcion);
				$template->assign('link',$link);

				$incr +=1;
				$fila = $con -> siguiente();

			}

		$template->newBlock('jquery');
		$template->printToScreen();


   ?>