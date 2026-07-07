<?php

session_start();

require_once("../config/database.php");

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

// Get form data
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validate input
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and Password are required.";
    header("Location: login.php");
    exit();
}

try {

    // Find user by email
    $stmt = $pdo->prepare("
        SELECT 
            id,
            first_name,
            last_name,
            email,
            password,
            gender
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

    $stmt->execute([
        ':email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if (!$user) {
        $_SESSION['error'] = "Invalid Email or Password.";
        header("Location: login.php");
        exit();
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Invalid Email or Password.";
        header("Location: login.php");
        exit();
    }

    // Prevent session fixation
    session_regenerate_id(true);

    // Store session
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_name']  = $user['first_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['gender']     = $user['gender'];

    // Generate CSRF token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Redirect to dashboard
    header("Location: ../dashboard/index.php");
    exit();

} catch (PDOException $e) {

    error_log($e->getMessage());

    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: login.php");
    exit();
}