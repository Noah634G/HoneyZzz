<?php
// ✅ session_start() EN PREMIER, avant tout require
session_start();

require('connect.php');
require('fonctions.php');

// Vérification login
if (empty($_SESSION['mailU'])) {
    $_SESSION['message'] = "Vous n'avez pas le droit d'accéder à cette page";
    header("Location: connexion.php");
    exit();
}

// Connexion BDD
$connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    echo "<p>Problème de connexion à la base de données.</p>";
    exit();
}

// ── Traitement des actions POST ──────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'ajouter':
            $nomProduit = $_POST['nomProduit'] ?? '';
            $prix       = (float)($_POST['prix'] ?? 0);
            $format     = $_POST['format'] ?? '';
            if ($nomProduit) {
                ajouterAuPanier($nomProduit, $prix, $format);
            }
            header("Location: boutique.php");
            exit();

        case 'supprimer':
            supprimerDuPanier($_POST['nomProduit'] ?? '');
            header("Location: panier.php");
            exit();

        case 'modifier':
            modifierQuantite($_POST['nomProduit'] ?? '', (int)($_POST['quantite'] ?? 0));
            header("Location: panier.php");
            exit();

        case 'vider':
            viderPanier();
            header("Location: panier.php");
            exit();
    }
}

initialiserPanier();
$panier = $_SESSION['panier'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Mon Panier – HoneyZzz</title>
</head>
<body>

<?php require('navbar.php'); ?>

<a href="boutique.php" class="retour-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="15 18 9 12 15 6"/>
    </svg>
    Continuer mes achats
</a>

<section class="panier-section">

    <!-- ── Colonne gauche : liste des articles ── -->
    <div>
        <h1 class="panier-titre">🛒 Mon Panier</h1>

        <?php if (empty($panier)): ?>
            <div class="panier-vide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                <p>Votre panier est vide.</p>
                <a href="boutique.php">Voir les produits →</a>
            </div>

        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($panier as $article): ?>
                    <div class="cart-item">

                        <div class="cart-item-infos">
                            <div class="cart-item-nom"><?= htmlspecialchars($article['nomProduit']) ?></div>
                            <div class="cart-item-prix">
                                <?= number_format($article['prix'], 2) ?> € — Format : <?= htmlspecialchars($article['format']) ?>
                            </div>

                            <div class="cart-item-controls">

                                <!-- Modifier quantité -->
                                <form method="POST" action="panier.php" style="display:inline-flex; align-items:center; gap:6px;">
                                    <input type="hidden" name="action" value="modifier">
                                    <input type="hidden" name="nomProduit" value="<?= htmlspecialchars($article['nomProduit']) ?>">
                                    <div class="qty-controls-sm">
                                        <button type="submit" name="quantite" value="<?= $article['quantite'] - 1 ?>" class="qty-btn-sm">−</button>
                                        <span class="qty-val"><?= $article['quantite'] ?></span>
                                        <button type="submit" name="quantite" value="<?= $article['quantite'] + 1 ?>" class="qty-btn-sm">+</button>
                                    </div>
                                </form>

                                <!-- Supprimer -->
                                <form method="POST" action="panier.php" style="display:inline;">
                                    <input type="hidden" name="action" value="supprimer">
                                    <input type="hidden" name="nomProduit" value="<?= htmlspecialchars($article['nomProduit']) ?>">
                                    <button type="submit" class="btn-suppr">✕ Supprimer</button>
                                </form>

                            </div>
                        </div>

                        <div class="cart-item-total">
                            <?= number_format($article['prix'] * $article['quantite'], 2) ?> €
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ── Colonne droite : récapitulatif ── -->
    <?php if (!empty($panier)): ?>
    <div class="recap-box">
        <div class="recap-titre">Récapitulatif</div>

        <?php foreach ($panier as $article): ?>
            <div class="recap-line">
                <span><?= htmlspecialchars($article['nomProduit']) ?> × <?= $article['quantite'] ?></span>
                <span><?= number_format($article['prix'] * $article['quantite'], 2) ?> €</span>
            </div>
        <?php endforeach; ?>

        <div class="recap-line total">
            <span>Total</span>
            <span><?= number_format(getTotalPanier(), 2) ?> €</span>
        </div>

        <a href="commande.php" class="btn-commander">✔ Passer la commande</a>

        <form method="POST" action="panier.php">
            <input type="hidden" name="action" value="vider">
            <button type="submit" class="btn-vider">🗑 Vider le panier</button>
        </form>
    </div>
    <?php endif; ?>

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

</body>
</html>