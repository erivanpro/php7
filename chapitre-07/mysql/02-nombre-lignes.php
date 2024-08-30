<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Nombre de lignes dans le résultat d'une requête de lecture</title>
  </head>
  <body>
    <div>

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
    // Exécution d'une requête SELECT.
    $requête = mysqli_query($connexion,'SELECT * FROM articles');
    if ($requête === FALSE) {
      echo 'Echec de l\'exécution de la requête.','<br />';
    } else {
      // Affichage du nombre de lignes dans le résultat
      echo 'Nombre d\'articles : ',mysqli_num_rows($requête) ,'<br />';
    }
    // Exécution d'une autre requête SELECT.
    $requête = mysqli_query($connexion,'SELECT * FROM articles WHERE prix > 40');
    if ($requête === FALSE) {
      echo 'Echec de l\'exécution de la requête.','<br />';
    } else {
      // Affichage du nombre de lignes dans le résultat
      echo
        'Nombre d\'articles dont le prix est supérieur à 40 : ',
        mysqli_num_rows($requête),
        '<br />';
    }
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
