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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://kit.fontawesome.com/42deadbeef.js">
    <link rel="stylesheet" href="/css/style-bar.css">
    <title>Stocks des écrans</title>
</head>
<body>


<div class="sidenav" id="contenu">
    <nav class="nav">
      <div class="text">
      <ul>
        <li class="deroulant"><a href="/page/stock_ecran.php">Stocks &ensp;</a>
        
          <ul class="sous">
            <li><a href="/page/stock_batterie.php">Stocks batterie</a>
            </li>
            <li><a href="/page/stock_ecran.php">Stocks Écran</a></li>
            <li><a href="/index.php">Stocks vitres arrières</a></li>
          </ul>
        </li>
        <li><a href="#>" >Ventes</a></li>
        <li><a href="../../client.php">Clients</a></li>
        <li><a href="../../intervention.php">Interventions</a></li>
        <li><a href="#contact">Accessoires</a></li>
      </ul>
      </div>
      
        
    </nav>
    
    
    
    
    
  </div>
	
    

        <!-- Page Content  -->
       
<div class="contenu" id="contenu">
  <div class="btn">
  <span> <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
</svg></span>
  </div>
<section class="accueil_page">
    
    <div class="table-title">
    <h2>Liste des quantités vitres arrières</h2>
    </div>
    <br><br>
    <div class="lien">
    <label for="voirModele">Client : </label>
    </div>
    
    <div class="lien" >
    
    <input type="search" name="voirModele"  class="voirModele">

    </div>
<br><br><br><br><br>
    <table class="table-fill" >
   
    
    <thead>
    <tr>
        <th scope="col">Nom</th>
        <th scope="col">Numero</th>
        <th scope="col">Mail</th>
        <th scope="col">Modifier</th>
        </tr>
    </thead>
        
        
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        try {
           
            $lesEnregs = $bdd->query("select id, nom , numero, mail from client  ");
            
        } catch (PDOException $e) {
            die("Err BDselect : erreur de lecture table modele dans index.php<br>Message d'erreur :" . $e->getMessage());
        }
        if ($lesEnregs->rowCount() == 0) {
            echo ("Aucune valeur n'a été enregistré");
        } else {
            foreach ($lesEnregs as $enreg) {
                echo "<tbody id='myTable' > <tr>
                <td>$enreg->nom</td>
                <td>$enreg->numero</td>
                <td>$enreg->mail</td>
                <td><a href='/page/modification/modif_client.php?id=$enreg->id'><input type='button' name='Modifier' value='Modifier'/> </a> </td>
               
            </tr>";
            }
            
        } ?>
        </tbody>
</table>
    
    <br><br><br><br>
    <div class="resultat">

    </div>
    


    <script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
    $('.btn').click(function(){
      $(this).toggleClass("click");
      $('.sidenav').toggleClass("show");
    });
      $('.feat-btn').click(function(){
        $('nav ul .feat-show').toggleClass("show");
        $('nav ul .first').toggleClass("rotate");
      });
      $('.serv-btn').click(function(){
        $('nav ul .serv-show').toggleClass("show1");
        $('nav ul .second').toggleClass("rotate");
      });
      $('nav ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
      });
    </script>

   
    <br>
   
    




    <br><br>
<div class="lien">

<a href="/page/ajout/ajout_stock_ecran.php" class="ajt">Ajouter du stock d'écran</a>

</div>
<!-- <div class="lien">
<a href="kk" onclick="window.print()">Imprimer
</a>
</div> -->


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


