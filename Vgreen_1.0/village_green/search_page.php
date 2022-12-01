<?php

include 'components/connect.php';

//début de la session
session_start();

//l'utilisateur doit être connecté
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

//on inclut la fonction d'ajout au panier
include 'components/ajout_panier.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="search-form">

        <form action="" method="POST">
            <input type="text" class="box" name="search_box" maxlength="100" placeholder="Rechercher" required>
            <button type="submit" class="fas fa-search" name="search_btn"></button>
        </form>

    </section>

    <section class="products" style='padding-top: 0; min-height: 50vh;'>

        <div class="box-container">
            <?php
            //fonction sur le clique de l'input ou du bouton de recherche
            if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                $search_box = $_POST['search_box'];
                $search_btn = $_POST['search_btn'];
                // on va chercher les données de la table produits correspondantes à la recherche
                $select_products = $conn->prepare("SELECT * FROM `produits`
                    WHERE libelle LIKE '%$search_box%'");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    //à l'aide d'une boucle on associe les produits de la BDD
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <!-- si le produit recherché existe dans la table on renvoie ce formulaire -->
                        <form action="" method="POST" class="box">
                            <input type="hidden" name="id" value="<?php $fetch_products['id']; ?>">
                            <input type="hidden" name="libelle" value="<?php $fetch_products['libelle']; ?>">
                            <input type="hidden" name="description" value="<?php $fetch_products['description']; ?>">
                            <input type="hidden" name="prix" value="<?php $fetch_products['prix']; ?>">
                            <input type="hidden" name="categorie" value="<?php $fetch_products['categorie']; ?>">
                            <input type="hidden" name="image" value="<?php $fetch_products['image']; ?>">
                            <img src="assets/images/BODY/<?= $fetch_products['image']; ?>" alt="">
                            <div class="name"><?= $fetch_products['libelle']; ?></div>
                            <div class="flex">
                                <div class="price"><?= $fetch_products['prix']; ?><span> €</span></div>
                                <!-- si le produit est déjà dans le panier on revoie 'false' et un message d'erreur s'affiche -->
                                <input type="number" name="qte" class="qte" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                            </div>
                            <input type="submit" value="Ajouter au panier" class="option-btn" name="ajout_panier">
                        </form>
            <?php
                    }
                } else {
                    //s'il aucun produit n'est trouvé ce message s'affiche
                    echo '<p class="empty">Aucun produit ne correspond à votre recherche !</p>';
                }
            }
            ?>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <script src="assets/js/script.js"></script>

</body>

</html>