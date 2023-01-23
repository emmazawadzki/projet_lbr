<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddplanning_final";

// CONNEXION AVEC LA BASE DE DONNEE

$connexion = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connexion->connect_error) {
    die("Connection failed: " . $connexion->connect_error);
}

// RECUPERATION DES DONNEE JAVASCRIPT(APPUIE DE BOUTON)

$cases_id = $_GET["donnee2"];
$case_id_value = $_GET["donnee1"];


modif_bdd($connexion, $case_id_value, $cases_id);

function modif_bdd($connexion, $case_id_value, $cases_id)
{
    // On recupere l'id de la personne et l'heure auquel corrapond l'identitfiant du bouton

    $separation = explode("_", $cases_id);          // permet de diviser la chaine au niveau des tirets
    $idpersonne = trim($separation[0], "personne"); // permet de supprimer "personne"
    $idheure = trim($separation[1], "heures");      // permet de supprimer 'heures'
    $jour = trim($separation[2], "jour");

    // Recupération de l'ID du festival

    $sql0 = "SELECT festivalID FROM creneau_planning WHERE dates='$jour'";
    $result0 = $connexion->query($sql0);
    $donnee = mysqli_fetch_assoc($result0);
    $festival = $donnee["festivalID"];
    echo "<script>console.log(" . $festival . ")</script>";


    // METTRE UNE PERSONNE EN PAUSE 

    if ($case_id_value == "Pause") {

        $sql7 = "SELECT creneauID FROM creneau_planning WHERE heure='$idheure' AND  personneID='$idpersonne' AND dates='$jour'";
        $result7 = $connexion->query($sql7);

        // Si la personne n'était pas en pause, on entrera dans la condition

        if (mysqli_num_rows($result7) > 0) {
            $donnee7 = mysqli_fetch_assoc($result7);
            $creneau = $donnee7["creneauID"];

            $sql8 = "DELETE FROM creneau_planning WHERE creneauID = $creneau ";
            $result8 = $connexion->query($sql8);
            if ($connexion->query($sql8) === TRUE) {
                echo "mise en pause d'une personne";
            } else {
                echo "Error updating record";
            }
        }
    }

    // ATTRIBUER  UN LIEU A LA PERSONNE

    else if ($case_id_value != "Pause") {

        // SI LA PERSONNE ETAIT DEJA DANS UN AUTRE LIEU

        $sql4 = "SELECT creneauID, besoin_nb_benevole, besoin_nb_membre FROM creneau_planning WHERE heure='$idheure' AND dates='$jour' AND personneID='$idpersonne'";
        $result4 = $connexion->query($sql4);
        if (mysqli_num_rows($result4) > 0) {
            $donnee4 = mysqli_fetch_assoc($result4);
            $creneau = $donnee4["creneauID"];
            $besoin_nb_benevole = $donnee4["besoin_nb_benevole"];
            $besoin_nb_membre = $donnee4["besoin_nb_membre"];

            $sql5 = "SELECT lieuID FROM lieu WHERE nom_du_lieu='$case_id_value'";

            $result5 = $connexion->query($sql5);
            $donnee5 = mysqli_fetch_assoc($result5);
            $idlieu = $donnee5["lieuID"];

            $sql6 = "UPDATE creneau_planning SET lieuID='$idlieu' WHERE creneauID='$creneau'";

            if ($connexion->query($sql6) === TRUE) {
                echo "changement de lieu d'une personne";
            } else {
                echo "erreur de changement";
            }
        } else {
            // SI LA PERSONNE ETAIT EN PAUSE 

            // Recuperation d'info pour créer une nouvelle ligne de creneau
            $sql1 = "SELECT creneauID, besoin_nb_benevole, besoin_nb_membre FROM creneau_planning WHERE heure='$idheure' AND dates='$jour'";
            $result1 = $connexion->query($sql1);
            $donnee1 = mysqli_fetch_assoc($result1);

            $creneau = $donnee1["creneauID"];
            $besoin_nb_benevole = $donnee1["besoin_nb_benevole"];
            $besoin_nb_membre = $donnee1["besoin_nb_membre"];

            // Recuperation de l'ID du lieu choisi

            $sql2 = "SELECT lieuID FROM lieu WHERE nom_du_lieu='$case_id_value'";
            $result2 = $connexion->query($sql2);
            $donnee2 = mysqli_fetch_assoc($result2);
            $idlieu = $donnee2["lieuID"];

            // Création d'un nouvel ID du creneau

            $newcreneau = intval($creneau . $idpersonne);
            $idheure1 = intval($idheure);
            $besoin_nb_benevole1 = intval($besoin_nb_benevole);
            $besoin_nb_membre1 = intval($besoin_nb_membre);
            $idpersonne1 = intval($idpersonne);
            $idlieu1 = intval($idlieu);
            $festival1 = intval($festival);


            $sql3 = "INSERT INTO creneau_planning (creneauID, dates, heure, besoin_nb_benevole, besoin_nb_membre, personneID, lieuID, festivalID) VALUES ($newcreneau, '$jour', $idheure1, $besoin_nb_benevole1, $besoin_nb_membre1, $idpersonne1, $idlieu1, $festival1)";

            if ($connexion->query($sql3) === TRUE) {
                echo "mise au travail d'une personne";
            } else {
                echo "Nous n'avons pas pu attribuer de lieu à cette personne";
            }
        }
    }
}
