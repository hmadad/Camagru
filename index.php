<?php require 'inc/header.php' ?>
<h1>Bonjour<?php if(isset($_SESSION['auth'])) : echo " ".$_SESSION['auth']->username; endif;?></h1>
<?php require 'inc/footer.php' ?>
