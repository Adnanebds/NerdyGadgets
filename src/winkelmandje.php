<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmand</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<?php
    include 'navbar.html';
?>
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-semibold mb-8">Winkelmand</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Product 1 -->
        <div class="bg-white p-4 shadow-lg rounded-lg">
            <img src="product1.jpg" alt="Product 1" class="w-full h-32 object-cover object-center mb-4">
            <h2 class="text-xl font-semibold">Productnaam 1</h2>
            <p class="text-gray-500 text-sm">Prijs: $19.99</p>
            <div class="mt-4">
                <label for="quantity" class="text-sm font-semibold">Aantal:</label>
                <input type="number" id="quantity" class="border rounded-full p-1 text-sm w-16" value="1">
            </div>
            <button class="mt-4 bg-blue-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-blue-700">Verwijder</button>
        </div>
    </div>
    <div class="mt-8 text-right">
        <p class="text-xl font-semibold">Totaal: $59.97</p>
        <button class="mt-4 bg-green-500 text-white font-semibold px-6 py-3 rounded hover:bg-green-700">Afrekenen</button>
    </div>
</div>
<?php
    include 'footer.html';
?>
</body>
</html>
