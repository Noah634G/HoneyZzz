<?php  require('include/connect.php'); ?>
<?php  require('include/fonctions.php'); ?>
<?php
session_start();

$connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

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
    <title>HoneyZzz - Humidité <?php echo $nomRuche; ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="navgauche">
    
    <nav class="sidebar">
        <a href="temperature.php?nom=<?php echo $nomRuche; ?>" class="nav-item">Température</a>
        
        <a href="humidite.php?nom=<?php echo $nomRuche; ?>" class="nav-item">Humidité</a>
        
        <a href="poids.php?nom=<?php echo $nomRuche; ?>" class="nav-item">Poids</a>
        
        <a href="activite.php?nom=<?php echo $nomRuche; ?>" class="nav-item">Activité</a>
        
        <a href="consommation.php?nom=<?php echo $nomRuche; ?>" class="nav-item">Consommation</a>
        
        <a href="controleruche.php?nom=<?php echo $nomRuche; ?>" class="nav-item active">Contrôle</a>

        <a href="apiculteur.php" class="btn-retour">Retour</a>
    </nav>
</div>

<div class="content">
    <h1>Humidité de <?php echo $nomRuche; ?></h1> 

</div>
<?php

$query = "SELECT H.valeur, H.datedbt 
          FROM Historique H
          JOIN Multisensor M ON H.idSensor = M.idSensor
          JOIN Ruche R ON M.idRuche = R.idRuche
          WHERE R.nom = '$nomRuche' 
          AND H.typeEvenement = 'humidite'
          ORDER BY H.datedbt ASC"; 

$resultat = mysqli_query($connexion, $query);

$labels = []; 
$valeurs = []; 

if ($resultat) {
    while($row = mysqli_fetch_assoc($resultat)) {
        // datedbt est au format '2026-04-01' dans tes INSERT
        // On le transforme en format plus lisible pour l'axe X
        $labels[] = date("d/m H:i", strtotime($row['datedbt'])); 
        $valeurs[] = $row['valeur']; // C'est ici qu'est stocké 35.5[cite: 1]
    }
}

$jsonLabels = json_encode($labels);
// json_encode va transformer ["35.5"] en [35.5] si tu forces le type float
$jsonValeurs = json_encode(array_map('FLOATval', $valeurs));
?>

<script src="chart.umd.js"></script>

<div style="width: 100%; max-width: 800px; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <canvas id="monGraphique"></canvas>
</div>

<script>
// On attend que toute la page soit chargée avant de dessiner
window.onload = function() {
    const canvas = document.getElementById('monGraphique');
    if (!canvas) {
        console.error("Canvas introuvable !");
        return;
    }

    const ctx = canvas.getContext('2d');
    
    // On récupère les données PHP passées en JSON
    const labels = <?php echo $jsonLabels; ?>;
    const dataValues = <?php echo $jsonValeurs; ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Humidité (%)',
                data: dataValues,
                borderColor: '#ffcc00',
                backgroundColor: 'rgba(255, 204, 0, 0.2)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    min: 40,
                    max: 90,
                    title: { display: true, text: 'Humidité (%)' }
                }
            }
        }
    });
};
</script>

</body>
</html>
