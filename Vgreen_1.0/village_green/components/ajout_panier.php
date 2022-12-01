<?php

if(isset($_POST['ajout_panier'])){

if($user_id == ''){
    header('location:user_login.php');
}else{

    $produit_id = $_POST['id'];
    $produit_id = htmlspecialchars($produit_id);
    $libelle = $_POST['libelle'];
    $libelle = htmlspecialchars($libelle);
    $prix = $_POST['prix'];
    $prix = htmlspecialchars($prix);
    $qte = $_POST['qte'];
    $qte = htmlspecialchars($qte);
    $image = $_POST['image'];
    $image = htmlspecialchars($image);

    $check_nombres_panier = $conn->prepare("SELECT * FROM `panier` WHERE produit_id = ? AND user_id = ?");
    $check_nombres_panier->execute([$produit_id, $user_id]);

    // $produit_id = $conn->prepare("SELECT DISTINCT produit_id.produits FROM `produits` LEFT JOIN panier ON produit_id.panier = produit_id.produits");
    // $produit_id->execute([$produit_id]);

    if($check_nombres_panier->rowCount() > 0){
        $message[] = 'Produit déjà ajouté au panier !';
    }else{
        $insert_panier = $conn->prepare("INSERT INTO `panier`(user_id, libelle, prix, quantite, image)
            VALUES(?,?,?,?,?)");
        $insert_panier->execute([$user_id, $libelle, $prix, $qte, $image]);
        $message[] = 'Produit ajouté !';
    }
}

}