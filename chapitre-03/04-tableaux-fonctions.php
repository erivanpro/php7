<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Manipuler les tableaux</title>
    <style>
      h1 { font-family: "Courier New",Courier,monospace ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>
    
    <h1>count()</h1>
    <?php
    $x = 1;
    echo '$x de type scalaire => ',count($x),'<br />';
    $x = array();
    echo '$x tableau vide => ',count($x),'<br />';
    $x = array(1,2);
    echo '$x tableau de 2 éléments => ',count($x),'<br />';
    ?>
    
    <h1>in_array()</h1>
    <?php
    $nombres = array('zéro','un','deux',
                     'zéro' => 0,'un' => 1,'deux' => 2);
    echo '1 type indifférent => ',
         var_dump(in_array(1,$nombres)),'<br />';
    echo '3 type indifférent => ',
         var_dump(in_array(3,$nombres)),'<br />';
    echo '\'1\' même type => ',
         var_dump(in_array('1',$nombres,TRUE)),'<br />';
    echo '\'un\' type indifférent => ',
         var_dump(in_array('un',$nombres)),'<br />';
    echo '\'trois\' type indifférent => <b>',
         var_dump(in_array('trois',$nombres)),'</b><br />';
    echo '\'trois\' même type => ',
         var_dump(in_array('trois',$nombres,TRUE)),'<br />';
    ?>

    <h1>array_search()</h1>
    <?php
    $nombres = array('zéro','un','deux',
                     'zéro' => 0,'un' => 1,'deux' => 2);
    echo '1 type indifférent => ',
         var_dump(array_search(1,$nombres)),'<br />';
    echo '3 type indifférent => ',
         var_dump(array_search(3,$nombres)),'<br />';
    echo '\'1\' même type => ',
         var_dump(array_search('1',$nombres,TRUE)),'<br />';
    echo '\'un\' type indifférent => ',
         var_dump(array_search('un',$nombres)),'<br />';
    echo '\'trois\' type indifférent => <b>',
         var_dump(array_search('trois',$nombres)),'</b><br />';
    echo '\'trois\' même type => ',
         var_dump(array_search('trois',$nombres,TRUE)),'<br />';
    ?>

    <h1>array_replace()</h1>
    <?php
    $tableau = array('c1' => 'vert','c2' => 'blanc');
    $tableau_remplace = array('c1' => 'bleu','c3' => 'rouge');
    // Affichage de contrôle.
    echo '<b>Tableau de départ :</b><br />';
    foreach($tableau as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    echo '<b>Tableau de remplacement :</b><br />';
    foreach($tableau_remplace as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    // Remplacement.
    $tableau_résultat = array_replace($tableau,$tableau_remplace);
    // Affichage du résultat.
    echo '<b>Résultat :</b><br />';
    foreach($tableau_résultat as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    ?>

    <h1>[a|k][r]sort()</h1>
    <?php
    $tableau = array('c3' => 'rouge','c1' => 'vert',
                     'c2' => 'bleu');
    // Affichage de contrôle.
    echo '<b>Tableau de départ :</b><br />';
    foreach($tableau as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    // sort
    echo '<b>sort : tri sur valeur, clés non préservées</b><br />';
    $tableau_bis = $tableau;
    sort($tableau_bis);
    foreach($tableau_bis as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    // asort
    echo '<b>asort : tri sur valeur, clés préservées</b><br />';
    $tableau_bis = $tableau;
    asort($tableau_bis);
    foreach($tableau_bis as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    // ksort
    echo '<b>ksort : tri sur clé, clés préservées</b><br />';
    $tableau_bis = $tableau;
    ksort($tableau_bis);
    foreach($tableau_bis as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    ?>

    
    <h1>Tri naturel</h1>
    <?php
    $tableau = 
	   ['faq1.txt','faq30.txt','faq100.txt','faq2000.txt'];
    // Affichage de contrôle.
    echo '<b>Tableau de départ :</b><br />';
    foreach($tableau as $valeur)
	   { echo "$valeur<br />"; }
    // Tri par défaut
    echo '<b>Tri par défaut (alphabétique) :</b><br />';
    $tableau_bis = $tableau;
    sort($tableau_bis);
    foreach($tableau_bis as $valeur)
	   { echo "$valeur<br />"; }
    // Tri naturel
    echo '<b>Tri naturel :</b><br />';
    $tableau_bis = $tableau;
    sort($tableau_bis,SORT_NATURAL);
    foreach($tableau_bis as $valeur)
	   { echo "$valeur<br />"; }
    ?>

    
    <h1>explode()</h1>
    <?php
    $liste = 'bleu, blanc, rouge';
    $couleurs = explode(', ',$liste);
      // séparateur = virgule+espace
    foreach($couleurs as $clé => $valeur)
      { echo "$clé => $valeur<br />"; }
    echo '<b>Avec le paramètre "limite"</b><br />';
    $liste = '1,2,3,4,5,6,7,8,9,0';
    echo '<b>= +4</b><br />';
    $chiffres = explode(',',$liste,4);
    foreach($chiffres as $valeur)
      { echo "$valeur<br />"; }
    echo '<b>= -4</b><br />';
    $chiffres = explode(',',$liste,-4);
    foreach($chiffres as $valeur)
      { echo "$valeur<br />"; }
    echo '<b>= 0 (équivalent à 1)</b><br />';
    $chiffres = explode(',',$liste,0);
    foreach($chiffres as $valeur)
      { echo "$valeur<br />"; }
    ?>
    
    <h1>implode()</h1>
    <?php
    $couleurs = array('bleu','blanc','rouge');
    $liste = implode(', ',$couleurs);
      // séparateur = virgule+espace
    echo $liste;
    ?>

    <h1>max()</h1>
    <?php
    echo max(['bleu','blanc','rouge']),'<br />'; 
    echo max([2**3,3**2,2*3,2+3]); 
    ?>

    <h1>min()</h1>
    <?php
    echo min(['bleu','blanc','rouge']),'<br />'; 
    echo min([2**3,3**2,2*3,2+3]); 
    ?>

    <h1>str_split()</h1>
    <?php
    $chaîne = 'A1B2C3';
    $tableau = str_split($chaîne,2);
    foreach($tableau as $clé => $valeur) {
      echo "\$tableau[$clé] = $valeur<br>";
    }
    ?>
    
    <h1>array_column()</h1>
    <?php
    $articles = [
      ['identifiant' => 10, 'libelle' => 'Abricots', 'prix' => 35],
      ['identifiant' => 20, 'libelle' => 'Cerises',  'prix' => 48],
      ['identifiant' => 30, 'libelle' => 'Fraises',  'prix' => 29],
      ['identifiant' => 40, 'libelle' => 'Pêches',   'prix' => 37]];
    echo '<b>Colonne des libellés :</b><br />';
    $libellés = array_column($articles,'libelle');
    foreach($libellés as $clé => $valeur) {
      echo "[$clé] = $valeur<br>";
    }
    echo '<b>Colonne des prix en utilisant le libellé comme index :</b><br />';
    $prix = array_column($articles,'prix','libelle');
    foreach($prix as $clé => $valeur) {
      echo "[$clé] = $valeur<br>";
    }
    ?>

    </div>
  </body>
</html>