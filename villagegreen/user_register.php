<?php

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
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $cp = htmlspecialchars($_POST['cp']);
    $ville = htmlspecialchars($_POST['ville']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['password']);       
    $password = filter_var($password);   
    $password_retype = sha1($_POST['password_retype']);
    $password_retype = filter_var($password_retype); 

    $select_client = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_client->execute([$email]);

    if($select_client->rowCount() > 0){
        $message[] = 'Utilisateur existant !';
    }else{
        if($password != $password_retype){
            $message[] = 'Les mots de passe ne correspondent pas !';
        }else{
            $insert_users = $conn->prepare("INSERT INTO `users`(nom, prenom, adresse, cp, ville, telephone, email, mdp)
                VALUES(?,?,?,?,?,?,?,?)");
            $insert_users->execute([$nom, $prenom, $adresse, $cp, $ville, $telephone, $email, $password]);
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
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include 'user_header.php' ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>Inscrivez-vous</h3>
            <label for="nom">Nom</label>
            <input type="text" name="nom" required placeholder="nom" maxlength="50"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" required placeholder="prenom" maxlength="50"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" required placeholder="adresse" maxlength="50" class="box")">
            <label for="cp">Code postal</label>
            <input type="text" name="cp" required placeholder="code postal" maxlength="50"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <label for="ville">Ville</label>
            <input type="text" name="ville" required placeholder="ville" maxlength="50"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" required placeholder="numéro de téléphone" maxlength="50"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <label for="email">Email</label>
            <input type="email" name="email" required placeholder="email" maxlength="50"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" required placeholder="mot de passe" class="box">
            <label for="password">Confirmer le mot de passe</label>
            <input type="password" name="password_retype" required placeholder="confirmer le mot de passe" class="box">   
            <input type="submit" value="S'inscrire" class="btn" name="submit">
            <p>Vous possédez déjà un compte ?</p>
            <a href="user_login.php" class="option-btn">Se connecter</a>
        </form>

    </section>


    <script src="assets/js/script.js"></script>

</body>

</html>