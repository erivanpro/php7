<?php
// Pas d'affichage des messages d'erreur PHP. 
error_reporting(0);
// Ouverture de la base de données et gestion de l'exception éventuelle.
try 
{
  $connexion = new SQLite3('/app/sqlite/diane.dbf');
  $ok = TRUE;
} catch (Exception $e) {
  $ok = FALSE;
}
// Exécution de la requête de sélection.
if ($ok) { 
  // Texte de la requête.
  $sql = 'SELECT prenom,nom FROM auteurs ORDER BY nom'; 
  // Préparation de la requête.
  $ok = (bool) ($requête = $connexion->prepare($sql));    
  // Exécution de la requête.  
  if ($ok) {  
    $ok = (bool) ($résultat = $requête->execute());   
  }
}
// Récupération d'un éventuel message d'erreur.
if (! $ok) {
  if (! $connexion) { // erreur de connexion
    $erreur = $e->getMessage();
  } else { // erreur ailleurs
    $erreur = $connexion->lastErrorMsg();
  }
  $message = "Erreur lors de l'exécution de la requête ($erreur).";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Accueil</title>
    <style>
    table { border-collapse: collapse; }
    table, td, th { border: 1px solid black; }
    td, th { padding: 4px; }
    </style>
  </head>
  <body>
    <div>
    <!-- Afficher le tableau des auteurs. -->
    <table id="auteurs">
    <tr><th>Auteurs</th></tr>
    <?php
    if ($ok) {
      $nombre_auteurs = 0;
      while ($auteur = $résultat->fetchArray()) {
        $nombre_auteurs++;
        echo "<tr><td>{$auteur['nom']} ({$auteur['prenom']})</td></tr>";
      }
      // En cas d'erreur ou si le résultat est vide, préparer un message. 
      if (! in_array($connexion->lastErrorCode(),[0,100,101])) { // erreur lors de la lecture 
        $message = "Erreur lors de la lecture des auteurs (résultat partiel)."; 
      } elseif ($nombre_auteurs == 0) { // aucun auteur 
        $message = 'Aucun auteur dans la base.'; 
      } 
    }
    ?>
    </table>
    </div>
    <!-- Affichage d'un éventuel message. --> 
    <div><?= $message ?? '' ?></div>
    <!-- Lien pour saisir un nouvel auteur. --> 
    <p><a href="saisie.php">Saisir un nouvel auteur</a></p>
    <script>
    // Masquer le tableau des auteurs s'il est vide.
    if (document.getElementById("auteurs").rows.length <= 1) 
      { document.getElementById("auteurs").style.display = "none"; }
    </script>
  </body>
</html>