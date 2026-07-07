<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="home-navbar">

    <!-- Logo -->
    <div class="logo">
        <a href="index.php">
            <span class="heart">❤</span> DivyaBandhan
        </a>
    </div>

    <!-- Navigation -->
    <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="matrimonial/search.php">Search</a></li>
        <li><a href="active-members.php">Members</a></li>
        <li><a href="success-stories.php">Success Stories</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>

    <!-- Right Buttons -->
    <div class="auth-buttons">

        <?php if(isset($_SESSION['user_id'])) { ?>

            <a href="dashboard/" class="dashboard-btn">
                Dashboard
            </a>

            <a href="auth/logout.php" class="logout-btn">
                Logout
            </a>

        <?php } else { ?>

            <a href="auth/login.php" class="login-btn">
                Login
            </a>

            <a href="auth/register.php" class="register-btn">
                Register
            </a>

        <?php } ?>

    </div>

</nav>