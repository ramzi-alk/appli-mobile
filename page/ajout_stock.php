<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Ajout de stock </title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Ajout de stock vitre arrière</h2>
</div>
<section class="content">
    <div class="formulaire">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        if(isset($_POST['envoyer']) == true){
           
            try{
                
                 $req = $bdd->prepare("INSERT INTO `modele_vitrearriere` (`id_modele`, `id_vitreArriere`, `nombreStock`) VALUES (':par_nom, :par_couleur, :par_nbStock')");
                 
                 $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                 $req->bindValue(':par_couleur', $_POST['couleur'], PDO::PARAM_STR);
                 $req->bindValue(':par_nbStock', $_POST['nbStock'], PDO::PARAM_STR);
               
               $req->execute();
                
                
                
                if ($req->rowCount() > 0) {
                   
                    $msg = "<p style='color: green;'>Le stock a bien été modifié</p>";
                } else {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le stock n'a pas été modifié</p>";
                }
                
            }catch(PDOException $e){
                die("Err BDselect : erreur lors de l'ajout vitre arriere dans ajout_couleur.php<br>Message d'erreur :" . $e->getMessage()); 
            }

        }
            
    ?>
        <form action="ajout_stock.php" method="POST">
        <div class="form-content">
        <label for='nom'>Modele : </label>
        
        <select name="nom" id="nom" class='select'>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, nom from modele;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table categorie_convoc dans ajout_epreuve.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id'>$enreg->nom</option>";
                    }
                }
                ?>

            </select>
            <br>
            <label for="couleur">Couleur : </label>
            <select name="couleur" id="couleur" class='select' required>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, couleur from vitrearriere;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table categorie_convoc dans ajout_epreuve.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id'>$enreg->couleur</option>";
                    }
                }
                ?>

            </select>
            <br>
            <label for='nbStock'>Nombre de stock : </label>
        <input type='number' name='nbStock' id='nbStock' placeholder='Ex : 12' required>
            <br><br>
        <input type='submit' name='envoyer' value='Envoyer' id='envoyer' >
       <br><br> <?php  echo $msg ?> 
        </div>
        </form>
        

    </div>

</section>
</div>

</body>
</html>