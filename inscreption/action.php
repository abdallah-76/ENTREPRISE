<!DOCTYPE HTML>

<html>

<head><title>Hielo by TEMPLATED</title>
  <meta charset="utf-8">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body class="subpage">

	<!-- Header -->
	<header id="header">
		
		<div class="logo">
		<p></p>
			<a href="index.html">Hielo <span>by TEMPLATED</span></a>
		</div>
		<a href="#menu">Menu</a>
	</header>
	<!-- Nav -->
	<nav id="menu">
		<ul class="links">
			<li><a href="../index.php">Home</a></li>
			<li><a href="../generic.php">Generic</a></li>
			<li><a href="../elements.php">Elements</a></li>
			<li><a href="inscription.php">Inscription</a></li>

		</ul>
	</nav><!-- One -->
	<section id="One" class="wrapper style3">
		<div class="inner">
			<header class="align-center">
				<p>Sed amet nulla</p>
				<h2>Inscription</h2>
			</header>
		</div>
	</section><!-- Main -->
	<div id="main" class="container">
		// <!--elements saisis dans le formulaire :-->


	
		<?php
		$pseudo= htmlspecialchars(addslashes($_POST['pseudo']));
		$password = htmlspecialchars(addslashes($_POST['mdp']));
		$name = htmlspecialchars(addslashes($_POST['nom']));
		$last_name = htmlspecialchars(addslashes($_POST['prenom']));
		$email = htmlspecialchars(addslashes($_POST['email']));
		$password_confermation = htmlspecialchars(addslashes($_POST['mdp2']));
		$code = htmlspecialchars(addslashes($_POST['code']));
     // Connexion à la base de données
         $servername = "localhost";
         $username = "e22308154sql";
         $password1 = "8eiFE5BT";
         $dbname = "e22308154_db2";
 
         $mysqli = new mysqli($servername, $username, $password1, $dbname);
         //$mysqli = new mysqli('localhost', 'e22308154sql', '8eiFE5BT', 'e22308154_db2');

		if ($mysqli->connect_errno) {
			// Affichage d'un message d'erreur
			echo "Error: Problème de connexion à la BDD \n";
			echo "Errno: " . $mysqli->connect_errno . "\n";
			echo "Error: " . $mysqli->connect_error . "\n";
			// Arrêt du chargement de la page
			exit();
		}
		//echo ("Connexion BDD réussie !");
		// Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
		if (!$mysqli->set_charset("utf8")) {
			printf("Pb de chargement du jeu de car. utf8 : %s\n", $mysqli->error);
			exit();
		}
		if ($pseudo == "" || $password == "" || $name == "" || $last_name == "" || $email == ""  || $password_confermation == "" || $code == "") {
			echo "rempliser toutles champ";
			echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
			exit;
		} else {
			 // Requête de obtention du code de confiermation 
			 $requetcodeconfirmation="SELECT cfg_code AS Bon_code_de_confirmation FROM t_config_cfg";
			 $result_codeconfirmation = $mysqli->query($requetcodeconfirmation);
			if ($result_codeconfirmation == false) {
				   echo "Error: La requête a échoué \n";
				   echo "Errno: " . $mysqli->errno . "\n";
				   echo "Error: " . $mysqli->error . "\n";
				   exit();
		   } else {
			   $row_codeconfirmation = $result_codeconfirmation->fetch_assoc();
			   $Bon_code_de_confirmation=$row_codeconfirmation['Bon_code_de_confirmation'];

		   }
		   if ($Bon_code_de_confirmation == $code && $password == $password_confermation) {
			if($password == $password_confermation) {
				// tester le psudo ou le nom du prpfis sont deja pris 
				$sqltst = "SELECT cpt_pseudo FROM t_compt_cpt WHERE cpt_pseudo = '$pseudo'UNION 
				SELECT pfl_nom FROM t_profileutilisateur_pfl WHERE pfl_nom = '$name' AND pfl_prenom = '$last_name';";
   				$resulttst = $mysqli->query($sqltst);

   				if ($resulttst && $resulttst->num_rows > 0) {
	   				echo "Erreur : L'identifiant, le nom ou le prénom existe déjà dans la base de données.";
	   				echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
	  				exit;
   				}
								   // Requête d'insertion du compte utilisateur
								   $requete_compte = "INSERT INTO t_compt_cpt (cpt_pseudo, cpt_motdepass) VALUES ('$pseudo', MD5('$password'));";

								   //cpt_motdepass = MD5('" . $motdepasse . "')
								   
								   // Exécution de la requête pour le compte utilisateur
								   if ($mysqli->query($requete_compte) === TRUE) {
										   // Requête d'insertion du profil utilisateur
										   $requete_profil = "INSERT INTO t_profileutilisateur_pfl (pfl_nom, pfl_prenom, pfl_validite, pfl_role, pfl_date, cpt_pseudo, pfl_email ) VALUES ('$name', '$last_name', 'D', 'R', NOW(),'$pseudo', '$email')";
					 
										   // Exécution de la requête pour le profil utilisateur
										   if ($mysqli->query($requete_profil) === TRUE) {
												   echo '<div class="alert alert-success text-center" role="alert">';
												   echo "Inscription réussie.";
												   echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
												   echo '</div>';            
										   }else {
												   // Suppression du compte utilisateur en cas d'échec d'insertion du profil
												  $mysqli->query("DELETE FROM t_compt_cpt WHERE cpt_pseudo='$pseudo'");
					 
												   //Si la requête n'est pas de type POST, afficher un message d'erreur
												  echo '<div class="alert alert-danger text-center" role="alert">';
												   echo "Erreur lors de l'insertion du profil: ". $mysqli->error;
												   echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
												   echo '</div>';
					 
										   }
								   } else {
										   echo '<div class="alert alert-danger text-center" role="alert">';
										   echo "Erreur lors de l'insertion du compte utilisateur: " . $mysqli->error;
										   echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
										   echo '</div>';
								   }
			}else{ echo '<div class="alert alert-danger text-center" role="alert">';
				echo "les mot de pass ne sont pas identique: " . $mysqli->error;
				echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
				echo '</div>';}

		   

		   } else {
				   echo '<div class="alert alert-danger text-center" role="alert">';
						   echo "Mauvais Code de Confirmation: " . $mysqli->error;
						   echo "<br /><a href='inscreption.php'>Retour au formulaire</a>";
						   echo '</div>';

		   		} 
		 }
		//Ferme la connexion avec la base MariaDB
		$mysqli->close();
		?>










		<!-- Footer -->
		<footer id="footer">
    <div class="container">
      <ul class="icons">
        <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
        <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
      </ul>
    </div>
  </footer>
  <div class="copyright">
  </div>

		<!-- Scripts -->
		<script src="../assets/js/jquery.min.js"></script>
		<script src="../assets/js/jquery.scrollex.min.js"></script>
		<script src="../assets/js/skel.min.js"></script>
		<script src="../assets/js/util.js"></script>
		<script src="../assets/js/main.js"></script>
</body>

</html>