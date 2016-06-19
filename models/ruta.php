<?php

		class ruta {

			private $id;
			private $titulo;
			private $descripcion;
			private $texto;
			private $duracion;
			private $distanciaTotal;
			private $altitudMax;
			private $salida;
			private $final;
			private $dificultad;
			private $localizacion;
			private $publicado;
			private $autor;


			//id
			function setId($myId){

				$this ->ID = $myId;
			}

			function getId(){

				return $this->ID;
			}


			//Titulo
			function setTitulo($myTitulo){

				$this ->Titulo = $myTitulo;
			}

			function getTitulo(){

				return $this->Titulo;
			}

			//Descripcion
			function setDescripcion($myDescripcion){

				$this ->Descripcion = $myDescripcion;
			}

			function getDescripcion(){

				return $this->Descripcion;
			}

			//Texto
			function setTexto($myTexto){

				$this ->Texto = $myTexto;
			}

			function getTexto(){

				return $this->Texto;
			}

			//Duracion
			function setDuracion($myDuracion){

				$this ->Duracion = $myDuracion;
			}

			function getDuracion(){

				return $this->Duracion;
			}

			//DistanciaTotal
			function setDistanciaTotal($myDistanciaTotal){

				$this ->DistanciaTotal = $myDistanciaTotal;
			}

			function getDistanciaTotal(){

				return $this->DistanciaTotal;
			}

			//AltitudMax
			function setAltitudMax($myAltitudMax){

				$this ->AltitudMax = $myAltitudMax;
			}

			function getAltitudMax(){

				return $this->AltitudMax;
			}

			//Salida
			function setSalida($mySalida){

				$this ->Salida = $mySalida;
			}

			function getSalida(){

				return $this->Salida;
			}

			//Final
			function setFinal($myFinal){

				$this ->Final = $myFinal;
			}

			function getFinal(){

				return $this->Final;
			}

			//Dificultad
			function setDificultad($myDificultad){

				$this ->Dificultad = $myDificultad;
			}

			function getDificultad(){

				return $this->Dificultad;
			}

			//Localizacion
			function setLocalizacion($myLocalizacion){

				$this ->Localizacion = $myLocalizacion;
			}

			function getLocalizacion(){

				return $this->Localizacion;
			}

			//Publicado
			function setPublicado($myPublicado){

				$this ->publicado = $myPublicado;
			}

			function getPublicado(){

				return $this->publicado;
			}

			//Autor
			function setAutor($myAutor){

				$this ->autor = $myAutor;
			}

			function getAutor(){

				return $this->autor;
			}


		}


?>
