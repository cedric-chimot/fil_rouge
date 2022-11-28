<?php

//connexion à la base de données
include '../components/connect.php';

//ouverture de la session
session_start();

$admin_id = $_SESSION['admin_id'];

//si la personne connectée n'est pas un admin, on la renvoie vers la page login
if (isset($admin_id)) {
    header('location:admin_login.php');
};

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
    //création de la variable et association avec le bouton de suppression
    $delete_id = $_GET['delete'];
    //on va chercher dans la BDD l'utilisateur correspondant à l'ID
    mysqli_query($con, "DELETE FROM `client` WHERE client_id = '$delete_id'")
    //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');
    //renvoie vers la page d'administration des utilisateurs
    header('location:admin_client.php');
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
    <link rel="stylesheet" href="assets/css/admin_style.css">
    <title>Utilisateurs</title>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="users">

        <h1 class="titre">Comptes clients</h1>

        <div class="box-container">

            <?php
            //on va chercher dans la BDD tous les utilisateurs avec le statut client
                $select_users = mysqli_query($con, "SELECT * FROM `client`")
                    or exit("Echec de la requête");
                if(mysqli_num_rows($select_users) > 0){
            // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                    while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                ?>
                    <div class="box">
                        <p>Nom : <span><?php echo $fetch_users['nom']; ?></span></p>
                        <p>Prenom : <span><?php echo $fetch_users['prenom']; ?></span></p>
                        <p>Adresse : <span><?php echo $fetch_users['adresse']; ?></span></p>
                        <p>CP : <span><?php echo $fetch_users['cp']; ?></span></p>
                        <p>Ville : <span><?php echo $fetch_users['ville']; ?></span></p>
                        <p>Email : <span><?php echo $fetch_users['email']; ?></span></p>
                        <p>Telephone : <span><?php echo $fetch_users['telephone']; ?></span></p>
                        <a href="admin_client.php?delete=<?php echo $fetch_users['client_id']; ?>"
                            class="delete-btn" onclick="return confirm('Voulez-vous supprimer cet utilisateur ?');">
                            Supprimer
                        </a>
                    </div>
                <?php
                        }
                    }else{
                        //s'il n'y a aucune commande on affiche ce message
                        echo '<p class="vide">Aucun client inscrit</p>';
                }
            ?>

        </div>

    </section>

    <script src="assets/js/admin_script.js"></script>

</body>

</html>