<?php
// Inclusion du fichier qui contient les 
// fonctions générales
include('../include/fonctions.inc.php');
// Ouvrir/réactiver la session.
session_start();
// Tester si la session est nouvelle (i.e. ouverte par
// l’appel session_start() ci-dessus) ou ancienne (i.e. ouverte
// par un appel antérieur à session_start()).
// Le mieux est de tester si une de nos variables de session
// est déjà enregistrée).
if (! isset($_SESSION['date']) ) {
  // Variable "date" pas encore enregistrée 
  // => nouvelle session.
  // => ouvrir la session au niveau applicatif
  // Pour cet exemple :
  //   - déterminer la date/heure d'ouverture de la session
  $date = date('\l\e d/m/Y à H:i:s');
  //   - enregistrer la date/heure d'ouverture de la session
  $_SESSION['date'] = $date;
  //   - récupérer l’identifiant de la session (pour info)
  $session = session_id();
  //   - préparer un message
  $message = "Nouvelle session : $session - $date";
} else {
  // Variable "date" déjà enregistrée.
  // => ancienne session.
  // => récupérer les variables de session utilisées 
  //    dans ce script.
  // Pour cet exemple :
  //   - date/heure d’ouverture de la session
  $date = $_SESSION['date'];
  //   - récupérer l’identifiant de la session (pour info)
  $session = session_id();
  //   - préparer un message
  $message = "Session déjà ouverte: $session - $date";
}
// Détermination de la date et de l'heure actuelle (pas celle
// de l'ouverture de la session.
$actuel = 'Nous sommes le '.date('d/m/Y').
          ' ; il est '.date('H:i:s');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Page 1</title>
  </head>
  <body>
    <div>
    <b>Page 1 - <?php echo $actuel; ?></b><br />
    <?php echo $message; ?><br />
    <!-- lien vers les autres pages 
         Utiliser notre fonction générique url() pour être 
         certain que l’identifiant de session est transmis 
         quelles que soient les conditions  -->
    <a href="<?php echo url('10-session-principes-page-2.php'); ?>">Page 2</a>
    </div>
  </body>
</html>
