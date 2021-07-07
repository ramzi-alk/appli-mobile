<?php
    
    
    if(isset($_POST['idModele']) == true && $_POST['idModele'] > 0){


        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        try {
             $lesEnregs = $bdd->query("select id_modele, id_vitreArriere, nombreStock, modele.nom, couleur from modele_vitrearriere join modele on id_modele = modele.id join vitrearriere on id_vitreArriere = vitrearriere.id;");
            
            
        } catch (PDOException $e) {
            die("Err BDselect : erreur de lecture table modele dans index.php<br>Message d'erreur :" . $e->getMessage());
        }
        if ($lesEnregs->rowCount() == 0) {
            
            echo ("Aucune valeur n'a été enregistré");
        } else {
            
            $lesModeles = $bdd->query("select id_modele, id_vitreArriere, nom, modele.id from modele_vitrearriere join modele on id_modele = modele.id where id_modele =  " .$_POST['idModele'] ." group by id_modele order by id_modele");
            foreach($lesModeles as $modele){
             
             echo "<div class='modele'><h4>$modele->nom</h4></div>";
             echo"<table class= 'table-fill'>
             <thead> ";
            
             echo "<tr> <th scope='col'>Couleur</th>
             <th scope='col'>Nombre de stock</th>
             <th scope='col'>Prix d'achat</th>
             <th scope='col'>Modifier le stock</th>
                ";
                echo" </tr> </thead>";
                echo "<tbody>";
                $lesCouleurs = $bdd->query("select id_vitreArriere, couleur from modele_vitrearriere join vitrearriere on id_vitreArriere = vitrearriere.id where id_modele = $modele->id");
                
                
                
                 $lesQuantites = $bdd->query("select id_modele as 'idMod', id_vitreArriere as 'idVit', nombreStock,prix_achat,  couleur from modele_vitrearriere join vitrearriere on id_vitreArriere = vitrearriere.id where id_modele = $modele->id order by id_vitreArriere");
               
                 foreach ($lesQuantites as $quantite) {
                    
                    echo "<tr>
                    <td>$quantite->couleur</td>
                    <td>$quantite->nombreStock</td>
                    <td>$quantite->prix_achat</td>
                    <td><a href='/page/modification/modif_vitre_arriere.php?id=$quantite->idMod&idVit=$quantite->idVit'><img src='/image/edit.svg' alt='' style='height: 30px;'> </a> </td>
                    </tr>";
                }
                $lesTotaux1 = $bdd->query("SELECT SUM(nombreStock) as nbStock FROM modele_vitrearriere where id_modele = $modele->id GROUP by id_modele "); 
                foreach($lesTotaux1 as $total){
                    echo "<tr>
                    <th colspan=1>Total</th> 
                    <td colspan=1>$total->nbStock</td>";
                }
                
                echo "</tr></tbody>
                </table>";
            }
           
            
            
        }

    }else{
        echo" <h3>Pas d'enregistrement renseigner pour ce modèle</h3>";
    }

    
    ?>