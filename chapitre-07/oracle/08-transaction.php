<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Transaction</title>
  </head>
  <body>
    <div>

    <?php 
    // Définition d’une petite fonction d’affichage de la liste 
    // des articles. 
    // Cette fonction utilise un curseur qui ne sera analysé
    // qu'une fois, lors du premier appel.
    // La variable qui stocke l'identifiant du curseur est une 
    // variable statique dont la valeur est préservée d'un appel 
    // à un autre.
    function afficher_articles ($connexion) { 
      static $curseur;
      if (! isset($curseur)) { // $curseur non défini = premier appel
        $requête = 'SELECT * FROM articles'; 
        $curseur = oci_parse($connexion,$requête); 
      }
      $ok = oci_execute($curseur); 
      echo '<b>Liste des articles :</b><br />'; 
      while ($article = oci_fetch_assoc($curseur)) {
          echo $article['IDENTIFIANT'],' - ',$article['LIBELLE'],' - ',
               $article['PRIX'],'<br />'; 
      }
    } 
    // Connexion. 
    $connexion = oci_connect('demeter','demeter','diane'); 
    // Affichage de contrôle. 
    afficher_articles($connexion); 
    // Requête INSERT (paramétrée). 
    $requête = 'INSERT INTO articles(libelle,prix) VALUES(:p1,:p2)'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Création d’une variable pour le rowid. 
    $rowid = oci_new_descriptor($connexion,OCI_D_ROWID); 
    // Association entre les variables et les paramètres. 
    oci_bind_by_name($curseur,':p1',$libellé,50); 
    oci_bind_by_name($curseur,':p2',$prix,32); 
    // Exécution de la requête. 
    $libellé = 'Bananes';
    $prix = 15.45;
    $ok = oci_execute($curseur,FALSE); // Pas de COMMIT automatique
    // Requête UPDATE paramétrée utilisant le ROWID objet. 
    $requête = 'UPDATE articles SET prix = :p1 WHERE identifiant = :p2'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Association entre les variables et les paramètres. 
    oci_bind_by_name($curseur,':p1',$prix,32); 
    oci_bind_by_name($curseur,':p2',$identifiant,10,SQLT_INT); 
    // Exécution de la requête. 
    $identifiant = 1;
    $prix = 29.9;
    $ok = oci_execute($curseur,FALSE); // Pas de COMMIT automatique
    // COMMIT. 
    $ok = oci_commit($connexion); 
    // Requête DELETE de tous les articles (oups !). 
    $requête = 'DELETE FROM articles'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur,FALSE); // Pas de COMMIT automatique 
    // ROLLBACK (ouf !). 
    $ok = oci_rollback($connexion); 
    // Affichage de contrôle. 
    afficher_articles($connexion); 
    // Déconnexion. 
    $ok = oci_close($connexion); 
    ?>

    </div>
  </body>
</html>
