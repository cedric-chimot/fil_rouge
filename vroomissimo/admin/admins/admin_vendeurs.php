<?php

//connexion à la base de données
include 'config.php';

//ouverture de la session
session_start();

$admin_id = $_SESSION['admin_id'];

//si la personne connectée n'est pas un admin, on la renvoie vers la page login
if (!isset($admin_id)) {
    header('location:login.php');
};

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
    //création de la variable et association avec le bouton de suppression
    $delete_id = $_GET['delete'];
    //on va chercher dans la BDD l'utilisateur correspondant à l'ID
    mysqli_query($con, "DELETE FROM `vendeur` WHERE idvendeur = '$delete_id'")
    //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');
    //renvoie vers la page d'administration des utilisateurs
    header('location:admin_vendeurs.php');
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
    <link rel="stylesheet" href="css/admin.css">
    <title>Utilisateurs</title>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="users">

        <h1 class="titre">Comptes d'utilisateurs</h1>

        <div class="box-container">

            <?php
            //on va chercher dans la BDD tous les utilisateurs avec le statut client
                $select_vendeur = mysqli_query($con, "SELECT * FROM `vendeur`")
                    or exit("Echec de la requête");
            // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                while ($fetch_vendeur = mysqli_fetch_assoc($select_vendeur)) {
                ?>
                <div class="box">
                    <p>Nom : <span><?php echo $fetch_vendeur['nom']; ?></span></p>
                    <p>Adresse : <span><?php echo $fetch_vendeur['adresse']; ?></span></p>
                    <p>CP : <span><?php echo $fetch_vendeur['cp']; ?></span></p>
                    <p>Ville : <span><?php echo $fetch_vendeur['ville']; ?></span></p>
                    <p>Email : <span><?php echo $fetch_vendeur['email']; ?></span></p>
                    <p>Type d'utilisateur :
                        <span style="color:
                            <?php if ($fetch_vendeur['type_user'] == 'admin') {
                                echo 'var(--rouge)';
                            } else {
                                echo 'var(--orange)';
                            } ?>;"><?php echo $fetch_vendeur['type_user']; ?>
                        </span>
                    </p>
                    <a href="admin_vendeurs.php?delete=<?php echo $fetch_vendeur['idvendeur']; ?>"
                        class="delete-btn" onclick="return confirm('Voulez-vous supprimer cet utilisateur ?');">
                        Supprimer
                    </a>
                </div>
            <?php
            };
            ?>

        </div>

    </section>

    <script src="js/admin_script.js"></script>

</body>

</html>