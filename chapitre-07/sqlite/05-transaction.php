<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Transaction</title>
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
    // Démarrer une transaction.
    $ok = $base->exec('BEGIN TRANSACTION');
    // Requête INSERT (paramétrée). 
    $sql = 'INSERT INTO articles(libelle,prix) VALUES(?,?)'; 
    $requête = $base->prepare($sql); 
    $ok = $requête->bindParam(1,$libellé);
    $ok = $requête->bindParam(2,$prix);
    $libellé = 'Kiwis';
    $prix = 24.5;
    $ok = $requête->execute(); 
    // Requête UPDATE (paramétrée).
    $sql = 'UPDATE articles SET prix = ? WHERE identifiant = ?'; 
    $requête = $base->prepare($sql); 
    $ok = $requête->bindParam(1,$prix);
    $ok = $requête->bindParam(2,$identifiant);
    $identifiant = 3;
    $prix = 29.9;
    $ok = $requête->execute(); 
    // COMMIT.
    $ok = $base->exec('COMMIT');
    // Démarrer une nouvelle transaction.
    $ok = $base->exec('BEGIN TRANSACTION');
    // Requête DELETE de tous les articles (oups !). 
    $sql = 'DELETE FROM articles '; 
    $ok = $base->exec($sql); 
    // ROLLBACK (ouf !). 
    $ok = $base->exec('ROLLBACK');
    // Affichage de contrôle.
    afficher_articles($base);
    // Fermeture de la base. 
    $ok = $base->close(); 
    ?>

    </div>
  </body>
</html>
