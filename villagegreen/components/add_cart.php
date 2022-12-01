<?php

//lien avec le bouton d'ajout au panier
if (isset($_POST['add_to_cart'])) {
   
   if ($user_id == '') {
      //si l'utilisateur n'est pas connecté on le renvoie sur la page de login
      header('location:user_login.php');
   } else {

      //déclaration des variables
      $pid = $_POST['pid'];
      //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
      $pid = htmlspecialchars($pid);
      $name = $_POST['name'];
      $name = htmlspecialchars($name);
      $price = $_POST['price'];
      $price = htmlspecialchars($price);
      $image = $_POST['image'];
      $image = htmlspecialchars($image);
      $qty = $_POST['qty'];
      $qty = htmlspecialchars($qty);

      //connexion avec la table 'panier' dans la BDD
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE libelle = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      //si le produit est déjà dans le panier le message d'erreur s'affiche
      if ($check_cart_numbers->rowCount() > 0) {
         $message[] = 'Produit déjà ajouté !';
      } else {
         //sinon on insère les données dans la table
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, libelle, prix, quantite, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'Produit ajouté au panier !';
      }
   }
}
