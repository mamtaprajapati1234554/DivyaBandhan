<?php
session_start();
include("../config/database.php");
?>

<!DOCTYPE html>

<html>

<head>

<title>Shortlist</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include("../includes/dashboard-header.php"); ?>

<div class="container mt-5">

<h2>My Shortlisted Profiles</h2>

<?php

include("../includes/member-card.php");

?>

</div>

</body>

</html>