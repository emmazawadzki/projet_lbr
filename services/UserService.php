<?php

	// inclut les fonctions liées à la base de données
	include "DBService.php";

	$retrieve_data = false;

	// teste l'existence des paramètres passés dans l'URL
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	$personneID = isset($_GET['personneID']) ?$_GET['personneID'] : '';
	
	// connexion à la BD et récupération des informations de la personne
	if($action === 'getuser' && $personneID !== '') {
		$con = connectDB();
		$sql = "select * from personnes where personneID=" . $personneID;
		$retrieve_data = mysqli_query($con, $sql);
		closeDB($con);

		// retourne le résultat au format JSON pour faciliter la manipulation des données en javascript
		echo json_encode(mysqli_fetch_array($retrieve_data));
	}
	
	
?>