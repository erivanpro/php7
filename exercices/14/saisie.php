<?php
// Pas d'affichage des messages d'erreur PHP. 
error_reporting(0);
// Initialiser les variables utilisées dans le formulaire.
$prenom = '';
$nom = '';
// Tester si le script est appelé en traitement du formulaire. 
if (isset($_POST['ok'])) { // oui
  // Utilisation d'un filtre pour s'assurer que la saisie est correcte. 
  $filtre = ['filter'  => FILTER_VALIDATE_REGEXP,
             'options' => ['regexp' => '/^[[:alpha:]- ]{1,40}$/u'],
             'flags'   => FILTER_NULL_ON_FAILURE  ];
  // Utilisation de ce filtre pour vérifier le prénom et le nom.
  $filtres = ['prenom' => $filtre,'nom' => $filtre];
  $saisie = filter_input_array(INPUT_POST,$filtres);
  // Tester le résultat du filtre.
  if (in_array(NULL, $saisie, true)) { // NULL présent = saisie incorrecte
    $ok = FALSE;
    $message = 'Votre saisie n\'est pas correcte.';
    // Récupérer les valeurs et les préparer pour l'affichage dans le formulaire.
    $prenom = filter_input(INPUT_POST,'prenom',FILTER_SANITIZE_SPECIAL_CHARS);
    $nom = filter_input(INPUT_POST,'nom',FILTER_SANITIZE_SPECIAL_CHARS);
  } else {
    $ok = TRUE;
    // Récupération de la saisie.
    $prenom = trim($saisie['prenom']);
    $nom = trim($saisie['nom']);
  }
  // Enregistrement dans la base de données si tout est OK.
  if ($ok) {
    // Ouverture de la base de données et gestion de l'exception éventuelle.
    try 
    {
      $connexion = new SQLite3('/app/sqlite/diane.dbf');
      $ok = TRUE;
    } catch (Exception $e) {
      $ok = FALSE;
    }
    // Exécution de la requête d'insertion. 
    if ($ok) {
      // Texte de la requête.
      $sql = 'INSERT INTO auteurs(prenom,nom) VALUES(?,?)'; 
      // Préparation de la requête.
      $ok = (bool) ($requête = $connexion->prepare($sql));    
      // Liaison des paramètres. 
      if ($ok) {
        $ok =    $requête->bindParam(1,$prenom)
              && $requête->bindParam(2,$nom);
      }
      // Exécution de la requête.   
      if ($ok) {  
        $ok = (bool) $requête->execute();  
      }
    }
    // Récupération d'un éventuel message d'erreur.
    if (! $ok) { // erreur
      if (! $connexion) { // erreur de connexion
        $erreur = $e->getMessage();
      } else { // erreur ailleurs
        $erreur = $connexion->lastErrorMsg();
      }
      $message = "Erreur lors de l'exécution de la requête ($erreur).";
    } else { // pas d'erreur
      // Message de succès et réinitialisation des variables.
      $message = "Auteur enregistré avec succès.";
      $prenom = '';
      $nom = '';
    }
  }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Saisie</title>
    <style>
    label { display: block; width: 60px; float: left; }
    </style>
  </head>
  <body>
    <!-- Formulaire de saisie de l'auteur. --> 
    <form action="saisie.php" method="post"> 
    <div> 
      <b>Prénom et nom du nouvel auteur :</b> 
      <br /><label>Prénom</label>  
      <input type="text" name="prenom" size="40" maxlength="40" 
             value="<?= $prenom ?>" autofocus="autofocus" /> 
      <br /><label>Nom</label>
      <input type="text" name="nom" size="40" maxlength="40" 
             value="<?= $nom ?>" /> 
      <br /> 
      <input type="submit" name="ok" value="Enregistrer" /> 
    </div> 
    </form> 
    <!-- Affichage d'un éventuel message. --> 
    <div><?= $message ?? '' ?></div>
    <!-- Lien pour afficher la liste. --> 
    <p><a href="accueil.php">Afficher la liste</a></p>
  </body>
</html>