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
    <title>Liste des articles</title>
    <style>
    table { border-collapse: collapse; }
    table, td, th { border: 1px solid black; }
    td, th { padding: 4px; }
    </style>
  </head>
  <body>
    <?php if ($ok): ?>
    <!-- si tout s'est bien passé, constuire une table HTML  
    ++++ à l'intérieur d'un formulaire  -->
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <table>
    <!-- ligne de titre -->
    <tr>
    <th>Libellé</th><th>Prix</th><th>Case</th><th>Lien</th>
    </tr>
    <?php
    // Code PHP générant les lignes du tableau.
    // Parcourir la liste des articles à afficher.
    $nombre_articles = 0;
    while ($ok = lire_article_suivant($connexion,$résultat,$article,$erreur)) {
      $nombre_articles++;
      // Mettre en forme les données.
      $identifiant = $article[IDENTIFIANT];
      $libellé = vers_page($article[LIBELLE]);
      $prix = vers_page(number_format($article[PRIX],2,',' ,' '));
      // Générer la ligne de la table HTML :
      // - une case à cocher dans une colonne
      // - un lien dans une autre colonne
      printf(
      "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",
      $libellé,
      $prix,
      "<input type=\"checkbox\" name=\"choix[]\" value=\"$identifiant\"/>",
      "<a href=\"javascript:alert($identifiant)\">action</a>");
    } // while
    // En cas d'erreur ou si le résultat est vide, préparer un message.
    if ($ok === FALSE) { // erreur lors de la lecture
      $message = "Erreur lors de la lecture des articles ($erreur).";
    } elseif ($nombre_articles == 0) { // aucun article
      $message = 'Aucun article dans la base.';
    }
    ?>
    </table>
    <p><input type="submit" name="action" value="Action" /></p>
    </form>
    <?php
    // Traiter le formulaire.
    // Simple affichage des identifiants cochés.
    if (isset($_POST['action'])) {
      if (isset($_POST['choix'])) {
        echo 'Identifiant(s) coché(s) : ',
              implode('+',$_POST['choix']);
      }
    }
    ?>
    <?php endif; ?>
    <!-- afficher un éventuel message -->
    <div><?= vers_page($message) ?></div>
  </body>
</html>
