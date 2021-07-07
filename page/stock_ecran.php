<?php
session_start();  // démarrage d'une session
?>


<?php
if (isset($_SESSION['sess_user_id']) && isset($_SESSION['sess_user_name']) ){
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/style.css">
        <title>Stocks des écrans</title>
    </head>
    <body>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>
        
        
    
            <!-- Page Content  -->
          
    <div class="contenu" id="contenu">
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>
    <section class="accueil_page">
        
        <div class="table-title">
        <h2>Liste des quantités d'écran</h2>
        </div>
        <br><br>
        <div class="lien">
        <label for="voirModele">Modele : </label>
        </div>
        
        <div class="lien" >
        
        <!-- Ce select permet de choisir un type de modele dont on veut voir les stocks et fait appel a un script ajax en jquery -->
        <select name="voirModele" id="" style="font-size: 25px;" class="voirModele">
        <?php
                    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
                    try {
                        $lesEnregs = $bdd->query("select id_modele,nom from modele_ecran join modele on id_modele = modele.id group by id_modele ;");
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
        <br><br><br><br><br><br><br><br><br><br>
        <div class="resultat">
    
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script></script>
    
    
    
        <!-- Le script récupère la valeur du select lors du click et fait appel au fichier modele_recherche.php qui lui va afficher les stocks du modèle choisie -->
       <script>
           $(document).ready(function(){
                $("select[name=voirModele]").click(function(){
                    $(".resultat").load("modele_recherche.php", {
                            'idModele' : $('select [name=voirModele]:checked').attr('value')} 
                            );
                });
           });
                
       </script>
       
        <br>
       
        
    
    
    
    
        <br><br>
    <div class="lien">
    
    <a href="/page/ajout/ajout_stock_ecran.php" class="ajt">Ajouter du stock d'écran</a>
    
    </div><br><br><br>
    <div class="lien">
    
    <a href="/page/ajout/ajout_telephone.php" class="ajt">Ajouter un téléphone</a>
    </div>
    <br><br><br><br>
    
    
    
    </section>
    
    </div>
    
       
    </body>
    </html>

<?php
}else{
     echo"<script type='text/javascript'>
     window.location.replace('/index.php');
    </script>";
    
}

?>
