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

		$titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
		$auteur = isset($_POST['auteur']) ? htmlspecialchars($_POST['auteur']) : '';
		$disponible = isset($_POST['disponible']) ? htmlspecialchars($_POST['disponible']) : '';
		$id_rayon = isset($_POST['id_rayon']) ? htmlspecialchars($_POST['id_rayon']) : '';

		$pdo_stmt = $pdo->prepare('	INSERT INTO livre
									VALUES 	(?, ?, ?, ?, ?)');
									
		$pdo_stmt->execute([$id, $titre, $auteur, $disponible, $id_rayon]);

        $msg = 'Ajouté avec succès !';

        header('Location: livre-read.php');
        exit();
	}
?>

<?php echo template_header('Livre/Create'); ?>

	<div class="content create">
        <h2>Ajouter un nouvel ouvrage :</h2>

        <form action="livre-create.php" method="POST">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" name="titre" id="titre">
            </div>
            <div class="form-group">
                <label for="auteur">Auteur</label>
                <input type="text" class="form-control" name="auteur" id="auteur">
            </div>
            <div class="form-group">
                <label for="disponible">Disponible</label>
                <input type="number" class="form-control" name="disponible" id="disponible">
            </div>
            <div class="form-group">
                <label for="id_rayon">Rayon</label>
                <select class="custom-select" id="id_rayon" name="id_rayon" style="width:400px;display:block;">
                    <?php
                        $pdo_stmt = $pdo->prepare('SELECT rayon.id, rayon.nom FROM rayon');

                        $pdo_stmt->execute();
                        while ($rayons = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC))
                            foreach ($rayons as $rayon) :
                                echo "<option value=\"". $rayon['id'] ."\">". $rayon['id'] ." - ". $rayon['nom'] ."</option>";
                            endforeach;
                    ?>
                </select>
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