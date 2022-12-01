<?php
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

        <a href="dashboard.php" class="logo">Tableau<span> de bord</span></a>

        <nav class="navbar">
            <a href="dashboard.php">Accueil</a>
            <a href="produits.php">Produits</a>
            <a href="commandes.php">Commandes</a>
            <a href="users_accounts.php">Clients</a>
            <a href="messages.php">Messages</a>
        </nav>

        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="fas fa-user" id="user-btn"></div>
        </div>

        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admin`
                    WHERE admin_id = ?");
                $select_profile->execute([$admin_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= $fetch_profile['nom']; ?></p>
            <div class="flex-btn">
                <a href="update_profile.php" class="option-btn">Modifier</a>
            </div>
            <a href="logout_admin.php" class="delete-btn"
                onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">Se déconnecter</a>
        </div>
    </section>

</header> 