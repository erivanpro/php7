<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Environnement NLS</title>
  </head>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  <body>
    <div>

    <h1> Première solution</h1>
    <?php
    // Connexion
    $connexion = oci_connect('demeter','demeter','diane','UTF8');
    // Récupération de la date du serveur :
    //    - la mise en forme attendue est obtenue par une 
    //      conversion explicite
    $requête = "SELECT TO_CHAR(SYSDATE, 'DD/MM/YYYY') d 
                FROM dual";
    $curseur = oci_parse($connexion,$requête);
    $ok = oci_execute($curseur);
    $ligne = oci_fetch_assoc($curseur);
    echo "SYSDATE = {$ligne['D']}<br />"; // utilisation de l'alias
    // Augmentation des prix à l’aide d’une requête paramétrée :
    //    - la chaîne implicitement passée en paramètre est 
    //      explicitement convertie à l’aide du bon format 
    $requête = "UPDATE articles 
                SET prix = prix * TO_NUMBER(:p1,'9.99')";
    $curseur = oci_parse($connexion,$requête);
    oci_bind_by_name($curseur,':p1',$coefficient,32);
    $coefficient = 1.05; // 5% d'augmentation
    $ok = oci_execute($curseur);
    echo oci_num_rows($curseur),' lignes modifiées.';
    ?>

    <h1> Deuxième solution</h1>
    <?php
    // Connexion
    $connexion = oci_connect('demeter','demeter','diane','UTF8');
    // Définition de l’environnement souhaité par 
    // deux requêtes ALTER SESSION.
    $requête = "ALTER SESSION SET NLS_DATE_FORMAT='DD/MM/YYYY'";
    $ok = oci_execute(oci_parse($connexion,$requête));
    $requête = "ALTER SESSION SET NLS_NUMERIC_CHARACTERS='.,'";
    $ok = oci_execute(oci_parse($connexion,$requête));
    // Récupération de la date du serveur
    $requête = 'SELECT SYSDATE FROM dual';
    $curseur = oci_parse($connexion,$requête);
    $ok = oci_execute($curseur);
    $ligne = oci_fetch_assoc($curseur);
    echo "SYSDATE = {$ligne['SYSDATE']}<br />";
    // Augmentation des prix à l’aide d’une requête paramétrée.
    $requête = 'UPDATE articles SET prix = prix * :p1';
    $curseur = oci_parse($connexion,$requête);
    oci_bind_by_name($curseur,':p1',$coefficient,32);
    $coefficient = 1.05; // 5% d'augmentation
    $ok = oci_execute($curseur);
    echo oci_num_rows($curseur),' lignes modifiées.';
    ?>

    </div>
  </body>
</html>
