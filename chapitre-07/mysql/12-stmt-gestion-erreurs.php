<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête préparée : gestion des erreurs</title>
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
    // Préparation d'une requête sur une table qui n'existe pas. 
    $sql = 'SELECT * FROM article'; 
    $requête = mysqli_prepare($connexion, $sql); 
    // Utilisation de mysqli_errno et mysqli_error à ce stade. 
    echo '1 : ',mysqli_errno($connexion),' - ', 
                mysqli_error($connexion),'<br />'; 
    // Préparation d'une requête (sur une table qui existe). 
    $sql = 'INSERT INTO articles(identifiant,libelle) VALUES(?,?)'; 
    $requête = mysqli_prepare($connexion, $sql); 
    // Liaison des paramètres. 
    $ok = mysqli_stmt_bind_param($requête,'is',$identifiant,$libelle); 
    // Exécution de la requête (viole une clé unique). 
    $identifiant = 3; 
    $libelle = 'Kiwis'; 
    $ok = mysqli_stmt_execute($requête); 
    echo '2 : ',mysqli_stmt_errno($requête),' - ', 
                mysqli_stmt_error($requête),'<br />'; 
    // Déconnexion. 
    $ok = mysqli_close($connexion); 
    ?>

    </div>
  </body>
</html>
