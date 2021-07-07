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
<h2>Ajout d'un accessoire</h2>
</div>
<section class="content">
    <div class="formulaire" style="height: 40vh;">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        $msgError = ''; 
        extract($_POST);
        if(isset($_POST['envoyer']) == true){
           

            
            $existe = $bdd->query("select count(*) from accessoires where nom = '$nom' ");
            $siExiste = $existe->fetchColumn();
            if($siExiste == 0){
                try{
                
                    $req = $bdd->prepare("INSERT INTO `accessoires` (`id`, `nom`,`prix_achat`, `nb_stock`) VALUES (0, :par_nom, :par_prix, :par_stock)");
                    
                    $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                    $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_STR);
                    $req->bindValue(':par_stock', $_POST['stock'], PDO::PARAM_STR);
                  
                  $req->execute();
                   
                   
                   
                   if ($req->rowCount() > 0) {
                      
                       $msg = "<p style='color: green;'>L'accessoire a bien été ajouté</p>";
                        echo"<script type='text/javascript'>
                        window.location.replace('/page/stock_accessoires.php');
                        </script>";
                    } else {
                       
                       $msg = "<p style= 'color : red;'>Erreur : l'accessoire n'a pas été ajouté</p>";
                   }
                   
               }catch(PDOException $e){
                   die("Err BDselect : erreur lors de l'ajout d'accessoires dans ajout_accessoires.php<br>Message d'erreur :" . $e->getMessage()); 
               }
            }else{
                $msgError  = "<p style= 'color : red;'>Erreur : la valeur a déjà été enregistré</p>";
            }

       }
            
    ?>
        <form action="ajout_accessoires.php" method="POST">
        <div class="form-content">
        <label for='nom'>Nom : </label>
        <input type="text" name="nom" id="nom" placeholder="Nom de l'accessoires" required>
            <br>
           
            <label for='prix'>Prix d'achat : </label>
        <input type="number" step="any" name="prix" id="prix" placeholder="">
            <br>
            <label for='stock'>Nombre de stock : </label>
        <input type='number' name='stock' id='stock' placeholder='' >
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

