<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Lire plusieurs lignes</title>
  </head>
  <body>
    <div>

    <?php
    // Connexion.
    $connexion = oci_connect('demeter','demeter','diane'); 
    // Définition de la requête. 
    $requête = 'SELECT identifiant,libelle FROM articles'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur); 
    // Lecture et affichage du résultat
    while ($article = oci_fetch_assoc($curseur)) {
      echo $article['IDENTIFIANT'],' - ',$article['LIBELLE'],'<br />';
    }
    // Déconnexion.
    $ok = oci_close($connexion);
    ?>

    </div>
  </body>
</html>
