<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Lire une ligne</title>
  </head>
  <body>
    <div>

    <?php
    // Identifiant de l'article à lire.
    $identifiant = 1;
    // Connexion.
    $connexion = oci_connect('demeter','demeter','diane'); 
    // Définition de la requête. 
    $requête = 'SELECT * FROM articles WHERE identifiant = :p1'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Liaison des paramètres. 
    $ok = oci_bind_by_name($curseur,':p1',$identifiant,1,OCI_B_INT); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur); 
    // Lecture et affichage du résultat
    $article = oci_fetch_assoc($curseur);
    echo $article['IDENTIFIANT'],' - ',$article['LIBELLE'],
         ' - ',$article['PRIX'],'<br />';
    // Déconnexion.
    $ok = oci_close($connexion);
    ?>

    </div>
  </body>
</html>
