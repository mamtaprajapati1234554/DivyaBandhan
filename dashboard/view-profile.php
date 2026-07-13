<?php
session_start();
require_once("../config/database.php");

// Check User ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Profile");
}

$user_id = (int)$_GET['id'];

// Fetch User + Profile
$sql = "SELECT
            u.id,
            u.first_name,
            u.last_name,
            u.gender,
            u.email,
            u.phone,
            u.dob,

            p.user_id,
            p.religion,
            p.caste,
            p.education,
            p.occupation,
            p.salary,
            p.height,
            p.weight,
            p.city,
            p.state,
            p.country,
            p.marital_status,
            p.mother_tongue,
            p.about_me,
            p.profile_photo,

            p.pref_age_min,
            p.pref_age_max,
            p.pref_marital_status,
            p.pref_religion,
            p.pref_caste,
            p.pref_mother_tongue,
            p.pref_country,
            p.pref_education,
            p.pref_salary_min,
            p.pref_manglik

        FROM users u
        INNER JOIN profiles p
            ON u.id = p.user_id
        WHERE u.id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    die("Profile Not Found");
}

/* Age */

$age = "";

if (!empty($profile['dob'])) {

    $dob = new DateTime($profile['dob']);

    $today = new DateTime();

    $age = $today->diff($dob)->y;
}

/* Profile Photo */

$photo = "../assets/images/default-profile.png";

if (!empty($profile['profile_photo'])) {

    $path = "../" . ltrim($profile['profile_photo'], "/");

    if (file_exists($path)) {

        $photo = $path;
    }
}
?>



<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

<?= htmlspecialchars($profile['first_name']." ".$profile['last_name']) ?>

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="../assets/css/view-profile.css">

</head>

<body>

<div class="container py-5">

<div class="profile-card">

<div class="row">



<!-- ===========================
LEFT PROFILE
=========================== -->

<div class="col-lg-4 mb-4">

    <div class="left-box">

        <img src="<?= htmlspecialchars($photo); ?>"
            alt="Profile Photo"
            class="profile-photo img-fluid">

        <h2 class="profile-name">

            <?= htmlspecialchars($profile['first_name'] . " " . $profile['last_name']); ?>

        </h2>

        <div class="profile-id">

            Profile ID :
            <strong>DVB<?= str_pad($profile['id'], 4, "0", STR_PAD_LEFT); ?></strong>

        </div>

        <span class="verified">

            ✔ Verified Profile

        </span>

        <hr>

        <div class="basic-info">

            <div class="mb-2">

                <strong>Gender</strong>

                <br>

                <?= htmlspecialchars($profile['gender']); ?>

            </div>

            <div class="mb-2">

                <strong>Age</strong>

                <br>

                <?= $age; ?> Years

            </div>

            <div class="mb-2">

                <strong>Religion</strong>

                <br>

                <?= htmlspecialchars($profile['religion']); ?>

            </div>

            <div class="mb-2">

                <strong>Caste</strong>

                <br>

                <?= htmlspecialchars($profile['caste']); ?>

            </div>

            <div class="mb-2">

                <strong>Marital Status</strong>

                <br>

                <?= htmlspecialchars($profile['marital_status']); ?>

            </div>

            <div class="mb-2">

                <strong>Location</strong>

                <br>

                <?= htmlspecialchars($profile['city']); ?>,
                <?= htmlspecialchars($profile['state']); ?>,
                <?= htmlspecialchars($profile['country']); ?>

            </div>

        </div>

        <div class="d-grid gap-2 mt-4">

            <button class="btn btn-interest">

                ❤️ Send Interest

            </button>

            <button class="btn btn-message">

                💬 Message

            </button>

        </div>

    </div>

</div>

<!-- ===========================
RIGHT SIDE START
=========================== -->

<div class="col-lg-8">

<div class="right-box">

<ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">

<li class="nav-item">

<button
class="nav-link active"
data-bs-toggle="tab"
data-bs-target="#about">

About Me

</button>

</li>

<li class="nav-item">

<button
class="nav-link"
data-bs-toggle="tab"
data-bs-target="#family">

Family Details

</button>

</li>

<li class="nav-item">

<button
class="nav-link"
data-bs-toggle="tab"
data-bs-target="#partner">

Partner Preference

</button>

</li>

</ul>

<div class="tab-content">

<!-- ABOUT TAB -->

<div class="tab-pane fade show active"
id="about">




<h3 class="section-title mb-4">
    About Me
</h3>

<table class="table table-bordered info-table">

<tr>
    <td><strong>Full Name</strong></td>
    <td>
        <?= htmlspecialchars($profile['first_name']." ".$profile['last_name']); ?>
    </td>
</tr>

<tr>
    <td><strong>Gender</strong></td>
    <td>
        <?= htmlspecialchars($profile['gender']); ?>
    </td>
</tr>

<tr>
    <td><strong>Age</strong></td>
    <td>
        <?= $age; ?> Years
    </td>
</tr>

<tr>
    <td><strong>Email</strong></td>
    <td>
        <?= htmlspecialchars($profile['email']); ?>
    </td>
</tr>

<tr>
    <td><strong>Phone</strong></td>
    <td>
        <?= htmlspecialchars($profile['phone']); ?>
    </td>
