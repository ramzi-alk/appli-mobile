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
    <link rel="stylesheet" href="/css/style.css">
    <title>Stocks des batteries</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>
	
    

        <!-- Page Content  -->
      
<div class="contenu" id="contenu">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>


<section class="accueil_page">

    <div class="table-title">
    <h2>Liste des quantités de batterie</h2>
    </div>
    
    <table class="table-fill">
   
    <tr>
    <thead>
    <th scope="col">Modele</th>
    <th scope="col">Prix d'achat</th>
        <th scope="col">Nombre</th>
        
        <th scope="col">Modifier le stock</th>
    </thead>
        
        
    </tr>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
    try {
       
        $lesEnregs = $bdd->query("select id as 'idMod', nom ,prix_achat, nbStockBatterie as 'nombreStock' from modele ");
        
    } catch (PDOException $e) {
        die("Err BDselect : erreur de lecture table modele dans index.php<br>Message d'erreur :" . $e->getMessage());
    }
    if ($lesEnregs->rowCount() == 0) {
        echo ("Aucune valeur n'a été enregistré");
    } else {
        foreach ($lesEnregs as $enreg) {
            echo "<tbody> <tr>
            <td>$enreg->nom</td>
            <td>$enreg->prix_achat</td>
            <td>$enreg->nombreStock</td>
            <td><a href='/page/modification/modif_batterie.php?id=$enreg->idMod'><img src='/image/edit.svg' alt='' style='height: 30px;'>  </a> </td>
           
        </tr>";
        }
        $lesTotaux = $bdd->query("SELECT SUM(prix_achat) as 'prix_achat' FROM modele "); 
            foreach($lesTotaux as $letotal){
                echo"<tr>
                <th colspan=1>Total</th> 
                <td colspan=1>$letotal->prix_achat</td>
                
                ";
            }
        $lesTotaux1 = $bdd->query("SELECT SUM(nbStockBatterie) as nbStock FROM modele "); 
            foreach($lesTotaux1 as $total){
                echo "
                <td colspan=1>$total->nbStock</td>
                </tr>
                ";
                
            }
        
    }
    ?>
</tbody>
</table>
</section>
<section class="accueil-page">
<div class="lien">

<a href="/page/ajout/ajout_telephone.php" class="ajt">Ajouter un téléphone</a>
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
