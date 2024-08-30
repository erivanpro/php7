<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Paramètres : passage par référence</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>

    <h1>Paramètre passé par valeur</h1>
    <?php 
    // Définition d'une fonction qui prend un paramètre. 
    function par_valeur($paramètre) { 
      // Incrémentation du paramètre. 
      $paramètre++; 
      // Affichage du paramètre à l'intérieur de la fonction. 
      echo "\$paramètre = $paramètre<br />"; 
    } 
    // Initialisation d'une variable. 
    $x = 1; 
    // Affichage de la variable avant l'appel à la fonction. 
    echo "\$x avant appel = $x<br />"; 
    // Appel de la fonction en utilisant la variable comme valeur  
    // du paramètre. 
    par_valeur($x); 
    // Affichage de la variable après l'appel à la fonction. 
    echo "\$x après appel = $x<br />"; 
    ?>

    <h1>Paramètre passé par référence</h1>
    <?php 
    // Définition d'une fonction qui prend un paramètre. 
    function par_référence(&$paramètre) { 
      // Incrémentation du paramètre. 
      $paramètre++; 
      // Affichage du paramètre à l'intérieur de la fonction. 
      echo "\$paramètre = $paramètre<br />"; 
    } 
    // Initialisation d'une variable. 
    $x = 1; 
    // Affichage de la variable avant l'appel à la fonction. 
    echo "\$x avant appel = $x<br />"; 
    // Appel de la fonction en utilisant la variable comme valeur  
    // du paramètre. 
    par_référence($x); 
    // Affichage de la variable après l'appel à la fonction. 
    echo "\$x après appel = <b>$x</b><br />"; 
    ?>
    
    </div>
  </body>
</html>
