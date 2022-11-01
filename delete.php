<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'DELETE FROM `books` WHERE id = :id;';

    // On prépare la requete 
    $query = $db->prepare($sql);

    // On doit accrocher les parametres (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //On exécute la requete
    $query->execute();

    // On recupere le livre 
    $book = $query->fetch();

    // On vérifie si le produit existe
    if (!$book) {
        $_SESSION['erreur'] = "cet id n'existe pas";
        header('location: index.php');
        die();
    }

    $sql = 'DELETE FROM `books` WHERE id = :id;';

    // On prépare la requete 
    $query = $db->prepare($sql);

    // On doit accrocher les parametres (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //On exécute la requete
    $query->execute();
    $_SESSION['message'] = "Livre supprimé";
        header('location: index.php');

} else {
    $_SESSION['erreur'] = "URL invalide";
    header('location: index.php');
}
