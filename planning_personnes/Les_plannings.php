<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Titre</title>
    <link rel="stylesheet" href="Les_plannings.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<style>
   /****************IMAGES**************/
.logo {
    width: 100px;
    padding-right: 15px;
}
.profil{
    width:3.5rem;
    margin-top: 3px;
    margin-left: 12%;
}
/***************NAVBAR*********************/

.navbar ul{
    position: fixed;
    margin: 0;
    width: 100%;
    float: left;
    top: 0;
    left: 0;
    padding: 0;
    list-style: none;
    background-color: #ea001c;
    text-align: center;
    height: 4em;
  
    z-index:1;
}

.navbar a,
.logo {
    float: left;
}

.navbar a {
    top: 50%;
    padding: 15px 15px;
    color: white;
    float: left;
    text-decoration: none;
    font-size: 25px;
    font-weight: bold;
    width: 25%;
    /* Four equal-width links. If you have two links, use 50%, and 33.33% for three links, etc.. */
    text-align: center;
    /* If you want the text to be centered */
}

a:hover {
    background-color: #EA001C;
    box-shadow: 4px 4px 4px rgba(0.25, 0, 0, 0), inset 4px 4px 4px rgba(0, 0, 0, 0.25);
}


</style>

<body style="position:fixed;">
<nav class=navbar>
    <ul>
      <img class="logo" src="../images/initiales_blanc.png">
      <?php
      $festivalID = $_GET["festivalID"];
      echo '<li><a href="..\planning_general\planning_general.php?festivalID=' . $festivalID . '">Planning général</a></li>
      <li><a href="..\planning_lieux\planning_lieux.php?festivalID=' . $festivalID . '">Lieu</a></li>
      <li><a class="active" href="Les_plannings.php?festivalID=' . $festivalID . '">Les plannings</a></li>';
      ?>
      <img id="profil" class="profil" src="../images/profil.png">
    </ul>
  </nav>
  <script>
    var btn = document.getElementById("profil");
    btn.addEventListener("click", event => {
      window.location.href = "../compte/modifier_infos.html";
    });
  </script>
    <div>
        <ul id="nav">
            <li onclick="openForm()"><a>Ajouter</a></li>
            <li onclick="openImport()"><a>Importer</a></li>

        </ul>

    </div>

