<?php
session_start();
require_once("../config/database.php");

// Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// User Details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Existing Profile
$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id=?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/create_profile.css">

</head>

<body>

    <div class="container profile-container">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

       <form action="profileApi.php" method="POST" enctype="multipart/form-data" id="profileForm" novalidate>

            <input type="hidden" name="user_id" value="<?= $user_id ?>">

            <!-- PERSONAL DETAILS -->

            <div class="card">

                <h3>Personal Details</h3>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($user['first_name']) ?>"
                            readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($user['last_name']) ?>"
                            readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email"
                            class="form-control"
                            value="<?= htmlspecialchars($user['email']) ?>"
                            readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($user['phone']) ?>"
                            >
                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Gender <span class="text-danger">*</span></label>

                        <select class="form-select" name="gender" required>

                            <option value="">Select</option>

                            <option <?= ($profile['gender'] ?? '') == "Male" ? "selected" : "" ?>>Male</option>

                            <option <?= ($profile['gender'] ?? '') == "Female" ? "selected" : "" ?>>Female</option>

                            <option <?= ($profile['gender'] ?? '') == "Other" ? "selected" : "" ?>>Other</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Date of Birth <span class="text-danger">*</span></label>

                        <input type="date"
                            class="form-control"
                            name="dob"
                            required
                            value="<?= $profile['dob'] ?? '' ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Country <span class="text-danger">*</span></label>

                        <select class="form-select" name="country" required>

                            <option value="">Select Country</option>

                            <option <?= ($profile['country'] ?? '') == "India" ? "selected" : "" ?>>India</option>
                            <option <?= ($profile['country'] ?? '') == "USA" ? "selected" : "" ?>>USA</option>
                            <option <?= ($profile['country'] ?? '') == "UK" ? "selected" : "" ?>>UK</option>
                            <option <?= ($profile['country'] ?? '') == "Canada" ? "selected" : "" ?>>Canada</option>
                            <option <?= ($profile['country'] ?? '') == "Australia" ? "selected" : "" ?>>Australia</option>
                            <option <?= ($profile['country'] ?? '') == "UAE" ? "selected" : "" ?>>UAE</option>
                            <option <?= ($profile['country'] ?? '') == "Other" ? "selected" : "" ?>>Other</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Religion <span class="text-danger">*</span></label>

                        <select class="form-select" name="religion" required>

                            <option value="">Select</option>

                            <option <?= ($profile['religion'] ?? '') == "Hindu" ? "selected" : "" ?>>Hindu</option>

                            <option <?= ($profile['religion'] ?? '') == "Muslim" ? "selected" : "" ?>>Muslim</option>

                            <option <?= ($profile['religion'] ?? '') == "Sikh" ? "selected" : "" ?>>Sikh</option>

                            <option <?= ($profile['religion'] ?? '') == "Christian" ? "selected" : "" ?>>Christian</option>

                            <option <?= ($profile['religion'] ?? '') == "Jain" ? "selected" : "" ?>>Jain</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Caste <span class="text-danger">*</span></label>

                        <select class="form-select" name="caste" required>

                            <option value="">Select Caste</option>

                            <option <?= ($profile['caste'] ?? '') == "Brahmin" ? "selected" : "" ?>>Brahmin</option>
                            <option <?= ($profile['caste'] ?? '') == "Rajput" ? "selected" : "" ?>>Rajput</option>
                            <option <?= ($profile['caste'] ?? '') == "Maratha" ? "selected" : "" ?>>Maratha</option>
                            <option <?= ($profile['caste'] ?? '') == "Patel" ? "selected" : "" ?>>Patel</option>
                            <option <?= ($profile['caste'] ?? '') == "Yadav" ? "selected" : "" ?>>Yadav</option>
                            <option <?= ($profile['caste'] ?? '') == "Jat" ? "selected" : "" ?>>Jat</option>
                            <option <?= ($profile['caste'] ?? '') == "Gurjar" ? "selected" : "" ?>>Gurjar</option>
                            <option <?= ($profile['caste'] ?? '') == "Agarwal" ? "selected" : "" ?>>Agarwal</option>
                            <option <?= ($profile['caste'] ?? '') == "Baniya" ? "selected" : "" ?>>Baniya</option>
                            <option <?= ($profile['caste'] ?? '') == "Kayastha" ? "selected" : "" ?>>Kayastha</option>
                            <option <?= ($profile['caste'] ?? '') == "Reddy" ? "selected" : "" ?>>Reddy</option>
                            <option <?= ($profile['caste'] ?? '') == "Nair" ? "selected" : "" ?>>Nair</option>
                            <option <?= ($profile['caste'] ?? '') == "Lingayat" ? "selected" : "" ?>>Lingayat</option>
                            <option <?= ($profile['caste'] ?? '') == "Jain" ? "selected" : "" ?>>Jain</option>

                            <option <?= ($profile['caste'] ?? '') == "Other" ? "selected" : "" ?>>Other</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Education <span class="text-danger">*</span></label>

                        <select class="form-select" name="education" required>

                            <option value="">Select</option>

                            <option <?= ($profile['education'] ?? '') == "B.Tech" ? "selected" : "" ?>>B.Tech</option>

                            <option <?= ($profile['education'] ?? '') == "M.Tech" ? "selected" : "" ?>>M.Tech</option>

                            <option <?= ($profile['education'] ?? '') == "MBA" ? "selected" : "" ?>>MBA</option>

                            <option <?= ($profile['education'] ?? '') == "B.Com" ? "selected" : "" ?>>B.Com</option>

                            <option <?= ($profile['education'] ?? '') == "M.Com" ? "selected" : "" ?>>M.Com</option>

                            <option <?= ($profile['education'] ?? '') == "BCA" ? "selected" : "" ?>>BCA</option>

                            <option <?= ($profile['education'] ?? '') == "MCA" ? "selected" : "" ?>>MCA</option>

                            <option <?= ($profile['education'] ?? '') == "Other" ? "selected" : "" ?>>Other</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Occupation <span class="text-danger">*</span></label>

                        <input

                            class="form-control"

                            name="occupation"

                            required

                            value="<?= $profile['occupation'] ?? '' ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Salary</label>

                        <select class="form-select" name="salary">

                            <option value="">Select</option>

                            <option <?= ($profile['salary'] ?? '') == "2 LPA" ? "selected" : "" ?>>2 LPA</option>

                            <option <?= ($profile['salary'] ?? '') == "3 LPA" ? "selected" : "" ?>>3 LPA</option>

                            <option <?= ($profile['salary'] ?? '') == "5 LPA" ? "selected" : "" ?>>5 LPA</option>

                            <option <?= ($profile['salary'] ?? '') == "7 LPA" ? "selected" : "" ?>>7 LPA</option>

                            <option <?= ($profile['salary'] ?? '') == "10 LPA" ? "selected" : "" ?>>10 LPA</option>

                            <option <?= ($profile['salary'] ?? '') == "15 LPA" ? "selected" : "" ?>>15 LPA</option>

                            <option <?= ($profile['salary'] ?? '') == "20 LPA+" ? "selected" : "" ?>>20 LPA+</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Height</label>

                        <select class="form-select" name="height">

                            <?php

                            for ($i = 140; $i <= 200; $i++) {
                                $sel = (($profile['height'] ?? '') == $i) ? "selected" : "";
                                echo "<option value='$i' $sel>$i cm</option>";
                            }

                            ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Weight</label>

                        <input

                            type="number"

                            class="form-control"

                            name="weight"

                            value="<?= $profile['weight'] ?? '' ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>City</label>

                        <input

                            class="form-control"

                            name="city"

                            value="<?= $profile['city'] ?? '' ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>State</label>

                        <input

                            class="form-control"

                            name="state"

                            value="<?= $profile['state'] ?? '' ?>">

                    </div>

                    <div class="col-md-12">

                        <label>About Me</label>

                        <textarea

                            class="form-control"

                            rows="5"

                            name="about_me"><?= $profile['about_me'] ?? '' ?></textarea>

                    </div>

                    <div class="col-md-12 mt-3">

                        <label>Profile Photo</label>

                        <input

                            type="file"

                            class="form-control"

                            name="profile_photo">

                    </div>

                </div>

            </div>

            <!-- PARTNER PREFERENCE -->

            <div class="card mt-4">

                <h3>Partner Preference</h3>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Preferred Age From</label>

                        <select class="form-select" name="pref_age_min">

                            <?php

                            for ($i = 18; $i <= 60; $i++) {
                                $sel = (($profile['pref_age_min'] ?? '') == $i) ? "selected" : "";
                                echo "<option $sel>$i</option>";
                            }

                            ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Preferred Age To</label>

                        <select class="form-select" name="pref_age_max">

                            <?php

                            for ($i = 18; $i <= 60; $i++) {
                                $sel = (($profile['pref_age_max'] ?? '') == $i) ? "selected" : "";
                                echo "<option $sel>$i</option>";
                            }

                            ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Religion</label>

                        <select class="form-select" name="pref_religion">

                            <option <?= ($profile['pref_religion'] ?? '') == "Doesn't Matter" ? "selected" : "" ?>>Doesn't Matter</option>

                            <option <?= ($profile['pref_religion'] ?? '') == "Hindu" ? "selected" : "" ?>>Hindu</option>

                            <option <?= ($profile['pref_religion'] ?? '') == "Muslim" ? "selected" : "" ?>>Muslim</option>

                            <option <?= ($profile['pref_religion'] ?? '') == "Sikh" ? "selected" : "" ?>>Sikh</option>

                            <option <?= ($profile['pref_religion'] ?? '') == "Christian" ? "selected" : "" ?>>Christian</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Marital Status</label>

                        <select class="form-select"

                            name="pref_marital_status">

                            <option <?= ($profile['pref_marital_status'] ?? '') == "Never Married" ? "selected" : "" ?>>Never Married</option>

                            <option <?= ($profile['pref_marital_status'] ?? '') == "Divorced" ? "selected" : "" ?>>Divorced</option>

                            <option <?= ($profile['pref_marital_status'] ?? '') == "Widow" ? "selected" : "" ?>>Widow</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Country</label>

                        <input

                            class="form-control"

                            name="pref_country"

                            value="<?= $profile['pref_country'] ?? '' ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Mother Tongue</label>

                        <input

                            class="form-control"

                            name="pref_mother_tongue"

                            value="<?= $profile['pref_mother_tongue'] ?? '' ?>">

                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Preferred Education</label>

                        <select class="form-select" name="pref_education">

                            <option value="">Select Education</option>

                            <option <?= ($profile['pref_education'] ?? '') == "Any" ? "selected" : "" ?>>Any</option>

                            <option <?= ($profile['pref_education'] ?? '') == "10th Pass" ? "selected" : "" ?>>10th Pass</option>
                            <option <?= ($profile['pref_education'] ?? '') == "12th Pass" ? "selected" : "" ?>>12th Pass</option>

                            <option <?= ($profile['pref_education'] ?? '') == "Diploma" ? "selected" : "" ?>>Diploma</option>

                            <option <?= ($profile['pref_education'] ?? '') == "B.A" ? "selected" : "" ?>>B.A</option>
                            <option <?= ($profile['pref_education'] ?? '') == "B.Com" ? "selected" : "" ?>>B.Com</option>
                            <option <?= ($profile['pref_education'] ?? '') == "B.Sc" ? "selected" : "" ?>>B.Sc</option>
                            <option <?= ($profile['pref_education'] ?? '') == "BCA" ? "selected" : "" ?>>BCA</option>
                            <option <?= ($profile['pref_education'] ?? '') == "B.Tech" ? "selected" : "" ?>>B.Tech</option>
                            <option <?= ($profile['pref_education'] ?? '') == "BE" ? "selected" : "" ?>>BE</option>

                            <option <?= ($profile['pref_education'] ?? '') == "M.A" ? "selected" : "" ?>>M.A</option>
                            <option <?= ($profile['pref_education'] ?? '') == "M.Com" ? "selected" : "" ?>>M.Com</option>
                            <option <?= ($profile['pref_education'] ?? '') == "M.Sc" ? "selected" : "" ?>>M.Sc</option>
                            <option <?= ($profile['pref_education'] ?? '') == "MCA" ? "selected" : "" ?>>MCA</option>
                            <option <?= ($profile['pref_education'] ?? '') == "M.Tech" ? "selected" : "" ?>>M.Tech</option>
                            <option <?= ($profile['pref_education'] ?? '') == "MBA" ? "selected" : "" ?>>MBA</option>

                            <option <?= ($profile['pref_education'] ?? '') == "Doctor (MBBS/MD)" ? "selected" : "" ?>>Doctor (MBBS/MD)</option>
                            <option <?= ($profile['pref_education'] ?? '') == "CA" ? "selected" : "" ?>>CA</option>
                            <option <?= ($profile['pref_education'] ?? '') == "Law" ? "selected" : "" ?>>Law</option>

                            <option <?= ($profile['pref_education'] ?? '') == "Government Job" ? "selected" : "" ?>>Government Job</option>

                            <option <?= ($profile['pref_education'] ?? '') == "Any Graduate" ? "selected" : "" ?>>Any Graduate</option>
                            <option <?= ($profile['pref_education'] ?? '') == "Any Post Graduate" ? "selected" : "" ?>>Any Post Graduate</option>

                            <option <?= ($profile['pref_education'] ?? '') == "Other" ? "selected" : "" ?>>Other</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Preferred Caste</label>

                       <select class="form-select" name="pref_caste">

                            <option value="">Select Caste</option>

                            <option <?= ($profile['pref_caste'] ?? '') == "Brahmin" ? "selected" : "" ?>>Brahmin</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Rajput" ? "selected" : "" ?>>Rajput</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Maratha" ? "selected" : "" ?>>Maratha</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Patel" ? "selected" : "" ?>>Patel</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Yadav" ? "selected" : "" ?>>Yadav</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Jat" ? "selected" : "" ?>>Jat</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Gurjar" ? "selected" : "" ?>>Gurjar</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Agarwal" ? "selected" : "" ?>>Agarwal</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Baniya" ? "selected" : "" ?>>Baniya</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Kayastha" ? "selected" : "" ?>>Kayastha</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Reddy" ? "selected" : "" ?>>Reddy</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Nair" ? "selected" : "" ?>>Nair</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Lingayat" ? "selected" : "" ?>>Lingayat</option>
                            <option <?= ($profile['pref_caste'] ?? '') == "Jain" ? "selected" : "" ?>>Jain</option>

                            <option <?= ($profile['pref_caste'] ?? '') == "Other" ? "selected" : "" ?>>Other</option>

                        </select>

                    </div>

                    <div class="col-md-12 text-center">

                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>

                            Save Profile

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

    <script>
        (function () {
            const form = document.getElementById('profileForm');
            const submitBtn = document.getElementById('submitBtn');

            // Fields that must be filled before submit is allowed
            const requiredFields = form.querySelectorAll('[required]');

            function checkFormValidity() {
                let allValid = true;

                requiredFields.forEach(function (field) {
                    if (!field.value || field.value.trim() === '') {
                        allValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                submitBtn.disabled = !allValid;
            }

            // Check on page load (in case values are pre-filled from DB)
            checkFormValidity();

            // Re-check every time a required field changes
            requiredFields.forEach(function (field) {
                field.addEventListener('input', checkFormValidity);
                field.addEventListener('change', checkFormValidity);
            });

            // Extra safety: prevent submit if somehow still invalid
            form.addEventListener('submit', function (e) {
                checkFormValidity();
                if (submitBtn.disabled) {
                    e.preventDefault();
                }
            });
        })();
    </script>

</body>

</html>