<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Tester les différentes techniques de fetch (oci_fetch_all)</title>
  </head>
  <body>
    <div>

    <?php
    // Inclusion du fichier qui contient la définition de
    // afficher_tableau.
    require('../../include/fonctions.inc.php');
    // Connexion.
    $connexion = oci_connect('demeter','demeter','diane','UTF8');
    // Définition de la requête.
    $requête = 'SELECT * FROM articles';
    // Analyse de la requête.
    $curseur = oci_parse($connexion,$requête);
    // Exécution de la requête.
    $ok = oci_execute($curseur);
    // Fetch de toutes les lignes :
    // - paramètres par défaut
    $nombre = oci_fetch_all($curseur,$résultat);
    afficher_tableau($résultat,
      'oci_fetch_all($curseur,$résultat)');
    echo ($nombre)?"$nombre lignes dans le résultat":'FALSE';
    // Autre détermination du nombre de lignes lues.
    $nombre = oci_num_rows($curseur);
    echo "<br />$nombre lignes dans le résultat";
    // Exécution de la requête.
    $ok = oci_execute($curseur);
    // Fetch de toutes les lignes :
    // - résultat partiel : ignorer la 1ère ligne
    //                      2 lignes en tout
    $nombre = oci_fetch_all($curseur,$résultat,1,2);
    afficher_tableau($résultat,
      'oci_fetch_all($curseur,$résultat,1,2)');
    echo ($nombre)?"$nombre lignes dans le résultat":'FALSE';
    // Autre détermination du nombre de lignes lues.
    $nombre = oci_num_rows($curseur);
    echo "<br />$nombre lignes dans le résultat";
    // Exécution de la requête.
    $ok = oci_execute($curseur);
    // Fetch de toutes les lignes :
    // - résultat partiel : 2 lignes en tout
    // - présentation par ligne
    $nombre = oci_fetch_all($curseur,$résultat,
          0,2,OCI_FETCHSTATEMENT_BY_ROW);
    afficher_tableau($résultat,
      'oci_fetch_all($curseur,$résultat,'.
        '0,2,OCI_FETCHSTATEMENT_BY_ROW)');
    echo ($nombre)?"$nombre lignes dans le résultat":'FALSE';
    // Autre détermination du nombre de lignes lues.
    $nombre = oci_num_rows($curseur);
    echo "<br />$nombre lignes dans le résultat";
    // Exécution de la requête.
    $ok = oci_execute($curseur);
    // Fetch de toutes les lignes :
    // - résultat partiel : 2 lignes en tout
    // - présentation par ligne
    // - tableau numérique pour les colonnes
    $nombre = oci_fetch_all($curseur,$résultat,
          0,2,OCI_FETCHSTATEMENT_BY_ROW+OCI_NUM);
    afficher_tableau($résultat,
      'oci_fetch_all($curseur,$résultat,'.
        '0,2,OCI_FETCHSTATEMENT_BY_ROW+OCI_NUM)');
    echo ($nombre)?"$nombre lignes dans le résultat":'FALSE';
    // Autre détermination du nombre de lignes lues.
    $nombre = oci_num_rows($curseur);
    echo "<br />$nombre lignes dans le résultat";
    // Définition d’une requête qui ne retourne aucune ligne.
    $requête = "SELECT * FROM articles WHERE 0=1";
    // Analyse de la requête.
    $curseur = oci_parse($connexion,$requête);
    // Exécution de la requête.
    $ok = oci_execute($curseur);
    // Fetch de toutes les lignes :
    // - paramètres par défaut
    $nombre = oci_fetch_all($curseur,$résultat);
    afficher_tableau($résultat,'Pas de résultat : par colonne');
    echo ($nombre)?"$nombre lignes dans le résultat":'FALSE';
    // Autre détermination du nombre de lignes lues.
    $nombre = ociRowCount($curseur);
    echo "<br />$nombre ligne dans le résultat";
    // Exécution de la requête.
    $ok = oci_execute($curseur);
    // Fetch de toutes les lignes :
    // - présentation par ligne
    $nombre = oci_fetch_all($curseur,$résultat,0,-1,OCI_FETCHSTATEMENT_BY_ROW);
    afficher_tableau($résultat,'Pas de résultat : par ligne');
    echo ($nombre)?"$nombre lignes dans le résultat":'FALSE';
    // Autre détermination du nombre de lignes lues.
    $nombre = ociRowCount($curseur);
    echo "<br />$nombre ligne dans le résultat";
    // Déconnexion. 
    $ok = oci_close($connexion); 
    ?>

    </div>
  </body>
</html>
