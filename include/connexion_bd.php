<?php
$hote = 'localhost';
$utilisateur = 'appliTelephone';
$mdp = 'Appli@2021';
$nombdd = 'gestion';
$port = '3306';


try {
    $bdd = new PDO("mysql:host=$hote;port=$port;dbname=$nombdd;charset=utf8", $utilisateur, $mdp);

    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXCEPTION $err) {
    die("BDAcc erreur de connexion à la base de données.<br>Erreur :" . $err->getMessage());
}
