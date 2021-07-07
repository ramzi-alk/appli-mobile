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
    <title>Personnel</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>
	
    


      
<div class="contenu" id="contenu">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>


<section class="accueil_page">

    <div class="table-title">
    <h2>Liste du personnel</h2>
    </div>
    
    <br><br>
    <div class="lien">
    <label for="voirModele">Personnel : </label>
    </div>
    
    <div class="lien" >

    <input type="search" name="voirModele" id="search" class="voirModele">
    </div>
    <br>
<br><br><div class="lien">

<a href="/page/ajout/ajout_client.php" class="ajt">Ajouter une personne</a>
</div><br><br><br>
    <table class="table-fill" >
   
    
    <thead>
    <tr>
    <th scope="col">Nom</th>
        <th scope="col">Numero</th>
        <th scope="col">Mail</th>
        <th scope="col">Modifier</th>
        <th scope="col">Supprimer</th>
        </tr>
    </thead>
        
        
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        try {
           
            $lesEnregs = $bdd->query("select id, nom , numero, mail from client order by id desc ");
            
        } catch (PDOException $e) {
            die("Err BDselect : erreur de lecture table client dans client.php<br>Message d'erreur :" . $e->getMessage());
        }
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach ($lesEnregs as $enreg) {
                echo "<tbody id='myTable'> <tr>
                <td>$enreg->nom</td>
                <td>$enreg->numero</td>
                <td>$enreg->mail</td>
                <td><a href='/page/modification/modif_client.php?id=$enreg->id'><img src='/image/edit.svg' alt='' style='height: 30px;'>  </a> </td>
                <td><a href='/page/suppression/sup_client.php?id=$enreg->id'><img src='/image/delete.svg' alt='' style='height: 30px;'> </a> </td>
            </tr>";
            }
            
        } ?>
        </tbody>
</table>
    
    <br><br><br><br>
    <div class="resultat">

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        //La fonction va écouter la saisie d'un caractère dans l'input (dont l'id est search),
        //et va stocker les caractères dans une variable value puis va chercher dans le tableau les tr qui correspondent aux caractères saisies
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</section>
<section class="accueil-page">



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
