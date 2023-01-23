<?php

$q = $_GET["q"];
choix_lieux($q);

function choix_lieux($identite)
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bddplanning_final";
  // Create connection
  $connexion = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($connexion->connect_error) {
    die("Connection failed: " . $connexion->connect_error);
  }
  // On recupere l'id de la personne et l'heure auquel corrapond l'ientitfiant du bouton
  $separation = explode("_", $identite);          // permet de diviser la chaine au niveau des tirets
  $idpersonne = trim($separation[0], "personne"); // permet de supprimer "personne"
  $idheure = trim($separation[1], "heures");      // permet de supprimer 'heures'
  $jour = trim($separation[2], "jour");



  // En fonction de la date, on va pouvoir savoir à quel festivalID ca correspond

  $sql4 = "SELECT festivalID FROM creneau_planning  WHERE dates='$jour'";
  $result4 = $connexion->query($sql4);
  if (mysqli_num_rows($result4) > 0) {
    while ($donnee = mysqli_fetch_assoc($result4)) {
      $festival = $donnee["festivalID"];
    }
    // Recherchons la categorie de la personne selectionnée

    $sql5 = "SELECT categorie, nom, prenom FROM personnes WHERE personneID='$idpersonne'";
    $result5 = $connexion->query($sql5);
    if (mysqli_num_rows($result5) > 0) {
      while ($donnee = mysqli_fetch_assoc($result5)) {
        $categorie = $donnee["categorie"];
        $nom = $donnee["nom"];
        $prenom = $donnee["prenom"];
      }

      echo "<table  class='table_lieu'border= '1' colspan='1'>";
      echo "<p style='color:white;padding:0;margin:0;font-size:0.8rem; font-weight:bold;text-align:center;'>" . $nom . " " . $prenom . " à " . $idheure . "h</p>";
      echo "<thead>";
      echo "<tr>";
      echo "<th>Lieux disponibles </th>";
      echo "<th>manque en " . $categorie . "</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody id='lieu_dispo'>";
      echo "<tr>";
      echo "<td> <input style=' background-color:#A3A3A3' class='lieu_dispo' type='button' value='Pause' id='btn0'></td>";
      echo "<td> </td>";
      echo "</tr>";


      //LA PERSONNE EST UN MEMEBRE

      if ($categorie == "membre") {

        // Recherche des lieux où il manque des membres 

        $sql5 = "SELECT DISTINCT lieuID, besoin_nb_membre FROM creneau_planning  WHERE heure='$idheure' AND dates='$jour'";
        $result5 = $connexion->query($sql5);
        $idbouton = 1;
        if (mysqli_num_rows($result5) > 0) {
          while ($donnee = mysqli_fetch_assoc($result5)) {

            $idlieu = $donnee["lieuID"];
            $nb_membre_necessaire = $donnee["besoin_nb_membre"];

            // Calcul du nombre de personne dans le lieu

            $sql6 = "SELECT COUNT(personneID) AS nb_membre_dans_lieu FROM creneau_planning WHERE heure='$idheure' and lieuID='$idlieu' AND dates='$jour'";
            $result6 = $connexion->query($sql6);
            $donnee6 = mysqli_fetch_assoc($result6);
            $nb_membre_dans_lieu = $donnee6["nb_membre_dans_lieu"];
            $manque = $nb_membre_necessaire - $nb_membre_dans_lieu;


            if ($manque > 0) {

              //Récupère le nom du lieu correspondant à l'id selectionné

              $sql06 = "SELECT nom_du_lieu, couleur_lieu FROM lieu WHERE lieuID='$idlieu'";
              $result06 = $connexion->query($sql06);
              $donnee06 = mysqli_fetch_assoc($result06);
              $nomlieu = $donnee06["nom_du_lieu"];
              $couleur_lieu = $donnee06["couleur_lieu"];
              echo "<tr>";
              echo "<td> <input style=' background-color:" . $couleur_lieu . "; color: white;' class='lieu_dispo' type='button' value=" . $nomlieu . " id='btn" . $idbouton . "'></td>";
              echo "<td>" . $manque . "</td>";
              echo "</tr>";
            }
            $idbouton++;
          }
        }
        echo "</tbody>";
        echo "</table>";

        echo "<table class='table_info' border='1' colspan='2'>";
        echo "<tbody>";

        //on va verifier si le membre  travaille deja dans un lieu

        $sql7 = "SELECT lieuID FROM creneau_planning WHERE personneID= '$idpersonne' and heure='$idheure' and dates=$jour";
        $result7 = $connexion->query($sql7);

        // membre en pause

        if (mysqli_num_rows($result7) == 0) {

          // On va chercher le nombre d'heure que le membre a travaillé dans la journée

          $sql8 = "SELECT COUNT(lieuID) AS nombre_heure_par_jour  FROM creneau_planning WHERE  personneID='$idpersonne' AND dates='$jour'";
          $result8 = $connexion->query($sql8);
          $donnee8 = mysqli_fetch_assoc($result8);
          $nombre_heure_par_jour = $donnee8["nombre_heure_par_jour"];
          echo "<tr>";
          echo "<td> nombre d'heure de travail dans la journee </td>";
          echo "<td>" . $nombre_heure_par_jour . " h</td>";
          echo "</tr>";
        }

        // membre occupé
        else {
          while ($donnee = mysqli_fetch_assoc($result7)) {
            $lieu = $donnee["lieuID"];
          }
          $sql9 = "SELECT COUNT(heure) AS nombre_heure_dans_le_lieu  FROM creneau_planning WHERE personneID='$idpersonne'and lieuID='$lieu' and dates='$jour'";
          $result9 = $connexion->query($sql9);
          $donnee9 = mysqli_fetch_assoc($result9);
          $nombre_heure_dans_lieu = $donnee9["nombre_heure_dans_le_lieu"];
          echo "<tr>";
          echo "<td> nombre d'heure dans le lieu </td>";
          echo "<td>" . $nombre_heure_dans_lieu . " h</td>";
          echo "</tr>";
        }
        //on va chercher le nombre d'heure total travaillées durant tout le festival

        $sql80 = "SELECT COUNT(lieuID) AS nombre_heure_total  FROM creneau_planning WHERE  personneID='$idpersonne'  AND festivalID='$festival' GROUP BY festivalID";
        $result80 = $connexion->query($sql80);
        $donnee80 = mysqli_fetch_assoc($result80);
        $nombre_heure_total = $donnee80["nombre_heure_total"];
        echo "<tr>";
        echo "<td> nombre total d'heure de travail </td>";
        echo "<td>" . $nombre_heure_total . " h</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
      }

      // LA PERSONNE EST UN BENEVOLE

      elseif ($categorie == "benevole") {

        // Recherche des lieux où il manque des benevoles

        $sql10 = "SELECT DISTINCT lieuID, besoin_nb_benevole	 FROM  creneau_planning  WHERE  heure='$idheure' and dates='$jour'";
        $result10 = $connexion->query($sql10);
        $idbouton = 1;
        if (mysqli_num_rows($result10) > 0) {
          while ($donnee = mysqli_fetch_assoc($result10)) {

            $idlieu = $donnee["lieuID"];
            $nb_benevole_necessaire = $donnee["besoin_nb_benevole"];

            //Recherche du nombre de personne dans le lieu 

            $sql11 = "SELECT COUNT(personneID) AS  nb_benevole_dans_lieu FROM creneau_planning WHERE heure='$idheure' and lieuID='$idlieu' and dates='$jour'";
            $result11 = $connexion->query($sql11);
            $donnee11 = mysqli_fetch_assoc($result11);
            $nb_benevole_dans_lieu = $donnee11["nb_benevole_dans_lieu"];
            $manque = $nb_benevole_necessaire - $nb_benevole_dans_lieu;


            if ($manque > 0) {
              // On recupere le nom du lieu correspondant à l'ID

              $sql011 = "SELECT nom_du_lieu FROM lieu WHERE lieuID='$idlieu'";
              $result011 = $connexion->query($sql011);
              $donnee011 = mysqli_fetch_assoc($result011);
              $nomlieu = $donnee011["nom_du_lieu"];
              echo "<tr>";
              echo "<td> <input class='lieu_dispo' type='button' value=" . $nomlieu . " id='btn" . $idbouton . "'></td>";
              echo "<td>" . $manque . "</td>";
              echo "</tr>";
            }
            $idbouton++;
          }
          echo "</tbody>";
          echo "</table>";
        }

        echo "<table class='table_info' border='1' colspan='2'>";
        echo "<tbody>";

        //on va verifier s'il travaille deja dans un lieu

        $sql12 = "SELECT lieuID FROM creneau_planning WHERE personneID='$idpersonne' and heure='$idheure' and dates='$jour'";
        $result12 = $connexion->query($sql12);

        // Benevole en pause

        if (mysqli_num_rows($result12) == 0) {

          // On va chercher le nombre d'heure qu'il a travaillé dans la journée

          $sql13 = "SELECT COUNT(lieuID) AS nombre_heure_par_jour FROM creneau_planning WHERE  personneID='$idpersonne' and dates='$jour'";
          $result13 = $connexion->query($sql13);
          $donnee13 = mysqli_fetch_assoc($result13);
          $nombre_heure_par_jour = $donnee13["nombre_heure_par_jour"];
          echo "<tr>";
          echo "<td> nombre d'heure de travail dans la journee </td>";
          echo "<td>" . $nombre_heure_par_jour . " h</td>";
          echo "</tr>";
        }

        // Benevole occupé
        else {
          while ($donnee = mysqli_fetch_assoc($result12)) {
            $lieu = $donnee["lieuID"];
          }
          // On va voir combien d'heure il a passé deja dans le lieu

          $sql14 = "SELECT COUNT(heure) AS  nombre_heure_dans_le_lieu FROM creneau_planning WHERE personneID='$idpersonne' and lieuID='$lieu' and dates='$jour'";
          $result14 = $connexion->query($sql14);
          $donnee14 = mysqli_fetch_assoc($result14);
          $nombre_heure_dans_le_lieu = $donnee14["nombre_heure_dans_le_lieu"];
          echo "<tr>";
          echo "<td> nombre d'heure dans le lieu </td>";
          echo "<td>" . $nombre_heure_dans_le_lieu . " h</td>";
          echo "</tr>";
        }

        // NOMBRE D'HEURE QU'IL RESTE A TRAVAILLER

        // Nombre d'heure total de travail durant le festival
        $sql140 = "SELECT COUNT(lieuID) AS nombre_heure_total  FROM creneau_planning WHERE  personneID='$idpersonne'  AND festivalID='$festival' GROUP BY festivalID";
        $result140 = $connexion->query($sql140);
        $donnee140 = mysqli_fetch_assoc($result140);
        $nombre_heure_total = $donnee140["nombre_heure_total"];

        //Nombre d'heure qu'un benevole doit realiser durant le festival

        $sql014 = "SELECT	nombre_heure_a_travailler	FROM configuration WHERE festivalID='$festival'";
        $result014 = $connexion->query($sql014);
        $donnee014 = mysqli_fetch_assoc($result014);
        $nombre_heure_à_travailler = $donnee014["nombre_heure_a_travailler"];

        $reste = $nombre_heure_à_travailler - $nombre_heure_total;
        echo "<tr>";
        echo "<td> Reste d'heures à travailler  </td>";
        echo "<td>" . $reste . " h</td>";
        echo "</tr>";

        echo "</tbody>";
        echo "</table>";
      }
    }
  }
}
