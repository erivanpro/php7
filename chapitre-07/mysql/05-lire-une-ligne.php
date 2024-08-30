<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête non préparée : lire ligne</title>
  </head>
  <body>
    <div>

    <?php
    // Identifiant de l'article à lire.
    $identifiant = 1;
    // Connexion et sélection de la base
    $connexion = mysqli_connect();
    $ok = mysqli_select_db($connexion,'diane') ;
    // Exécution de la requête de sélection.
    $requête = "SELECT * FROM articles " .
                "WHERE identifiant = $identifiant";
    $résultat = mysqli_query($connexion,$requête);
    // Lecture et affichage du résultat
    $article = mysqli_fetch_assoc($résultat);
    echo $article['identifiant'],' - ',$article['libelle'],
         ' - ',$article['prix'],'<br />';
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
