<?php

if (isset($_POST['Submit2']) && $_POST['Submit2'] == 'Modifier') {
    $mail = $_POST['mail'];
    $pass = $_POST['password'];
    $new_mail = $_POST['new_mail'];
    $conn = mysqli_connect('localhost', 'root', '','bddplanning_final');

$sql = mysqli_query($conn, "SELECT email FROM users WHERE mdp = '" . $pass ."'");
list($email) = mysqli_fetch_array($sql);

if ($email == $mail && !empty($pass))
{
//si oui tu update et encrypte le nouveau mot de passe dans la bdd
        $adress  = $new_mail;  
        $query  = mysqli_query($conn,"UPDATE users SET email = '$adress'  WHERE mdp = '". $pass ."'");
        $query2 = mysqli_query($conn,"UPDATE `users` SET `mdp` = '$pass' WHERE  email = '". $mail ."'");
        header("Location:../compte/confirmation.html");
        exit();
       
}
else
{
    header("Location:../compte/erreur.html");
    exit();
}


}
?>

