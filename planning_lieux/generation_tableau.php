<?php

            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "bddplanning_final";

            $conn = mysqli_connect($host, $username, $password, $database);
            //$festivalID = $_GET["festivalID"];
            $festivalID = intval(2022);
            $sql = "SELECT date_de_debut, duree_en_jour FROM configuration WHERE festivalID=2022;";
            $resultat = $conn->query($sql);
            if (mysqli_num_rows($resultat) > 0) {
              // output data of each row
              while ($row = mysqli_fetch_assoc($resultat)) {
                $date_de_debut = $row['date_de_debut'];
                $duree_en_jour = $row['duree_en_jour'];
              }
            } else {
              echo "0 results";
            }

            $dateString = $_COOKIE['jour'];
            $lieuID = "202201";
            for ($i = 0; $i < 24; $i++) {
              //echo "<script>console.log(".$sql.")</script>";
              echo "<tr><td style='text-align: right; width: 10%; font-size:2rem; font-weight:bold;padding:2px;'>" . $i . "<p style='display:inline-block;font-size:1rem;'>h</p>";
              $sql = "SELECT besoin_nb_benevole, besoin_nb_membre FROM creneau_planning WHERE dates='" . $dateString . "' AND heure='" . $i . "' AND lieuID = '" . $lieuID . "' AND personneID='';";
              $resultat = $conn->query($sql);
              if (mysqli_num_rows($resultat) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($resultat)) {
                  echo "<td style='text-align: center; width: 20%; font-size:1.8rem;'>" . $row['besoin_nb_membre'] . "</td>
                  <td style='text-align: center; width: 20%; font-size:1.8rem;'>" . $row['besoin_nb_benevole'] . "</td>";
                }
              } else {
                echo "<td style='text-align: center; width: 20%; font-size:1.8rem;'>0</td>
                <td style='text-align: center; width: 20%; font-size:1.8rem;'>0</td>";
              }


              $sql = "SELECT personneID FROM creneau_planning WHERE dates='" . $dateString . "' AND heure='" . $i . "' AND lieuID = '" . $lieuID . "' AND personneID !=''";
              $resultat = $conn->query($sql);
              if (mysqli_num_rows($resultat) > 0) {
                // output data of each row
                echo "<td>";
                while ($row = mysqli_fetch_assoc($resultat)) {
                  $sql2 = "SELECT Nom, Prenom, Tel From personnes WHERE personneID='" . $row['personneID'] . "'";
                  $resultat2 = $conn->query($sql2);
                  if (mysqli_num_rows($resultat2) > 0) {
                    echo "<ul style='width:100%;padding-top:0;padding-bottom:0;margin-top:0;margin-bottom:0;'>";
                    while ($row2 = mysqli_fetch_assoc($resultat2)) {
                      echo "<li><p style='display:inline-block;width:20%;'>" . $row2['Nom'] . "</p><p style='display:inline-block;width:20%;'>" . $row2['Prenom'] . "</p><p style='display:inline-block;width:20%;'>" .  $row2['Tel'] . "</p></li>";
                    }
                    echo "</ul>";
                  } else {
                    echo "0 results";
                  }
                }
                echo "</td>";
              } else {
                echo "0 results";
              }
            }
            echo "</tr>";




            ?>