</body>
<script>

    function openForm() {
        document.getElementById("popupForm").style.display = "block";
        document.getElementById("popupImport").style.display = "none";
        document.getElementById("NomPrenom").style.display = "none";
        document.getElementById("Informations").style.display = "none";
        document.getElementById("Modif").style.display = "none";
        document.getElementById("planning").style.display = "none";
    }
    
    function closeForm() {
        document.getElementById("popupForm").style.display = "none";
    }
    
    function openImport() {
        document.getElementById("popupImport").style.display = "block";
        document.getElementById("popupForm").style.display = "none";
        document.getElementById("NomPrenom").style.display = "none";
        document.getElementById("Informations").style.display = "none";
        document.getElementById("Modif").style.display = "none";
        document.getElementById("planning").style.display = "none";
    }
    
    function closeImport() {
        document.getElementById("popupImport").style.display = "none";
    }
    
    
    // affiche les informations d'une personne en fonction de son ID
    function AfficherInfo(personneID){
    
        // affiche la bonne popup
        document.getElementById("NomPrenom").style.display = "block";
        document.getElementById("popupForm").style.display = "none";
        document.getElementById("popupImport").style.display = "none";
        document.getElementById("Informations").style.display = "none";
        document.getElementById("Modif").style.display = "none";
        document.getElementById("planning").style.display = "none";
        
        // appel ajax pour récupérer les informations de la personne
        const xhtp = new XMLHttpRequest();
        xhtp.onload = function() {
            // le résultat est retourné dans la valeur "this.responseText" au format JSON
            const personne = JSON.parse(this.responseText);
            document.getElementById("NomPrenom_nom").innerHTML = personne.Nom;
            document.getElementById("NomPrenom_prenom").innerHTML = personne.Prenom;
            document.getElementById("persID").innerHTML = personne.personneID;
            document.getElementById("NomPrenom_nomAffiche").innerHTML = personne.Nom;
            document.getElementById("NomPrenom_prenomAffiche").innerHTML = personne.Prenom;
            document.getElementById("categorie_Affiche").innerHTML = personne.categorie;
            document.getElementById("NomPrenom_btn_voirInfo").onclick = function (){ VoirInfo(personne.personneID);return false; };
            document.getElementById("Affiche").onclick = function (){ AfficherInfo(personne.personneID);return false; };
            

        }
        xhtp.open("GET", "../services/UserService.php?action=getuser&personneID=" + personneID, false);
        xhtp.send();
        
        
    }
    
    function MasquerInfo(){
        document.getElementById("NomPrenom").style.display = "none";
    }
    
    // permet de modifier les informations d'une personne en fonction de son ID
    function ModifierInfo(personneID){
        document.getElementById("Modif").style.display = "block";
        document.getElementById("NomPrenom").style.display = "none";
        document.getElementById("popupForm").style.display = "none";
        document.getElementById("popupImport").style.display = "none";
        document.getElementById("Informations").style.display = "none";
        document.getElementById("planning").style.display = "none";
        
        // appel ajax pour récupérer les informations de la personne
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            // le résultat est retourné dans la valeur "this.responseText" au format JSON
            const personne = JSON.parse(this.responseText);
            document.getElementById("NomPrenom_nom1").innerHTML = personne.Nom;
            document.getElementById("NomPrenom_prenom1").innerHTML = personne.Prenom;

            document.querySelector('#Modif input#personneID').value = personne.personneID;
            document.querySelector('#Modif input#Nom').value = personne.Nom;
            document.querySelector('#Modif input#Prenom').value = personne.Prenom;
            document.querySelector('#Modif input#email').value = personne.email;
            document.querySelector('#Modif input#Tel').value = personne.Tel;
            document.querySelector('#Modif input#Heures_dispos_1er_jour').value = personne.Heures_dispos_1er_jour;
            document.querySelector('#Modif input#Infos_complementaires').value = personne.Infos_complementaires;
            document.querySelector('#Modif input#Benevole').checked = (personne.categorie !== 'membre');
            document.querySelector('#Modif input#Membre').checked = (personne.categorie === 'membre');
        }
        xhttp.open("GET", "../services/UserService.php?action=getuser&personneID=" + personneID, false);
        xhttp.send();
    }
    
    function FermerModifier(){
        document.getElementById("Modif").style.display = "none";
    }
    
    // affiche les informations d'une personne en fonction de son ID
    function VoirInfo(personneID){
        document.getElementById("Informations").style.display = "block";
        document.getElementById("popupForm").style.display = "none";
        document.getElementById("popupImport").style.display = "none";
        document.getElementById("NomPrenom").style.display = "none";
        document.getElementById("Modif").style.display = "none";
        document.getElementById("planning").style.display = "none";
        
        // appel ajax pour récupérer les informations de la personne
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            // le résultat est retourné dans la valeur "this.responseText" au format JSON
            const personne = JSON.parse(this.responseText);
            document.getElementById("Informations_nomprenom").innerHTML = personne.Nom + " " + personne.Prenom;
            document.getElementById("Informations_categorie").innerHTML = personne.categorie;
            document.getElementById("Informations_tel").innerHTML = personne.email + " " + personne.Tel;
            document.getElementById("Informations_heures").innerHTML = "Heures dispos le 1er jour: " + personne.Heures_dispos_1er_jour;
            document.getElementById("Informations_infos").innerHTML = "Infos complémentaires: <div style='background-color: #4c4c4c; font-size: 15px;'>" + personne.Infos_complementaires + "</div>";
        }
        xhttp.open("GET", "../services/UserService.php?action=getuser&personneID=" + personneID, false);
        xhttp.send();

    }
    
    function FermerInfo(){
        document.getElementById("Informations").style.display = "none";
    }
    function AffichePlanning(){
        document.getElementById("planning").style.display = "block";
        document.getElementById("NomPrenom").style.display = "none";
        document.getElementById("popupForm").style.display = "none";
        document.getElementById("popupImport").style.display = "none";
        document.getElementById("Informations").style.display = "none";
        document.getElementById("Modif").style.display = "none";
    }
    
    function FermerPlanning(){
        document.getElementById("planning").style.display = "none";
    }
    

</script>

</html>


<!-- Mise en forme de l'importation -->

<?php

// inclut les fonctions liées à la base de données
include "../services/UserService.php";

// récupère une connexion à la BDD
$con = connectDB();

if(isset($_POST['but_import'])){
   
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
}
?>


<!-- Mise en forme de l'ajout-->

<?php

