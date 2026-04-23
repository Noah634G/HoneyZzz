<?php  require('include/connect.php'); ?>
<?php  require('include/fonctions.php'); ?>
<?php
session_start();

// 1. Sécurité
if (empty($_SESSION['mailU'])) {
    header("Location: connexion.php");
    exit();
}

// 2. Récupération du nom de la ruche
$nomRuche = isset($_GET['nom']) ? $_GET['nom'] : "Ruche inconnue";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HoneyZzz - Contrôle <?php echo $nomRuche; ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    