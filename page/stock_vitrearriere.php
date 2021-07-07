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
    <title>Stocks des vitres arrières</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>
	
    

        <!-- Page Content  -->
      
<div class="contenu" id="contenu">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>


<section class="accueil_page">
    
    <div class="table-title">
    <h2>Liste des vitres arrières </h2>
    </div>
    
    <br><br>
    <div class="lien">
    <label for="voirModele">Modele : </label>
    </div>
    
    <div class="lien" >
    
    
    <select name="voirModele" id="" style="font-size: 25px;" class="voirModele">
    <?php
            
            

            echo "<h1>".$_SESSION["nom"]."</h1>";
                include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                try {
                    $lesEnregs = $bdd->query("select id_modele,nom from modele_vitrearriere join modele on id_modele = modele.id group by id_modele ;");
                } catch (PDOException $e) {
                    die("Err BDselect : erreur de lecture table categorie_convoc dans ajout_epreuve.php<br>Message d'erreur :" . $e->getMessage());
                }
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id_modele' name='voirModele'>$enreg->nom</option>";
                    }
                }
                ?>



    </select>
    </div>
    <br><br><br><br>
    <div class="resultat">

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script></script>
   
   <script>
       $(document).ready(function(){
            $("select[name=voirModele]").click(function(){
                $(".resultat").load("/page/vitre_recherche.php", {
                        'idModele' : $('select [name=voirModele]:checked').attr('value')} 
                        );
            });
       });
            
   </script>
   
    <br>
   
    

<div class="lien">

<a href="/page/ajout/ajout_couleur.php" class="ajt">Ajouter une couleur</a>

</div>
<br><br>
<div class="lien">
<a href="/page/ajout/ajout_stock.php" class="ajt">Ajouter du stock</a>
</div>
<br><br><div class="lien">

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
