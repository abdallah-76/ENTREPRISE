<!DOCTYPE html>
<ht lang="fr">
<head>
  <meta charset="utf-8">
  <title>InfoScreen</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hielo by TEMPLATED</title>
  <meta charset="utf-8">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/main.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color:rgb(108, 114, 120);
    }
    #navigation {
      background-color: #ffffff;
      padding: 20px;
      text-align: center;
      font-size: 32px;
      font-weight: bold;
      color: #000;
      border-bottom: 3px solid #0d6efd;
    }
    .category-title {
      color: #0d6efd;
      text-align: center;
      margin-top: 30px;
      margin-bottom: 30px;
      font-size: 28px;
    }
    .container-custom {
      margin-top: 40px;
      max-width: 90%;
    }
  </style>
</head>



    Département Informatique
<header id="header" class="alt"><div class="logo"><a href="#"><span>Info</span></a></div>
				<a href="#menu">Menu</a>
</header>
<!-- Nav -->
<nav id="menu">
	<ul class="links">
		<li><a href="../index.php">Home</a></li>
		<li><a href="affichage3/afichecat.php?indice=0">Affichage</a></li>
		<li><a href="../inscreption/inscreption.php">Inscription</a></li>
	</ul>
</nav>
 

<div class="container container-custom">
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
 //echo ("Valeur de indice : ");
 //echo ($_GET['indice']);
 //echo ("<br />");
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
			echo '<h3 class="category-title">' . htmlspecialchars($nomcat['cat_initule']) . '</h3>';
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
			echo '<th>Date</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			while ($actu = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($actu['inf_text']) . '</td>';
				echo '<td>' . htmlspecialchars($actu['inf_date']) . '</td>';
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
  </div>

  <!-- Bootstrap JS (optionnel si tu veux des fonctionnalités JS comme dropdowns etc) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </section><!-- Footer --><footer id="footer"><div class="container">
					<ul class="icons"><li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-envelope-o"><span class="label">Mail</span></a></li>
					</ul></div>
			</footer><div class="copyright">
		</div>
		

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/skel.min.js"></script><script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

</body>
</html>
