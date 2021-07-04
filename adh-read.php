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

$pdo_stmt = $pdo->prepare('SELECT * FROM adherent');
$pdo_stmt->execute();

$adherents = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Read'); ?>

<div class="content read">

	<div><h2>Liste des adhérents de la bibliotheque</h2> 
    <span><a href="adh-create.php" class="add"><i class="fas fa-plus-square fa-xs"></i></a></span></div>

	<table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Nombre de livres empruntés</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adherents as $adherent) : ?>
            <tr>
                <td><?php echo $adherent["id"] ?></td>
                <td><?php echo $adherent["nom"] ?></td>
                <td><?php echo $adherent["prenom"] ?></td>
                <td>
                    <?php 
                        $pdo_stmt = $pdo->prepare('SELECT id, id_adherent, COUNT(*) AS nbr_livres FROM emprunt GROUP BY id_adherent');
                        $pdo_stmt->execute();

                        while ($livres = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC))
                            foreach ($livres as $livre) :
                                if ($livre['id_adherent'] == $adherent["id"]) : echo $livre['nbr_livres'];
                                else : echo '0';
                                endif;
                            endforeach;
                    ?>
                </td>
                <td class="actions">
                    <a href="adh-update.php?id=<?php echo $adherent["id"] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="adh-delete.php?id=<?php echo $adherent["id"] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<?php echo template_footer(); ?>