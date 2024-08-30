<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Mise à jour</title>
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
    $requête = 'INSERT INTO articles(libelle,prix)  
                VALUES(:p1,:p2) 
                RETURNING identifiant, ROWID, ROWIDTOCHAR(ROWID)  
                INTO :r1,:r2,:r3'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Création d’une variable pour le rowid. 
    $rowid = oci_new_descriptor($connexion,OCI_D_ROWID); 
    // Association entre les variables et les paramètres. 
    oci_bind_by_name($curseur,':p1',$libellé,50); 
    oci_bind_by_name($curseur,':p2',$prix,32); 
    oci_bind_by_name($curseur,':r1',$identifiant,32); 
    oci_bind_by_name($curseur,':r2',$rowid,-1,SQLT_RDD); 
    oci_bind_by_name($curseur,':r3',$rowid_chaîne,32); 
    // Exécution de la requête. 
    $libellé = 'Poire'; // valeur du libellé (sans s) 
    $prix = 0; // valeur du prix (0 pour l’instant) 
    $ok = oci_execute($curseur); // COMMIT automatique 
    echo "Identifiant du nouvel article = $identifiant.<br />"; 
    echo  
      'ROWID du nouvel article = ',gettype($rowid),'.<br />'; 
    echo "ROWID du nouvel article = $rowid_chaîne (chaîne).<br />"; 
    // Requête UPDATE paramétrée utilisant le ROWID objet. 
    $requête = 'UPDATE articles SET prix = :p1  
                WHERE ROWID = :p2'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Association entre les variables et les paramètres. 
    oci_bind_by_name($curseur,':p1',$prix,32); 
    oci_bind_by_name($curseur,':p2',$rowid,-1,SQLT_RDD); 
    // Exécution de la requête. 
    $prix = 29.9; // valeur du prix ($rowid déjà initialisé) 
    $ok = oci_execute($curseur); // COMMIT automatique 
    // Requête UPDATE paramétrée utilisant le ROWID chaîne. 
    $requête = 'UPDATE articles SET libelle = :p1  
                WHERE ROWID = CHARTOROWID(:p2)'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Association entre les variables et les paramètres. 
    oci_bind_by_name($curseur,':p1',$libellé,50); 
    oci_bind_by_name($curseur,':p2',$rowid_chaîne,32); 
    // Exécution de la requête. 
    $libellé = 'Poires'; // valeur du libellé (avec un s) 
                         // $rowid_chaîne déjà initialisé 
    $ok = oci_execute($curseur); // COMMIT automatique 
    // Requête UPDATE (non paramétrée). 
    $requête = 'UPDATE articles SET prix = prix * 1.1  
                WHERE prix < 40'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur); // COMMIT automatique 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre article(s) augmenté(s).<br />"; 
    // Requête DELETE (non paramétrée). 
    $requête = 'DELETE FROM articles WHERE prix > 40'; 
    // Analyse. 
    $curseur = oci_parse($connexion,$requête); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur); // COMMIT automatique 
    $nombre = oci_num_rows($curseur); 
    echo "$nombre article(s) supprimés(s).<br />"; 
    // Affichage de contrôle. 
    afficher_articles($connexion); 
    // Déconnexion. 
    $ok = oci_close($connexion); 
    ?>

    </div>
  </body>
</html>
