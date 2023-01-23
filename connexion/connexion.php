<!--Formulaire-->
<html>
  <head>
    <title>Connexion</title>
    <link href="connexion/connexion.css" rel="stylesheet" type="text/css">
  </head>
  <body> 
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
    <img id="planete" src="images/planete.png">
    <img id="soleil" src="images/soleil.png">
    <header>
      <img id="logo" src="images/initiales_blanc.png">
      <p id="header_texte">Admin</p>
    </header>
    <div id="title">
      <h1 id="titre_contours">CONNEXION</h1>
      <h2 id="titre_main">CONNEXION</h2>
    </div>
    <div id="form">
    <form method="post" action="connexion/connexion.php">
      <div id="champs">
      <p class="titre_input">Identifiant</p>
      <input type="email" name="email" placeholder="Identifiant" class="input_connexion"/><br />
      <p class="titre_input">Mot de passe</p>
      <input type="password" name="mdp" placeholder="Mot de passe" class="input_connexion"/><br/>
      </div>
      <input type="submit" value="CONNEXION" id="bouton_submit"/>
    </form>
    </div>
    <a id="mdp_oublie">Mot de passe oublié</a>


  </body>
</html>

<?php
    // Vérifie qu'il provient d'un formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //identifiants mysql
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "bddplanning_final";
    
    //champs du formulaire
    $email = $_POST["email"];
    $mdp = $_POST["mdp"]; 

    //Connexion à la base de donnée
    $conn = mysqli_connect($host,$username,$password,$database);

    //Fonction qui vérifie mail et mdp
    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $result = mysqli_query($conn, $sql);
 
        if (mysqli_num_rows($result) == 0)
        {
            die("Mot de passe incorrect.");
        }
 
        $user = mysqli_fetch_object($result);
 
        if ($mdp == $user->mdp)
        {
            header('Location: accueil.php');
        }
        else{
            header('Location: ../main.php');
        }
 
        exit();
    }
?>