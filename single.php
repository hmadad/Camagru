<?php
require_once 'config/db.php';

session_start();

if (isset($_GET['id'])) {
    $req = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute([$_GET['id']]);
    $article = $req->fetch();
    if ($req->rowCount() <= 0)
        $_SESSION['flash']['danger'] = "Aucun Article avec cet id";
} else
    $_SESSION['flash']['danger'] = "Aucun Article avec cet id";

require 'inc/header.php';

if (!empty($article)) : ?>
    <div class="galerie" style="width: 980px; margin: auto">
            <div class="articles" style="width: 500px; margin: auto">
                <img src="<?= $article->path; ?>" alt="" style="width: 500px; height: 500px;">
                <?= $article->like_count; ?>
            </div>
    </div>
<?php endif;
require 'inc/footer.php';
?>
