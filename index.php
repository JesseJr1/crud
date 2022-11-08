<?php
// On démarre une session
session_start();

// On inclut la connexion à la base 
require_once('connect.php');

$allbooks = $db->query('SELECT * FROM `books` ORDER BY id DESC');
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = htmlspecialchars($_GET['search']);
    $allbooks = $db->query('SELECT title FROM books WHERE title LIKE "%'.$search.'%" ORDER BY id DESC');
}
$sql = 'SELECT books.*, authors.firstname, authors.lastname FROM books LEFT JOIN authors on authors.id = books.author_id;';

// On prepare la requete 
$query = $db->prepare($sql);

// On execute la requete 
$query->execute();

// On stocke le résultat dans un tableau
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');

###### POUR LE FILTRE ######
// <div>
// <form method="GET">
// <input type="search" name="title-search" placeholder="Rechercher un livre">
// <input type="submit" name="submit">
// <!-- <input type="search" name="author-search" placeholder="Rechercher un auteur">
// <input type="submit" name="submit">
// </form> -->
// </div>

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheque</title>

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
                <?php
                if (!empty($_SESSION['message'])) {
                    echo '<div class="alert alert-success" role="alert">
                            ' . $_SESSION['message'] . '
                            </div>';
                    $_SESSION['message'] = "";
                }
                ?>
                <h1>Liste des livres</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Détails</th>
                        <th>Supprimer</th>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach ($result as $book) {
                        ?>
                            <tr>
                                <td><?= $book['id'] ?></td>
                                <td><?= $book['title'] ?></td>
                                <td><?= $book['firstname'] . " " . $book['lastname'] ?></td>
                                <td><a href="details.php?id=<?= $book['id'] ?>">Voir</a> <a href="edit.php?id=<?= $book['id'] ?>">Modifier</a></td>
                                <td><a href="delete.php?id=<?= $book['id'] ?>">Supprimer</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un livre</a>
            </section>
        </div>
    </main>
</body>

</html>