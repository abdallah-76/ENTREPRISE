<?php
// Assurez-vous que la session est démarrée
session_start();

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que le pseudo et la validité ont été envoyés
    if ( isset($_POST['cat_id'])) {
        // Récupérez le pseudo et la validité du formulaire
        $cat_id = $_POST['cat_id'];
        // Assurez-vous d'avoir une connexion à la base de données
        $connexion = new mysqli('localhost', 'e22308154sql', '8eiFE5BT', 'e22308154_db2');

        // Vérification de la connexion
        if ($connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }
        // Suppression de toutes les informations liées à la catégorie
         $query_info = "DELETE FROM t_information_inf WHERE cat_num = $cat_id";
        $query_assc = "DELETE FROM t_association_assc WHERE cat_num = $cat_id";
        $query_cat  = "DELETE FROM t_categorie_cat WHERE cat_num = $cat_id";
 
            $result1 = $connexion->query($query_info);
            $result2 = $connexion->query($query_assc);
            $result3 = $connexion->query($query_cat);
            if (!($result1&& $result2 && $result3)) {
                echo "Error: La requête a échoué \n";
                echo "Errno: " . $connexion->errno . "\n";
                echo "Error: " . $connexion->error . "\n";
                exit();
            } else {
                header("Location: gestion_cat.php");
            }



        // Fermez la connexion avec la base de données
        $connexion->close();
    } else {
        // Redirigez l'utilisateur avec un message d'erreur si le pseudo ou la validité n'ont pas été envoyés
        header("Location: gestion_cat.php");
        exit();
    }
} else {
    // Redirigez l'utilisateur si le formulaire n'a pas été soumis
    header("Location: gestion_cat.php");
    exit();
}
?>