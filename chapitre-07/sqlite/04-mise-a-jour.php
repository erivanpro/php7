<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Mise à jour</title>
  </head>
  <body>
    <div>

    <?php 
    // Définition d'une petite fonction d’affichage de la liste 
    // des articles. 
    // Cette fonction utilise une requête préparée qui ne sera 
    // préparée qu'une fois, lors du premier appel.
    // La variable qui stocke le résultat de la préparation est une
    // variable statique dont la valeur est préservée d'un appel à 
    // un autre.
    function afficher_articles($base) { 
      static $requête;
      if (! isset($requête)) { // $requête non définie = premier appel
        $sql = 'SELECT * FROM articles'; 
        $requête = $base->prepare($sql); 
      }
      $résultat = $requête->execute(); 
      echo '<b>Liste des articles :</b><br />'; 
      while ($ligne = $résultat->fetchArray()) {
        echo $ligne['identifiant'],' - ',$ligne['libelle'],' - ',
             $ligne['prix'],'<br />'; 
      }
    } 
    // Ouverture de la base. 
    $base = new SQLite3('/app/sqlite/diane.dbf'); 
    // Affichage de contrôle. 
    afficher_articles($base); 
    // Requête INSERT (paramétrée). 
    $sql = 'INSERT INTO articles(libelle,prix) VALUES(?,?)'; 
    $requête = $base->prepare($sql); 
    $ok = $requête->bindParam(1,$libellé);
    $ok = $requête->bindParam(2,$prix);
    $libellé = 'Poires';
    $prix = 29.9;
    $résultat = $requête->execute(); 
    $identifiant =  
      $base->lastInsertRowID(); // récupérer l’identifiant 
    echo "Identifiant du nouvel article = $identifiant.<br />"; 
    // Requête UPDATE (non paramétrée). 
    $requête = 'UPDATE articles SET prix = ROUND(prix * 1.1,2) ' .  
               'WHERE prix < 40'; 
    $résultat = $base->exec($requête); 
    $nombre = $base->changes(); 
    echo "$nombre article(s) augmenté(s).<br />"; 
    // Requête DELETE (non paramétrée). 
    $requête = 'DELETE FROM articles WHERE prix > 40'; 
    $résultat = $base->exec($requête); 
    $nombre = $base->changes(); 
    echo "$nombre article(s) supprimé(s).<br />"; 
    // Affichage de contrôle. 
    afficher_articles($base); 
    // Fermeture de la base. 
    $ok = $base->close(); 
    ?>

    </div>
  </body>
</html>
