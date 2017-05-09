<?php
require_once 'config/db.php';
/*                      PAGINATION                                    */
$req = $pdo->prepare('SELECT COUNT(id) as nbArt FROM articles');
$req->execute();
$nbArt = $req->fetch()->nbArt;
$perPage = 2;
$nbPage = ceil($nbArt / $perPage);

if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage)
    $cPage = $_GET['page'];
else
    $cPage = 1;

$req = $pdo->prepare('SELECT * FROM articles ORDER BY created_at DESC LIMIT '.(($cPage - 1)* $perPage).', '.$perPage);
$req->execute();
$pages = $req->fetchAll();
/*                      FIN PAGINATION                                    */
require 'inc/header.php';
?>

<div class="galerie" style="width: 980px; margin: auto">
    <?php foreach ($pages as $page) :?>
        <div class="articles" style="width: 320px; margin: auto; border: solid black 3px">
            <a href="single.php?id=<?= $page->id ?>">
                <img src="<?= $page->path; ?>" alt="" style="width: 320px; height: 250px;">
            </a>
            <hr>
            <form action="like.php?vote=1&ref_id=<?= $page->id ?>" method="post">
                <button type="submit"><span style="color: green">Like: </span><?= $page->like_count; ?></button>
            </form>
            <form action="like.php?vote=-1&ref_id=<?= $page->id ?>" method="post">
                <button type="submit"><span style="color: red">Dislike: </span><?= $page->dislike_count; ?></button>
            </form>
            <hr>
        </div>
    <?php endforeach; ?>
</div>

<?php
for ($i = 1; $i <= $nbPage; $i++)
    if ($i == $cPage)
        echo $i.' / ';
    else
        echo '<a href="galerie.php?page='.$i.'">'.$i.'</a> / ';
require 'inc/footer.php';
