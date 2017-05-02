<?php require_once ('functions/functions.php'); ?>
<?php
if (!empty($_POST))
{
    $errors = array();
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors['email'] = "L'email est invalide";
    if (empty($errors))
    {
        session_start();
        require_once('config/db.php');
        $req = $pdo->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if (!empty($user))
        {
            $reset_token = str_random(60);
            $req = $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
            mail($_POST['email'], 'Reinitialisation de votre mot de passe', "Afin de reinitialiser votre mot de passe, veuillez cliquer sur ce lien\nhttp://localhost/camagru/reset.php?id=$user->id&token=$reset_token");
            $_SESSION['flash']['success'] = "Les instructions vous on été envoyé par email";
            header('location: login.php');
            exit;
        }
        else
            $_SESSION['flash']['danger'] = "Aucun compte ne correspond a cet email";
    }
}
require ('inc/header.php');
?>
    <h1>Mot de passe oublié</h1>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email">
        <button type="submit">Retrouver</button>
    </form>

<?php require ('inc/footer.php'); ?>