<?php
session_start();  // démarrage d'une session
?>

<?php
if (isset($_SESSION['sess_user_id']) && isset($_SESSION['sess_user_name']) ){?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../css/style.css">
    <title>Ajout d'un téléphone</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Ajout d'un téléphone</h2>
</div>
<section class="content">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <div class="formulaire">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        if(isset($_POST['envoyer']) == true){
            
            $nb = 0;
            try{
                
                $req = $bdd->prepare("insert into modele (id, nom, nbStockBatterie) values(0, :par_nom, :par_id)");
                
                $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
               
               
                $req->execute();
                
                
                
                if ($req->rowCount() > 0) {
                   
                    $msg = "<p style='color: green;'>Le téléphone a bien été ajouté</p>";
                    echo"<script type='text/javascript'>
                    window.location.replace('/page/stock_batterie.php');
                    </script>";
                } else {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le téléphone n'a pas été ajouté</p>";
                
                }
                
            }catch(PDOException $e){
                die("Err BDselect : erreur lors de l'ajout modele dans ajout_telephone.php<br>Message d'erreur :" . $e->getMessage()); 
            }

        }
            
    ?>
        <form action="ajout_telephone.php" method="POST">
        <div class="form-content">
        <label for='nom'>Nom du modele : </label>
        <input type='text' name='nom' id='nom' placeholder='Ex : iPhone 12'  required><br><br><br><br>
        <input type="hidden" name="id" value="0" >
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
<?php
}else{
echo"<script type='text/javascript'>
     window.location.replace('/index.php');
    </script>";
}?>
