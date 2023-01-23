<!--Méthode barre de recherche d'un lieu-->
<?php
try
{
 $bdd = new PDO("mysql:host=localhost;dbname=bddplanning_final", "root", "");
 $bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
  die("Une érreur a été trouvé : " . $e->getMessage());
}
$bdd->query("SET NAMES UTF8");

if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
{
 $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les intrusions html
 $terme = $_GET["terme"];
 $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
 $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

 if (isset($terme))
 {
  $terme = strtolower($terme);
  $select_terme = $bdd->prepare("SELECT nom_du_lieu FROM lieu  WHERE nom_du_lieu LIKE ?");
  $select_terme->execute(array("%".$terme."%")); //tab
 }
 else
 {
  $message = "Vous devez entrer votre requete dans la barre de recherche";
 }
}
?>


<?php
  if($terme_trouve = $select_terme->fetch())
  {
    echo "<p>".$terme_trouve['nom_du_lieu']."</p>";
  }
  else{
    echo '<script>alert("Ce lieu n existe pas");</script>';
  }
  $select_terme->closeCursor();
?>
