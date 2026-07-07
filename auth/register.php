<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="../assets/css/register.css">
</head>

<body>

    <div class="container">

        <form action="RegisterApi.php" method="POST">

            <h1>Create Your Account</h1>
            <p>Fill out the form to get started.</p>

            <label>Profile For</label>

            <select name="profile_for" required>
                <option value="">Select</option>
                <option value="Self">Self</option>
                <option value="Parents">Parents</option>
                <option value="Relatives">Relatives</option>
                <option value="Siblings">Siblings</option>
            </select>

            <label>First Name</label>
            <input type="text" name="firstname" placeholder="First Name" required>

            <label>Last Name</label>
            <input type="text" name="lastname" placeholder="Last Name" required>

            <label>Gender</label>

            <select name="gender" required>
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>

            <label>Date of Birth</label>
            <input type="date" name="dob" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter Email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <div class="checkbox">

                <input type="checkbox" name="agree" value="yes" id="agree"
                    required>

                <label>I agree to the Terms & Conditions</label>

            </div>

            <button type="submit" id="registerBtn" disabled>Create Account</button>

        </form>

        <?php

        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;text-align:center;margin-top:15px;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo "<p style='color:green;text-align:center;margin-top:15px;'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }

        ?>

    </div>

</body>

</html>


<script>
const checkbox = document.getElementById("agree");
const button = document.getElementById("registerBtn");

checkbox.addEventListener("change", function () {

    button.disabled = !this.checked;

});
</script>