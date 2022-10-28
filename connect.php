<?php
try{
    // Connexion à la base
    $db = new PDO('mysql:host=localhost;dbname=library;charset=utf8', 'root',''); 
} catch(PDOException $e){
    echo 'Erreur : ' . $e->getMessage();
    die();
}