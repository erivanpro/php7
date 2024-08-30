<?php
// Inclure un fichier qui contient les différentes fonctions générales.
require('../../include/fonctions.inc.php');
// Le numéro du cas à tester est passé dans l'URL avec la variable 'test'.
// Récupérer la valeur de la variable (1 par défaut = MySQL).
$test = filter_input(INPUT_GET,'test',FILTER_VALIDATE_INT)?:1;
switch ($test) {
  case 1: // MySQL
  default:
    require('./mysql.inc.php');
    break;
  case 2: // Oracle
    require('./oracle.inc.php');
    break;
  case 3: // SQLite
    require('./sqlite.inc.php');
    break;
}
// Initialiser la variable de message.
$message = '';
// Se connecter.
$ok = connexion($connexion,$erreur);
if (! $ok) {
  $message = "Erreur de connexion à la base de données ($erreur).";
}
// Sélectionner les articles.
if ($ok) {
  $ok = sélectionner_articles($connexion,$résultat,$erreur);
  if (! $ok) {
    $message = "Erreur lors de la sélection des articles ($erreur).";
  }
}
// Afficher la page ...
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Liste de sélection</title>
  </head>
  <body>
    <?php if ($ok): ?>
    <!-- si tout s'est bien passé, construire le formulaire -->
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <div>
    Fruits préférés :<br />
    <select name="fruits[]" multiple size="8">
    <?php
    // Code PHP générant la partie dynamique du formulaire.
    // Parcourir la liste à afficher.
    $nombre_articles = 0;
    while ($ok = lire_article_suivant($connexion,$résultat,$article,$erreur)) {
      $nombre_articles++;
      // Mettre en forme les données.
      $identifiant = $article[IDENTIFIANT];
      $libellé = vers_formulaire($article[LIBELLE]);
      // Générer la balise 'option' avec l'identifiant
      // pour l'attribut 'value' et le libellé pour le texte 
      // affiché dans la liste.
      printf("<option value=\"%s\">%s\n",$identifiant,$libellé);
    }
    // En cas d'erreur ou si le résultat est vide, préparer un message.
    if ($ok === FALSE) { // erreur lors de la lecture
      $message = "Erreur lors de la lecture des articles ($erreur).";
    } elseif ($nombre_articles == 0) { // aucun article
      $message = 'Aucun article dans la base.';
    }
    ?>
    </select>
    <input type="submit" name="ok" value="OK" /><br />
    </div>
    </form>
    <?php endif; ?>
    <!-- afficher un éventuel message -->
    <div><?= vers_page($message) ?></div>
  </body>
</html>
