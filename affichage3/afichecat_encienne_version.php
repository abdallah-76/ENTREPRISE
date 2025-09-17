<!DOCTYPE html>
<!DOCTYPE HTML>
<html><head><title>Hielo by TEMPLATED</title><meta charset="utf-8"><meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../assets/css/main.css"></head>
<body>

<!-- Header -->
<header id="header" class="alt"><div class="logo"><a href="index.html">Hielo <span>by TEMPLATED</span></a></div>
				<a href="#menu">Menu</a>
			</header><!-- Nav --><nav id="menu"><ul class="links"><li><a href="index.html">Home</a></li>
					<li><a href="affichage1/affichagecategorie3.php">Affichage</a></li>
					<li><a href="inscreption/inscreption.php">Inscription</a></li>
				</ul></nav><!-- Banner --><section class="banner full"><article><img src="images/slide01.jpg" alt="" width="1440" height="961"><div class="inner">
						<header><p>Project Info-Screen </p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="../images/slide02.jpg" alt="" width="1440" height="961"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="../images/slide03.jpg" alt="" width="1440" height="962"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="../images/slide04.jpg" alt="" width="1440" height="961"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="../images/slide05.jpg" alt="" width="1440" height="962"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article></section>
				<!-- One -->
				<section id="one" class="wrapper style2"><div class="inner">
					<div class="grid-style">

					</div>
				</div>
			</section>
			<!-- Two -->
					
			
			<!-- Three -->
			<section id="three" class="wrapper style2"><div class="inner">

<?php
$mysqli = new mysqli('localhost', 'e22308154sql', '8eiFE5BT', 'e22308154_db2');
if ($mysqli->connect_errno) {
    echo "Error: Problème de connexion à la BDD \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit();
}

if (!$mysqli->set_charset("utf8")) {
    printf("Pb de chargement du jeu de car. utf8 : %s\n", $mysqli->error);
    exit();
}
if (isset($_GET['indice']) && is_numeric($_GET['indice']) && ($_GET['indice'] >= 0) && ($_GET['indice'] <= 8))
{
 echo ("Valeur de indice : ");
 echo ($_GET['indice']);
 echo ("<br />");
}
 else {
 echo ("Vous avez oublié de méttre l'indice ou l'indice est incompatible");
 exit();
}


// recupération de tout les id de mes catégorie 

$sql = "SELECT cat_num FROM t_categorie_cat";
$result = $mysqli->query($sql);
if ($result== false) {
    echo "Error: La requête a échoué \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit();
} else {
	$nb_categories = $result->num_rows;
                    
	// Boucle pour stocker les identifiants dans le tableau PHP
	for ($i = 0; $i < $nb_categories; $i++) {
		$cat = $result->fetch_assoc(); 
		$id[$i] = $cat['cat_num']; 
		echo ("<br />");
	}
	$cat_id = $id[$_GET['indice']];
	$requete1 = "SELECT * FROM t_categorie_cat WHERE cat_num=".$cat_id. ";";
	$result1 = $mysqli->query($requete1);
	
	// Vérification de la requête
	if ($result1== false) {
		echo "Error: La requête a échoué \n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit();
	}
	
	// Vérifier s'il y a des résultats
	if ($result1->num_rows > 0) {
		while ($nomcat = $result1->fetch_assoc()) {
			echo '<h3 style="color: white; text-align: center;">' . htmlspecialchars($nomcat['cat_initule']) . '</h3>'; 
		}
	} else {
		echo "Aucune catégorie trouvée.";
	}                   
	$requete = "SELECT * FROM t_information_inf JOIN t_categorie_cat USING(cat_num) WHERE cat_num=$cat_id";
					
		$result = $mysqli->query($requete);

		if ($result === false) {
			echo '<div class="alert alert-danger">Erreur : Impossible de récupérer les informations.</div>';
			echo '<p>Code erreur : ' . $mysqli->errno . '</p>';
			echo '<p>Détail : ' . $mysqli->error . '</p>';
			exit();
		}

		if ($result->num_rows > 0) {
			echo '<br /><br />';
			echo '<table class="table table-hover table-bordered table-striped table-dark">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Texte</th>';
			echo '<th>Catégorie</th>';
			echo '<th>Date</th>';
			echo '<th>Auteur</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			while ($actu = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($actu['inf_text']) . '</td>';
				echo '<td>' . htmlspecialchars($actu['cat_initule']) . '</td>';
				echo '<td>' . htmlspecialchars($actu['inf_date']) . '</td>';
				echo '<td>' . htmlspecialchars($actu['cpt_pseudo']) . '</td>';
				echo '</tr>';
			}

			echo '</tbody>';
			echo '</table>';
		} else {
			echo '<div class="alert alert-info">Aucune information disponible.</div>';
		}

		$numero=$_GET['indice']+1;
		
		
		if($nb_categories > $numero ){
			header("refresh:2;url=afichecat.php?indice=".$numero."");
			
		}else{
			header("refresh:2;url=afichecat.php?indice=0");
		}
		

}

?>
</section><!-- Footer --><footer id="footer"><div class="container">
					<ul class="icons"><li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-envelope-o"><span class="label">Mail</span></a></li>
					</ul></div>
			</footer><div class="copyright">
			Made by <a href="https://templated.co/"><?php echo $Nom_devlopeur ?> on <?php echo $date_creation ?> </a>.
		</div>
		

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script><script src="../assets/js/jquery.scrollex.min.js"></script><script src="../assets/js/skel.min.js"></script><script src="../assets/js/util.js"></script><script src="../assets/js/main.js"></script></body></html>
