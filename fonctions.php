<?php

function verifieProfil($connexion, $mailU, $mdp){
	
	$query = "select role from Utilisateur where mailU ='".$mailU."' and mdp='".$mdp."'";
	$resultat =  mysqli_query($connexion,$query);
	
	if ($resultat) {
        // mysqli_num_rows permet de savoir si on a trouvé 1 utilisateur
        if (mysqli_num_rows($resultat) == 1) {
            $user = mysqli_fetch_array($resultat);
            $role = $user['role'];

            session_start();
            $_SESSION['mailU'] = $mailU;
            $_SESSION['role'] = $role; // On stocke le rôle en session
            $_SESSION['message'] = '';

            // LOGIQUE DE REDIRECTION SELON LE RÔLE
            if ($role == 'apiculteur') {
                header("Location: apiculteur.php"); // Page de gestion
            } 
            elseif ($role == 'client') {
                header("Location: boutique.php"); // Page d'achat
            } 
            else {
                header("Location: index.php"); // Admin ou autre
            }
            exit();
        } else {
            session_start();
            $_SESSION['message'] = 'Login ou mot de passe incorrect';
            header("Location: login.php");
            exit();
        }
     }   
     else
      {
        echo "<p>Erreur dans l'exécution de la requête.<br>";
        echo "Message du serveur de base de données : ".mysqli_error($connexion);

      }
}


function AfficherProduit($connexion) {
    // Ta requête avec tes données exactes
    $query = "select nomProduit, prix, dateRecolte, format from Produit";	
    $resultat = mysqli_query($connexion, $query);

    if ($resultat) {
        // On récupère le nombre total pour gérer les classes CSS
        $total = mysqli_num_rows($resultat);
        $i = 1;

        while ($p = mysqli_fetch_array($resultat)) {
            // Gestion simplifiée des classes (first pour le 1er, last pour le dernier)
            if ($i == 1) { 
                echo "<li class='first'>"; 
            } elseif ($i == $total) { 
                echo "<li class='last'>"; 
            } else { 
                echo "<li>"; 
            }

            echo "<div class='card'>";
                echo "<h3>" . $p["nomProduit"] . "</h3>";
                echo "<p class='price'>" . $p["prix"] . " €</p>";
                echo "<p><strong>Format :</strong> " . $p["format"] . "</p>";
                echo "<div class='footer-card'><small>Récolte : " . $p["dateRecolte"] . "</small></div>";
            echo "</div>";
            $i++;
        }
    } else {
        echo "Erreur SQL : " . mysqli_error($connexion);
    }
}

?>