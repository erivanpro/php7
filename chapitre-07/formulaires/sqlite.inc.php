<?php

// Constantes pour les différents noms de colonnes.
const IDENTIFIANT='identifiant';
const LIBELLE='libelle';
const PRIX='prix';

// Fonction pour la connexion à la base de données.
function connexion(&$connexion,&$erreur) {
  // Ouvrir la base de données et gérer l'exception éventuelle.
  try 
  {
    $connexion = new SQLite3('/app/sqlite/diane.dbf');
    $ok = TRUE;
  } catch (Exception $e) { // erreur
    // Récupérer le message d'erreur.
    $erreur = $e->getMessage();
    $ok = FALSE;
  }
  return $ok;
}

// Fonction pour la sélection des articles.
function sélectionner_articles($connexion,&$requête,&$erreur) {
  // Texte de la requête.
  $sql = 'SELECT identifiant,libelle,prix FROM articles ORDER BY libelle';
  // Exécuter la requête.
  $ok = (bool) ($requête = $connexion->query($sql));
  // Récupérer le message d'erreur éventuel.
  if (! $ok) { // erreur
    $erreur = $connexion->lastErrorMsg();
  }
  return $ok;
}

// Fonction pour la lecture de l'article suivant dans
// le résultat d'une requête.
function lire_article_suivant($connexion,$requête,&$article,&$erreur) {
  $ok = (bool) ($article = @$requête->fetchArray());
  // Si fetchArray retourne FALSE, vérifier si c'est 
  // à cause d'une erreur ou pas.
  if (! $ok) {
    if (in_array(@$connexion->lastErrorCode(),[0,100,101])) { // pas d'erreur
      $ok = NULL; // retourner NULL au lieu de FALSE
    } else { // erreur => récupérer le message d'erreur
      $erreur = @$connexion->lastErrorMsg();
    }
  }
  return $ok;
}

// Fonction pour la sélection d'un article dont l'identifiant 
// est passé en paramètre.
function sélectionner_un_article($connexion,$identifiant,&$article,&$erreur) {
  // Texte de la requête.
  $sql = 'SELECT identifiant,libelle,prix FROM articles WHERE identifiant = ?';
  // Préparer la requête.
  $ok = (bool) ($requête = @$connexion->prepare($sql));  
  // Lier les paramètres.
  if ($ok) {
    $ok = @$requête->bindParam(1,$identifiant);  
  }
  // Exécuter la requête.
  if ($ok) {
    $ok = (bool) ($résultat = @$requête->execute()); 
  }
  // Lire le résultat.
  if ($ok) {
    $article = @$résultat->fetchArray();
    $ok = in_array(@$connexion->lastErrorCode(),[0,100,101]);
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    $erreur = @$connexion->lastErrorMsg();
  }
  return $ok;
}

// Fonction pour enregistrer un article.
function enregistrer_article($connexion,$article,&$erreur) {
  // Texte de la requête.
  $sql = 'UPDATE articles SET libelle = ?, prix = ? ' .
         'WHERE identifiant = ?';
  // Préparer la requête.
  $ok = (bool) ($requête = @$connexion->prepare($sql));  
  // Lier les paramètres.
  if ($ok) {
    $ok =    @$requête->bindParam(1,$article['libelle'])
          && @$requête->bindParam(2,$article['prix'])
          && @$requête->bindParam(3,$article['identifiant']);  
  }
  // Exécuter la requête.
  if ($ok) {
    $ok = (bool) @$requête->execute();  
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    $erreur = @$connexion->lastErrorMsg();
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
        $ok = (bool) ($reqINS = @$connexion->prepare($sql));
        if ($ok) {
          $ok =    @$reqINS->bindParam(1,$libellé)
                && @$reqINS->bindParam(2,$prix);  
        }
      }
      $requête = $reqINS;
    } elseif (isset($ligne['supprimer'])) {
      // Case "supprimer" cochée = suppression = DELETE
      if ($reqDEL == NULL) {
        // La première fois, préparer la requête.
        $sql = 'DELETE FROM articles WHERE identifiant = ?';
        $ok = (bool) ($reqDEL = @$connexion->prepare($sql));
        if ($ok) {
          $ok = @$reqDEL->bindParam(1,$identifiant);  
        }
      }
      $requête = $reqDEL;
    } elseif (! empty($ligne['modifier'])) {
      // Zone "modifier" non vide = modification = UPDATE
      if ($reqUPD == NULL) {
        // La première fois, préparer la requête.
        $sql = 'UPDATE articles SET libelle = ?, prix = ? '.
               'WHERE identifiant = ?';
        $ok = (bool) ($reqUPD = @$connexion->prepare($sql));
        if ($ok) {
          $ok =    @$reqUPD->bindParam(1,$libellé)
                && @$reqUPD->bindParam(2,$prix)
                && @$reqUPD->bindParam(3,$identifiant);  
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
        $ok = @$connexion->exec('BEGIN TRANSACTION');
        $transaction = TRUE;
      }
      if ($ok) {
        $ok = (bool) @$requête->execute();  
      }
      // En cas d'erreur, interrompre le traitement.
      if (! $ok) {break;}
    }
  } // foreach
  // Si tout s'est bien passé, valider la transaction.
  if ($ok) {
    $ok = @$connexion->exec('COMMIT');
  }
  // En cas de problème, récupérer le message d'erreur et annuler
  // la transaction.
  if (! $ok) {
    $erreur = @$connexion->lastErrorMsg();
    @$connexion->exec('ROLLBACK');
  }
  return $ok;
}
?>
