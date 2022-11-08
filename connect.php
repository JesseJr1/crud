<?php
try {
    // Connexion à la base
    $db = new PDO('mysql:host=localhost;dbname=library;charset=utf8', 'root', '');
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}

$authorsQuery = $db->query("SELECT * FROM authors");
$authors = $authorsQuery->fetchAll(PDO::FETCH_ASSOC);


// $bookQuery = $db->query("SELECT * FROM book");
// $allbooks = $bookQuery->fetchAll(PDO::FETCH_ASSOC);
