<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "nerdy_gadgets_start";

$conn = new mysqli($servername, $username, $password, $db_name);

print_r($_POST);

if (empty($_POST['name'])){
    die('Naam is verplicht');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die('Geldige email is verplicht');
}

if (strlen($_POST['password']) < 8){
    die("Wachtwoord moet langer zijn dan 8 tekens");
}

if( ! preg_match('/[a-z]/i', $_POST['password'])){
    die("Wachtwoord moet 1 of meer letter bevatten");
}

if( ! preg_match('/[0-9]/i', $_POST['password'])){
    die("Wachtwoord moet 1 of meer cijfer bevatten");
}

if($_POST['password'] !== $_POST['password_confirmation']){
    die("Wachtwoorden moeten hetzelfde zijn");
}

// Hashing the password using SHA-256
$password_hash = hash('sha256', $_POST['password']);

$sql = "INSERT INTO user (first_name, email, password)
        VALUES(?,?,?)";

$stmt = $conn->stmt_init();

if( ! $stmt->prepare($sql)){
    die("SQL error:" . $conn->error);
}

$stmt->bind_param('sss',
    $_POST['name'],
    $_POST['email'],
    $password_hash);

if($stmt->execute()) {
    header("Location: signup-succes.html");
    exit;
} else {
    die($conn->error . ' ' . $conn->error);
}
?>
