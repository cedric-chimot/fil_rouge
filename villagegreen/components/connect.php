<?php

//nom de la BDD et lien vers l'hôte local
$db_name = 'mysql:host=localhost;dbname=villagegreen';
//nom d'utilisateur dans la BDD
$user_name = 'cedricCH';
//mot de passe de l'utilisateur
$user_password = 'PZ!xv5U@fVu.Af8Y';

//variable de connexion à la BDD
$conn = new PDO($db_name, $user_name, $user_password);
