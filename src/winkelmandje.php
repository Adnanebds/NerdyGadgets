<?php
// Start the session before any output is sent
session_start();

include 'navbar.php';

// Function to remove a product from the cart
function removeFromCart($product_id)
{
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Handle removal when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    $remove_product_id = $_POST['product_id'];
    removeFromCart($remove_product_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (your HTML head section) ... -->
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-semibold mb-8">Winkelmand</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            // Initialize total price
            $total_price = 0;

            // Check if there are products in the cart
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                // Create a database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $db_name = "nerdy_gadgets_start";
                $conn = new mysqli($servername, $username, $password, $db_name);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Loop through the cart items and display product details
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    // Retrieve product details from the database
                    $sql = "SELECT * FROM product WHERE id = $product_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $product_name = $row['name'];
                        $product_price = $row['price'];
                        $product_image = $row['image'];

                        // Add product price multiplied by quantity to total
                        $total_price += $product_price * $quantity;

                        echo '<form method="post">';
                        echo '<div class="bg-white p-4 shadow-lg rounded-lg">';
                        echo '<img src="../pngs/product_images/' . $product_image . '.jpg" alt="productimage" class="w-full h-72 overflow-hidden rounded-lg bg-gray-200 xl:h-48 xl:w-64">';
                        echo '<h2 class="text-xl font-semibold">' . $product_name . '</h2>';
                        echo '<p class="text-gray-500 text-sm">Prijs: €' . number_format($product_price, 2) . '</p>';
                        echo '<div class="mt-4">';
                        echo '<label for="quantity" class="text-sm font-semibold">Aantal:</label>';
                        echo '<input type="number" id="quantity" class="border rounded-full p-1 text-sm w-16" value="' . $quantity . '">';
                        echo '</div>';
                        echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
                        echo '<button type="submit" name="remove_from_cart" class="mt-4 bg-blue-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-blue-700">Verwijder</button>';
                        echo '</div>';
                        echo '</form>';
                    }
                }

                // Close the database connection
                $conn->close();
            } else {
                // Display a message if the cart is empty
                echo '<p>Je winkelmandje is leeg.</p>';
            }
            ?>
        </div>
        <div class="mt-8 text-right">
            <!-- Display the calculated total price dynamically -->
            <p class="text-xl font-semibold">Totaal: €<?php echo number_format($total_price, 2); ?></p>
            <button class="mt-4 bg-green-500 text-white font-semibold px-6 py-3 rounded hover-bg-green-700">Afrekenen</button>
        </div>
    </div>
    <?php
    include 'footer.html';
    ?>
</body>

</html>
