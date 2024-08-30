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
  $titre_page = 'Chapitre 3';
  // Liste des liens.
  $liens['01-constantes-fonctions.php'] = 'Manipuler les constantes';
  $liens['02-variables-fonctions.php'] = 'Manipuler les variables';
  $liens['03-types-fonctions.php'] = 'Manipuler les types de données';
  $liens['04-tableaux-fonctions.php'] = 'Manipuler les tableaux';
  $liens['05-nombres-fonctions.php'] = 'Manipuler les nombres';
  $liens['06-chaines-fonctions.php'] = 'Manipuler les chaînes de caractères';
  $liens['07-expressions-rationnelles.php'] = 'Utiliser les expressions rationnelles';
  $liens['08-dates-fonctions.php'] = 'Manipuler les dates';
  $liens['09-identifiant-unique.php'] = 'Générer un identifiant unique';
  $liens['10-manipuler-fichiers.php'] = 'Manipuler les fichiers sur le serveur';
}
// Inclure le fichier qui va afficher la page.
include('../include/index-chapitre.inc.php');
?>
