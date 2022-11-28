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
        <a href="dashboard.php" class="logo">
            Tableau<span> de bord</span>
        </a>

        <nav class="navbar">
            <a href="dashboard.php">Accueil</a>
            <a href="products.php">Produits</a>
            <a href="recap_commandes.php">Commandes</a>
            <a href="admin_client.php">Clients</a>
            <a href="messages.php">Messages</a>
        </nav>

        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="fas fa-user" id="user-btn"></div>
        </div>

        <div class="profile">
            <?php
                $select_admin = mysqli_query($con, "SELECT * FROM `admin`
                WHERE `admin_id` = '$admin_id'");
            ?>
            <p>Utilisateur : <span><?php echo $_SESSION['admin_nom']; ?></span> </p>
            <div class="flex-btn">
                <a href="logout_admin.php" class="delete-btn" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
                    Se déconnecter
                </a>
            </div>

        </div>
    </section>

</header> 