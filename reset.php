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
    <h1>Reinitialiser mot de passe</h1>
    <form action="" method="POST">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="password" name="password_confirm" placeholder="Mot de passe">
        <button type="submit">Reinitialiser</button>
    </form>

<?php require ('inc/footer.php'); ?>