<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "nerdy_gadgets_start";

$conn = new mysqli($servername,$username,$password,$db_name);

$sql = "SELECT * FROM product;";
$sql_oplopend = "SELECT * FROM product ORDER BY price;";
$sql_afloped = "SELECT * FROM product ORDER BY price DESC;";

$all_product = $conn->query($sql);

?>


<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/product.css">
    </head>
<body>
        <?php
        include 'navbar.html';
        ?>
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="sr-only">Products</h2>
        <br>
        <div class="filter">
            <?php
            include 'Filter.php';
            ?>
        </div>

            <?php
                while($row = mysqli_fetch_assoc($all_product)){
            ?>
            <div class='test'>
                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <?php
                    foreach ($all_product as $row) {
                        $productId = $row['id'];
                        $image = $row['image'];
                        ?>
                        <a href="product_page.php?id=<?php echo $productId; ?>" class="group flex flex-col">
                            <div class="w-full h-72 overflow-hidden rounded-lg bg-gray-200 xl:h-48 xl:w-64">
                                <?php echo "<img src='../pngs/product_images/$image.jpg' alt='productimage' class='h-full w-full object-cover object-center group-hover:opacity-75'>"; ?>
                            </div>
                            <div class="p-4">
                                <h3 class="text-xl font-bold mt-2 text-gray-800" name="product_name"><?php echo $row['name']; ?></h3>
                                <p class="text-lg text-black" name="product_price">€<?php echo $row['price']; ?></p>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-full mt-2 hover:bg-blue-700">Voeg toe aan winkelwagen</button>
                            </div>
                        </a>
                        <?php
                    }
                    }
                    ?>
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
    <?php
        include 'footer.html';
    ?>
</body>