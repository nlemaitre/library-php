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

	if (isset($_GET['id'])) {

		$pdo_stmt = $pdo->prepare('SELECT * FROM emprunt WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$emprunt = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (!$emprunt) {
			exit('Aucun emprunt n\'existe avec cet ID!');
		}

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM emprunt WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				$msg = 'Emprunt supprimé !';
			} else {
				header('Location: empr-read.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Delete')?>

	<div class="container">
		<br><h2>Supprimer l'emprunt #<?php echo $emprunt['id'] ?></h2><br>

		<?php if ($msg): ?>
		<p><?=$msg?></p>
		<?php else: ?>

		<p>Souhaitez-vous vraiment supprimer l'emprunt #<?php echo $emprunt['id'] ?> ?</p><br>

		<a href="empr-delete.php?id=<?php echo $emprunt['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="empr-delete.php?id=<?php echo $emprunt['id'] ?>&confirm=no" class="btn btn-danger">Non</a>

		<?php endif; ?>
	</div>

<?php echo template_footer()?>