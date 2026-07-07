<?php
session_start();
?>

<!DOCTYPE html>

<html>

<head>

<title>Settings</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include("../includes/dashboard-header.php"); ?>

<div class="container mt-5">

<h2>Settings</h2>

<form>

<div class="mb-3">

<label>Change Password</label>

<input type="password" class="form-control">

</div>

<button class="btn btn-primary">

Save

</button>

</form>

</div>

</body>

</html>