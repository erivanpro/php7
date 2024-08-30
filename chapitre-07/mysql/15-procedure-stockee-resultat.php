<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Procédure stockée qui retourne un résultat directement</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>

    <h1>Requête non préparée</h1>
    <?php
    $connexion = mysqli_connect(); 
    if (! $connexion) { 
      exit('Echec de la connexion.'); 
    } 
    // Sélection de la base de données. 
    $ok = mysqli_select_db($connexion,'diane'); 
    if (! $ok) { 
      exit('Echec de la sélection de la base de données.'); 
    } 
    // Prix maximum.
    $prix_max = 30;
    // Exécution de la requête d'appel de la procédure.
    $sql = "CALL ps_lire_articles($prix_max)";
    $requête = mysqli_query($connexion,$sql);
    while ($ligne = mysqli_fetch_assoc($requête)) {
      echo $ligne['libelle'],'<br />';
    }
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>
    
    <h1>Requête préparée</h1>
    <?php
    $connexion = mysqli_connect(); 
    if (! $connexion) { 
      exit('Echec de la connexion.'); 
    } 
    // Sélection de la base de données. 
    $ok = mysqli_select_db($connexion,'diane'); 
    if (! $ok) { 
      exit('Echec de la sélection de la base de données.'); 
    } 
    // Prix maximum.
    $prix_max = 30;
    // Exécution de la requête d'appel de la procédure.
    $sql = "CALL ps_lire_articles(?)";
    $requête = mysqli_prepare($connexion,$sql);
    $ok = mysqli_stmt_bind_param($requête,'d',$prix_max);
    $ok = mysqli_stmt_execute($requête);
    // Important de faire le bind du résultat après le execute
    // car la structure du résultat n'est pas connue avant.
    $ok = mysqli_stmt_bind_result($requête,$libellé);
    while (mysqli_stmt_fetch($requête)) {
      echo $libellé,'<br />';
    }
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
