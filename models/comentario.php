<?php

		class comentario {

			private $id;
			private $login;
			private $fecha;
			private $texto;
			private $idRuta;


			//id
			function setId($myId){

				$this ->ID = $myId;
			}

			function getId(){

				return $this->ID;
			}

			//login
			function setlogin($myLogin){

				$this ->login = $myLogin;
			}

			function getLogin(){

				return $this->login;
			}

			//Fecha
			function setFecha($myFecha){

				$this ->Fecha = $myFecha;
			}

			function getFecha(){

				return $this->Fecha;
			}

			//Texto
			function setTexto($myTexto){

				$this ->Texto = $myTexto;
			}

			function getTexto(){

				return $this->Texto;
			}
			//Idruta
			function setIdruta($myIdruta){

				$this ->Idruta = $myIdruta;
			}

			function getIdruta(){

				return $this->Idruta;
			}


		}


?>