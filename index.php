<?php
/*On démarre un session avant tout*/
session_start();

 $msg= "";
/*On lance le programme de vérification lors de l'envoie du formulaire*/
 if(isset($_POST["envoyer"]) == true){
    
    include $_SERVER['DOCUMENT_ROOT'] . "/include/connexion_bd.php";
  /*On vérifie les informations envoyées,
  htmlspecialchars est une fonction qui remplace les caractères spéciaux comme les guillemets par des lettres afin d'éviter notamment les injections Sql ou html
  */
    $utilisateur = trim($_POST['nom']);
    $mdp = trim($_POST['password']);
    htmlspecialchars($utilisateur);
    htmlspecialchars($mdp);

    if($utilisateur != "" && $mdp != ""){
        try{
            /*Nous récupérons de la base de données les informations saisie si ils existents*/
            $req = $bdd->prepare("select id, nom, password from utilisateur where nom = :par_nom and password = :par_mdp");
            $req->bindValue(':par_nom', $utilisateur, PDO::PARAM_STR);
            $req->bindValue(':par_mdp', $mdp, PDO::PARAM_STR);
            $req->execute();
            $count = $req->rowCount();
          $row = $req->fetch(PDO::FETCH_ASSOC);
          /*Si nous avons bien une correspondance alors nous entrons dans la boucle et nous créons la session de l'utilisateur*/
          if($count == 1 && !empty($row)) {
           
            $_SESSION['sess_user_id'] = $row['id'];
            $_SESSION['sess_user_name'] = $row['nom'] ;
            /*Nous transférons l'utilisateur vers la page du stock d'écran*/
            echo"<script type='text/javascript'>
            window.location.replace('/page/stock_ecran.php');
            </script>";
          } else {
            $msg = "<p style='color: red;'>Nom d'utilisateur et mot de passe invalides ! </p>";
          }
        }catch (PDOException $e) {
            echo "Erreur : ".$e->getMessage();
          }
        

    }else{
        echo"<p style='color: red;'>Les deux champs sont obligatoires </p>";
    }

 }
?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel Log in</title>
 <link rel="stylesheet" href="/css/style-index.css">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <!--Formulaire de connexion -->
<div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    ADMIN 
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label class="form-control-label">Nom</label>
                                <input type="text" class="form-control" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Mot de passe</label>
                                <input type="password" class="form-control" i name="password" required>
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <?php echo $msg; ?>
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary" name="envoyer">CONNEXION</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>

</body>
</html>