<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Tester les différentes techniques de fetch (mysqli_fetch_all)</title>
  </head>
  <body>
    <div>

    <?php
    // Inclusion du fichier qui contient la définition de
    // la fonction 'afficher_tableau'.
    require('../../include/fonctions.inc.php');
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
    // Exécution d'une requête.
    $sql = 'SELECT * FROM articles';
    $requête = mysqli_query($connexion,$sql);
    // Fetch de toutes les lignes :
    // - paramètres par défaut = MYSQLI_NUM
    $résultat = mysqli_fetch_all($requête);
    afficher_tableau($résultat,'mysqli_fetch_all($requête)');
    // Détermination du nombre de lignes lues.
    $nombre = mysqli_num_rows($requête);
    echo "$nombre lignes dans le résultat";
    // Nouvelle exécution de la requête.
    $requête = mysqli_query($connexion,$sql);
    // Fetch de toutes les lignes :
    // - MYSQLI_ASSOC
    $résultat = mysqli_fetch_all($requête,MYSQLI_ASSOC);
    afficher_tableau($résultat,'mysqli_fetch_all($requête,MYSQLI_ASSOC)');
    // Détermination du nombre de lignes lues.
    $nombre = mysqli_num_rows($requête);
    echo "$nombre lignes dans le résultat";
    // Nouvelle exécution de la requête.
    $requête = mysqli_query($connexion,$sql);
    // Fetch de toutes les lignes :
    // - MYSQLI_BOTH
    $résultat = mysqli_fetch_all($requête,MYSQLI_BOTH);
    afficher_tableau($résultat,'mysqli_fetch_all($requête,MYSQLI_BOTH)');
    // Détermination du nombre de lignes lues.
    $nombre = mysqli_num_rows($requête);
    echo "$nombre lignes dans le résultat";
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
