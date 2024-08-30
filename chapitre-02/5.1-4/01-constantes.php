<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Constantes</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
  <div>
  
  <h1>Définition et affichage de constantes</h1>
  <?php
  // Définir une constante (dont le nom est par défaut 
  // sensible à la casse).
  define('CONSTANTE','valeur de CONSTANTE');
  // Afficher la valeur de CONSTANTE (=> OK).
  echo 'CONSTANTE = ',CONSTANTE,'<br />';
  // Utilisation du mot-clé const (depuis la version 5.3)
  const UNE_AUTRE_CONSTANTE = 'PHP 7.0';
  echo 'UNE_AUTRE_CONSTANTE = ', UNE_AUTRE_CONSTANTE,'<br />';
  // Utilisation d'une expression complexe pour définir la valeur
  // d'une constante avec la fonction define.
  define('ENCORE_UNE_CONSTANTE',md5(uniqid(rand())));
  echo 'ENCORE_UNE_CONSTANTE = ', ENCORE_UNE_CONSTANTE,'<br />';
  // Utilisation d'une expression simple pour définir la valeur
  // d'une constante avec le mot clé const (depuis la version 5.6).
  const UNE_DERNNIERE_CONSTANTE = UNE_AUTRE_CONSTANTE . ' (nouveau)';
  echo 'UNE_DERNNIERE_CONSTANTE = ', UNE_DERNNIERE_CONSTANTE;
  ?>

  <h1>Utilisation d'une constante non définie</h1>
  <?php
  echo 'constante = ',constante;
  echo ' => interprété en littéral<br />';
  ?>

  </div>
  </body>
</html>
