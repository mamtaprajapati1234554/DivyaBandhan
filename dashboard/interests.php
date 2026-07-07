<?php
session_start();
?>

<!DOCTYPE html>

<html>

<head>

<title>Interests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include("../includes/dashboard-header.php"); ?>

<div class="container mt-5">

<h3>Received Interests</h3>

<table class="table">

<tr>

<th>Name</th>

<th>Status</th>

<th>Action</th>

</tr>

<tr>

<td>Rahul</td>

<td>Pending</td>

<td>

<button class="btn btn-success btn-sm">

Accept

</button>

</td>

</tr>

</table>

</div>

</body>

</html>