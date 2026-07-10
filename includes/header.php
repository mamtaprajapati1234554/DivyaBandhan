<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['user_name'] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DivyaBandhan Dashboard</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<header class="header">

    <div class="logo">
        <a href="../dashboard/index.php">
            ❤️ DivyaBandhan
        </a>
    </div>

    <div class="profile-menu">

        <button class="profile-btn" id="profileBtn">

            <i class="fa-solid fa-circle-user"></i>

            <span><?= htmlspecialchars($userName); ?></span>

            <i class="fa-solid fa-chevron-down"></i>

        </button>

        <div class="dropdown" id="dropdown">

            <a href="../dashboard/profile.php">
                <i class="fa-solid fa-user"></i>
                My Profile
            </a>

            <a href="../dashboard/edit-profile.php">
                <i class="fa-solid fa-user-pen"></i>
                Edit Profile
            </a>

            <a href="../dashboard/upload-photo.php">
                <i class="fa-solid fa-camera"></i>
                Upload Photos
            </a>

            <a href="../dashboard/partner_preferences.php">
                <i class="fa-solid fa-heart"></i>
                Partner Preference
            </a>

            <a href="../dashboard/search.php">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search Profiles
            </a>

            <a href="../dashboard/interests.php">
                <i class="fa-solid fa-envelope"></i>
                Interests
            </a>

            <a href="../dashboard/messages.php">
                <i class="fa-solid fa-comments"></i>
                Messages
            </a>

            <a href="../dashboard/settings.php">
                <i class="fa-solid fa-gear"></i>
                Settings
            </a>

            <hr>

            <a href="../auth/logout.php" class="logout">

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </a>

        </div>

    </div>

</header>

<script>
const profileBtn = document.getElementById("profileBtn");
const dropdown = document.getElementById("dropdown");

profileBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    dropdown.classList.toggle("show");
});

document.addEventListener("click", function () {
    dropdown.classList.remove("show");
});
</script>