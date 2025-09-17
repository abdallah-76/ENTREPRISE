<section class="design-block" style="margin-bottom : 60px;">
      <?php
        //Ouverture d'une session
        session_start();
        if(!isset($_SESSION['login'])) { //A COMPLETER pour tester aussi le rôle...
            header("Location:session.php");

        }else{
       
        if ($_SESSION["role"]=='G'){
            $achuyi="Gesionnaire";
        }else{
            $achuyi="Rédacteur";

        }
           }

       // Connexion à la base de données
        $servername = "localhost";
        $username = "e22308154sql";
        $password1 = "8eiFE5BT";
        $dbname = "e22308154_db2";   
        $mysqli = new mysqli($servername, $username, $password1, $dbname);
                   //$mysqli = new mysqli('localhost', 'e22308154sql', '8eiFE5BT', 'e22308154_db2');
       

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
        // Instruction à rajouter depuis PHP 8.1
        mysqli_report(MYSQLI_REPORT_OFF); 
        // Utilisation de mysqli_real_escape_string pour prévenir les injections SQL
        $pseudo = $mysqli->real_escape_string($_SESSION['login']);


?>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Administration</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome pour l'icône utilisateur -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
  background-color: #f0f2f5;
}

.table th {
  background-color: #0d6efd;
  color: white;
}

.navbar {
  margin-bottom: 30px;
}

.card {
  border-radius: 10px;
}

.card-header h5 {
  font-weight: bold;
}
  </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Gestion des catégories</a>
    <a class="navbar-brand" href="admin_acceuil.php">Acceuil</a>
    <a class="navbar-brand" href="deconnexion.php">Déconnexion</a>
    <span class="navbar-text text-light">
      <?php echo ucfirst($achuyi); ?>
    </span>
  </div>
</nav>

<!-- Contenu principal -->
<div class="container design-block">
  <h1 class="text-center mb-5">ESPACE ADMINISTRATION</h1>
  <div class="card-body">
    <!-- Formulaire d'ajout de catégorie -->
    <div class="card">
        <div class="card-header">Ajouter une nouvelle catégorie</div>
        <div class="card-body">
            <form action="nouv_cat_inf.php" method="POST">
                <div class="mb-3">
                    <label for="intitule" class="form-label">Intitulé de la catégorie</label>
                    <input type="text" class="form-control" id="intitule" name="intitule" >
                </div>
                <div class="mb-3">
                    <label for="texte" class="form-label">Texte d'information</label>
                    <textarea class="form-control" id="texte" name="texte" rows="4" ></textarea>
                </div>
                <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

  </div>
  
  <div class="card-body">
    <!-- la table ici -->




  <?php
  
    
  // Vérification si l'utilisateur est connecté
  if(isset($_SESSION["login"])) {
    
      // Préparation de la requête pour récupérer les informations de l'utilisateur
      $requeteUserInfo="SELECT pfl_nom,pfl_prenom , pfl_validite , pfl_role ,pfl_date FROM t_profileutilisateur_pfl  WHERE
              cpt_pseudo='" . $_SESSION["login"] . "'";
      $resultUserInfo = $mysqli->query($requeteUserInfo);

      // Vérification s'il y a des résultats
      if ($resultUserInfo && $resultUserInfo->num_rows > 0) {
          // Récupération des informations de l'utilisateur
          $userInfo = $resultUserInfo->fetch_assoc();
          if ($userInfo["pfl_validite"]=='A'){
              $amekakken="Activé";
          }else{
              $amekakken="Désactivé";

          }
          if($userInfo["pfl_role"]=='G'||$userInfo["pfl_role"]=='R' ){
              $requetcategorie = "SELECT cat_num ,cat_statu,cat_date ,cat_initule FROM t_categorie_cat ;";//
            //$requeteNws = "SELECT new_titre,new_text,cpt_pseudo FROM t_news_new WHERE new_id>=(SELECT Max(new_id)-9 FROM t_news_new);";

            $resultcategorie = $mysqli->query($requetcategorie);
            if ($resultcategorie === false) {
                echo "Error: La requête a échoué \n";
                echo "Errno: " . $mysqli->errno . "\n";
                echo "Error: " . $mysqli->error . "\n";
                exit();
            } else {
                echo "<h1 style='color:rgb(33, 5, 216);'>Liste des Categorie</h1>\n";
        
                echo '<table class="table table-striped table-dark table-hover table-bordered text-center align-middle">';
                echo '<thead class="table-dark">';
                echo '<tr>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color:rgb(44, 5, 216);">ID</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Statu</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Date de Création</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Intitule</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Les Information</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Suprimer</th>';
        
                 // Ajout d'une colonne pour les actions
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
        
                while ($categorie = $resultcategorie->fetch_assoc()) {
        
                    echo '<tr>';
                    echo '<td class="text-white">' . $categorie['cat_num'] . '</td>';
                    echo '<td class="text-white">' . $categorie['cat_statu'] . '</td>';
                    echo '<td class="text-white">' . $categorie['cat_date'] . '</td>';
                    echo '<td class="text-white">' . $categorie['cat_initule'] . '</td>';
                    echo '<td class="text-white">'; // Colonne des actions
                    echo '<form action="cat_ende_tail.php" method="post">';
                    echo '<input type="hidden" name="cat_id" value="' . $categorie['cat_num'] . '">';
                    echo '<button type="submit" class="btn btn-sm btn-primary">détaille</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '<td class="text-white">'; // Colonne des actions
                    echo '<form action="cat_delete.php" method="post">';
                    echo '<input type="hidden" name="cat_id" value="' . $categorie['cat_num'] . '">';
                    echo '<button type="submit" class="btn btn-sm btn-danger">suprimer</button>';
                    echo '</form>';
                    echo '</td>';
        
                    echo '</tr>';
                }
        
                echo '</tbody>';
                echo '</table>';
            }


          }
      } else {
          echo "Erreur: Impossible de récupérer les Categorie.";
      }

      // Fermeture de la connexion avec la base de données
  } else {
      echo "Vous n'êtes pas connecté.";
  }
?>
</div>
</div>

<!-- Bootstrap JS (facultatif si pas besoin d’interactivité JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
