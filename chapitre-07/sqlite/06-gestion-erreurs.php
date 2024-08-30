<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Gestion des erreurs</title>
  </head>
  <body>
    <div>

    <?php 
    // Ouvrir la base. 
    $base = new SQLite3('/app/sqlite/diane.dbf'); 
    // Une bonne requête pour commencer. 
    $requête = 'SELECT * FROM articles'; 
    $résultat = $base->query($requête); 
    $code = $base->lastErrorCode(); 
    $message = $base->lastErrorMsg(); 
    echo "1 : $code - $message<br />"; 
    // Requête sur une table qui n’existe pas. 
    $requête = 'SELECT * FROM article'; 
    $résultat = $base->query($requête); 
    $code = $base->lastErrorCode(); 
    $message = $base->lastErrorMsg(); 
    echo "2 : $code - $message<br />"; 
    // requête INSERT qui viole une clé primaire. 
    $requête = "INSERT INTO articles(identifiant,libelle,prix) " . 
               "VALUES(1,'Poires',29.9)"; 
    $résultat = $base->query($requête); 
    $code = $base->lastErrorCode(); 
    $message = $base->lastErrorMsg(); 
    echo "3 : $code - $message<br />"; 
    // Tentative de fetch sur un mauvais résultat. 
    $requête = 'SELECT * FROM article'; 
    $résultat = $base->query($requête); 
    $code = $base->lastErrorCode(); 
    $message = $base->lastErrorMsg(); 
    echo "4 : $code - $message<br />"; 
    $ligne = $résultat->fetchArray(); 
    $code = $base->lastErrorCode(); 
    $message = $base->lastErrorMsg(); 
    echo "5 : $code - $message<br />"; 
    ?>

    </div>
  </body>
</html>
