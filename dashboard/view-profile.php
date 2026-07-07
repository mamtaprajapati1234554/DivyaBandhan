<?php
session_start();

require_once("../config/database.php");

// ID check
if (!isset($_GET['id'])) {
    die("Profile not found.");
}

$id = intval($_GET['id']);

// Profile Fetch
$sql = "SELECT
            u.id,
            u.first_name,
            u.last_name,
            u.gender,
            u.dob,

            p.*
        FROM users u
        INNER JOIN profiles p
        ON u.id=p.user_id
        WHERE u.id=?";

$stmt=$pdo->prepare($sql);
$stmt->execute([$id]);

$profile=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$profile){
    die("Profile Not Found");
}

// Age Calculate
$age="";

if(!empty($profile['dob'])){
    $age=date_diff(date_create($profile['dob']),date_create('today'))->y;
}

// Photo
$photo="../uploads/default.png";

if(!empty($profile['profile_photo'])){
    $photo="../uploads/".$profile['profile_photo'];
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>View Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f5f5;
}

.profile-box{
background:#fff;
padding:25px;
border-radius:12px;
box-shadow:0 0 10px rgba(0,0,0,.1);
}

.profile-photo{
width:250px;
height:300px;
object-fit:cover;
border-radius:10px;
}

.table td{
padding:10px;
}

</style>

</head>

<body>

<div class="container my-5">

<div class="profile-box">

<div class="row">

<div class="col-md-4 text-center">

<img src="<?= $photo ?>" class="profile-photo">

<h3 class="mt-3">

Profile ID :
DVB<?= str_pad($profile['id'],4,'0',STR_PAD_LEFT); ?>

</h3>

</div>

<div class="col-md-8">

<ul class="nav nav-tabs" id="myTab">

<li class="nav-item">

<button class="nav-link active"
data-bs-toggle="tab"
data-bs-target="#about">

About Me

</button>

</li>

<li class="nav-item">

<button class="nav-link"
data-bs-toggle="tab"
data-bs-target="#family">

Family Details

</button>

</li>

<li class="nav-item">

<button class="nav-link"
data-bs-toggle="tab"
data-bs-target="#partner">

Partner Preference

</button>

</li>

</ul>

<div class="tab-content mt-4">

<!-- ABOUT -->

<div class="tab-pane fade show active"
id="about">

<table class="table">

<tr>
<td><b>Gender</b></td>
<td><?= $profile['gender']; ?></td>
</tr>

<tr>
<td><b>Age</b></td>
<td><?= $age; ?></td>
</tr>

<tr>
<td><b>Religion</b></td>
<td><?= $profile['religion']; ?></td>
</tr>

<tr>
<td><b>Caste</b></td>
<td><?= $profile['caste']; ?></td>
</tr>

<tr>
<td><b>Education</b></td>
<td><?= $profile['education']; ?></td>
</tr>

<tr>
<td><b>Occupation</b></td>
<td><?= $profile['occupation']; ?></td>
</tr>

<tr>
<td><b>Salary</b></td>
<td><?= $profile['salary']; ?></td>
</tr>

<tr>
<td><b>Height</b></td>
<td><?= $profile['height']; ?> cm</td>
</tr>

<tr>
<td><b>Weight</b></td>
<td><?= $profile['weight']; ?> kg</td>
</tr>

<tr>
<td><b>City</b></td>
<td><?= $profile['city']; ?></td>
</tr>

<tr>
<td><b>State</b></td>
<td><?= $profile['state']; ?></td>
</tr>

<tr>
<td><b>About Me</b></td>
<td><?= nl2br($profile['about_me']); ?></td>
</tr>

</table>

</div>

<!-- FAMILY -->

<div class="tab-pane fade"
id="family">

<div class="alert alert-info">

Family Details feature will be added here.

</div>

</div>

<!-- PARTNER -->

<div class="tab-pane fade"
id="partner">

<table class="table">

<tr>
<td>Preferred Age</td>

<td>

<?= $profile['pref_age_min']; ?>

-

<?= $profile['pref_age_max']; ?>

Years

</td>

</tr>

<tr>

<td>Preferred Height</td>

<td>

<?= $profile['pref_height_min']; ?>

-

<?= $profile['pref_height_max']; ?>

</td>

</tr>

<tr>

<td>Religion</td>

<td><?= $profile['pref_religion']; ?></td>

</tr>

<tr>

<td>Caste</td>

<td><?= $profile['pref_caste']; ?></td>

</tr>

<tr>

<td>Education</td>

<td><?= $profile['pref_education']; ?></td>

</tr>

<tr>

<td>Country</td>

<td><?= $profile['pref_country']; ?></td>

</tr>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>