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

		$id_livre = isset($_POST['id_livre']) ? htmlspecialchars($_POST['id_livre']) : '';
		$id_adherent = isset($_POST['id_adherent']) ? htmlspecialchars($_POST['id_adherent']) : '';
		$date_emprunt = isset($_POST['date_emprunt']) ? htmlspecialchars($_POST['date_emprunt']) : date('j F Y');
		$date_retourmax = isset($_POST['date_retourmax']) ? htmlspecialchars($_POST['date_retourmax']) : date('j F Y');
        $date_retour = isset($_POST['date_retour']) ? htmlspecialchars($_POST['date_retour']) : date('j F Y');

		$pdo_stmt = $pdo->prepare('INSERT INTO emprunt VALUES (?, ?, ?, ?, ?, ?)');
									
		$pdo_stmt->execute([$id, $id_livre, $id_adherent, $date_emprunt, $date_retourmax, $date_retour]);

        $msg = 'Ajouté avec succès !';

        header('Location: empr-read.php');
        exit();
	}
?>

<?php echo template_header('Empr/Create'); ?>

	<div class="content create">
        <h2>Ajouter un nouvel emprunt :</h2>

        <form action="empr-create.php" method="POST">
            <div class="form-group">
                <label for="id_livre">Livre</label>
                <select name="id_livre" class="custom-select" id="id_livre" style="width:400px;display:block;">
                    <?php
                        $pdo_stmt = $pdo->prepare('SELECT livre.id, livre.titre, livre.auteur, livre.disponible FROM livre');

                        $pdo_stmt->execute();
                        while ($livres = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC))
                            foreach ($livres as $livre) :
                                if ($livre['disponible'] == 1) :
                                    echo "<option value=\"".$livre['id']."\">".$livre['id']." - ".$livre['titre']." (".$livre['auteur'].")</option>";
                                endif;
                            endforeach;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_adherent">Adhérent</label>
                <select name="id_adherent" class="custom-select" id="id_adherent" style="width:400px;display:block;">
                    <?php
                        $pdo_stmt = $pdo->prepare('SELECT adherent.id, adherent.prenom, adherent.nom, adherent.nbr_livresempr FROM adherent');

                        $pdo_stmt->execute();
                        while ($adherents = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC))
                            foreach ($adherents as $adherent) :
                                if ($adherent['nbr_livresempr'] < 5) :
                                    echo "<option value='".$adherent['id']."'>".$adherent['id']." - ".$adherent['prenom']." ".$adherent['nom']."</option>";
                                endif;
                            endforeach;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_emprunt">Date d'emprunt</label>
                <input type="date" class="form-control" name="date_emprunt" id="date_emprunt">
            </div>
            <div class="form-group">
                <label for="date_retourmax">Date de retour max</label>
                <input type="date" class="form-control" name="date_retourmax" id="date_retourmax">
            </div>
            <div class="form-group">
                <label for="date_retour">Date de retour</label>
                <input type="date" class="form-control" name="date_retour" id="date_retour">
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