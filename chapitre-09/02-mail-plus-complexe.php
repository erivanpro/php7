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
    
    <h1>Exemple de message plus complexe</h1>
    <?php
    // Deux destinataires séparés par une virgule.
    $destinataires = 'olivier@diane.priv,xavier@zeus.priv';
    // Objet.
    $objet = 'Inscription au marathon';
    // Message.
    $message .= "Olivier, Xavier,\n";
    $message .= "Nous vous confirmons votre inscription au\n";
    $message .= "marathon le dimanche 11 avril.\n";
    $message .= "Le départ sera donné à 8h45.\n\n";
    $message .= "Les organisateurs.\n";
    // En-têtes supplémentaires.
    $entêtes .= "From: \"Inscription\" <contact@marathon.fr>\r\n";
    $entêtes .= "Reply-To: \"Inscription\" <contact@marathon.fr>\r\n";
    $entêtes .= "Content-Type: text/plain; charset=utf-8\r\n";
    $entêtes .= "X-Priority: 1\r\n";
    // Envoi.
    // $ok = mail($destinataires,$objet,$message,$entêtes);
    echo 'Remarque : la ligne de code permettant d\'envoyer le mail est en commentaire.<br />';
    ?>

    </div>
  </body>
</html>