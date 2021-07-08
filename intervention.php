<?php
session_start();  // démarrage d'une session
?>

<?php
// Si la session sess_user_id et sess_user_name sont saisie alors l'utilisateur peut accéder au contenu de la page sinon il est redirigé vers la page de formulaire
if (isset($_SESSION['sess_user_id']) && isset($_SESSION['sess_user_name']) ){?>


<!-- Nous affichons ainsi le contenu dans la condition -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Interventions</title>
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/sidebar.html"; ?>
	
    

        <!-- Contenu  -->
      
<div class="contenu" id="contenu">
<!-- Script qui fait appel au bouton qui affiche la sidebar -->
<?php include $_SERVER['DOCUMENT_ROOT'] . "/include/btn.html"; ?>

<section class="accueil_page">

    <div class="table-title">
    <h2>Liste des Interventions</h2>
    </div>
    
    <br><br>
    <div class="lien">
        
    <label for="voirModele">Intervention : </label>
    </div>
    <!-- Cet input fait appel a un script ajax en jquery qui recherche dans le tableau une correspondance entre les informations saisies et les informations du tableau
    -->
    <div class="lien">
    
    <input type="search" name="voirModele" id="search" class="voirModele">

    </div>
    <br><br><div class="lien">

<a href="/page/ajout/ajout_client.php" class="ajt">Ajouter une personne</a>
</div>
<br><br>
<div class="lien">

<a href="/page/ajout/ajout_intervention.php" class="ajt">Ajouter une intervention</a>
</div>
<br><br><br><br><br>
    <table class="table-fill">
   
    <tr>
    <thead>
    <th scope="col">ID</th>
    <th scope="col">Date</th>
        <th scope="col">Nom</th>
        <th scope="col">Modele</th>
        <th scope="col">IMEI</th>
        <th scope="col">Type</th>
        <th scope="col">Intervention</th>
        <th scope="col">Coût</th>
        <th scope="col">Observation</th>
        <th scope="col">État</th>
        <th scope="col">Modif</th>
        <th scope="col">Sup</th>
        <th scope="col">imprimer</th>
    </thead>
        
        
    </tr>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
    try {
       
        $lesEnregs = $bdd->query("select intervention.id as 'idInterv',etat.id as 'idEtat', etat.libelle as 'libelleEtat',DATE_FORMAT(date, '%d/%m/%Y') as  'date', prix, imei,id_ecran, id_vitrearriere, observation, id_modele, id_client, id_type_intervention, modele.nom as 'nomModele', client.nom as 'nomClient', type_intervention.libelle from intervention join etat on id_etat = etat.id join modele on id_modele = modele.id join client on id_client = client.id join type_intervention on id_type_intervention = type_intervention.id order by intervention.id desc");
        
    } catch (PDOException $e) {
        die("Err BDselect : erreur de lecture table modele dans index.php<br>Message d'erreur :" . $e->getMessage());
    }
    if ($lesEnregs->rowCount() == 0) {
        echo ("Aucune valeur n'a été enregistré");
    } else {
        foreach ($lesEnregs as $enreg) {
            
            echo "<tbody id='myTable'> <tr>
            <td>$enreg->idInterv</td>
            <td>$enreg->date</td>
            <td>$enreg->nomClient</td>
            <td>$enreg->nomModele</td>
            <td>$enreg->imei</td>
            <td>$enreg->libelle</td>
            ";
            // Nous vérifions si id_ecran est supérieur à 0 si oui alors la valeur affiché est écran
            // sinon nous vérifions si id_vitrearriere est supérieur à 0 si oui alors la valeur affiché est vitre arrière
            // ou sinon nous affichons Batterie
            if($enreg->id_ecran > 0){
                echo"<td>Écran</td>";
            }elseif($enreg->id_vitrearriere > 0 ){
                echo"<td>Vitre arrière</td>";
            }else{
                echo"<td>Batterie</td>";
            }
            echo"
            <td>$enreg->prix</td>
            <td>$enreg->observation</td>
            <td>$enreg->libelleEtat</td>
            <td><a href='/page/modification/modif_intervention.php?id=$enreg->idInterv'><img src='/image/edit.svg' alt='' style='height: 30px;'> </a> </td>
            <td><a href='/page/suppression/sup_intervention.php?id=$enreg->idInterv'><img src='/image/delete.svg' alt='' style='height: 30px;'></a>  </td>
            <td><a href='/page/imprime.php?id=$enreg->idInterv'><img src='/image/printer.svg' alt='' style='height: 30px;'></a>  </td>
        </tr>";
        }
        
    }
    ?>
</tbody>

</table>
</section>
<!-- Le script jquery récupère les données saisie dans l'input avec l'id search et cherche dans le tableau les valeurs qui correspondent -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

