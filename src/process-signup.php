<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "nerdy_gadgets_start";

// Check database connection
$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Print posted data for debugging
print_r($_POST);

// Validate user input
if (empty($_POST['name'])) {
    die('Naam is verplicht');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die('Geldige email is verplicht');
}

if (strlen($_POST['password']) < 8) {
    die("Wachtwoord moet langer zijn dan 8 tekens");
}

if (!preg_match('/[a-z]/i', $_POST['password'])) {
    die("Wachtwoord moet 1 of meer letter bevatten");
}

if (!preg_match('/[0-9]/i', $_POST['password'])) {
    die("Wachtwoord moet 1 of meer cijfer bevatten");
}

if ($_POST['password'] !== $_POST['password_confirmation']) {
    die("Wachtwoorden moeten hetzelfde zijn");
}

// Hashing the password using SHA-256
$password_hash = hash('sha256', $_POST['password']);

// Prepare SQL statement
$sql = "INSERT INTO user (first_name, email, password)
        VALUES(?,?,?)";

$stmt = $conn->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $conn->error);
}

// Bind parameters
$stmt->bind_param('sss', $_POST['name'], $_POST['email'], $password_hash);

// Execute the query
if ($stmt->execute()) {
    header("Location: signup-succes.html");
    exit;
} else {
    die("Execution failed: " . $stmt->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
