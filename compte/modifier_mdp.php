<?php
if (isset($_POST['Submit']) && $_POST['Submit'] == 'Modifier') {
    $mail = $_POST['mail'];
    $new_pass = $_POST['new_pass'];
    $pass_old = $_POST['pass_old'];
    $new_pass_conf = $_POST['new_pass_conf'];
    $conn = mysqli_connect('localhost', 'root', '','bddplanning_final');

$sql = mysqli_query($conn, "SELECT mdp FROM users WHERE email = '" . $mail ."'");
list($password) = mysqli_fetch_array($sql);

// tu compare si le nouveau passe correspond à l'ancien
if ($new_pass == $new_pass_conf)
{
    //tu vérifie si il sont identique
    if ($password == $pass_old)
    {
        //si oui tu update et encrypte le nouveau mot de passe dans la bdd
        $pass   = $new_pass;  
        $query  = mysqli_query($conn,"UPDATE users SET mdp = '$pass'  WHERE email = '". $mail ."'");
        header("Location:../compte/confirmation.html");
        exit();
    }
    else
    {
        header("Location:../compte/erreur.html");
        exit();
    }
}
else
{
    header("Location:../compte/erreur.html");
    exit();
}
}
?>