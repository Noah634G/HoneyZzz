<?php  require('include/connect.php'); ?>
<?php  require('include/fonctions.php'); ?>

<?php
// On inclut la connexion et tes fonctions
session_start();

$connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

// 2. Récupérer l'ID de l'utilisateur à partir de son mail en session
$mailU = isset($_SESSION['mailU']) ? $_SESSION['mailU'] : 'Non défini';
$requete = mysqli_query($connexion, "SELECT idUtilisateur FROM Utilisateur WHERE mailU = '$mailU'");
$donnees = mysqli_fetch_assoc($requete);

// On sécurise l'ID s'il n'est pas trouvé
$idUtilisateur = isset($donnees['idUtilisateur']) ? $donnees['idUtilisateur'] : 0;

// 3. Récupérer les données du formulaire
$nom = $_POST['nom']; 
$date = $_POST['dateInstallation'];
$espece = $_POST['especeAbeille'];
$statut = $_POST['statut'];
$idEmplacement = $_POST['idEmplacement'];


$resultat = AjouterRuche($connexion, $nom, $date, $espece, $statut, $idEmplacement, $idUtilisateur);

if ($resultat){
    header("Location: controleruche.php?nom=" . urlencode($nom));
    exit();
}else{
    echo"<p>Une erreur est survenue lors de l'ajout de la ruche. Veuillez réessayer.</p>";
    echo '<a href="apiculteur.php">Retour à l\'accueil .</a>';   
}

?>