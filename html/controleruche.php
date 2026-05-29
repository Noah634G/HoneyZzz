<?php  require('include/connect.php'); ?>
<?php  require('include/fonctions.php'); ?>
<?php
session_start();

if (empty($_SESSION['mailU'])) {
    header("Location: connexion.php");
    exit();
}

$connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

$nomRuche = isset($_GET['nom']) ? $_GET['nom'] : "Ruche inconnue";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HoneyZzz - Contrôle <?php echo htmlspecialchars($nomRuche); ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<!-- ── Sidebar ── -->
<div class="navgauche">
    <nav class="sidebar">
        <a href="temperature.php?nom=<?php echo $nomRuche ?>"  class="nav-item">Température</a>
        <a href="humidite.php?nom=<?= urlencode($nomRuche) ?>"     class="nav-item">Humidité</a>
        <a href="poids.php?nom=<?= urlencode($nomRuche) ?>"        class="nav-item">Poids</a>
        <a href="activite.php?nom=<?= urlencode($nomRuche) ?>"     class="nav-item">Activité</a>
        <a href="consommation.php?nom=<?= urlencode($nomRuche) ?>" class="nav-item">Consommation</a>
        <a href="controleruche.php?nom=<?= urlencode($nomRuche) ?>" class="nav-item active">Contrôle</a>
        <a href="apiculteur.php" class="btn-retour">← Retour</a>
    </nav>
</div>

<!-- ── Contenu principal ── -->
<main class="main-content">
    <h1>Tableau de bord — <?php echo htmlspecialchars($nomRuche); ?></h1>

    <div class="dashboard-grid">

        <div class="widget widget-conso">
    <div class="widget-titre">
        Consommation Prise — Temps réel
    </div>

    <div class="conso-live-wrap" style="text-align: center; padding: 20px 0;">
        <span class="conso-valeur" id="valeur-conso" style="font-size: 3rem; font-weight: bold; color: #ffcc00;">--</span>
        <span class="conso-unite" id="unite-conso" style="font-size: 1.2rem; color: #666;">Watt</span>
    </div>

    <div class="conso-statut" style="font-size: 0.8rem; text-align: center; color: #888; border-top: 1px solid #eee; padding-top: 10px;">
        <span id="statut-conso">Initialisation...</span>
    </div>
</div>

<div class="widget widget-conso">
    <div class="widget-titre">Multisensor — Temps réel </div>
    <div style="padding: 15px;">
        <p>Température : <span id="multi-temp" style="font-weight:bold; color: #ffcc00;">--</span> °C</p>
        <p>Humidité : <span id="multi-humi" style="font-weight:bold;color: #ffcc00;">--</span> %</p>
        <p>Luminosité : <span id="multi-lux" style="font-weight:bold;color: #ffcc00;">--</span> Lux</p>
        <p>UV : <span id="multi-uv" style="font-weight:bold;color: #ffcc00;">--</span> </p>
    </div>
</div>

<div class="widget widget-conso">
    <div class="widget-titre">Multisensor — Temps réel </div>
    <div style="padding: 15px;">
        <p>Mouvement : <span id="multi-mouv" style="font-weight:bold; color: #ffcc00;">--</span> </p>
        <p>Vibration: <span id="multi-vibr" style="font-weight:bold;color: #ffcc00;">--</span> </p>
    </div>
</div>

<div class="widget widget-conso">
    <div class="widget-titre">Capteur Porte — Temps réel </div>
    <div style="padding: 15px;">
        <p>Statut de la porte : <span id="porte-statut" style="font-weight:bold; color: #ffcc00;">--</span> </p>
    </div>
