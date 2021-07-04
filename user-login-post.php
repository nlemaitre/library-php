<?php
session_start();

if (isset($_POST['nom_utilisateur']) && isset($_POST['mdp'])) {
    require 'functions_custom.php';
    $bdd = pdo_connect_mysql();

    $requete = "SELECT * FROM utilisateur WHERE BINARY nom_utilisateur = ? AND mdp = ?";
    $resultat = $bdd->prepare($requete);

    $login = $_POST['nom_utilisateur'];
    $mdp = $_POST['mdp'];

    $resultat->execute(array($login, $mdp));

    if ($resultat->rowCount() == 1) {
        $_SESSION['nom_utilisateur'] = $login;
        $_SESSION['mdp'] = $mdp;
        $authOK = true;
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Résultat de l'authentification</title>
    </head>

    <body>
        <?php echo template_header('Authentification'); ?>

        <div class="container">
            <h1 style="margin-top:50px;margin-bottom:20px;">Résultat de l'authentification</h1>

            <?php
            if (isset($authOK)) {
                echo "<p>Vous avez été reconnu(e) en tant que <b>" . escape($login) . "</b>.</p>";
                echo '<a href="index.php">Poursuivre vers la page d\'accueil</a>';
            }
            else { ?>
                <p>Vous n'avez pas été reconnu(e)</p>
                <p><a href="user-login.php">Nouvel essai</p>
            <?php } ?>
        </div>

        <?php echo template_footer(); ?>
    </body>
</html>