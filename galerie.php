<?php
require_once 'config/db.php';
/*                      PAGINATION                                    */
$req = $pdo->prepare('SELECT COUNT(id) as nbArt FROM articles');
$req->execute();
$nbArt = $req->fetch()->nbArt;
$perPage = 6;
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
<div class="container">
    <h2>Galerie Photos</h2>
    <div class="photos" style="width: 100%">
        <?php foreach ($pages as $page) :?>
            <div class="articles" style="width: 320px; margin: 10px auto; border: solid rgb(51, 51, 51) 1px; border-radius: 5px;">
                <a href="single.php?id=<?= $page->id ?>">
                    <img src="<?= $page->path; ?>" alt="" style="width: 320px; height: 250px;">
                </a>
                <hr>
                <form action="like.php?vote=1&ref_id=<?= $page->id ?>" method="post" style="float: left">
                    <button class="button" type="submit" style="background-color: #4CAF50; width: 120px;"><span style="color: green">Like : </span> <?= $page->like_count; ?></button>
                </form>
                <form action="like.php?vote=-1&ref_id=<?= $page->id ?>" method="post" style="float: right">
                    <button class="button" type="submit" style="background-color: #f44336; width: 120px;"><span style="color: white">Dislike : </span> <?= $page->dislike_count; ?></button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
for ($i = 1; $i <= $nbPage; $i++)
    if ($i == $cPage)
        echo $i.' / ';
    else
        echo '<a href="galerie.php?page='.$i.'">'.$i.'</a> / ';
require 'inc/footer.php';
