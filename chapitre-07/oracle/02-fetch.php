<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Tester les différentes techniques de fetch (oci_fetch_*)</title>
  </head>
  <body>
    <div>

    <?php
    // Inclusion du fichier qui contient la définition de
    // afficher_tableau.
    require('../../include/fonctions.inc.php');
    // Connexion. 
    $connexion = oci_connect('demeter','demeter','diane'); 
    // Définition de la requête. 
    $requête = 'SELECT * FROM articles'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur); 
    // Détermination du nombre de lignes lues à ce stade. 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre ligne lue à ce stade"; 
    // Premier fetch avec oci_fetch_row. 
    $ligne = oci_fetch_row($curseur); 
    afficher_tableau($ligne,'oci_fetch_row'); 
    // Détermination du nombre de lignes lues à ce stade. 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre ligne lue à ce stade"; 
    // Deuxième fetch avec oci_fetch_assoc. 
    $ligne = oci_fetch_assoc($curseur); 
    afficher_tableau($ligne,'oci_fetch_assoc'); 
    // Détermination du nombre de lignes lues à ce stade. 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre lignes lues à ce stade"; 
    // Troisième fetch avec oci_fetch_array : 
    // - sans deuxième paramètre = OCI_BOTH. 
    $ligne = oci_fetch_array($curseur); 
    afficher_tableau($ligne,'oci_fetch_array'); 
    // Détermination du nombre de lignes lues à ce stade. 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre lignes lues à ce stade"; 
    // Quatrième fetch avec oci_fetch_object. 
    $ligne = oci_fetch_object($curseur); 
    echo "<br /><b>oci_fetch_object</b><br />"; 
    echo "\$ligne->IDENTIFIANT = $ligne->IDENTIFIANT<br />"; 
    echo "\$ligne->LIBELLE = $ligne->LIBELLE<br />"; 
    echo "\$ligne->PRIX = $ligne->PRIX<br />"; 
    // Détermination du nombre de lignes lues à ce stade. 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre lignes lues à ce stade<br />"; 
    // Cinquième fetch de nouveau sans paramètre : 
    //  - normalement, plus de ligne. 
    $ligne = oci_fetch_array($curseur); 
    if (! $ligne) { 
      echo "<b>Cinquième fetch : plus rien</b><br />"; 
    } 
    // Détermination du nombre de lignes lues à ce stade. 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre lignes lues à ce stade"; 
    // Déconnexion. 
    $ok = oci_close($connexion); 
    ?>

    </div>
  </body>
</html>
