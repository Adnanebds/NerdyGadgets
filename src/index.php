<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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

</body>

</html>
