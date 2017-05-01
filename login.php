<?php require ('inc/header.php');
require_once ('functions/functions.php'); ?>
<?php
if (!empty($_POST))
{
    $errors = array();

    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
        $errors['username'] = "Le nom d'utilisateur n'est pas valide";

    if (empty($_POST['password']))
        $errors['password'] = "Le mot de passe est invalide";

    if (empty($errors))
    {
        require_once('config/db.php');
        $req = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $req->execute([$_POST['username'], password_hash($_POST['password'], PASSWORD_BCRYPT)]);
        $user = $req->fetch();
        if (!empty($user))
        {
            $_SESSION['auth'] = $user;
            header('location: index.php');
        }
        else
            $_SESSION['flash']['danger'] = "Login ou mot de passe incorrect";
    }
}
if (!empty($errors))
    debug($errors);
?>
    <h1>Se connecter</h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="password" name="password" placeholder="Mot de passe">
        <button type="submit">S'inscrire</button>
    </form>

<?php require ('inc/footer.php'); ?>