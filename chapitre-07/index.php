<?php
// Est-ce que la page est appelée avec le paramètre "source" 
// dans l'URL ?
$afficher_source = isset($_GET['source']);
if ($afficher_source) {
  // Oui.
  // Il faut afficher le code source d'une page.
  $titre_page = "Source de {$_GET['source']}";  
  // Supprimer les éventuels paramètres de l'URL.
  $source = preg_replace('/\?.*/','',$_GET['source']);
} else {
  // Non.
  // Il faut afficher une liste de liens.
  $titre_page = 'Chapitre 7';
  // Liste des liens.
  $liens['<1>'] = 'MySQL';
  $liens['mysql/01-connexion.php'] = 'Connexion et déconnexion';
  $liens['mysql/02-nombre-lignes.php'] = 'Requête non préparée : nombre de lignes dans le résultat d\'une requête de lecture (mysqli_num_rows)';
  $liens['mysql/03-fetch.php'] = 'Requête non préparée : tester les différentes techniques de fetch (mysqli_fetch_*)';
  $liens['mysql/04-fetch-all.php'] = 'Requête non préparée : mysqli_fetch_all';
  $liens['mysql/05-lire-une-ligne.php'] = 'Requête non préparée : lire une ligne';
  $liens['mysql/06-lire-plusieurs-lignes.php'] = 'Requête non préparée : lire plusieurs lignes';
  $liens['mysql/07-mise-a-jour.php'] = 'Requête non préparée : mise à jour';
  $liens['mysql/08-gestion-erreurs.php'] = 'Requête non préparée : gestion des erreurs';
  $liens['mysql/09-stmt-lecture.php'] = 'Requête préparée : lecture';
  $liens['mysql/10-stmt-lecture-stocke.php'] = 'Requête préparée : lecture avec résultat stocké';
  $liens['mysql/11-stmt-mise-a-jour.php'] = 'Requête préparée : mise à jour';
  $liens['mysql/12-stmt-gestion-erreurs.php'] = 'Requête préparée : gestion des erreurs';
  $liens['mysql/13-transaction.php'] = 'Transaction';
  $liens['mysql/14-procedure-stockee-out.php'] = 'Procédure stockée avec paramètre OUT';
  $liens['mysql/15-procedure-stockee-resultat.php'] = 'Procédure stockée qui retourne un résultat directement';
  $liens['mysql/16-fonction-stockee.php'] = 'Fonction stockée';
  $liens['<2>'] = 'Oracle';
  $liens['oracle/01-connexion.php'] = 'Connexion et déconnexion';
  $liens['oracle/02-fetch.php'] = 'Tester les différentes techniques de fetch (oci_fetch_*)';
  $liens['oracle/03-fetch-all.php'] = 'Tester les différentes techniques de fetch (oci_fetch_all)';
  $liens['oracle/04-lire-une-ligne.php'] = 'Lire une ligne';
  $liens['oracle/05-lire-plusieurs-lignes.php'] = 'Lire plusieurs lignes';
  $liens['oracle/06-bind.php'] = 'Requêtes paramétrées';
  $liens['oracle/07-mise-a-jour.php'] = 'Mise à jour';
  $liens['oracle/08-transaction.php'] = 'Transaction';
  $liens['oracle/09-procedure-stockee.php'] = 'Appeler une procédure stockée';
  $liens['oracle/10-curseur-implicite.php'] = 'Lire un curseur implicite (nouveauté d\'Oracle 12c)';
  $liens['oracle/11-environnement-nls.php'] = 'Environnement NLS';
  $liens['oracle/12-gestion-erreurs.php'] = 'Gestion des erreurs';
  $liens['<3>'] = 'SQLite';
  $liens['sqlite/01-fetch.php'] = 'Tester les différentes techniques de fetch';
  $liens['sqlite/02-lire-une-ligne.php'] = 'Lire une ligne';
  $liens['sqlite/03-lire-plusieurs-lignes.php'] = 'Lire plusieurs lignes';
  $liens['sqlite/04-mise-a-jour.php'] = 'Mise à jour';
  $liens['sqlite/05-transaction.php'] = 'Transaction';
  $liens['sqlite/06-gestion-erreurs.php'] = 'Gestion des erreurs';
  $liens['<4>'] = 'PHP Data Objects (PDO)';
  $liens['pdo/01-pdo.php?test=1'] = 'PHP Data Objects (PDO) : MySQL';
  $liens['pdo/01-pdo.php?test=2'] = 'PHP Data Objects (PDO) : Oracle';
  $liens['pdo/01-pdo.php?test=3'] = 'PHP Data Objects (PDO) : SQLite';
  $liens['<5>'] = 'Gestion des apostrophes dans le texte des requêtes';
  $liens['apostrophes/01-apostrophe-probleme.php'] = 'Problème';
  $liens['apostrophes/02-apostrophe-solution.php'] = 'Solution';
  $liens['apostrophes/03-construire-requete.php'] = 'Construire une requête';
  $liens['<6>'] = 'Exemples d\'intégration dans des formulaires';
  $liens['formulaires/01-liste-select.php?test=1'] = 'Liste de sélection (MySQL)';
  $liens['formulaires/01-liste-select.php?test=2'] = 'Liste de sélection (Oracle)';
  $liens['formulaires/01-liste-select.php?test=3'] = 'Liste de sélection (SQLite)';
  $liens['formulaires/02-liste-articles.php?test=1'] = 'Affichage d\'une liste (MySQL)';
  $liens['formulaires/02-liste-articles.php?test=2'] = 'Affichage d\'une liste (Oracle)';
  $liens['formulaires/02-liste-articles.php?test=3'] = 'Affichage d\'une liste (SQLite)';
  $liens['formulaires/03-gestion-articles.php?test=1'] = 'Formulaire de saisie en liste (MySQL)';
  $liens['formulaires/03-gestion-articles.php?test=2'] = 'Formulaire de saisie en liste (Oracle)';
  $liens['formulaires/03-gestion-articles.php?test=3'] = 'Formulaire de saisie en liste (SQLite)';
  $liens['formulaires/04-saisie-article.php?test=1'] = 'Formulaire de saisie (MySQL)';
  $liens['formulaires/04-saisie-article.php?test=2'] = 'Formulaire de saisie (Oracle)';
  $liens['formulaires/04-saisie-article.php?test=3'] = 'Formulaire de saisie (SQLite)';
}
// Inclure le fichier qui va afficher la page.
include('../include/index-chapitre.inc.php');
?>
