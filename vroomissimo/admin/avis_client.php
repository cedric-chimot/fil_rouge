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
    //association du bouton 'delete' avec l'ID du message
    $delete_id = $_GET['delete'];
    //requête de suppression avec lien vers la table 'message'
    mysqli_query($con, "DELETE FROM `message` WHERE id = '$delete_id'")
    //'or die' renvoie une notification d'erreur si la requête ne peut aboutir
        or die('Echec de la requête');
    //renvoie vers la liste des messages
    header('location:vendeur_contact.php');
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
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="admins/css/admin.css">
    <title>Messages</title>
</head>

<body>

    <?php include 'vendeur_header.php'; ?>

    <section class="messages">

        <h1 class="titre">Commentaires clients</h1>

        <div class="box-container">

            <?php
                //connexion à la table 'message' dans la BDD
                $select_message = mysqli_query($con, "SELECT * FROM `avis`
                    WHERE idvendeur = '$vendeur_id'")
                    or die("Echec de la requête");
                // Retourne le nombre de lignes dans le jeu de résultats
                if(mysqli_num_rows($select_message) > 0){
                    // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                    while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                
            ?>

            <!-- création de la div correspondante quand un message est reçu -->
            <div class="box">
                <p> Nom : <span><?php echo $fetch_message['nom_client']; ?></span></p>
                <p> Note : 
                    <span>
                        <?php
                            switch ($_SERVER["REQUEST_METHOD"] == "POST"){
                                case "0":
                                    if($fetch_message['note'] == 0){
                                        echo '<i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>';
                                        }

                                case "1":
                                    if ($fetch_message['note'] == 1){
                                        echo '<i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>';
                                        }

                                case "2":
                                    if ($fetch_message['note'] == 2){
                                        echo '<i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>';
                                        }
                                
                                case "3":
                                    if ($fetch_message['note'] == 3){
                                        echo '<i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="lar la-star" style="color: black;"></i>
                                            <i class="lar la-star" style="color: black;"></i>';
                                        }

                                case "4":
                                    if ($fetch_message['note'] == 4){
                                        echo '<i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="lar la-star" style="color: black;"></i>';
                                    }

                                case "5":
                                    if ($fetch_message['note'] == 5){
                                        echo '<i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>
                                            <i class="las la-star" style="color: goldenrod;"></i>';
                                    }
                            }
                        ?>
                    </span>
                </p>
                <p> Commentaire : <span><?php echo $fetch_message['avis']; ?></span></p>
                <a href="board_vendeur.php" class="option-btn">Retour</a>
                <a href="avis_client.php?delete=<?php echo $fetch_message['id']; ?>"
                    class="delete-btn" onclick="return confirm('Voulez-vous supprimer ce commentaire ?');">Supprimer le commentaire
                </a>
            </div>

            <?php
                };
            }else{
                //s'il n'y a aucun message on affiche ceci :
                echo "<p class='vide' style='color: var(--rouge);'>Vous n'avez pas encore d'avis client</p>";
            }
            ?>

        </div>

    </section>


    <script src="admins/js/admin_script.js"></script>

</body>

</html>