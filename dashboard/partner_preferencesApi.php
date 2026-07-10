<?php
session_start();
require '../config/database.php'; // apna db connect file ka sahi path daalna

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // login session se user id
    $min_age = $_POST['min_age'];
    $max_age = $_POST['max_age'];
    $min_height = $_POST['min_height'];
    $max_height = $_POST['max_height'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $education = $_POST['education'];
    $min_income = $_POST['min_income'];
    $location = $_POST['location'];

    // Check already exists?
    $check = $pdo->prepare("SELECT id FROM partner_preferences WHERE user_id = ?");
    $check->execute([$user_id]);

    if ($check->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE partner_preferences 
            SET min_age=?, max_age=?, min_height=?, max_height=?, religion=?, caste=?, education=?, min_income=?, location=? 
            WHERE user_id=?");
        $stmt->execute([$min_age, $max_age, $min_height, $max_height, $religion, $caste, $education, $min_income, $location, $user_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO partner_preferences 
            (user_id, min_age, max_age, min_height, max_height, religion, caste, education, min_income, location) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $min_age, $max_age, $min_height, $max_height, $religion, $caste, $education, $min_income, $location]);
    }

    header("Location: partner_preferences.php?success=1");
    exit;
}
?>
