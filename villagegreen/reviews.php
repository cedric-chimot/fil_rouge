<?php

//connexion à la BDD
include 'components/connect.php';

//début de la session
session_start();

//si l'ulisateur est connecté on renvoie ses identifiants sinon ça reste vide
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

//paramétrage de la fonction 'ajout'
if (isset($_POST['add_review'])) {

    //déclaration des variables
    $num_order = $_POST['num_order'];
    $name_user = $_POST['name_user'];
    //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
    $name_user = htmlspecialchars($name_user);
    $note = $_POST['note'];
    $note = htmlspecialchars($note);
    $review = $_POST['review'];
    $review = htmlspecialchars($review);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];                                     //"tmp_name" = temporary name
    $image_folder = 'assets/images/avatar/' . $image;

    //on va chercher dans la BDD la table 'reviews' par rapport au numéro de commande et l'id utilisateur
    $select_review = $conn->prepare('SELECT * FROM `reviews` WHERE num_order = ? AND user_id = ?');
    $select_review->execute([$num_order, $user_id]);
    
    // si le commentaire a déjà été envoyé on affiche ceci
    if($select_review->rowCount() > 0){
        $message[] = 'Commentaire déjà envoyé !';
    }else{
        //insertion des données du commentaire à l'aide d'une requête
        $add_review = $conn->prepare('INSERT INTO reviews(user_id, num_order, client, note, avis, image) VALUES(?,?,?,?,?,?)');
        $add_review->execute([$user_id, $num_order, $name_user, $note, $review, $image]);

    //vérification de la taile de l'image au moment de l'insertion et envoie d'un message d'erreur si elle est trop grande
    if ($add_review) {
        if ($image_size > 2000000) {
            $message[] = "La taille de l'image est trop grande !";
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Commentaire ajouté avec succès !';
        }
        } else {
            $message[] = "Votre commentaire n'a pas pu être ajouté";
        }
    }
}

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
    //association du bouton 'delete' avec l'ID du commentaire
    $delete_id = $_GET['delete'];
    //requête de suppression avec lien vers la table 'reviews'
    $delete_review = $conn->prepare('DELETE FROM `reviews` WHERE id = ?');
    $delete_review->execute([$delete_id]);
    //renvoie vers la liste des reviews
    header('location:reviews.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter avis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- on inclut le header du site -->
    <?php include 'components/user_header.php'; ?>

    <section class="reviews">
        
        <h1 class="heading">Donner votre avis</h1>

        <!-- Formulaire d'ajout d'un commentaire -->
        <section class="add-review">

            <form method="post" action="" enctype="multipart/form-data">
                <h3>Votre avatar :</h3>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
                <h3>Votre nom :</h3>
                <input type="text" name="name_user" class="box" placeholder="votre nom" required>
                <h3>Commande N° :</h3>
                <input type="text" name="num_order" class="box" placeholder="numéro de commande" required>
                <h3>Votre note :</h3>
                <!-- on attribue une valeur aux étoiles -->
                <div class="stars">
                    <i class="fa-regular fa-star" data-value="1"></i>
                    <i class="fa-regular fa-star" data-value="2"></i>
                    <i class="fa-regular fa-star" data-value="3"></i>
                    <i class="fa-regular fa-star" data-value="4"></i>
                    <i class="fa-regular fa-star" data-value="5"></i>
                </div>
                <!-- input type 'hidden' qui attribue une note de base de '0' -->
                <input type="hidden" name="note" id="note" value="0">
                <h3>Votre commentaire :</h3>
                <textarea name="review" class="box" placeholder="votre avis" cols="30" rows="10" required></textarea>
                <input type="submit" value="Ajouter un avis" name="add_review" class="option-btn">
            </form>

        </section>

        <section class="read_reviews">

            <h1 class="heading">Tous vos commentaires</h1>

            <div class="box-container">

                <?php

                //requête pour afficher les données de la table 'reviews' correspondantes au client
                $select_review = $conn->prepare('SELECT * FROM `reviews` WHERE `user_id` = ?');
                $select_review->execute([$user_id]);

                // Retourne le nombre de lignes affectées par le dernier appel à la fonction
                if ($select_review->rowCount() > 0) {
                    // Récupère la ligne suivante d'un ensemble de résultats PDO
                    while ($fetch_review = $select_review->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <!-- S'il existe un avis, on affiche les informations correspondantes -->
                        <div class="box">
                            <img src="assets/images/avatar/<?= $fetch_review['image']; ?>" alt=""><br><br>
                            <span>Commande N° : </span>
                            <div class="commande"><?= $fetch_review['num_order']; ?></div>
                            <span>Note : </span>
                            <div class="note">
                            <?php if ($fetch_review['note'] == 0) {
                                        echo '<i class="fa-regular fa-sun"> style="color: grey;"></i>
                                            <i class="fa-regular fa-sun"> style="color: grey;"></i>
                                            <i class="fa-regular fa-sun"> style="color: grey;"></i>
                                            <i class="fa-regular fa-sun"> style="color: grey;"></i>
                                            <i class="fa-regular fa-sun"> style="color: grey;"></i>';
                                    } elseif ($fetch_review['note'] == 1) {
                                        echo '<i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>';                                            
                                    } elseif ($fetch_review['note'] == 2) {
                                        echo '<i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>';
                                    } else if ($fetch_review['note'] == 3){
                                        echo '<i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>';
                                    } else if ($fetch_review['note'] == 4){
                                        echo '<i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-sun" style="color: grey;"></i>';
                                    } else if ($fetch_review['note'] == 5){
                                        echo '<i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>
                                            <i class="fa-solid fa-sun" style="color: goldenrod;"></i>';
                                    } ?>                                                                    
                            </div>
                            <span>Commentaire : </span>
                            <div class="avis"><?= $fetch_review['avis']; ?></div>
                            <a href="reviews.php?delete=<?= $fetch_review['id']; ?>" class="delete-btn"
                                onclick="return confirm('Voulez-vous supprimer ce commentaire ?');">Supprimer
                            </a>
                        </div>
                <?php
                    } 
                    } else {
                        //Sinon la phrase suivante s'affiche
                        echo '<p class="empty">Aucun avis publié !</p>';
                    }
                
                ?>

        </section>

    </section>

    <!-- on inclut le footer du site -->
    <?php include 'components/footer.php'; ?>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/eval.js"></script>

</body>

</html>