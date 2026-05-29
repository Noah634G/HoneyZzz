<?php
/**
 * ajouter_capteurs_auto.php
 * 
 * Script automatique qui récupère les données Domoticz
 * et les ajoute dans la table Historique
 * 
 * À lancer toutes les heures :
 * php ajouter_capteurs_auto.php
 */

require('include/connect.php');
$connexion = mysqli_connect(SERVEUR, NOM, PASSE, BD);

if (!$connexion) {
    die("Erreur base de données\n");
}

// Configuration Domoticz
$DOMOTICZ_IP = "192.168.4.1";
$DOMOTICZ_PORT = "8080";

// Les capteurs à récupérer
$capteurs = array(
    "6" => "Température",
    "14" => "Consommation",
    "4" => "Luminosité",
    "5" => "UV",
    "2" => "Vibration"
);

// Récupère la valeur d'un capteur
function obtenirValeur($idx) {
    global $DOMOTICZ_IP, $DOMOTICZ_PORT;
    
    $url = "http://$DOMOTICZ_IP:$DOMOTICZ_PORT/json.htm?type=devices&rid=$idx";
    $json = @file_get_contents($url);
    
    if (!$json) return null;
    
    $data = json_decode($json, true);
    
    if (isset($data['result'][0]['Data'])) {
        // Extrait le nombre
        preg_match('/(\d+\.?\d*)/', $data['result'][0]['Data'], $match);
        return isset($match[1]) ? $match[1] : null;
    }
    
    return null;
}

// Enregistre dans la base
echo "[" . date('Y-m-d H:i:s') . "] Début\n";
$count = 0;

// Récupère le prochain idHistorique (si la colonne n'est pas AUTO_INCREMENT)
function prochainIdHistorique($connexion) {
    $res = mysqli_query($connexion, "SELECT COALESCE(MAX(idHistorique), 0) + 1 AS next_id FROM Historique");
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        return (int)$row['next_id'];
    }
    return null;
}

foreach ($capteurs as $idx => $nom) {
    $valeur = obtenirValeur($idx);
    
    if ($valeur !== null) {
        $now = date('Y-m-d H:i:s');
        $nom = mysqli_real_escape_string($connexion, $nom);
        
        // Si la table n'a pas d'AUTO_INCREMENT sur idHistorique, on calcule un id
        $nextId = prochainIdHistorique($connexion);
        if ($nextId !== null) {
            $sql = "INSERT INTO Historique (idHistorique, typeEvenement, valeur, datedbt) 
                VALUES ($nextId, '$nom', '$valeur', '$now')";
        } else {
            // fallback : essayer sans id (si la table a AUTO_INCREMENT)
            $sql = "INSERT INTO Historique (typeEvenement, valeur, datedbt) 
                VALUES ('$nom', '$valeur', '$now')";
        }
        
        if (mysqli_query($connexion, $sql)) {
            echo "✓ $nom : $valeur\n";
            $count++;
        } else {
            echo "✗ Erreur $nom\n";
        }
    } else {
        echo "✗ Capteur $idx pas de données\n";
    }
}

echo "[" . date('Y-m-d H:i:s') . "] Fin ($count ajoutés)\n";

mysqli_close($connexion);
?>
