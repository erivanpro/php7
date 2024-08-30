<?php

// Constantes pour les différents noms de colonnes.
const IDENTIFIANT='identifiant';
const LIBELLE='libelle';
const PRIX='prix';

// Fonction pour la connexion à la base de données.
function connexion(&$connexion,&$erreur) {
  // Se connecter et sélectionner la base de données.
  $ok = (bool) ($connexion = @mysqli_connect());
  if ($ok) { // connexion OK
    $ok = @mysqli_select_db($connexion,'diane');
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur 
    // Récupérer le message d'erreur.
    if (! $connexion) { // erreur de connexion
      $erreur = @mysqli_connect_error();
    } else { // autre erreur
      $erreur = @mysqli_error($connexion);
    }
  }
  return $ok;
}

// Fonction pour la sélection des articles.
function sélectionner_articles($connexion,&$requête,&$erreur) {
  // Texte de la requête.
  $sql = 'SELECT identifiant,libelle,prix FROM articles ORDER BY libelle';
  // Préparer la requête.
  $ok = (bool) ($requête = mysqli_prepare($connexion,$sql));
  // Exécuter la requête.
  if ($ok) {
    $ok = mysqli_stmt_execute($requête); 
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    if (! $requête) { // erreur lors de la préparation
      $erreur = @mysqli_error($connexion);
    } else { // erreur ailleurs
      $erreur = @mysqli_stmt_error($requête);
    }
  }
  return $ok;
}

// Fonction pour la lecture de l'article suivant dans
// le résultat d'une requête.
function lire_article_suivant($connexion,$requête,&$article,&$erreur) {
  // Lier les colonnes du résultat. 
  $ok = @mysqli_stmt_bind_result($requête,$article[IDENTIFIANT],
                                 $article[LIBELLE],$article[PRIX]/*,$article[]*/); 
  // Lire le résultat.
  if ($ok) {
    $ok = @mysqli_stmt_fetch($requête); 
  }
  // Tester si tout s'est bien passé.
  if ($ok === FALSE) { // erreur quelque part
    $erreur = @mysqli_stmt_error($requête);
  }
  return $ok;
}

// Fonction pour la sélection d'un article dont l'identifiant 
// est passé en paramètre.
function sélectionner_un_article($connexion,$identifiant,&$article,&$erreur) {
  // Texte de la requête.
  $sql = 'SELECT identifiant,libelle,prix FROM articles WHERE identifiant = ?';
  // Préparer la requête.
  $ok = (bool) ($requête = @mysqli_prepare($connexion,$sql));
  // Lier les paramètres.
  if ($ok) {
    $ok = @mysqli_stmt_bind_param($requête,'i',$identifiant);
  }
  // Lier les colonnes du résultat. 
  if ($ok) {
    $ok = @mysqli_stmt_bind_result($requête,$article[IDENTIFIANT],
                                   $article[LIBELLE],$article[PRIX]); 
  }
  // Exécuter la requête.
  if ($ok) {
    $ok = @mysqli_stmt_execute($requête); 
  }
  // Lire le résultat.
  if ($ok) {
    $ok = @mysqli_stmt_fetch($requête); 
    if ($ok === NULL) { // pas de résultat
      $ok = TRUE; // = pas d'erreur
      $article = NULL; // mais résultat vide
    }
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    if (! $requête) { // erreur lors de la préparation
      $erreur = @mysqli_error($connexion);
    } else { // erreur ailleurs
      $erreur = @mysqli_stmt_error($requête);
    }
  }
  return $ok;
}

// Fonction pour enregistrer un article.
function enregistrer_article($connexion,$article,&$erreur) {
  // Texte de la requête.
  $sql = 'UPDATE articles SET libelle = ?, prix = ? ' .
         'WHERE identifiant = ?';
  // Préparer la requête.
  $ok = (bool) ($requête = @mysqli_prepare($connexion,$sql));
  // Lier les paramètres.
  if ($ok) {
    $ok = @mysqli_stmt_bind_param
            (
            $requête,
            'sdi',
            $article['libelle'],
            $article['prix'],
            $article['identifiant']
            );
  }
  // Exécuter la requête.
  if ($ok) {
    $ok = @mysqli_stmt_execute($requête);
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    if (! $requête) { // erreur lors de la préparation
      $erreur = @mysqli_error($connexion);
    } else { // erreur ailleurs
      $erreur = @mysqli_stmt_error($requête);
    }
  }
  return $ok;
}

