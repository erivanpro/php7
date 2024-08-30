<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Manipuler les fichiers sur le serveur</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>
    
    <h1>Quelques opérations de base sur les fichiers</h1>
    <?php
    // Ouvrir un fichier en écriture.
    $f = fopen('../documents/info.txt','wb');
    // Ecrire dans le fichier.
    fwrite($f, 'Olivier HEURTEL');
    // Fermer le fichier.
    fclose($f);
    // Ouvrir un fichier en lecture
    $f = fopen('../documents/info.txt','rb');
    // Lire dans le fichier.
    $texte = fread($f, filesize('../documents/info.txt'));
    // Fermer le fichier.
    fclose($f);
    // Afficher les informations lues.
    echo $texte,'<br />';
    // Plus simple : utiliser file_get_contents.
    $texte = file_get_contents('../documents/info.txt');
    // Afficher les informations lues.
    echo $texte;
    ?>
    
    <h1>Affichage du contenu d'un répertoire</h1>
    <?php
    // Première méthode : opendir + readdir + closedir.
    echo '<b>1) opendir + readdir + closedir</b><br />';
    // Ouvrir le répertoire.
    $dir = opendir('../documents');
    // Parcourir le répertoire en lisant le nom d'un fichier
    // à chaque itération.
    while($fichier = readdir($dir)) {
      echo $fichier,'<br />';
    }
    // Fermer le répertoire.
    closedir($dir);
    // Deuxième méthode : scandir.
    echo '<br /><b>2) scandir</b><br />';
    // Lister le contenu du répertoire dans un tableau.
    $fichiers = scandir('../documents');
    // Parcourir résultat.
    foreach ($fichiers as $fichier) {
      echo $fichier,'<br />';
    }
    ?>

    </div>
  </body>
</html>