<?php
require_once 'config/db.php';
require_once 'functions/functions.php';

session_start();

if (isset($_POST['submit']))
{
    if (isset($_POST['message']))
    {
        $pdo->prepare('INSERT INTO commentaires SET user_id = ?, post_id = ?, message = ?, created_at = NOW()')->execute([$_SESSION['auth']->id, $_GET['id'], $_POST['message']]);
    }
    else
        $_SESSION['flash']['danger'] = "Commentaire vide";
}

if (isset($_GET['id'])) {
    $req = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute([$_GET['id']]);
    $article = $req->fetch();
    if ($req->rowCount() <= 0)
        $_SESSION['flash']['danger'] = "Aucun Article avec cet id";
    else {
        $req = $pdo->prepare('SELECT * FROM commentaires WHERE post_id = ? ORDER BY created_at DESC');
        $req->execute([$_GET['id']]);
        $commentaires = $req->fetchAll();
    }
} else
    $_SESSION['flash']['danger'] = "Aucun Article avec cet id";



require 'inc/header.php';

if (!empty($article)) : ?>
    <div class="galerie" style="width: 980px; margin: auto">
            <div class="articles" style="width: 500px; margin: auto">
                <img src="<?= $article->path; ?>" alt="" style="width: 320px; height: 250px;">
            </div>
        <form action="like.php?vote=1&ref_id=<?= $article->id ?>" method="post">
            <button type="submit"><span style="color: green">Like: </span><?= $article->like_count; ?></button>
        </form>
        <form action="like.php?vote=-1&ref_id=<?= $article->id ?>" method="post">
            <button type="submit"><span style="color: red">Dislike: </span><?= $article->dislike_count; ?></button>
        </form>
        <hr>
        <form action="" method="POST">
            <label for="message">Commentaire</label>
            <textarea name="message" rows="5" style="width: 100%"></textarea>
            <button type="submit" name="submit">Envoyer</button>
        </form>
        <hr>
        <?php if (!empty($commentaires)) : ?>
        <?php foreach ($commentaires as $com) : ?>
                <p><?php showUser($com->user_id, $pdo); ?>: <?= $com->message ?></p>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif;
require 'inc/footer.php';
?>
