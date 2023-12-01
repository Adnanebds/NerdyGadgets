<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
session_start(); // Start the session
include 'navbar.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nerdy_gadgets_start";

$user_id = null;

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    // Redirect or handle the case where the user is not logged in
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['image']) && isset($_GET['desc']) && isset($_GET['prijs']) && isset($_GET['name'])) {
    $productId = $_GET['id'];
    $image = $_GET['image'];
    $desc = $_GET['desc'];
    $prijs = $_GET['prijs'];
    $name = $_GET['name'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        // Check if the user has already reviewed the product
        $checkReviewSql = "SELECT * FROM review WHERE user_id = $user_id AND product_id = $productId";
        $existingReview = $conn->query($checkReviewSql);

        if ($existingReview->num_rows > 0) {
            echo "You have already reviewed this product!";
        } else {
            // User hasn't reviewed the product, proceed with inserting the review
            $stmt = $conn->prepare("INSERT INTO review (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $user_id, $productId, $rating, $comment);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Review added successfully!!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}
?>

<div class="bg-white">
    <div class="pt-6">
        <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
            <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                <?php echo "<img src='../pngs/product_images/$image.jpg' alt='productimage' class='h-full w-full object-cover object-center'>"; ?>
            </div>
        </div>
        <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
            <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"><?php echo $name; ?></h1>
            </div>

            <div class="mt-4 lg:row-span-3 lg:mt-0">
                <h2 class="sr-only">Product information</h2>
                <p class="text-3xl tracking-tight text-gray-900"><?php echo "€" . $prijs; ?></p>

                <!-- Reviews -->
                <div class="mt-6">
    <h3 class="sr-only">Reviews</h3>
    <form method="post">
        <div class="flex items-center">
            <!-- Star icons for rating selection -->
            <?php
            for ($i = 1; $i <= 5; $i++) {
                echo "<svg data-rating='$i' class='cursor-pointer text-gray-900 h-5 w-5 flex-shrink-0 star' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                        <path fill-rule='evenodd' d='M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z' clip-rule='evenodd' />
                    </svg>";
            }
            ?>
        </div>
        <br>
        <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <label for="comment" class="sr-only">Your comment</label>
            <textarea id="comment" name="comment" rows="6"
                class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                placeholder="Write a comment..." required></textarea>
        </div>
        <input type="hidden" id="rating" name="rating" value="">
        <button type="submit" class="mt-2 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit Review</button>
    </form>
</div>


                <!-- <form class="mt-10">
                    <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add to bag</button>
                </form> -->
            </div>

            <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                <div>
                    <h3 class="sr-only">Description</h3>

                    <div class="space-y-6">
                        <p class="text-base text-gray-900"><?php echo $desc; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.html';
?>

<script>
    // JavaScript to handle star rating selection
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => star.addEventListener('click', rate));

    function rate(event) {
        const rating = event.currentTarget.getAttribute('data-rating');
        ratingInput.value = rating;

        // Update star colors based on rating
        stars.forEach(star => {
            const starRating = star.getAttribute('data-rating');
            star.style.color = starRating <= rating ? '#FFD700' : '#D1D5DB';
        });
    }
</script>

</html>
