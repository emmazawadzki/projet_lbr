<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Planning general</title>
  <link rel="stylesheet" href="../planning_general/planning_general.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>

<style>
  /* Popup container - can be anything you want */
  .popup {

    position: relative;
    margin-top: 260px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;

  }

  /* The actual popup */

  .popup.popup_containt {

    height: 80px;
    background-color: #FF890A;
    color: #fff;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -125px;
    overflow-y: scroll;
    scrollbar-color: rebeccapurple green;
    scrollbar-width: thin;
  }

  .lieu_dispo {
    margin: 0px;

    border: none;
    color: white;
    padding: fixed;
    font-size: 12px;
    cursor: pointer;
    text-align: center;

  }

  .table_info {
    display: inline-block;
    position: relative;
    top: -3px;
  }

  .table_lieu {
    display: inline-block;
  }


  /* Popup arrow */
  .popup .popup_containt::after {

    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
  }

  /* Toggle this class - hide and show the popup */
  .popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
  }

  /* Add animation (fade in the popup) */
  @-webkit-keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  thead th,
  td {
    padding: fixed;
    font-size: 10px;
  }

  .popup.bouton_tableau:active {
    color: red;

  }
</style>
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

<body id="tabpdf" style="position:fixed;top:0;bottom:0;left:0;right:0;overflow:hidden;">

  <nav class=navbar>

    <ul>

      <img class="logo" src="../images/initiales_blanc.png">
      <?php
      $festivalID = $_GET["festivalID"];
      echo '<li><a href="planning_general.php?festivalID=' . $festivalID . '">Planning général</a></li>
      <li><a class="active" href="..\planning_lieux\planning_lieux.php?festivalID=' . $festivalID . '">Lieu</a></li>
      <li><a href="..\planning_personnes\Les_plannings.php?festivalID=' . $festivalID . '">Les plannings</a></li>';
      ?>
      <img id="profil" class="profil" src="../images/profil.png"></a>

    </ul>

  </nav>
  <script>
    var btn = document.getElementById("profil");
    btn.addEventListener("click", event => {
      window.location.href = "../compte/modifier_infos.html";
    });
  </script>


  <!--BARRE DE LA DATE  -->

  <<div class="container">
    <div class="month">
      <button class="buttonleft" type="button" onclick="Changeprev()"></button>
      <div class="date">
        <h id="p"></h><br>
        <h id="p1"></h>
      </div>
      <button class="buttonright" type="button" onclick="Changenext()"></button>
    </div>
    </div>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "bddplanning_final";

    $conn = mysqli_connect($host, $username, $password, $database);
    $sql = "SELECT date_de_debut, duree_en_jour FROM configuration WHERE festivalID=2022;";


    $resultat = $conn->query($sql);
    if (mysqli_num_rows($resultat) > 0) {
      // output data of each row
      while ($row = mysqli_fetch_assoc($resultat)) {
        $annee = intval(substr($row['date_de_debut'],0,4));
        $mois = intval(substr($row['date_de_debut'],5,2))-1; 
        $jour = intval(substr($row['date_de_debut'],8,2));
        echo "<script>let date_du_jour = new Date(" . $annee . ", " . $mois . "," . $jour . ");console.log(date_du_jour);</script>";
      }
    } else {
      echo "0 results";
    }

    ?>
    
    <script>

      //Date en français 
      var options1 = {
        weekday: "long",
        day: "2-digit"
      };
      var options2 = {
        year: "numeric",
        month: "long"
      };
      var date_du_jour1 = date_du_jour.toLocaleDateString("fr-FR", options1);
      var date_du_jour2 = date_du_jour.toLocaleDateString("fr-FR", options2);

      //Récup de l'ID de la date
      document.getElementById("p").innerHTML = date_du_jour1.toUpperCase();
      document.getElementById("p1").innerHTML = date_du_jour2;


      //FONCTION POUR METTRE LA DATE DANS LA BONNE FORME
      function format_date() {
        let partie1 = document.getElementById("p").innerHTML;
        let partie2 = document.getElementById("p1").innerHTML;
        let date = partie1 + partie2
        const d = new Date(date);
        let annee = d.getFullYear();
        let jour = d.getDate();
        let mois = d.getMonth() + 1;
        window.datestring = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2);

        return datestring;
      }


      //MANIPULATION DE LA DATE 

      format_date();
      var xmlhttp1 = new XMLHttpRequest();

      xmlhttp1.onreadystatechange = function() {
        if (this.readyState === 4 || this.status === 200) {
          document.getElementById("tableaux").innerHTML = this.response;
        }
      };
      xmlhttp1.open("GET", "generation_tableau.php?s=" + datestring, true);
      xmlhttp1.send();


      // FONCTION POUR ALLER A LA DATE SUIVANTE

      function Changenext() {
        date_du_jour = new Date(date_du_jour);
        date_du_jour.setDate(date_du_jour.getDate() + 1);
        date_du_jour1 = date_du_jour.toLocaleDateString("fr-FR", options1);
        date_du_jour2 = date_du_jour.toLocaleDateString("fr-FR", options2);
        document.getElementById("p").innerHTML = date_du_jour1.toUpperCase();
        document.getElementById("p1").innerHTML = date_du_jour2;
        format_date();
        var xmlhttp1 = new XMLHttpRequest();

        xmlhttp1.onreadystatechange = function() {
          if (this.readyState === 4 || this.status === 200) {
            document.getElementById("tableaux").innerHTML = this.response;
          }
        };
        xmlhttp1.open("GET", "generation_tableau.php?s=" + datestring, true);
        xmlhttp1.send();
      }

      // FONCTION POUR ALLER A LA DATE PRECEDENTE 

      function Changeprev() {
        date_du_jour = new Date(date_du_jour);
        date_du_jour.setDate(date_du_jour.getDate() - 1);
        date_du_jour1 = date_du_jour.toLocaleDateString("fr-FR", options1);
        date_du_jour2 = date_du_jour.toLocaleDateString("fr-FR", options2);
        document.getElementById("p").innerHTML = date_du_jour1.toUpperCase();
        document.getElementById("p1").innerHTML = date_du_jour2;
        format_date();
        var xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
          if (this.readyState === 4 || this.status === 200) {
            document.getElementById("tableaux").innerHTML = this.response;
          }
        };
        xmlhttp1.open("GET", "generation_tableau.php?s=" + datestring, true);
        xmlhttp1.send();

      };
    </script>



    <!--GENERATION DU PLANNING-->
    <div id=tableaux>

    </div>

    <!--PARTIE DE LA POPUP-->

    <span class="popup" id="myPopup" style="visibility: hidden;">

      <div id=lieux class="popup_containt" style="margin-top:80px; overflow:auto;
    scrollbar-color: rebeccapurple green;
    scrollbar-width: thin;  height: 90px; width:450px;
    background-color: black">

      </div>
    </span>
    <!--FIN DE LA POPUP-->

    <!--FOOTER -->
    <div id="navbar_du_bas">
      <ul>
        <li id="btn"><a>Telecharger</a></li>
        <li onclick="openForm()"><a href="#Ajouter">Importer</a></li>
      </ul>
    </div>


    <div id="place">
    </div>

    <!--FONCTION POUR TELECHARGEMENT PDF-->
    <script>
      var btn = document.getElementById("btn");
      btn.addEventListener("click", event => {
        console.log("ok");
        var plan_holder = document.getElementById("place");

        plan_holder.scrollTo(0, 0);

        const {

          jsPDF

        } = window.jspdf;

        const pdf = new jsPDF("l", "px", "a4");

        var width = pdf.internal.pageSize.getWidth();
        const tableau = document.getElementById("tabpdf");
        console.log($("#tabpdf"));
        html2canvas($("#tabpdf")[0], {

          width: $("#tabpdf").width() + 100,
          allowTaint: true,

          onrendered: function(canvas) {

            var a = document.createElement('a');
            const imgData = canvas.toDataURL("image/png");
            pdf.addImage(imgData, 'PNG', 0, 0, width, $("#tabpdf").height() * 0.75);
            pdf.save("planning.pdf");

          }

        });
      });
    </script>




    <!-- DETECTION DU CLIC SUR LA TABLEAU POUR OUVRIR LA POPUP -->

    <script>
      var previous_button = "init";
      let bouton_tableau = document.getElementById("tableaux");
      bouton_tableau.onclick = function(event) {

        if (event.target.id == "") {
          return 0;
        }
        cases_id = event.target.id;

        console.log("id=", cases_id);
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
          if (this.readyState === 4 || this.status === 200) {
            document.getElementById("lieux").innerHTML = this.response;

          }
        };
        xmlhttp.open("GET", "lieux_disponibles.php?q=" + cases_id, true);
        xmlhttp.send();
        console.log("bouton=", previous_button);
        let popup = document.getElementById("myPopup");
        popup.style.visibility = "visible";



        console.log("bouton1=", previous_button);
      };
    </script>

    <!--DETECTION DU CLIC SUR LA POPUP POUR SELECTIONNER UN LIEU  -->

    <script>
      let lieu_dispo_id = document.getElementById("lieux");
      lieu_dispo_id.onclick = function(event) {

        // l'evenement permet de détecter sur quel composant le clic est passé
        if (event === undefined) event = window.event;
        let target = 'target' in event ? event.target : event.srcElement;

        let case_id = document.getElementById(cases_id);
        if (target.value == undefined) {
          return 0;
        }
        let previous_value = case_id.value; // sauvegarde de la nouvelle valeur en fontion
        let new_value = target.value;
        case_id.value = new_value;

        $.ajax({
          type: 'GET',
          url: 'modification_planning.php',
          data: {
            donnee1: case_id.value,
            donnee2: cases_id
          },
          dataType: 'html',
          timeout: 20000,
          success: function(reponse) {
            console.log(reponse);
          },
          error: function() {
            console.log("ca n'a pas marché");
          }
        })

      }
    </script>

</body>

</html>