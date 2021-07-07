<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style-imprime.css" >
    <title>Imprime</title>
</head>
<body>
    
</body>
</html>


<?php 

$id = $_GET["id"];

if (isset($id) == true){
    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
    try{

    }catch(PDOException $e) {
        die("Err BDselect : erreur de lecture table intervention dans imprime.php<br>Message d'erreur :" . $e->getMessage());
    }
    
    $verif = $bdd->query("select id, ifnull(id_ecran,0) as 'id_ecran', ifnull(id_vitrearriere, 0) as 'id_vitre' from intervention where id = ".$id."");
    foreach($verif as $ver){
        $id_ecran = $ver->id_ecran;
        $id_vitre = $ver->id_vitre;
    }
    if($id_ecran > 0 ){
        $lesEnregs = $bdd->query("select intervention.id as 'idInterv',etat.id as 'idEtat',couleurEcran, etat.libelle as 
        'libelleEtat',DATE_FORMAT(date, '%d/%m/%Y') as  'date', prix, imei,id_ecran, id_vitrearriere, observation, 
        id_modele, id_client, id_type_intervention, modele.nom as 'nomModele', client.nom as 'nomClient', type_intervention.libelle 
        from intervention join etat on id_etat = etat.id join modele on id_modele = modele.id join client on id_client = client.id 
        join type_intervention on id_type_intervention = type_intervention.id join ecran on id_ecran = ecran.id 
         where intervention.id =  ".$id." order by intervention.id desc ");
        foreach($lesEnregs as $enreg){
            echo "<div id='imprime'>";
            echo "ID : ". $enreg->idInterv ."</br> ";
            echo $enreg->date ."</br>  ";
            echo $enreg->nomClient ."</br>  ";
            echo $enreg->nomModele ."</br>  ";
            echo $enreg->prix ."€</br>  ";
            
            echo $enreg->libelle ."</br>  ";
           
                echo"Écran " . $enreg->couleurEcran."</br>  ";
            
                echo"$enreg->observation" ."</br>";
                echo"$enreg->libelleEtat";
        }
        echo "</div>";
    }elseif($id_vitre > 0 ){
        $lesEnregs = $bdd->query("select intervention.id as 'idInterv',etat.id as 'idEtat',couleur, etat.libelle as 
        'libelleEtat',DATE_FORMAT(date, '%d/%m/%Y') as  'date', prix, imei,id_ecran, id_vitrearriere, observation, 
        id_modele, id_client, id_type_intervention, modele.nom as 'nomModele', client.nom as 'nomClient', type_intervention.libelle 
        from intervention join etat on id_etat = etat.id join modele on id_modele = modele.id join client on id_client = client.id 
        join type_intervention on id_type_intervention = type_intervention.id join vitrearriere on id_vitrearriere = vitrearriere.id
         where intervention.id =  ".$id." order by intervention.id desc ");
        foreach($lesEnregs as $enreg){
            echo "<div id='imprime'>";
            echo "ID : ". $enreg->idInterv ."</br> ";
            echo $enreg->date ."</br>  ";
            echo $enreg->nomClient ."</br>  ";
            echo $enreg->nomModele ."</br>  ";
            echo $enreg->prix ."€</br>  ";
            
            echo $enreg->libelle ."</br>  ";
            
                echo"Vitre " . $enreg->couleur."</br>  ";
            
                echo"$enreg->observation" ."</br>";
                echo"$enreg->libelleEtat";
        }
        echo "</div>";
    }else{
        $lesEnregs = $bdd->query("select intervention.id as 'idInterv',etat.id as 'idEtat', etat.libelle as 
        'libelleEtat',DATE_FORMAT(date, '%d/%m/%Y') as  'date', prix, imei,id_ecran, id_vitrearriere, observation, 
        id_modele, id_client, id_type_intervention, modele.nom as 'nomModele', client.nom as 'nomClient', type_intervention.libelle 
        from intervention join etat on id_etat = etat.id join modele on id_modele = modele.id join client on id_client = client.id 
        join type_intervention on id_type_intervention = type_intervention.id 
         where intervention.id =  ".$id." order by intervention.id desc ");
        foreach($lesEnregs as $enreg){
            echo "<div id='imprime'>";
            echo "ID : ". $enreg->idInterv ."</br> ";
            echo $enreg->date ."</br>  ";
            echo $enreg->nomClient ."</br>  ";
            echo $enreg->nomModele ."</br>  ";
            echo $enreg->prix ."€</br>  ";
            
            echo $enreg->libelle ."</br>  ";
            
                echo"Batterie</br>  ";
            
            echo"$enreg->observation" ."</br>";
            echo"$enreg->libelleEtat";
        }
        echo "</div>";
    }
    
    

}else{
    
}




?>
<button onClick="imprimer('imprime')">Imprimer</button>
<script>
function imprimer(imprime) {
      var printContents = document.getElementById(imprime).innerHTML;    
   var originalContents = document.body.innerHTML;      
   document.body.innerHTML = printContents;     
   window.print();     
   document.body.innerHTML = originalContents;
   }
</script>