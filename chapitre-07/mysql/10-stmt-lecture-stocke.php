<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête préparée : lecture avec résultat stocké</title>
  </head>
  <body>
    <div>

    <?php 
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
    // Préparation de la requête. 
    $sql = 'SELECT libelle,prix FROM articles WHERE prix < ?'; 
    $requête = mysqli_prepare($connexion, $sql); 
    // Liaison des paramètres. 
    $ok = mysqli_stmt_bind_param($requête,'d',$prix_max); 
    // Liaison des colonnes du résultat. 
    $ok = mysqli_stmt_bind_result($requête,$libelle,$prix); 
    // Exécution de la requête. 
    $prix_max = 35; 
    $ok = mysqli_stmt_execute($requête); 
    echo '<b>Avant appel à mysqli_stmt_store_result</b><br />', 
         'Nombre de lignes sélectionnées = ', 
         mysqli_stmt_num_rows($requête),'<br />'; 
    $ok = mysqli_stmt_store_result($requête); 
    echo '<b>Après appel à mysqli_stmt_store_result</b><br />', 
         'Nombre de lignes sélectionnées = ', 
         mysqli_stmt_num_rows($requête),'<br />'; 
    // Lecture du résultat. 
    echo "<b>Articles dont le prix est < $prix_max </b><br />"; 
    while (mysqli_stmt_fetch($requête)) { 
      echo "$libelle<br />"; 
    } 
    // Déconnexion. 
    $ok = mysqli_close($connexion); 
    ?>

    </div>
  </body>
</html>
