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
    <title>Modification de la vente</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Modification de la vente </h2>
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
            
            $lesEnregs = $bdd->query("select ventes.id as 'id', id_accessoires, prix_vente,nom from ventes join accessoires on id_accessoires = accessoires.id where ventes.id = $id");
            
        }catch(PDOException $e){
            die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
        }
        
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach($lesEnregs as $enreg){
                $nom = $enreg->nom;
                $prix = $enreg->prix_vente; 
                
                
            }
        }

         if(isset($_POST['envoyer']) == true){
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            
            try{
                
                $req = $bdd->prepare("update ventes set id_accessoires = :par_nom, prix_vente = :par_prix where id = :par_id ");
                
                $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_STR);
                
                $req->execute();
                

                if ($req->rowCount() == 0) {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le client n'a pas été modifié</p>";
                } else {
                   
                   $msg = "<p style='color: green;'>Le client a bien été modifié</p>";
                   echo"<script type='text/javascript'>
                   window.location.replace('/page/ventes.php');
                   </script>";
                }
                
                
            }catch(PDOException $e){
                die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
            }
        } 

    }
    
    ?>
        <form action="modif_ventes.php?id=<?php echo $id?>" method="POST">
        <div class="form-content">
        <label for='nom'>Nom : </label>
        <select  name="nom" id="nom" class='select' required>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, nom from accessoires;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table modele dans modif_intervention.php<br>Message d'erreur :" . $e->getMessage());
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
        <label for='prix'>Prix : </label>
        <input type='number' step="any" name='prix' id='prix' value="<?php echo$prix;?>" required>
<br>
        
        
        
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
