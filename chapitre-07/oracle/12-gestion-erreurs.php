<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Gestion des erreurs</title>
  </head>
  <body>
    <div>

    <?php 
    // Mauvaise connexion. 
    $connexion = oci_connect('demeter','MotDePasseErroné','diane'); 
    $e = oci_error(); // Appel sans paramètre 
    echo '1 : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    // Connexion. 
    $connexion = oci_connect('demeter','demeter','diane'); 
    // Une bonne requête pour commencer. 
    $requête = 'SELECT * FROM articles'; 
    $curseur = oci_parse($connexion,$requête); 
    $ok = oci_execute($curseur); 
    $e = oci_error($curseur); 
    echo '<p>2 : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    // Erreur de syntaxe. 
    $requête = "SELEC ' FROM articles"; 
    $curseur = oci_parse($connexion,$requête); 
    $e = oci_error($connexion); // Appel avec l'identifiant de la connexion 
    echo '<p>3 : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />';
    // Requête sur une table qui n’existe pas. 
    $requête = 'SELECT * FROM article'; 
    $curseur = oci_parse($connexion,$requête); 
    $e = oci_error($connexion); // Appel avec l'identifiant de la connexion 
    echo '<p>4.a : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    $ok = oci_execute($curseur); 
    $e = oci_error($curseur); // Appel avec l'identifiant de curseur
    echo '4.b : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    // Requête UPDATE qui viole une clé primaire. 
    $requête = 'UPDATE articles SET identifiant = 1'; 
    $curseur = oci_parse($connexion,$requête); 
    $ok = oci_execute($curseur); 
    $e = oci_error($curseur); 
    echo '<p>5 : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    // Tentative de fetch sur un mauvais résultat. 
    $requête = 'SELECT * FROM article'; 
    $curseur = oci_parse($connexion,$requête); 
    $ok = oci_execute($curseur); 
    $e = oci_error($curseur); 
    echo '<p>6.a : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    $ligne = oci_fetch_assoc($curseur); 
    $e = oci_error($curseur); 
    echo '6.b : ',($e?"${e['code']} - {$e['message']}":'OK'),'<br />'; 
    ?>

    </div>
  </body>
</html>
