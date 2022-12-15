<?php include 'include/connect.php'; ?>

<?php 
    $semaine=['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

     // Dans chaque cellule
    // On compare chaque creneau avec la BDD
    /*for($a=0; isset($semaine[$a]); $a++){
        for($x=0; isset($reserv[$x][3]); $x++){
            $date = date('l', strtotime($reserv[$x][3]));

            // Si correspondance
            if($semaine[$a] == $date){
                echo $date . '<br>';
                echo $reserv[$x][1] . '<br>' . $reserv[$x][2] . '<br>';
                break;
            }
        }
    }*/
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
        <main class="flex-row">

            <table id="table-container">
                <thead>
                    <tr>
                        <th>Jour /<br>Heure</th>

                        <?php 
                            // On créé une liste des jours de la semaine et on génère la première ligne du tableau en la parcourant
                            $semaine=['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                            for($i=0; isset($semaine[$i]); $i++){
                                echo '<th>' . $semaine[$i] . '</th>';
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

                                // Je rajoute un '0' devant l'heure pour faciliter la comparaison
                                if ($j === 8 || $j === 9){
                                    $j = '0' . $j;
                                }
                                // On remplit la première cellule de chaque ligne par HH:00
                                $heure = '<th>' . $j . ':00' . '<br>' . $j+1 . ':00' . '</th>';
                                echo '<tr>';
                                    echo $heure;
                                
                                    // On rempli les autres cellules par Jour + Heure    
                                    for($k=0; isset($semaine[$k]); $k++){
                                        $creneau = $semaine[$k] . ' ' . $j . ':00';

                                        // Dans chaque cellule
                                        // On compare chaque creneau avec la BDD
                                        for($x=0; isset($reserv[$x][3]); $x++){
                                            $date = date('l H:i', strtotime($reserv[$x][3]));

                                            // Si correspondance
                                            if($creneau == $date){
                                                echo '<td>' . $reserv[$x][1] . '<br>' . $reserv[$x][2] . '</td>';
                                                break;
                                            }
                                            else{
                                                echo '<td>' . $creneau . '</td>';
                                                break;
                                            }
                                        }
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