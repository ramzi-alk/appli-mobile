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
    <title>Modification du client</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Modification du client </h2>
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
            
            $lesEnregs = $bdd->prepare("select id,nom ,numero , mail from client where id = :par_id");
            $lesEnregs->bindValue(':par_id', $id, PDO::PARAM_INT);
            $lesEnregs->execute();
        }catch(PDOException $e){
            die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
        }
        
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach($lesEnregs as $enreg){
                $nom = $enreg->nom;
                $numero = $enreg->numero; 
                $mail = $enreg->mail;
                $id =$enreg->id;
                
            }
        }
        
         if(isset($_POST['envoyer']) == true){
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            
            try{
                
                $req = $bdd->prepare("update client set nom = :par_nom, numero = :par_numero, mail = :par_mail where id = :par_id ");
                
                $req->bindValue(':par_nom', $_POST['nom'], PDO::PARAM_STR);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                $req->bindValue(':par_numero', $_POST['numero'], PDO::PARAM_STR);
                $req->bindValue(':par_mail', $_POST['mail'], PDO::PARAM_STR);
                $req->execute();
                

                if ($req->rowCount() == 0) {
                    
                    $msg = "<p style= 'color : red;'>Erreur : le client n'a pas été modifié</p>";
                } else {
                   
                   $msg = "<p style='color: green;'>Le client a bien été modifié</p>";
                   echo"<script type='text/javascript'>
                   window.location.replace('/intervention.php');
                   </script>";
                }
                
                
            }catch(PDOException $e){
                die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
            }
        } 

    }
    
    ?>
        <form action="modif_client.php?id=<?php echo $id?>" method="POST">
        <div class="form-content">
        <label for='nom'>Nom : </label>
        <input type='text' name='nom' id='nom' value="<?php echo htmlspecialchars($nom);?>" required>
    <br>    
        <label for='numero'>Numero de téléphone : </label>
        <input type='text' name='numero' id='numero' value="<?php echo$numero;?>" required>
<br>
        <label for='mail'>Mail : </label>
        <input type='text' name='mail' id='mail' value="<?php echo$mail;?>" required>
        
        
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
