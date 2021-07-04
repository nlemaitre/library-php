<?php
    include 'functions_custom.php';

    session_start();

    if (isset($_SESSION['nom_utilisateur']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_utilisateur'] ."</div>";
        echo "<style>#connected { display:none; }</style>";
    } else {
        echo "<style>#logout { display:none; }</style>";
        echo "<style>#addNewBook { display:none; }</style>";
        echo "<style>.actions { display:none; }</style>";
    }

        $pdo = pdo_connect_mysql();
        $msg = '';

    $pdo = pdo_connect_mysql();

    $pdo_stmt = $pdo->prepare(' SELECT  livre.id, 
                                        livre.titre, 
                                        livre.auteur, 
                                        livre.disponible, 
                                        rayon.nom 
                                FROM    livre 
                                LEFT JOIN rayon 
                                ON      livre.id_rayon = rayon.id');
                                
    $pdo_stmt->execute();

    $livres = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Livre/Read'); ?>

    <div class="content read">

        <h2>Liste des ouvrages de la bibliotheque</h2> 

        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Titre</td>
                    <td>Auteur</td>
                    <td>Disponible</td>
                    <td>Rayon</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livres as $livre) : ?>
                <tr>
                    <td><?php echo $livre["id"] ?></td>
                    <td><?php echo $livre["titre"] ?></td>
                    <td><?php echo $livre["auteur"] ?></td>
                    <td>
                        <?php 
                            if ($livre["disponible"] == 1) : echo "Oui";
                            else : echo "Non";
                            endif;
                        ?>
                    </td>
                    <td><?php echo $livre["nom"] ?></td>
                    <td class="actions">
                        <a href="livre-update.php?id=<?php echo $livre["id"] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="livre-delete.php?id=<?php echo $livre["id"] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>

    
            </tbody>
        </table>
        <span><a id="addNewBook" href="livre-create.php" class="add"><i class="fas fa-plus-square fa-xs"> Add a new Book</i></a></span>
    </div>

    

<?php echo template_footer(); ?>