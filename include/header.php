<header class="flex-row">
    <nav class="flex-row">

        <!-- Si aucune Session n'est ouverte -->
        <?php if(!isset($_SESSION['login'])){ ?> 
            <a href="index.php">Accueil</a>
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
            
        <!-- Si une Session user est ouverte -->
        <?php } else{?>
            <a href="profil.php">Modifier mon profil</a>
            <a href="planning.php">Planning</a>
            <a href="reservation-form.php">Réserver une salle</a>
            <a href="deconnexion.php">Se déconnecter</a>

        <?php } ?>
    </nav>
</header>