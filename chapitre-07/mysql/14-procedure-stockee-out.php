<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Procédure stockée avec paramètre OUT</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>

    <h1>Requête non préparée</h1>
    <?php
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
    // Définition des caractéristiques du nouvel article.
    $libellé = 'Ananas';
    $prix = 19.90;
    // Exécution de la requête d'appel de la procédure.
    // Le paramètre OUT de la procédure est récupéré dans la
    // variable MySQL @identifiant.
    $sql = "CALL ps_creer_article('$libellé',$prix,@identifiant)";
    $requête = mysqli_query($connexion,$sql);
    // Exécution de la requête qui lit le contenu de la 
    // variable MySQL @identifiant.
    $sql='SELECT @identifiant';
    $requête = mysqli_query($connexion,$sql);
    $ligne = mysqli_fetch_assoc($requête);
    // Affichage du résultat.
    echo 'Identifiant du nouvel article = ',
         $ligne['@identifiant'],'<br />';
    // Exécution d'une requête qui supprime le nouvel article.
    $sql = "DELETE FROM articles WHERE identifiant = {$ligne['@identifiant']}";
    $requête = mysqli_query($connexion,$sql);
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    <h1>Requête préparée</h1>
    <?php
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
    // Définition des caractéristiques du nouvel article.
    $libellé = 'Ananas';
    $prix = 19.90;
    // Exécution de la requête d'appel de la procédure.
    // Le paramètre OUT de la procédure est récupéré dans la
    // variable MySQL @identifiant.
    $sql = "CALL ps_creer_article(?,?,@identifiant)";
    $requête = mysqli_prepare($connexion,$sql);
    $ok = mysqli_stmt_bind_param($requête,'sd',$libellé,$prix);
    $ok = mysqli_stmt_execute($requête);
    mysqli_stmt_close($requête);
    // Exécution de la requête qui lit le contenu de la 
    // variable MySQL @identifiant.
    $sql='SELECT @identifiant';
    $requête = mysqli_prepare($connexion,$sql);
    $ok = mysqli_stmt_bind_result($requête,$identifiant);
    $ok = mysqli_stmt_execute($requête);
    $ok = mysqli_stmt_fetch($requête);
    mysqli_stmt_close($requête);
    // Affichage du résultat.
    echo "Identifiant du nouvel article = $identifiant"; 
    // Exécution d'une requête qui supprime le nouvel article.
    $sql = 'DELETE FROM articles WHERE identifiant = ?';
    $requête = mysqli_prepare($connexion,$sql);
    $ok = mysqli_stmt_bind_param($requête,'d',$identifiant);
    $ok = mysqli_stmt_execute($requête);
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
