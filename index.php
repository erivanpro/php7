<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Exemples PHP</title>
  </head>
  <body>
    <div>
    <?php
    // Liste des liens.
    $liens['./chapitre-02/'] = 'Chapitre 2 - Introduction à PHP';
    $liens['./chapitre-03/'] = 'Chapitre 3 - Utiliser les fonctions PHP';
    $liens['./chapitre-04/'] = 'Chapitre 4 - Écrire des fonctions et des classes PHP';
    $liens['./chapitre-05/'] = 'Chapitre 5 - Gérer les erreurs dans un script PHP';
    $liens['./chapitre-06/'] = 'Chapitre 6 - Gérer des formulaires et les liens';
    $liens['./chapitre-07/'] = 'Chapitre 7 - Accéder aux bases de données';
    $liens['./chapitre-08/'] = 'Chapitre 8 - Gérer les sessions';
    $liens['./chapitre-09/'] = 'Chapitre 9 - Envoyer un courrier électronique';
    $liens['./chapitre-10/'] = 'Chapitre 10 - Annexes';
    $liens['./exercices/'] = 'Exercices';
    // Code JavaScript pour l'affichage du lien dans une autre fenêtre.
    $onclick="window.open(this.href,'_blank'); return false;";
    // Affichage d'une liste de liens.
    foreach ($liens as $lien => $titre) {
      printf // lien vers la page
        (
        "<a href=\"%s\" onclick=\"%s\">%s</a><br />",
        $lien,
        $onclick,
        $titre
        );
    }
    ?>
    </div>
  </body>
</html>