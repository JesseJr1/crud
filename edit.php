<?php
// On démarre une session
session_start();
$_SESSION['erreur'] = "";
$_SESSION['message'] = "";

if (isset($_POST['edit'])) { //var_dump($_POST); die();
    if (
        isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['books']) && !empty($_POST['books'])
        && isset($_POST['author_id']) && !empty($_POST['author_id'])
    ) {
        // On inclut la connexion à la base 
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = $_POST['id'];
        $titleBook = strip_tags($_POST['books']);
        $idAuthor = strip_tags($_POST['author_id']);

        $sql = 'UPDATE `books` SET `title`=:title, `author_id`=:author_id WHERE `id`=:id';
        
        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':title', $titleBook, PDO::PARAM_STR);
        $query->bindValue(':author_id', $idAuthor, PDO::PARAM_INT);

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
                        <select id="authors" name="author_id" class="form-control" value="<?= $book['author_id'] ?>">
                            <?php foreach ($authors as $author) {
                                echo '<option value="' . $author['id'] . '">' . $author['firstname'] . " " . $author['lastname'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" value="<?php echo $book['id']; ?>" name="id">
                    <button type="submit" class="btn btn-primary" name="edit">Modifier</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>