<?php

//variable message avec option de suppression qui s'affiche en cas d'action spécifique
//ajout d'une annonce, modification d'une commande, suppression d'utilisateurs etc...
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<header class="header">

    <div class="header-1">
        <div class="flex">
            <div class="share">
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
            <p><a href="login.php">Se connecter</a> | <a href="inscrire.php">S'inscrire</a> </p>
        </div>
    </div>

    <div class="header-2">
        <div class="flex">
            <a href="home.php" id="logo" class="fa-solid fa-car"> Vroomissimo</a>

            <nav class="navbar">
                <a href="home.php">Accueil</a>
                <a href="about.php">A propos</a>
                <a href="annonces.php">Annonces</a>
                <a href="recap_commandes.php">Commandes</a>
                <a href="eval_vendeur.php">Avis</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="search_page.php" class="fa fa-search"></a>
                <a href="contact.php" class="fa-solid fa-address-book"></a>
                <div id="user-btn" class="fas fa-user"></div>
                <?php
                //lien vers la table panier pour afficher le nombre d'article
                    $select_nb_panier = mysqli_query($con, "SELECT * FROM `panier` WHERE client_id = '$client_id'")
                        or exit('Echec de la requête');
                    $nb_panier = mysqli_num_rows($select_nb_panier);
                ?>
                <!-- on affiche le nombre de produits dans le panier à côté de l'icône -->
                <a href="panier.php"> <i class="fas fa-shopping-cart"></i> <span class="nombre">(<?php echo $nb_panier; ?>)</span> </a>
            </div>

            <div class="user-box">
                <!-- user box avec nom et mail du client connecté -->
                <p>Utilisateur : <span><?php echo $_SESSION['client_nom']; ?></span></p>
                <p>Email : <span><?php echo $_SESSION['client_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">Se déconnecter</a>
            </div>
        </div>
    </div>

</header>