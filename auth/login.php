<?php
session_start();




?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <div class="container">

    <h2>Login</h2>

    <form action="loginApi.php" method="POST">

       

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>

        <div class="bottom-text">
            New User?
            <a href="register.php">Create Account</a>
        </div>

    </form>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo "<p style='color:green'>" . htmlspecialchars($_SESSION['success']) . "</p>";
        unset($_SESSION['success']);
    }
    ?>
</div>
</body>

</html>