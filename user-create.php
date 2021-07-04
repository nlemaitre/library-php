<?php
	include 'functions_custom.php';

    if (!empty($_POST)) {

        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

		$login = isset($_POST['nom_utilisateur']) ? htmlspecialchars($_POST['nom_utilisateur']) : '';
		$mdp = isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : '';

		$pdo_stmt = $pdo->prepare('	INSERT INTO utilisateur
									VALUES 	(?, ?, ?)');
									
		$pdo_stmt->execute([$id, $login, $mdp]);

        $msg = 'Ajouté avec succès !';

        header('Location: index.php');
        exit();
	}
?>