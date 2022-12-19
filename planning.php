<?php include 'include/connect.php';      //On joint la connexion à la base de donnée ?>

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
        <title>Planning2</title>
    </head>
    <body>
        <header><?php include 'include/header.php' ?></header>
        <main class="flex-row">

            <table id="table-container">
                <thead>
                    <tr>
                        <th>Jour /<br>Heure</th>

                        <?php 
                            // On créé une currentDate en partant de "ce lundi"
                            $currentDate = date('l d F', strtotime('this week monday'));

                            // On génère la première ligne des dates en rajoutant à chaque tour + 1 jour
                            for($i=0; $i<5; $i++){
                                echo '<th>' . $currentDate . '</th>';
                                $currentDate = date('l d F', strtotime($currentDate . '+1 day'));
                            }
                        ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php 
                            // On commence à 8h00 (premier créneau disponible), jusqu'à 18h00 (dernier créneau disponible)
                            // On génère la première cellule de la ligne en th contenant le créneau et le reste en th contenant
                            // le jour en cours + l'heure du créneau en cours
                            for ($j=8; $j<19; $j++){

                                // On rajoute un '0' devant l'heure pour faciliter la comparaison
                                if ($j === 8 || $j === 9){
                                    $j = '0' . $j;
                                }
                               
                                echo '<tr>';
                                    // On remplit la première cellule de chaque ligne par HH:00
                                    $heure = '<th>' . $j . ':00' . '</th>';
                                    echo $heure;
                                
                                    // On rempli les autres cellules par creneau (currentDate + Heure)
                                    $currentDate = date('l d F', strtotime('this week monday'));
                                    for($k=0; $k<5; $k++){
                                        $creneau = $currentDate . ' ' . $j . ':00';
                                        
                                        // On initie checkCreneau sur false
                                        // Dans chaque cellule on compare chaque creneau avec la BDD
                                        $checkCreneau = false;
                                        for($x=0; isset($reserv[$x][3]); $x++){
                                            $hdebut = date('l d F H:i', strtotime($reserv[$x][3]));
                                            $hfin = date('l d F H:i', strtotime($reserv[$x][4]));

                                            // Si correspondance, on passe chsckCreneau sur true
                                            if($creneau >= $hdebut && $creneau < $hfin){
                                                $checkCreneau = true;
                                                break;
                                            }
                                        }
                                        
                                        // Si le créneau est occupé on récupère son titre et sa description
                                        if($checkCreneau){
                                            echo "<td id='resa'><a href='reservation.php?id=" . $reserv[$x][0] . "'>" . $reserv[$x][1] . "</a></td>";
                                        }
                                        // Sinon on affiche un bouton
                                        else{
                                            echo "<td id='dispo'>" . "<a href='reservation-form.php'><button id='reserver'>Réserver ce créneau</button></a>" . '</td>';
                                        }

                                        // On rajoute 1 jour qàa la currentDate
                                        $currentDate = date('l d F', strtotime($currentDate . '+1 day'));
                                    }

                                echo '</tr>';
                            }
                        ?>
                    </tr>
                </tbody>
            </table>

        </main>
        <footer><?php include 'include/footer.php' ?></footer>
    </body>
</html>