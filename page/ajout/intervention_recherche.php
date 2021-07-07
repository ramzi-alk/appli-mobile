<?php

if(isset($_POST['valeur']) == true && ($_POST['valeur'] == 'E' || $_POST['valeur'] == 'V' ||$_POST['valeur'] == 'B') ){

    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";

    try{
        if($_POST['valeur'] == 'E' ){
            $lesEnregs = $bdd->query("select id, couleurEcran as 'couleur' from ecran;");
        }
        if($_POST['valeur'] == 'V' ){
            $lesEnregs = $bdd->query("select id, couleur from vitrearriere");
        }
    
        
    }catch(PDOException $e){
        die ("Err BDSelect : erreur lors de la lecture table intervention dans intervention_recherche.php<br>Message d'erreur :" . $e->getMessage()); 
    }

    if($_POST['valeur'] == 'E' ){
       echo" 
            <label for='couleur'>Couleur : </label><br>
            <select name='couleur' id='couleur' class='select' required>";
                
               
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id'>$enreg->couleur</option>";
                    }
                }
                
                echo"
            </select>
            <br>";
    }
    if($_POST['valeur'] == 'V' ){
       echo" 
            <label for='couleur'>Couleur : </label> <br>
            <select name='couleur' id='couleur' class='select' required>";
                
                
                if ($lesEnregs->rowCount() == 0) {
                    echo ("Aucune valeur n'a été enregistré");
                } else {
                    foreach ($lesEnregs as $enreg) {
                        echo "<option class='opt' value='$enreg->id'>$enreg->couleur</option>";
                    }
                }
                
                echo"
            </select>
            <br>";
    }

}else{
    echo"<h1>Erreur</h1>";
}