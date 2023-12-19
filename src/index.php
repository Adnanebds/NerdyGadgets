<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    <script>
        function checkGuess() {
            var guessedWord = prompt("Guess the secret word:");

            if (guessedWord.toLowerCase() === "easter") {
                // Generate a random discount code
                var discountCode = generateDiscountCode();

                // Save the discount code in session storage
                sessionStorage.setItem('discountCode', discountCode);

                // Display the discount code
                alert("Congratulations! You found the Easter egg!\nYour discount code: " + discountCode);
            } else {
                alert("Sorry, that's not the correct word. Keep trying!");
            }
        }

        function generateDiscountCode() {
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var code = '';

            for (var i = 0; i < 8; i++) {
                code += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            return code;
        }
    </script>
</head>

<body class="bg-gray-100">

    <div class="navbar-container">
        <?php include 'navbar.php'; ?>
        <?php include 'hero.html'; ?>
        <br>
        <br>
        <?php include 'cards.php'; ?>
        <br>
        <br>
        <div class="flex justify-center items-center">
            <!-- Styled button using Tailwind CSS -->
            <button onclick="checkGuess()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Gok het woord
            </button>
        </div>
        <br>
        <br>
        <?php include 'testomonials.html'; ?>
        <?php include 'footer.html'; ?>
    </div>

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

</body>



