<?php require ('inc/header.php');
require_once ('functions/functions.php'); ?>
<?php
    if (!empty($_POST))
    {
        $errors = array();

        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
            $errors['username'] = "Le nom d'utilisateur n'est pas valide";
        else {
            require_once ('config/db.php');
            $req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $req->execute([$_POST['username']]);
            $user = $req->fetch();
            if (!empty($user))
                $errors['username'] = "Le nom d'utilisateur est déjà utilisé";
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = "L'email est invalide";
        else {
            $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $req->execute([$_POST['email']]);
            $user = $req->fetch();
            if (!empty($user))
                $errors['username'] = "Cet email est déjà utilisé";
        }

        if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm'])
            $errors['password'] = "Le mot de passe est invalide";

        if (empty($errors))
        {
            $req = $pdo->prepare("INSERT INTO users SET username = ?, email = ?, password = ?, confirmation_token = ?");
            $token = str_random(60);
            $req->execute([$_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_BCRYPT), $token]);
            $id = $pdo->lastInsertId();
            mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien\nhttp://localhost/camagru/confirm.php?id=$id&token=$token");
            $_SESSION['flash']['success'] = "Un email de confirmation a été envoyé";
            header('location: index.php');
            exit;
        }
    }
    if (!empty($errors))
        debug($errors);
?>
    <h1>S'inscrire</h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="password" name="password_confirm" placeholder="Confirmer mot de passe">
        <button type="submit">S'inscrire</button>
    </form>

<?php require ('inc/footer.php'); ?>