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
    // Exécution d'une requête
    $sql = 'SELECT * FROM articles';
    $requête = mysqli_query($connexion,$sql);
    // Premier fetch avec mysqli_fetch_row.
    $ligne = mysqli_fetch_row($requête);
    afficher_tableau($ligne,'mysql_fetch_row');
    // Deuxième fetch avec mysql_fetch_assoc.
    $ligne = mysqli_fetch_assoc($requête);
    afficher_tableau($ligne,'mysql_fetch_assoc');
    // Troisième fetch avec mysql_fetch_array :
    // -> sans deuxième paramètre = MYSQLI_BOTH
    $ligne = mysqli_fetch_array($requête);
    afficher_tableau($ligne,'mysql_fetch_array');
    // Quatrième fetch avec mysql_fetch_object.
    $ligne = mysqli_fetch_object($requête);
    echo "<p /><b>mysql_fetch_object</b><br />";
    echo "\$ligne->identifiant = $ligne->identifiant<br />";
    echo "\$ligne->libelle = $ligne->libelle<br />";
    echo "\$ligne->prix = $ligne->prix<br />";
    // Cinquième fetch de nouveau avec mysql_fetch_row :
    // -> normalement, plus de ligne.
    $ligne = mysqli_fetch_row($requête);
    if ($ligne === NULL) {
    	echo '<p /><b>Cinquième fetch : plus rien</b>';
    }
    // Déconnexion.
    $ok = mysqli_close($connexion);
    ?>

    </div>
  </body>
</html>
