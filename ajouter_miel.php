<?php  
require('include/connect.php'); 
require('include/fonctions.php'); 

session_start();

// Vérification de connexion (Seulement si l'utilisateur est logué)
if (empty($_SESSION['mailU']) || $_SESSION['role'] !== 'apiculteur') {
    $_SESSION['message'] = "Accès réservé. Vous devez être connecté en tant qu'apiculteur.";
    header("Location:connexion.php");
    exit();
}

$connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE, BD);
$mailU = $_SESSION['mailU'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link href="style.css" rel="stylesheet">
  <title>Ajouter une Récolte – HoneyZzz</title>
</head>
<body>

<nav>
    </nav>

<main class="container-form">
    <div class="form-card">
        <h2>Nouvelle Récolte de Miel</h2>
        <form action="ajouter_miel_action.php" method="POST">
            
            <div class="form-group">
                <label for="nomProduit">Nom du produit (ex: Miel de Printemps)</label>
                <input type="text" name="nomProduit" id="nomProduit" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix (€)</label>
                <input type="number" step="0.01" name="prix" id="prix" required>
            </div>

            <div class="form-group">
                <label for="dateRecolte">Date de récolte</label>
                <input type="date" name="dateRecolte" id="dateRecolte" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label for="format">Format (ex: Pot de 500g)</label>
                <input type="text" name="format" id="format" placeholder="500g, 1kg...">
            </div>

            <div class="form-group">
                <label for="idRuche">Ruche d'origine (Optionnel)</label>
                <select name="idRuche" id="idRuche">
                    <option value="">-- Aucune ruche spécifique --</option>
                    <?php 
                    // Correction de la requête : ajout des "ON" pour les jointures
                    $query = "SELECT R.idRuche, R.nom 
                              FROM Ruche R
                              INNER JOIN Gerer G ON R.idRuche = G.idRuche
                              INNER JOIN Utilisateur U ON G.idUtilisateur = U.idUtilisateur
                              WHERE U.mailU = '$mailU'";
                                              
                    $res = mysqli_query($connexion, $query);
                    
                    if ($res && mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<option value='".$row['idRuche']."'>".$row['nom']."</option>";
                        }
                    } else {
                        echo "<option value=''>Aucune ruche trouvée pour votre compte</option>";
                    }
                    ?>
                </select>
            </div>


            <div class="form-buttons">
                <a href="boutique.php" class="btn-annuler">Annuler</a>
                <button type="submit" class="btn-valider">Enregistrer le produit</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
