<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Lire une ligne</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>

    <h1>Requête non préparée</h1>
    <?php
    // Identifiant de l'article à lire.
    $identifiant = 1;
    // Ouverture. 
    $base = new SQLite3('/app/sqlite/diane.dbf'); 
    // Exécution de la requête de sélection.
    $requête = "SELECT * FROM articles " .
                "WHERE identifiant = $identifiant";
    $résultat = $base->query($requête); 
    // Lecture et affichage du résultat
    $article = $résultat->fetchArray(); 
    echo $article['identifiant'],' - ',$article['libelle'],
         ' - ',$article['prix'],'<br />';
    // Fermeture. 
    $ok = $base->close(); 
    ?>
    
    <h1>Requête préparée</h1>
    <?php
    // Identifiant de l'article à lire.
    $identifiant = 1;
    // Ouverture de la base. 
    $base = new SQLite3('/app/sqlite/diane.dbf'); 
    // Préparation de la requête de sélection.
    $sql = 'SELECT * FROM articles WHERE identifiant = ?';
    $requête = $base->prepare($sql); 
    // Liaison des paramètres.
    $ok = $requête->bindParam(1,$identifiant); 
    // Exécution de la requête.
    $résultat = $requête->execute(); 
    // Lecture et affichage du résultat
    $article = $résultat->fetchArray(); 
    echo $article['identifiant'],' - ',$article['libelle'],
         ' - ',$article['prix'],'<br />';
    // Fermeture de la base. 
    $ok = $base->close(); 
    ?>

    </div>
  </body>
</html>
