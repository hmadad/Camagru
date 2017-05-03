<?php
require_once 'config/db.php';

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
require 'inc/header.php';
?>

<div class="galerie" style="width: 980px; margin: auto">
    <?php foreach ($pages as $page) :?>
        <div class="articles" style="width: 500px; margin: auto">
            <img src="<?= $page->path; ?>" alt="" style="width: 500px; height: 500px;">
            <?= $page->like_count; ?>
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
