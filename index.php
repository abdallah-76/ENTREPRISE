<!-- 
******************************************************************
FICHIER : index.php
AUTEUR : TOUBAL Karim
DATE DE CRÉATION : 2020-03-20
DESCRIPTION : Page d'accueil du site Web.

COMMENTAIRE :
-----------------------------------------------------------------------
Cette page contient la structure de la page d'accueil du site. Elle est la premére version de l aplication 

TOUBAL Karim
karim.toubal@etudiant.univ-brest.fr
***********************************************************************
-->
<!DOCTYPE HTML>
<html><head><title>Hielo by TEMPLATED</title><meta charset="utf-8"><meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="assets/css/main.css"></head>
<body>
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
//nombre  actualité enligne  
$requette_Nombre_news="SELECT COUNT(*) AS nombre_news_actifs FROM t_news_new WHERE new_etat='E'; ";
$result_Nombre_news = $mysqli->query($requette_Nombre_news);
if ($result_Nombre_news == false) {
    echo "Error: La requête a échoué \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit();
} else {
	$row_news = $result_Nombre_news->fetch_assoc();
$Nombre_news=$row_news['nombre_news_actifs'];
echo "<header class='align-center'>
        <p class='special'>le nombre d'actualité actif est " . $Nombre_news . "</p>
        <h2>Nos Actualités</h2>
      </header>";

}
// recupération du nom du devlopeur 
$requette_Nom_devlopeur="SELECT cfg_devName  AS Nom_devlopeur FROM t_config_cfg;  ";
$result_Nom_devlopeur = $mysqli->query($requette_Nom_devlopeur);
if ($result_Nom_devlopeur == false) {
    echo "Error: La requête a échoué \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit();
} else {
	$row_nom_devlopeur = $result_Nom_devlopeur->fetch_assoc();
	$Nom_devlopeur=$row_nom_devlopeur['Nom_devlopeur'];

}
//recupération du théme du projet 
$requette_Them_projet="SELECT cfg_theme  AS them FROM t_config_cfg;  ";
$result_Them_projet = $mysqli->query($requette_Them_projet);
if ($result_Them_projet == false) {
    echo "Error: La requête a échoué \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit();
} else {
	$row_them_projet = $result_Them_projet->fetch_assoc();
	$them_projet=$row_them_projet['them'];
}
//recupération de la date de creationdu projet 
$requette_Date_creation="SELECT cfg_date  AS date_creation FROM t_config_cfg;  ";
$result_Date_creation = $mysqli->query($requette_Date_creation);
if ($result_Date_creation == false) {
    echo "Error: La requête a échoué \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit();
} else {
	$row_Date_creation = $result_Date_creation->fetch_assoc();
	$date_creation=$row_Date_creation['date_creation'];

}
?>

		<!-- Header -->
			<header id="header" class="alt"><div class="logo"><a href="#">Hielo <span>by TEMPLATED</span></a></div>
				<a href="#menu">Menu</a>
			</header><!-- Nav --><nav id="menu"><ul class="links"><li><a href="#">Home</a></li>
					<li><a href="affichage3/afichecat.php?indice=0">Affichage</a></li>
					<li><a href="inscreption/inscreption.php">Inscription</a></li>
					<li><a href="session/session.php">Connexion</a></li>
				</ul></nav><!-- Banner --><section class="banner full"><article><img src="images/slide01.jpg" alt="" width="1440" height="961"><div class="inner">
						<header><p>Project Info-Screen </p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="images/slide02.jpg" alt="" width="1440" height="961"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="images/slide03.jpg" alt="" width="1440" height="962"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="images/slide04.jpg" alt="" width="1440" height="961"><div class="inner">
						<header><p>Project Info-Screen</p>
							<h2><?php echo $them_projet ?></h2>
						</header></div>
				</article><article><img src="images/slide05.jpg" alt="" width="1440" height="962"><div class="inner">
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
//On insère une ligne dans la table gérant les comptes des utilisateurs
//$requete2="INSERT INTO t_compt_cpt (cpt_pseudo,cpt_motdepass) VALUES ('tux',MD5('tux1234'));";
//echo ($requete2);

// Préparation de la requête récupérant les 10 actualités les plus récentes
$requeteNws = "SELECT * FROM t_news_new WHERE new_etat='E'ORDER BY new_date DESC LIMIT 10;";//
//$requeteNws = "SELECT new_titre,new_text,cpt_pseudo FROM t_news_new WHERE new_id>=(SELECT Max(new_id)-9 FROM t_news_new);";

$resultNews = $mysqli->query($requeteNws);
if ($resultNews == false) {
    echo "Error: La requête a échoué \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit();
} else {
    echo '<table id="table-hover" class="table table-hover">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Titre</th>';
    echo '<th scope="col">Texte</th>';
    echo '<th scope="col">Auteur</th>';
    echo '<th scope="col">Date</th>'; // Ajout de la classe col-date
	echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while ($actu = $resultNews->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $actu['new_titre'] . '</td>';
        echo '<td>' . $actu['new_text'] . '</td>';
        echo '<td>' . $actu['cpt_pseudo'] . '</td>';
        echo '<td style="width: 100px;">' . $actu['new_date'] . '</td>'; // Ajustez la largeur selon vos préférences
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table></div>';
}


    

// Ferme la connexion avec la base MariaDB

					
					
						
					
				
				$mysqli->close();
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
			<script src="assets/js/jquery.min.js"></script><script src="assets/js/jquery.scrollex.min.js"></script><script src="assets/js/skel.min.js"></script><script src="assets/js/util.js"></script><script src="assets/js/main.js"></script></body></html>