// Vérifier si le formulaire est soumis 
if ( isset( $_GET['submit'] ) ) {
   
   /* récupérer les données du formulaire en utilisant la valeur des attributs name comme clé */
   $Nom = $_GET['Nom'];
   $Prenom = $_GET['Prenom']; 
   $email = $_GET['email'];
   $Tel = $_GET['Tel'];
   $categorie = $_GET['categorie']; 
   $Heures_dispos_1er_jour = $_GET['Heures_dispos_1er_jour'];
   $Infos_complementaires = $_GET['Infos_complementaires'];

   // Vérifier les duplications
   $sql = "select count(*) as allcount from personnes where Nom='" . $Nom . "' and Prenom='" . $Prenom . "' and email='" . $email . "' and Tel='" . $Tel . "' and categorie='" . $categorie . "' and Heures_dispos_1er_jour='" .$Heures_dispos_1er_jour."' and Infos_complementaires='" . $Infos_complementaires . "' ";
   $retrieve_data = mysqli_query($con,$sql);
   $row = mysqli_fetch_array($retrieve_data);
   $count = $row['allcount'];

   if($count == 0){
      // Insérer
      $insert_query = "insert into personnes(Nom,Prenom,email,Tel,categorie,Heures_dispos_1er_jour,Infos_complementaires) values('".$Nom."','".$Prenom."','".$email."','".$Tel."','".$categorie."','".$Heures_dispos_1er_jour."','".$Infos_complementaires."')";
      mysqli_query($con,$insert_query);
   }

}
?>

<!-- Mise en forme de la modification-->

<?php
if ( isset( $_GET["submit_modif"] ) ) {
   
try{
   $host = "localhost"; /* nom de l'host */
   $user = "root"; /* utilisateur */
   $password = ""; /* mot de passe */
   $dbname = "bddplanning_final"; /* nom de la base*/

   $dbco = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
   $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   $personneID_modif = $_GET['personneID'];
   $Nom_modif = $_GET['Nom'];
   $Prenom_modif = $_GET['Prenom']; 
   $email_modif = $_GET['email'];
   $Tel_modif = $_GET['Tel'];
   $categorie_modif = $_GET['categorie']; 
   $Heures_dispos_1er_jour_modif = $_GET['Heures_dispos_1er_jour'];
   $Infos_complementaires_modif = $_GET['Infos_complementaires'];
   
   $sth = $dbco->prepare("update personnes set Nom='".$Nom_modif."', Prenom='" . $Prenom_modif . "', email='" . $email_modif . "', Tel='" . $Tel_modif . "', categorie='" . $categorie_modif . "', Heures_dispos_1er_jour='" .$Heures_dispos_1er_jour_modif."', Infos_complementaires='" . $Infos_complementaires_modif . "' where personneID='".$personneID_modif."'");
   $sth->execute();
}

catch(PDOException $e){
   echo "Erreur : " . $e->getMessage();
}

}

?>


<!-- Afficher les données importées -->
<?php
      echo "<div id='Affiche' style='font-size: 30px; color: rgb(255, 255, 255); position: relative; padding: 60px 10px ;'>
      <span hidden id='persID'></span> <span id='NomPrenom_nomAffiche'></span> <span id='NomPrenom_prenomAffiche'></span> <span style='font-size: 15px;' id='categorie_Affiche'></span>
         </div>";
?>


<div style="overflow: auto; height: 73%; position:relative; display: block; width:100%; padding: 0; top: -45px;">
   <table class="Info-Perso" id="userTable">
      <?php
         $sql = "select * from personnes order by personneID asc";
         $retrieve_data = mysqli_query($con, $sql);
         while($row = mysqli_fetch_array($retrieve_data)){
            
            // Vérifier si le formulaire est soumis 
            echo
               "<tr>
                  <td><div onclick=\"AfficherInfo(" . $row["personneID"] . ");\">" . $row['Nom'] . " " . $row['Prenom'] . "</div></td>
                  <td>" . $row['categorie'] . "</td>
                  <td>" . $row['Tel'] . "</td>
                  <td><div onclick='ModifierInfo(" . $row["personneID"] . ");'>Modifier les infos</div></td>
               </tr>";
         }    
      ?>
   </table>
</div>

<div><?php include('Ajouter_Popup.html');?></div>
<!-- Afficher Nom Prenom en haut -->
<div class="loginPopup">
    <div class="formPopup" id="NomPrenom">
        <form class="formContainer" method="post" >
            <div class="titre">
            <span id="NomPrenom_nom"></span> <span id="NomPrenom_prenom"></span>
               <button type="button" class="btn cancel" id="NomPrenom_btn_voirInfo">Voir Info</button>
               
                  <button type="button" class="btn cancel" onclick="AffichePlanning()">Voir Planning</button>
               
               <button type="button" class="btn cancel" onclick="MasquerInfo()">Fermer</button>
                
            </div>
        </form>
    </div>
</div>

