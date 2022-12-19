<?php include 'include/connect.php'; 
    $idReserv = $_GET['id'];
    
    $request3 = $mysqli->query("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_user WHERE reservations.id=$idReserv");
    $reservation = $request3->fetch_all();
    //var_dump($reservation);

    $jour = date('d/m/Y', strtotime($reserv[0][3]));
    $hdebut = date('H:i', strtotime($reservation[0][3]));
    $hfin = date('H:i', strtotime($reserv[0][4]));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/f18b510552.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sahitya:wght@700&family=Trirong:wght@600&family=Trykker&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>Réservation</title>
    </head>
<body>
    <header><?php include 'include/header.php' ?></header>

    <main class="flex-column">
        <div class="flex-column" id="reservation">
            <h2>Réservation effectuée par <br><?= $reservation[0][7]; ?></h2>
            <p id="text">Titre<p id="text1"><?= $reservation[0][1]; ?></p></p>

            <p id="text">Description<p id="text1"><?= $reservation[0][2]; ?></p></p>

            <p id="text">le <?= $jour; ?></p>
            <p id="text">de <?= $hdebut; ?> à <?= $hfin; ?></p>
        </div>
    </main>

    <footer><?php include 'include/footer.php' ?></footer>
</body>
</html>

