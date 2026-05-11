<?php
// On démarre la session pour pouvoir y accéder
session_start();

// On détruit toutes les variables de session
$_SESSION = array();

// On détruit la session elle-même sur le serveur
session_destroy();

// On redirige proprement vers la page de connexion
header("Location: connexion.php");
exit();
?>