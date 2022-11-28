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
                <img src="assets/images/HEADER/picto_pays.png" alt="">
                <?php
                    $select_product_cart = mysqli_query($con, "SELECT * FROM `panier` WHERE `client_id` = '$client_id'")
                        or exit('Echec de la requête');
                    $total_product_cart = mysqli_fetch_assoc($select_product_cart);
                ?>
                <a href="panier.php"> <i class="fas fa-shopping-cart"></i> <span class="nombre">(<?php echo $total_product_cart; ?>)</span></a>
            </div>
            <p><a href="user_login.php">Se connecter</a> | <a href="user_register.php">S'inscrire</a> </p>
        </div>
    </div>

    <div class="header-2">
        <div class="flex">

            <a href="home.php" class="logo">
                <img src="assets/images/HEADER/logo_village_green.png" alt="">
            </a>

            <nav class="navbar">
                <a href="home.php">Accueil</a>
                <a href="annonces.php">Produits</a>
                <a href="recap_commandes.php">Commandes</a>
                <a href="eval_vendeur.php">Avis</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="user-btn" class="fas fa-user"></div>
            </div>

            <div class="profile">
                <!-- user box avec nom et prenom du client connecté -->
                <p>Utilisateur : <span><?php echo $_SESSION['prenom'] . ' ' . $_SESSION['client_nom']; ?></span></p>
                <a href="components/logout.php" class="delete-btn">Se déconnecter</a>
            </div>
        </div>
    </div>

</header>