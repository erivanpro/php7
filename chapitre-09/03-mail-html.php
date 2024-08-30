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
    
    <h1>Message au format HTML</h1>
    <?php
    // Destinataires.
    $destinataires = 'xavier@zeus.priv';
    // Objet.
    $objet = 'Bonjour !';
    // En-têtes supplémentaires.
    $entêtes .= "From: \"Olivier\" <olivier@diane.com>\r\n";
    $entêtes .= "MIME-Version: 1.0\r\n";
    $entêtes .= "Content-Type: text/html; charset=utf-8\r\n";
    $entêtes .= "Content-Transfer-Encoding: 8bit\r\n";
    // Message (HTML).
    $message .= "<html>\n";
    $message .= "<head><title>Bonjour !</title></head>\n";
    $message .= "<body>\n";
    $message .= "<font color=\"green\">Bonjour !</font>\n";
    $message .= "</body>\n";
    $message .= "</html>\n";
    // Envoi.
    // $ok = mail($destinataires,$objet,$message,$entêtes);
    echo 'Remarque : la ligne de code permettant d\'envoyer le mail est en commentaire.<br />';
    ?>

    </div>
  </body>
</html>