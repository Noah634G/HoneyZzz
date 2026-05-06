<?php

function verifieProfil($connexion, $mailU, $mdp){
	
	$query = "select role from Utilisateur where mailU ='".$mailU."' and mdp='".$mdp."'";
	$resultat =  mysqli_query($connexion,$query);
	
	if ($resultat) {
        if (mysqli_num_rows($resultat) == 1) {
            $user = mysqli_fetch_array($resultat);
            $role = $user['role'];

            session_start();
            $_SESSION['mailU'] = $mailU;
            $_SESSION['role'] = $role;
            $_SESSION['message'] = '';

            if ($role == 'apiculteur') {
                header("Location: apiculteur.php");
            } 
            elseif ($role == 'client') {
                header("Location: boutique.php");
            } 
            else {
                header("Location: index.php");
            }
            exit();
        } else {
            session_start();
            $_SESSION['message'] = 'Login ou mot de passe incorrect';
            header("Location: connexion.php");
            exit();
        }
     }   
     else {
        echo "<p>Erreur dans l'exécution de la requête.<br>";
        echo "Message du serveur de base de données : ".mysqli_error($connexion);
     }
}

function InscriptionUtilisateur($connexion, $nom, $prenom, $email, $tel, $mdp, $role) {
    $nom    = mysqli_real_escape_string($connexion, $nom);
    $prenom = mysqli_real_escape_string($connexion, $prenom);
    $email  = mysqli_real_escape_string($connexion, $email);
    $tel    = mysqli_real_escape_string($connexion, $tel);
    $mdp    = mysqli_real_escape_string($connexion, $mdp);
    $role   = mysqli_real_escape_string($connexion, $role);

    $date = date("Y-m-d");

    $check = mysqli_query($connexion, "SELECT mailU FROM Utilisateur WHERE mailU = '$email'");
    if(mysqli_num_rows($check) > 0) {
        return false;
    }

    $sql = "INSERT INTO Utilisateur (nomU, prenomU, mailU, telU, mdp, role, datecreation) 
            VALUES ('$nom', '$prenom', '$email', '$tel', '$mdp', '$role', '$date')";

    return mysqli_query($connexion, $sql);
}

/* =========================================================
   PANIER — fonctions utilitaires
   ========================================================= */

/**
 * Initialise le panier en session s'il n'existe pas encore.
 */
function initialiserPanier() {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
}

/**
 * Ajoute un produit au panier.
 * Chaque article est identifié par son nomProduit.
 */
function ajouterAuPanier($nomProduit, $prix, $format) {
    initialiserPanier();

    // Si l'article est déjà dans le panier, on incrémente la quantité
    if (isset($_SESSION['panier'][$nomProduit])) {
        $_SESSION['panier'][$nomProduit]['quantite']++;
    } else {
        $_SESSION['panier'][$nomProduit] = [
            'nomProduit' => $nomProduit,
            'prix'       => $prix,
            'format'     => $format,
            'quantite'   => 1
        ];
    }
}

/**
 * Supprime un produit du panier.
 */
function supprimerDuPanier($nomProduit) {
    initialiserPanier();
    if (isset($_SESSION['panier'][$nomProduit])) {
        unset($_SESSION['panier'][$nomProduit]);
    }
}

/**
 * Modifie la quantité d'un article.
 * Si quantité <= 0, l'article est supprimé.
 */
function modifierQuantite($nomProduit, $quantite) {
    initialiserPanier();
    $quantite = (int)$quantite;
    if ($quantite <= 0) {
        supprimerDuPanier($nomProduit);
    } elseif (isset($_SESSION['panier'][$nomProduit])) {
        $_SESSION['panier'][$nomProduit]['quantite'] = $quantite;
    }
}

/**
 * Vide complètement le panier.
 */
function viderPanier() {
    $_SESSION['panier'] = [];
}

/**
 * Retourne le nombre total d'articles dans le panier.
 */
function getNombreArticlesPanier() {
    initialiserPanier();
    $total = 0;
    foreach ($_SESSION['panier'] as $article) {
        $total += $article['quantite'];
    }
    return $total;
}

/**
 * Retourne le total prix du panier.
 */
