<?php

    if(isset($_POST['idModele']) == true && $_POST['idModele'] > 0){

        include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
        try {
             $lesEnregs = $bdd->query("select id_ecran , id_modele, nombreStock, modele.nom, ecran.couleurEcran, ecran.couleurEcran,modele_ecran.prix_achat from modele_ecran join modele on id_modele = modele.id join ecran on id_ecran = ecran.id;");
            
            
        } catch (PDOException $e) {
            die("Err BDselect : erreur de lecture table modele dans index.php<br>Message d'erreur :" . $e->getMessage());
        }
        if ($lesEnregs->rowCount() == 0) {
            
            echo ("Aucune valeur n'a été enregistré");
        } else {
    
            $lesModeles = $bdd->query("select id_modele, nom, modele.id from modele_ecran join modele on id_modele = modele.id where id_modele = ".$_POST['idModele'] ." group by id_modele order by id_modele");
            foreach($lesModeles as $modele){
            //  Nous affichons tout d'abord le modèle dans une balise h4
             echo "<div class='modele'><h4>$modele->nom</h4></div>";
             echo"<table class= 'table-fill'>
             <thead> ";
             echo "<tr>
                ";
                
                    echo " <th scope='col'>Couleur</th>
                    <th scope='col'>Nombre</th>
                    <th scope='col'>Prix d'achat</th>
                    <th scope='col'>Modifier le stock</th>";
                 
                echo" </tr> </thead>";
                // Dans la boucle foreach des modèles nous récupérons les informations que nous voulons afficher dans une seconde boucle
                 $lesQuantites = $bdd->query("select id_modele as 'idMod', id_ecran as 'idVit', nombreStock, couleurEcran as 'couleur',
                 modele_ecran.prix_achat as 'prix' FROM modele_ecran 
                 join ecran on id_ecran = ecran.id where id_modele = $modele->id 
                 order by id_ecran ");
               echo "<tbody>";
                 foreach ($lesQuantites as $quantite) {
                    
                    echo "
                    <tr>
                    <td>$quantite->couleur</td>
                    <td>$quantite->nombreStock</td>
                    <td>$quantite->prix</td>
                    <td><a href='/page/modification/modif_ecran.php?id=$quantite->idMod&idVit=$quantite->idVit'><img src='/image/edit.svg' alt='' style='height: 30px;'> </a> </td>
                    </tr>
                    ";
                    $lesTotaux = $bdd->query("SELECT SUM(nombreStock) as nbStock FROM modele_ecran where id_modele = $modele->id GROUP by id_modele ");
                
                }
                // Et enfin nous affichons le total du nombre de stock dans une dernière boucle
                foreach($lesTotaux as $total){
                    echo "
                    <th>Total</th>
                    <td>$total->nbStock</td>";
                }
            echo "</tr></tbody></table>";
            }
        }

    }
