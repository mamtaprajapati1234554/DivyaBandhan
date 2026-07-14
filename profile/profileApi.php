<?php

session_start();

require_once("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get form data
$religion = trim($_POST['religion'] ?? '');
$caste = trim($_POST['caste'] ?? '');
$education = trim($_POST['education'] ?? '');
$occupation = trim($_POST['occupation'] ?? '');
$salary = trim($_POST['salary'] ?? '');
$height = trim($_POST['height'] ?? '');
$weight = trim($_POST['weight'] ?? '');
$city = trim($_POST['city'] ?? '');
$state = trim($_POST['state'] ?? '');
$about_me = trim($_POST['about_me'] ?? '');

$posted_profile_id = isset($_POST['profile_id']) && trim($_POST['profile_id']) !== ''
    ? (int) $_POST['profile_id']
    : null;

$gender = trim($_POST['gender'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$country = trim($_POST['country'] ?? '');

$pref_age_min = trim($_POST['pref_age_min'] ?? '');
$pref_age_max = trim($_POST['pref_age_max'] ?? '');

$pref_religion = trim($_POST['pref_religion'] ?? '');
$pref_marital_status = trim($_POST['pref_marital_status'] ?? '');

$pref_country = trim($_POST['pref_country'] ?? '');
$pref_mother_tongue = trim($_POST['pref_mother_tongue'] ?? '');

$pref_education = trim($_POST['pref_education'] ?? '');
$pref_caste = trim($_POST['pref_caste'] ?? '');

// Family details
$father_occupation = trim($_POST['father_occupation'] ?? '');
$mother_occupation = trim($_POST['mother_occupation'] ?? '');
$brothers = ($_POST['brothers'] ?? '') !== '' ? (int) $_POST['brothers'] : null;
$married_brothers = ($_POST['married_brothers'] ?? '') !== '' ? (int) $_POST['married_brothers'] : null;
$sisters = ($_POST['sisters'] ?? '') !== '' ? (int) $_POST['sisters'] : null;
$married_sisters = ($_POST['married_sisters'] ?? '') !== '' ? (int) $_POST['married_sisters'] : null;
$family_type = trim($_POST['family_type'] ?? '');
$native_place = trim($_POST['native_place'] ?? '');
$family_description = trim($_POST['family_description'] ?? '');

if ($family_type === '') {
    $family_type = null;
}

if (
    empty($religion) ||
    empty($caste) ||
    empty($education) ||
    empty($occupation) ||
    empty($gender) ||
    empty($dob) ||
    empty($country)
) {
    $_SESSION['error'] = "Please fill all required fields.";
    header("Location: create_profile.php");
    exit;
}

// Photo upload
$profile_photo = "";
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
    $folder = "../uploads/profiles/";
    if (!is_dir($folder)) mkdir($folder, 0777, true);
    $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
    $fileName = time() . "_" . rand(1000,9999) . "." . $ext;
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $folder . $fileName)) {
        $profile_photo = "uploads/profiles/" . $fileName;
    }
}

// Determine existing profile
$useProfileId = false;
if ($posted_profile_id) {
    $check = $pdo->prepare("SELECT * FROM profiles WHERE id=?");
    $check->execute([$posted_profile_id]);
    $profile = $check->fetch(PDO::FETCH_ASSOC);
    if ($profile && ((int)$profile['user_id'] !== (int)$user_id)) {
        $_SESSION['error'] = "Unauthorized to edit this profile.";
        header("Location: create_profile.php");
        exit;
    }
    $useProfileId = true;
} else {
    $check = $pdo->prepare("SELECT * FROM profiles WHERE user_id=?");
    $check->execute([$user_id]);
    $profile = $check->fetch(PDO::FETCH_ASSOC);
}

try {
    if (!$profile) {
        $sql = "INSERT INTO profiles (
            user_id, gender, dob, religion, caste, education, occupation, salary,
            height, weight, city, state, country, about_me, profile_photo,
            pref_age_min, pref_age_max, pref_marital_status, pref_religion, pref_caste,
            pref_mother_tongue, pref_country, pref_education,
            father_occupation, mother_occupation, brothers, married_brothers,
            sisters, married_sisters, family_type, native_place, family_description
        ) VALUES (
            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
        )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $user_id, $gender, $dob, $religion, $caste, $education, $occupation, $salary,
            $height, $weight, $city, $state, $country, $about_me, $profile_photo,
            $pref_age_min, $pref_age_max, $pref_marital_status, $pref_religion, $pref_caste,
            $pref_mother_tongue, $pref_country, $pref_education,
            $father_occupation, $mother_occupation, $brothers, $married_brothers,
            $sisters, $married_sisters, $family_type, $native_place, $family_description
        ]);
    } else {
        if (empty($profile_photo)) $profile_photo = $profile['profile_photo'];
        $sql = "UPDATE profiles SET
            gender=?, dob=?, religion=?, caste=?, education=?, occupation=?, salary=?,
            height=?, weight=?, city=?, state=?, country=?, about_me=?, profile_photo=?,
            pref_age_min=?, pref_age_max=?, pref_marital_status=?, pref_religion=?, pref_caste=?,
            pref_mother_tongue=?, pref_country=?, pref_education=?,
            father_occupation=?, mother_occupation=?, brothers=?, married_brothers=?,
            sisters=?, married_sisters=?, family_type=?, native_place=?, family_description=?";

        if ($useProfileId) {
            $sql .= " WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $params = [
                $gender, $dob, $religion, $caste, $education, $occupation, $salary,
                $height, $weight, $city, $state, $country, $about_me, $profile_photo,
                $pref_age_min, $pref_age_max, $pref_marital_status, $pref_religion, $pref_caste,
                $pref_mother_tongue, $pref_country, $pref_education,
                $father_occupation, $mother_occupation, $brothers, $married_brothers,
                $sisters, $married_sisters, $family_type, $native_place, $family_description,
                $posted_profile_id
            ];
            $stmt->execute($params);
        } else {
            $sql .= " WHERE user_id=?";
            $stmt = $pdo->prepare($sql);
            $params = [
                $gender, $dob, $religion, $caste, $education, $occupation, $salary,
                $height, $weight, $city, $state, $country, $about_me, $profile_photo,
                $pref_age_min, $pref_age_max, $pref_marital_status, $pref_religion, $pref_caste,
                $pref_mother_tongue, $pref_country, $pref_education,
                $father_occupation, $mother_occupation, $brothers, $married_brothers,
                $sisters, $married_sisters, $family_type, $native_place, $family_description,
                $user_id
            ];
            $stmt->execute($params);
        }
    }

    $_SESSION['success'] = "Profile saved successfully.";
    header("Location: ../dashboard/index.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: create_profile.php");
    exit;
}
