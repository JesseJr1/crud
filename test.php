<?php
require_once('connect.php');

$allbooks = $db->query('SELECT * FROM `books` LEFT JOIN authors on authors.id = books.author_id');
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = htmlspecialchars($_GET['search']);
    $allbooks = $db->query('SELECT title FROM books WHERE title LIKE "%'.$search.'%" ORDER BY id DESC');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form method="GET">
<input type="search" name="search" placeholder="Rechercher un livre">
<input type="submit" name="submit">

</form>

<section class="afficher titre">

<?php 

    if($allbooks->rowCount() > 0){
        while($title = $allbooks->fetch()){
            ?>
            <tr>
                <td><?= $title['title']; ?></td>
                <td><?= $title['lastname']; ?></td>
                <td><?= $title['firstname']; ?></td>
                </tr>
            
            <?php
        }
    }else{
        ?>
        <p>erreur</p>
        <?php
    }

?>

</section>

</body>
</html>