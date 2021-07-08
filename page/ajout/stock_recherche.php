<?php

extract($_POST);
if (isset($_POST['idModele']) == true && $_POST['idModele'] > 0 && $type == true) {


    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
    try {
        // Nous vérifions le type d'intervention sélectionner puis nous récupérons les données correspondant
        // Pour la batterie nous avons besoin seulement du modèle
        if ($type == 'B') {
            $lesEnregs = $bdd->query("select id,nom, nbStockBatterie,prix_achat from modele where id = " . $_POST['idModele'] . ";");
        }
        // Pour l'écran nous avons besoin du modèle et de la couleur d'écran
        if ($type == 'E' && $idModele == true && $idCouleur > 0) {
            $lesEcrans = $bdd->query("select id_modele, id_ecran,prix_achat, nombreStock from modele_ecran where id_modele = " . $idModele . " and id_ecran =" . $idCouleur . "");
        } elseif ($type == 'E') {
            echo "<p style= 'color : red;'>Veuillez renseignez une couleur d'écran</p>";
            $lesEcrans = "";
        }
        // De même pour les vitres arrières
        if ($type == 'V' && $idCouleur == true && $idCouleur > 0) {
            $lesVitres = $bdd->query("select id_modele, id_vitreArriere,prix_achat, nombreStock from modele_vitrearriere where id_modele = " . $idModele . " and id_vitreArriere =" . $idCouleur . "");
        } elseif ($type == 'V') {
            echo "<p style= 'color : red;'>Veuillez renseignez une couleur de vitre arrière</p>";
        }
    } catch (PDOException $e) {
        die("Err BDselect : erreur de lecture table modele dans index.php<br>Message d'erreur :" . $e->getMessage());
    }



    if ($type == 'B') {
        foreach ($lesEnregs as $enreg) {
            echo "<p> Stock de batterie pour ce modèle =  $enreg->nbStockBatterie, prix d'achat = $enreg->prix_achat €</p>";
        }
    }
    if ($type == 'E' && $idCouleur > 0) {
        foreach ($lesEcrans as $enreg) {
            if ($enreg->nombreStock > 0 && $enreg->nombreStock == true) {
                echo "<p> Stock d'écran pour ce modèle =  $enreg->nombreStock, prix d'achat = $enreg->prix_achat €</p>";
            } else {
                echo "<p style= 'color : red;>Pas de stock pour ce modèle</p>";
            }
        }
    } elseif ($type == 'E') {
    }
    if ($type == 'V' && $idCouleur > 0) {
        foreach ($lesVitres as $enreg) {
            if ($enreg->nombreStock > 0 && $enreg->nombreStock == true) {
                echo "<p> Stock de vitre pour ce modèle =  $enreg->nombreStock, prix d'achat = $enreg->prix_achat €</p>";
            } else {
                echo "<p style= 'color : red; >Pas de stock pour ce modèle</p>";
            }
        }
    } elseif ($type == 'V') {
        echo "<p style= 'color : red;>Pas de stock pour ce modèle</p>";
    }
} else {
    echo " <p>Pas de stock renseigner pour ce modèle</p> ";
}
