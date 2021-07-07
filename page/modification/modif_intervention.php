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
    <title>Modification de l'intervention</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">


<div class="titre">
<h2>Modification de l'intervention </h2>
</div>
<section class="content">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <div class="formulaire" style="height: 800px;">
    <?php
        
     if(isset($_GET['id'] )== true && $_GET['id'] > 0 ){
        $msg = '';
        $id = $_GET['id'];
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        
        try{
            
            $lesEnregs = $bdd->query("select intervention.id as 'idInterv',DATE_FORMAT(date, '%Y-%m-%d') as  'date',type_intervention.libelle as 'nomType', prix, imei, observation, id_modele, id_client as 'leclient', id_type_intervention, modele.nom as 'nomModele', client.nom as 'nomClient', libelle from intervention join modele on id_modele = modele.id join client on id_client = client.id join type_intervention on id_type_intervention = type_intervention.id where intervention.id = $id");
            
        }catch(PDOException $e){
            die("Err BDselect : erreur de lecture table client dans modif_client.php<br>Message d'erreur :" . $e->getMessage()); 
        }
        
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach($lesEnregs as $enreg){
                $idInterv = $enreg->idInterv;
                $nomClient = $enreg->nomClient;
                $date = $enreg->date; 
                $prix = $enreg->prix;
                $imei = $enreg->imei;
                $observation = $enreg->observation;
                $nomModele = $enreg->nomModele;
                $idClient = $enreg->leclient;
                $idModele = $enreg->id_modele;
                $libelle = $enreg->libelle;
                $nomType = $enreg->nomType;
                $idType = $enreg->id_type_intervention;
                
            }
        }

         if(isset($_POST['envoyer']) == true){
            include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
            
            try{
                
                $req = $bdd->prepare("update intervention set date = :par_date, prix = :par_prix, imei = :par_imei, observation = :par_obser, id_modele = :par_modele, id_client = :par_client, id_type_intervention = :par_typeInterv, id_etat = :par_etat where id = :par_id ");
                
                $req->bindValue(':par_date', $_POST['date'], PDO::PARAM_STR);
                $req->bindValue(':par_id', $_POST['id'], PDO::PARAM_INT);
                $req->bindValue(':par_modele', $_POST['modele'], PDO::PARAM_STR);
                $req->bindValue(':par_client', $_POST['client'], PDO::PARAM_STR);
                $req->bindValue(':par_typeInterv', $_POST['typeInterv'], PDO::PARAM_STR);
                $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_INT);
                $req->bindValue(':par_etat', $_POST['etat'], PDO::PARAM_INT);
                $req->bindValue(':par_obser', $_POST['obser'], PDO::PARAM_STR);
                $req->bindValue(':par_imei', $_POST['imei'], PDO::PARAM_STR);
                $req->execute();
                

                if ($req->rowCount() == 0) {
                    
                    $msg = "<p style= 'color : red;'>Erreur : l'intervention n'a pas été modifié</p>";
                } else {
                   
                   $msg = "<p style='color: green;'>L'intervention a bien été modifié</p>";
                    echo"<script type='text/javascript'>
                    window.location.replace('/intervention.php');
                    </script>";
                    
                
                }
                
                
            }catch(PDOException $e){
                die("Err BDselect : erreur de lecture table client dans modif_intervention.php<br>Message d'erreur :" . $e->getMessage()); 
            }
        } 

    }
    
    ?>
        <form action="modif_intervention.php?id=<?php echo $id?>" method="POST">
        <div class="form-content">
        <label for='date'>Date : </label>
        <input type='date' name='date' id='date' value="<?php echo$date;?>" required>
    <br>    
        


    



    <label for="client">Client : </label>
            <select  name="client" id="client" class='select' required >
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, nom from client;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table modele dans modif_intervention.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    
                        echo "<option class='opt' value='$idClient'>$nomClient</option>";
                    
                }
                ?>

            </select>
        
    <br>
            <label for="modele">Modele : </label>
            <select  name="modele" id="modele" class='select' required>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, nom from modele;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table modele dans modif_intervention.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    
                        echo "<option class='opt' value='$idModele'>$nomModele</option>";
                    
                }
                ?>

            </select>
            <br>        
    
    
            
            <label for="typeInterv">Type d'intervention : </label>
            <select  name="typeInterv" id="typeInterv" class='select' style="width: 180px;" required>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, libelle from type_intervention;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table modele dans modif_intervention.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    
                        echo "<option class='opt' value='$idType'>$nomType</option>";
                    
                }
                ?>

            </select>
            <br>  
    
    
    
    
    
    <label for='prix'>Prix : </label>
        <input type='number' name='prix' id='prix' value="<?php echo$prix;?>" required>
<br>
        <label for='obser'>Observation : </label>
        <input type='text' name='obser' id='obser' value="<?php echo$observation;?>">
        <br>
        <label for='imei'>imei : </label>
        <input type='text' name='imei' id='imei' value="<?php echo$imei;?>" required>
        
        <br>
        <label for="etat">État :</label>
        <div>
        
        <input type="radio" name="etat" id="" value="1" checked> 
        <label for="1">Payé</label><br>
       <input type="radio" name="etat" id="" value="2">
       <label for="2">Non payé</label><br>
        </div>
        
                <br>
        <input type="hidden" name="id" value="<?php echo $id;?>" >
        
        <input type='submit' name='envoyer' value='Envoyer' id='envoyer' >
        
        
        <br>

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

