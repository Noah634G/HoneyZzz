<?php  require('include/connect.php'); ?>
<?php  require('include/fonctions.php'); ?>

<?php 
    // code PHP permettant de gérer le fait que l'utilisateur est bien logué et la connection à la BD pour la page.
    // Ce code pourrait être intégré dans une fonction car répété à chaque début de page. Attention toutefois dans ce cas-là à bien gérer les variables (locales et globales)

    // 1 . Gestion du login
    // Le login est stocké en variable de session si l'utilisateur est correctement logué.

    // obligatoire de prolonger la session
    session_start();

    // S'il n'y a rien dans la variable de session, on redirige vers la page de login
     if (empty($_SESSION['mailU']))
    {
      $_SESSION['message']="Vous n'avez pas le droit d'accéder à cette page";
      // on redirige vers login
      header("Location:connexion.php");
    }
    // sinon on stocke l'utilisateur courant dans la variable $pesudo
    else
    {
      $mailU = $_SESSION['mailU'];
    }


    // 2. Connexion à la base
    $connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE,BD);
    if (!$connexion)
    {
      echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br> Erreur : ".mysqli_error()."</p>";
     
    }   
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="style.css" rel="stylesheet">
  <title>Ruche Connectée</title>
  
</head>
<body>

<!--Barre de navigation-->
<nav>
  <div class="nav-left">
    <ul class="nav-links">
      <li><a href="index.php" class="active">Accueil</a></li>
      <li><a href="boutique.php">Boutique</a></li>
    </ul>
  </div>

  <div class="nav-center">
    <img src="logo_honeyzzz2.png" alt="Logo Ruche Connectée" class="logo-img">
  </div>

  <div class="nav-right">
    <!-- Connexion -->
      <a href="connexion.php" class="btn-connexion active">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="8" r="4"/>
        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
      </svg>
      Connexion
    </a>

    <!-- Panier -->
    <button class="btn-panier">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 01-8 0"/>
      </svg>
      Panier
    </button>

    <a class="btn-deconnexion" href="deconnexion.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
      Déconnexion
    </a>
  </div>
</nav>

<!--Accueil-->
<section class="hero" id="accueil">
  <h1>Surveillance et suivi de Vos Colonies à Distance</h1>
  <p>
    Grâce à notre technologie de ruche connectée, suivez en temps réel l'état de santé
    de vos colonies d'abeilles depuis n'importe où. Température, humidité, poids et
    activité de la ruche — toutes les données essentielles accessibles depuis votre
    smartphone ou ordinateur, pour une apiculture moderne et sereine. Alors n'attendez
    plus pour offrir à vos abeilles le meilleur de la technologie avec HoneZzz ! 
  </p>
  <a href="boutique.html" class="btn-decouvrir">Découvrez nos produits</a>
</section>
<footer>
  <div class="footer-content">
    <h5 class="footer-title">Nous suivre sur :</h5>
    <div class="social-links">
      <a href="https://www.instagram.com" target="_blank" class="social-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
          <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
          <path d="m16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
          <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
        </svg>
      </a>
      <a href="https://www.facebook.com" target="_blank" class="social-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
          <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
        </svg>
      </a>
      <a href="https://www.twitter.com" target="_blank" class="social-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
          <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
        </svg>
      </a>
    </div>
    <p class="footer-copyright">&copy; 2024 HoneyZzz. Tous droits réservés.</p>
  </div>
</footer>


<script src="script.js"></script>
<!-- Modale non connecté -->
<div class="modale-overlay" id="modale" style="display:none;">
  <div class="modale-box">
    <p>⚠️ Vous n'êtes pas connecté.</p>
    <button class="btn-decouvrir" onclick="fermerModale()">Fermer</button>
  </div>
</div>
</body>
</html>