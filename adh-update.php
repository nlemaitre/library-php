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
        if (!empty($_POST)) {
            
            $id = $_GET['id'];
            $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
		    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
		    $nbr_livresempr = isset($_POST['nbr_livresempr']) ? htmlspecialchars($_POST['nbr_livresempr']) : '';

            $pdo_stmt = $pdo->prepare(' UPDATE  adherent 
                                        SET     id = ?, 
                                                nom = ?, 
                                                prenom = ?, 
                                                nbr_livresempr = ? 
                                        WHERE id = ?');

            $pdo_stmt->execute([$id, $nom, $prenom, $nbr_livresempr, $id]);
            $msg = 'Edité avec succès !';

            header('Location: adh-read.php');
            exit();
        }

        $pdo_stmt = $pdo->prepare('SELECT * FROM adherent WHERE id = ?');
        $pdo_stmt->execute([$_GET['id']]);
        $adherent = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$adherent) {
            exit('Aucun adhérent n\'existe avec cet ID !');
        }

    } else {
            exit('Pas d\'ID spécifié');
    }
?>

<?php echo template_header('Adh/Update'); ?>

    <div class="content update">
        <h2>Modifier les informations de l'adhérent #<?php echo $adherent['id'] ?> (<?php echo $adherent['prenom'] ?> <?php echo $adherent['nom'] ?>) :</h2>

        <form action="adh-update.php?id=<?php echo $adherent["id"] ?>" method="POST" style="display:block">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" value="<?php echo $adherent['nom'] ?>" id="nom">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" name="prenom" value="<?php echo $adherent['prenom'] ?>" id="prenom">
            </div>
            <div class="form-group">
                <label for="nbr_livresempr">Nombre de livres empruntés</label>

                <?php 
                        $pdo_stmt = $pdo->prepare('SELECT adherent.id, emprunt.date_retour, emprunt.id_adherent, COUNT(*) AS nbr_livres FROM emprunt LEFT JOIN adherent ON adherent.id = emprunt.id_adherent');
                        $pdo_stmt->execute();

                        while ($livres = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC))
                            foreach ($livres as $livre) :
                                if ($livre['id_adherent'] == $adherent["id"]) : 
                                    echo "<input type='text' class='form-control' name='nbr_livresempr' id='nbr_livresempr' value='". $livre['nbr_livres'] ."' readonly>";
                                else :
                                    echo "<input type='text' class='form-control' name='nbr_livresempr' id='nbr_livresempr' value='0' readonly>";
                                endif;
                            endforeach;
                    ?>

                <!--  <input type="text" class="form-control" name="nbr_livresempr" value="<?php echo $adherent['nbr_livresempr'] ?>" id="nbr_livresempr"> -->
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>

        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?php echo template_footer(); ?>