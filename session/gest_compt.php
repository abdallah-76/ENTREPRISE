<!DOCTYPE html>
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
            $achuyi="Membre";

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
          if($userInfo["pfl_role"]=='G'){
              $lhalaw="Gestionnaire";
              $requeteprofile = "SELECT cpt_pseudo ,pfl_nom,pfl_prenom , pfl_validite , pfl_role ,pfl_date FROM t_profileutilisateur_pfl ;";//
            //$requeteNws = "SELECT new_titre,new_text,cpt_pseudo FROM t_news_new WHERE new_id>=(SELECT Max(new_id)-9 FROM t_news_new);";

            $resultProfils = $mysqli->query($requeteprofile);
            if ($resultProfils === false) {
                echo "Error: La requête a échoué \n";
                echo "Errno: " . $mysqli->errno . "\n";
                echo "Error: " . $mysqli->error . "\n";
                exit();
            } else {
                echo "<h1 style='color:rgb(33, 5, 216);'>Liste des Profils Utilisateur</h1>\n";
        
                echo '<table class="table table-striped table-dark table-hover table-bordered text-center align-middle">';
                echo '<thead class="table-dark">';
                echo '<tr>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color:rgb(44, 5, 216);">Nom</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Prénom</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Validité</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Statut</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Date de Création</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Pseudo du Compte</th>';
                echo '<th scope="col" class="bg-secondary fs-5" style="color: rgb(44, 5, 216);">Actions</th>';
        
                 // Ajout d'une colonne pour les actions
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
        
                while ($profil = $resultProfils->fetch_assoc()) {
        
                    if ($profil['pfl_role'] == 'R') {
                        $role = 'Rédacteur';
                    } else {
                        $role= 'Gestionnaire';
                    }
        
                    if ($profil['pfl_validite'] == 'A') {
                        $validite = 'Activé';
                    } else {
                        $validite = 'Désactivé';
                    }
        
                    echo '<tr>';
                    echo '<td class="text-white">' . $profil['pfl_nom'] . '</td>';
                    echo '<td class="text-white">' . $profil['pfl_prenom'] . '</td>';
                    echo '<td class="text-white">' . $validite . '</td>';
                    echo '<td class="text-white">' . $role. '</td>';
                    echo '<td class="text-white">' . $profil['pfl_date'] . '</td>';
                    echo '<td class="text-white">' . $profil['cpt_pseudo'] . '</td>';
                    echo '<td class="text-white">'; // Colonne des actions
                    echo '<form action="comptes_action.php" method="post">';
                    echo '<input type="hidden" name="pseudo" value="' . $profil['cpt_pseudo'] . '">';
                    echo '<input type="hidden" name="validite" value="' . $profil['pfl_validite'] . '">';
                    echo '<button type="submit" class="btn btn-sm btn-primary">Modifier validite </button>';
                    echo '</form>';
                    echo '</td>';
        
                    echo '</tr>';
                }
        
                echo '</tbody>';
                echo '</table>';
            }

            //nombre  actualité enligne  
              $requette_Nombre_profile="SELECT COUNT(*) AS nombre_de_profile FROM t_profileutilisateur_pfl ;";
              $result_Nombre_profil = $mysqli->query($requette_Nombre_profile);
              if ($result_Nombre_profil == false) {
                  echo "Error: La requête a échoué \n";
                  echo "Errno: " . $mysqli->errno . "\n";
                  echo "Error: " . $mysqli->error . "\n";
                  exit();
              } else {
                $row_profil = $result_Nombre_profil->fetch_assoc();
              $Nombre_profil=$row_profil['nombre_de_profile'];
              echo "<header class='align-center'>
                      <p class='special'>le nombre de profile est " . $Nombre_profil . "</p>
                    </header>";

}


          }else{
              $lhalaw="Membre";
              echo "Vous n'avez pas les droit sur les profile!.";
              

          }
      } else {
          echo "Erreur: Impossible de récupérer les informations de l'utilisateur.";
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
