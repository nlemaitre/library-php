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

		$pdo_stmt = $pdo->prepare('SELECT * FROM adherent WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$adherent = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM adherent WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				header('Location: adh-read.php');
			} else {
				header('Location: adh-read.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Delete')?>

	<div class="container">
		<br><h2>Supprimer l'adherent #<?php echo $adherent['id'] ?></h2><br>

		<p>Souhaitez-vous vraiment supprimer l'adhérent #<?php echo $adherent['id'] ?> (<?php echo $adherent['nom'] ?> <?php echo $adherent['prenom'] ?>) ?</p><br>

		<a href="adh-delete.php?id=<?php echo $adherent['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="adh-delete.php?id=<?php echo $adherent['id'] ?>&confirm=no" class="btn btn-danger">Non</a>
	</div>

<?php echo template_footer()?>