<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>Envoyer un courrier électronique</title>
    <style>
      h1 { font-family: verdana,arial,helvetica,sans-serif ; font-size: 100% ; margin-top: 20pt }
    </style>
  </head>
  <body>
    <div>
    
    <h1>Exemple de message simple</h1>
    <?php
    // Destinataire.
    $destinataire = 'olivier@diane.priv';
    // Objet.
    $objet = "Inscription à monSite.com";
    // Message.
    $message = "Monsieur Heurtel,\n";
    $message .= "Nous vous remercions pour votre inscription sur note site monSite.com.\n";
    $message .= "Nous espérons que ce site répondra à vos attentes.\n";
    $message .= "Le webmaster.\n";
    // Envoi.
    // $ok = mail($destinataire,$objet,$message);
    echo 'Remarque : la ligne de code permettant d\'envoyer le mail est en commentaire.<br />';
    ?>

    </div>
  </body>
</html>