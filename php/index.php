<?php require_once('db_connexion.php');

// Insert query
if(!empty($_POST['name']) && !empty($_POST['message']) && !empty($_POST['published_date'])) {
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);
    $published_date = htmlspecialchars($_POST['published_date']);

    $queryInsert = $pdo->prepare("INSERT INTO `book`(`name`, `message`, `published_date`) VALUES(?,?,?)");
    $queryInsert->execute([$name, $message, $published_date]);

    header('Location: index.php');
}

// Select query
$querySelect = $pdo->prepare("SELECT DISTINCT name, message, published_date FROM book");
$querySelect->execute();
$comments = $querySelect->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Guest Book</title>
  </head>
  <body>
    <div class="container">
        <h1>Livre d'or</h1>
        <form name="frmGuestBook" method="POST" action="index.php">
            <p>
                <label for="name">Nom :</label>
                <input type="name" name="name" id="name" />
            </p>
            <p>
                <label for="message">Message :</label>
                <textarea name="message" id="message"></textarea>
            </p>
            <p>
                <label for="published_date">Date :</label>
                <input type="date" name="published_date" id="published_date" />
            </p>
            <button type="submit">Envoyer</button>
        </form>

        <? if($queryInsert) echo 'Messqge envoyé!'; ?>

        <!-- Afficher les commentaires -->
        <h3>Commentaires :</h3>
        
        <?php foreach($comments as $comment) { ?>
            <p><i><?= $comment['name']; ?> (<?= $comment['published_date']; ?>)</i> : "<i><?= $comment['message']; ?></i>".</p>
        <?php } ?>
    </div>
  </body>
</html>