<div class="loginPopup">
    <div class="formPopup" id="Modif">
        <form class="formContainer" method="get" >
            <div class="titre">Modifier info de <span id="NomPrenom_nom1"></span> <span id="NomPrenom_prenom1"></span>
               <label for="Nom"></label>
               <input id="Nom" placeholder="Nom" name="Nom" required>

               <label for="personneID"></label>
               <input type="hidden" id="personneID" name="personneID">

               <label for="Prenom"></label>
               <input id="Prenom" placeholder="Prenom" name="Prenom" required>

               <label for="email"></label>
               <input id="email" placeholder="email" name="email" required>

               <label for="Tel"></label>
               <input id="Tel" placeholder="Numéro de télephone" name="Tel" required>

               <label for="Heures_dispos_1er_jour"></label>
               <input id="Heures_dispos_1er_jour" placeholder="Heures dispos le 1er jour" name="Heures_dispos_1er_jour" required>

               <label for="Infos_complementaires"></label>
               <input id="Infos_complementaires" placeholder="Infos complémentaires" name="Infos_complementaires">

               <input type="radio" id="Benevole" name="categorie" value="Benevole">
               <label for="Benevole">Bénévole</label>

               <input type="radio" id="Membre" name="categorie" value="Membre">
               <label for="Membre">Membre</label>

               <input type="submit" class="btn cancel" id="submit_modif" name="submit_modif">
               <button type="button" class="btn cancel" onclick="FermerModifier()">Fermer</button>
               
            </div>
        </form>
    </div>
</div>

<div class="loginPopup">
    <div class="formPopup" id="Informations">
        <form class="formContainer" method="post">
            <div class="titre">
                <?php echo "<div style='margin: 5px; text-align: left; width: 500px;'>
                        <div id='Informations_nomprenom' style='margin: 10px; font-size: 40px; font-weight: bold;'></div>
                        <div id='Informations_categorie' style='margin: 10px; font-size: 30px; text-align: left; font-weight:lighter; border-bottom: 2px solid white;'></div>
                        <div id='Informations_tel' style='margin: 10px;'></div>
                        <div id='Informations_heures' style='margin: 10px; font-weight: lighter;'></div>
                        <div id='Informations_infos' style='margin: 10px; font-weight: lighter;'></div>
                           </div>";
                ?>
                <button type="button" class="btn cancel" onclick="FermerInfo()">Fermer</button>
            </div>
        </form>
    </div>
</div>


<div class="loginPopup">
    <div class="formPopup" id="planning">
        <form class="formContainer" style="transform: translate(0%, 4%);"method="post">
            <table style="overflow: auto; height: 73%; position:relative; display: block; width:100%; padding: 0; ">
            <?php
         echo"<script>";
         echo"var span=document.getElementsByTagName('span')[0];";
         echo "var idpersonne =span;";
         echo" let d = new Date();
               d.setTime(d.getTime() + (60*1000));
         document.cookie = 'name='+idpersonne+ '; expires=' + d; ";
         echo"</script>";

         
         $id=isset($_GET['name']) ? $_GET['name'] : '';
      
        
         echo "<thead>";

         $sql="SELECT date_de_debut, duree_en_jour FROM configuration WHERE festivalID='2022'";
         $result = $con->query($sql);
         $donnee = mysqli_fetch_assoc($result);
         $date_debut=$donnee["date_de_debut"];
         $duree=$donnee["duree_en_jour"];
         echo "<tr>";
         echo"<td> </td>";
         for($i=0; $i<$duree;$i++){
            $date=date('Y-m-d',strtotime($date_debut.'+'.$i.'days'));
            echo "<td>".$date."</td>";
         }
         echo "</tr>";
         echo "</thead>";
         echo"<tr>";
         for($j=0; $j<=23;$j++){
            echo "<td>".$j."h</td>";
            for($i=0; $i<$duree;$i++){
               $date=date('Y-m-d',strtotime($date_debut.'+'.$i.'days'));
               $sql1= "SELECT nom_du_lieu FROM lieu INNER JOIN creneau_planning ON lieu.lieuID=creneau_planning.lieuID WHERE heure=$j AND personneID='5' AND dates='$date'";
               $result1 = $con->query($sql1);
               if (mysqli_num_rows($result1) > 0) {
                 while ($donnee1 = mysqli_fetch_assoc($result1)) {
                   $text = $donnee1["nom_du_lieu"];
                 }
               }
               else {
                 $text = 'Pause';
               }
               echo "<td>".$text."</td>";
            }
            echo"</tr>";
         }
         
          
      ?>
      
            </table>
            <button type="button" class="btn cancel" style="margin-top: 5px; margin-bottom: 2px; width: 100%;"onclick="FermerPlanning()">Fermer</button>
        </form>
    </div>
</div>


<?php
   // fermeture de la connexion à la BDD
   closeDB($con);
?>

