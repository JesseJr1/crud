<?php
// On démarre une session
session_start();

if ($_POST) {
    if (
        isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['books']) && !empty($_POST['books'])
        && isset($_POST['authors']) && !empty($_POST['authors'])
    ) {
        // On inclut la connexion à la base 
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $book = strip_tags($_POST['books']);
        $authors = strip_tags($_POST['authors']);

        $sql = 'UPDATE `books` SET `title`=:title, `authors`=:author_id WHERE `id=:id`;';
        // $sql = 'SELECT books.*, authors.firstname, authors.lastname FROM books LEFT JOIN authors on authors.id = books.author_id;';
        // Je pense devoir joindre mes tables afin de voir correctement le nom de l'auteur (la requete UPDATE n'est pas bonne)



        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':books', $book, PDO::PARAM_STR);
        $query->bindValue(':authors', $authors, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Livre modifié";
        require_once('close.php');

        header('location: index.php');
    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplete";
    }
}


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
    <title>Modifier un livre</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">
                            ' . $_SESSION['erreur'] . '
                            </div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
                <h1>Modification du livre</h1>
                <form method="post">

                    <div class="form-group">
                        <label for="books">Livre</label>
                        <input type="text" id="books" name="books" class="form-control" value="<?= $book['title'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="authors">Auteurs</label> 
                        <!-- Je dois associer les values -->
                        <select id="authors" name="authors" class="form-control" value="<?= $book['author_id'] ?>"> 
                            <option value="">(selectionnez un auteur)</option>
                            <option value="">J.R.R Tolkien</option>
                            <option value="">J.K Rowling</option>
                            <option value="">Autre</option>
                        </select>
                    </div>
                    <input type="hidden" value="<? $book['id'] ?>" name="id">
                    <button class="btn btn-primary">Modifier</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>