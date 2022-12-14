<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
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
                  $count_cart_items = $conn->prepare("SELECT * FROM `panier` WHERE user_id = ?");
                  $count_cart_items->execute([$user_id]);
                  $total_cart_counts = $count_cart_items->rowCount();
               ?>
               <img src="assets/images/HEADER/picto_pays.png" alt="">
               <a href="search_page.php"><i class="fas fa-search"></i></a>
               <a href="panier.php"> <i class="fas fa-shopping-cart"></i> <span>(<?= $total_cart_counts; ?>)</span></a>
            </div>
      </div>
   </div>

   <section class="flex">

      <a href="home.php" class="logo">
         <img src="assets/images/HEADER/logo_village_green.png" alt="">
      </a>

      <nav class="navbar">
         <a href="home.php">Accueil</a>
         <a href="recap_produits.php">Produits</a>
         <a href="recap_commandes.php">Commandes</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
      <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p>Utilisateur : <span><?= $fetch_profile["prenom"] . ' ' . $fetch_profile["nom"]; ?></span></p>
         <a href="update_user.php" class="option-btn">Modifier</a>
         <a href="user_logout.php" class="delete-btn" onclick="return confirm('Voulez-vous vraiment vous d??connecter ?');">Se d??connecter</a> 
         <?php
            }else{
         ?>
         <p>Veuillez d'abord vous connecter !</p>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">Inscription</a>
            <a href="user_login.php" class="option-btn">Connexion</a>
         </div>
         <?php
            }
         ?>           
      </div>

   </section>

   
</header>