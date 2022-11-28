<?php

//connexion à la base de données
include 'admin/admins/config.php';

//ouverture de la session
session_start();

$client_id = $_SESSION['client_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($client_id)) {
    header('location:login.php');
};

//paramétrage de la fonction 'delete'
if(isset($_GET['delete'])){
    //association du bouton 'delete' avec l'ID du produit dans le panier
    $delete_id = $_GET['delete'];
    //requête de suppression avec lien vers la table 'panier'
    mysqli_query($con, "DELETE FROM `panier` WHERE id = '$delete_id'")
    //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');
    header('location:panier.php');
}

//paramétrage de la fonction 'delete all'
if(isset($_GET['delete_all'])){
    //pour tout supprimer on va chercher la table et on associe cette fois l'ID du client
    mysqli_query($con, "DELETE FROM `panier` WHERE idclient = '$client_id'")
        or exit('Echec de la requête');
    //renvoie vers le panier
    header('location:panier.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Panier</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading_panier">
        <h3>Panier</h3>
        <p> <a href="home.php">Accueil</a> / Panier </p>
    </div>

    <section class="panier">

        <h1 class="titre">Votre panier</h1>

        <table class="box-container">
            
            <?php
            //déclaration d'une variable pour le total à payer
            $total = 0;
            //connexion à la table 'panier' et sa colonne client_id dans la BDD
            $select_panier = mysqli_query($con, "SELECT * FROM `panier`
                WHERE client_id = '$client_id'")
                or exit('Echec de la requête');
            // Retourne le nombre de lignes dans le jeu de résultats
            if (mysqli_num_rows($select_panier) > 0) {
                // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                while ($fetch_panier = mysqli_fetch_assoc($select_panier)) {
            ?>

            <!-- début du tableau panier -->

                    <tr>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Prix</th>
                        <th>Photo</th>
                    </tr>
                    <tr class="box">
                        <td class="marque">
                            <?php echo $fetch_panier['marque']; ?>
                        </td>
                        <td class="modele">
                            <?php echo $fetch_panier['modele']; ?>
                        </td>
                        <td class="prix">
                            <?php echo $fetch_panier['prix']; ?>
                        </td>
                        <td class="image">
                            <img src="image/<?php echo $fetch_panier['image']; ?>" alt="">
                        </td>
                    </tr>
                    <tr class="quantite">
                        <th>Quantité</th>
                        <td>1</td>
                    </tr>
                    <tr class="total">
                        <th>Montant(ttc)</th>
                        <!-- on déclare une variable '$sous_total' en l'associant au prix du produit
                            multiplié par la quantité -->
                        <td><?php echo $sous_total = ($fetch_panier['prix'] * 1); ?>€</td>
                    </tr>
                    <tr class="supprimer">
                        <th>Supprimer</th>
                        <td>
                            <!-- lien vers la fonction 'delete' par l'id de la ligne du panier -->
                            <a href="panier.php?delete=<?php echo $fetch_panier['id']; ?>"
                                class="fa-solid fa-trash-can" onclick="return confirm('Supprimer le produit ?');">
                            </a>
                        </td>
                    </tr>

            <!-- fin du tableau panier -->

            <?php
            //la variable 'total' déclarée au dessus est cette fois égale à la somme de tous les prix des produits dans le panier
                $total += $sous_total;
                }
            } else {
                //sinon, si le panier est vide on renvoie cette phrase
                echo '<p class="vide">Votre panier est vide</p>';
            }
            ?>
        </table>

        <!-- bouton 'supprimer tout' -->
        <!-- 'disabled' pour signifier que le bouton est inactif s'il n'y a aucun produits dans le panier -->
        <div style="margin-top: 2rem; text-align: center;">
            <!-- pop-up pour confirmer la suppression de tout le panier -->
            <a href="panier.php?delete_all" class="delete-btn <?php echo ($total > 1)?'':'disabled'; ?>"
                onclick="return confirm('Voulez-vous vider votre panier ?');">Supprimer tout</a>
        </div>

        <!-- affichage du total général -->
        <div class="total_panier">
            <p>Total à payer : <span><?php echo $total; ?> €</span></p>
            <div class="flex">
                <!-- bouton de passation de commande inactif si le panier est vide -->
                <a href="annonces.php" class="option-btn">Continuer vos achat</a>
                <a href="checkout.php" class="btn <?php echo ($total > 1)?'':'disabled'; ?>">Passer la commande</a>
            </div>
        </div>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>