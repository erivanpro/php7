<?php
// Inclusion du fichier contenant les fonctions générales.
include('../include/fonctions.inc.php');
// Fonction qui vérifie que l'identification saisie 
// est correcte.
function utilisateur_existe($identifiant,$mot_de_passe) {
  // Connexion et sélection de la base de données
  $connexion = mysqli_connect('localhost','root');
  mysqli_select_db($connexion,'diane');
  // Définition et exécution d'une requête préparée
  $sql  = 'SELECT 1 FROM utilisateurs ';
  $sql .= 'WHERE identifiant = ? AND mot_de_passe = ?';
  $requête = mysqli_stmt_init($connexion);
  $ok = mysqli_stmt_prepare($requête,$sql);
  $ok = mysqli_stmt_bind_param
          ($requête,'ss',$identifiant,$mot_de_passe);
  $ok = mysqli_stmt_execute($requête);
  mysqli_stmt_bind_result($requête,$existe);
  $ok = mysqli_stmt_fetch($requête);
  mysqli_stmt_free_result($requête);
  // L'identification est bonne si la requête a retourné 
  // une ligne (l'utilisateur existe et le mot de passe 
  // est bon).
  // Si c'est le cas $existe contient 1, sinon elle est 
  // vide. Il suffit de la retourner en tant que booléen.
  return (bool) $existe;
}
// Initialisation des variables.
$identifiant = '';
$mot_de_passe = '';
$message = '';
// Traitement du formulaire.
if (isset($_POST['connexion'])) {
   // Récupérer les information saisies.
   $identifiant = $_POST['identifiant'];
   $mot_de_passe = $_POST['mot_de_passe'];
   // Vérifier que l'utilisateur existe.
   if (utilisateur_existe($identifiant,$mot_de_passe)) {
      // L'utilisateur existe ...
      // Ouvrir une session et enregistrer les données
      // de session.
      session_start();
      $_SESSION['date'] = date('\l\e d/m/Y à H:i:s');
      $_SESSION['identifiant'] = $identifiant;
      // Puis rediriger l'utilisateur vers la page d'accueil 
      // en appelant la fonction générique url() pour être
      // certain que l'identifiant de session est transmis
      // quelles que soient les conditions.
      header('location: '.url('11-session-authentification-accueil.php'));
      exit;
   } else {
      // L'utilisateur n'existe pas ...
      // Afficher un message et proposer de 
      // nouveau l'identification.
      $message  = 'Identification incorrecte. ';
      $message .= 'Essayez de nouveau.';
      // Laisser le formulaire s'afficher de nouveau ...
   }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>MonSite.com - Identification</title>
  </head>
  <body>
    <form action="11-session-authentification-login.php" method="post">
    <table>
    <tr>
      <td style="text-align:right">Identifiant :</td>
      <td><input type="text" name="identifiant" value=
         "<?php echo vers_formulaire($identifiant); ?>" /></td>
    </tr>
    <tr>
      <td style="text-align:right">Mot de passe :</td>
      <td><input type="password" name="mot_de_passe" value=
         "<?php echo vers_formulaire($mot_de_passe); ?>" /></td>
    </tr>
    <tr>
      <td></td>
      <td style="text-align:right"><input type="submit" name="connexion" 
                         value="Connexion" /></td>
    </tr>
    </table>
    <p><?php echo $message; ?></p>
    </form>
  </body>
</html>
