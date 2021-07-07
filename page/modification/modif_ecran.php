<?php session_start() ?>

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
<h2>Modification du nombre de stocks d'écran </h2>
</div>
<section class="content">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <div class="formulaire">
    <?php if(isset($_GET['id'] )== true && $_GET['id'] > 0 && isset($_GET['idVit']) == true && $_GET['idVit'] > 0){
        $msg = '';        
        $id = $_GET['id'];
        $idVit = $_GET['idVit'];
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        
        try{
            
            $lesEnregs = $bdd->query("select id_modele as 'idMod', id_ecran as 'id_vit', nombreStock as 'nbStock', prix_achat from modele_ecran where id_modele = $id and id_ecran = $idVit");
            
        }catch(PDOException $e){
            die("Err BDselect : erreur de lecture table batterie dans index.php<br>Message d'erreur :" . $e->getMessage()); 
        }
        
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach($lesEnregs as $enreg){
                $nbStock = $enreg->nbStock;
                $prix = $enreg->prix_achat;
            }
        }
        
         if(isset($_POST['envoyer']) == true){
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            
            try{
                
                $req = $bdd->prepare("update modele_ecran set nombreStock = :par_nbStock, prix_achat = :par_prix where id_modele = :par_id and id_ecran = :par_idVit  ");
                
                $req->bindValue(':par_nbStock', $_POST['nbStock'], PDO::PARAM_INT);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                $req->bindValue(':par_idVit', $_POST['idVit'], PDO::PARAM_INT);
                $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_INT);
                $req->execute();
                

                if ($req->rowCount() == 0) {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le stock n'a pas été modifié</p>";
                    
                } else {
                   
                    $msg = "<p style='color: green;'>Le stock a bien été modifié</p>";
                
                    echo"<script type='text/javascript'>
                    window.location.replace('/page/stock_ecran.php');
                    </script>";
                
                
                }
                
                
            }catch(PDOException $e){
                die("Err BDselect : erreur de lecture table batterie dans index.php<br>Message d'erreur :" . $e->getMessage()); 
            }
        } 

    }
    
    ?>
        <form action="modif_ecran.php?id=<?php echo $id?>&idVit=<?php echo $idVit?>" method="POST">
        <div class="form-content">
        <label for='nbStock'>Nombre : </label>
        <input type='number' name='nbStock' id='nbStock' placeholder='Ex : 12' value="<?php echo$nbStock;?>" required><br>
        <input type='number' name='prix' id='prix' placeholder='Ex : 30' value="<?php echo$prix;?>" required>
        <br><br><br>
        <input type="hidden" name="id" value="<?php echo $id;?>" >
        <input type="hidden" name="idVit" value="<?php echo $idVit;?>" >
        <input type='submit' name='envoyer' value='Envoyer' id='envoyer' >
        
        
        
            <br><br>
            <?php  echo $msg ?> 
                   
        

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
