<?php
    include 'functions_custom.php';

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

    $pdo = pdo_connect_mysql();

    if (isset($_GET['id'])) {
        if (!empty($_POST)) {
            
            $id = $_GET['id'];

            $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
		    $reference = isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : '';

            $pdo_stmt = $pdo->prepare('UPDATE rayon SET id = ?, nom = ?, reference = ? WHERE id = ?');
            $pdo_stmt->execute([$id, $nom, $reference, $_GET['id']]);

            header('Location: rayon-read.php');
            exit();
        }

        $pdo_stmt = $pdo->prepare('SELECT * FROM rayon WHERE id = ?');
        $pdo_stmt->execute([$_GET['id']]);
        $rayon = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

    } else {
            exit('Pas d\'ID spécifié');
    }
?>

<?php echo template_header('Update'); ?>

    <div class="content update">
        <h2>Modifier les informations du rayon #<?php echo $rayon['id'] ?> (<?php echo $rayon['nom']?>) :</h2>

        <form action="rayon-update.php?id=<?php echo $rayon["id"] ?>" method="POST" style="display:block">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" value="<?php echo $rayon['nom']?>" id="nom">
            </div>
            <div class="form-group">
                <label for="name">Référence</label>
                <input type="text" class="form-control" name="reference" value="<?php echo $rayon['reference']?>" id="reference">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>

<?php echo template_footer(); ?>