<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/output.css">
    <style>
        .image {
            height: 270px;
            width: 270px;
        }

        .image2 {
            height: 270px;
            width: 450px;
        }

        .card-container {
            display: flex;
            gap: 20px;
            margin-left: 180px;
        }
    </style>
    <?php
    $is_invalid = false;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "nerdy_gadgets_start";

    $conn = new mysqli($servername, $username, $password, $db_name);

    $sql = sprintf("SELECT DISTINCT product.id, product.name, product.description, product.price, product.category, product.image, order_item.quantity 
               FROM product 
               LEFT JOIN order_item ON product.id = order_item.product_id
               ORDER BY order_item.quantity DESC
               LIMIT 4");

    $result = $conn->query($sql);
    ?>

</head>

<body>
    <div class="mx-auto max-w-screen-sm ml-400">
        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Aanbevolen producten</h2>
    </div>
    <br>
    <div class="card-container">
        <?php
        while ($row = $result->fetch_assoc()) {
            $image = $row['image'];
        ?>
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full h-72 overflow-hidden rounded-lg bg-gray-200 xl:h-48 xl:w-64">
                <a href="#">
                <?php echo "<img src='../pngs/product_images/$image.jpg' alt='productimage' class='h-full w-full object-cover object-center group-hover:opacity-75'>"; ?>
                </a>
        </div>
                <div class="px-5 pb-5">
                    <a href="#">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white"><?php echo $row['name']; ?></h5>
                    </a>
                    <!-- Additional code for ratings and other details here -->
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">€<?php echo $row['price']; ?></span>
                    </div>
                </div>
            </div>
        <?php
        }
        $result->free();
        $conn->close();
        ?>
    </div>
</body>

</html>
