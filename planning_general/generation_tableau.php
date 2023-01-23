<?php
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
?>

<div style="height: 81%;position: fixed;width:100%;">
    <div class="popup" style="overflow: auto; height:65%; margin-left:0; padding-left:0;margin-top: 14%;">
        <table class="planning-style">
            <thead class="heure" style="position:sticky;top:0; background-color: black;">
                <tr id=tete>
                    <th> </th>
                    <?php
                    // Création de la ligne des heures 
                    for ($indice_col = 0; $indice_col <= 23; $indice_col++) {
                        echo "<th>" . $indice_col . "h </th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody id="body">
                <div id='tableau'>
                    <?php
                    $q = $_GET["s"];
                    generer_tableau($connexion, $q);

                    function generer_tableau($connexion, $date)
                    {

                        $sql0 = "SELECT DISTINCT festivalID FROM creneau_planning WHERE dates='$date'";
                        $result0 = $connexion->query($sql0);
                        $donnee0 = mysqli_fetch_assoc($result0);
                        $festivalID = $donnee0["festivalID"];
                        $intervalle1 = 000;
                        $intervalle2 = 999;
                        $festivalID1 = intval($festivalID . $intervalle1);
                        $festivalID2 = intval($festivalID . $intervalle2);

                        $sql = "SELECT  nom, prenom, personneID FROM personnes WHERE personneID BETWEEN '$festivalID1' AND '$festivalID2' ORDER BY personneID ASC";
                        $result = $connexion->query($sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='colonne_nom' style='background-color:black; width=8rem; font-size:0.8rem; font-weight:bold;'>" . $row['nom'] . " " . $row["prenom"] . "</td>";
                                $nom1 = $row["nom"];
                                $prenom = $row["prenom"];
                                $identifiant = $row["personneID"];

                                for ($i = 0; $i <= 23; $i++) {

                                    $sql3 = "SELECT nom_du_lieu, couleur_lieu FROM lieu INNER JOIN creneau_planning ON lieu.lieuID=creneau_planning.lieuID WHERE creneau_planning.heure='$i' AND personneID=$identifiant AND dates='$date'";

                                    $result1 = $connexion->query($sql3);

                                    if (mysqli_num_rows($result1) > 0) {
                                        while ($donnee = mysqli_fetch_assoc($result1)) {
                                            $text = $donnee["nom_du_lieu"];
                                            $couleur_lieu = $donnee["couleur_lieu"];
                                        }
                                    } else {
                                        $text = 'Pause';
                                        $couleur_lieu = '#A3A3A3';
                                    }
                                    echo "<td>";

                                    echo " <input style='width:100%; margin:0; padding:7px; background-color:" . $couleur_lieu . "; color: white;' class='bouton_tableau' type='button' value=" . $text . "  id=personne" . $row["personneID"] . "_heures" . $i . "_jour" . $date . "> ";

                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                        }
                    }

                    ?>
                </div>

            </tbody>

        </table>

    </div>
</div>

<script src="planning_general.php"></script>