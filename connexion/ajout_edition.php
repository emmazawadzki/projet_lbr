<html>

<head>
    <title>Accueil</title>
    <link href="connexion.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="../images/fusee.png">
</head>

<body>
<script>
    function setLieuxCookies(){
    console.log("test");
    let lieux = document.getElementsByClassName("nomLieu");
    let d = new Date();
    d.setTime(d.getTime() + (60*1000));     //1 min
    d = d.toUTCString();
    document.cookie = "nbLieux=" + lieux.length + "; expires=" + d;
    for(i = 0; i < lieux.length; i++){
        document.cookie = "lieu"+ i + "=" + lieux[i].value + "; expires=" + d;
    }
}
</script>


    <span class="dot" id="dot1"></span>
    <span class="dot" id="dot2"></span>
    <span class="dot" id="dot3"></span>
    <span class="dot" id="dot4"></span>
    <span class="dot" id="dot5"></span>
    <span class="dot" id="dot6"></span>
    <span class="dot" id="dot7"></span>
    <span class="dot" id="dot8"></span>
    <span class="dot" id="dot9"></span>
    <span class="dot" id="dot10"></span>
    <img id="planete" src="../images/planete.png">
    <img id="soleil" src="../images/soleil.png">
    <header>
        <img id="logo" src="../images/initiales_blanc.png">
        <p id="header_texte">Admin</p>
    </header>
    <form method="post" action="ajout_edition.php" enctype="multipart/form-data">
        <div id="form2" style="overflow:hidden;">
            <a href="accueil.php" class="retour">&#10006;</a>
            <div class="champs" id="champs">
                <div class="ligne_form" style="margin-top: 0;">
                    <label class="titre_input" for="date_festival">Date 1er jour</label>
                    <input type="date" name="date_festival" class="input_form" id="date_festival" />
                </div>
                <div class="ligne_form">
                    <label class="titre_input" for="duree_festival" style="width: 68.7%; font-size: 1.8rem;">Dur&eacute;e
                        (jours)</label>
                    <input type="number" name="duree_festival" id="duree_festival" placeholder="Jours" class="input_form" style="width: 25%; margin-top: 0.4%;" min="0" onInput="updateValue();" />
                </div>
                <hr color=#FEFEE8 size="5" width="90%" style="margin-top: 6.5%;">
                <div class="ligne_form" style="margin-top:3%;">
                    <label class="titre_input" for="heures_benevoles" style="width: 68.7%; font-size: 1.8rem;">Heures
                        b&eacute;n&eacute;voles</label>
                    <input type="number" min="0" name="heures_benevoles" id="heures_benevoles" placeholder="Heures" class="input_form" style="width: 25%; margin-top : 0.4%;" />
                </div>
                <div class="ligne_form" style="background: rgba(254, 254, 232, 0.2);cursor: pointer;">
                    <a onclick="showLieux(event)">
                        <p class="titre_input" style="width: 68.7%; font-size: 1.8rem; padding-left : 3%; padding-top: 1%;">
                            Lieux</p>
                        <p class="titre_input" style="width: 25%; text-align: right; font-size: 3rem; margin-top: 0;">+
                        </p>
                    </a>
                </div>
                <div class="ligne_form">
                    <label class="titre_input" for="importfile" style="width: 50%; font-size: 1.8rem;">
                        Fichier .csv</label>
                    <input type="file" class="titre_input" id="importfile" name="importfile" multiple style="width: 50%; text-align: right; font-size: 1.2rem; margin-top: 1.5%;" accept=".csv">
                </div>
            </div>
            <div>
                <input onclick='setLieuxCookies()' type="submit" value="CONTINUER" id="bouton_submit" style="background-color: #FEFEE8; color: black; margin-top: 7.9%;cursor: pointer;font-size: 2rem;font-weight: bold;" />
            </div>
        </div>

        <div id="form3">
            <div class="ligne_form" style="top:0;margin-top:0;background: rgba(254, 254, 232, 0.2);cursor: pointer;">
                <a id="close_lieux" onclick="hideLieux(event);">
                    <p class="titre_input" style="width: 68.7%; font-size: 2.2rem; padding-left : 3%; padding-top: 0%;">
                        Lieux</p>
                    <p class="titre_input" style="width: 25%; text-align: right; font-size: 2.8rem; margin-top: 0; font-weight:800;">
                        &#9644;
                    </p>
                </a>
            </div>
            <a onclick="showAddLieux(event);" id="lienLieux">
                <p class="titre_input" style="width: 100%; text-align: center; font-size: 6rem; font-weight:very bold; margin-top: 0; cursor: pointer;">+
                </p>
            </a>
        </div>

        <div id="form4">
            <a id="form4_close" onclick="hideAddLieux(event)" class="retour">&#10006;</a>
            <div class="champs" id="champs3">
                <div id="ligne_lieu" class="ligne_form" style="margin-top: 0;">
                    <label class="titre_input" style="font-size:3rem; margin-top : 0;">Nom du
                        lieu</label>
                    <input type="text" name="lieu" class="input_form" id="lieu_festival" placeholder="Lieu" />
                </div>
                <div id="ligne_couleur" class="ligne_form" style="margin-top: 0;">
                    <label class="titre_input" style="width:70%;">Couleur</label>
                    <input type="color" name="couleur_lieu" class="input_form" maxlength="7" id="couleur_lieu" style="width:24%; border: 1px solid #FEFEE8;background-color: #FEFEE8; padding: 0px;" />
                </div>
                <div class="ligne_form;" style="margin-top: 2%; height:50%;overflow:auto;border:5px solid #FEFEE8;">
                    <table style="width:100%;">
                        <thead style="z-index:5;position:sticky; top:0;background-color: #FEFEE8; width: 100%; color:black;">
                            <tr id="thead1">
                                <th></th>
                            </tr>
                            <tr id="thead2">
                                <th>Besoins</th>
                            </tr>
                        </thead>
                        <tbody style="margin-top: 10%;position:relative;color:#FEFEE8;font-size:1.2rem; text-align: right;">
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">0h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">1h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">2h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">3h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">4h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">5h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">6h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">7h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">8h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">9h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">10h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">11h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">12h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">13h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">14h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">15h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">16h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">17h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">18h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">19h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">20h</td>
                            </tr class="tab_tr_heure">
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">21h</td>
                            </tr class="tab_tr_heure">
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">22h</td>
                            </tr>
                            <tr class="tab_tr_heure">
                                <td class="tab_heure">23h</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="button" id="bouton_ajouter" style="margin-top: 4%;cursor: pointer;" onclick="setValue()">AJOUTER</button>
        </div>
        </div>
    </form>

    <script src="ajout_edition.js"></script>


    <?php

    if (isset($_POST['date_festival']) && isset($_POST['duree_festival']) && isset($_POST['heures_benevoles'])) {
        // Vérifie qu'il provient d'un formulaire
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            //identifiants mysql
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "bddplanning_final";

            $conn = mysqli_connect($host, $username, $password, $database);
            $festivalID = intval(substr($_POST['date_festival'], 0, 4));

            $sql = "select count(*) as total from configuration where festivalID = " . $festivalID;
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            if($data['total'] != 0){
                $festivalID = $festivalID . $data['total'] + 1;
            }



            $date_debut = $_POST['date_festival'];
            $duree_festival = $_POST['duree_festival'];
            $heures_benevoles = $_POST['heures_benevoles'];

            $sql = "insert into configuration(festivalID, date_de_debut, duree_en_jour, nombre_heure_a_travailler) values ('" . $festivalID . "', '" . $date_debut . "', '" . $duree_festival . "', '" . $heures_benevoles . "');";
            $nbLieux = intval($_COOKIE["nbLieux"]);
            for ($k = 0; $k < $nbLieux; $k++) {
                $lieu_festival = $_COOKIE["lieu" . $k];
                $couleur_festival = $_POST['couleur_' . $lieu_festival];
                $date = new DateTime($date_debut);
                if ($k < 10) {
                    $lieuID = intval($festivalID . "0" . $k);
                } else {
                    $lieuID = intval($festivalID . $k);
                }
                $sql .= "insert into lieu (lieuID, nom_du_lieu, couleur_lieu) values ('" . $lieuID . "', '" . $lieu_festival . "', '" . $couleur_festival . "' );";
                for ($i = 0; $i < $duree_festival; $i++) {
                    $dateString = $date->format('Y-m-d');
                    for ($j = 0; $j < 24; $j++) {
                        $creneau_M = $_POST[$lieu_festival . '_heure' . $j . '_jour' . $i . '_M'];
                        $creneau_B = $_POST[$lieu_festival . '_heure' . $j . '_jour' . $i . '_B'];
                        
                        $sql .= "insert into creneau_planning (date, heure, besoin_nb_benevole, besoin_nb_membre, personneID, lieuID, festivalID)
                    values ('" . $dateString . "', '" . $j . "' , '" . $creneau_B . "', '" . $creneau_M . "', '' ,'" . $lieuID . "', '" . $festivalID . "');";
                    }
                    $date->add(new DateInterval('P1D'));
                }
            }
            if ($conn->multi_query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


            $target_file = basename($_FILES["importfile"]["name"]);

            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         
            $uploadOk = 1;
            if($imageFileType != "csv" ) {
              $uploadOk = 0;
            }
         
            if ($uploadOk != 0) {
               if (move_uploaded_file($_FILES["importfile"]["tmp_name"], 'importfile.csv')) {
         
                 // Checking file exists or not
                 $target_file =  'importfile.csv';
                 $fileexists = 0;
                 if (file_exists($target_file)) {
                    $fileexists = 1;
                 }
                 if ($fileexists == 1 ) {
         
                    // Reading file
                    $file = fopen($target_file,"r");
                    $i = 0;
         
                    $importData_arr = array();
                                
                    while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
                      $num = count($data);
         
                      for ($c=0; $c < $num; $c++) {
                         $importData_arr[$i][] = mysqli_real_escape_string($con, $data[$c]);
                      }
                      $i++;
                    }
                    fclose($file);
                    $i = 0;
                    $skip = 0;
                    // insérer les données importées
                    foreach($importData_arr as $data){
                       if($skip != 0){
                        if($i < 10){
                            $personneID = intval($festivalID . "00" . $i);
                        } else if($i < 100){
                            $personneID = intval($festivalID . "0" . $i);
                        } else{
                            $personneID = intval($festivalID . $i);
                        }
                           $Nom = $data[0];
                           $Prenom = $data[1];
                           $email = $data[2];
                           $Tel = $data[3];
                           $categorie = $data[4];
                           $Heures_dispos_1er_jour = $data[5];
                           $Infos_complementaires = $data[6];
         
                          // Vérifier les duplications
                          $sql = "select count(*) as allcount from personnes where personneID='" . $personneID . "' Nom='" . $Nom . "' and Prenom='" . $Prenom . "' and email='" . $email . "' and Tel='" . $Tel . "' and categorie='" . $categorie . "' and Heures_dispos_1er_jour='" .$Heures_dispos_1er_jour."' and Infos_complementaires='" . $Infos_complementaires . "' ";
         
                          $retrieve_data = mysqli_query($con,$sql);
                          $row = mysqli_fetch_array($retrieve_data);
                          $count = $row['allcount'];
         
                          if($count == 0){
                             // Insérer
                             $insert_query = "insert into personnes(personneID,Nom,Prenom,email,Tel,categorie,Heures_dispos_1er_jour,Infos_complementaires) values('" . $personneID . "', '".$Nom."','".$Prenom."','".$email."','".$Tel."','".$categorie."','".$Heures_dispos_1er_jour."','".$Infos_complementaires."')";
                             mysqli_query($con,$insert_query);
                          }
                       }
                       $skip ++;
                       $i++;
                    }
                    $newtargetfile = $target_file;
                    if (file_exists($newtargetfile)) {
                       unlink($newtargetfile);
                    }
                  }
         
               }
            }
            echo "<script>window.location.replace('../planning_general/planning_general.php?festivalID=" . $festivalID . "');</script>";
            
            exit();
        }
    }
    ?>


</body>

</html>