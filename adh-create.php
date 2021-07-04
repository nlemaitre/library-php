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

	if (!empty($_POST)) {

        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

		$nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
		$prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
		$nbr_livresempr = isset($_POST['nbr_livresempr']) ? htmlspecialchars($_POST['nbr_livresempr']) : '';

		$pdo_stmt = $pdo->prepare('	INSERT INTO adherent VALUES (?, ?, ?, ?)');
									
		$pdo_stmt->execute([$id, $nom, $prenom, $nbr_livresempr]);
        $msg = 'Ajouté avec succès !';

        header('Location: adh-read.php');
        exit();
	}
?>

<?php echo template_header('Adh/Create'); ?>

	<div class="content create">
        <h2>Ajouter un nouvel adhérent :</h2>

        <form action="adh-create.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom">
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