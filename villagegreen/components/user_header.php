<?php

//fonction d'affichage des différents messages(login, ajout au panier, informations diverses etc...)
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
            <?php
            //lien vers la table 'cart' pour afficher le nombre d'articles dans le panier
            $count_panier_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_panier_items->execute([$user_id]);
            //on retourne le nombre de lignes dans la table liées à l'ID utilisateur
            $total_panier_counts = $count_panier_items->rowCount();
            ?>
            <img src="assets/images/HEADER/picto_pays.png" alt="">
            <a href="search_page.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?= $total_panier_counts; ?>)</span></a>
         </div>
      </div>
   </div>

   <section class="flex">

      <a href="home.php" class="logo">
         <img src="assets/images/HEADER/logo_village_green.png" alt="">
      </a>

      <nav class="navbar">
         <a href="home.php">Accueil</a>
         <a href="about.php">A propos</a>
         <a href="shop.php">Produits</a>
         <a href="orders.php">Commandes</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
         /*paramétrage de la userbox en la connectant à la table 'users' dans la BDD
           par rapport à l'ID de l'utilisateur*/
         $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_profile->execute([$user_id]);
         if ($select_profile->rowCount() > 0) {
            //on créé un tableau associatif par un fetch pour récupérer les données de la table
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- on affiche le pseudo de l'utilisateur connecté -->
            <p>Utilisateur : <span><?= $fetch_profile["pseudo"]; ?></span></p>
            <!-- s'affichent alors les boutons de modification et de déconnexion -->
            <a href="update_user.php" class="option-btn">Modifier</a>
            <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('Voulez-vous vous déconnecter ?');">Se déconnecter</a>
         <?php
         } else {
         ?>
         <!-- sinon si la personne n'est pas connectée, on affiche ce message -->
            <p>Veuiller d'abord vous connecter !</p>
            <div class="flex-btn">
               <!-- les boutons d'inscription et de connexion s'affichent -->
               <a href="user_register.php" class="option-btn">Inscription</a>
               <a href="user_login.php" class="option-btn">Connexion</a>
            </div>
         <?php
         }
         ?>

      </div>

   </section>

</header>