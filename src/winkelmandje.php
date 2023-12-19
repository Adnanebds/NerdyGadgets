<?php
include 'navbar.php';

function removeFromCart($product_id)
{
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    $remove_product_id = $_POST['product_id'];
    removeFromCart($remove_product_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function applyDiscount() {
            var enteredCode = document.getElementById('discountCodeInput').value;
            var storedCode = sessionStorage.getItem('discountCode');

            if (enteredCode === storedCode) {
                var currentTotal = parseFloat($('#totalPrice').text().replace(/[^\d.-]/g, ''));
                var discountedTotal = currentTotal * 0.9;

                $('#totalPrice').text('€' + discountedTotal.toFixed(2));
                $('#discountedTotalInput').val(discountedTotal);

                alert("Discount applied! 10% off your total price.");
            } else {
                alert("Invalid discount code. Please try again.");
            }

            return false; // Prevent form submission and page reload
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-semibold mb-8">Winkelmand</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            $total_price = 0;

            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $db_name = "nerdy_gadgets_start";
                $conn = new mysqli($servername, $username, $password, $db_name);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $sql = "SELECT * FROM product WHERE id = $product_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $product_name = $row['name'];
                        $product_price = $row['price'];
                        $product_image = $row['image'];

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
                        echo '<input type="text" id="discountCodeInput" placeholder="Enter discount code">';
                        echo '<button onclick="return applyDiscount()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Apply Discount
                        </button>';
                        echo '</form>';
                    }
                }

                $conn->close();
            } else {
                echo '<p>Je winkelmandje is leeg.</p>';
            }
            ?>
        </div>
        <div class="mt-8 text-right">
            <p id="totalPrice" class="text-xl font-semibold">Totaal: €<?php echo number_format($total_price, 2); ?></p>
            <input type="hidden" id="discountedTotalInput" name="discountedTotal" value="<?php echo $total_price; ?>">
            <button class="mt-4 bg-green-500 text-white font-semibold px-6 py-3 rounded hover-bg-green-700">Afrekenen</button>
        </div>
    </div>
    <?php
    include 'footer.html';
    ?>
</body>

</html>
