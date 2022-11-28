<?php

//connexion à la base de données
include 'admins/config.php';

//ouverture de la session
session_start();

$vendeur_id = $_SESSION['vendeur_id'];

//si la personne connectée n'est pas un admin, on la renvoie vers la page login
if (!isset($vendeur_id)) {
    header('location:login_vendeur.php');
};

//paramétrage de la fonction 'update'
if(isset($_POST['update_commande'])){
    //on va chercher l'ID et le statut de la commande dans le formulaire
    //création des variables
    $update_commande_id = $_POST['commande_id'];
    $update_paiement = $_POST['update_paiement'];
    //connexion puis MAJ de la table 'commande' au niveau de la colonne 'statut_paiement'
    mysqli_query($con, "UPDATE `commandes`
        SET statut_paiement = '$update_paiement'
        WHERE id = '$update_commande_id'")
    //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');
    //à la validation, le message de confirmation s'affiche
    $message[] = 'Statut de la commande mis à jour !';
}

//paramétrage de la fonction 'delete'
if(isset($_GET['delete'])){
    //association du bouton 'delete' avec l'ID de la commande
    $delete_commande_id = $_GET['delete'];
    //requête de suppression avec lien vers la table 'commande'
    mysqli_query($con, "DELETE FROM `commande` WHERE id = '$delete_commande_id'")
    or exit('Echec de la requête');
    //renvoie vers la liste des commandes réglées
    header('location:commandes_dues.php');
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
    <link rel="stylesheet" href="admins/css/admin.css">
    <title>Commandes</title>
</head>

<body>

    <?php include 'vendeur_header.php'; ?>

    <section class="commandes">

        <h1 class="titre">Commandes en attente</h1>

        <div class="box-container">
            <?php
                //connexion à la table 'commande' dans la BDD
                //requête pour selectionner la colonne 'statut_paiement' avec le paramètre 'en attente'
                $select_commandes = mysqli_query($con, "SELECT * FROM `commandes`
                    WHERE statut_paiement = 'en attente' AND vendeur_id = '$vendeur_id'")
                    or exit("Echec de la requête");
                // Retourne le nombre de lignes dans le jeu de résultats
                if(mysqli_num_rows($select_commandes) > 0){
                    // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                    while($fetch_commande = mysqli_fetch_assoc($select_commandes)){
            ?>
        
            <!-- création de la div correspondante lorque la commande est réglée -->
            <div class="box">
                <p>Date commande : 
                    <span><?php echo $fetch_commande['date_commande']?></span> 
                </p>
                <p>ID Client : <span><?php echo $fetch_commande['client_id']?> </span> </p>
                <p>Nom : <span><?php echo $fetch_commande['nom']?> </span> </p>
                <p>Telephone : <span><?php echo $fetch_commande['telephone']?> </span> </p>
                <p>Email : <span><?php echo $fetch_commande['email']?> </span> </p>                
                <p>Adresse : <span><?php echo $fetch_commande['adresse']?> </span> </p>
                <p>CP : <span><?php echo $fetch_commande['cp']?> </span> </p>
                <p>Ville : <span><?php echo $fetch_commande['ville']?> </span> </p>
                <p>Pays : <span><?php echo $fetch_commande['pays']?> </span> </p>
                <p>Total articles : 
                    <span><?php echo $fetch_commande['total_articles']?> </span> 
                </p>
                <p>Prix total : 
                    <span><?php echo $fetch_commande['prix_total']?> € </span> 
                </p>
                <p>Paiement : <span><?php echo $fetch_commande['paiement']?> </span> </p>
                <form action="" method="post">
                    <input type="hidden" name="commande_id"
                        value="<?php echo $fetch_commande['id']; ?>">
                    <select name="update_paiement">
                        <option value="" selected disabled>
                            <?php echo $fetch_commande['statut_paiement']; ?>
                        </option>
                        <option value="en attente">en attente</option>
                        <option value="completee">completee</option>
                    </select>
                    <input type="submit" value="Modifier" name="update_commande" class="option-btn">
                    <!-- 'return confirm' : renvoie une fenêtre de confirmation pour valider la suppression -->
                    <a href="vendeur_commandes.php?delete=<?php echo $fetch_commande['id']; ?>"
                        onclick="return confirm('supprimer cette commande ?');" class="delete-btn">Supprimer</a>
                </form>
            </div>
            <?php
                        }
                    }else{
                        //s'il n'y a aucune commande on affiche ce message
                        echo '<p class="vide">Aucune commandes en cours</p>';
                }
            ?>
        </div>

    </section>

    <script src="admins/js/admin_script.js"></script>

</body>

</html>