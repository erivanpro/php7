<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Requêtes paramétrées</title>
  </head>
  <body>
    <div>

    <?php 
    // Connexion. 
    $connexion = oci_connect('demeter','demeter','diane'); 
    // Définition d’une première requête paramétrée. 
    $requête = 'SELECT * FROM articles WHERE identifiant = :p1'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Association entre le paramètre et la variable PHP 
    oci_bind_by_name($curseur,':p1',$identifiant,-1,SQLT_INT); 
    // Exécution de la requête avec une première valeur  
    // de la variable. 
    $identifiant = 1; 
    $ok = oci_execute($curseur); 
    // Lire le résultat. 
    $ligne = oci_fetch_assoc($curseur); 
    echo "{$ligne['IDENTIFIANT']} - {$ligne['LIBELLE']}<br />"; 
    // Exécution de la requête avec une deuxième valeur  
    // de la variable (utilisation du même curseur). 
    $identifiant = 2; 
    $ok = oci_execute($curseur); 
    // Lire le résultat. 
    $ligne = oci_fetch_assoc($curseur); 
    echo "{$ligne['IDENTIFIANT']} - {$ligne['LIBELLE']}<br />"; 
    // Définition d’une requête qui sélectionne les ROWID sous 
    // deux formes. 
    $requête = 'SELECT ROWID,ROWIDTOCHAR(ROWID) rowid_chaine FROM articles'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Exécution de la requête. 
    $ok = oci_execute($curseur); 
    // Récupération de la première ligne. 
    $ligne = oci_fetch_assoc($curseur); 
    $rowid = $ligne['ROWID']; 
    $rowid_chaîne = $ligne['ROWID_CHAINE'];
    echo '$rowid = ',gettype($rowid),'<br />'; 
    echo '$rowid_chaîne = ',$rowid_chaîne,'<br />'; 
    // Définition d’une requête paramétrée utilisant le ROWID. 
    $requête = 'SELECT * FROM articles WHERE ROWID = :p1'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Association entre le paramètre et la variable PHP. 
    oci_bind_by_name($curseur,':p1',$rowid,-1,SQLT_RDD); 
    // Exécution de la requête avec le premier ROWID  
    //(actuellement dans $rowid). 
    $ok = oci_execute($curseur); 
    // Lire le résultat. 
    $ligne = oci_fetch_assoc($curseur); 
    echo "{$ligne['IDENTIFIANT']} - {$ligne['LIBELLE']}<br />"; 
    // Définition d’une requête paramétrée utilisant le ROWID chaîne. 
    $requête = 'SELECT * FROM articles WHERE ROWID = CHARTOROWID(:p1)'; 
    // Analyse de la requête. 
    $curseur = oci_parse($connexion,$requête); 
    // Association entre le paramètre et la variable PHP. 
    oci_bind_by_name($curseur,':p1',$rowid_chaîne); 
    // Exécution de la requête avec le premier ROWID  
    //(actuellement dans $rowid_chaîne). 
    $ok = oci_execute($curseur); 
    // Lire le résultat. 
    $ligne = oci_fetch_assoc($curseur); 
    echo "{$ligne['IDENTIFIANT']} - {$ligne['LIBELLE']}<br />"; 
    // Déconnexion. 
    $ok = oci_close($connexion); 
    ?>

    </div>
  </body>
</html>
