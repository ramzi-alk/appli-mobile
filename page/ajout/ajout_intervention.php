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
    <title>Ajout d'une intervention </title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>

<div class="contenu">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
<div class="titre">
<h2>Nouvelle intervention</h2>
</div>
<section class="content">
    <div class="formulaire" style="height: 1100px; width:500px;">
    <?php 
                
        
        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        $msg = '';
        $msgError = '';
        $nbStock = 0;
        $nomCouleur = "";
        $nomModele = "";
        
        extract($_POST);
        if(isset($_POST['envoyer']) == true){
            $type_interv = $_POST['type_interv'];
            
            if($type_interv == 'E'){
                $recup = $bdd->query("select id_modele, id_ecran, nombreStock, couleurEcran, nom from modele_ecran join ecran on id_ecran = ecran.id join modele on id_modele = modele.id where id_modele = ". $modele ." and id_ecran = ". $couleur ." ");

                foreach($recup as $rec){
                    $nbStock = $rec->nombreStock;
                    $nomCouleur = $rec->couleurEcran;
                    $nomModele = $rec->nom;
                }
                if ($nbStock > 0 && $nbStock != -1){
                    $nbStock = $nbStock - 1;
                }else{
                    $msg = "<p style= 'color : red;'>Erreur : Il n'y a pas de stock d'écran pour ce modèle </p>";
                }
                
                $renvoi = $bdd->query("update modele_ecran set nombreStock = ". $nbStock. " where id_modele = ". $modele. " and id_ecran = ".$couleur." ");
                
                
                
                
                if ($renvoi->rowCount() > 0){
                    $req = $bdd->prepare("insert into intervention values(0,:par_date,:par_prix,:par_imei,:par_obser,:par_modele,:par_client,:par_type,:par_couleur, NULL,:par_etat)");
                
                    $req->bindValue(':par_date', $_POST['date'], PDO::PARAM_STR);
                    $req->bindValue(':par_modele', $_POST['modele'], PDO::PARAM_INT);
                    $req->bindValue(':par_client', $_POST['client'], PDO::PARAM_INT);
                    $req->bindValue(':par_etat', $_POST['etat'], PDO::PARAM_INT);
                    $req->bindValue(':par_type', $_POST['type'], PDO::PARAM_STR);
                    $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_INT);
                    $req->bindValue(':par_obser', $_POST['obser'], PDO::PARAM_STR);
                    $req->bindValue(':par_imei', $_POST['imei'], PDO::PARAM_STR);
                    $req->bindValue(':par_couleur', $_POST['couleur'], PDO::PARAM_INT);
                    $req->execute();
                    if ($req->rowCount() > 0) {
                      
                        $msg = "<p style='color: green;'>L'intervention a bien été ajouté</p>";
                        echo"<script type='text/javascript'>
                        window.location.replace('/intervention.php');
                        </script>";
                         } else {
                           
                            $msg = "<p style= 'color : red;'>Erreur : l'intervention n'a pas été ajouté</p>";
                       }
                }else{
                    $msg = "<p style= 'color : red;'>Erreur : Il n'y a pas de stock d'écran pour ce modèle </p>";
                }
                }
               
            if($type_interv == 'V'){
                
            
                    $recup = $bdd->query("select id_modele, id_vitreArriere, nombreStock, couleur, nom FROM modele_vitrearriere join vitrearriere on id_vitreArriere = vitrearriere.id join modele on id_modele = modele.id where id_modele = ".$modele." and id_vitreArriere = ".$couleur."");
                    
                    foreach($recup as $rec){
                        $nbStock = $rec->nombreStock;
                        $nomCouleur = $rec->couleur;
                        $nomModele = $rec->nom;
                    }
                    if ($nbStock > 0 && $nbStock != -1){
                        $nbStock = $nbStock - 1;
                    }else{
                        $msg = "<p style= 'color : red;'>Erreur : Il n'y a pas de vitre arrière pour ce modèle </p>";
                    }
                    
                    $renvoi = $bdd->query("update modele_vitrearriere set nombreStock = ". $nbStock. " where id_modele = ". $modele. " and id_vitreArriere = ".$couleur." ");
                    
                    
                    
                    
                    if ($renvoi->rowCount() > 0){
                        $req = $bdd->prepare("insert into intervention values(0,:par_date,:par_prix,:par_imei,:par_obser,:par_modele,:par_client,:par_type,NULL, :par_couleur,:par_etat)");
                    
                        $req->bindValue(':par_date', $_POST['date'], PDO::PARAM_STR);
                        $req->bindValue(':par_modele', $_POST['modele'], PDO::PARAM_INT);
                        $req->bindValue(':par_client', $_POST['client'], PDO::PARAM_INT);
                        $req->bindValue(':par_type', $_POST['type'], PDO::PARAM_STR);
                        $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_INT);
                        $req->bindValue(':par_obser', $_POST['obser'], PDO::PARAM_STR);
                        $req->bindValue(':par_imei', $_POST['imei'], PDO::PARAM_STR);
                        $req->bindValue(':par_couleur', $_POST['couleur'], PDO::PARAM_INT);
                        $req->bindValue(':par_etat', $_POST['etat'], PDO::PARAM_INT);
                        $req->execute();
                        if ($req->rowCount() > 0) {
                          
                            $msg = "<p style='color: green;'>L'intervention a bien été ajouté</p>";
                            echo"<script type='text/javascript'>
                            window.location.replace('/intervention.php');
                            </script>";
                             } else {
                               
                                $msg = "<p style= 'color : red;'>Erreur : l'intervention n'a pas été ajouté</p>";
                           }
                    }else{
                        $msg = "<p style= 'color : red;'>Erreur : Il n'y a pas de stock de vitre arrière pour ce modèle </p>";
                    }
            }
            
            if($type_interv == 'B'){

                $recup = $bdd->query("select id, nbStockBatterie, nom from modele where id = ". $modele ." ");
    
                    foreach($recup as $rec){
                        $nbStock = $rec->nbStockBatterie;
                        
                        $nomModele = $rec->nom;
                    }
                    if ($nbStock > 0 && $nbStock != -1){
                        $nbStock = $nbStock - 1;
                    }else{
                        $msg = "<p style= 'color : red;'>Erreur : Il n'y a pas de stock de batterie pour ce modèle </p>";
                    }
                    
                    
                    $renvoi = $bdd->query("update modele set nbStockBatterie = ". $nbStock. " where id  = ". $modele ."");
                    
                    
                    
                    
                    if ($renvoi->rowCount() > 0){
                        $req = $bdd->prepare("insert into intervention values(0,:par_date,:par_prix,:par_imei,:par_obser,:par_modele,:par_client,:par_type,NULL,NULL,:par_etat)");
                    
                        $req->bindValue(':par_date', $_POST['date'], PDO::PARAM_STR);
                        $req->bindValue(':par_modele', $_POST['modele'], PDO::PARAM_INT);
                        $req->bindValue(':par_client', $_POST['client'], PDO::PARAM_INT);
                        $req->bindValue(':par_type', $_POST['type'], PDO::PARAM_STR);
                        $req->bindValue(':par_prix', $_POST['prix'], PDO::PARAM_INT);
                        $req->bindValue(':par_obser', $_POST['obser'], PDO::PARAM_STR);
                        $req->bindValue(':par_imei', $_POST['imei'], PDO::PARAM_STR);
                        $req->bindValue(':par_etat', $_POST['etat'], PDO::PARAM_INT);
                        $req->execute();
                        if ($req->rowCount() > 0) {
                          
                            $msg = "<p style='color: green;'>L'intervention a bien été ajouté</p>";
                            echo"<script type='text/javascript'>
                            window.location.replace('/intervention.php');
                            </script>";
                             } else {
                               
                                $msg = "<p style= 'color : red;'>Erreur : l'intervention n'a pas été ajouté</p>";
                           }
                    }else{
                        $msg = "<p style= 'color : red;'>Erreur : Il n'y a pas de stock de batterie pour ce modèle </p>";
                    }
            
            
            
            }
                try{
                
               
                   
               }catch(PDOException $e){
                   die("Err BDselect : erreur lors de l'ajout d'une intervention dans ajout_intervention.php<br>Message d'erreur :" . $e->getMessage()); 
               }
            
            

        }
            
    ?>
        <form action="ajout_intervention.php" method="POST" id="form">
        <div class="form-content">
        <label for='date'>Date : </label>
        <input type='date' name='date' id='date'  required>
    <br> 


    <label for="client">Client : </label>
            <select  name="client" id="client" class='select' required>
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
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id'>$enreg->nom</option>";
                    }
                }
                ?>

            </select>
        
    <br>
    
        <label for='modele'>Modele : </label>
        
        <select name="modele" id="modele" class='select modele'>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, nom from modele;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table categorie_convoc dans ajout_epreuve.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id' name='modele'>$enreg->nom</option>";
                    }
                }
                ?>

            </select>
            <br>

            <label for='imei'>identifiant de l'appareil : </label>
        <input type='text' name='imei' id='imei'>
        <br>

        <label for="type">Type : </label>
            <select name="type" id="type" class='select' required>
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id, libelle from type_intervention;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table type_intervention dans ajout_intervention.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id' >$enreg->libelle</option>";
                    }
                }
                ?>

            </select>
            <br>

            
            <div>
                <input type="radio" name="type_interv" id="type_interv" value="B" checked >
                <label for="B">Batterie</label><br>
                <input type="radio" name="type_interv" id="type_interv" value="E">
                <label for="E">Ecran</label><br>
                 <input type="radio" name="type_interv" id="type_interv" value="V" >
                 <label for="V">Vitre arrière </label> 
            </div>
                
                <br>
                <div class="resultat"></div>
        <br>

        <div class="resultatStock"></div>
        <br>
            <label for='nbStock'>prix : </label>
        <input type='number' name='prix' id='prix' placeholder='Ex : 12' required>
            <br>
           <label for="obser">Observation : </label>
           <input type="text" name="obser" id="obser">
           <br>
        <label for="etat">État :</label>
        <div>
        
        <input type="radio" name="etat" id="" value="1" checked> 
        <label for="1">Payé</label><br>
       <input type="radio" name="etat" id="" value="2">
       <label for="2">Non payé</label><br>
        </div>
