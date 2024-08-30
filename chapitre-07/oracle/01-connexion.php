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
    function connecter($utilisateur,$mot_de_passe,$hôte) {
      $connexion = @oci_connect($utilisateur,$mot_de_passe,$hôte);
      if ($connexion) {
        echo 'Connexion réussie.<br />';
        echo 'Version du serveur : <br />';
        echo oci_server_version($connexion),'<br />';
      } else {
        $e = oci_error(); // noter l’appel sans paramètre 
        printf(
          'Erreur %d : %s.<br />',
          $e['code'],$e['message']);
      }
      return $connexion;
    }
    // Définition d'une petite fonction qui ferme une connexion.
    function déconnecter($connexion) {
      if ($connexion) {
        $ok = @oci_close($connexion);
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
    $connexion = connecter('demeter','demeter','diane');
    déconnecter($connexion);
    // Deuxième test de connexion/déconnexion.
    echo '<b>Deuxième test</b><br />';
    $connexion = connecter('inconnu','inconnu','diane');
    déconnecter($connexion);
    ?>

    </div>
  </body>
</html>
