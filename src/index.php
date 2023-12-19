<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/output.css">
</head>

  <div class="navbar-container">
    <?php include 'navbar.php'; ?>
    <?php include 'hero.html'; ?>
    <br></br>
    <br></br>
    <?php include 'cards.php'; ?>
    <br></br>
    <br></br>
    <?php include 'testomonials.html'; ?>
    <?php include 'footer.html'; ?>
  </div>
</body>


</html>
<!DOCTYPE html>
<html>
<head>
    <title>YouTube Easter Egg</title>
    <style>
        #videoFrame {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Voeg een onzichtbaar iframe toe om de video te laden -->
<iframe id="videoFrame" width="560" height="315" style="display: none;" src="" frameborder="0" allowfullscreen></iframe>

<script>
    let secretCode = [];
    const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'KeyB', 'KeyA'];

    $(document).on('keydown', (event) => {
        secretCode.push(event.code);
        secretCode.splice(-konamiCode.length - 1, secretCode.length - konamiCode.length);
        if (secretCode.join('') === konamiCode.join('')) {
            const videoFrame = document.getElementById('videoFrame');
            videoFrame.style.display = 'block';
            videoFrame.src = 'https://www.youtube.com/embed/IOwLVfO_xZM?autoplay=1'; // Vervang YOUR_VIDEO_ID door de daadwerkelijke YouTube-video-ID
        }
    });
</script>

</body>
</html>
