<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `books` WHERE id = :id;';

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
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du livre</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du livre <?= $book['title'] ?> </h1>
                <p>ID: <?= $book['id'] ?> </p>
                <p>Auteur: <?= $book['author_id'] ?> </p>
                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?= $book['id'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>

</html>