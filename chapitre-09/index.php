<?php
// Est-ce que la page est appelée avec le paramètre "source" 
// dans l'URL ?
$afficher_source = isset($_GET['source']);
if ($afficher_source) {
  // Oui.
  // Il faut afficher le code source d'une page.
  $titre_page = "Source de {$_GET['source']}";  
  $source = $_GET['source'];
} else {
  // Non.
  // Il faut afficher une liste de liens.
  $titre_page = 'Chapitre 10';
  // Liste des liens.
  $liens['01-mail-simple.php'] = 'Envoyer un courrier électronique simple';
  $liens['02-mail-plus-complexe.php'] = 'Envoyer un courrier électronique plus complexe';
  $liens['03-mail-html.php'] = 'Envoyer un courrier électronique au format HTML';
  $liens['04-mail-avec-pj.php'] = 'Envoyer un courrier électronique avec pièce jointe';
}
// Inclure le fichier qui va afficher la page.
include('../include/index-chapitre.inc.php');
?>
