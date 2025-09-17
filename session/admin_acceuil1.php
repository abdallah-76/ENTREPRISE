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
      background-color: #f8f9fa;
    }
    .design-block {
      margin-top: 40px;
    }
    .user-info {
      background-color: #ffffff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 0 auto;
      text-align: center;
    }
    .user-info i {
      color: #0d6efd;
      margin-bottom: 20px;
    }
    .user-info h4 {
      margin-top: 10px;
    }
    .user-info span {
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">AdminPanel</a>
    <span class="navbar-text text-light">
      <?php echo ucfirst($achuyi); ?>
    </span>
  </div>
</nav>

<!-- Contenu principal -->
<div class="container design-block">
  <h1 class="text-center mb-5">ESPACE ADMINISTRATION</h1>

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
          }else{
              $lhalaw="Membre";

          }
          // Affichage des informations de l'utilisateur avec l'icône de personne
          echo "<div class='user-info'>";
          echo "<i class='fas fa-user fa-6x'></i>"; // Icône de personne
          echo "<h4 class='mb-3'>Bienvenue, " . $userInfo["pfl_nom"] . " " . $userInfo["pfl_prenom"] . "!</h4>";
          echo "<p class='mb-0'>Validité: <span>" .  $amekakken . "</span></p>";
          echo "<p class='mb-0'>Statut: <span>" .$lhalaw . "</span></p>";
          echo "<p class='mb-0'>Date de création: <span>" . $userInfo["pfl_date"] . "</span></p>";
          echo "</div>";
      } else {
          echo "Erreur: Impossible de récupérer les informations de l'utilisateur.";
      }

      // Fermeture de la connexion avec la base de données
  } else {
      echo "Vous n'êtes pas connecté.";
  }
?>
</div>

<!-- Bootstrap JS (facultatif si pas besoin d’interactivité JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
