<!----------------------------------------------------------- PHP ------------------------------------------------------------------->      
<?php include 'include/connect.php';      //On joint la connexion à la base de donnée

    // Il faut être connecté pour avoir accés à cette page
    if($_SESSION['login'] === NULL){
        header('location: connexion.php');
    }

    date_default_timezone_set('Europe/Paris');              //On définit le timezone pour avoir le bon fuseau d'horaire
    $currentDate = date('Y-m-d');                           // On récupère la date et l'heure

    // On initialise les différents messages d'erreurs
    $msgTitre = "";
    $msgDate = "";
    $msgHeure = "";
    $msgDescription = "";
    $msgReservation = "";



    if ($_POST != NULL){

        // On récupère les données du formulaire et celles en session
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES);
        $date = $_POST['date'];
        $hD = $_POST['hdebut'];
        $hF = $_POST['hfin'];
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
        $id_user = $_SESSION['id'];
        $testDay = date('l', strtotime($date));
        
        
        // Si le titre n'est pas vide et fait plus de 5 caractères
        if($titre != NULL && strlen($titre) >= 3 && strlen($titre) <= 20){
            
            // Si la date cactuelle n'est pas superieur à la date choisie
            if($currentDate <= $date){
                
                // On vérifie que la date choisie ne soit ni un samedi ni un dimanche
                if($testDay != "Saturday" && $testDay != "Sunday"){

                    // Si la description n'es pas vide et fait plus de  caractères
                    if($description != NULL && strlen($description) >= 10 && strlen($description) <= 50){
                            
                        // Si l'heure de fin n'est pas inferieure que l'heure de début
                        if((int)$hF > (int)$hD){
                            $hdebut = $date . ' ' . $hD . ':00' . ':00';
                            $hfin = $date . ' ' . $hF . ':00' . ':00';
                            
                            // On vérifie si les horaires sont disponibles
                            $checkDate = true;
                            for($i=0; isset($reserv[$i][3]); $i++){
                                if($reserv[$i][3] === $hdebut){
                                    $checkDate = false;
                                    break;
                                }
                            }

                            // S'ils sont disponibles
                            if($checkDate){
                                $requestInsert = $mysqli->query("INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_user`) VALUES ('$titre', '$description', '$hdebut', '$hfin', '$id_user')");
                                $msgReservation = "<p id='msgok'> Votre réservation a bien été prise en compte</p>";
                            }

                            //Sinon message d'erreur
                            else{
                                $msgHeure = "<p id='msgerror'>!! Les horaires souhaités ne sont pas disponibles !!</p>";
                            }
                        }
                        
                        //Sinon message d'erreur
                        else{
                            $msgHeure = "<p id='msgerror'>!! Les horaires souhaités ne sont pas disponibles !!</p>";
                        }
                    }

                    //Sinon message d'erreur
                    else{
                        $msgDescription = "<p id='msgerror'>!! La description doit comporter entre 10 et 50 caractères !!</p>";
                    }
                }

                //Sinon message d'erreur
                else{
                    $msgDate = "<p id='msgerror'>!! La salle n'est pas disponible le Week-end !!</p>";
                }
            }
            
            //Sinon message d'erreur
            else{
                $msgDate = "<p id='msgerror'>!! La date choisie n'est pas disponible !!</p>";
            }
        }
        //Sinon message d'erreur
        else{
            $msgTitre = "<p id='msgerror'>!! Le titre doit comporter entre 5 et 20 caractères !!</p>";
        }
    }
?>
<!----------------------------------------------------------------------------------------------------------------------------------->  




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
    <title>Réserver</title>
</head>
<body>
    <header><?php include 'include/header.php' ?></header>
    <main class="flex-row">
            <div class="flex-column" id="form-container">
                <h2>Formulaire de réservation</h2>
                <form Method="POST" class="flex-column">
                    <label for="titre">Titre :</label>
                    <input type="text" name="titre" id="titre" placeholder="Entre 5 et 20 caractères">
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
                    <textarea name="description" id="description" cols="30" rows="10" placeholder="Min. 10 caractères et Max. 50"></textarea>
                    <?= $msgDescription ?>

                    <input type="submit" id="mybutton" value="Réserver" >
                    <?= $msgReservation ?>
                </form>
            </div>
        </main>
        <footer><?php include 'include/footer.php' ?></footer>
    </body>
</html>