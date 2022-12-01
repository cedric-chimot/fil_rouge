<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/admin_style.css">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="accounts">

        <h1 class="heading">Tous les clients</h1>

        <div class="box-container">

            <?php
            $select_accounts = $conn->prepare("SELECT * FROM `users`");
            $select_accounts->execute();
            if ($select_accounts->rowCount() > 0) {
                while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p> Id client : <span><?= $fetch_accounts['user_id']; ?></span> </p>
                        <p> Utilisateur : <span><?= $fetch_accounts['prenom'] . ' ' . $fetch_accounts['nom']; ?></span> </p>
                        <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
                        <a href="users_accounts.php?delete=<?= $fetch_accounts['user_id']; ?>"
                            onclick="return confirm('Supprimer ce compte ? Toutes les informations liées à cet utilisateur seront aussi supprimées !')"
                            class="delete-btn">Supprimer</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Pas encore de clients</p>';
            }
            ?>

        </div>

    </section>








    <script src="assets/js/admin_script.js"></script>

</body>

</html>