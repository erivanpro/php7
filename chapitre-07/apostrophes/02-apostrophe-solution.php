<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Gestion des apostrophes (solution)</title>
  </head>
  <body>
    <div>

    <?php
    // Donnée corrigée (valable pour toutes les bases).
    $libellé = "Pomme d''api";
    $prix = 10;
    // Requête.
    $requête = "INSERT INTO articles(libelle,prix) " .
               "VALUES('$libellé',$prix)";
    echo "$requête<br />";
    // Exécution avec MySQL.
    echo "<p><b>MySQL</b><br />";
    $connexion = mysqli_connect();
    $ok = mysqli_select_db($connexion,'diane');
    $résultat = mysqli_query($connexion,$requête);
    echo mysqli_error($connexion),'<br />'; // MySQL ne génère pas d’alerte
    // Exécution avec Oracle.
    echo "<p><b>Oracle</b><br />";
    $connexion = oci_connect('demeter','demeter','diane');
    $résultat = oci_execute(oci_parse($connexion,$requête));
    // Exécution avec SQLite.
    echo "<p><b>SQLite</b><br />";
    $base = new SQLite3('/app/sqlite/diane.dbf');
    $résultat = $base->query($requête);
    ?>

    </div>
  </body>
</html>
