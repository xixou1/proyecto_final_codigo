<?php
	error_reporting(0);
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
	@$_SESSION['contador'] = 0;
	//Iniciamos el objeto templatePower y lo preparamo
	$template =  new TemplatePower("../templates/index.tpl");

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
			$template->assign('nombre',$nombre);
			$template->newBlock('banner1');
			$template->assign('nombre',$nombre);
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

					echo "<script>alert('Datos incorrectos');
                                              window.location='index.php'</script>";

				}

			$con->desconectar();
		}
	}

		$template->newBlock('rutas');

		//----------------  ZONA RUTA
			$con = new MySQLDataSource();

			$con -> conectar();

			$imagen = Null;

			$incr = 0;

			$rutaImagenCompleta = array();
			$contador = 0;
			$idBD = array();

			$consultaImagenes = "SELECT * FROM imagenes";

			$con -> ejecutar_consulta($consultaImagenes);

			$fila = $con ->siguiente();


			while($fila){

				$imagen[$incr] = new imagen();

				$imagen[$incr] -> setId($fila->ID);
				$imagen[$incr] -> setNombreArchivo($fila->nombreArchivo);
				$imagen[$incr] -> setCantidad($fila->cantidad);
				$imagen[$incr] -> setRutaCarpeta($fila->rutaCarpeta);

				$idBD[$contador] = $imagen[$incr] -> getId();
				$rutaCarpeta = $imagen[$incr] -> getRutaCarpeta();
				$nombreArchivo = $imagen[$incr] -> getNombreArchivo();
				$rutaImagenCompleta[$contador] = $rutaCarpeta.$nombreArchivo."0".".jpg";

				$incr+=1;
				$contador+=1;

				$fila = $con-> siguiente();
			}

			$con->desconectar();
			$con = new MySQLDataSource();

			$con -> conectar();

			$ruta = Null;

			$incrR = 0;

			$consultaRuta = "SELECT Titulo, Descripcion FROM rutas WHERE publicado='si'";

			$con -> ejecutar_consulta($consultaRuta);
			$fila = $con ->siguiente();

			while($fila){

				$ruta[$incrR] = new ruta();

				$ruta[$incrR] -> setTitulo($fila->Titulo);
				$ruta[$incrR] -> setDescripcion($fila->Descripcion);

				$titulo = $ruta[$incrR] -> getTitulo();
				$descripcion = $ruta[$incrR] -> getDescripcion();

				$template ->newBlock('infRutas');
				$template ->assign('id', $idBD[$incrR]);
				$template ->assign("imagen",$rutaImagenCompleta[$incrR]);
				$template ->assign("Titulo", $titulo);
				$template ->assign("descripcion",$descripcion);

				$incrR+=1;
				$fila = $con ->siguiente();

			}



			$con->desconectar();

		// ----- FIN ZONA RUTA

				// --- ZONA DE GALERIA

		$template->newBlock('galeria');

		$con = new MySQLDataSource();

		$con -> conectar();

		$consulta = "SELECT nombreArchivo, rutaCarpeta from imagenes";

		$imagenGaleria =  Null;
		$incrG = 0;

		$con -> ejecutar_consulta($consulta);
		$fila = $con -> siguiente();

		while($fila){

			$imagenGaleria[$incrG] =  new imagen();

			$imagenGaleria[$incrG] -> setNombreArchivo($fila->nombreArchivo);
			$imagenGaleria[$incrG] -> setRutaCarpeta($fila->rutaCarpeta);

			$nombreBD = $imagenGaleria[$incrG] -> getNombreArchivo();
			$rutaBD = $imagenGaleria[$incrG] -> getRutaCarpeta();

			$nombreArchivo = $rutaBD.$nombreBD."0.jpg";
			$template -> newBlock('datos');
			$template -> assign('url', $nombreArchivo);

			$incrG+=1;
			$fila = $con -> siguiente();

		}


		$con -> desconectar();




		// -- Fin zona Galeria
		$template->newBlock('jquery');


		//Pintamos los bloques
		$template->printToScreen();

?>