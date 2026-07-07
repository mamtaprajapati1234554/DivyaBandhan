<?php
 
session_start();
require_once("../config/database.php");
 
// Get Form Data
$profile_for = trim($_POST['profile_for'] ?? '');
$firstname = trim($_POST['firstname'] ?? '');
$lastname = trim($_POST['lastname'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');
 
// Validation
if (
    empty($profile_for) ||
    empty($firstname) ||
    empty($lastname) ||
    empty($gender) ||
    empty($dob) ||
    empty($email) ||
    empty($password) ||
    empty($confirm_password)
) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: register.php");
    exit;
}
 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid Email Address.";
    header("Location: register.php");
    exit;
}
 
if (strlen($password) < 8) {
    $_SESSION['error'] = "Password must be at least 8 characters.";
    header("Location: register.php");
    exit;
}
 
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: register.php");
    exit;
}
 
if (!isset($_POST['agree'])) {
    $_SESSION['error'] = "Please accept Terms & Conditions.";
    header("Location: register.php");
    exit;
}
 
try {
 
    // Check Email
    $check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $check->execute([
        ":email" => $email
    ]);
 
    if ($check->fetch()) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: register.php");
        exit;
    }
 
    // Hash Password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
    // Insert User
    $stmt = $pdo->prepare("
        INSERT INTO users
        (
            profile_for,
            first_name,
            last_name,
            email,
            password,
            gender,
            dob
        )
        VALUES
        (
            :profile_for,
            :first_name,
            :last_name,
            :email,
            :password,
            :gender,
            :dob
        )
    ");
 
    $stmt->execute([
        ":profile_for" => $profile_for,
        ":first_name"  => $firstname,
        ":last_name"   => $lastname,
        ":email"       => $email,
        ":password"    => $hashedPassword,
        ":gender"      => $gender,
        ":dob"         => $dob
    ]);
 
    // Get the new user's ID (auto-increment id just inserted)
    $newUserId = $pdo->lastInsertId();
 
    // Create a matching empty profile row, linked via user_id
    $profileStmt = $pdo->prepare("
        INSERT INTO profiles
        (user_id, religion, caste, education, occupation, salary, height, weight, city, state, about_me, profile_photo)
        VALUES
        (:user_id, '', '', '', '', '', '', '', '', '', '', NULL)
    ");
 
    $profileStmt->execute([
        ":user_id" => $newUserId
    ]);
 
    $_SESSION['success'] = "Registration Successful.";
 
    header("Location: login.php");
    exit;
 
} catch (PDOException $e) {
 
    $_SESSION['error'] = $e->getMessage();
    header("Location: register.php");
    exit;
}