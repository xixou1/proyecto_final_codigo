<?php
		
		class usuario {

			private $id;
			private $login;
			private $password;
			private $nombre;
			private $email;
			private $avatar;
			private $tipo;

			//ID
			function setId($myId){
				$this ->ID = $myId;
			}

			function getId(){
				return $this ->ID;
			}

			//login
			function setLogin($myLogin){

				$this ->login = $myLogin;
			}

			function getLogin(){

				return $this->login;
			}


			//password
			function setPassword($myPassword){

				$this ->password = $myPassword;
			}

			function getPassword(){

				return $this->password;
			}

			//nombre
			function setNombre($myNombre){

				$this ->nombre = $myNombre;
			}

			function getNombre(){

				return $this->nombre;
			}

			//email
			function setEmail($myEmail){

				$this ->email = $myEmail;
			}

			function getEmail(){

				return $this->email;
			}

			//avatar
			function setAvatar($myAvatar){

				$this ->avatar = $myAvatar;
			}

			function getAvatar(){

				return $this->avatar;
			}

			//tipo
			function setTipo($myTipo){

				$this ->tipo = $myTipo;
			}

			function getTipo(){

				return $this->tipo;
			}


		}


?>