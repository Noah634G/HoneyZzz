<?php
require('include/connect.php');
require('include/fonctions.php');

session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: connexion.php");
    exit();
}

$connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE, BD);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 
include('navbar.php'); 
?>

<h1>Gestion des ruches</h1>

<?php AfficherRuchesAdmin($connexion); ?>

</body>
</html>
