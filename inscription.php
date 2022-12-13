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
    <title>Inscriptions</title>
</head>
<body>
    <header><?php include 'include/header.php' ?></header>

    <main class="flex-row">

<!----------------------------------------------------------- PHP ------------------------------------------------------------------->      

    <?php 
        include 'include/connect.php';      //On joint la connexion à la base de donnée

        $msgError = "";         //Création de la variable qui contiendra le message d'erreur du mdp

        if ($_POST != NULL){
            $login=htmlspecialchars($_POST['login']);                 // On récupère le login saisi
            $password=htmlspecialchars($_POST['password']);           // On récupère le premier mdp saisi
            $confpassword=htmlspecialchars($_POST['confpassword']);   // On récupère le second mdp saisi

            // On créée la regex pour la vérification du mdp
            $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
            
            $testLogin = true;          // On crée le booléen pour le test du login
            $testPassword = false;      // On crée le boléen pour le test du mdp

            
            // Si les champs ne soient pas vides
            if($login){
                // On vérifie que le Login n'existe pas, Si oui on créé le message d'erreur et on sort de la boucle
                foreach($users as $user){
                    if($user[0] === $login){                        
                        $msgError = "<p id='msgerror'>!! Le pseudo " . $login . ' est déjà utilisé !!</p>';
                        $testLogin = false;
                        break;
                    }
                }

                // On vérifie que les 2 mdp sont identiques 
                if($password === $confpassword){
                    // On vérifie que le mdp remplisse les conditions   
                    if(preg_match($password_regex, $password)){
                        $testPassword = true;
                    }
                    // Sinon message d'erreur
                    else{
                        $msgError = "<p id='msgerror'> !! Le mot de passe doit contenir au moins 8 cractères dont
                        1 lettre majuscule, 1 lettre minuscule et 1 chiffre!! </p>";
                    }
                }
                // Sinon message d'erreur
                else{
                    $msgError = "<p id='msgerror'> !! Les mots de passe ne sont pas identiques !!</p>";
                }

                // Si les deux conditions rons true, on crypte le mdp, on crée l'utilisateur, et on redirige vers la page deconnexion
                if($testLogin && $testPassword){                        
                    $cryptPassword = password_hash($password, PASSWORD_BCRYPT);
                    $request = $mysqli->query("INSERT INTO `utilisateurs`(`login`, `password`) VALUES ('$login', '$cryptPassword')");
                    header("location: connexion.php");
                } 
            }
            // Sinon message d'erreur
            else{
                $msgError ="<p id='msgerror'>Tous les Champs doivent être remplis.</p>";
            }
        }
    ?>
<!----------------------------------------------------------------------------------------------------------------------------------->  
        


            <div class="flex-row" id="form-container">
                <form action="" Method="POST" class="flex-column">
                    <label for="login">Nom d'utilisateur</label>
                    <input type="text" id="login" name="login" >

                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" >

                    <label for="confpassword">Confirmation</label>
                    <input type="password" id="confpassword" name="confpassword" >

                    <input type="submit" id="mybutton" value="S'inscrire" >
                    <?php echo $msgError; ?>          <!-- Le message sera affiché en cas derreur -->
                </form>
            </div>
        </main>
        <footer><?php include 'include/footer.php' ?></footer>
    </body>
</html>