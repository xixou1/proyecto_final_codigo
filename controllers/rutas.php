<?php
	#error_reporting(0);
	// Hacemos los includes necesarios
    include_once("../models/usuario.php");
    include_once("../models/imagen.php");
    include_once("../models/ruta.php");
    include_once("../models/comentario.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");
    include_once("funciones.php");
    session_start();

	//Variables de sesion, para saber tipo y login de la persona coenctada
	@$nombre = $_SESSION['nombreUsuario'];
	@$usuario = $_SESSION['UsuarioIntroducido'];
	@$tipo = $_SESSION['tipo'];
	@$id = $_SESSION['id'];

	$template =  new TemplatePower("../templates/rutas.tpl");
	$template->prepare();


	if(empty($nombre)){

		echo "<script language='javascript'>alert('Debes estar registrado para entrar aqui')</script>";
		echo "<script language='javascript'>window.location='index.php'</script>";

	}else{

			if($tipo == 1){
				$template->newBlock('menu1');
				$template->assign('nombre',$nombre);
			}else{
				$template->newBlock('menu2');
				$template->assign('nombre',$nombre);
			}

	}
		$id = $_SESSION['id'];

		$rutaNueva = Null;
		$incr = 0;

		//Creación del objeto MySQLDataSource
		$con = new MySQLDataSource();

		$con -> conectar();

		//Creamos la consulta

		$consulta = "SELECT * FROM rutas WHERE ID = '".$id."'";

		$con -> ejecutar_consulta($consulta);
		$fila = $con -> siguiente();

		if($fila){

			$rutaNueva[$incr] = new ruta();

			$rutaNueva[$incr] -> setId($fila->ID);
			$rutaNueva[$incr] -> setTitulo($fila->Titulo);
			$rutaNueva[$incr] -> setDescripcion($fila->Descripcion);
			$rutaNueva[$incr] -> setTexto($fila->Texto);
			$rutaNueva[$incr] -> setDuracion($fila->Duracion);
			$rutaNueva[$incr] -> setDistanciaTotal($fila->DistanciaTotal);
			$rutaNueva[$incr] -> setAltitudMax($fila->AltitudMax);
			$rutaNueva[$incr] -> setSalida($fila->Salida);
			$rutaNueva[$incr] -> setFinal($fila->Final);
			$rutaNueva[$incr] -> setDificultad($fila->Dificultad);
			$rutaNueva[$incr] -> setLocalizacion($fila->Localizacion);


			$idBD = 			$rutaNueva[$incr] -> getId($fila->ID);
			$tituloBD = $rutaNueva[$incr] -> getTitulo($fila->Titulo);
			$descripcionBD = $rutaNueva[$incr] -> getDescripcion($fila->Descripcion);
			$textoBD = $rutaNueva[$incr] -> getTexto($fila->Texto);
			$duracionBD = $rutaNueva[$incr] -> getDuracion($fila->Duracion);
			$distanciaBD = $rutaNueva[$incr] -> getDistanciaTotal($fila->DistanciaTotal);
			$altitudBD = $rutaNueva[$incr] -> getAltitudMax($fila->AltitudMax);
			$salidaBD = $rutaNueva[$incr] -> getSalida($fila->Salida);
			$finalBD = $rutaNueva[$incr] -> getFinal($fila->Final);
			$dificultadBD = $rutaNueva[$incr] -> getDificultad($fila->Dificultad);
			$localizacionBD = $rutaNueva[$incr] -> getLocalizacion($fila->Localizacion);

		}

			//Rellenamos los campos

			$template -> newBlock('bannerRuta');
			$template -> assign('Titulo', $tituloBD);
			$template -> assign('Descripcion', $descripcionBD);

			$template -> newBlock('infRutas');
			$template -> assign('Titulo', $tituloBD);
			$template -> assign('Localizacion', $localizacionBD);
			$template -> assign('altitudMax', $altitudBD);
			$template -> assign('duracion', $duracionBD);
			$template -> assign('salida', $salidaBD);
			$template -> assign('llegada', $finalBD);

			$template -> newBlock('texto');
			$template -> assign('Texto', $textoBD);

			$con -> desconectar();

			$con = new MySQLDataSource();
			$con -> conectar();

			//Aqui está la zona de los comentarios
			$template ->newBlock('comentarios');
			$comentarios = Null;
			$incrCom = 0;

			$consultaComentarios ="SELECT * FROM comentarios WHERE idRuta ='".$id."'";

			$con -> ejecutar_consulta($consultaComentarios);
			$fila = $con ->siguiente();

			while($fila){

				$comentarios[$incrCom] = new comentario();

				$comentarios[$incrCom] -> setId($fila->ID);
				$comentarios[$incrCom] -> setLogin($fila->Login_C);
				$comentarios[$incrCom] -> setFecha($fila->Fecha);
				$comentarios[$incrCom] -> setTexto($fila->Texto);
				$comentarios[$incrCom] -> setIdruta($fila->idRuta);



				$idBD = $comentarios[$incrCom] -> getId();
				$comentLogin = $comentarios[$incrCom] -> getLogin();
				$fechaBD = $comentarios[$incrCom] -> getFecha();
				$textoComentBD = $comentarios[$incrCom] -> getTexto();

				$template ->newBlock('datos');
				$template ->assign('usuarioComentario', $comentLogin);
				$template ->assign('textoComentario',$textoComentBD);
				$template ->assign('fecha',$fechaBD);

				$incrCom+=1;
				$fila = $con->siguiente();

			}

			$template -> newBlock('Formcomentarios');
			$template -> assign('nombre', $nombre);

			$fecha =  date("Y/m/d");
			@$textoComent = $_POST['texto'];
			//Zona de envio de comentarios
			if(isset($_POST['Enviar'])){

				$consulta = "INSERT INTO comentarios (Login_C, Fecha, Texto, idRuta) VALUES ('".$nombre."','".$fecha."','".$textoComent."','".$id."')";
				$con -> ejecutar_consulta($consulta);
			}






			$con -> desconectar();

			$con = new MySQLDataSource();
			$con -> conectar();

			// Cargamos las imagenes
			$imagen = Null;

			$incr1 = 0;

			//Cargamos el bloque de la galeria

			$template -> newBlock('galeria');

			$consultaImagenes = "SELECT * FROM imagenes WHERE ID = '".$id."'";

			$con -> ejecutar_consulta($consultaImagenes);

			$fila = $con ->siguiente();

			if($fila){

				$imagen[$incr1] = new imagen();

				$imagen[$incr1] -> setId($fila->ID);
				$imagen[$incr1] -> setNombreArchivo($fila->nombreArchivo);
				$imagen[$incr1] -> setCantidad($fila->cantidad);
				$imagen[$incr1] -> setRutaCarpeta($fila->rutaCarpeta);

				$idBD = $imagen[$incr1] -> getId();
				$cantidadBD = $imagen[$incr1] -> getCantidad();
				$rutaCarpeta = $imagen[$incr1] -> getRutaCarpeta();
				$nombreArchivo = $imagen[$incr1] -> getNombreArchivo();

			}


				while($incr1 < $cantidadBD){

				$rutaImagenCompleta = $rutaCarpeta.$nombreArchivo.$incr1.".jpg";
				//Creamos el bloque que se va a repetir por cada imagen
				$template -> newBlock('listaImagen');
				$template -> assign('url', $rutaImagenCompleta);
				$template -> assign('descripcion', $descripcionBD);
				$template -> assign('Titulo', $tituloBD);

				$incr1 +=1;
			}

		$template -> newBlock('jquery');

		$template -> printToScreen();
?>