<?php
// On démarre une session
session_start();

// On inclut la connexion à la base 
require_once('connect.php');


if ($_POST) {
    if (
        isset($_POST['books']) && !empty($_POST['books'])
        && isset($_POST['author_id']) && !empty($_POST['author_id'])
    ) {
        // On inclut la connexion à la base 
        require_once('connect.php');

        // On nettoie les données envoyées
        $book = strip_tags($_POST['books']);
        $authors = strip_tags($_POST['author_id']);


        $sql = 'INSERT INTO `books` (`title`,`author_id`) VALUES (:title, :author_id);';
        // Utilisation de "LIKE" ou "WHERE?   (Je pense devoir joindre les tables)


        $query = $db->prepare($sql);

        $query->bindValue(':title', $book, PDO::PARAM_STR);
        $query->bindValue(':author_id', $authors, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Livre aujouté";
        require_once('close.php');
        header('location: index.php');
    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplete";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>

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
                <h1>Ajout de livre</h1>
                <form method="post">

                    <div class="form-group">
                        <label for="books">Livre</label>
                        <input type="text" id="books" name="books" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="authors">Auteurs</label>
                        <select id="authors" name="author_id" class="form-control">
                            <?php foreach ($authors as $author) {
                                var_dump($author); 
                                echo '<option value="' . $author['id'] . '">' . $author['firstname'] . " " . $author['lastname'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    </div>
                    <button class="btn btn-primary">Ajout du livre</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>