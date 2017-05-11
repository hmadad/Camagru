<?php
require_once 'config/db.php';
require_once 'functions/functions.php';

session_start();

if (isset($_POST['del']))
{
    $pdo->prepare('DELETE FROM commentaires WHERE user_id = ? AND id = ?')->execute([$_SESSION['auth']->id, $_POST['del']]);
}

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
        <form action="like.php?vote=1&ref_id=<?= $article->id ?>" method="post" style="float: left">
            <button type="submit" class="button" style="background-color: #4CAF50"><span style="color: green">Like : </span> <?= $article->like_count; ?></button>
        </form>
        <form action="like.php?vote=-1&ref_id=<?= $article->id ?>" method="post" style="float: right">
            <button type="submit" class="button" style="background-color: #f44336"><span style="color: white">Dislike : </span> <?= $article->dislike_count; ?></button>
        </form>
        <div class="comment" style="width: 100%; margin-top: 50px;">
            <form action="" method="POST">
                <label for="message">Commentaire</label>
                <textarea name="message" rows="3" style="width: 100%" placeholder="Commentaire..."></textarea>
                <button type="submit" class="button" name="submit"><span>Envoyer</span></button>
            </form>
            <hr>
            <?php if (!empty($commentaires)) : ?>
                <?php foreach ($commentaires as $com) : ?>
                    <div class="comm" style="width: 100%; background-color: #eeeeee; border-radius: 20px; padding: 10px; box-sizing: border-box; margin: 10px 0;">
                        <?php if ($_SESSION['auth']->id == $com->user_id) : ?>
                        <form action="" method="post">
                            <button class="closebtn" name="del" style="border: none; color: red" value="<?= $com->id ?>">&times;</button>
                        </form>
                        <?php endif; ?>
                        <p><span style="color: rgb(0, 140, 186);"><?php ucfirst(showUser($com->user_id, $pdo)); ?></span> : <?= $com->message ?></p>
                        <p style="text-align: right"><?= $com->created_at ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        </div>
        <hr>
    <script>
        function delcom() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "http://localhost/cama/single.php", true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send("data="+data+"&elements="+elements);
        }
    </script>
<?php endif;
require 'inc/footer.php';
?>
