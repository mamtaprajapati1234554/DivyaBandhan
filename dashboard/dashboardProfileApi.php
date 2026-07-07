<?php
session_start();
header('Content-Type: application/json');

include("../config/database.php");

// Session check

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => false,
        "message" => "Unauthorized"
    ]);
    exit();
}

$user_gender = $_SESSION['gender'] ?? null;



if (!$user_gender) {
    echo json_encode([
        "status" => false,
        "message" => "Gender not found"
    ]);
    exit();
}

try {

    $stmt = $pdo->prepare("
        SELECT
           u.id AS user_id,
            u.first_name,
            u.last_name,
            u.gender,
            u.dob,
            TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age,

            p.religion,
            p.caste,
            p.education,
            p.occupation,
            p.salary,
            p.height,
            p.weight,
            p.city,
            p.state,
            p.about_me,
            p.profile_photo

        FROM users u

        INNER JOIN profiles p
            ON u.id = p.user_id

        WHERE u.gender != :gender

        ORDER BY u.id DESC
    ");

    $stmt->bindValue(':gender', $user_gender, PDO::PARAM_STR);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "data" => $users
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}
