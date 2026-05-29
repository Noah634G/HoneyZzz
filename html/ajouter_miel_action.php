<?php  
require('include/connect.php'); 
require('include/fonctions.php'); 

session_start();

if (empty($_SESSION['mailU'])) {
    header("Location: connexion.php");
    exit();
}

$connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

// 1. Récupération sécurisée des données du formulaire
$nomProduit  = mysqli_real_escape_string($connexion, $_POST['nomProduit']);
$prix        = $_POST['prix'];
$dateRecolte = $_POST['dateRecolte'];
$format      = mysqli_real_escape_string($connexion, $_POST['format']);

// Correction ici : on vérifie que la clé existe dans $_POST
$idRuche     = isset($_POST['idRuche']) ? $_POST['idRuche'] : null;

// 2. Récupération de l'ID de l'utilisateur (Apiculteur)
$mailU = $_SESSION['mailU'];
$reqUser = mysqli_query($connexion, "SELECT idUtilisateur FROM Utilisateur WHERE mailU = '$mailU'");
$dataUser = mysqli_fetch_assoc($reqUser);
$idUtilisateur = $dataUser['idUtilisateur'];

// Vérification de sécurité : si idRuche est vide, on affiche une erreur propre
if (empty($idRuche)) {
    die("Erreur : Vous devez sélectionner une ruche valide.");
}

// 3. Requête d'insertion (Ligne 29 environ)
// On s'assure que $idRuche et $idUtilisateur sont passés sans guillemets s'ils sont des INT
$sql = "INSERT INTO Produit (nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) 
        VALUES ('$nomProduit', $prix, '$dateRecolte', '$format', $idUtilisateur, $idRuche)";

$resultat = mysqli_query($connexion, $sql);

if ($resultat) {
    header("Location: boutique.php?success=1");
} else {
    echo "Erreur SQL : " . mysqli_error($connexion);
}
?>
