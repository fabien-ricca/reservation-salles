<?php  ?><!DOCTYPE html>
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

<!----------------------------------------------------------- PHP ------------------------------------------------------------------->      

    <?php 
        include 'include/connect.php';      //On joint la connexion à la base de donnée

        date_default_timezone_set('Europe/Paris');              //On définit le timezone pour avoir le bon fuseau d'horaire
        $currentDate = date('Y-m-d');                           // On récupère la date et l'heure

        $msgTitre = "";
        $msgDate = "";
        $msgHeure = "";
        $msgDescription = "";
        $msgReservation = "";

        if ($_POST != NULL){
            $titre = $_POST['titre'];                 // On récupère le login saisi
            $date = $_POST['date'];
            $hdebut = $_POST['hdebut'];
            $hfin = $_POST['hfin'];
            $description = $_POST['description'];
            $id_user = $_SESSION['id'];

            $checkTitre = false;
            $checkDate = false;
            $checkHeure = false;
            $checkDescription = false;
            

            if($titre != NULL && strlen($titre) >= 5){
                echo "titre OK<br>";
                $checkTitre = true;
            }
            else{
                $msgTitre = "<p id='msgerror'>!! Le titre est trop court !!</p>";
            }

            if($currentDate <= $date){
                $checkDate = true;
            }
            else{
                $msgDate = "<p id='msgerror'>!! La date choisie n'est pas disponible !!</p>";
            }
    
            if((int)$hfin > (int)$hdebut){
                $checkHeure = true;
                $hdebut = $currentDate . ' ' . $hdebut . ':00';
                $hfin = $currentDate . ' ' . $hfin . ':00'; 
                //echo $hdebut . '<br>';
                //echo $hfin . '<br>';
            }
            else{
                $msgHeure = "<p id='msgerror'>!! Les horaires souhaités ne sont pas disponibles !!</p>";
            }
            
            if($description != NULL && strlen($description) >= 10){
                $checkDescription = true;
            }
            else{
                $msgDescription = "<p id='msgerror'>!! La description est trop courte !!</p>";
            }

            if($checkTitre && $checkDate && $checkHeure && $checkDescription){
                $request = $mysqli->query("INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_user`) VALUES ('$titre', '$description', '$hdebut', '$hfin', '$id_user')");
                $msgReservation = "<p id='msgok'> Votre réservation a bien été prise en compte</p>";
            }

            
        }

        

    ?>
<!----------------------------------------------------------------------------------------------------------------------------------->  
        


            <div class="flex-column" id="form-container">
                <h2>Formulaire de réservation</h2>
                <form Method="POST" class="flex-column">
                    <label for="titre">Titre :</label>
                    <input type="text" name="titre" id="titre" placeholder="Min. 5 caractères">
                    <?= $msgTitre ?>

                    <label for="date">Début de la réservation :</label>
                    <input type="date" name="date" id="date" min="<?php echo $currentDate ?>">
                    <?= $msgDate ?>

                    <div>
                        <label for="hdebut">Heure de début :</label>
                        <select name="hdebut" id="hdebut">  <option value="08">08:00</option>  
                                                            <option value="09">09:00</option>  
                                                            <option value="10">10:00</option>  
                                                            <option value="11">11:00</option>  
                                                            <option value="12">12:00</option>  
                                                            <option value="13">13:00</option>  
                                                            <option value="14">14:00</option>  
                                                            <option value="15">15:00</option>  
                                                            <option value="16">16:00</option>  
                                                            <option value="17">17:00</option>  
                                                            <option value="18">18:00</option>  
                        </select>
                    </div>
                    
                    <div>
                        <label for="hfin">Heure de Fin :</label>
                        <select name="hfin" id="hfin">  <option value="09">09:00</option>  
                                                        <option value="10">10:00</option>  
                                                        <option value="11">11:00</option>  
                                                        <option value="12">12:00</option>  
                                                        <option value="13">13:00</option>  
                                                        <option value="14">14:00</option>  
                                                        <option value="15">15:00</option>  
                                                        <option value="16">16:00</option>  
                                                        <option value="17">17:00</option>  
                                                        <option value="18">18:00</option>  
                                                        <option value="19">19:00</option>  
                        </select>
                    </div>
                    <?= $msgHeure ?>

                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" placeholder="Min. 10 caractères"></textarea>
                    <?= $msgDescription ?>

                    <input type="submit" id="mybutton" value="Réserver" >
                    <?= $msgReservation ?>
                </form>
            </div>
        </main>
        <footer><?php include 'include/footer.php' ?></footer>
    </body>
</html>