// Fonction pour enregistrer une liste d'articles (en liaison
// avec le formulaire de saisie en liste).
function enregistrer_articles($connexion,$lignes,&$erreur) {
  // Initialiser les variables utilisées pour les curseurs paramétrés.
  $reqINS = NULL;
  $reqUPD = NULL;
  $reqDEL = NULL;
  // Initialiser l'indicateur de succès.
  $ok = NULL; // NULL = aucune mise à jour effectuée.
  // Parcourir le résultat de la saisie.
  foreach($lignes as $identifiant => $ligne) {
    // Récupérer les valeurs.
    $libellé = $ligne['libelle'];
    $prix = $ligne['prix'];
    // Définir la requête à exécuter.
    // Pour chaque action, la requête est différente.
    $requête = NULL;
    if ($identifiant < 0 and $libellé.$prix != '') {
      // Identifiant négatif et quelque chose de saisi = création = INSERT
      if ($reqINS == NULL) {
        // La première fois, préparer la requête.
        $sql = 'INSERT INTO articles(libelle,prix) VALUES(?,?)';
        $ok = (bool) ($reqINS = @mysqli_prepare($connexion,$sql));
        if ($ok) {
          $ok = @mysqli_stmt_bind_param($reqINS,'sd',$libellé,$prix);
        }
      }
      $requête = $reqINS;
    } elseif (isset($ligne['supprimer'])) {
      // Case "supprimer" cochée = suppression = DELETE
      if ($reqDEL == NULL) {
        // La première fois, préparer la requête.
        $sql = 'DELETE FROM articles WHERE identifiant = ?';
        $ok = (bool) ($reqDEL = @mysqli_prepare($connexion,$sql));
        if ($ok) {
          $ok = @mysqli_stmt_bind_param($reqDEL,'i',$identifiant);
        }
      }
      $requête = $reqDEL;
    } elseif (! empty($ligne['modifier'])) {
      // Zone "modifier" non vide = modification = UPDATE
      if ($reqUPD == NULL) {
        // La première fois, préparer la requête.
        $sql = 'UPDATE articles SET libelle = ?, prix = ? '.
               'WHERE identifiant = ?';
        $ok = (bool) ($reqUPD = @mysqli_prepare($connexion,$sql));
        if ($ok) {
          $ok = @mysqli_stmt_bind_param($reqUPD,'sdi',
                                        $libellé,$prix,$identifiant);
        }
      }
      $requête = $reqUPD;
    }
    // En cas d'erreur, interrompre le traitement.
    if ($ok === FALSE) {break;}
    // Si une requête a été déterminée, l'exécuter.
    // Au préalable, démarrer une transaction si cela n'a pas 
    // déjà été fait.
    if ($requête != NULL) {
      if (! isset($transaction)) {
        $ok = @mysqli_begin_transaction($connexion);
        $transaction = TRUE;
      }
      if ($ok) {
        $ok = @mysqli_stmt_execute($requête);
      }
      // En cas d'erreur, interrompre le traitement.
      if (! $ok) {break;}
    }
  } // foreach
  // Si tout s'est bien passé, valider la transaction.
  if ($ok) {
    $ok = @mysqli_commit($connexion);
  }
  // En cas de problème, récupérer le message d'erreur et annuler
  // la transaction.
  if (! $ok) {
    if (! $requête) { // erreur lors de la préparation
      $erreur = @mysqli_error($connexion);
    } else { // erreur ailleurs
      $erreur = @mysqli_stmt_error($requête);
    }
    @mysqli_rollback($connexion);
  }
  return $ok;
}
?>
