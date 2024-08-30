<?php

// Constantes pour les différents noms de colonnes.
const IDENTIFIANT='IDENTIFIANT';
const LIBELLE='LIBELLE';
const PRIX='PRIX';

// Fonction pour la connexion à la base de données.
function connexion(&$connexion,&$erreur) {
  $connexion = @oci_connect('demeter','demeter','diane','AL32UTF8');
  // Tester si la connexion s'est bien passée.
  if ($connexion === FALSE) { // erreur 
    // Récupérer le message d'erreur.
     $erreur = @oci_error()['message'];
     $ok = FALSE;
  } else {
    $ok = TRUE;
  }
  return $ok;
}

// Fonction pour la sélection des articles.
function sélectionner_articles($connexion,&$requête,&$erreur) {
  // Texte de la requête.
  $sql = 'SELECT identifiant,libelle,prix FROM articles ORDER BY libelle';
  // Analyser la requête.
  $ok = (bool) ($requête = @oci_parse($connexion,$sql));
  // Exécuter la requête.
  if ($ok) {
    $ok = @oci_execute($requête);
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    // Récupérer le message d'erreur.
    if (! $requête) { // erreur lors de l'analyse
      $erreur = @oci_error($connexion)['message'];
    } else { // erreur ailleurs
      $erreur = @oci_error($requête)['message'];
    }
  }
  return $ok;
}

// Fonction pour la lecture de l'article suivant dans
// le résultat d'une requête.
function lire_article_suivant($connexion,$requête,&$article,&$erreur) {
  $ok = (bool) ($article = @oci_fetch_array($requête));
  // Si oci_fetch_array retourne FALSE, vérifier si c'est 
  // à cause d'une erreur ou pas.
  if (! $ok) {
    $e = @oci_error($requête); 
    if ($e === FALSE) { // pas d'erreur
      $ok = NULL; // retourner NULL au lieu de FALSE
    } else { // erreur => récupérer le message d'erreur
      $erreur = $e['message'];
    }
  }
  return $ok;
}

// Fonction pour la sélection d'un article dont l'identifiant 
// est passé en paramètre.
function sélectionner_un_article($connexion,$identifiant,&$article,&$erreur) {
  // Texte de la requête.
  $sql = 'SELECT identifiant,libelle,prix FROM articles WHERE identifiant = :p1';
  // Analyser la requête.
  $ok = (bool) ($requête = @oci_parse($connexion,$sql));
  // Lier le paramètre.
  if ($ok) {
    $ok = (bool) @oci_bind_by_name($requête,':p1',$identifiant,-1,SQLT_INT);
  }
  // Exécuter la requête.
  if ($ok) {
    $ok = @oci_execute($requête);
  }
  // Lire le résultat.
  if ($ok) {
    $article = @oci_fetch_array($requête);
    $ok = (bool) (! @oci_error($requête));
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    if (! $requête) { // erreur lors de l'analyse
      $erreur = @oci_error($connexion)['message'];
    } else { // erreur ailleurs
      $erreur = @oci_error($requête)['message'];
    }
  }
  return $ok;
}

// Fonction pour enregistrer un article.
function enregistrer_article($connexion,$article,&$erreur) {
  // Texte de la requête.
  $sql = 'UPDATE articles SET libelle = :p1, prix = :p2 ' .
         'WHERE identifiant = :p3';
  // Analyser la requête.
  $ok = (bool) ($requête = @oci_parse($connexion,$sql));
  // Lier les paramètres.
  if ($ok) {
    $ok =    @oci_bind_by_name($requête,':p1',$article['libelle'])
          && @oci_bind_by_name($requête,':p2',$article['prix'])
          && @oci_bind_by_name($requête,':p3',$article['identifiant'],-1,SQLT_INT);
  }
  // Exécuter la requête.
  if ($ok) {
    $ok = @oci_execute($requête);
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
    if (! $requête) { // erreur lors de l'analyse
      $erreur = @oci_error($connexion)['message'];
    } else { // erreur ailleurs
      $erreur = @oci_error($requête)['message'];
    }
  }
  return $ok;
}

// Fonction pour enregistrer une liste d'articles (en liaison
// avec le formulaire de saisie en liste).
function enregistrer_articles($connexion,$lignes,&$erreur) {
  // Initialiser les variables utilisées pour les requêtes paramétrés.
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
        $sql = 'INSERT INTO articles(libelle,prix) VALUES(:p1,:p2)';
        $ok = (bool) ($reqINS = @oci_parse($connexion,$sql));
        if ($ok) {
          $ok = @oci_bind_by_name($reqINS,':p1',$libellé,40)
             && @oci_bind_by_name($reqINS,':p2',$prix,32);
        }
      }
      $requête = $reqINS;
    } elseif (isset($ligne['supprimer'])) {
      // Case "supprimer" cochée = suppression = DELETE
      if ($reqDEL == NULL) {
        // La première fois, préparer la requête.
        $sql = 'DELETE FROM articles WHERE identifiant = :p1';
        $ok = (bool) ($reqDEL = @oci_parse($connexion,$sql));
        if ($ok) {
          $ok = @oci_bind_by_name($reqDEL,':p1',$identifiant,-1,SQLT_INT);
        }
      }
      $requête = $reqDEL;
    } elseif (! empty($ligne['modifier'])) {
      // Zone "modifier" non vide = modification = UPDATE
      if ($reqUPD == NULL) {
        // La première fois, préparer la requête.
        $sql = 'UPDATE articles SET libelle = :p1, prix = :p2 '.
               'WHERE identifiant = :p3';
        $ok = (bool) ($reqUPD = @oci_parse($connexion,$sql));
        if ($ok) {
          $ok = @oci_bind_by_name($reqUPD,':p1',$libellé,40)
             && @oci_bind_by_name($reqUPD,':p2',$prix,32)
             && @oci_bind_by_name($reqUPD,':p3',$identifiant,-1,SQLT_INT);
        }
      }
      $requête = $reqUPD;
    }
    // En cas d'erreur, interrompre le traitement.
    if ($ok === FALSE) {break;}
    // Si une requête a été déterminée, l'exécuter.
    if ($requête != NULL) {
      // Pas de COMMIT automatique.
      $ok = @oci_execute($requête,OCI_DEFAULT);
      // En cas d'erreur, interrompre le traitement.
      if (! $ok) {break;}
    }
  } // foreach
  // Si tout s'est bien passé, valider la transaction.
  if ($ok) {
    $ok = @oci_commit($connexion);
  }
  // En cas de problème, récupérer le message d'erreur et annuler
  // la transaction.
  if (! $ok) {
    if (! $requête) { // erreur lors de l'analyse
      $erreur = @oci_error($connexion)['message'];
    } else { // erreur ailleurs
      $erreur = @oci_error($requête)['message'];
    }
    @oci_rollback($connexion);
  }
  return $ok;
}
?>
