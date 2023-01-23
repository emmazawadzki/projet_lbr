<html>

<head>
    <title>Accueil</title>
    <link href="connexion.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="../images/fusee.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <img id="planete" src="../images/planete.png">
    <img id="soleil" src="../images/soleil.png">
    <header>
        <img id="logo" src="../images/initiales_blanc.png">
        <p id="header_texte">Admin</p>
    </header>
    <div id="title">
        <h1 id="titre_contours">EDITION</h1>
        <h2 id="titre_main">EDITION</h2>
    </div>
    <div id="form">
        <div style="height:84.1%;overflow:auto;">
            <form method="get" action="accueil.php">
                <?php

                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "bddplanning_final";

                $conn = mysqli_connect($host, $username, $password, $database);
                $sql = "select festivalID from configuration";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if (strlen(strval($row['festivalID'])) == 5) {
                            $newFestivalID = substr($row['festivalID'], 0, 4) . " (" . substr($row['festivalID'], 4, 5)  . ")";
                            echo "<button style='background: none; cursor : pointer;' name='edition' class='edition' value=" . strval($row['festivalID']) . ">" . $newFestivalID . "</button>";
                        } else {
                            echo "<button style='background: none; cursor : pointer;' name='edition' class='edition' value=" . strval($row['festivalID']) . ">" . $row['festivalID'] . "</button>";
                        }
                    }
                }
                ?>
            </form>
        </div>
        <a href="ajout_edition.php"><button id="bouton_ajouter" style="cursor: pointer;">AJOUTER</button></a>

    </div>
</body>

<?php
if (isset($_GET['edition'])) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $edition = $_GET['edition'];
        echo "<script>window.location.replace('../planning_general/planning_general.php?festivalID=" . $edition . "');</script>";
    }
}
?>

</html>