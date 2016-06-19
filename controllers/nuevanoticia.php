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
	$template = new TemplatePower("../templates/nuevanoticia.tpl");


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
		@$link = $_POST['link'];


		$con = new MySQLDataSource();

		$con -> conectar();


		@$enviar = $_POST['Subida'];

		if(isset($_POST['Subida'])){


			$consultaNumeroNoticias = "SELECT * FROM noticias ";

			$con -> ejecutar_consulta($consultaNumeroNoticias);

			$fila = $con -> siguiente();

			$contador = 0;

			while($fila){

				$contador+=1;
				$fila = $con -> siguiente();
			}

			echo $contador;

			// Zona fichero Nuevo

			$contadorNuevo = $contador +1;

					if(is_uploaded_file($_FILES['fichero']['tmp_name'])){

					$nombreDirectorio = "img/noticias/";
			       	$nombreFichero = "img".$contadorNuevo.".jpg";
			       	$nombreCompleto = $nombreDirectorio.$nombreFichero;
			       		if (is_dir($nombreDirectorio)){  // es un directorio existente
			            	$nombreCompleto = $nombreDirectorio.$nombreFichero;
			            	move_uploaded_file ($_FILES['fichero']['tmp_name'],$nombreCompleto);
			            	$cambiarAvatar = true;

			        	}
			        	else{
			        		 echo "Directorio definitivo inválido";
			         	}
					}

			// Fin zona fichero

			$consulta = "INSERT INTO noticias (Titulo, Descripcion, Link, Imagen, publicado) VALUES ('".$titulo."','".$descripcion."','".$link."','".$nombreCompleto."','no')";

			$con -> ejecutar_consulta($consulta);

		}




	$template->newBlock('jquery');
	//Pintamos los bloques
	$template->printToScreen();

}

?>
