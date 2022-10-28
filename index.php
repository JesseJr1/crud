<?php
// On démarre une session
session_start();

// On inclut la connexion à la base 
require_once('connect.php');

$sql = 'SELECT * FROM `books`';

// On prepare la requete 
$query = $db->prepare($sql);

// On execute la requete 
$query->execute();

// On stocke le résultat dans un tableau
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
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
                <h1>Liste des livres</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach ($result as $book) {
                        ?>
                            <tr>
                                <td><?= $book['id'] ?></td>
                                <td><?= $book['title'] ?></td>
                                <td><?= $book['author_id'] ?></td>
                                <td></td>
                                <td><a href="details.php?id=<?= $book['id']?>">Voir</a></td>
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