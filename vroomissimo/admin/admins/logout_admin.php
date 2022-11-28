<?php

//connexion à la base de données
include 'config.php';

//ouverture de la session
session_start();
// Détruit toutes les variables d'une session
session_unset();
//Détruit la session
session_destroy();

//redirection vers la page de login
header('location:login_admin.php');