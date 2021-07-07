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
    <title>Modification du nombre de batterie</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Modification de l'accessoires </h2>
</div>
<section class="content">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <div class="formulaire" style="height: 45vh;">
    <?php
        
     if(isset($_GET['id'] )== true && $_GET['id'] > 0 ){
        $msg = '';
        $id = $_GET['id'];
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        
        try{
            
            $lesEnregs = $bdd->query("select id, nom , prix_achat, nb_stock from accessoires where id = $id");
            
        }catch(PDOException $e){
            die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
        }
        
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach($lesEnregs as $enreg){
                $nom = $enreg->nom;
                $prix = $enreg->prix_achat; 
                $stock = $enreg->nb_stock;
                
            }
        }

         if(isset($_POST['envoyer']) == true){
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            
            try{
                
                $req = $bdd->prepare("update accessoires set nom = :par_nom, prix_achat = :par_prix, nb_stock = :par_stock where id = :par_id ");
                
                $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_STR);
                $req->bindValue(':par_stock', $_POST['stock'], PDO::PARAM_INT);
                $req->execute();
                

                if ($req->rowCount() == 0) {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le client n'a pas été modifié</p>";
                } else {
                   
                   $msg = "<p style='color: green;'>Le client a bien été modifié</p>";
                   echo"<script type='text/javascript'>
                   window.location.replace('/page/stock_accessoires.php');
                   </script>";
                }
                
                
            }catch(PDOException $e){
                die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
            }
        } 

    }
    
    ?>
        <form action="modif_accessoires.php?id=<?php echo $id?>" method="POST">
        <div class="form-content">
        <label for='nom'>Nom : </label>
        <input type='text' name='nom' id='nom' value="<?php echo$nom;?>" required>
    <br>    
        <label for='prix'>Prix d'achat : </label>
        <input type='number' step="any" name='prix' id='prix' value="<?php echo$prix;?>" required>
<br>
        <label for='stock'>Nombre de stock  : </label>
        <input type='number' name='stock' id='stock' value="<?php echo$stock;?>" required>
        
        
        <br><br><br><br>
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
<?php
}else{
echo"<script type='text/javascript'>
     window.location.replace('/index.php');
    </script>";
}?>
