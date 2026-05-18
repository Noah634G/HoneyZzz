<?php
require('include/connect.php');
require('include/fonctions.php');

session_start();
$connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE,BD);
if (empty($_SESSION['mailU'])) {
    $_SESSION['message'] = "Vous devez être connecté.";
    header("Location: connexion.php");
    exit();
}

$commandeValidee = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = date("Y-m-d"); // date actuelle
    $total = getTotalPanier();
    
    // 1. On récupère le mail en session
    $mailU = $_SESSION['mailU'];

    // 2. On cherche l'idUtilisateur correspondant dans la base
    $requete = mysqli_query($connexion, "SELECT idUtilisateur FROM Utilisateur WHERE mailU = '$mailU'");
    $donnees = mysqli_fetch_assoc($requete);
    $idUtilisateur = $donnees['idUtilisateur'];

    // 3. On peut maintenant appeler la fonction sans erreur
    AjouterCommande($connexion, $date, $total, $idUtilisateur);

    viderPanier();
    $commandeValidee = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation commande</title>

    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="commande-box">

<?php if (!$commandeValidee): ?>

    <h1 class="commande-title">Confirmation commande</h1>

    <form method="POST">
        <button type="submit" class="btn-valider">
            ✔ Valider la commande
        </button>
    </form>

<?php else: ?>
    <h1 class="commande-success-title">Commande validée</h1>
    <p class="commande-success">
        Votre commande a été validée avec succès.
    </p>
    <a href="boutique.php" class="btn-retour-boutique">
        Retour à la boutique
    </a>
<?php endif; ?>

</div>

</body>
</html>
