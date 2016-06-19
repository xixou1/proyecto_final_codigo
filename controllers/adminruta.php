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

	$template =  new TemplatePower("../templates/adminruta.tpl");
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

		$listaRutas = Null;
		$incr = 0;

		//Creación del objeto MySQLDataSource
		$con = new MySQLDataSource();

		$con -> conectar();

		//Creamos la consulta

		$consulta = "SELECT * FROM rutas WHERE publicado='no'";

		$con -> ejecutar_consulta($consulta);
		$fila = $con -> siguiente();

		while($fila){

			$listaRutas[$incr] = new ruta();

			$listaRutas[$incr] -> setId($fila->ID);
			$listaRutas[$incr] -> setTitulo($fila->Titulo);
			$listaRutas[$incr] -> setDescripcion($fila->Descripcion);
			$listaRutas[$incr] -> setTexto($fila->Texto);
			$listaRutas[$incr] -> setDuracion($fila->Duracion);
			$listaRutas[$incr] -> setDistanciaTotal($fila->DistanciaTotal);
			$listaRutas[$incr] -> setAltitudMax($fila->AltitudMax);
			$listaRutas[$incr] -> setSalida($fila->Salida);
			$listaRutas[$incr] -> setFinal($fila->Final);
			$listaRutas[$incr] -> setDificultad($fila->Dificultad);
			$listaRutas[$incr] -> setLocalizacion($fila->Localizacion);
			$listaRutas[$incr] -> setPublicado($fila->publicado);
			$listaRutas[$incr] -> setAutor($fila->autor);


			$idBD = $listaRutas[$incr] -> getId();
			$tituloBD = $listaRutas[$incr] -> getTitulo();
			$descripcionBD = $listaRutas[$incr] -> getDescripcion();
			$textoBD = $listaRutas[$incr] -> getTexto();
			$duracionBD = $listaRutas[$incr] -> getDuracion();
			$distanciaBD = $listaRutas[$incr] -> getDistanciaTotal();
			$altitudBD = $listaRutas[$incr] -> getAltitudMax();
			$salidaBD = $listaRutas[$incr] -> getSalida();
			$finalBD = $listaRutas[$incr] -> getFinal();
			$dificultadBD = $listaRutas[$incr] -> getDificultad();
			$localizacionBD = $listaRutas[$incr] -> getLocalizacion();
			$publicadoBD = $listaRutas[$incr] -> getPublicado();
			$autorBD = $listaRutas[$incr] -> getAutor();

			$template->newBlock('datos');

			$template -> assign('Titulo', $tituloBD);
			$template -> assign('Descripcion', $descripcionBD);
			$template -> assign('Texto', $textoBD);
			$template -> assign('Duracion', $duracionBD);
			$template -> assign('DistanciaTotal', $distanciaBD);
			$template -> assign('AltitudMax', $altitudBD);
			$template -> assign('Salida', $salidaBD);
			$template -> assign('Final', $finalBD);
			$template -> assign('Dificultad', $dificultadBD);
			$template -> assign('Localizacion', $localizacionBD);
			$template -> assign('Publicado', $publicadoBD);
			$template -> assign('id',$idBD);
			$template -> assign('Autor', $autorBD);


			$fila = $con -> siguiente();
			$incr+=1;

		}






		$template -> newBlock('jquery');

		$template -> printToScreen();
?>