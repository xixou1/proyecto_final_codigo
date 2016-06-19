<?php

	Class MySQLDataSource {

		private $conexion;
		private $querys;
		private $dev;




			function conectar(){

			$host = 'localhost';
			$user = 'root';
			$password = '';
			$nombreBD = 'senderos_mallorca';

			if(!$this -> conexion){

				$this -> conexion = mysqli_connect($host,$user,$password) or die(mysqli_error());
				mysqli_set_charset($this->conexion,"utf8");


				$bd = mysqli_select_db($this->conexion,$nombreBD);
				

					if(!$bd){

						echo "No se ha encontrado la base de datos ";

					}else{

						

					}
				}
			
			}



			function desconectar(){


				mysqli_close($this->conexion);

			}

			function ejecutar_consulta($consulta){

			$this->querys = mysqli_query($this->conexion,$consulta);

			}


			function siguiente(){

			$this->dev = mysqli_fetch_object($this->querys);

			return $this->dev;

			}

			function mensajeError(){


			}

		private function RegError(){

			$fallo = mysql_error();

			$fp = fopen("Log_Errores.txt","a");
			fwrite($fp,"|",date("d/m/Y H:i:s"),"]");

		}
	}


/*

	while ($row = mysqli_fetch_array($resultado,MYSQLI_ASSOC)){

				printf("Nombre: %s",$row["Marca"]);

				}
				
				mysqli_free_result($resultado);

*/
?>
