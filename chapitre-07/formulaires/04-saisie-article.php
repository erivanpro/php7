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
// Variables qui indiquent si un article doit être chargé et/ou
// si un article doit être enregistré.
$charger_article = FALSE;
$enregistrer_article = FALSE;
// Initialiser la variable de message (sous la forme d'un tableau 
// pour pouvoir stocker plusieurs messages).
$messages = [];
// Tester si le script est appelé en traitement d'un formulaire.
if (isset($_POST['charger']) OR isset($_POST['ok'])) { // oui
  // Récupérer l'identifiant de l'article.
  // Utilisation d'un filtre pour s'assurer que la valeur
  // récupérée est bien un entier.
  $identifiant = filter_input(INPUT_POST,'identifiant',FILTER_VALIDATE_INT);
  // Identifiant absent ou invalide => message.
  // Sinon, déterminer l'action à effectuer.
  if ($identifiant === FALSE OR $identifiant === NULL) {
    $messages[] = 'Identifiant absent ou invalide.';
  } else {
    $enregistrer_article = isset($_POST['ok']);
    $charger_article = // enregistrer => recharger
      (isset($_POST['charger']) OR $enregistrer_article);
  }
}
// Se connecter si nécessaire.
if ($charger_article OR $enregistrer_article) {
  $ok = connexion($connexion,$erreur);
  // En cas d'erreur, on arrête tout.
  if (! $ok) {
    $messages[] = "Erreur de connexion à la base de données ($erreur).";
    $charger_article = FALSE;
    $enregistrer_article = FALSE;
  }
}
// S'il y a un article à enregistrer ...
if ($enregistrer_article) {
  // Récupérer le contenu du formulaire.
  $article = $_POST;
  // Supprimer la ligne correspondant au bouton Enregistrer.
  unset($article['ok']);
  // Nettoyer la saisie.
  $article['libelle'] = trim($article['libelle']);
  // Pour le prix, remplacer la virgule par un point
  // et supprimer les espaces.
  $article['prix'] = str_replace([',',' '],['.',''],$article['prix']);
  // A ce stade, il faudrait vérifier un peu mieux la saisie ...
  // Enregister l'article.
  $ok = enregistrer_article($connexion,$article,$erreur);
  // Définir le message.
  if ($ok) {
    $messages[] = 'Article enregistré avec succès.';
  } else {
    $messages[] = "Erreur lors de l'enregistrement de l'article ($erreur).";
  }
}
// S'il y a un article à charger ...
if ($charger_article) {
  // Charger les informations dans le tableau associatif $article.
  $ok = sélectionner_un_article($connexion,$identifiant,$article,$erreur);
  // Définir l'éventuel message d'erreur.
  if ($ok) { // pas d'erreur
    if ($article) { // il y a bien un article
      // Mettre en forme les données.
      $libellé = vers_formulaire($article[LIBELLE]);
      $prix = vers_formulaire(@number_format($article[PRIX],2,',' ,' '));
    } else { // pas d'article => message
      $messages[] = 'Aucun article trouvé.';
      unset($article);
    }
  } else  { // erreur
    $messages[] = "Erreur lors du chargement de l'article ($erreur).";
    unset($article);
  }
}
// Affichage de la page ...
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Modifier un article</title>
  </head>
  <body>
    <!-- Formulaire de saisie de l'identifiant. -->
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <div>
    Identifiant : 
    <input type="text" name="identifiant" size="6" 
       value="<?= $identifiant??'' ?>" />
    <input type="submit" name="charger" value="Charger" />
    </div>
    </form>
    <?php if (isset($article)): ?>
    <!-- Formulaire de saisie de l'article (affiché uniquement si
         un article a été chargé avec succès) -->
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <div>
      <br />Libellé : 
      <input type="text" name="libelle" size="40" maxlength="40"
       value="<?= $libellé ?>" />
      <br />Prix :
      <input type="text" name="prix" size="10" maxlength="10"
       value= "<?= $prix ?>" />
      <input type="hidden" name="identifiant" 
       value="<?= $identifiant ?>" />
      <br />
      <input type="submit" name="ok" value="Enregistrer" />
    </div>
    </form>
    <?php endif; ?>
    <!-- afficher les éventuels messages -->
    <div><?= vers_page(implode("\n",$messages)) ?></div>
  </body>
</html>