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

		$pdo_stmt = $pdo->prepare('SELECT * FROM rayon WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$rayon = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM rayon WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				header('Location: rayon-read.php');
			} else {
				header('Location: rayon-read.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Delete')?>

	<div class="container">
		<br><h2>Supprimer le rayon #<?php echo $rayon['id'] ?></h2><br>

		<p>Souhaitez-vous vraiment supprimer le rayon #<?php echo $rayon['id'] ?> (<?php echo $rayon['nom'] ?>) ?</p><br>

		<a href="rayon-delete.php?id=<?php echo $rayon['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="rayon-delete.php?id=<?php echo $rayon['id'] ?>&confirm=no" class="btn btn-danger">Non</a>
	</div>

<?php echo template_footer()?>