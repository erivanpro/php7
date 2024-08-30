<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête non préparée : gestion des erreurs</title>
  </head>
  <body>
    <div>

    <?php 
    // Connexion. 
    $connexion = mysqli_connect(); 
    if (! $connexion) {
      exit('Echec de la connexion.');
    }
    // Sélection d'une mauvaise base de données. 
    $ok = mysqli_select_db($connexion,'hermes'); 
    echo '1 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    // Sélection de la bonne base de données. 
    $ok = mysqli_select_db($connexion,'diane'); 
    echo '2 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    // Une bonne requête pour commencer. 
    $requête = 'SELECT * FROM articles'; 
    $résultat = mysqli_query($connexion,$requête); 
    echo '3 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    // Requête sur une table qui n'existe pas. 
    $requête = 'SELECT * FROM article'; 
    $résultat = mysqli_query($connexion,$requête); 
    echo '4 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    // Tentative de fetch sur un mauvais résultat. 
    $ligne = mysqli_fetch_assoc($résultat); 
    echo '5 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    // Requête INSERT qui viole une clé primaire.  
    $requête = "INSERT INTO articles(identifiant,libelle,prix) " . 
               "VALUES(1,'Poires',29.9)"; 
    $résultat = mysqli_query($connexion,$requête); 
    echo '6 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    ?>

    </div>
  </body>
</html>
