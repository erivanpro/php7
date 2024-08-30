<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête non préparée : lire plusieurs lignes</title>
  </head>
  <body>
    <div>

    <?php
    // Connexion et sélection de la base
    $connexion = mysqli_connect();
    $ok = mysqli_select_db($connexion,'diane') ;
    // Exécution de la requête de sélection.
    $requête = 'SELECT identifiant,libelle FROM articles';
    $résultat = mysqli_query($connexion,$requête);
    // Lecture et affichage du résultat
    while ($article = mysqli_fetch_assoc($résultat)) {
      echo $article['identifiant'],' - ',$article['libelle'],'<br />';
    }
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