function getTotalPanier() {
    initialiserPanier();
    $total = 0;
    foreach ($_SESSION['panier'] as $article) {
        $total += $article['prix'] * $article['quantite'];
    }
    return $total;
}

/**
 * Affiche le panier sous forme de tableau HTML.
 */
function afficherPanier() {
    initialiserPanier();

    if (empty($_SESSION['panier'])) {
        echo "<p class='panier-vide'>🛒 Votre panier est vide.</p>";
        return;
    }

    echo "<div class='panier-container'>";
    echo "<h2>🛒 Mon Panier</h2>";
    echo "<table class='panier-table'>";
    echo "<thead><tr>
            <th>Produit</th>
            <th>Format</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Sous-total</th>
            <th>Action</th>
          </tr></thead>";
    echo "<tbody>";

    foreach ($_SESSION['panier'] as $article) {
        $sousTotal = $article['prix'] * $article['quantite'];
        $nomEncode = urlencode($article['nomProduit']);

        echo "<tr>";
        echo "  <td><strong>" . htmlspecialchars($article['nomProduit']) . "</strong></td>";
        echo "  <td>" . htmlspecialchars($article['format']) . "</td>";
        echo "  <td>" . number_format($article['prix'], 2) . " €</td>";

        // Formulaire de modification de quantité
        echo "  <td>";
        echo "    <form method='POST' action='panier.php' style='display:inline;'>";
        echo "      <input type='hidden' name='action' value='modifier'>";
        echo "      <input type='hidden' name='nomProduit' value='" . htmlspecialchars($article['nomProduit']) . "'>";
        echo "      <input type='number' name='quantite' value='" . $article['quantite'] . "' min='0' class='input-qty'>";
        echo "      <button type='submit' class='btn-modifier'>↺</button>";
        echo "    </form>";
        echo "  </td>";

        echo "  <td><strong>" . number_format($sousTotal, 2) . " €</strong></td>";

        // Bouton supprimer
        echo "  <td>";
        echo "    <form method='POST' action='panier.php' style='display:inline;'>";
        echo "      <input type='hidden' name='action' value='supprimer'>";
        echo "      <input type='hidden' name='nomProduit' value='" . htmlspecialchars($article['nomProduit']) . "'>";
        echo "      <button type='submit' class='btn-supprimer'>✕ Supprimer</button>";
        echo "    </form>";
        echo "  </td>";

        echo "</tr>";
    }

    echo "</tbody>";
    echo "<tfoot>";
    echo "  <tr>";
    echo "    <td colspan='4' style='text-align:right;'><strong>TOTAL :</strong></td>";
    echo "    <td colspan='2'><strong>" . number_format(getTotalPanier(), 2) . " €</strong></td>";
    echo "  </tr>";
    echo "</tfoot>";
    echo "</table>";

    // Bouton vider le panier
    echo "<form method='POST' action='panier.php'>";
    echo "  <input type='hidden' name='action' value='vider'>";
    echo "  <button type='submit' class='btn-vider'>🗑 Vider le panier</button>";
    echo "</form>";

    // Bouton commander
    echo "<a href='commande.php' class='btn-commander'>✔ Passer la commande</a>";
    echo "</div>";
}


/* =========================================================
   AFFICHAGE PRODUITS — avec bouton Ajouter au panier
   ========================================================= */

function AfficherProduit($connexion) {
    $query = "SELECT nomProduit, prix, dateRecolte, format FROM Produit";
    $resultat = mysqli_query($connexion, $query);

    if ($resultat) {
        $total = mysqli_num_rows($resultat);
        $i = 1;

        while ($p = mysqli_fetch_array($resultat)) {
            if ($i == 1) {
                echo "<li class='first'>";
            } elseif ($i == $total) {
                echo "<li class='last'>";
            } else {
                echo "<li>";
            }

            echo "<div class='card'>";
                echo "<h3>" . htmlspecialchars($p["nomProduit"]) . "</h3>";
                echo "<p class='price'>" . $p["prix"] . " €</p>";
                echo "<p><strong>Format :</strong> " . htmlspecialchars($p["format"]) . "</p>";
                echo "<div class='footer-card'><small>Récolte : " . $p["dateRecolte"] . "</small></div>";

                // ── Bouton Ajouter au panier ──
                echo "<form method='POST' action='panier.php'>";
                echo "  <input type='hidden' name='action'      value='ajouter'>";
                echo "  <input type='hidden' name='nomProduit'  value='" . htmlspecialchars($p["nomProduit"]) . "'>";
                echo "  <input type='hidden' name='prix'        value='" . $p["prix"] . "'>";
                echo "  <input type='hidden' name='format'      value='" . htmlspecialchars($p["format"]) . "'>";
                echo "  <button type='submit' class='btn-panier'>🛒 Ajouter au panier</button>";
                echo "</form>";

            echo "</div>";
            echo "</li>";
            $i++;
        }
    } else {
        echo "Erreur SQL : " . mysqli_error($connexion);
    }
}


