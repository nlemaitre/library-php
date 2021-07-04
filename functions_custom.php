<?php
function pdo_connect_mysql() {
    // AJOUTER LE CODE DE CONNECTION ICI

    $username = "root";
    $password = "";

    try {
        $conn = new PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', $username, $password);
        return $conn;

    } catch (PDOException $e) {
        return false;
    }
}

function template_header($title) {
  echo <<<EOT
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>$title</title>
      <link href="style.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
      <nav class="navtop">
        <div style="width:auto;">
          <a href="index.php" style="padding-left:20px;"><h1>Bibliothèque</h1></a>
          <a href="index.php"><i class="fas fa-home"></i>Accueil</a>
          <a href="adh-read.php"><i class="fas fa-address-book"></i>Adhérents</a>
          <a href="livre-read.php"><i class="fas fa-book"></i>Bibliothèque</a>
          <a href="empr-read.php"><i class="fas fa-book-reader"></i>Emprunts</a>
          <a href="rayon-read.php"><i class="fas fa-database"></i>Rayons</a>
          <a id="connected" href="user-login.php"><i class="fas fa-user"></i>Connexion</a>
          <a id="logout" href="user-logout.php"><i class="fas fa-sign-out-alt"></i>Déconnexion</a>
        </div>
      </nav>
  EOT;
}


/**
 * function permettant de printer la template de footer
 */
function template_footer() {
  $year = date("Y");
  echo <<<EOT
        <footer>
          <p>©$year biblio.nc</p>
        </footer>
      </body>
  </html>
  EOT;
}

function escape($valeur)
{
    // Convertit les caractères spéciaux en entités HTML
    return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
}

?>