<?php

	// fonction qui retourne une connexion à la base de données
	function connectDB() {
		$host = "localhost"; /* nom de l'host */
		$user = "root"; /* utilisateur */
		$password = ""; /* mot de passe */
		$dbname = "bddplanning_final"; /* nom de la base*/

		$con = mysqli_connect($host, $user, $password,$dbname);

		if (!$con) {
		   die("connexion échouée: " . mysqli_connect_error());
		}
		
		return $con;
	}
	
	// fonction qui permet de fermer la connexion à la base de données
	function closeDB($con) {
		mysqli_close($con);
	}

?>