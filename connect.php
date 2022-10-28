<?php
try{
    // Connexion à la base
    $db = new PDO('mysql:host=localhost;dbname=library;charset=utf8', 'root',''); 
} catch(PDOException $e){
    echo 'Erreur : ' . $e->getMessage();
    die();
}
    // $user = "root";
    // $pass = "";
    // $db = new PDO('mysql:host=localhost;dbname=library', $user, $pass);

    // $booksQuery = $db->query("SELECT * FROM books");
    // $showBooks = $booksQuery->fetchAll(PDO::FETCH_ASSOC);

    // $sql ='SELECT books.title, authors.firstname, authors.lastname FROM `books` JOIN authors ON authors.id = books.author_id';
    // $query = $db->prepare($sql);
    // $query->execute();
    // $result = $query->fetchAll();
    // print_r($result);