/* =========================================================
   RUCHES — inchangé
   ========================================================= */

function AfficherRuche($connexion, $mailU) {
    $query = "SELECT R.nom, R.dateInstallation, R.especeAbeille, R.statut, E.nomLieu, E.adresse 
              FROM Ruche R 
              JOIN Emplacement E ON R.idEmplacement = E.idEmplacement 
              JOIN Utilisateur U ON E.idUtilisateur = U.idUtilisateur 
              WHERE U.mailU = '$mailU'";

    $resultat = mysqli_query($connexion, $query);

    if ($resultat) {
        $total = mysqli_num_rows($resultat);
        $i = 1;

        while ($r = mysqli_fetch_array($resultat)) {
            if ($i == 1) {
                echo "<li class='first'>";
            } elseif ($i == $total) {
                echo "<li class='last'>";
            } else {
                echo "<li>";
            }

            $lien = "controleruche.php?nom=" . urlencode($r['nom']);

            echo "  <a href='$lien' class='card' style='text-decoration:none; color:inherit;'>";
            echo "    <h3>" . htmlspecialchars($r["nom"]) . "</h3>";
            echo "    <p class='card-label'>" . htmlspecialchars($r["especeAbeille"]) . "</p>";
            echo "    <p><strong>Lieu :</strong> " . htmlspecialchars($r["nomLieu"]) . "</p>";
            echo "    <div class='footer-card'><small>Installée le : " . $r["dateInstallation"] . "</small></div>";
            echo "  </a>";
            echo "</li>";
            $i++;
        }
    } else {
        echo "Erreur SQL : " . mysqli_error($connexion);
    }
}

function AjouterRuche($connexion, $nom, $date, $espece, $statut, $idEmplacement) {
    $nom          = mysqli_real_escape_string($connexion, $nom);
    $date         = mysqli_real_escape_string($connexion, $date);
    $espece       = mysqli_real_escape_string($connexion, $espece);
    $statut       = mysqli_real_escape_string($connexion, $statut);
    $idEmplacement = (int)$idEmplacement;

    $sql = "INSERT INTO Ruche (nom, dateInstallation, especeAbeille, statut, idEmplacement) 
            VALUES ('$nom', '$date', '$espece', '$statut', '$idEmplacement')";

    return mysqli_query($connexion, $sql);
}


function afficherHumidite($connexion, $nomRuche) {
    $nomRuche = mysqli_real_escape_string($connexion, $nomRuche);

    $query = "SELECT humidite FROM Multisensor M JOIN Ruche R ON M.idRuche = R.idRuche
              WHERE nom = '$nomRuche'";

    $resultat = mysqli_query($connexion, $query);

    if ($resultat) {
        $total = mysqli_num_rows($resultat);
        $i = 1;

        while ($h = mysqli_fetch_array($resultat)) {
            $class = "";
            if ($i == 1) $class = "first";
            elseif ($i == $total) $class = "last";

            echo "<li class='$class'>";
            echo "<div class='card'>";
                echo "<h3>Humidité</h3>";
                echo "<p class='card-prix'>" . $h["humidite"] . " %</p>";
                echo "<div class='footer-card'><small>Mesure n°" . $i . "</small></div>";
            echo "</div>";
            echo "</li>";
            $i++;
        }
    } else {
        echo "Erreur SQL : " . mysqli_error($connexion);
    }
}