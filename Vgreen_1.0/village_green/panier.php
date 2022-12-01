<?php

include 'components/connect.php';

//début de la session
session_start();

//l'utilisateur doit être connecté
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
};

if (isset($_POST['delete'])) {
    $panier_id = $_POST['panier_id'];
    $delete_panier_item = $conn->prepare("DELETE FROM `panier` WHERE id = ?");
    $delete_panier_item->execute([$panier_id]);
}

if (isset($_GET['delete_all'])) {
    $delete_panier_item = $conn->prepare("DELETE FROM `panier` WHERE user_id = ?");
    $delete_panier_item->execute([$user_id]);
    header('location:panier.php');
}

if (isset($_POST['update_qte'])) {
    $panier_id = $_POST['panier_id'];
    $qte = $_POST['qte'];
    $qte = htmlspecialchars($qte);
    $update_qte = $conn->prepare("UPDATE `panier` SET quantite = ? WHERE id = ?");
    $update_qte->execute([$qte, $panier_id]);
    $message[] = 'Quantité modifiée !';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="produits panier">

        <h3 class="heading">Votre panier</h3>

        <div class="box-container">

            <?php
            $total = 0;
            $select_produits = $conn->prepare("SELECT * FROM `produits`");
            $select_produits->execute();
            $select_panier = $conn->prepare("SELECT * FROM `panier` WHERE user_id = ?");
            $select_panier->execute([$user_id]);
            if ($select_panier->rowCount() > 0) {
                while (($fetch_panier = $select_panier->fetch(PDO::FETCH_ASSOC)) and ($fetch_produit = $select_produits->fetch(PDO::FETCH_ASSOC))) {
            ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="panier_id" value="<?= $fetch_panier['id']; ?>">
                        <input type="hidden" name="id" value="<?= $fetch_produit['id']; ?>">
                        <img src="assets/images/BODY/<?= $fetch_produit['image']; ?>" alt="">
                        <div class="libelle"><?= $fetch_produit['libelle']; ?></div>
                        <div class="flex">
                            <div class="prix"><?= $fetch_produit['prix']; ?> €</div>
                            <input type="number" name="qte" class="qte" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_panier['quantite']; ?>">
                            <button type="submit" class="fas fa-edit" name="update_qte"></button>
                        </div>
                        <div class="sous-total"> Sous-total : <span><?= $sous_total = ($fetch_produit['prix'] * $fetch_panier['quantite']); ?> €</span> </div>
                        <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
                    </form>
            <?php
                    $total += $sous_total;
                }
            } else {
                echo '<p class="empty">Votre panier est vide !</p>';
            }
            ?>
        </div>

        <div class="total-panier">
            <p>Total à payer : <span><?= $total; ?> €</span></p>
            <a href="recap_produits.php" class="option-btn">Continuer vos achats</a>
            <a href="panier.php?delete_all" class="delete-btn <?= ($total > 1)?'':'disabled'; ?>" onclick="return confirm('Voulez-vous vider votre panier ?');">Supprimer tout</a>
            <a href="checkout.php" class="btn <?= ($total > 1)?'':'disabled'; ?>">Passer la commande</a>
        </div>

    </section>

    <?php include 'footer.php'; ?>


    <script src="assets/js/script.js"></script>

</body>

</html>