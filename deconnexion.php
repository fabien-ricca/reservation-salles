<?php include 'include/connect.php';      //On joint la connexion à la base de donnée

    session_destroy();   // On détruit la Session

    header("location: connexion.php");  // On redirige vers la page de connexion
?>