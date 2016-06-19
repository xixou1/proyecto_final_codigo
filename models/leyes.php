<?php

		class leyes {

			private $id;
			private $titulo;
			private $descripcion;
			private $link;



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

			//Link
			function setLink($myLink){

				$this ->Link = $myLink;
			}

			function getLink(){

				return $this->Link;
			}

		}


?>