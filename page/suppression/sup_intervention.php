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
    <title>Supprimer une intervention</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Êtes-vous sûrs de vouloir supprimer l'intervention ? </h2>
</div>
<section class="content">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <div class="formulaire">
    <?php 
          
        if(isset($_GET['id']) == TRUE && $_GET['id'] > 0 ){
            $id = $_GET['id'];  
        
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            $msg = '';
            
            if(isset($_POST['envoyer']) == true){
                
                $nb = 0;
                try{
                    
                    $req = $bdd->prepare("delete from intervention where id = :par_id");
                    
                    $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                   
                    $req->execute();
                    
                    if ($req->rowCount() > 0) {
                       
                        $msg = "<p style='color: green;'>L'intervention a bien été supprimé</p>";
                        echo"<script type='text/javascript'>
                        window.location.replace('/intervention.php');
                        </script>";
                    } else {
                        
                        $msg = "<p style= 'color : red;'>Erreur : l'intervention n'a pas été supprimer</p>";
                    
                    }
                    
                }catch(PDOException $e){
                    die("Err BDdelete : erreur lors de la suppression dans sup_intervention.php<br>Message d'erreur :" . $e->getMessage()); 
                }
    
            }
        
        
        
        }
        
            
    ?>
        <form action="sup_intervention.php?id=<?php echo $id;?>" method="POST">
        <div class="form-content">
        <br><br><br>
        <input type="hidden" name="id" value="<?php echo $id; ?>" >
        <input type='submit' name='envoyer' value='SUPPRIMER' id='envoyer' >
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
