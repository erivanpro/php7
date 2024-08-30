<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requête non préparée : mise à jour</title>
  </head>
  <body>
    <div>

    <?php
    // Définition d’une petite fonction d’affichage de la liste 
    // des articles. 
    function afficher_articles($connexion) { 
      $sql = 'SELECT * FROM articles'; 
      $requête = mysqli_query($connexion,$sql);
      echo '<b>Liste des articles :</b><br />'; 
      while($ligne = mysqli_fetch_assoc($requête)) { 
        echo $ligne['identifiant'],' - ',$ligne['libelle'],' - ',
             $ligne['prix'],'<br />'; 
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
    $requête = "INSERT INTO articles(libelle,prix) " . 
                "VALUES('Poires',29.9)";
    $résultat = mysqli_query($connexion,$requête);
    // Récupération de l’identifiant.
    $identifiant = mysqli_insert_id($connexion);
    echo "Identifiant du nouvel article = $identifiant.<br />";
    // Requête UPDATE.
    $requête = 'UPDATE articles SET prix = ROUND(prix * 1.1,2) ' . 
               'WHERE prix < 40';
    $résultat = mysqli_query($connexion,$requête);
    // Récupération du nombre de lignes modifiées. 
    $nombre = mysqli_affected_rows($connexion);
    echo "$nombre article(s) augmenté(s).<br />";
    // Requête DELETE.
    $requête = 'DELETE FROM articles WHERE prix > 40';
    $résultat = mysqli_query($connexion,$requête);
    // Récupération du nombre de lignes supprimées. 
    $nombre = mysqli_affected_rows($connexion);
    echo "$nombre article(s) supprimés(s).<br />";
    // Affichage de contrôle.
    afficher_articles($connexion);
    // Déconnexion. 
    $ok = mysqli_close($connexion); 
    ?>

    </div>
  </body>
</html>
