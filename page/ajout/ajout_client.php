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
    <title>Ajout de stock </title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>

<div class="titre">
<h2>Ajout d'un client</h2>
</div>
<section class="content">
    <div class="formulaire">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        $msgError = ''; 
        extract($_POST);
        if(isset($_POST['envoyer']) == true){
           

            
            $existe = $bdd->query("select count(*) from client where nom = '$nom' and numero = '$numero' ");
            $siExiste = $existe->fetchColumn();
            if($siExiste == 0){
                try{
                
                    $req = $bdd->prepare("INSERT INTO `client` (`id`, `nom`, `numero`, `mail`) VALUES (0, :par_nom, :par_numero, :par_mail)");
                    
                    $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                    $req->bindValue(':par_numero', $_POST['numero'], PDO::PARAM_STR);
                    $req->bindValue(':par_mail', $_POST['mail'], PDO::PARAM_STR);
                  
                  $req->execute();
                   
                   
                   
                   if ($req->rowCount() > 0) {
                      
                       $msg = "<p style='color: green;'>Le client a bien été ajouté</p>";
                       echo"<script type='text/javascript'>
                       window.location.replace('/intervention.php');
                       </script>";
                    } else {
                       
                       $msg = "<p style= 'color : red;'>Erreur : le clien n'a pas été ajouté</p>";
                   }
                   
               }catch(PDOException $e){
                   die("Err BDselect : erreur lors de l'ajout client dans ajout_client.php<br>Message d'erreur :" . $e->getMessage()); 
               }
            }else{
                $msgError  = "<p style= 'color : red;'>Erreur : la valeur a déjà été enregistré</p>";
            }

            

       }
           
            
            
    ?>
        <form action="ajout_client.php" method="POST">
        <div class="form-content">
        <label for='nom'>Nom : </label>
        <input type="text" name="nom" id="nom" placeholder="Nom du client" required>
            <br>
           
            <label for='nom'>Numero de téléphone : </label>
        <input type="text" name="numero" id="numero" placeholder="">
            <br>
            <label for='nbStock'>Mail : </label>
        <input type='text' name='mail' id='mail' placeholder='' >
            <br><br>
        <input type='submit' name='envoyer' value='Envoyer' id='envoyer' >
        <br><br> <?php  echo $msg . $msgError?> 
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
