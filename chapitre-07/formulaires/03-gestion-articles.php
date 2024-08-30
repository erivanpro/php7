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
// Initialiser la variable de message (sous la forme d'un tableau 
// pour pouvoir stocker plusieurs messages).
$messages = [];
// Se connecter.
$ok = connexion($connexion,$erreur);
if (! $ok) {
  $messages[] = "Erreur de connexion à la base de données ($erreur).";
}
// Traitement du formulaire.
if ($ok and isset($_POST['ok'])) {
  // Récupérer le tableau contenant la saisie.
  $lignes = $_POST['saisie'];
  // Nettoyer la saisie.
  // Pour le prix, remplacer la virgule par un point
  // et supprimer les espaces.
  // A ce stade, il faudrait vérifier un peu mieux la saisie ...
  // Astuce : la valeur du tableau est récupérée par référence
  //          (&$ligne) pour pouvoir être modifiée directement.
  foreach($lignes as &$ligne) {
    $ligne['libelle'] = trim($ligne['libelle']);
    $ligne['prix'] = str_replace([',',' '],['.',''],$ligne['prix']);
  }
  // Effectuer la mise à jour.
  $ok_maj = enregistrer_articles($connexion,$lignes,$erreur);
  // Définir le message.
  if (is_null($ok_maj)) {
    $messages[] = 'Aucune mise à jour effectuée.';
  } elseif ($ok_maj) {
    $messages[] = 'Mise à jour terminée avec succès.';
  } else {
    $messages[] = "Erreur lors de la mise à jour ($erreur).";
  }
}
// Recharger les articles.
if ($ok) {
  $ok = sélectionner_articles($connexion,$résultat,$erreur);
  if (! $ok) {
    $messages[] = "Erreur lors du chargement des articles ($erreur).";
  }
}
// Affichage de la page ...
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Gestion des articles</title>
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
    <form name="formulaire" action="<?= $_SERVER['REQUEST_URI'] ?>" 
          method="post">
    <table>
    <!-- ligne de titre -->
    <tr>
    <th>Identifiant</th><th>Libellé</th><th>Prix</th>
                <th>Supprimer</th>
    </tr>
    <?php
    // Code PHP générant les lignes du tableau.
    // Initialiser le compteur de ligne.
    $i = 0;
    // Parcourir la liste des articles à afficher.
    while ($ok = lire_article_suivant($connexion,$résultat,$article,$erreur)) {
      // Incrémentation du compteur de ligne.
      $i++;
      // Calcul du numéro d'ordre dans le formulaire de la
      // zone cachée correspondant à l'identifiant.
      $n = 4 * ($i - 1);
      // Mettre en forme les données.
      $identifiant = $article[IDENTIFIANT];
      $libellé = vers_formulaire($article[LIBELLE]);
      $prix = vers_formulaire(@number_format($article[PRIX],2,',' ,' '));
      // Générer la ligne de la table HTML en insérant les
      // balises INPUT du formulaire.
      printf(
      "<tr><td>%s%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
      $identifiant,
      "<input type=\"hidden\" name=\"saisie[$identifiant][modifier]\"/>",
      "<input type=\"text\" name=\"saisie[$identifiant][libelle]\"
        value=\"$libellé\" onchange=\"document.formulaire[$n].value=1\" />",
      "<input type=\"text\" name=\"saisie[$identifiant][prix]\"
        value=\"$prix\" onchange=\"document.formulaire[$n].value=1\" />",
      "<input type=\"checkbox\" name=\"saisie[$identifiant][supprimer]\"
        value=\"$identifiant\" />");
    } // while
    // En cas d'erreur ou si le résultat est vide, préparer un message.
    if ($ok === FALSE) { // erreur lors de la lecture
      $messages[] = "Erreur lors de la lecture des articles ($erreur).";
    } elseif ($i == 0) { // aucun article
      $messages[] = 'Aucun article dans la base.';
    }
    // Ajout de 5 lignes vides pour la création
    // (sans identifiant, sans case de suppression).
    for($i=1;$i<=5;$i++) {
      printf(
      "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
      "",
      "<input type=\"text\" name=\"saisie[-$i][libelle]\" value=\"\" />",
      "<input type=\"text\" name=\"saisie[-$i][prix]\" value=\"\" />",
      "");
    } // for

    ?>    
    </table>
    <p><input type="submit" name="ok" value="Enregistrer" /></p>
    </form>
    <?php endif; ?>
    <!-- afficher les éventuels messages -->
    <div><?= vers_page(implode("\n",$messages)) ?></div>
  </body>
</html>
