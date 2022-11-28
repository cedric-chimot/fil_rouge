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

        <a href="admin_page.php" class="logo">Tableau<span> de bord</span></a>

        <!-- création de la navbar du tableau de bord -->
        <nav class="navbar">
            <a href="../../home.php">Accueil</a>
            <a href="admin_annonce.php">Annonces</a>
            <a href="admin_commandes.php">Commandes</a>
            <a href="admin_admins.php">Admins</a>
            <a href="admin_vendeurs.php">Vendeurs</a>
            <a href="admin_users.php">Utilisateurs</a>
        </nav>

        <div class="icons">
            <div class="fa fa-bars" id="menu-btn"></div>
            <div class="fa fa-user" id="user-btn"></div>
            <a href="admin_contact.php" class="fa-solid fa-address-book" id="contact"></a>
        </div>

        <!-- boite de connexion qui s'affiche en cliquant sur le bouton utilisateur -->
        <div class="account-box">
            <p>Utilisateur : <span><?php echo $_SESSION['admin_nom']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
        <!-- option de  déconnexion incluse -->
            <a href="logout_admin.php" class="delete-btn">Se déconnecter</a>
        </div>

    </div>

</header>