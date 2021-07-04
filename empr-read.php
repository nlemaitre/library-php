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

    $pdo_stmt = $pdo->prepare(' SELECT  emprunt.id, 
                                        livre.titre, 
                                        adherent.prenom, 
                                        adherent.nom, 
                                        emprunt.date_emprunt, 
                                        emprunt.date_retourmax, 
                                        emprunt.date_retour 
                                FROM    emprunt 
                                JOIN    livre 
                                ON      emprunt.id_livre = livre.id 
                                JOIN    adherent 
                                ON      emprunt.id_adherent = adherent.id');
    $pdo_stmt->execute();

    $emprunts = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Read'); ?>

    <div class="content read">

        <div><h2>Liste complète des emprunts</h2> 
        <span><a href="empr-create.php" class="add"><i class="fas fa-plus-square fa-xs"></i></a></span></div>

        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Livre</td>
                    <td>Adhérent</td>
                    <td>Date d'emprunt</td>
                    <td>Date de retour max</td>
                    <td>Date de retour</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprunts as $emprunt) : ?>
                <tr>
                    <td><?php echo $emprunt["id"] ?></td>
                    <td><?php echo $emprunt["titre"] ?></td>
                    <td><?php echo $emprunt["prenom"] ." ". $emprunt["nom"] ?></td>
                    <td><?php echo date("d/m/y", strtotime($emprunt["date_emprunt"])) ?></td>
                    <td><?php echo date("d/m/y", strtotime($emprunt["date_retourmax"])) ?></td>
                    <td>
                        <?php 
                            if ($emprunt["date_retour"] == NULL OR $emprunt["date_retour"] == "0000-00-00" OR $emprunt["date_retour"] > date("Y-m-d")):
                                echo "Pas encore rendu";
                            else :
                                echo date("d/m/y", strtotime($emprunt["date_retour"]));
                            endif;
                        ?>
                    </td>
                    <td class="actions">
                        <a href="empr-update.php?id=<?php echo $emprunt["id"] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="empr-delete.php?id=<?php echo $emprunt["id"] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

<?php echo template_footer(); ?>