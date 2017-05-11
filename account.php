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
            $_SESSION['flash']['success'] = "Mot de passe modifier avec succ�s";
        }
    }
}
require 'inc/header.php' ?>
<div class="container">
    <h1 style="">Bonjour <?php echo ucfirst($_SESSION['auth']->username); ?></h1>
    <form action="" method="POST" style="width: 100%">
        <label for="old_password">Ancien mot de passe</label>
        <input type="password" name="old_password" placeholder="Ancien mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" name="new_password" placeholder="Nouveau mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <label for="password_confim">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" placeholder="Confirmation mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <button class="button" type="submit"><span>Modifier</span></button>
    </form>
</div>
<?php require 'inc/footer.php' ?>
