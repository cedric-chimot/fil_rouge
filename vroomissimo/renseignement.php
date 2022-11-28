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

//paramétrage de l'envoi du message
if(isset($_POST['envoyer'])) {

    //déclaration des variables en rapport avec les inputs
    $num_commande = mysqli_real_escape_string($con, $_POST['num_commande']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $nom = mysqli_real_escape_string($con, $_POST['nom']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $telephone = $_POST['telephone'];
    $msg = mysqli_real_escape_string($con, $_POST['message']);

    //connexiion à la table 'message'
    $select_message = mysqli_query($con, "SELECT * FROM `contact_commandes`
        WHERE `num_commande` = '$num_commande' AND `contact` = '$contact'
        AND `nom` = '$nom' AND `email` = '$email' AND `telephone` = '$telephone'
        AND `message` = '$msg'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    // si le message a déjà été envoyé on affiche ceci
    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'Message déjà envoyé !';
    }else{
        //sinon on insère les données dans la table 'message'
        mysqli_query($con, "INSERT INTO `contact_commandes` (`num_commande`, `idvendeur`, `client_id`, `contact`, `nom`,
            `email`, `telephone`, `message`)
            VALUES ('$num_commande', '$vendeur_id', '$client_id', '$contact', '$nom', '$email', '$telephone', '$msg')")
            or exit('Echec de la requête');
        $message[] = 'Message envoyé !';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Contact</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="contact_commande">
        <h3>Contactez le vendeur</h3>
        <p> <a href="home.php">Accueil</a> / Contact </p>
    </div>

    <!-- formulaire des messages -->
    
    <section class="contact">
        <h1 class="titre">Votre message :</h1>
        <form method="post" action="">
            <input type="text" name="num_commande" class="box" placeholder="entrer le numero de la commande">
            <input type="text" name="contact" class="box" placeholder="entrer le nom du contact" required>
            <input type="text" name="nom" class="box" placeholder="entrer votre nom" required>
            <input type="text" name="email" class="box" placeholder="entrer votre email" required>
            <input type="number" name="telephone" class="box" placeholder="numéro de téléphone" required>
            <textarea name="message" class="box" placeholder="taper votre message"
            cols="30" rows="10"></textarea>
            <input type="submit" name="envoyer" class="btn" value="Envoyer">
        </form>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>