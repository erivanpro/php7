<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Transaction</title>
  </head>
  <body>
    <div>

    <?php
    // Définition d’une petite fonction d’affichage de la liste 
    // des articles. 
    // Cette fonction utilise une requête préparée qui ne sera 
    // préparée qu'une fois, lors du premier appel.
    // La variable qui stocke le résultat de la préparation ainsi que
    // le tableau utilisé pour la liaison sont des variables statiques
    // dont les valeurs sont préservées d'un appel à un autre.
    function afficher_articles($connexion) { 
      static $requête;
      static $ligne = array();
      if (! isset($requête)) { // $requête non définie = premier appel
        $sql = 'SELECT * FROM articles'; 
        $requête = mysqli_prepare($connexion,$sql);
        $ok = mysqli_stmt_bind_result($requête,$ligne[],$ligne[],$ligne[]); 
      }
      $ok = mysqli_stmt_execute($requête); 
      echo '<b>Liste des articles :</b><br />'; 
      while (mysqli_stmt_fetch($requête)) { 
        echo $ligne[0],' - ',$ligne[1],' - ',$ligne[2],'<br />'; 
      } 
    } 
    // Connexion (utilisation des valeurs par défaut). 
    $connexion = mysqli_connect(); 
    if (! $connexion) { 
      exit('Echec de la connexion.'); 
    } 
    // Sélection de la base de données. 
    $ok = mysqli_select_db($connexion,'diane'); 
    if (! $ok) { 
      exit('Echec de la sélection de la base de données.'); 
    } 
    // Affichage de contrôle. 
    afficher_articles($connexion); 
    // Démarrer une transaction.
    $ok = mysqli_begin_transaction($connexion);
    // Requête INSERT (paramétrée).
    $sql = 'INSERT INTO articles(libelle,prix) VALUES(?,?)';
    $requête = mysqli_prepare($connexion, $sql);
    $ok = mysqli_stmt_bind_param($requête,'sd',$libellé,$prix);
    $libellé = 'Mangues';
    $prix = 24.5;
    $ok = mysqli_stmt_execute($requête);
    // Requête UPDATE (paramétrée).
    $sql = 'UPDATE articles SET prix = ? WHERE identifiant = ?'; 
    $requête = mysqli_prepare($connexion, $sql); 
    $ok = mysqli_stmt_bind_param($requête,'di',$prix,$identifiant); 
    $identifiant = 3;
    $prix = 29.9;
    $ok = mysqli_stmt_execute($requête); 
    // COMMIT.
    $ok = mysqli_commit($connexion);
    // Désactiver le COMMIT automatique.
    $ok = mysqli_autocommit($connexion,FALSE);
    // Requête DELETE de tous les articles (oups !). 
    $sql = 'DELETE FROM articles '; 
    $requête = mysqli_query($connexion, $sql); 
    // ROLLBACK (ouf !). 
    $ok = mysqli_rollback($connexion); 
    // Affichage de contrôle.
    afficher_articles($connexion);
    // Déconnexion. 
    $ok = mysqli_close($connexion); 
    ?>

    </div>
  </body>
</html>
