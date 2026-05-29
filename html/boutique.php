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
  <title>Boutique – HoneyZzz</title>
</head>
<body>

<?php 
include('navbar.php'); 
?>

<section class="boutique" id="boutique">
  <div class="boutique-header">
    <div class="search-bar">
      </div>

    <?php 
    // On affiche le bouton seulement si l'utilisateur est connecté
    // (Puisque vous redirigez vers connexion.php si mailU est vide au début du fichier,
    // ce bouton s'affichera pour tout utilisateur ayant passé cette barrière)
    if (!empty($_SESSION['mailU'])&& $_SESSION ['role']==='apiculteur') : 
    ?>
      <div class="admin-actions" style="margin-bottom: 20px; text-align: right;">
        <a href="ajouter_miel.php" class="btn-valider" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Ajouter un miel
        </a>
      </div>

    <div class="grid" id="products-grid">
    <ul class="products-list">
        
        <li class="card" style="cursor: default; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #2c1a00; font-size: 1.4rem; margin-bottom: 5px;">L'Essentielle</h3>
                <p style="color: #9a7030; font-size: 0.9rem; margin-top: 0;">1 Ruche Connectée</p>
                
                <div style="margin: 20px 0;">
                    <span class="produit-prix" style="display: block;">745 €</span>
                    <span style="font-size: 0.8rem; color: #888;">à l'achat (matériel inclus)</span>
                    <span style="display: block; font-weight: bold; color: #c97a00; margin-top: 10px; font-size: 1.1rem;">+ 20 € / mois</span>
                    <span style="font-size: 0.8rem; color: #888;">Abonnement "Data et Suivi"</span>
                </div>

                <div style="background: #fff8ee; border: 1px solid #e0d0b0; border-radius: 8px; padding: 15px; text-align: left; margin-bottom: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem; color: #5a3e00; line-height: 1.8;">
                        <li><strong>✅ La solution de test idéale</strong></li>
                        <li>✅ 1 Ruche connectée autonome</li>
                        <li>✅ Matériel garanti 2 ans</li>
                        <li>✅ Engagement 24 mois</li>
                    </ul>
                </div>
            </div>
            <button class="btn-decouvrir" style="width: 100%;">Sélectionner</button>
        </li>

        <li class="card" style="cursor: default; display: flex; flex-direction: column; justify-content: space-between; border: 2px solid #c97a00; box-shadow: 0 4px 15px rgba(200,150,0,0.2);">
            <div>
                <div style="background: #c97a00; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; display: inline-block; margin-bottom: 10px;">Meilleure Vente</div>
                <h3 style="color: #2c1a00; font-size: 1.4rem; margin-bottom: 5px;">Pack Premium</h3>
                <p style="color: #9a7030; font-size: 0.9rem; margin-top: 0;">10 Ruches connectées</p>
                
                <div style="margin: 20px 0;">
                    <span class="produit-prix" style="display: block; font-size: 2rem;">5 000 €</span>
                    <span style="font-size: 0.8rem; color: #888;">à l'achat (soit 500 € / ruche)</span>
                    <span style="display: block; font-weight: bold; color: #c97a00; margin-top: 10px; font-size: 1.2rem;">+ 149 € / mois</span>
                    <span style="font-size: 0.8rem; color: #888;"> 15 € par ruche / mois</span>
                </div>

                <div style="background: #fdf1c7; color: #b78100; font-weight: bold; padding: 8px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px;">
                    🔥 Économisez 2 450 € sur le matériel !
                </div>

                <div style="background: #fff8ee; border: 1px solid #e0d0b0; border-radius: 8px; padding: 15px; text-align: left; margin-bottom: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem; color: #5a3e00; line-height: 1.8;">
                        <li><strong>✅ 2 Ruches Maîtres + 8 Eco Ruches</strong></li>
                        <li>✅ Architecture réseau optimisée</li>
                        <li>✅ Matériel garanti 2 ans</li>
                        <li>✅ Engagement 24 mois</li>
                    </ul>
                </div>
            </div>
            <button class="btn-add-cart" style="width: 100%; justify-content: center;">Sélectionner le Pack</button>
        </li>

        <li class="card" style="cursor: default; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #2c1a00; font-size: 1.4rem; margin-bottom: 5px;">Pack Expert</h3>
                <p style="color: #9a7030; font-size: 0.9rem; margin-top: 0;">20 Ruches connectées</p>
                
                <div style="margin: 20px 0;">
                    <span class="produit-prix" style="display: block;">9 500 €</span>
                    <span style="font-size: 0.8rem; color: #888;">à l'achat (soit 475 € / ruche)</span>
                    <span style="display: block; font-weight: bold; color: #c97a00; margin-top: 10px; font-size: 1.1rem;">+ 260 € / mois</span>
                    <span style="font-size: 0.8rem; color: #888;">Moins de 15 € par ruche / mois</span>
                </div>

                <div style="background: #fdf1c7; color: #b78100; font-weight: bold; padding: 8px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px;">
                    🔥 Économisez 5 300 € sur le matériel !
                </div>

                <div style="background: #fff8ee; border: 1px solid #e0d0b0; border-radius: 8px; padding: 15px; text-align: left; margin-bottom: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem; color: #5a3e00; line-height: 1.8;">
                        <li><strong>✅ 4 Ruches Maîtres + 16 Eco Ruches</strong></li>
                        <li>✅ Couverture multi-sites (4 zones)</li>
                        <li>✅ Matériel garanti 2 ans</li>
                        <li>✅ Engagement 24 mois</li>
                    </ul>
                </div>
            </div>
            <button class="btn-decouvrir" style="width: 100%;">Sélectionner le Pack</button>
        </li>

    </ul>
</div>
    <?php endif; ?>
  </div>

  <div class="grid" id="products-grid">
    <ul class="clear" style="list-style:none; display: flex; flex-wrap: wrap; gap: 20px;">
      <?php 
        AfficherProduit($connexion); 
      ?>
    </ul>
  </div>
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
