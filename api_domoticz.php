<?php
/**
 * api_domoticz.php
 * API générique pour tous les capteurs Domoticz/RaZberry.
 *
 * Appel JS :
 *   fetch('api_domoticz.php?idx[]=4&idx[]=5')
 *
 * Réponse :
 * {
 *   "status": "ok",
 *   "ts": "14:32:05",
 *   "capteurs": {
 *     "4": {
 *       "idx": "4",
 *       "nom": "conso instantanée",
 *       "type": "Usage",
 *       "subtype": "Electric",
 *       "valeur": 3.6,
 *       "unite": "Watt",
 *       "raw": "3.6 Watt",
 *       "lastUpdate": "2023-03-20 19:39:55",
 *       "batterie": 255,
 *       "signal": "-"
 *     }
 *   }
 * }
 */

session_start();
require('connect.php');

// ── Sécurité
if (empty($_SESSION['mailU'])) {
    http_response_code(401);
    echo json_encode(['status' => 'erreur', 'message' => 'Non autorisé']);
    exit();
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

// ── Config Domoticz (invisible du navigateur)
define('DOMOTICZ_IP',   '127.0.0.1');
define('DOMOTICZ_PORT', '8080');
define('DOMOTICZ_USER', '');  // laisser vide si pas de login
define('DOMOTICZ_PASS', '');

// ═══════════════════════════════════════════════════════════
//  TABLE DE CONFIG — ajoute tes capteurs ici
//  (optionnel : si l'idx n'est pas là, on utilise le nom Domoticz)
// ═══════════════════════════════════════════════════════════
$capteurs_config = [
    '4' => 'Consommation',
    '5' => 'Température',
    '6' => 'Humidité',
    '7' => 'Poids',
    '8' => 'CO₂',
    '9' => 'Activité sonore',
    // Ajoute tes idx ici...
];

// ═══════════════════════════════════════════════════════════
//  PARSING DU CHAMP Data de Domoticz
//
//  Exemples réels issus du JSON :
//    "3.6 Watt"         → valeur: 3.6,   unite: "Watt"
//    "34.2 C"           → valeur: 34.2,  unite: "°C"
//    "65 %"             → valeur: 65.0,  unite: "%"
//    "1.234 kg"         → valeur: 1.234, unite: "kg"
//    "1020.3 hPa"       → valeur: 1020.3,unite: "hPa"
//    "52 dB"            → valeur: 52.0,  unite: "dB"
//    "500 ppm"          → valeur: 500.0, unite: "ppm"
//    "34.2 C, 65%"      → valeur: 34.2,  unite: "°C"  (Temp+Humi combiné)
// ═══════════════════════════════════════════════════════════
function parserData($raw, $type = '') {

    // Cas Temp+Humidity combiné : "34.2 C, 65 %" → on prend la température
    if (strpos($raw, ',') !== false && $type === 'Temp + Humidity') {
        $raw = trim(explode(',', $raw)[0]);
    }

    // Sépare le nombre du texte
    // Regex : capture le nombre (avec éventuel signe négatif et décimale)
    // puis capture le reste comme unité
    if (preg_match('/^(-?[\d]+\.?[\d]*)\s*(.*)$/', trim($raw), $m)) {
        $valeur = (float)$m[1];
        $unite  = trim($m[2]);

        // Domoticz retourne "C" pour les degrés → on normalise
        if ($unite === 'C')  $unite = '°C';
        if ($unite === 'F')  $unite = '°F';

        return ['valeur' => $valeur, 'unite' => $unite];
    }

    // Fallback si le format est inconnu
    return ['valeur' => null, 'unite' => ''];
}

// ═══════════════════════════════════════════════════════════
//  APPEL DOMOTICZ pour un idx
// ═══════════════════════════════════════════════════════════
function fetchDevice($idx) {
    $idx = (int)$idx;

    $base = DOMOTICZ_USER !== ''
        ? 'http://' . DOMOTICZ_USER . ':' . DOMOTICZ_PASS . '@' . DOMOTICZ_IP . ':' . DOMOTICZ_PORT
        : 'http://' . DOMOTICZ_IP . ':' . DOMOTICZ_PORT;

    $url = $base . '/json.htm?type=devices&rid=' . $idx;

    $context  = stream_context_create(['http' => ['timeout' => 5]]);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) return null;

    $data = json_decode($response, true);

    if (!$data || ($data['status'] ?? '') !== 'OK' || empty($data['result'])) return null;

    return $data['result'][0];  // ← le device brut Domoticz
}

// ═══════════════════════════════════════════════════════════
//  RÉCUPÉRATION DES idx DEMANDÉS
//  ?idx=4          → un seul
//  ?idx[]=4&idx[]=5 → plusieurs
// ═══════════════════════════════════════════════════════════
$demandes = [];

if (isset($_GET['idx'])) {
    $demandes = is_array($_GET['idx'])
        ? array_map('intval', $_GET['idx'])
        : [(int)$_GET['idx']];
}

if (empty($demandes)) {
    http_response_code(400);
    echo json_encode(['status' => 'erreur', 'message' => 'Paramètre idx manquant. Ex: ?idx=4 ou ?idx[]=4&idx[]=5']);
    exit();
}

// ═══════════════════════════════════════════════════════════
//  BOUCLE — traite chaque idx
// ═══════════════════════════════════════════════════════════
$resultats = [];
$nb_erreurs = 0;

foreach ($demandes as $idx) {
    $key    = (string)$idx;
    $device = fetchDevice($idx);

    if ($device === null) {
        $nb_erreurs++;
        $resultats[$key] = [
            'idx'    => $key,
            'erreur' => "Capteur idx=$idx injoignable ou introuvable dans Domoticz"
        ];
        continue;
    }

    // ── Champs bruts du JSON Domoticz
    $raw        = $device['Data']         ?? '';   // ex: "3.6 Watt"
    $type       = $device['Type']         ?? '';   // ex: "Usage"
    $subtype    = $device['SubType']      ?? '';   // ex: "Electric"
    $nomDomo    = $device['Name']         ?? '';   // ex: "conso instantanée"
    $lastUpdate = $device['LastUpdate']   ?? '';
    $batterie   = $device['BatteryLevel'] ?? null;
    $signal     = $device['SignalLevel']  ?? null;

    // ── Parse "3.6 Watt" → { valeur: 3.6, unite: "Watt" }
    $parsed = parserData($raw, $type);

    // ── Nom : priorité config manuelle, sinon nom Domoticz
    $nom = $capteurs_config[$key] ?? $nomDomo;

    $resultats[$key] = [
        'idx'        => $key,
        'nom'        => $nom,
        'type'       => $type,
        'subtype'    => $subtype,
        'valeur'     => $parsed['valeur'],   // float, ex: 3.6
        'unite'      => $parsed['unite'],    // string, ex: "Watt"
        'raw'        => $raw,                // string brute Domoticz, ex: "3.6 Watt"
        'lastUpdate' => $lastUpdate,
        'batterie'   => $batterie,
        'signal'     => $signal,
    ];
}

// ── Réponse
echo json_encode([
    'status'   => $nb_erreurs === 0 ? 'ok' : ($nb_erreurs === count($demandes) ? 'erreur' : 'partiel'),
    'ts'       => date('H:i:s'),
    'capteurs' => $resultats,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);