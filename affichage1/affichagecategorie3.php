<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>InfoScreen </title>
<style>

	h1 {
	color:#006EAA;
	font-weight:bold;
	font-size:24pt;
	font-family:Arial, sans-serif;
	font-style:italic;
	}

	h3 {
	color:#006EFF;
	font-weight:bold;
	font-size:20pt;
	font-family:Arial, sans-serif;
	font-style:italic;
	color:blue;
	}

	body{
	display:flex;
	flex-direction:column;
	align-items:center;
	}

#navigation {
font-size:28pt;
color:black;
width:90%;
height:auto;
order:1;
background-color:white;
padding:10px;
font-family:Arial, sans-serif;
font-weight:bold;
}

#contenu {
width:90%;
height:auto;
order:2;
background-color:white;
padding:10px;
margin-top:40px;
}

</style>
</head>
<body>

<div id="navigation">
	Département Informatique
</div>


<div id="contenu">
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
	$cat_id = $id[2];
	$requete1 = "SELECT * FROM t_categorie_cat WHERE cat_num=$cat_id";
	$result1 = $mysqli->query($requete1);
	
	// Vérification de la requête
	if (!$result1) {
		die("Erreur SQL : " . $mysqli->error);
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
		header("refresh:5;url=affichagecategorie.php");

}

?>

</div>
</body>
</html>
