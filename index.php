<?php
	include 'functions_custom.php';

	session_start();

	if (isset($_SESSION['nom_utilisateur']) && isset($_SESSION['mdp'])) {
		$mdp = $_SESSION['mdp'];
		echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_utilisateur'] ."</div>";
		echo "<style>#connected { display:none; }</style>";
	} else {
		echo "<style>#logout { display:none; }</style>";
		echo "<style>#addLoan { display:none; }</style>";
	}
?>

<?php echo template_header('Home'); ?>

<div class="container">
	<br><h1 style="padding-top:5px;text-align:center;color:grey;">Accueil</h1><br>

	<br><div class="home-buttons">
		<div class="home-livre">
			<i class="fas fa-book fa-2x"><br><h3>Catalogue</h3></i><br><br>
			<a type="button" class="btn btn-info" href="livre-read.php"><h5>Consulter la liste des livres</h5></a><br>
			<a type="button" class="btn btn-success" href="livre-create.php"><h5>Ajouter un livre</h5></a>
		</div>
		<div class="home-adh">
			<i class="fas fa-address-book fa-2x"><br><h3>Adhérents</h3></i><br><br>
			<a type="button" class="btn btn-info" href="adh-read.php"><h5>Je recherche un adhérent</h5></a><br>
			<a type="button" class="btn btn-success" href="adh-create.php"><h5>Ajouter un nouvel adhérent</h5></a>
		</div>
		<div class="home-empr">
			<i class="fas fa-book-reader fa-2x"><br><h3>Emprunts</h3></i><br><br>
			<a type="button" class="btn btn-info" href="empr-read.php"><h5>Consult Loans</h5></a><br>
			<a id="addLoan" type="button" class="btn btn-success" href="empr-create.php"><h5>Add New Loan</h5></a>
		</div>
		<div class="home-rayon">
			<i class="fas fa-database fa-2x"><br><h3>Rayons</h3></i><br><br>
			<a type="button" class="btn btn-info" href="rayon-read.php"><h5>Les rayons de la Bibliothèque</h5></a><br>
			<a type="button" class="btn btn-success" href="rayon-create.php"><h5>Ajouter un nouveau rayon</h5></a>
		</div>
	</div>
</div>

<?php echo template_footer(); ?>
