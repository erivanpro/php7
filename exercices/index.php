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
  $titre_page = 'Exercices';
  // Liste des liens.
  $liens['<01>'] = 'Exercice 01 : mon premier script PHP';
  $liens['01/accueil.php'] = 'accueil.php';
  $liens['<02>'] = 'Exercice 02 : variables et structures de contrôle';
  $liens['02/accueil-1.php'] = 'accueil-1.php';
  $liens['02/accueil-2.php'] = 'accueil-2.php';
  $liens['02/accueil-3.php'] = 'accueil-3.php';
  $liens['02/accueil-4.php'] = 'accueil-4.php';
  $liens['02/accueil.php'] = 'accueil.php';
  $liens['02/commun.inc.php'] = 'commun.inc.php';
  $liens['<03>'] = 'Exercice 03 : manipuler les données';
  $liens['03/accueil-1.php'] = 'accueil-1.php';
  $liens['03/accueil-2.php'] = 'accueil-2.php';
  $liens['03/accueil-3.php'] = 'accueil-3.php';
  $liens['03/accueil-4.php'] = 'accueil-4.php';
  $liens['03/accueil.php'] = 'accueil.php';
  $liens['03/commun.inc.php'] = 'commun.inc.php';
  $liens['<04>'] = 'Exercice 04 : écrire et lire un fichier sur le serveur';
  $liens['04/accueil.php'] = 'accueil.php';
  $liens['04/commun.inc.php'] = 'commun.inc.php';
  $liens['04/enregistrer_auteurs.php'] = 'enregistrer_auteurs.php';
  $liens['<05>'] = 'Exercice 05 : écrire une fonction';
  $liens['05/accueil.php'] = 'accueil.php';
  $liens['05/commun.inc.php'] = 'commun.inc.php';
  $liens['<06>'] = 'Exercice 06 : écrire une classe';
  $liens['06/accueil.php'] = 'accueil.php';
  $liens['06/classe.Auteur.php'] = 'classe.Auteur.php';
  $liens['<07>'] = 'Exercice 07 : gérer les erreurs';
  $liens['07/accueil-1.php'] = 'accueil-1.php';
  $liens['07/accueil.php'] = 'accueil.php';
  $liens['<08>'] = 'Exercice 08 : récupérer des données passées par l’URL';
  $liens['08/accueil.php'] = 'accueil.php';
  $liens['08/auteur.php'] = 'auteur.php';
  $liens['08/commun.inc.php'] = 'commun.inc.php';
  $liens['<09>'] = 'Exercice 09 : récupérer des données saisies dans un formulaire';
  $liens['09/saisie.php'] = 'saisie.php';
  $liens['<10>'] = 'Exercice 10 : contrôler des données passées par l’URL';
  $liens['10/accueil.php'] = 'accueil.php';
  $liens['10/auteur.php'] = 'auteur.php';
  $liens['10/commun.inc.php'] = 'commun.inc.php';
  $liens['<11>'] = 'Exercice 11 : contrôler des données saisie dans un formulaire';
  $liens['11/saisie.php'] = 'saisie.php';
  $liens['<12>'] = 'Exercice 12 : utiliser MySQL';
  $liens['12/accueil.php'] = 'accueil.php';
  $liens['12/saisie.php'] = 'saisie.php';
  $liens['<13>'] = 'Exercice 13 : utiliser Oracle';
  $liens['13/accueil.php'] = 'accueil.php';
  $liens['13/saisie.php'] = 'saisie.php';
  $liens['<14>'] = 'Exercice 14 : utiliser SQLite';
  $liens['14/accueil.php'] = 'accueil.php';
  $liens['14/saisie.php'] = 'saisie.php';
  $liens['<15>'] = 'Exercice 15 : gérer les sessions';
  $liens['15/accueil.php'] = 'accueil.php';
  $liens['15/auteur.php'] = 'auteur.php';
  $liens['15/commun.inc.php'] = 'commun.inc.php';
  $liens['<16>'] = 'Exercice 16 : envoyer un courrier électronique';
  $liens['16/mail.php'] = 'mail.php';
}
// Inclure le fichier qui va afficher la page.
include('../include/index-chapitre.inc.php');
?>
