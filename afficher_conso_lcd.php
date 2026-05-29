#!/usr/bin/env php
<?php
// --- CONFIGURATION ---
$domoticz_ip = '192.168.4.1';
$domoticz_port = '8080';
$idx_capteur = 14; // IDX 14 = La prise

// Chemin vers la commande pifacecad
$pifacecad = '/home/pi/piface/libpifacecad/pifacecad'; 

// --- 1. NETTOYAGE DES DONNÉES (Pour éviter le texte qui déborde) ---
function NettoyerConso($raw) {

    if (strpos($raw, ',') !== false) {
        $raw = trim(explode(',', $raw)[0]);
    }

    if (preg_match('/^(-?[\d]+\.?[\d]*)\s*(.*)$/', trim($raw), $m)) {
        $valeur = number_format((float)$m[1], 1, '.', '');
        return $valeur . " Watt ";
    }

    return "Inconnue";
}

// --- 2. RÉCUPÉRATION DE LA Consomation DEPUIS DOMOTICZ ---
$url = "http://{$domoticz_ip}:{$domoticz_port}/json.htm?type=devices&rid={$idx_capteur}";
$context = stream_context_create(['http' => ['timeout' => 3]]);
$response = @file_get_contents($url, false, $context);

if (!$response) {
    shell_exec("$pifacecad clear");
    shell_exec("$pifacecad write " . escapeshellarg("Erreur Domoticz"));
    exit();
}

$data = json_decode($response, true);
if (isset($data['result'][0]['Data'])) {
    // On nettoie la température reçue grâce à notre fonction
    $consommation = NettoyerConso($data['result'][0]['Data']); // ILS FAUT CHANGER POUR LA PRISE
} else {
    $consommation = "Inconnue";
}

// --- 3. AFFICHAGE UNIQUE SUR L'ÉCRAN LCD ---
// Nettoyer l'écran
shell_exec("$pifacecad clear");

// Écrire sur la première ligne
shell_exec("$pifacecad write " . escapeshellarg("Ruche HoneyZzz"));

// Passer à la ligne 2 (coordonnées x=0, y=1) et écrire la température propre
shell_exec("$pifacecad setcursor 0 1");
shell_exec("$pifacecad write " . escapeshellarg("Conso: " . $consommation));
?>
