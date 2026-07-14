<?php
session_start();
require_once("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id=?");
$stmt->execute([$user_id]);

$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$isEdit = isset($_GET['mode']) && $_GET['mode']=="edit";
?>