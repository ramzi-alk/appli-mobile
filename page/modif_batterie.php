<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Modification du nombre de batterie</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Modification du nombre de stocks de batterie </h2>
</div>
<section class="content">
    <div class="formulaire">
    <?php if(isset($_GET['id'] )== true && $_GET['id'] > 0){
        $msg = '';
        $id = $_GET['id'];
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        
        try{
            
            $lesEnregs = $bdd->query("select id as 'idMod' , nbStockBatterie as 'nbStock' from modele where id = $id");
            
        }catch(PDOException $e){
            die("Err BDselect : erreur de lecture table batterie dans index.php<br>Message d'erreur :" . $e->getMessage()); 
        }
        
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach($lesEnregs as $enreg){
                $nbStock = $enreg->nbStock;
            }
        }

         if(isset($_POST['envoyer']) == true){
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            
            try{
                
                $req = $bdd->prepare("update modele set nbStockBatterie = :par_nbStock where id = :par_id ");
                
                $req->bindValue(':par_nbStock', $_POST['nbStock'], PDO::PARAM_INT);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                
                $req->execute();
                

                if ($req->rowCount() == 0) {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le stock n'a pas été modifié</p>";
                } else {
                   
                    $msg = "<p style='color: green;'>Le stock a bien été modifié</p>";
                }
                
                
            }catch(PDOException $e){
                die("Err BDselect : erreur de lecture table batterie dans index.php<br>Message d'erreur :" . $e->getMessage()); 
            }
        } 

    }
    
    ?>
        <form action="modif_batterie.php?id=<?php echo $id?>" method="POST">
        <div class="form-content">
        <label for='nbStock'>Nombre : </label>
        <input type='number' name='nbStock' id='nbStock' placeholder='Ex : 12' value="<?php echo$nbStock;?>" required><br><br><br><br>
        <input type="hidden" name="id" value="<?php echo $id;?>" >
        <input type='submit' name='envoyer' value='Envoyer' id='envoyer' >
        
        <br><br>

<?php echo $msg?>

        </div>
       

        </form>
        

    </div>
     


</section>
</div>

</body>
</html>