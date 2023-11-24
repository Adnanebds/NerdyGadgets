<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/product.css">
</head>

<body>
<?php include 'navbar.html'; ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "nerdy_gadgets_start";

$conn = new mysqli($servername, $username, $password, $db_name);

$sql = "SELECT * FROM product " . (isset($_GET['cat']) ? "WHERE category = '" . $_GET['cat'] . "'" : "") . (isset($_GET['price']) ? " ORDER BY price " . $_GET['price'] : '') . ";";

$sql_oplopend = "SELECT * FROM product ORDER BY price;";
$sql_afloped = "SELECT * FROM product ORDER BY price DESC;";

$all_product = $conn->query($sql);

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the product was added to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + 1 : 1;

    // Set success message
    $_SESSION['success_message'] = "Product succesvol toegevoegd aan het winkelmand!";
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<div class="flex justify-between w-full h-full">
    <div class="min-w-[12rem] h-full mt-20 pl-8 pr-4">
        <p class="text-2xl font-medium">Filters</p>
        <div class="mt-4">

            <p class="font-xl font-medium">Categorieën</p>
            <div class="mt-2">
                <?php

                $query = $conn->query("SELECT COUNT(*) as count FROM product");

                $totalCount = $query->fetch_assoc();
                $totalCount = $totalCount['count']

                ?>
                <a href="Product.php"
                   class="cursor-pointer my-1 w-full flex items-center justify-between group"><span
                            class="<?php !isset($_GET['cat']) ? print('underline') : print('group-hover:underline') ?>">Alles</span>
                    <span>(<?php echo $totalCount ?>)</span></a>

                <?php

                $query = $conn->query("SELECT DISTINCT COUNT(*) as count, category FROM product GROUP BY category");

                while ($row = $query->fetch_assoc()) {
                    ?>

                    <a href="Product.php?cat=<?php echo $row['category'] ?>"
                       class="cursor-pointer my-1 w-full flex items-center justify-between group"><span
                                class="<?php isset($_GET['cat']) && $_GET['cat'] === $row['category'] ? print('underline') : print('group-hover:underline') ?>"><?php echo strtoupper(substr($row['category'], 0, 1)) . substr($row['category'], 1) ?></span>
                        <span>(<?php echo $row['count'] ?>)</span></a>

                    <?php
                }
                ?>
            </div>

            <p class="mt-4 font-xl font-medium">Prijs</p>
            <div class="mt-2">
                <a href="<?php echo "Product.php?" . (isset($_GET['cat']) ? 'cat=' . $_GET['cat'] : '') ?>" class="<?php !isset($_GET['price']) ? print('underline') : print('hover:underline') ?> cursor-pointer my-1 w-full flex items-center justify-between group">Aanbevolen</a>
                <a href="<?php echo "Product.php?price=asc" . (isset($_GET['cat']) ? '&cat=' . $_GET['cat'] : '') ?>" class="<?php isset($_GET['price']) && $_GET['price'] === 'asc' ? print('underline') : print('hover:underline') ?> cursor-pointer my-1 w-full flex items-center justify-between group">Oplopend</a>
                <a href="<?php echo "Product.php?price=desc" . (isset($_GET['cat']) ? '&cat=' . $_GET['cat'] : '') ?>" class="<?php isset($_GET['price']) && $_GET['price'] === 'desc' ? print('underline') : print('hover:underline') ?> cursor-pointer my-1 w-full flex items-center justify-between group">Aflopend</a>
            </div>

        </div>
    </div>
    <div class="border-l w-full mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <!-- Check if success message is set and display it -->
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div id="snackbar"
                 class="fixed bottom-4 right-4 bg-green-300 text-green-800 p-4 rounded-md flex items-center">
                <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <?php echo $_SESSION['success_message']; ?>
            </div>

            <script>
                // Automatically close the snackbar after 5 seconds
                setTimeout(function () {
                    var snackbar = document.getElementById("snackbar");
                    snackbar.style.display = "none";
                }, 5000);
            </script>

            <?php
            // Unset the success message after displaying it
            unset($_SESSION['success_message']);
            ?>
        <?php endif; ?>

        <h2 class="sr-only">Products</h2>

        <div>
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                <?php
                while ($row = mysqli_fetch_assoc($all_product)) {
                    $productId = $row['id'];
                    $image = $row['image'];
                    $desc = $row['description'];
                    $prijs = $row['price'];
                    $name = $row['name'];
                    $category = $row['category'];
                    ?>
                    <a href="product_page.php?id=<?php echo $productId; ?>&image=<?php echo urlencode($image); ?>&desc=<?php echo urlencode($desc); ?>&prijs=<?php echo urlencode($prijs); ?>&name=<?php echo urlencode($name); ?>&category=<?php echo urlencode($category); ?>"
                       class="group flex flex-col h-full">
                        <div class="w-full h-[250px] flex items-center justify-center">
                            <?php echo "<img src='../pngs/product_images/$image.jpg' alt='productimage' class='max-h-full max-w-full group-hover:opacity-75'>"; ?>
                        </div>
                        <div class="p-4 flex items-end h-full">
                            <div class="flex flex-col">
                                <h3 class="text-xl font-bold mt-3 mb-1 text-gray-800"
                                    name="product_name"><?php echo $row['name']; ?></h3>
                                <p class="text-lg text-black mt-1 mb-2" name="product_price">
                                    €<?php echo $row['price']; ?></p>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <button type="submit" name="add_to_cart"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-full h-full hover:bg-blue-700">
                                        Voeg toe aan winkelwagen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br><br>
<br>
<?php include 'footer.html'; ?>


</body>

</html>

</div>
</body>