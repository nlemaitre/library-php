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
    $msg = '';

	if (!empty($_POST)) {

        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
		$nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
		$reference = isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : '';

		$pdo_stmt = $pdo->prepare('INSERT INTO rayon VALUES (?, ?, ?)');
									
		$pdo_stmt->execute([$id, $nom, $reference]);
        $msg = 'Ajouté avec succès !';

        header('Location: rayon-read.php');
        exit();
	}
?>

<?php echo template_header('Rayon/Create'); ?>

	<div class="content create">
        <h2>Ajouter un nouveau rayon à la bibliotheque :</h2>

        <form action="rayon-create.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom">
            </div>
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" class="form-control" name="reference" id="reference">
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-info" value="Ajouter">
            </div>
        </form>

        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>

    </div>

<?php echo template_footer(); ?>