<?php

include 'components/connect.php';

//ouverture de la session
session_start();

$user_id = $_SESSION['user_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($user_id)) {
    header('location:user_login.php');
};

?>