<?php

//connexion à la BDD
include 'components/connect.php';

//début de la session
session_start();

//si l'ulisateur est connecté on renvoie ses identifiants sinon ça reste vide
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

//paramétrage de la fonction de passation de commande
if (isset($_POST['order'])) {

   //déclaration des variables
   $nom = $_POST['nom'];
   //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $nom = htmlspecialchars($nom);
   $prenom = $_POST['prenom'];
   $prenom = htmlspecialchars($prenom);
   $telephone = $_POST['telephone'];
   $telephone = htmlspecialchars($telephone);
   $adresse = $_POST['adresse'];
   $adresse = htmlspecialchars($adresse);
   $cp = $_POST['cp'];
   $cp = htmlspecialchars($cp);
   $ville = $_POST['ville'];
   $ville = htmlspecialchars($ville);
   $total_produits = $_POST['total_produits'];
   $prixTTC = $_POST['prixTTC'];

   //connexion à la table 'cart' dans la BDD
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      //on insert les données dans la table 'orders' dans la BDD
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, nom, prenom, telephone, adresse, cp, ville, total_produits, prixTTC)
         VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $nom, $prenom, $telephone, $adresse, $cp, $ville, $total_produits, $prixTTC]);

      //les articles dans le panier sont alors supprimés
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      //une fois la commande validée on affiche ce message
      $message[] = 'Commande effectuée !';
   } else {
      //sinon on affiche celui-ci
      $message[] = 'Votre panier est vide !';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Passer commande</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="checkout-orders">

      <form action="" method="POST">

         <h3>Votre panier</h3>

         <div class="display-orders">
            <?php
            //paramétrage de la variable 'total'    
            $total = 0;
            //paramétrage de la variable 'cart_items' 
            $cart_items[] = '';
            //connexion à la table 'cart' dans la BDD par rapport à l'ID utilisateur
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               //association avec la table par un fetch pour récupérer les valeurs dans la table
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['libelle'] . ' (' . $fetch_cart['prix'] . ' x ' . $fetch_cart['quantite'] . ') - ';
                  //'implode' : Rassemble les éléments d'un tableau en une chaine de caractères
                  $total_products = implode($cart_items);
                  $total += ($fetch_cart['prix'] * $fetch_cart['quantite']);
            ?>
                  <p> <?= $fetch_cart['libelle']; ?> <span>(<?= $fetch_cart['prix'] . ' € x ' . $fetch_cart['quantite']; ?>)</span> </p>
            <?php
               }
            } else {
               //si le panier est vide cette phrase s'affiche
               echo '<p class="empty">Votre panier est vide !</p>';
            }
            ?>
            <!-- input type 'hidden' pour récupérer le nombre de produits et le montant du panier -->
            <input type="hidden" name="total_produits" value="<?= $total_products; ?>">
            <input type="hidden" name="prixTTC" value="<?= $total; ?>" value="">
            <!-- affichage du total à payer -->
            <div class="grand-total">Total à payer : <span><?= $total; ?> €</span></div>
         </div>

         <!-- formulaire de validation de commande -->
         <h3>Passer votre commande</h3>

         <div class="flex">
            <div class="inputBox">
               <span>Nom :</span>
               <input type="text" name="nom" placeholder="entrer votre nom" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>Prenom :</span>
               <input type="text" name="prenom" placeholder="entrer votre prénom" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Telephone</span>
               <input type="number" name="telephone" placeholder="numéro de téléphone" class="box" min="0" max="9999999999" required>
            </div>
            <div class="inputBox">
               <span>Addresse :</span>
               <input type="text" name="adresse" placeholder="adresse" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>CP :</span>
               <input type="text" name="cp" placeholder="code postal" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Ville :</span>
               <input type="text" name="ville" placeholder="ville" class="box" maxlength="50" required>
            </div>
         </div>

         <!-- le bouton de passation de commande est inactif si le panier est vide -->
         <input type="submit" name="order" class="option-btn <?= ($total > 1) ? '' : 'disabled'; ?>" value="Passer commande">

      </form>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>