<?php

$is_invalid = FALSE;

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "nerdy_gadgets_start";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $conn = new mysqli($servername, $username, $password, $db_name);

    $sql = sprintf("SELECT * FROM user
            WHERE email = '%s'",
        $conn->real_escape_string($_POST['email']));

    $result = $conn->query($sql);

    $user = $result->fetch_assoc();

    print_r($user);

    if ($user){
        header("Location: index.php");
    } else{
        die("Ongeldige inlog");
    }
//    if ($user) {
//        print("User verified");
//        print("<br>" . $_POST['password'] . "<br>");
//
//        if (password_verify($_POST['password'], $user['password'])) {
//            die("login succesvol");
//        } elseif ($_POST['password'] === $user['password']) {
//            die("login succesvol");
//        }
//    }
//
//    $is_invalid = TRUE;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>

<body>

<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
                 alt="logo">
            Nerdy Gadgets
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Log in uw account
                </h1>
                <?php if ($is_invalid): ?>
                    <em class="text-red-500">Invalid login</em>
                <?php endif; ?>
                <form class="space-y-4 md:space-y-6" method="post" action="#">
                    <div>
                        <label for="email"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uw
                            email</label>
                        <input type="email" name="email" id="email"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Uw
                            Wachtwoord</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required="">
                    </div>
                    <div class="flex items-center justify-between">

                    </div>
                    <button type="submit"
                            class="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Log
                        in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Nog geen account? <a href="signup.html"
                                             class="font-medium text-primary-600 hover:underline dark:text-primary-500">Registreer
                            een account</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
</body>

</html>
