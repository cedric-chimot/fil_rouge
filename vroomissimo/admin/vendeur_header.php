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

    <div class="flex">

        <a href="board_vendeur.php" class="logo">Tableau<span> de bord</span></a>

        <!-- création de la navbar du tableau de bord -->
        <nav class="navbar">
            <a href="../home.php">Accueil</a>
            <a href="vendeur_annonce.php">Annonces</a>
            <a href="vendeur_commandes.php">Commandes</a>
            <a href="vendeur_client.php">Utilisateurs</a>
            <a href="vendeur_contact.php">Contact</a>
        </nav>

        <div class="icons">
            <div class="fa fa-bars" id="menu-btn"></div>
            <div class="fa fa-user" id="user-btn"></div>
        </div>

        <!-- boite de connexion qui s'affiche en cliquant sur le bouton utilisateur -->
        <div class="account-box">
            <p>Utilisateur : <span><?php echo $_SESSION['vendeur_nom']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['vendeur_email']; ?></span></p>
        <!-- option de  déconnexion incluse -->
            <a href="logout_vendeur.php" class="delete-btn">Se déconnecter</a>
        </div>

    </div>

</header>