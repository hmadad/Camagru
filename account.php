<?php
require_once('functions/functions.php');
if (!isConnected())
{
    header('location: login.php');
    exit;
}
if (!empty($_POST))
{
    $errors = array();

    if (empty($_POST['new_password']) || empty($_POST['password_confirm']))
        $errors['password'] = "Le mot de passe est invalide";

    if ($_POST['new_password'] != $_POST['password_confirm'])
        $errors['same'] = "Les mots de passe ne sont pas identiques";
    if (empty($errors))
    {
        require_once 'config/db.php';
        $req = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $req->execute([$_SESSION['auth']->username]);
        $user = $req->fetch();
        if (!password_verify($_POST['old_password'], $user->password))
            $errors['password'] = "L'ancien mot de passe est incorrect";
        else
        {
            $req = $pdo->prepare("UPDATE users SET password = ?");
            $req->execute([password_hash($_POST['new_password'], PASSWORD_BCRYPT)]);
            $req = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $req->execute([$_SESSION['auth']->username]);
            $_SESSION['auth'] = $req->fetch();
            $_SESSION['flash']['success'] = "Mot de passe modifier avec succès";
        }
    }
}
require 'inc/header.php' ?>

<h1>Bonjour <?php echo $_SESSION['auth']->username; ?></h1>

<form action="" method="POST">
    <input type="password" name="old_password" placeholder="Ancien mot de passe">
    <input type="password" name="new_password" placeholder="Nouveau mot de passe">
    <input type="password" name="password_confirm" placeholder="Confirmation mot de passe">
    <button type="submit">Modifier</button>
</form>

<?php require 'inc/footer.php' ?>
