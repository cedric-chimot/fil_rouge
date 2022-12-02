<?php

    //fonction d'affichage des différents messages(login, ajout au panier, informations diverses etc...)
    if(isset($message)){
        foreach($message as $message){
            echo '
                <div class="message">
                    <span>' .$message. '</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>';
        }
    }
?>

<header class="header">

    <section class="flex">

        <a href="../admin/dashboard.php" class="logo">Tableau<span> de bord</span></a>

        <nav class="navbar">
            <a href="../admin/dashboard.php">Accueil</a>
            <a href="../admin/products.php">Produits</a>
            <a href="../admin/placed_orders.php">Commandes</a>
            <a href="../admin/users_accounts.php">Utilisateurs</a>
            <a href="../admin/messages.php">Messages</a>
        </nav>

        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="fas fa-user" id="user-btn"></div>
        </div>

        <!-- paramétrage de la userbox -->
        <div class="profile">
            <?php
            //on va chercher la table 'admins' dans la BDD
                $select_profile = $conn->prepare("SELECT * FROM `admins`
                    WHERE id = ?");
                $select_profile->execute([$admin_id]);

                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <!-- on affiche le nom de l'admin connecté dans la userbox -->
            <p><?= $fetch_profile['nom']; ?></p>
            <div class="flex-btn">
                <a href="update_profile.php" class="option-btn">Modifier</a>
            </div>
            <a href="logout_admin.php" class="delete-btn"
                onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">Se déconnecter</a>
        </div>
    </section>

</header> 