</div>

        <div class="widget">
            <div class="widget-titre">
                Balance
            </div>
            <ul class="liste-mesures">
                <?php afficherBalance($connexion, $nomRuche); ?>
            </ul>
        </div>
        <div class="widget">
            <div class="widget-titre">
                Panneau solaire
            </div>
            <ul class="liste-mesures">
                <?php AfficherPanneauSolaire($connexion,$nomRuche); ?>
            </ul>
        </div>
        <div class="widget">
            <div class="widget-titre">
                Tapis chauffant
            </div>
            <ul class="liste-mesures">
                <?php  afficherTapisChauffant($connexion, $nomRuche); ?>
            </ul>
        </div>
        <div class="widget">
            <div class="widget-titre">
                Ventilation
            </div>
            <ul class="liste-mesures">
                <?php  AfficherVentilation($connexion, $nomRuche); ?>
            </ul>
        </div>
        <div class="widget">
            <div class="widget-titre">
                Batterie
            </div>
            <ul class="liste-mesures">
                <?php AfficherBatterie($connexion, $nomRuche); ?>
            </ul>
        </div>

    </div><!-- /.dashboard-grid -->
</main>

<!-- Inclusion du fichier de fonctions Domoticz -->
<script src="domoticz.js"></script>
<script>
const ID_PRISE = 14; 
const ID_MULTI = 6;  
const ID_LUX   = 4;  
const ID_UV    = 5;
const ID_MOUV = 1;
const ID_VIBR = 2;
const ID_PORTE = 19;

Domoticz.poll([ID_PRISE, ID_MULTI, ID_LUX, ID_UV, ID_MOUV, ID_VIBR, ID_PORTE], (capteurs, erreur) => {
    const elStatut = document.getElementById('statut-conso');

    if (erreur) {
        elStatut.textContent = "⚠ Erreur : " + erreur.message;
        return;
    }

    // 1. CONSOMMATION (IDX 14) -> 3.9 Watt
    if (capteurs[ID_PRISE]) {
        document.getElementById('valeur-conso').textContent = capteurs[ID_PRISE].valeur.toFixed(1);
    }

    // 2. MULTISENSOR (IDX 6) -> Temp + Humidité
    if (capteurs[ID_MULTI]) {
        const dataMulti = capteurs[ID_MULTI];
        // Température (22.3)
        document.getElementById('multi-temp').textContent = dataMulti.valeur.toFixed(1);
        
        // Humidité (Extraction du "61 %" dans la chaîne "22.3 C, 61 %")
        if (document.getElementById('multi-humi')) {
            const parties = dataMulti.raw.split(','); // Sépare au niveau de la virgule
            if (parties[1]) {
                document.getElementById('multi-humi').textContent = parties[1].trim(); 
            }
        }
    }

    // 3. LUMINOSITÉ (IDX 4)
    if (capteurs[ID_LUX]) {
        document.getElementById('multi-lux').textContent = capteurs[ID_LUX].valeur;
    }

    if (capteurs[ID_UV]){
        document.getElementById('multi-uv').textContent = capteurs[ID_UV].valeur;
    }     
    // --- MOUVEMENT ---
    if (capteurs[ID_MOUV] && document.getElementById('multi-mouv')){
        // On utilise .raw car c'est souvent "On" ou "Off"
        document.getElementById('multi-mouv').textContent = capteurs[ID_MOUV].raw;
    }

    // --- VIBRATION ---
    if (capteurs[ID_VIBR] && document.getElementById('multi-vibr')){
        document.getElementById('multi-vibr').textContent = capteurs[ID_VIBR].raw;
    }

    if (capteurs[ID_PORTE]) {
        const raw = capteurs[ID_PORTE].raw; // Envoie "On" (Ouvert) ou "Off" (Fermé)
        const el = document.getElementById('porte-statut');
        
        if (raw === "On") {
            el.textContent = "OUVERTE";
            el.style.color = "#e74c3c"; // Rouge alerte
        } else {
            el.textContent = "FERMÉE";
            el.style.color = "#27ae60"; // Vert sécurité
        }
    }


    elStatut.textContent = "Mis à jour à " + new Date().toLocaleTimeString();
}, 5000);
</script>

</body>
</html>