</tr>

<tr>
    <td><strong>Religion</strong></td>
    <td>
        <?= htmlspecialchars($profile['religion']); ?>
    </td>
</tr>

<tr>
    <td><strong>Caste</strong></td>
    <td>
        <?= htmlspecialchars($profile['caste']); ?>
    </td>
</tr>

<tr>
    <td><strong>Marital Status</strong></td>
    <td>
        <?= htmlspecialchars($profile['marital_status']); ?>
    </td>
</tr>

<tr>
    <td><strong>Mother Tongue</strong></td>
    <td>
        <?= htmlspecialchars($profile['mother_tongue']); ?>
    </td>
</tr>

<tr>
    <td><strong>Education</strong></td>
    <td>
        <?= htmlspecialchars($profile['education']); ?>
    </td>
</tr>

<tr>
    <td><strong>Occupation</strong></td>
    <td>
        <?= htmlspecialchars($profile['occupation']); ?>
    </td>
</tr>

<tr>
    <td><strong>Salary</strong></td>
    <td>
        <?= htmlspecialchars($profile['salary']); ?>
    </td>
</tr>

<tr>
    <td><strong>Height</strong></td>
    <td>
        <?= htmlspecialchars($profile['height']); ?> cm
    </td>
</tr>

<tr>
    <td><strong>Weight</strong></td>
    <td>
        <?= htmlspecialchars($profile['weight']); ?> kg
    </td>
</tr>

<tr>
    <td><strong>Country</strong></td>
    <td>
        <?= htmlspecialchars($profile['country']); ?>
    </td>
</tr>

<tr>
    <td><strong>State</strong></td>
    <td>
        <?= htmlspecialchars($profile['state']); ?>
    </td>
</tr>

<tr>
    <td><strong>City</strong></td>
    <td>
        <?= htmlspecialchars($profile['city']); ?>
    </td>
</tr>

<tr>
    <td><strong>About Me</strong></td>
    <td>
        <?= nl2br(htmlspecialchars($profile['about_me'])); ?>
    </td>
</tr>

</table>

</div>
<!-- END ABOUT TAB -->



<!-- =========================
FAMILY DETAILS TAB
========================= -->

<div class="tab-pane fade" id="family">

    <h3 class="section-title mb-4">
        Family Details
    </h3>

    <table class="table table-bordered info-table">

        <tr>
            <td><strong>Family Type</strong></td>
            <td>Not Available</td>
        </tr>

        <tr>
            <td><strong>Family Status</strong></td>
            <td>Not Available</td>
        </tr>

        <tr>
            <td><strong>Family Values</strong></td>
            <td>Not Available</td>
        </tr>

        <tr>
            <td><strong>Father's Occupation</strong></td>
            <td>Not Available</td>
        </tr>

        <tr>
            <td><strong>Mother's Occupation</strong></td>
            <td>Not Available</td>
        </tr>

        <tr>
            <td><strong>Brothers</strong></td>
            <td>Not Available</td>
        </tr>

        <tr>
            <td><strong>Sisters</strong></td>
            <td>Not Available</td>
        </tr>

    </table>

</div>

<!-- =========================
PARTNER PREFERENCE TAB
========================= -->

<div class="tab-pane fade" id="partner">

    <h3 class="section-title mb-4">
        Partner Preference
    </h3>

    <table class="table table-bordered info-table">

        <tr>
            <td><strong>Preferred Age</strong></td>
            <td>
                <?= htmlspecialchars($profile['pref_age_min']); ?>
                -
                <?= htmlspecialchars($profile['pref_age_max']); ?>
                Years
            </td>
        </tr>

        <tr>
            <td><strong>Preferred Marital Status</strong></td>
            <td><?= htmlspecialchars($profile['pref_marital_status']); ?></td>
        </tr>

        <tr>
            <td><strong>Religion</strong></td>
            <td><?= htmlspecialchars($profile['pref_religion']); ?></td>
        </tr>

        <tr>
            <td><strong>Caste</strong></td>
            <td><?= htmlspecialchars($profile['pref_caste']); ?></td>
        </tr>

        <tr>
            <td><strong>Mother Tongue</strong></td>
            <td><?= htmlspecialchars($profile['pref_mother_tongue']); ?></td>
        </tr>

        <tr>
            <td><strong>Education</strong></td>
            <td><?= htmlspecialchars($profile['pref_education']); ?></td>
        </tr>

        <tr>
            <td><strong>Preferred Country</strong></td>
            <td><?= htmlspecialchars($profile['pref_country']); ?></td>
        </tr>

        <tr>
            <td><strong>Minimum Salary</strong></td>
            <td><?= htmlspecialchars($profile['pref_salary_min']); ?></td>
        </tr>

        <tr>
            <td><strong>Manglik</strong></td>
            <td><?= htmlspecialchars($profile['pref_manglik']); ?></td>
        </tr>

    </table>

</div>

</div>
<!-- End tab-content -->

</div>
<!-- End right-box -->

</div>
<!-- End col-lg-8 -->

</div>
<!-- End row -->

</div>
<!-- End profile-card -->

</div>
<!-- End container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


