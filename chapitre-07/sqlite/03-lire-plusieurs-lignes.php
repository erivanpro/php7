<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Lire plusieurs lignes</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>

    <h1>Requête non préparée</h1>
    <?php
    // Ouverture. 
    $base = new SQLite3('/app/sqlite/diane.dbf'); 
    // Exécution de la requête de sélection.
    $requête = 'SELECT * FROM articles';
    $résultat = $base->query($requête); 
    // Lecture et affichage du résultat
    while ($article = $résultat->fetchArray()) {
      echo $article['identifiant'],' - ',$article['libelle'],
           ' - ',$article['prix'],'<br />';
    }
    // Fermeture. 
    $ok = $base->close(); 
    ?>

    <h1>Requête préparée</h1>
    <?php
    // Ouverture de la base. 
    $base = new SQLite3('/app/sqlite/diane.dbf'); 
    // Préparation de la requête de sélection.
    $sql = 'SELECT * FROM articles WHERE prix < ?';
    $requête = $base->prepare($sql); 
    // Liaison des paramètres.
    $ok = $requête->bindParam(1,$prix_max); 
    // Exécution de la requête.
    $prix_max = 35; 
    $résultat = $requête->execute(); 
    // Lecture du résultat. 
    echo "<b>Articles dont le prix est < $prix_max </b><br />"; 
    while ($article = $résultat->fetchArray()) {
      echo $article['libelle'],' - ',$article['prix'],'<br />';
    }
    // Nouvelle exécution et lecture du résultat 
    // (inutile de refaire les liaisons). 
    $prix_max = 40; 
    $résultat = $requête->execute(); 
    // Lecture du résultat. 
    echo "<b>Articles dont le prix est < $prix_max </b><br />"; 
    while ($article = $résultat->fetchArray()) {
      echo $article['libelle'],' - ',$article['prix'],'<br />';
    }
    // Fermeture de la base. 
    $ok = $base->close(); 
    ?>

    </div>
  </body>
</html>
