<?php
session_start();

// 1. Validate CSRF Token
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Invalid CSRF token!");
}

// 2. Sanitize Input
$name    = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
$email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

// 3. Validate Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address!");
}

// 4. Save securely (Example: text file instead of DB)
$file = fopen("messages.txt", "a");
fwrite($file, "Name: $name\nEmail: $email\nMessage: $message\n---\n");
fclose($file);

// 5. Confirmation
echo "Message received securely. Thank you, $name!";
?>