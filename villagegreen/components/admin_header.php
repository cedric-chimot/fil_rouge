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
            <a href="../admin/admin_accounts.php">Admins</a>
            <a href="../admin/products.php">Produits</a>
            <a href="../admin/placed_orders.php">Commandes</a>
            <a href="../admin/users_accounts.php">Utilisateurs</a>
        </nav>

        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="fas fa-user" id="user-btn"></div>
            <a href="../admin/messages.php" class="fa-solid fa-address-book" id="contact"></a>
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
            <p>Admin : <span><?= $fetch_profile['nom']; ?></span></p>
            <div class="flex-btn">
                <a href="update_profile.php" class="option-btn">Modifier</a>
            </div>
            <a href="../components/admin_logout.php" class="delete-btn"
                onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">Se déconnecter</a>
        </div>
    </section>

</header> 