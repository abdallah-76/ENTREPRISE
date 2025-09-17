<?php
// Assurez-vous que la session est démarrée
session_start();

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que le pseudo et la validité ont été envoyés
    if (isset($_POST['pseudo']) && isset($_POST['validite'])) {
        // Récupérez le pseudo et la validité du formulaire
        $pseudo = $_POST['pseudo'];
        $validite_prec = $_POST['validite'];

        // Déterminez la nouvelle valeur de validité en fonction de l'état précédent
        $vival1 = ($validite_prec == 'A') ? 'D' : 'A';

        // Assurez-vous d'avoir une connexion à la base de données
        $connexion = new mysqli('localhost', 'e22308154sql', '8eiFE5BT', 'e22308154_db2');

        // Vérification de la connexion
        if ($connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }

        // Préparez et exécutez la requête pour mettre à jour la validité dans la base de données
        $sql1 = "UPDATE t_profileutilisateur_pfl SET pfl_validite = '$vival1' WHERE cpt_pseudo = '$pseudo'";
            // recupération du nom du devlopeur 
            $result = $connexion->query($sql1);
            if ($result== false) {
                echo "Error: La requête a échoué \n";
                echo "Errno: " . $connexion->errno . "\n";
                echo "Error: " . $connexion->error . "\n";
                exit();
            } else {
                header("Location: gest_compt.php");
            }



        // Fermez la connexion avec la base de données
        $connexion->close();
    } else {
        // Redirigez l'utilisateur avec un message d'erreur si le pseudo ou la validité n'ont pas été envoyés
        header("Location: admin_acceuil.php?erreur=donnees_manquantes");
        exit();
    }
} else {
    // Redirigez l'utilisateur si le formulaire n'a pas été soumis
    header("Location: admin_acceuil.php");
    exit();
}
?>