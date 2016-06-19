<?php
    session_start();
// Hacemos los includes necesarios
    include_once("funciones.php");
    include_once("../models/usuario.php");
    include_once("../models/MySQLDataSource.php");
    include_once("../template_power/TemplatePower.php");


	//Variables de sesion, para saber tipo y login de la persona coenctada
	@$nombre = $_SESSION['nombreUsuario'];
	@$usuario = $_SESSION['UsuarioIntroducido'];
	@$tipo = $_SESSION['tipo'];

	//Iniciamos el objeto templatePower y lo preparamo
	$template = new TemplatePower("../templates/nuevaruta.tpl");


	$template->prepare();

   	 	//Control de seguridad, para que pueda entrar la gente que tenga el derecho
   	if(empty(@$nombre)){

		echo "<script type='text/javascript'>
		alert('No puedes entrar aqui si no estas registrado');
		window.location.href = 'index.php';
		</script>";
	}elseif($tipo==2){
		echo "<script type='text/javascript'>
		alert('No puedes entrar aqui si no eres un usuario normal y estas registrado');
		window.location.href = 'index.php';
		</script>";
	}else{

		 $template->newBlock('menu1');
		 $template->newBlock("banner1");
		 $template->newBlock('subida');

		@$titulo = $_POST['titulo'];
		@$descripcion = $_POST['descripcion'];
		@$duracion = $_POST['duracion'];
		@$texto = $_POST['texto'];
		@$distanciaTotal = $_POST['distanciaTotal'];
		@$altitudMax = $_POST['altitudMax'];
		@$salida = $_POST['salida'];
		@$final = $_POST['final'];
		@$dificultad = $_POST['dificultad'];
		@$localizacion = $_POST['localizacion'];

		$con = new MySQLDataSource();

		$con -> conectar();


		@$enviar = $_POST['Subida'];

		if(isset($_POST['Subida'])){

			$nombreCarpeta = str_replace(" ", "-", $titulo);

			listarARchivos($_FILES['fichero']['tmp_name'], $nombreCarpeta);
			$cantidad = contarImagenes($_FILES['fichero']['tmp_name']);

			$consulta = "INSERT INTO `imagenes`(nombreArchivo, cantidad, rutaCarpeta) VALUES ('img','".$cantidad."','img/rutas/".$nombreCarpeta."/')";

			$con -> ejecutar_consulta($consulta);


			$consulta2 = "INSERT INTO `rutas`(Titulo, Descripcion, Texto, Duracion, DistanciaTotal, AltitudMax, Salida, Final, Dificultad, Localizacion, publicado, autor) VALUES ('".$titulo."','".$descripcion."','".$texto."','".$duracion."','".$distanciaTotal."','".$altitudMax."','".$salida."','".$final."','".$dificultad."','".$localizacion."','no','".$nombre."')";

			$con -> ejecutar_consulta($consulta2);
		}




	$template->newBlock('jquery');
	//Pintamos los bloques
	$template->printToScreen();

}

?>