<?php
require_once 'functions/functions.php';
if (!isConnected())
{
    header('location: login.php');
    exit;
}

require_once 'config/db.php';

if (isset($_POST['submit']) && isset($_POST['path']))
{
    $req = $pdo->prepare("DELETE FROM articles WHERE id = ?");
    $req->execute([$_POST['submit']]);
    unlink($_POST['path']);
}

$req = $pdo->prepare("SELECT * FROM articles WHERE user_id = ? ORDER BY created_at DESC;");
$req->execute([$_SESSION['auth']->id]);
$photos = $req->fetchAll();


require 'inc/header.php' ?>
<div class="container">
    <div class="main">
        <h1>Bonjour <?php echo ucfirst($_SESSION['auth']->username);?></h1>
        <p>Bienvenue sur la page montage. </p>
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <?php radio(); ?>
            <br />
            <div class="vid" style="width: 320px; height: auto; margin: auto; text-align: center">
                <video id="video" style="border: solid 2px #eee; border-radius: 20px; height: 240px; width: 320px; display: block"></video>
                <canvas id="canvas"></canvas>
                <button type="button" class="button" id="startbutton">Capturer</button>
            </div>
            <h4 style="text-align: center">Ou</h4>
            <div class="upl"  style="width: 320px; height: auto; margin: auto; text-align: center">
                <input type="file" name="data">
                <button type="submit" class="button" name="submit" style="vertical-align:middle"><span>Envoyer</span></button>
            </div>
        </form>

        <p>Amuse toi ;)</p>
    </div>
    <div class="sidebar" style="border: solid 2px #eee; border-radius: 20px;">
        <h2>Mes photos</h2>
        <?php if (!empty($photos)) :?>
        <?php foreach ($photos as $photo) :?>
                <img src="<?= $photo->path ?>" alt="" style="width: 100%; height: 187px">
                    <input type="hidden" value="<?= $photo->path ?>" name="path">
                    <button type="submit" name="submit" value="<?= $photo->id ?>" style="background-color: transparent; border: none; margin: 0; padding: 0; font-size: 35px; color: red; float: left; cursor: pointer">&times;</button>
                <p style="text-align: right"><?= $photo->created_at ?></p>
                <hr>
        <?php endforeach; ?>
        <?php else :?>
        <?php echo '<h3 style="text-align: center; color: #f44336">Pas de photo</h3>'?>
        <?php endif; ?>
    </div>
</div>
<script>
    (function() {

        var streaming = false,
            video        = document.querySelector('#video'),
            cover        = document.querySelector('#cover'),
            canvas       = document.querySelector('#canvas'),
            startbutton  = document.querySelector('#startbutton'),
            width = 320,
            height = 0;

        navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function(stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.src = vendorURL.createObjectURL(stream);
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
        );

        video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                streaming = true;
            }
        }, false);


        function takepicture() {
            var radio = document.querySelector('input[name=elements]:checked').value;
            canvas.width = 320;
            canvas.height = 240;
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/jpeg');
            var elements = radio;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "http://localhost:8080/Camagru/upload.php", true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send("data="+data+"&elements="+elements);
            document.location.href="http://localhost:8080/Camagru/"
        }

        startbutton.addEventListener('click', function(ev){
            takepicture();
            ev.preventDefault();
        }, false);

    })();
</script>
<?php require 'inc/footer.php' ?>
