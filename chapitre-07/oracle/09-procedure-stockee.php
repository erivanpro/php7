<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Appeler une procédure stockée</title>
  </head>
  <body>
    <div>

    <?php
    // Connexion.
    $connexion = oci_connect('demeter','demeter','diane','UTF8');
    // Insertion à l'aide du package :
    //    - la procédure est appelée dans un bloc PL/SQL
    $requête = 'BEGIN pkg_articles.creer(:p1,:p2,:r1); END;';
    //    - la procédure est appelée dans une instruction SQL CALL 
    // $requête = 'CALL pkg_articles.creer(:p1,:p2,:r1)'; 
    // Analyse.
    $curseur = oci_parse($connexion,$requête);
    // Association paramètres/variables.
    oci_bind_by_name($curseur,':p1',$libellé,50);
    oci_bind_by_name($curseur,':p2',$prix,32);
    oci_bind_by_name($curseur,':r1',$identifiant,32);
    // Exécution avec certaines valeurs.
    $libellé = 'Pommes';
    $prix = 10;
    // Pas de COMMIT automatique de oci_execute (le package
    // s'en charge).
    $ok = oci_execute($curseur,OCI_DEFAULT);
    // Affichage de l'identifiant du nouvel article.
    echo "Identifiant du nouvel article = $identifiant.<br />";
    // Comptage à l'aide du package :
    //    - la fonction est appelée dans un bloc PL/SQL
    $requête = 'BEGIN :r1 := pkg_articles.compter; END;';
    //    - la fonction est appelée dans une instruction SQL CALL 
    // $requête = 'CALL pkg_articles.compter() INTO :r1'; 
    // Analyse.
    $curseur = oci_parse($connexion,$requête);
    // Association paramètres/variables.
    oci_bind_by_name($curseur,':r1',$nombre,32);
    // Exécution.
    $ok = oci_execute($curseur,OCI_DEFAULT);
    echo "$nombre article(s) dans la base.<br />";
    // Lecture d'un article à l'aide du package :
    //    - la procédure est appelée dans un bloc PL/SQL
    $requête = 'BEGIN pkg_articles.lire(:p1,:r1); END;';
    //    - la procédure est appelée dans une instruction SQL CALL
    // $requête = 'CALL pkg_articles.lire(:p1,:r1)';
    // Analyse.
    $curseur = oci_parse($connexion,$requête);
    // Création d'un curseur pour le résultat.
    $curseur_résultat = oci_new_cursor($connexion);
    // Association paramètres/variables.
    oci_bind_by_name($curseur,':p1',$identifiant,32);
    oci_bind_by_name($curseur,':r1',$curseur_résultat,
                    -1,SQLT_RSET );
    // Exécution avec la valeur actuelle de $identifiant.
    // => lecture de l'article inséré précédemment
    $ok = oci_execute($curseur,OCI_DEFAULT);
    // Exécution du curseur résultat.
    $ok = oci_execute($curseur_résultat,OCI_DEFAULT);
    // Fetch.
    $article = oci_fetch_array($curseur_résultat,OCI_ASSOC+OCI_RETURN_NULLS);
    echo "Nouveau : {$article['LIBELLE']} - {$article['PRIX']}<br />";
    // Lecture de tous les articles à l'aide du package :
    //    - le curseur $curseur peut être réutilisé
    //    - par contre, $curseur_résultat est "grillé" : il faut
    //      le recréer et le re-associer
    oci_free_statement($curseur_résultat); // libération du premier
    $curseur_résultat = oci_new_cursor($connexion);
    oci_bind_by_name($curseur,':r1',$curseur_résultat,
                    -1,SQLT_RSET);
    // Exécution avec $identifiant = 0.
    $identifiant = 0;
    $ok = oci_execute($curseur,OCI_DEFAULT);
    // Exécution du curseur résultat.
    $ok = oci_execute($curseur_résultat,OCI_DEFAULT);
    // Fetch de toutes les lignes.
    echo "Liste : <br />";
    while ($article = oci_fetch_array($curseur_résultat,
                                      OCI_ASSOC+OCI_RETURN_NULLS)) {
      echo "&nbsp&nbsp {$article['LIBELLE']} - {$article['PRIX']}<br />";
    }
    ?>

    </div>
  </body>
</html>
