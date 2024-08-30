<?php 
// Fonction qui retourne le nom de la constante 
// de statut à partir de sa valeur. 
function texte_statut($valeur) { 
  switch ($valeur) { 
    case PHP_SESSION_DISABLED: 
        return 'PHP_SESSION_DISABLED'; 
    case PHP_SESSION_NONE: 
        return 'PHP_SESSION_NONE'; 
    case PHP_SESSION_ACTIVE: 
        return 'PHP_SESSION_ACTIVE'; 
  } 
  return '?'; 
} 
$statut1 = texte_statut(session_status());
session_start(); 
$statut2 = texte_statut(session_status());
session_destroy(); 
$statut3 = texte_statut(session_status());
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Statut de la session</title>
  </head>
  <body>
    <div>
    <?php 
    echo 'Avant session_start() : ',$statut1,'<br />'; 
    echo 'Après session_start() : ',$statut2,'<br />'; 
    echo 'Après session_destroy() : ',$statut3,'<br />'; 
    ?>
    </div>
  </body>
</html>
