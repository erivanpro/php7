<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Tester les différentes techniques de fetch</title>
  </head>
  <body>
    <div>

    <?php
    // Inclusion du fichier qui contient la définition de
    // afficher_tableau.
    require('../../include/fonctions.inc.php');
    // Ouverture de la base.
    $base = new SQLite3('/app/sqlite/diane.dbf');
    // Définition de la requête.
    $requête = 'SELECT * FROM articles';
    // Exécution de la requête.
    $résultat = $base->query($requête);
    // Premier fetch sans paramètre.
    $ligne = $résultat->fetchArray();
    afficher_tableau($ligne,'sans paramètre');
    // Deuxième fetch avec SQLITE3_BOTH.
    $ligne = $résultat->fetchArray(SQLITE3_BOTH);
    afficher_tableau($ligne,'SQLITE3_BOTH');
    // Troisième fetch avec SQLITE3_ASSOC.
    $ligne = $résultat->fetchArray(SQLITE3_ASSOC);
    afficher_tableau($ligne,'SQLITE3_ASSOC');
    // Quatrième fetch avec SQLITE3_NUM.
    $ligne = $résultat->fetchArray(SQLITE3_NUM);
    afficher_tableau($ligne,'SQLITE3_NUM');
    // Cinquième fetch de nouveau sans paramètre :
    //  - normalement, plus de ligne
    $ligne = $résultat->fetchArray();
    if (! $ligne) {
      echo "<p><b>Cinquième fetch : plus rien</b>";
    }
    // Fermeture de la base. 
    $ok = $base->close(); 
    ?>

    </div>
  </body>
</html>
