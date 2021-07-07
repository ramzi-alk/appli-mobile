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
    <title>Ajout d'une vente</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Ajout d'une vente</h2>
</div>
<section class="content">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <div class="formulaire" style="height: 50vh;">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        $msgError = '';
        $nbStock = 0;
        $accessoires = 0;
        $ventes= 0;
        extract($_POST);
        if(isset($_POST['envoyer']) == true){
            
            $recup = $bdd->query("select id, nb_stock from accessoires ");
            
            foreach($recup as $rec){
                $nbStock = $rec->nb_stock;
                $accessoires = $rec->id;
                
                
            }
            if($nbStock > 0){
                $nbStock = $nbStock - 1;
            }else{
                $msgError = "Il n'y a plus de stock";
            }
            
            
            $renvoi = $bdd->query("update accessoires set nb_stock = ". $nbStock. " where id = ". $accessoires. "");
            
            
            
            if($renvoi->rowCount() > 0){
                try{
                
                    $req = $bdd->prepare("INSERT INTO `ventes` VALUES (0, :par_nom, :par_prix)");
                    
                    $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_INT);
                    $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_STR);
                   
                  
                  $req->execute();
                   
                   
                   
                   if ($req->rowCount() > 0) {
                      
                       $msg = "<p style='color: green;'>Le stock a bien été ajouté</p>";
                       echo"<script type='text/javascript'>
                       window.location.replace('/page/ventes.php');
                       </script>";
                    } else {
                       
                       $msg = "<p style= 'color : red;'>Erreur : la vente n'a pas été ajouté</p>";
                   }
                   
               }catch(PDOException $e){
                   die("Err BDselect : erreur lors de l'ajout vitre arriere dans ajout_couleur.php<br>Message d'erreur :" . $e->getMessage()); 
               }
            } else{
                $msgError  = "<p style= 'color : red;'>Erreur : la vente n'a pas été ajouté</p>";
            }
            

        }
            
    ?>
        <form action="ajout_ventes.php" method="POST">
        <div class="form-content">
        <label for='nom'>Accessoire : </label>
        
        <select name="nom" id="nom" class='select'>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, nom from accessoires;");
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
            
            
            <label for='prix'>Prix de vente : </label>
        <input type='number' step="any" name='prix' id='prix'  required>
            <br><br>
            
 
<br>
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
