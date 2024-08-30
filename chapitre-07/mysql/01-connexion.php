<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Connexion et déconnexion</title>
  </head>
  <body>
    <div>

    <?php
    // Définition d'une petite fonction qui ouvre une connexion.
    function connecter($hôte=NULL,$utilisateur=NULL,$mot_de_passe=NULL) {
      if (func_num_args() == 0) {
        $connexion = @mysqli_connect();
      } else {
        $connexion = @mysqli_connect($hôte,$utilisateur,$mot_de_passe);
      }
      if ($connexion) {
        echo 'Connexion réussie.<br />';
        echo 'Informations sur le serveur : ',
             mysqli_get_host_info($connexion),'<br />';
        echo 'Version du serveur : ',
             mysqli_get_server_info($connexion),'<br />';
      } else {
        printf(
          'Erreur %d : %s.<br />',
          mysqli_connect_errno(),mysqli_connect_error());
      }
      return $connexion;
    }
    // Définition d'une petite fonction qui ferme une connexion.
    function déconnecter($connexion) {
      if ($connexion) {
        $ok = @mysqli_close($connexion);
        if ($ok) {
          echo 'Déconnexion réussie.<br />';
        } else {
          echo 'Echec de la déconnexion. <br />';
        }
      } else {
          echo 'Connexion non ouverte.<br />';
      }
    }
    // Premier test de connexion/déconnexion.
    echo '<b>Premier test</b><br />';
    $connexion = connecter();
    déconnecter($connexion);
    // Deuxième test de connexion/déconnexion.
    echo '<b>Deuxième test</b><br />';
    $connexion = connecter('localhost','inconnu','inconnu');
    déconnecter($connexion);
    ?>

    </div>
  </body>
</html>
