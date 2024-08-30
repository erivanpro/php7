<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Fonction stockée</title>
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
    // Exécution de la requête qui appelle la fonction
    // (l'expression qui appelle la fonction est nommée avec
    // un alias de colonne).
    $sql = "SELECT fs_nombre_articles($prix_max) nb";
    $requête = mysqli_query($connexion,$sql);
    $ligne = mysqli_fetch_assoc($requête);
    echo 'Nombre d\'articles = ',$ligne['nb'];
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
    // Exécution de la requête qui appelle la fonction
    // (l'expression qui appelle la fonction est nommée avec
    // un alias de colonne).
    $sql = "SELECT fs_nombre_articles(?) nb";
    $requête = mysqli_prepare($connexion,$sql);
    $ok = mysqli_stmt_bind_param($requête,'d',$prix_max);
    $ok = mysqli_stmt_execute($requête);
    $ok = mysqli_stmt_bind_result($requête,$nb);
    $ok = mysqli_stmt_fetch($requête);
    echo 'Nombre d\'articles = ',$nb;
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
