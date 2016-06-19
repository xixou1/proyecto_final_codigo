<?php
		
		class imagen {

			private $id;
			private $nombreArchivo;
			private $cantidad;
			private $rutaCarpeta;


			//id
			function setId($myId){

				$this ->ID = $myId;
			}

			function getId(){

				return $this->ID;
			}


			//nombreArchivo
			function setNombreArchivo($myNombreArchivo){

				$this ->nombreArchivo = $myNombreArchivo;
			}

			function getNombreArchivo(){

				return $this->nombreArchivo;
			}

			//Cantidad
			function setCantidad($myCantidad){

				$this ->cantidad = $myCantidad;
			}

			function getCantidad(){

				return $this->cantidad;
			}

			//rutaCarpeta
			function setRutaCarpeta($myRutaCarpeta){

				$this ->rutaCarpeta = $myRutaCarpeta;
			}

			function getRutaCarpeta(){

				return $this->rutaCarpeta;
			}
			
		}


?>