<?php

	function listarArchivos($ruta, $nombreCarpeta){
		$archivo = array();
		$archivosFormu = $ruta;

		if (!file_exists('img/rutas/'.$nombreCarpeta.'/')) {
		    mkdir('img/rutas/'.$nombreCarpeta.'/', 0777, true);
		}

		if(is_array($archivosFormu)){
			for ($i = 0; $i < count($archivosFormu); ++$i) {
						if(is_uploaded_file($archivosFormu[$i])){

						$nombreDirectorio = "img/rutas/".$nombreCarpeta."/";
				       	$nombreFichero = "img".$i.".jpg";
				       	$nombreCompleto = $nombreDirectorio.$nombreFichero;

				       		if (is_dir($nombreDirectorio)){  // es un directorio existente
				            	$nombreCompleto = $nombreDirectorio.$nombreFichero;
				            	move_uploaded_file ($archivosFormu[$i],$nombreCompleto);
				            	$cambiarAvatar = true;

				        	}
				        	else{
				        		 echo "Directorio definitivo inválido";
				         	}
						}
				}
            }else{
            	$archivo[] = $archivosFormu;
            }

	}


	function contarImagenes($ruta){
		$archivo = array();
		$archivosFormu = $ruta;
		$contador = 0;

		if(is_array($archivosFormu)){
			for ($i = 0; $i < count($archivosFormu); ++$i) {
				$contador = $i;
				}
            }

            return $contador;

	}


?>