<?php require_once ('functions/functions.php'); ?>
<?php
if (isset($_GET['id']) && isset($_GET['token']))
{
    require_once 'config/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    session_start();
    if ($user) {
        if (!empty($_POST))
        {
            if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm'])
            {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $req = $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                $req = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $req->execute([$user->username]);
                $_SESSION['auth'] = $req->fetch();
                $_SESSION['flash']['success'] = "Mot de passe reinitialisé avec succès";
                header('location: index.php');
                exit;
            }
        }

    } else {
        $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
        header('location: login.php');
        exit;
    }
}

if (!empty($_POST))
{

}
require ('inc/header.php');
?>
    <div class="container">
        <h1>Reinitialiser</h1>
        <form action="" method="POST" style="width: 100%">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
            <br />
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input type="password" name="password_confirm" placeholder="Confirmer mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
            <br />
            <button class="button" type="submit"><span>Reinitialiser</span></button>
        </form>
    </div>

<?php require ('inc/footer.php'); ?>