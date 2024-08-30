<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête préparée : mise à jour</title>
  </head>
  <body>
    <div>

    <?php
    // Définition d’une petite fonction d’affichage de la liste 
    // des articles. 
    // Cette fonction utilise une requête préparée qui ne sera 
    // préparée qu'une fois, lors du premier appel.
    // La variable qui stocke le résultat de la préparation ainsi que
    // le tableau utilisé pour la liaison sont des variables statiques
    // dont les valeurs sont préservées d'un appel à un autre.
    function afficher_articles($connexion) { 
      static $requête;
      static $ligne = array();
      if (! isset($requête)) { // $requête non définie = premier appel
        $sql = 'SELECT * FROM articles'; 
        $requête = mysqli_prepare($connexion,$sql);
        $ok = mysqli_stmt_bind_result($requête,$ligne[],$ligne[],$ligne[]); 
      }
      $ok = mysqli_stmt_execute($requête); 
      echo '<b>Liste des articles :</b><br />'; 
      while (mysqli_stmt_fetch($requête)) { 
        echo $ligne[0],' - ',$ligne[1],' - ',$ligne[2],'<br />'; 
      } 
    } 
    // Connexion (utilisation des valeurs par défaut). 
    $connexion = mysqli_connect(); 
    if (! $connexion) { 
      exit('Echec de la connexion.'); 
    } 
    // Sélection de la base de données. 
    $ok = mysqli_select_db($connexion,'diane'); 
    if (! $ok) { 
      exit('Echec de la sélection de la base de données.'); 
    } 
    // Affichage de contrôle. 
    afficher_articles($connexion); 
    // Mises à jour.
    echo '<b>Mises à jour :</b><br />'; 
    // Requête INSERT.
    // Préparation de la requête.
    $sql = 'INSERT INTO articles(libelle,prix) VALUES(?,?)';
    $requête = mysqli_prepare($connexion, $sql);
    // Liaison des paramètres.
    $ok = mysqli_stmt_bind_param($requête,'sd',$libellé,$prix);
    // Exécution de la requête.
    $libellé = 'Pommes';
    $prix = 24.5;
    $ok = mysqli_stmt_execute($requête);
    // Récupération de l'identifiant.
    $identifiant = mysqli_stmt_insert_id($requête);
    echo "Identifiant du nouvel article = $identifiant.<br />";
    // Il est alors possible de donner d'autre valeurs aux variables
    // et d'exécuter de nouveau la requête.
    $libellé = 'Bananes';
    $prix = 15.35;
    $ok = mysqli_stmt_execute($requête);
    $identifiant = mysqli_stmt_insert_id($requête);
    echo "Identifiant du nouvel article = $identifiant.<br />";
    // Requête UPDATE.
    // Préparation de la requête.
    $sql = 'UPDATE articles SET prix = ROUND(prix * ?,2) ' . 
           'WHERE prix < ?'; 
    $requête = mysqli_prepare($connexion, $sql); 
    // Liaison des paramètres. 
    $ok = mysqli_stmt_bind_param($requête,'dd',$augmentation,$prix); 
    // Exécution de la requête. 
    $augmentation = 1.10; 
    $prix = 40; 
    $ok = mysqli_stmt_execute($requête); 
    // Récupération du nombre de lignes modifiées. 
    $nombre = mysqli_stmt_affected_rows($requête);
    echo "$nombre article(s) augmenté(s).<br />";
    // Requête DELETE.
    // Préparation de la requête.
    $sql = 'DELETE FROM articles WHERE prix > ?'; 
    $requête = mysqli_prepare($connexion, $sql); 
    // Liaison des paramètres. 
    $ok = mysqli_stmt_bind_param($requête,'d',$prix); 
    // Exécution de la requête. 
    $prix = 40; 
    $ok = mysqli_stmt_execute($requête); 
    // Récupération du nombre de lignes supprimées. 
    $nombre = mysqli_stmt_affected_rows($requête);
    echo "$nombre article(s) supprimé(s).<br />";
    // Affichage de contrôle.
    afficher_articles($connexion);
    // Déconnexion. 
    $ok = mysqli_close($connexion); 
    ?>

    </div>
  </body>
</html>
