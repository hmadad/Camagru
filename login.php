<?php require_once ('functions/functions.php'); ?>
<?php
session_start();
if (!empty($_POST))
{
    $errors = array();

    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
        $_SESSION['flash']['danger'] = "Le nom d'utilisateur n'est pas valide";

    if (empty($_POST['password']))
        $_SESSION['flash']['danger'] = "Le mot de passe est invalide";

    if (empty($_SESSION['flash']))
    {
        require_once('config/db.php');
        $req = $pdo->prepare("SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL");
        $req->execute(['username' => $_POST['username']]);
        $user = $req->fetch();
        if (!empty($user) && password_verify($_POST['password'], $user->password))
        {
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = "Vous êtes maintenant connecté";
            header('location: index.php');
            exit;
        }
        else
            $_SESSION['flash']['danger'] = "Login ou mot de passe incorrect";
    }
}
require ('inc/header.php');
?>
    <h1>Se connecter</h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur Ou Email">
        <input type="password" name="password" placeholder="Mot de passe">
        <button type="submit">S'inscrire</button>
    </form>
    <a href="forget.php">Mot de passe oublié</a>

<?php require ('inc/footer.php'); ?>