<?php

//connexion à la BDD
include 'components/connect.php';

//début de la session
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

//validation du formulaire de connexion
if(isset($_POST['submit'])){
    //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
    $email = htmlspecialchars($_POST['email']);
    //'sha1' : Hachage du mot de passe
    $password = sha1($_POST['password']);       
    $password = filter_var($password); 

    //connexion à la BDD par la table client
    $select_users = $conn->prepare("SELECT * FROM `users`
        WHERE email = ? AND mdp = ?");
    $select_users->execute([$email, $password]);
    //association avec les données présentes dans la BDD
    $row = $select_users->fetch(PDO::FETCH_ASSOC);

    //on vérifie si l'utilisateur existe déjà
    if($select_users->rowCount() > 0){
        $_SESSION['user_id'] = $row['user_id'];
        header("location:home.php");
    }else{
        //message d'erreur si les mdp sont différents
        $message[] = 'Mot de passe ou email incorrect';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include 'user_header.php' ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>Connectez-vous</h3>
            <!-- utilisation de regex pour supprimer les espaces dans le mail -->
            <input type="email" name="email" required placeholder="entrer votre email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="password" required placeholder="mot de passe" class="box">
            <input type="submit" value="Se connecter" class="btn" name="submit">
            <p>Vous n'avez pas encore de compte ?</p>
            <a href="user_register.php" class="option-btn">S'enregistrer</a>
        </form>

    </section>


    <script src="assets/js/script.js"></script>

</body>

</html>