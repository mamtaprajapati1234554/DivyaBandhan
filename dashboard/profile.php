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

if (isset($_POST['save_profile'])) {

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

    if (!empty($_FILES['profile_photo']['name'])) {

        $filename = time() . "_" . $_FILES['profile_photo']['name'];

        move_uploaded_file(
            $_FILES['profile_photo']['tmp_name'],
            "../uploads/" . $filename
        );

        $photo = $filename;
    }

    if ($profile) {

        $sql = "UPDATE profiles SET

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

        $stmt = $pdo->prepare($sql);

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
    } else {

        $sql = "INSERT INTO profiles(

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

        $stmt = $pdo->prepare($sql);

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

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id=?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch();

// Helper - agar value khaali/NULL ho to "Not added yet" dikhao
function pv($value)
{
    return (!empty($value)) ? htmlspecialchars($value) : "Not added yet";
}

// ==========================
// Profile Completion % (photo ke around ring dikhane ke liye)
// ==========================

function section_percent($p, $fields)
{
    $filled = 0;
    foreach ($fields as $f) {
        if (!empty($p[$f])) $filled++;
    }
    return count($fields) > 0 ? ($filled / count($fields)) * 100 : 0;
}

$personalFields = ['gender', 'dob', 'country', 'religion', 'caste', 'education', 'occupation', 'city', 'state', 'about_me', 'height', 'weight', 'profile_photo'];
$familyFields   = ['father_occupation', 'mother_occupation', 'family_type', 'native_place', 'family_description'];
$partnerFields  = ['pref_age_min', 'pref_age_max', 'pref_religion', 'pref_caste', 'pref_education', 'pref_country', 'pref_mother_tongue', 'pref_marital_status'];

$personalPct = $profile ? section_percent($profile, $personalFields) : 0;
$familyPct   = $profile ? section_percent($profile, $familyFields) : 0;
$partnerPct  = $profile ? section_percent($profile, $partnerFields) : 0;

$profileCompletion = round(($personalPct + $familyPct + $partnerPct) / 3);

if ($profileCompletion >= 80) {
    $completionColor = "#28a745"; // green
} elseif ($profileCompletion >= 40) {
    $completionColor = "#ffc107"; // yellow
} else {
    $completionColor = "#dc3545"; // red
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .profile-img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
        }

        .profile-photo-wrap {
            position: relative;
            width: 190px;
            height: 190px;
            margin: 0 auto;
        }

        .profile-photo-wrap svg {
            position: absolute;
            top: 0;
            left: 0;
            transform: rotate(-90deg);
        }

        .profile-photo-wrap .ring-track {
            fill: none;
            stroke: #e9ecef;
            stroke-width: 6;
        }

        .profile-photo-wrap .ring-progress {
            fill: none;
            stroke-width: 6;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.5s ease;
        }

        .profile-photo-wrap .profile-img {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 180px !important;
            height: 180px !important;
            object-fit: cover !important;
            border-radius: 50% !important;
        }

        .completion-label {
            display: inline-block;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #333;
            background: #e9ecef;
            padding: 4px 14px;
            border-radius: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row .label {
            font-weight: 600;
            color: #555;
        }

        /* =========================================
           BOX STYLING & GLOW HIGHLIGHT EFFECT 
           ========================================= */
        
        /* Default state of inputs/dropdowns */
        .form-control, 
        .form-select {
            border: 2px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 11px 15px !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02) !important;
        }

        /* Red glow when clicked/focused */
        .form-control:focus, 
        .form-select:focus {
            color: #212529 !important;
            background-color: #fff !important;
            border-color: #dc3545 !important; /* Strict Red Border */
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.18) !important; /* Strict Red Glow */
        }

        /* 3 buttons inline positioning */
        .button-row-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .btn-match-save {
            font-weight: 600 !important;
            padding: 10px 24px !important;
            border-radius: 6px !important;
            transition: background-color 0.2s ease, border-color 0.2s ease;
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

                <?php if (isset($_GET['success'])) { ?>

                    <div class="alert alert-success">

                        Profile Updated Successfully.

                    </div>

                <?php } ?>

                <form method="POST" enctype="multipart/form-data">

                    <div class="text-center mb-4">

                        <?php

                        $image = "https://via.placeholder.com/180";

                        if (!empty($profile['profile_photo'])) {

                            $image = "../uploads/" . $profile['profile_photo'];
                        }

                        $radius = 90;
                        $circumference = 2 * M_PI * $radius;
                        $offset = $circumference - ($profileCompletion / 100) * $circumference;

                        ?>
                        

                        <div class="profile-photo-wrap">

                            <svg width="190" height="190" viewBox="0 0 190 190">
                                <circle class="ring-track" cx="95" cy="95" r="<?= $radius ?>"></circle>
                                <circle class="ring-progress" cx="95" cy="95" r="<?= $radius ?>"
                                    stroke="<?= $completionColor ?>"
                                    stroke-dasharray="<?= $circumference ?>"
                                    stroke-dashoffset="<?= $offset ?>"></circle>
                            </svg>

                            <img src="<?= $image ?>" class="profile-img">

                        </div>

                        <div>
                            <span class="completion-label">Profile <?= $profileCompletion ?>% Complete</span>
                        </div>

                        <br>
                        <div class="col-12">
                            <hr class="my-4">
                            <div class="button-row-container mb-3">
                                <button class="btn btn-danger btn-lg btn-match-save" type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
                                    Personal Info
                                </button>

                                <button class="btn btn-danger btn-lg btn-match-save" type="button" data-bs-toggle="collapse" data-bs-target="#familyDetailsView">
                                    Family Details
                                </button>

                                <button class="btn btn-danger btn-lg btn-match-save" type="button" data-bs-toggle="collapse" data-bs-target="#partnerPreferenceView">
                                    Partner Preference
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <input
                                type="file"
                                name="profile_photo"
                                class="form-control">
                        </div>

                    </div>
                    


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Religion</label>

                            <select name="religion" class="form-select">

                                <option <?= (isset($profile['religion']) && $profile['religion'] == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
                                <option <?= (isset($profile['religion']) && $profile['religion'] == 'Muslim') ? 'selected' : '' ?>>Muslim</option>
                                <option <?= (isset($profile['religion']) && $profile['religion'] == 'Christian') ? 'selected' : '' ?>>Christian</option>
                                <option <?= (isset($profile['religion']) && $profile['religion'] == 'Sikh') ? 'selected' : '' ?>>Sikh</option>
                                <option <?= (isset($profile['religion']) && $profile['religion'] == 'Jain') ? 'selected' : '' ?>>Jain</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Caste</label>

                            <input
                                type="text"
                                name="caste"
                                class="form-control"
                                value="<?= $profile['caste'] ?? '' ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Education</label>

                            <select name="education" class="form-select">

                                <option <?= (isset($profile['education']) && $profile['education'] == 'B.Tech') ? 'selected' : '' ?>>B.Tech</option>
                                <option <?= (isset($profile['education']) && $profile['education'] == 'M.Tech') ? 'selected' : '' ?>>M.Tech</option>
                                <option <?= (isset($profile['education']) && $profile['education'] == 'Graduate') ? 'selected' : '' ?>>Graduate</option>
                                <option <?= (isset($profile['education']) && $profile['education'] == 'Post Graduate') ? 'selected' : '' ?>>Post Graduate</option>
                                <option <?= (isset($profile['education']) && $profile['education'] == 'MBA') ? 'selected' : '' ?>>MBA</option>
                                <option <?= (isset($profile['education']) && $profile['education'] == 'MBBS') ? 'selected' : '' ?>>MBBS</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Occupation</label>

                            <input
                                type="text"
                                name="occupation"
                                class="form-control"
                                value="<?= $profile['occupation'] ?? '' ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Annual Income</label>

                            <select name="salary" class="form-select">

                                <option <?= (isset($profile['salary']) && $profile['salary'] == '2-5 LPA') ? 'selected' : '' ?>>2-5 LPA</option>
                                <option <?= (isset($profile['salary']) && $profile['salary'] == '5-8 LPA') ? 'selected' : '' ?>>5-8 LPA</option>
                                <option <?= (isset($profile['salary']) && $profile['salary'] == '8-12 LPA') ? 'selected' : '' ?>>8-12 LPA</option>
                                <option <?= (isset($profile['salary']) && $profile['salary'] == '12-20 LPA') ? 'selected' : '' ?>>12-20 LPA</option>
                                <option <?= (isset($profile['salary']) && $profile['salary'] == '20+ LPA') ? 'selected' : '' ?>>20+ LPA</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Height (cm)</label>

                            <input
                                type="number"
                                name="height"
                                class="form-control"
                                value="<?= $profile['height'] ?? '' ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">Weight</label>

                            <input
                                type="number"
                                name="weight"
                                class="form-control"
                                value="<?= $profile['weight'] ?? '' ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">City</label>

                            <input
                                type="text"
                                name="city"
                                class="form-control"
                                value="<?= $profile['city'] ?? '' ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">State</label>

                            <input
                                type="text"
                                name="state"
                                class="form-control"
                                value="<?= $profile['state'] ?? '' ?>">

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label mb-2 fw-semibold text-secondary">About Me</label>

                            <textarea
                                name="about_me"
                                rows="5"
                                class="form-control"><?= $profile['about_me'] ?? '' ?></textarea>

                        </div>

                        <!-- Save Profile Button Area -->
                        <div class="text-center mb-4">
                            <button
                                type="submit"
                                name="save_profile"
                                class="btn btn-danger btn-lg px-5">
                                Save Profile
                            </button>
                        </div>

                        <!-- Teeno Buttons Save Profile Ke Just Niche, Form Ke Hi Andar -->
                        

                    </div>

                </form>

                <!-- Collapse panels for View only details -->
                <div class="collapse" id="familyDetailsView">

                    <div class="card card-body mb-3 border mt-3">

                        <h5 class="mb-3 text-danger fw-bold">Family Details</h5>

                        <div class="info-row">
                            <span class="label">Father's Occupation</span>
                            <span><?= pv($profile['father_occupation'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Mother's Occupation</span>
                            <span><?= pv($profile['mother_occupation'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Brothers</span>
                            <span><?= pv($profile['brothers'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Married Brothers</span>
                            <span><?= pv($profile['married_brothers'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Sisters</span>
                            <span><?= pv($profile['sisters'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Married Sisters</span>
                            <span><?= pv($profile['married_sisters'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Family Type</span>
                            <span><?= pv($profile['family_type'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Native Place</span>
                            <span><?= pv($profile['native_place'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Family Description</span>
                            <span><?= pv($profile['family_description'] ?? '') ?></span>
                        </div>

                    </div>

                </div>

                <div class="collapse" id="partnerPreferenceView">

                    <div class="card card-body mb-3 border mt-3">

                        <h5 class="mb-3 text-danger fw-bold">Partner Preference</h5>

                        <div class="info-row">
                            <span class="label">Preferred Age</span>
                            <span>
                                <?php
                                $ageMin = $profile['pref_age_min'] ?? '';
                                $ageMax = $profile['pref_age_max'] ?? '';
                                echo (!empty($ageMin) && !empty($ageMax))
                                    ? htmlspecialchars($ageMin) . " - " . htmlspecialchars($ageMax) . " yrs"
                                    : "Not added yet";
                                ?>
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="label">Religion</span>
                            <span><?= pv($profile['pref_religion'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Marital Status</span>
                            <span><?= pv($profile['pref_marital_status'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Country</span>
                            <span><?= pv($profile['pref_country'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Mother Tongue</span>
                            <span><?= pv($profile['pref_mother_tongue'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Education</span>
                            <span><?= pv($profile['pref_education'] ?? '') ?></span>
                        </div>

                        <div class="info-row">
                            <span class="label">Caste</span>
                            <span><?= pv($profile['pref_caste'] ?? '') ?></span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>