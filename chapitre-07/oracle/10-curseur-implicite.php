<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Lire un curseur implicite (nouveauté d'Oracle 12c)</title>
  </head>
  <body>
    <div>

    <?php
    // Connexion.
    $connexion = oci_connect('demeter','demeter','diane');
    // La procédure est appelée dans un bloc PL/SQL.
    $requête = 'BEGIN lire_curseur_implicite(); END;';
    // Analyse.
    $curseur = oci_parse($connexion,$requête);
    // Exécution.
    $ok = oci_execute($curseur,OCI_DEFAULT);
    // Récupération du curseur implicite.
    $curseur_résultat = oci_get_implicit_resultset($curseur);
    // Fetch de toutes les lignes.
    while ($article = oci_fetch_array($curseur_résultat,
                                      OCI_ASSOC+OCI_RETURN_NULLS)) {
      echo "{$article['LIBELLE']} - {$article['PRIX']}<br />";
    }
    ?>

    </div>
  </body>
</html>
