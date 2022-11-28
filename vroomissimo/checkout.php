<?php

//connexion à la base de données
include 'admin/admins/config.php';

//ouverture de la session
session_start();

$client_id = $_SESSION['client_id'];
$vendeur_id = $_SESSION['vendeur_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($client_id)) {
    header('location:login.php');
};

//paramétrage de la validation de commande
if(isset($_POST['commander'])){

    //création des variables
    $nom = mysqli_real_escape_string($con, $_POST['nom']);
    $telephone = mysqli_real_escape_string($con, $_POST['telephone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $paiement = mysqli_real_escape_string($con, $_POST['paiement']);
    $adresse = mysqli_real_escape_string($con, $_POST['adresse']);
    $cp = mysqli_real_escape_string($con, $_POST['cp']);
    $ville = mysqli_real_escape_string($con, $_POST['ville']);
    $pays = mysqli_real_escape_string($con, $_POST['pays']);
    //variable 'date' affichant la date du jour
    $date_commande = date('d-M-Y');

    //création de la variable total et article_panier renvoyant un tableau vide
    $total_panier = 0;
    $article_panier[] = '';

    //connexion à la table 'panier' en lien avec l'ID du client
    $panier_query = mysqli_query($con, "SELECT * FROM `panier`
            WHERE `client_id` = '$client_id'")
            //'or exit' Affiche un message et termine le script courant
            or exit('Echec de la requête');

        // Retourne le nombre de lignes dans le jeu de résultats
        if(mysqli_num_rows($panier_query) > 0){
            // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
            while($panier_item = mysqli_fetch_assoc($panier_query)){
                //la variable article renvoie aux produits dans le panier par la marque et le modèle
                $article_panier[] = $panier_item['marque'] . ', ' . $panier_item['modele'];
                //la variable sous_total est égale au prix du produit
                $sous_total = $panier_item['prix'];
                // le total panier renvoie le total de tous les articles du panier
                $total_panier += $sous_total;
            }
        }

    //Rassemble les éléments d'un tableau en une chaîne
    $total_articles = implode($article_panier);

    //lien de la table 'commande' avec les colonnes et les variables
    $commande_query = mysqli_query($con, "SELECT * FROM `commandes`
        WHERE nom = '$nom' AND telephone = '$telephone' AND email = '$email'
        AND paiement = '$paiement' AND adresse = '$adresse' AND cp = '$cp'
        AND ville = '$ville' AND pays = '$pays' AND total_articles = '$total_articles'
        AND prix_total = '$total_panier'")
        or exit('Echec de la requête');

    // si le panier est vide on renvoie le message suivant
    if($total_panier == 0){
        $message[] = 'Votre panier est vide';
    }else{
        //si la commande a été effectuée ce message s'affiche
        if(mysqli_num_rows($commande_query) > 0){
            $message[] = 'Votre commande a déjà été passée !';
        }else{
            // sinon on insère les données du formulaires de commande dans la table 'commande'
            mysqli_query($con, "INSERT INTO `commandes`(date_commande, client_id, nom, telephone, email, paiement,
                adresse, cp, ville, pays, total_articles, prix_total, vendeur_id)
                VALUES('$date_commande', '$client_id', '$nom', '$telephone', '$email', '$paiement', '$adresse', '$cp', '$ville',
                '$pays', '$total_articles', '$total_panier', '$vendeur_id')")
                or exit('Echec de la requête');
                $message[] = 'Commande effectuée !';
            //une fois la commande validée, le panier se vide
            mysqli_query($con, "DELETE FROM `panier` WHERE `client_id` = '$client_id'")
                or exit('Echec de la requête');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Vérification</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading_checkout">
        <h3>Votre commande</h3>
        <p> <a href="home.php">Accueil</a> / Commande </p>
    </div>

    <section class="display_commande">
        <h3>Votre panier</h3>
        <?php
            $total = 0;
            //on va chercher les données de la table 'panier' liées à l'ID du client
            $select_panier = mysqli_query($con, "SELECT * FROM `panier` 
                WHERE client_id = '$client_id'")
                or die('Echec de la requête');
            if(mysqli_num_rows($select_panier) > 0){
            while($fetch_panier = mysqli_fetch_assoc($select_panier)){
                // le sous_total est égal au prix de l'article par la quantité
                $sous_total = ($fetch_panier['prix'] * 1);
                //le total est égal à la somme de tous les sous totaux des produits
                $total += $sous_total;   
        ?>
        <!-- récapitulatif du panier -->
        <p class="achat"> 
            <?php echo $fetch_panier['marque'] . ', '; ?>
            <?php echo $fetch_panier['modele'] . ', '; ?>
            <span>
                <?php echo $fetch_panier['prix'] . '€' . ', '; ?>
                <span class="qte">Quantité : 1</span> 
            </span>

        </p>
        <?php
                }
            } else {
                echo '<p class="vide">Votre panier est vide</p>';
            }
        ?>
        <!-- affichage du total à payer -->
        <div class="total_panier">
            <p class="total">Total à payer : <span><?php echo $total; ?> €</span></p>
        </div>

    </section>

    <section class="checkout">

    <!-- formulaire de validation de la commande -->
        <form action="" method="post">
            <h3>Valider votre commande</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Votre nom :</span>
                    <input type="text" name="nom" placeholder="entrer votre nom" required>
                </div>
                <div class="inputBox">
                    <span>Votre telephone :</span>
                    <input type="text" name="telephone" placeholder="numero de telephone" required>
                </div>
                <div class="inputBox">
                    <span>Votre email :</span>
                    <input type="email" name="email" placeholder="entrer votre email" required>
                </div>
                <div class="inputBox">
                    <span>Mode de paiement :</span>
                    <select name="paiement">
                        <option value=""></option>
                        <option value="Paiement à la livraison">Paiement à la livraison</option>
                        <option value="Carte bancaire">Carte bancaire</option>
                        <option value="Virement bancaire">Virement bancaire</option>
                        <option value="Paypal">Paypal</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Adresse :</span>
                    <input type="text" name="adresse" placeholder="entrer votre adresse" required>
                </div>
                <div class="inputBox">
                    <span>Code postal :</span>
                    <input type="text" name="cp" placeholder="code postal" required>
                </div>
                <div class="inputBox">
                    <span>Ville :</span>
                    <input type="text" name="ville" placeholder="votre ville" required>
                </div>
                <div class="inputBox">
                    <span>Pays :</span>
                    <input type="text" name="pays" placeholder="votre pays" required>
                </div>
                <input type="hidden" name="idvendeur">
            </div>
            <input type="submit" class="btn" name="commander" value="Commmander" />
        </form>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>