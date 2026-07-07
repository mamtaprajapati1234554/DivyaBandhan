<?php
session_start();
require_once("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch Profile */

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id=?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch();

/* Save Profile */

if(isset($_POST['save_profile'])){

    $religion   = $_POST['religion'];
    $caste      = $_POST['caste'];
    $education  = $_POST['education'];
    $occupation = $_POST['occupation'];
    $salary     = $_POST['salary'];
    $height     = $_POST['height'];
    $weight     = $_POST['weight'];
    $city       = $_POST['city'];
    $state      = $_POST['state'];
    $about      = $_POST['about_me'];

    /* Photo Upload */

    $photo = $profile['profile_photo'] ?? "";

    if(!empty($_FILES['profile_photo']['name'])){

        $filename = time()."_".$_FILES['profile_photo']['name'];

        move_uploaded_file(
            $_FILES['profile_photo']['tmp_name'],
            "../uploads/".$filename
        );

        $photo = $filename;
    }

    if($profile){

        $sql="UPDATE profiles SET

        religion=?,
        caste=?,
        education=?,
        occupation=?,
        salary=?,
        height=?,
        weight=?,
        city=?,
        state=?,
        about_me=?,
        profile_photo=?

        WHERE user_id=?";

        $stmt=$pdo->prepare($sql);

        $stmt->execute([

            $religion,
            $caste,
            $education,
            $occupation,
            $salary,
            $height,
            $weight,
            $city,
            $state,
            $about,
            $photo,
            $user_id

        ]);

    }else{

        $sql="INSERT INTO profiles(

            user_id,
            religion,
            caste,
            education,
            occupation,
            salary,
            height,
            weight,
            city,
            state,
            about_me,
            profile_photo

        )

        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt=$pdo->prepare($sql);

        $stmt->execute([

            $user_id,
            $religion,
            $caste,
            $education,
            $occupation,
            $salary,
            $height,
            $weight,
            $city,
            $state,
            $about,
            $photo

        ]);

    }

    header("Location: profile.php?success=1");
    exit();

}

/* Reload Updated Profile */

$stmt=$pdo->prepare("SELECT * FROM profiles WHERE user_id=?");
$stmt->execute([$user_id]);
$profile=$stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6fb;
}

.card{
    border:none;
    border-radius:15px;
}

.profile-img{
    width:180px;
    height:180px;
    object-fit:cover;
    border-radius:50%;
    border:5px solid #fff;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
}

</style>

</head>

<body>

<div class="container mt-5 mb-5">

<div class="card shadow">

<div class="card-header bg-danger text-white">

<h3>Complete Your Profile</h3>

</div>

<div class="card-body">

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success">

Profile Updated Successfully.

</div>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

<div class="text-center mb-4">

<?php

$image="https://via.placeholder.com/180";

if(!empty($profile['profile_photo'])){

$image="../uploads/".$profile['profile_photo'];

}

?>

<img src="<?= $image ?>" class="profile-img">

<br><br>

<input
type="file"
name="profile_photo"
class="form-control">

</div>


<div class="row">

<div class="col-md-6 mb-3">

<label>Religion</label>

<select name="religion" class="form-select">

<option>Hindu</option>
<option>Muslim</option>
<option>Christian</option>
<option>Sikh</option>
<option>Jain</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Caste</label>

<input
type="text"
name="caste"
class="form-control"
value="<?= $profile['caste'] ?? '' ?>">

</div>

<div class="col-md-6 mb-3">

<label>Education</label>

<select name="education" class="form-select">

<option>B.Tech</option>
<option>M.Tech</option>
<option>Graduate</option>
<option>Post Graduate</option>
<option>MBA</option>
<option>MBBS</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Occupation</label>

<input
type="text"
name="occupation"
class="form-control"
value="<?= $profile['occupation'] ?? '' ?>">

</div>

<div class="col-md-6 mb-3">

<label>Annual Income</label>

<select name="salary" class="form-select">

<option>2-5 LPA</option>
<option>5-8 LPA</option>
<option>8-12 LPA</option>
<option>12-20 LPA</option>
<option>20+ LPA</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Height (cm)</label>

<input
type="number"
name="height"
class="form-control"
value="<?= $profile['height'] ?? '' ?>">

</div>

<div class="col-md-6 mb-3">

<label>Weight</label>

<input
type="number"
name="weight"
class="form-control"
value="<?= $profile['weight'] ?? '' ?>">

</div>

<div class="col-md-6 mb-3">

<label>City</label>

<input
type="text"
name="city"
class="form-control"
value="<?= $profile['city'] ?? '' ?>">

</div>

<div class="col-md-6 mb-3">

<label>State</label>

<input
type="text"
name="state"
class="form-control"
value="<?= $profile['state'] ?? '' ?>">

</div>

<div class="col-12 mb-3">

<label>About Me</label>

<textarea
name="about_me"
rows="5"
class="form-control"><?= $profile['about_me'] ?? '' ?></textarea>

</div>

<div class="text-center">

<button
type="submit"
name="save_profile"
class="btn btn-danger btn-lg">

Save Profile

</button>

</div>

</div>

</form>

</div>

</div>

</div>

</body>

</html>