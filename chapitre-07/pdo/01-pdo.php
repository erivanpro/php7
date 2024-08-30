<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>PHP Data Objects (PDO)</title>
  </head>
  <body>
    <div>

    <?php
    // Définition des paramètres de connexion.
    // La syntaxe de la source (Data Source Name ou DSN)
    // est spécifique à chaque driver.
    // Le numéro du cas à tester est passé dans l'URL avec la 
    // variable 'test'.
    // Récupérer la valeur de la variable (1 par défaut = MySQL).
    $test = filter_input(INPUT_GET,'test',FILTER_VALIDATE_INT)?:1;
    switch ($test) {
      case 1: // MySQL
      default:
        $source = 'mysql:host=localhost;dbname=diane';
        $utilisateur = 'root';
        $mot_de_passe = '';
        break;
      case 2: // Oracle
        $source = 'oci:dbname=diane';
        $utilisateur = 'demeter';
        $mot_de_passe = 'demeter';
        break;
      case 3: // SQLite (version 3.x)
        $source = 'sqlite:/app/sqlite/diane.dbf';
        $utilisateur = '';
        $mot_de_passe = '';
        break;
    }
    // Définition de deux requêtes de test.
    // Noter que la requête d'insertion est paramétrée (c'est
    // en fait la seule fonctionnalité qui est émulée par PDO,
    // si elle n'est pas nativement supportée par la base de
    // données).
    $sql_select = 'SELECT * FROM articles ORDER BY identifiant';
    $sql_insert = 'INSERT INTO articles(libelle,prix) VALUES(:p1,:p2)';
    // Toutes les opérations sont effectuées dans un bloc
    // 'try' afin de récupérer les exceptions levées par PDO.
    try {
      // Connexion à la base de données.
      $db = new PDO($source, $utilisateur, $mot_de_passe);
      // Modification des paramètres de la connexion pour
      // demander que des exceptions soient levées en cas
      // d'erreur.
      $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      // Préparer une requête pour l'insertion.
      $st = $db->prepare($sql_insert);
      // Lier les paramètres
      $st->bindParam(':p1',$nom);
      $st->bindParam(':p2',$prix);
      // Affecter une valeur aux variables.
      $nom = 'Pommes';
      $prix = 30.5;
      // Exécuter la requête.
      // Pour les bases de données qui supporte les transactions,
      // les méthodes beginTransaction(), commit() et rolback()
      // des objets PDO peuvent être utilisées.
      $st->execute();
      // Préparer une requête pour la sélection.
      $st = $db->prepare($sql_select);
      // Exécuter la requête.
      $st->execute();
      // Récupérer le résultat.
      // Plusieurs méthodes sont disponibles pour récupérer
      // le résultat : fetch(), fetchObject(), fetchAll().
      // La méthode fetch() dispose d'un paramètre qui permet
      // de spécifier le type de résultat (tableau, objet, etc.).
      while ($ligne = $st->fetch()) {
        echo "$ligne[1] - $ligne[2]<br />\n";
      }
      // Libérer les resources
      $st = null;
      $db = null;
    } catch (PDOException $e) {
      // Gérer les exceptions
      echo 'Error!: ',$e->getMessage(),'<br />';
      die();
    }
    ?>

    </div>
  </body>
</html>