<br><br>
        <input type='submit' name='envoyer' value='Envoyer' id='envoyer' style="height: 4vh;" >
       <br><br> <?php  echo $msg . $msgError?> 
        </div>
        </form>
        

    </div>

</section>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
     <script>
       $(document).ready(function(){
            $("input[name=type_interv]").click(function(){
                $(".resultat").load("intervention_recherche.php", {
                        'valeur' : $('input[name=type_interv]:checked').attr('value')} 
                        );
            });
            

       });
            
   </script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
   
    
    
    
    
    <script>
       $(document).ready(function(){
        $("#form").change(function(){
            $.ajax({
                url : '/page/ajout/stock_recherche.php',
                type : 'POST',
                data : 'idModele=' + $("#modele").val() + '&idCouleur=' + $("#couleur").val() + '&type=' + $('input[name=type_interv]:checked').attr('value'),
                dataType : 'html',
                success : function(code_html, status){
                    $(".resultatStock").html(code_html);
                },
                error :function(resultat, statut, erreur){
                    $(".resultatStock").html("Erreur : " + resultat.responseText);
                }
            });
            $("#couleur").change(function(){
            $.ajax({
                url : '/page/ajout/stock_recherche.php',
                type : 'POST',
                data : 'idCouleur=' + $("#couleur").val(),
                dataType : 'html',
                success : function(code_html, status){
                    $(".resultatStock").html(code_html);
                },
                error :function(resultat, statut, erreur){
                    $(".resultatStock").html("Erreur : " + resultat.responseText);
                }
            });
        });
        });
       
       });
            
   </script>





</div>

</body>
</html>
<?php
}else{
echo"<script type='text/javascript'>
     window.location.replace('/index.php');
    </script>";
}?>