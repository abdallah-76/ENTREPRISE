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
	color:red;
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
/* Affichage en titre de la catégorie PUIS redirection vers la page de la catégorie suivante */
echo ("<h3>2ème catégorie</h3>");
header("refresh:3;url=affichagecategorie3.php");
?>

</div>
</body>
</html>
