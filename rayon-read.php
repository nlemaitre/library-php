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

$pdo_stmt = $pdo->prepare('SELECT * FROM rayon');
$pdo_stmt->execute();

$rayons = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Read'); ?>

<div class="content read">

	<div><h2>Liste des rayons de la bibliotheque</h2> 
    <span><a href="rayon-create.php" class="add"><i class="fas fa-plus-square fa-xs"></i></a></span></div>

	<table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>Nom</td>
                <td>Référence</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rayons as $rayon) : ?>
            <tr>
                <td><?php echo $rayon["id"] ?></td>
                <td><?php echo $rayon["nom"] ?></td>
                <td><?php echo $rayon["reference"] ?></td>
                <td class="actions">
                    <a href="rayon-update.php?id=<?php echo $rayon["id"] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="rayon-delete.php?id=<?php echo $rayon["id"] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<?php echo template_footer(); ?>