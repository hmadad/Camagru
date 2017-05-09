<?php
require_once 'functions/functions.php';
if (!isConnected())
{
    header('location: login.php');
}
require 'inc/header.php' ?>
<div class="container">
    <h1>Bonjour <?php echo $_SESSION['auth']->username;?></h1>
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <?php radio(); ?>
        <br />
            <input type="file" name="data">
            <button type="submit" name="submit">Envoyer</button>
    </form>
    <video id="video"></video>
    <button id="startbutton">Prendre une photo</button>
    <canvas id="canvas"></canvas>
    <img src="" id="photo" alt="photo">
</div>
<script>
    (function() {

        var streaming = false,
            video        = document.querySelector('#video'),
            cover        = document.querySelector('#cover'),
            canvas       = document.querySelector('#canvas'),
            photo        = document.querySelector('#photo'),
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
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        function takepicture() {
            var radio = document.querySelector('input[name=elements]:checked').value;
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/jpeg');
            var elements = radio;
            photo.setAttribute('src', data);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "http://localhost:8080/Camagru/upload.php", true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send("data="+data+"&elements="+elements);
        }

        startbutton.addEventListener('click', function(ev){
            takepicture();
            ev.preventDefault();
        }, false);

    })();
</script>
<?php require 'inc/footer.php' ?>
