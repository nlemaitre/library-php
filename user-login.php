<?php
    include 'functions_custom.php';

    $pdo = pdo_connect_mysql();

    session_start();

    if (isset($_SESSION['nom_utilisateur']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_utilisateur'] ."</div>";
        echo "<style>#connected { display:none; }</style>";
    } else {
        echo "<style>#logout { display:none; }</style>";
    }

        $pdo = pdo_connect_mysql();
        $msg = '';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
    </head>

    <body>
        <?php 
        echo template_header('Connexion'); ?>

        <div class="container">
            <h1 style="margin-top:50px;margin-bottom:20px;">Connexion</h1>

            <form class="form" action="user-login-post.php" method="post" style="width:400px;">
                <div class="form-group">
                    <label for="nom">Nom d'utilisateur :</label>
                    <input type="text" class="form-control" name="nom_utilisateur" id="nom" required />
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" required />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Connexion">
                </div>
            </form>
        </div>
    
        <?php echo template_footer(); ?>
    </body>
</html>
