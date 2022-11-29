<?php

//connexion à la BDD
include '../components/connect.php';

//début de la session
session_start();

// si l'admin est connecté le dashboard s'affiche
$admin_id = $_SESSION['admin_id'];

// s'il n'est pas connecté il est renvoyé sur le formulaire de login
if(!isset($admin_id)){
    header('location:admin_login.php');
}

// formulaire de modification
if (isset($_POST['update'])) {

    //création des variables
    $idproduit = $_POST['idproduit'];
    $libelle = $_POST['libelle'];
    $libelle = htmlspecialchars($libelle);
    $description = $_POST['description'];
    $description = htmlspecialchars($description);
    $prix = $_POST['prix'];
    $prix = htmlspecialchars($prix);
    $categorie = $_POST['categorie'];
    $categorie = htmlspecialchars($categorie);

    //préparation de la MAJ de la table produits
    $update_product = $conn->prepare("UPDATE `produits` SET libelle = ?, description = ?, prix = ?, categorie = ?
        WHERE idproduit = ?");
    $update_product->execute([$libelle, $description, $prix, $categorie, $idproduit]);

    $message[] = 'Produit modifié avec succès !';

    //modification de l'image
    //on prend l'ancienne image
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'assets/images/BODY/' . $image;

    //si la variable 'image' n'est pas vide
    if (!empty($image)) {
        if ($image_size > 2000000) {
            //message d'erreur si la taille de la nouvelle image est trop grande
            $message[] = 'image size is too large!';
        } else {
            //sinon on remplace l'ancienne image par la nouvelle par rapport à l'ID du produit
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE idproduit = ?");
            $update_image->execute([$image, $idproduit]);
            //déplacement de l'image depuis le dossier temporaire au dossier image
            move_uploaded_file($image_tmp_name, $image_folder);
            //suppression de l'ancienne image
            unlink('assets/images/BODY/' . $old_image);
            //message de confirmation
            $message[] = 'Image modifiée avec succès !';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="update-product">

        <h1 class="heading">Modifier un produit</h1>

        <?php
        //on va chercher le bouton avec le name update dans la page produit
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `produits` WHERE idproduit = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            //on créé une association avec la table dans la BDD
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <!-- formulaire de modification -->
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- inputs cachés correspondants à l'ID du produit et l'ancienne image pour que le produit modifié soit bien associé au bon bouton -->
                    <input type="hidden" name="idproduit" value="<?= $fetch_products['idproduit']; ?>">
                    <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
                    <div class="image-container">
                        <div class="main-image">
                            <img src="assets/images/<?= $fetch_products['image']; ?>" alt="">
                        </div>
                    </div>
                    <span>Modifier le libellé</span>
                    <input type="text" name="libelle" required class="box" maxlength="100" placeholder="Libellé du produit" value="<?= $fetch_products['libelle']; ?>">
                    <span>Modifier le prix</span>
                    <input type="number" name="prix" required class="box" min="0" max="9999999999" placeholder="Prix du produit" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['prix']; ?>">
                    <span>Modifier la description</span>
                    <textarea name="description" class="box" required cols="30" rows="10"><?= $fetch_products['description']; ?></textarea>
                    <span>Modifier la catégorie</span>
                    <input type="text" name="categorie" required class="box" maxlength="100" placeholder="Catégorie du produit" value="<?= $fetch_products['categorie']; ?>">
                    <span>Modifier l'image</span>
                    <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                    <div class="flex-btn">
                        <input type="submit" name="update" class="option-btn" value="Modifier">
                        <a href="produits.php" class="delete-btn">Retour</a>
                    </div>
                </form>
        <?php
            }
        } else {
            echo '<p class="empty">Aucun produits !</p>';
        }
        ?>

    </section>


    <script src="assets/js/admin_script.js"></script>

</body>

</html>