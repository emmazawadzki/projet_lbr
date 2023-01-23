<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Planning lieux</title>
  <link rel="stylesheet" href="../planning_lieux/planning_lieux.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>

<body>

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
      document.location.href = "../compte/modifier_infos.html";
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
        echo "<script>let date_du_jour = new Date(" . $annee . ", " . $mois . "," . $jour . ");</script>";
      }
    } else {
    }

    ?>
    <script>
      //let date_du_jour = new Date('Sept 22, 2022');

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
          document.getElementById("tabpdf").innerHTML = this.response;
        }
      };
      /*xmlhttp1.open("GET", "generation_tableau?s=" + datestring, true);
      xmlhttp1.send();*/

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
            document.getElementById("tabpdf").innerHTML = this.response;
          }
        };
        /*xmlhttp1.open("GET", "planning_lieux?s=" + datestring, true);
        xmlhttp1.send();*/
        let d = new Date();
        d.setTime(d.getTime() + (60 * 1000)); //1 min
        if(date_du_jour.getMonth() < 9){
          $mois = date_du_jour.getMonth()+1;
          $mois = "0" + $mois;
        }
        else{
          $mois = date_du_jour.getMonth()+1;
        }
        dateActuelle = date_du_jour.getFullYear() + "-" + $mois + "-" + date_du_jour.getDate();
        document.cookie = "jour =" + dateActuelle + "; expires=;" + d;

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
            document.getElementById("tabpdf").innerHTML = this.response;
          }
        };
        let d = new Date();
        d.setTime(d.getTime() + (60 * 1000)); //1 min
        if(date_du_jour.getMonth() < 9){
          $mois = date_du_jour.getMonth()+1;
          $mois = "0" + $mois;
        }
        else{
          $mois = date_du_jour.getMonth()+1;
        }
        dateActuelle = date_du_jour.getFullYear() + "-" + $mois + "-" + date_du_jour.getDate();

        
        document.cookie = "jour =" + dateActuelle + "; expires=;" + d;

        
      };
    </script>



    <div style="height: 80%;top: 10%;position: fixed;width:100%; overflow:auto;">
      <div>
        <table id="tabpdf" class="planning-style">
          <thead class="personnes">
            <tr id="tete" style="position:sticky;top:0;">
              <th></th>
              <th>Besoin membres</th>
              <th>Besoin bénévoles</th>
              <th>Personnes</th>
            </tr>
          </thead>

          <tbody id="tablebody">
          <?php include('generation_tableau.php'); ?>
          
            

          </tbody>
        </table>
      </div>
    </div>

    <!--  <script>
    let indice_ligne = 0;
    for (let indice_col = 0; indice_col <= 23; indice_col++) {
      let thheure = document.createElement("tr");
      thheure.setAttribute("id", "personne" + indice_ligne + "_heure" + indice_col);
      thheure.innerHTML = indice_col + "h"; // Ici on insère le texte dans la case
      let entete = document.getElementById("tablebody");
      entete.appendChild(thheure);

    }
  </script> -->

    <!--FOOTER -->
    <div id="navbar_du_bas">
      <ul>
        <li id="btn"><a>Telecharger</a></li>
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

          width: $("#tabpdf").width() + 150,
          allowTaint: true,

          onrendered: function(canvas) {

            var a = document.createElement('a');
            const imgData = canvas.toDataURL("image/png");
            pdf.addImage(imgData, 'PNG', 0, 0, width, $("#tabpdf").height());
            pdf.save("planninglieux.pdf");

          }

        });
      });
    </script>


</body>
<script src="..\planning_general\planning_general.js"></script>

</html>