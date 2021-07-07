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
    <title>Ajout d'une couleur</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
<div class="titre">
<h2>Ajout d'une couleur vitre arrière</h2>
</div>
<section class="content">
    <div class="formulaire">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        if(isset($_POST['envoyer']) == true){
           
            try{
                
                 $req = $bdd->prepare("insert into vitrearriere(id,couleur) values(0, :par_nom)");
                
                 $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
               
               
               $req->execute();
                
                
                
                if ($req->rowCount() > 0) {
                   
                    $msg = "<p style='color: green;'>La couleur a bien été ajouté</p>";
                } else {
                    
                    $msg = "<p style= 'color : red;'>Erreur : la couleur n'a pas été ajouté</p>";
                    echo"<script type='text/javascript'>
                    window.location.replace('/index.php');
                    </script>";
                }
                
            }catch(PDOException $e){
                die("Err BDselect : erreur lors de l'ajout vitre arriere dans ajout_couleur.php<br>Message d'erreur :" . $e->getMessage()); 
            }

        }
            
    ?>
        <form action="ajout_couleur.php" method="POST">
        <div class="form-content">
        <label for='nom'>Nom de la couleur : </label>
        <input type='text' name='nom' id='nom' placeholder='Ex : Noir'  required><br><br><br><br>
        
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