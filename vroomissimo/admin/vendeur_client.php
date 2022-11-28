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

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
    //création de la variable et association avec le bouton de suppression
    $delete_id = $_GET['delete'];
    //on va chercher dans la BDD l'utilisateur correspondant à l'ID
    mysqli_query($con, "DELETE FROM `client` WHERE idclient = '$delete_id'")
    //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');
    //renvoie vers la page d'administration des utilisateurs
    header('location:admin_users.php');
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
    <title>Utilisateurs</title>
</head>

<body>

    <?php include 'vendeur_header.php'; ?>

    <section class="users">

        <h1 class="titre">Comptes d'utilisateurs</h1>

        <div class="box-container">

            <?php
            //on va chercher dans la BDD tous les utilisateurs avec le statut client
                $select_users = mysqli_query($con, "SELECT * FROM `client`")
                    or exit("Echec de la requête");
            // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                ?>
                <div class="box">
                    <p>Nom : <span><?php echo $fetch_users['nom']; ?></span></p>
                    <p>Adresse : <span><?php echo $fetch_users['adresse']; ?></span></p>
                    <p>CP : <span><?php echo $fetch_users['cp']; ?></span></p>
                    <p>Ville : <span><?php echo $fetch_users['ville']; ?></span></p>
                    <p>Email : <span><?php echo $fetch_users['email']; ?></span></p>
                    <p>Type d'utilisateur :
                        <span style="color:
                            <?php if ($fetch_users['type_user'] == 'vendeur') {
                                echo 'var(--orange)';
                            } else {
                                echo 'var(--violet)';
                            } ?>;"><?php echo $fetch_users['type_user']; ?>
                        </span>
                    </p>
                    <a href="vendeur_client.php?delete=<?php echo $fetch_users['idclient']; ?>"
                        class="delete-btn" onclick="return confirm('Voulez-vous supprimer cet utilisateur ?');">
                        Supprimer
                    </a>
                </div>
            <?php
            };
            ?>

        </div>

    </section>

    <script src="admins/js/admin_script.js"></script>

</body>

</html>