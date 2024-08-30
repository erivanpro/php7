<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Construire une requête</title>
  </head>
  <body>
    <div>

    <?php
    // Inclure un fichier qui contient les différentes fonctions
    // générales
    require('../../include/fonctions.inc.php');
    // Des variables contiennent des valeurs venant de quelque part ...
    $libellé = "Pomme d'api";
    $prix = 10;
    // Construction de la requête.
    $requête = construire_requête(
      "INSERT INTO articles(libelle,prix) VALUES('%1',%2)",
      $libellé,
      $prix);
    echo $requête;
    ?>

    </div>
  </body>
</html>
