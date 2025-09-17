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
		 //Ouverture d'une session
         session_start();
         /*Affectation dans des variables du pseudo/mot de passe s'ils existent,
         affichage d'un message sinon*/
         if(empty($_POST["pseudo"])){
           echo "<div class='row justify-content-center mb-5' style='padding: 0 100px;'>";
           echo '<div class="container-fluid alert alert-danger text-center" role="alert">';
           echo "ERROR : Please Fill pseudo Input !";
           echo "<br /> <a href='../index.php' style='color:green;' class='alert-link'> Return to HOME page</a>";;
           echo '</div>';
           echo '</div>';
           exit();
         }
 
 
         if(empty($_POST["mdp"])){
           echo "<div class='row justify-content-center mb-5' style='padding: 0 100px;'>";
           echo '<div class="container-fluid alert alert-danger text-center" role="alert">';
           echo "ERROR : Please Fill PASSWORD Input !";
           echo "<br /> <a href='../index.php' style='color:green;' class='alert-link'> Return to HOME page</a>";;
           echo '</div>';
           echo '</div>';
           exit();
         }
        if ($_POST["pseudo"] && $_POST["mdp"]){
            $id = htmlspecialchars(addslashes($_POST["pseudo"]));
            $motdepasse = htmlspecialchars(addslashes($_POST["mdp"]));
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

             /* 1) Requête SQL n° 1) incomplète de recherche du compte utilisateur à partir
            des pseudo / mot de passe saisis */
            $sql="SELECT cpt_pseudo , cpt_motdepass , pfl_validite , pfl_role FROM t_compt_cpt INNER JOIN t_profileutilisateur_pfl USING(cpt_pseudo) WHERE
                cpt_pseudo='" . $id . "' AND cpt_motdepass = MD5('" . $motdepasse . "');";
            /* 1bis) A NOTER : on préparera plutôt une requête SQL n° 1bis) complète avec
            une jointure pour rechercher si un compte utilisateur valide ('A') existe dans
            la table des données des profils et récupérer aussi son rôle à partir des
            pseudo / mot de passe saisis */

            /* Exécution de la requête pour vérifier si le compte (=pseudo+mdp) existe !*/
            $resultat = $mysqli->query($sql);
            if ($resultat == false) {
                echo "<div class='row justify-content-center mb-5' style='padding: 0 100px;'>";
                echo '<div class="container-fluid alert alert-danger text-center" role="alert">';
                echo "Error: La requête a echoué \n";
                echo "Errno: " . $mysqli->errno . "\n";
                echo "Error: " . $mysqli->error . "\n";
                echo '</div>';
                echo '</div>';
                exit();
            }
            else {
                /* Dans le cas de la requête n° 1) non complétée ou n° 1bis), on teste si
                une ligne de résultat a été renvoyée, c'est à dire si le compte
                existe bien (n° 1)) et est activé (n° 1bis)) :
                */
                if($resultat->num_rows == 1) {
                $profil = $resultat->fetch_assoc();
                if($profil["pfl_validite"] != 'A'){
                    echo "<div class='row justify-content-center mb-5' style='padding: 0 100px;'>";
                    echo '<div class="container-fluid alert alert-danger text-center" role="alert">';
                    echo "ERROR : Your account is currently DISABLED. Please try again later !";
                    echo "<br /> <a href='../index.php' style='color:green;' class='alert-link'> Return to HOME page</a>";;
                    echo '</div>';
                    echo '</div>';
                    exit();
                }
                //Mise à jour des données de la session
                $_SESSION['login'] = $id;
                //affecter la valeur du rôle à $_SESSION['role']
                $_SESSION['role'] = $profil['pfl_role'];
                
                
                /* Redirection vers la page autorisée à cet utilisateur
                    ATTENTION !! Ne pas mettre d'appel d'echo() / de balise HTML
                    au-dessus de header() dans cette condition */
                header("Location:admin_acceuil.php");
                }
                else{
                    // aucune ligne retournée
                    // => le compte n'existe pas.
                    echo "<div class='row justify-content-center mb-5' style='padding: 0 100px;'>";
                    echo '<div class="container-fluid alert alert-danger text-center" role="alert">';
                    echo "ERROR : pseudo or mdp INCORRECT !";
                    echo "<br /> <a href='./session.php' style='color:green;' class='alert-link'> Return to log in page</a>";
                    echo '</div>';
                    echo '</div>';
                }
            
            }

            
            //Ferme la connexion avec la base MariaDB
            $mysqli->close();
        }
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