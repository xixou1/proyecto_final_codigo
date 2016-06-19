<?php
	#error_reporting(0);
	// Hacemos los includes necesarios
    include_once("../models/usuario.php");
    include_once("../models/imagen.php");
    include_once("../models/noticia.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");
    include_once("funciones.php");
    session_start();

	//Variables de sesion, para saber tipo y login de la persona coenctada
	@$nombre = $_SESSION['nombreUsuario'];
	@$usuario = $_SESSION['UsuarioIntroducido'];
	@$tipo = $_SESSION['tipo'];
	@$id = $_SESSION['id'];

	$template =  new TemplatePower("../templates/adminnoticia.tpl");
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

		$listaNoticias = Null;
		$incr = 0;

		//Creación del objeto MySQLDataSource
		$con = new MySQLDataSource();

		$con -> conectar();

		//Creamos la consulta

		$consulta = "SELECT * FROM noticias WHERE publicado='no'";

		$con -> ejecutar_consulta($consulta);
		$fila = $con -> siguiente();

		while($fila){

			$listaNoticias[$incr] = new noticia();

			$listaNoticias[$incr] -> setId($fila->ID);
			$listaNoticias[$incr] -> setTitulo($fila->Titulo);
			$listaNoticias[$incr] -> setDescripcion($fila->Descripcion);
			$listaNoticias[$incr] -> setLink($fila->Link);
			$listaNoticias[$incr] -> setImagen($fila->Imagen);
			$listaNoticias[$incr] -> setPublicado($fila->publicado);


			$idBD = $listaNoticias[$incr] -> getId();
			$tituloBD = $listaNoticias[$incr] -> getTitulo();
			$descripcionBD = $listaNoticias[$incr] -> getDescripcion();
			$linkBD = $listaNoticias[$incr] -> getLink();
			$imagenBD = $listaNoticias[$incr] -> getImagen();
			$publicadoBD = $listaNoticias[$incr] -> getPublicado();

			$template->newBlock('datos');

			$template -> assign('Titulo', $tituloBD);
			$template -> assign('Descripcion', $descripcionBD);
			$template -> assign('Link', $linkBD);
			$template -> assign('imagen', $imagenBD);
			$template -> assign('Publicado', $publicadoBD);
			$template -> assign('id',$idBD);


			$fila = $con -> siguiente();
			$incr+=1;

		}






		$template -> newBlock('jquery');

		$template -> printToScreen();
?>