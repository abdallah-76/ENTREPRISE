<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['intitule'])) {


        $cat_intitule = $_POST['intitule'];
        
        $cpt_pseudo = $_SESSION['login'];

        $connexion = new mysqli('localhost', 'e22308154sql', '8eiFE5BT', 'e22308154_db2');
        if ($connexion->connect_error) {
            die("Erreur connexion BDD : " . $connexion->connect_error);
        }

        // Sécurisation
        $cat_intitule = $connexion->real_escape_string($cat_intitule);
        
        $cpt_pseudo = $connexion->real_escape_string($cpt_pseudo);

        // Vérifier si la catégorie existe
        $req = "SELECT COUNT(*) AS total FROM t_categorie_cat WHERE cat_initule = '$cat_intitule'";
        $result = $connexion->query($req);

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['total'] > 0) {
                echo " La catégorie existe déjà.<br>";

                // Récupérer son cat_num
                $resCat = $connexion->query("SELECT cat_num FROM t_categorie_cat WHERE cat_initule = '$cat_intitule' LIMIT 1");
                $catRow = $resCat->fetch_assoc();
                $cat_num = $catRow['cat_num'];
                 

            } else {
                echo " La catégorie n'existe pas, on l'ajoute.<br>";

                $connexion->query("INSERT INTO t_categorie_cat (cat_initule, cat_statu, cat_date)
                                   VALUES ('$cat_intitule', 'C', CURRENT_DATE)");

                // Récupérer le cat_num de la nouvelle catégorie
                $resCat = $connexion->query("SELECT cat_num FROM t_categorie_cat WHERE cat_initule = '$cat_intitule' ORDER BY cat_num DESC LIMIT 1");
                $catRow = $resCat->fetch_assoc();
                $cat_num = $catRow['cat_num'];
            }
            if( isset($_POST['texte'])&& !(empty($_POST['texte']))){
                $inf_texte = $_POST['texte'];
                $inf_texte = $connexion->real_escape_string($inf_texte);
                            // Insertion dans t_information_inf
                $reqInsert = "INSERT INTO t_information_inf (inf_text, cpt_pseudo, cat_num, inf_date, inf_etat)
                VALUES ('$inf_texte', '$cpt_pseudo', '$cat_num', CURDATE(), 'C')";
                if ($connexion->query($reqInsert)) {
                    echo "Information bien ajoutée.";
                    header("Location: gestion_cat.php");
                    
                } else {
                    echo " Erreur d'insertion de l'information : " . $connexion->error;

                }   
            }else{
    
                header("Location: gestion_cat.php");
            }



        } else {
            echo " Erreur dans la requête : " . $connexion->error;
        }

        $connexion->close();
    } else {
        echo " Formulaire incomplet.";
    }
}


?>